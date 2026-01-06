<?php

namespace App\Exports;

use App\Models\LegalCase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CasesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'NUC / Folio',
            'Alias de Caso',
            'Tipo de Delito',
            'Etapa Procesal',
            'Estado',
            'Tribunal',
            'Fecha de Inicio',
            'Fecha de Cierre',
        ];
    }

    public function map($case): array
    {
        return [
            $case->id,
            $case->internal_folio ?? $case->nuc ?? 'S/N',
            $case->case_alias,
            $case->crime_type,
            $case->stage,
            $case->status,
            $case->court_name,
            $case->created_at->format('d/m/Y'),
            $case->close_date ? $case->close_date->format('d/m/Y') : '-',
        ];
    }
}
