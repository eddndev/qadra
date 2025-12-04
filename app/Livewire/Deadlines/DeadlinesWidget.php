<?php

namespace App\Livewire\Deadlines;

use App\Models\Deadline;
use Livewire\Component;

class DeadlinesWidget extends Component
{
    public function render()
    {
        // Get upcoming deadlines (next 7 days) + any past due pending
        $deadlines = Deadline::with('case')
            ->where('status', 'pendiente')
            ->where(function($query) {
                $query->whereBetween('expires_at', [now(), now()->addDays(7)])
                      ->orWhere('expires_at', '<', now()); // Include overdue
            })
            ->orderBy('expires_at', 'asc')
            ->limit(5)
            ->get();

        return view('livewire.deadlines.deadlines-widget', [
            'deadlines' => $deadlines
        ]);
    }
}
