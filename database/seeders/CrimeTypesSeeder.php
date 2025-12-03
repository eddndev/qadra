<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrimeTypesSeeder extends Seeder
{
    public function run(): void
    {
        $crimes = [
            // Art. 19 Constitucional (Prisión Preventiva Oficiosa)
            ['name' => 'Homicidio Doloso', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => false],
            ['name' => 'Feminicidio', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => false],
            ['name' => 'Violación', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => false],
            ['name' => 'Secuestro', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => true],
            ['name' => 'Trata de Personas', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => true],
            ['name' => 'Delincuencia Organizada', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => true],
            ['name' => 'Abuso o Violencia Sexual contra Menores', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => false],
            ['name' => 'Robo de Casa Habitación', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => false],
            ['name' => 'Uso de Programas Sociales con Fines Electorales', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => true],
            ['name' => 'Enriquecimiento Ilícito', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => false],
            ['name' => 'Ejercicio Abusivo de Funciones', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => false],
            ['name' => 'Robo al Transporte de Carga', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => true],
            ['name' => 'Delitos en Materia de Hidrocarburos (Huachicoleo)', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => true],
            ['name' => 'Desaparición Forzada de Personas', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => true],
            ['name' => 'Delitos con Armas de Fuego y Explosivos', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const.', 'is_federal' => true],
            ['name' => 'Extorsión', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const. (Reforma 2024)', 'is_federal' => false],
            ['name' => 'Contrabando', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const. (Reforma 2024)', 'is_federal' => true],
            ['name' => 'Defraudación Fiscal (Factureros)', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const. (Reforma 2024)', 'is_federal' => true],
            ['name' => 'Producción/Distribución de Fentanilo/Drogas Sintéticas', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Art. 19 Const. (Reforma 2024)', 'is_federal' => true],

            // Delitos Comunes Fuero Común
            ['name' => 'Robo Simple', 'classification' => 'doloso', 'severity' => 'no_grave', 'legal_basis' => 'Código Penal Estatal', 'is_federal' => false],
            ['name' => 'Robo con Violencia', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Código Penal Estatal', 'is_federal' => false],
            ['name' => 'Lesiones', 'classification' => 'doloso', 'severity' => 'no_grave', 'legal_basis' => 'Código Penal Estatal', 'is_federal' => false],
            ['name' => 'Daño en Propiedad Ajena', 'classification' => 'doloso', 'severity' => 'no_grave', 'legal_basis' => 'Código Penal Estatal', 'is_federal' => false],
            ['name' => 'Amenazas', 'classification' => 'doloso', 'severity' => 'no_grave', 'legal_basis' => 'Código Penal Estatal', 'is_federal' => false],
            ['name' => 'Fraude Genérico', 'classification' => 'doloso', 'severity' => 'no_grave', 'legal_basis' => 'Código Penal Estatal', 'is_federal' => false],
            ['name' => 'Abuso de Confianza', 'classification' => 'doloso', 'severity' => 'no_grave', 'legal_basis' => 'Código Penal Estatal', 'is_federal' => false],
            ['name' => 'Violencia Familiar', 'classification' => 'doloso', 'severity' => 'grave', 'legal_basis' => 'Código Penal Estatal', 'is_federal' => false],
            ['name' => 'Incumplimiento de Obligaciones de Asistencia Familiar', 'classification' => 'doloso', 'severity' => 'no_grave', 'legal_basis' => 'Código Penal Estatal', 'is_federal' => false],
            
            // Culposos
            ['name' => 'Homicidio Culposo (Tránsito)', 'classification' => 'culposo', 'severity' => 'no_grave', 'legal_basis' => 'Código Penal Estatal', 'is_federal' => false],
            ['name' => 'Lesiones Culposas', 'classification' => 'culposo', 'severity' => 'no_grave', 'legal_basis' => 'Código Penal Estatal', 'is_federal' => false],
        ];

        foreach ($crimes as $crime) {
            DB::table('crime_types')->updateOrInsert(
                ['name' => $crime['name']],
                $crime
            );
        }
    }
}