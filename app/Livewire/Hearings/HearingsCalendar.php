<?php

namespace App\Livewire\Hearings;

use App\Models\Hearing;
use Livewire\Component;

class HearingsCalendar extends Component
{
    public function render()
    {
        return view('livewire.hearings.hearings-calendar')
            ->layout('layouts.app', ['header' => 'Calendario de Audiencias']);
    }

    public function getEvents()
    {
        // Fetch hearings for current tenant
        // TenantScoped trait handles filtering automatically via global scope?
        // Yes, but only if triggered from web request with auth.
        // Since this will be called via Livewire/AJAX, auth is present.
        
        $hearings = Hearing::with(['case', 'judge'])
            ->get()
            ->map(function ($hearing) {
                $color = match($hearing->status) {
                    'programada' => '#4F46E5', // Indigo
                    'celebrada' => '#10B981', // Green
                    'cancelada' => '#EF4444', // Red
                    'reprogramada' => '#F59E0B', // Yellow
                    default => '#6B7280', // Gray
                };

                return [
                    'id' => $hearing->id,
                    'title' => $hearing->type . ' - ' . ($hearing->case->case_alias ?? 'Exp: ' . $hearing->case->internal_folio),
                    'start' => $hearing->scheduled_at->toIso8601String(),
                    'end' => $hearing->scheduled_at->addMinutes($hearing->duration_minutes ?? 60)->toIso8601String(),
                    'color' => $color,
                    'url' => route('cases.show', $hearing->case_id), // Redirect to case on click
                    'extendedProps' => [
                        'status' => ucfirst($hearing->status),
                        'courtroom' => $hearing->courtroom,
                        'judge' => $hearing->judge->name ?? 'N/A',
                    ]
                ];
            });

        return $hearings;
    }
}
