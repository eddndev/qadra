<?php

namespace App\Enums;

enum CaseParticipantRole: string
{
    // Partes Principales
    case IMPUTADO = 'imputado';
    case VICTIMA = 'victima';
    case OFENDIDO = 'ofendido';

    // Autoridades
    case JUEZ_CONTROL = 'juez_control';
    case JUEZ_ENJUICIAMIENTO = 'juez_enjuiciamiento';
    case JUEZ_EJECUCION = 'juez_ejecucion';
    case MINISTERIO_PUBLICO = 'ministerio_publico'; // Fiscal
    case ASESOR_JURIDICO = 'asesor_juridico'; // De la víctima

    // Defensa
    case DEFENSOR_PARTICULAR = 'defensor_particular';
    case DEFENSOR_PUBLICO = 'defensor_publico';

    // Otros
    case TESTIGO = 'testigo';
    case PERITO = 'perito';
    case TERCERO_INTERESADO = 'tercero_interesado';
    case POLICIA_PROCESAL = 'policia_procesal';

    public function label(): string
    {
        return match($this) {
            self::IMPUTADO => 'Imputado',
            self::VICTIMA => 'Víctima',
            self::OFENDIDO => 'Ofendido',
            self::JUEZ_CONTROL => 'Juez de Control',
            self::JUEZ_ENJUICIAMIENTO => 'Juez de Enjuiciamiento',
            self::JUEZ_EJECUCION => 'Juez de Ejecución',
            self::MINISTERIO_PUBLICO => 'Ministerio Público (Fiscal)',
            self::ASESOR_JURIDICO => 'Asesor Jurídico',
            self::DEFENSOR_PARTICULAR => 'Defensor Particular',
            self::DEFENSOR_PUBLICO => 'Defensor Público',
            self::TESTIGO => 'Testigo',
            self::PERITO => 'Perito',
            self::TERCERO_INTERESADO => 'Tercero Interesado',
            self::POLICIA_PROCESAL => 'Policía Procesal',
        };
    }

    public static function options(): array
    {
        return array_reduce(self::cases(), function ($options, $case) {
            $options[$case->value] = $case->label();
            return $options;
        }, []);
    }
}
