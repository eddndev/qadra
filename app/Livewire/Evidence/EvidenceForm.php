<?php

namespace App\Livewire\Evidence;

use App\Models\ChainOfCustodyEntry;
use App\Models\Evidence;
use App\Models\LegalCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EvidenceForm extends Component
{
    public $case_id;
    public $description;
    public $type;
    public $current_location;
    public $collected_at;
    public $collected_by;
    public $notes;
    
    // For UI
    public $cases;

    protected $rules = [
        'case_id' => 'required|exists:legal_cases,id',
        'description' => 'required|string|max:500',
        'type' => 'required|string|max:100',
        'current_location' => 'required|string|max:255',
        'collected_at' => 'required|date',
        'collected_by' => 'nullable|string|max:255',
        'notes' => 'nullable|string|max:65535',
    ];

    public function mount($caseId = null)
    {
        $this->case_id = $caseId;
        // Default collection time to now
        $this->collected_at = now()->format('Y-m-d\TH:i');
        
        // Load active cases for the dropdown
        $this->cases = LegalCase::where('status', 'activo')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'internal_folio', 'case_alias']);
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // 1. Generate Folio
            // Format: EV-{YEAR}-{CASE_SUFFIX}-{SEQ}
            // Simple version: EV-{YEAR}-{RANDOM} or based on count. 
            // Let's use a sequential logic per tenant/year if possible, or ULID based.
            // Docs suggest: EV-{YEAR}-{CASE_ID}-{SEQUENCE}
            
            $year = now()->format('Y');
            
            // Get case internal folio for cleaner ID if possible, otherwise partial ID
            $case = LegalCase::find($this->case_id);
            $caseRef = $case->internal_folio ?? substr($case->id, 0, 8);
            
            // Count existing evidence for this case to determine sequence
            $count = Evidence::where('case_id', $this->case_id)->count() + 1;
            $sequence = str_pad($count, 3, '0', STR_PAD_LEFT);
            
            $folio = "EV-{$year}-{$caseRef}-{$sequence}";

            // 2. Create Evidence
            $evidence = Evidence::create([
                'case_id' => $this->case_id,
                'chain_of_custody_folio' => $folio,
                'description' => $this->description,
                'type' => $this->type,
                'current_location' => $this->current_location,
                'status' => 'en_custodia', // Default status
                'collected_at' => $this->collected_at,
                'collected_by' => $this->collected_by,
                'notes' => $this->notes,
            ]);

            // 3. Create First Chain of Custody Entry (Reception)
            ChainOfCustodyEntry::create([
                'tenant_id' => $evidence->tenant_id, // Explicitly set if needed, or let trait handle it
                'evidence_id' => $evidence->id,
                'movement_at' => now(),
                'given_by' => $this->collected_by ?? 'Autoridad Recolectora',
                'received_by' => Auth::user()->name,
                'reason' => 'Recepción inicial de evidencia',
                'location' => $this->current_location,
                'condition' => 'Recibido para custodia',
                'registered_by' => Auth::id(),
            ]);

            session()->flash('message', "Evidencia registrada exitosamente con folio: {$folio}");
            
            // Reset form or redirect
            $this->reset(['description', 'type', 'current_location', 'notes']);
            $this->collected_at = now()->format('Y-m-d\TH:i');
            
            // If we want to redirect to the case or evidence list:
            // return redirect()->route('cases.show', $this->case_id);
        });
    }

    public function render()
    {
        return view('livewire.evidence.evidence-form')->layout('layouts.app');
    }
}