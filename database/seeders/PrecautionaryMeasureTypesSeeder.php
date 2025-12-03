<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrecautionaryMeasureTypesSeeder extends Seeder
{
    public function run(): void
    {
        $measures = [
            [
                'fraction' => 'I',
                'name' => 'Presentación periódica',
                'description' => 'La presentación periódica ante el juez o ante autoridad distinta que aquél designe.',
            ],
            [
                'fraction' => 'II',
                'name' => 'Exhibición de garantía económica',
                'description' => 'La exhibición de una garantía económica.',
            ],
            [
                'fraction' => 'III',
                'name' => 'Embargo de bienes',
                'description' => 'El embargo de bienes.',
            ],
            [
                'fraction' => 'IV',
                'name' => 'Inmovilización de cuentas',
                'description' => 'La inmovilización de cuentas y demás valores que se encuentren dentro del sistema financiero.',
            ],
            [
                'fraction' => 'V',
                'name' => 'Prohibición de salir del país/localidad',
                'description' => 'La prohibición de salir sin autorización del país, de la localidad en la cual reside o del ámbito territorial que fije el juez.',
            ],
            [
                'fraction' => 'VI',
                'name' => 'Sometimiento a cuidado o vigilancia',
                'description' => 'El sometimiento al cuidado o vigilancia de una persona o institución determinada o internamiento a institución determinada.',
            ],
            [
                'fraction' => 'VII',
                'name' => 'Prohibición de concurrir a reuniones/lugares',
                'description' => 'La prohibición de concurrir a determinadas reuniones o acercarse a ciertos lugares.',
            ],
            [
                'fraction' => 'VIII',
                'name' => 'Prohibición de convivencia/acercamiento',
                'description' => 'La prohibición de convivir, acercarse o comunicarse con determinadas personas, con las víctimas u ofendidos o testigos, siempre que no se afecte el derecho de defensa.',
            ],
            [
                'fraction' => 'IX',
                'name' => 'Separación inmediata del domicilio',
                'description' => 'La separación inmediata del domicilio.',
            ],
            [
                'fraction' => 'X',
                'name' => 'Suspensión temporal del cargo (SP)',
                'description' => 'La suspensión temporal en el ejercicio del cargo cuando se le atribuye un delito cometido por servidores públicos.',
            ],
            [
                'fraction' => 'XI',
                'name' => 'Suspensión temporal de actividad',
                'description' => 'La suspensión temporal en el ejercicio de una determinada actividad profesional o laboral.',
            ],
            [
                'fraction' => 'XII',
                'name' => 'Localizador electrónico',
                'description' => 'La colocación de localizadores electrónicos.',
            ],
            [
                'fraction' => 'XIII',
                'name' => 'Resguardo domiciliario',
                'description' => 'El resguardo en su propio domicilio con las modalidades que el juez disponga.',
            ],
            [
                'fraction' => 'XIV',
                'name' => 'Prisión Preventiva',
                'description' => 'La prisión preventiva (Oficiosa o Justificada).',
            ],
        ];

        foreach ($measures as $measure) {
            DB::table('precautionary_measure_types')->updateOrInsert(
                ['fraction' => $measure['fraction']],
                array_merge($measure, ['legal_basis' => 'Art. 155 CNPP'])
            );
        }
    }
}