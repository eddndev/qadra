<?php

namespace App\Livewire\Evidence;

use App\Models\ChainOfCustodyEntry;
use App\Models\Evidence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CustodyMovementForm extends Component
{
    public Evidence $evidence;

    // Form Fields
    public $movement_at;
    public $given_by;
    public $given_by_badge;
    public $received_by;
    public $received_by_badge;
    public $reason;
    public $location;
    public $condition;

    // Derived Status Logic
    public $new_status;

    protected $rules = [
        'movement_at' => 'required|date',
        'given_by' => 'required|string|max:255',
        'given_by_badge' => 'nullable|string|max:100',
        'received_by' => 'required|string|max:255',
        'received_by_badge' => 'nullable|string|max:100',
        'reason' => 'required|string|max:255',
        'location' => 'required|string|max:255', // New location
        'condition' => 'required|string|max:255',
    ];

    public function mount(Evidence $evidence)
    {
        $this->evidence = $evidence;
        $this->movement_at = now()->format('Y-m-d\TH:i');
        
        // Default 'Given By' is usually the current custodian if known, or blank
        // Default 'Received By' could be the auth user
        $this->received_by = Auth::user()->name;
        $this->condition = 'Sin cambios aparentes';
        
        // Pre-fill given_by from last entry if exists
        $lastEntry = $evidence->chainOfCustodyEntries()->first();
        if ($lastEntry) {
            $this->given_by = $lastEntry->received_by;
        }
    }

    public function updatedReason($value)
    {
        // Auto-suggest status based on reason
        $this->new_status = match($value) {
            'Traslado a Fiscalía' => 'en_fiscalia',
            'Entrega a Juzgado' => 'en_juzgado',
            'Devolución a Propietario' => 'devuelto',
            'Destrucción Autorizada' => 'destruido',
            'Recepción en Despacho' => 'en_custodia',
            default => $this->evidence->status,
        };
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // 1. Create Chain of Custody Entry
            ChainOfCustodyEntry::create([
                'tenant_id' => $this->evidence->tenant_id,
                'evidence_id' => $this->evidence->id,
                'movement_at' => $this->movement_at,
                'given_by' => $this->given_by,
                'given_by_badge' => $this->given_by_badge,
                'received_by' => $this->received_by,
                'received_by_badge' => $this->received_by_badge,
                'reason' => $this->reason,
                'location' => $this->location,
                'condition' => $this->condition,
                'registered_by' => Auth::id(),
            ]);

            // 2. Update Evidence Status & Location
            // Determine status if not auto-set
            $status = $this->new_status ?? $this->evidence->status;
            
            // If reason implies external transfer, update status
            if (str_contains(strtolower($this->reason), 'fiscalía')) $status = 'en_fiscalia';
            if (str_contains(strtolower($this->reason), 'juzgado')) $status = 'en_juzgado';
            if (str_contains(strtolower($this->reason), 'despacho')) $status = 'en_custodia';

            $this->evidence->update([
                'current_location' => $this->location,
                'status' => $status,
            ]);

            session()->flash('message', 'Movimiento registrado exitosamente. La cadena de custodia ha sido actualizada.');
            
            // Reset form partials, but keep some context or redirect
            return redirect()->route('evidence.create'); // Temporary, ideally back to ShowEvidence
        });
    }

    public function render()
    {
        return view('livewire.evidence.custody-movement-form')
            ->layout('layouts.app', ['header' => 'Registro de Cadena de Custodia']);
    }
}