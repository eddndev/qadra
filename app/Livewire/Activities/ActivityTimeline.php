<?php

namespace App\Livewire\Activities;

use App\Models\Activity;
use App\Models\LegalCase;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ActivityTimeline extends Component
{
    use WithFileUploads, WithPagination;

    public LegalCase $case;
    
    // Form Fields
    public $type;
    public $title;
    public $description;
    public $performed_at;
    public $duration_minutes;
    public $attachments = [];

    // Filters
    public $filterUser = '';
    public $filterType = '';

    protected $rules = [
        'type' => 'required|string',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'performed_at' => 'required|date',
        'duration_minutes' => 'nullable|integer|min:1',
        'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
    ];

    public function mount(LegalCase $case)
    {
        $this->case = $case;
        $this->performed_at = now()->format('Y-m-d\TH:i');
    }

    public function save()
    {
        $this->validate();

        $activity = Activity::create([
            'tenant_id' => $this->case->tenant_id,
            'case_id' => $this->case->id,
            'performed_by' => Auth::id(),
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'performed_at' => $this->performed_at,
            'duration_minutes' => $this->duration_minutes,
        ]);

        // Handle Attachments
        foreach ($this->attachments as $file) {
            $activity->addMedia($file)
                ->toMediaCollection('attachments', 's3');
        }

        // Reset Form
        $this->reset(['type', 'title', 'description', 'duration_minutes', 'attachments']);
        $this->performed_at = now()->format('Y-m-d\TH:i');
        
        session()->flash('message', 'Actuación registrada exitosamente.');
    }
    
    public function delete($id)
    {
        $activity = Activity::findOrFail($id);
        // Only owner or creator can delete
        if ($activity->performed_by !== Auth::id()) {
             // Add role check here if Owner needs to delete others' logs
             // For MVP, restrict to creator
             return;
        }
        $activity->delete();
    }

    public function render()
    {
        $activities = Activity::where('case_id', $this->case->id)
            ->with(['user', 'media'])
            ->when($this->filterUser, function($q) {
                $q->where('performed_by', $this->filterUser);
            })
            ->when($this->filterType, function($q) {
                $q->where('type', $this->filterType);
            })
            ->orderByDesc('performed_at')
            ->paginate(10);
            
        $users = $this->case->tenant->users; // Get all tenant users for filter

        return view('livewire.activities.activity-timeline', [
            'activities' => $activities,
            'users' => $users
        ]);
    }
}