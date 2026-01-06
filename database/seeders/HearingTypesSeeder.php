<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HearingTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Audiencia Inicial', 'slug' => 'inicial', 'description' => 'Control de detención, formulación de imputación, vinculación a proceso y medidas cautelares.'],
            ['name' => 'Formulación de Imputación', 'slug' => 'imputacion', 'description' => 'Fase de la audiencia inicial donde se informa al imputado el hecho delictivo.'],
            ['name' => 'Vinculación a Proceso', 'slug' => 'vinculacion', 'description' => 'Fase de la audiencia inicial donde se determina si hay elementos para procesar.'],
            ['name' => 'Audiencia Intermedia', 'slug' => 'intermedia', 'description' => 'Ofrecimiento y admisión de medios de prueba, y depuración de hechos controvertidos.'],
            ['name' => 'Juicio Oral', 'slug' => 'juicio', 'description' => 'Desahogo de pruebas y dictado de sentencia.'],
            ['name' => 'Revisión de Medidas Cautelares', 'slug' => 'revision-medidas', 'description' => 'Audiencia para modificar, cancelar o ratificar medidas cautelares.'],
            ['name' => 'Audiencia de Prueba Anticipada', 'slug' => 'prueba-anticipada', 'description' => 'Desahogo de prueba antes del juicio por riesgo de pérdida.'],
            ['name' => 'Lectura de Sentencia', 'slug' => 'lectura-sentencia', 'description' => 'Explicación íntegra de la sentencia dictada por el tribunal.'],
            ['name' => 'Audiencia de Individualización de Sanciones', 'slug' => 'individualizacion', 'description' => 'Determinación de la pena y reparación del daño.'],
            ['name' => 'Audiencia de Suspensión Condicional', 'slug' => 'suspension-condicional', 'description' => 'Salida alterna al proceso penal.'],
            ['name' => 'Audiencia de Procedimiento Abreviado', 'slug' => 'abreviado', 'description' => 'Terminación anticipada del proceso ante la aceptación de culpa.'],
            ['name' => 'Otra', 'slug' => 'otra', 'description' => 'Cualquier otro tipo de audiencia no especificada.'],
        ];

        foreach ($types as $type) {
            \App\Models\HearingType::updateOrCreate(['slug' => $type['slug']], $type);
        }
    }
}
