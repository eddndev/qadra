<?php

namespace App\Notifications;

use App\Models\Deadline;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeadlineApproachingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Deadline $deadline;
    public int $daysLeft;

    /**
     * Create a new notification instance.
     */
    public function __construct(Deadline $deadline, int $daysLeft)
    {
        $this->deadline = $deadline;
        $this->daysLeft = $daysLeft;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $urgency = $this->deadline->is_fatal ? 'TÉRMINO FATAL' : 'Recordatorio';
        $color = $this->deadline->is_fatal ? 'error' : 'primary';
        
        $message = (new MailMessage)
            ->subject("[$urgency] Vence en {$this->daysLeft} días: {$this->deadline->title}")
            ->greeting('Hola ' . $notifiable->name)
            ->line("El siguiente plazo procesal está próximo a vencer:")
            ->line("**Título:** {$this->deadline->title}")
            ->line("**Vencimiento:** " . $this->deadline->expires_at->format('d/m/Y H:i'))
            ->line("**Caso:** " . ($this->deadline->case->internal_folio ?? 'S/N') . " - " . $this->deadline->case->case_alias);

        if ($this->daysLeft === 0) {
            $message->line("**URGENTE:** El plazo vence HOY.");
        } else {
            $message->line("Restan {$this->daysLeft} días para su vencimiento.");
        }

        return $message
            ->action('Ver Caso', route('cases.show', $this->deadline->case_id))
            ->line('Por favor toma las acciones necesarias para cumplir en tiempo y forma.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'deadline_id' => $this->deadline->id,
            'case_id' => $this->deadline->case_id,
            'title' => $this->deadline->title,
            'expires_at' => $this->deadline->expires_at->toIso8601String(),
            'days_left' => $this->daysLeft,
            'is_fatal' => $this->deadline->is_fatal,
        ];
    }
}