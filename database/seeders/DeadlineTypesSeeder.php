<?php

namespace Database\Seeders;

use App\Models\DeadlineType;
use Illuminate\Database\Seeder;

class DeadlineTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            // Actos Urgentes / Iniciales
            [
                'name' => 'Término Constitucional (Situación Jurídica)',
                'default_days' => 3, // 72 horas
                'business_days' => false, // Naturales (todos los días y horas son hábiles)
                'legal_basis' => 'Art. 19 Constitucional',
            ],
            [
                'name' => 'Duplicidad del Término Constitucional',
                'default_days' => 6, // 144 horas
                'business_days' => false,
                'legal_basis' => 'Art. 19 Constitucional / Art. 313 CNPP',
            ],
            
            // Investigación Complementaria
            [
                'name' => 'Cierre de Investigación (Delitos < 2 años prisión)',
                'default_days' => 60, // 2 meses aprox
                'business_days' => false, // Meses calendario
                'legal_basis' => 'Art. 321 CNPP',
            ],
            [
                'name' => 'Cierre de Investigación (Delitos > 2 años prisión)',
                'default_days' => 180, // 6 meses máx
                'business_days' => false,
                'legal_basis' => 'Art. 321 CNPP',
            ],
            
            // Etapa Intermedia
            [
                'name' => 'Acusación del MP (tras cierre investigación)',
                'default_days' => 15,
                'business_days' => false, // "Dentro de los 15 días siguientes" (Generalmente naturales salvo excepción) - CNPP Art 94 dice hábiles salvo que afecte libertad? Art 324. Mejor poner false (naturales) y que el abogado ajuste si aplica regla especial, o true si aplica regla general.
                // Corrección: Art 94 CNPP: "No se computarán los sábados, los domingos ni los días inhábiles".
                // Por tanto, los plazos en días son HÁBILES por defecto salvo libertad personal.
                // La acusación no implica libertad inmediata. Se considera HÁBIL.
                'business_days' => true,
                'legal_basis' => 'Art. 324 CNPP',
            ],
            [
                'name' => 'Audiencia Intermedia (Señalamiento)',
                'default_days' => 30, // Min 30, Max 40
                'business_days' => false, // Naturales (Art 341)
                'legal_basis' => 'Art. 341 CNPP',
            ],
            
            // Juicio Oral
            [
                'name' => 'Apertura de Juicio Oral',
                'default_days' => 20, // Min 20, Max 60
                'business_days' => false, // Naturales (Art 349)
                'legal_basis' => 'Art. 349 CNPP',
            ],

            // Recursos
            [
                'name' => 'Recurso de Revocación',
                'default_days' => 2,
                'business_days' => true,
                'legal_basis' => 'Art. 466 CNPP',
            ],
            [
                'name' => 'Apelación (Contra Autos)',
                'default_days' => 3,
                'business_days' => true,
                'legal_basis' => 'Art. 471 CNPP',
            ],
            [
                'name' => 'Apelación (Sentencia Definitiva)',
                'default_days' => 10,
                'business_days' => true,
                'legal_basis' => 'Art. 471 CNPP',
            ],
            
            // Amparo
            [
                'name' => 'Amparo Directo (General)',
                'default_days' => 15,
                'business_days' => true,
                'legal_basis' => 'Art. 17 Ley de Amparo',
            ],
            [
                'name' => 'Amparo Directo (Sentencia Condenatoria Prisión)',
                'default_days' => 2920, // 8 años
                'business_days' => true,
                'legal_basis' => 'Art. 17 Fracc. II Ley de Amparo',
            ],
        ];

        foreach ($types as $type) {
            DeadlineType::firstOrCreate(
                ['name' => $type['name']],
                $type
            );
        }
    }
}