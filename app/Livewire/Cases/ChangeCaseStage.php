<?php

namespace App\Livewire\Cases;

use App\Models\LegalCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChangeCaseStage extends Component
{
    public LegalCase $case;
    public $showModal = false;

    // Form Fields
    public $new_stage;
    public $new_status;
    public $reason;

    // Constants (Could be in Enums later)
    public $stages = [
        'inv_inicial' => 'Investigación Inicial',
        'inv_complementaria' => 'Investigación Complementaria',
        'intermedia' => 'Etapa Intermedia',
        'juicio' => 'Juicio Oral',
        'ejecucion' => 'Ejecución de Sentencia',
    ];

    public $statuses = [
        'activo' => 'Activo',
        'suspendido' => 'Suspendido',
        'cerrado' => 'Cerrado',
        'archivado' => 'Archivado',
    ];

    protected $rules = [
        'new_stage' => 'required|in:inv_inicial,inv_complementaria,intermedia,juicio,ejecucion',
        'new_status' => 'required|in:activo,suspendido,cerrado,archivado',
        'reason' => 'required|string|min:10',
    ];

    public function mount(LegalCase $case)
    {
        $this->case = $case;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->new_stage = $this->case->stage;
        $this->new_status = $this->case->status;
        $this->reason = '';
    }

    public function openModal()
    {
        $this->resetForm();
        $this->dispatch('open-modal', 'change-stage-modal');
    }

    public function save()
    {
        $this->validate();

        // Prevent dummy updates
        if ($this->new_stage === $this->case->stage && $this->new_status === $this->case->status) {
            $this->addError('new_stage', 'Debes cambiar la etapa o el estado para guardar.');
            return;
        }

        DB::transaction(function () {
            // 1. Capture old state
            $oldStage = $this->case->stage;
            $oldStatus = $this->case->status;

            // 2. Update Case
            $this->case->update([
                'stage' => $this->new_stage,
                'status' => $this->new_status,
            ]);

            // 3. Create History Record
            $this->case->stageHistory()->create([
                'tenant_id' => $this->case->tenant_id,
                'previous_stage' => $oldStage,
                'new_stage' => $this->new_stage,
                'previous_status' => $oldStatus,
                'new_status' => $this->new_status,
                'reason' => $this->reason,
                'changed_by' => Auth::id(),
            ]);
        });

        $this->dispatch('close-modal', 'change-stage-modal');
        
        // Redirect to refresh full state
        return redirect()->route('cases.show', $this->case->id)->with('status', 'Etapa actualizada correctamente.');
    }

    public function render()
    {
        return view('livewire.cases.change-case-stage');
    }
}