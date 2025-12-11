<?php

namespace App\Http\Controllers;

use App\Models\Deadline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertsController extends Controller
{
    public function index()
    {
        // Plazos Vencidos (Expired)
        $expiredDeadlines = Deadline::with('case')
            ->where('expires_at', '<', now())
            ->where('status', '!=', 'completed')
            ->orderBy('expires_at', 'desc')
            ->take(10)
            ->get();

        // Plazos Próximos (Next 72h)
        $upcomingDeadlines = Deadline::with('case')
            ->where('expires_at', '>=', now())
            ->where('expires_at', '<=', now()->addHours(72))
            ->where('status', '!=', 'completed')
            ->orderBy('expires_at', 'asc')
            ->take(10)
            ->get();

        // System Alerts (Mocked for prototype as there's no system alert model yet)
        $systemAlerts = collect([
            [
                'type' => 'error',
                'title' => 'Error al sincronizar expediente',
                'description' => 'No se pudo actualizar CG-2024-002890 con el sistema SIAJ. Reintentar en 10 minutos.',
                'time_ago' => 'Hace 30 minutos',
            ],
            [
                'type' => 'warning',
                'title' => 'Usuario sin permisos suficientes',
                'description' => 'María González intentó modificar expediente CG-2024-001234 sin autorización.',
                'time_ago' => 'Hace 2 horas',
            ],
            [
                'type' => 'info',
                'title' => 'Actualización del sistema programada',
                'description' => 'Mantenimiento preventivo el 05 Dic 2024 de 02:00 a 04:00 hrs.',
                'time_ago' => 'Hace 5 horas',
            ],
            [
                'type' => 'warning',
                'title' => 'Espacio de almacenamiento bajo',
                'description' => 'La carpeta de adjuntos está al 85% de capacidad. Considere archivar documentos antiguos.',
                'time_ago' => 'Hace 1 día',
            ],
        ]);

        return view('alerts.index', [
            'expiredDeadlines' => $expiredDeadlines,
            'upcomingDeadlines' => $upcomingDeadlines,
            'systemAlerts' => $systemAlerts,
        ]);
    }
}
