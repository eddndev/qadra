<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte de Expedientes - Qadra</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #111344;
            margin-bottom: 5px;
        }

        .stats-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .stats-table td {
            padding: 15px;
            border: 1px solid #eee;
            text-align: center;
        }

        .stats-label {
            color: #666;
            font-size: 10px;
            display: block;
            margin-bottom: 5px;
        }

        .stats-value {
            font-size: 18px;
            font-weight: bold;
            color: #111344;
        }

        .cases-table {
            width: 100%;
            border-collapse: collapse;
        }

        .cases-table th {
            background: #f8fafc;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #eee;
        }

        .cases-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Análisis de Expedientes</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table class="stats-table">
        <tr>
            <td>
                <span class="stats-label">TOTAL EXPEDIENTES</span>
                <span class="stats-value">{{ $totalCases }}</span>
            </td>
            <td>
                <span class="stats-label">CASOS CERRADOS</span>
                <span class="stats-value">{{ $closedCases }}</span>
            </td>
            <td>
                <span class="stats-label">CASOS CON ALERTA</span>
                <span class="stats-value">{{ $alertCases }}</span>
            </td>
            <td>
                <span class="stats-label">AUDIENCIAS</span>
                <span class="stats-value">{{ $hearingsRealized }}</span>
            </td>
        </tr>
    </table>

    <h3>Detalle de Expedientes</h3>
    <table class="cases-table">
        <thead>
            <tr>
                <th>Folio/NUC</th>
                <th>Delito</th>
                <th>Etapa</th>
                <th>Fecha Inicio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cases as $case)
                <tr>
                    <td>{{ $case->internal_folio ?? $case->nuc ?? 'S/N' }}</td>
                    <td>{{ $case->crime_type }}</td>
                    <td>{{ $case->stage }}</td>
                    <td>{{ $case->created_at->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($case->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Qadra - Sistema de Gestión Legal • Página 1
    </div>
</body>

</html>