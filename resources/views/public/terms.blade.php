@extends('layouts.public')

@section('content')
    <div class="container-app py-24 max-w-4xl mx-auto">
        <!-- III. TÉRMINOS Y CONDICIONES DE SERVICIO -->
        <h1 class="text-3xl font-bold text-brand-900 mb-8">III. TÉRMINOS Y CONDICIONES DE SERVICIO</h1>

        <h3 class="text-xl font-bold text-brand-800 mt-8 mb-4">1. Uso Aceptable</h3>
        <p class="mb-4 text-neutral-600">Queda estrictamente prohibido:</p>
        <ul class="list-disc pl-5 space-y-3 mb-8 text-neutral-600 marker:text-brand-500">
            <li>Almacenar contenido ilegal, difamatorio o que infrinja derechos de propiedad intelectual de terceros.</li>
            <li>Intentar vulnerar las medidas de seguridad, realizar pentesting no autorizado o ingeniería inversa del
                software.</li>
            <li>Utilizar la Plataforma para el envío de comunicaciones no solicitadas (spam) o actividades de suplantación
                de identidad.</li>
        </ul>

        <h3 class="text-xl font-bold text-brand-800 mt-8 mb-4">2. Propiedad Intelectual</h3>
        <ul class="list-disc pl-5 space-y-3 mb-8 text-neutral-600 marker:text-brand-500">
            <li><strong class="text-neutral-800">Propiedad del Software:</strong> El código fuente, diseño, algoritmos,
                logotipos y marcas de Qadra son propiedad exclusiva de sus desarrolladores. El Usuario adquiere una licencia
                de uso temporal, revocable y no transferible.</li>
            <li><strong class="text-neutral-800">Propiedad de los Datos:</strong> El Usuario conserva en todo momento la
                propiedad sobre la información, expedientes y documentos cargados. La Plataforma actúa únicamente como
                encargado del tratamiento.</li>
        </ul>

        <h3 class="text-xl font-bold text-brand-800 mt-8 mb-4">3. Limitación de Responsabilidad</h3>
        <ul class="list-disc pl-5 space-y-3 mb-8 text-neutral-600 marker:text-brand-500">
            <li><strong class="text-neutral-800">Naturaleza del Servicio:</strong> Qadra es una herramienta tecnológica de
                apoyo y no constituye asesoría legal. La responsabilidad final sobre el seguimiento de plazos y términos
                procesales recae exclusivamente en el Usuario.</li>
            <li><strong class="text-neutral-800">Disponibilidad:</strong> Si bien garantizamos altos estándares de
                disponibilidad, no nos hacemos responsables por interrupciones debidas a fallos en proveedores de internet,
                ataques externos de fuerza mayor o negligencia del Usuario en el manejo de su cuenta.</li>
        </ul>

        <h3 class="text-xl font-bold text-brand-800 mt-8 mb-4">4. Modificaciones y Jurisdicción</h3>
        <ul class="list-disc pl-5 space-y-3 mb-8 text-neutral-600 marker:text-brand-500">
            <li><strong class="text-neutral-800">Modificaciones:</strong> Nos reservamos el derecho de modificar estas
                políticas avisando al Usuario a través de los canales oficiales.</li>
            <li><strong class="text-neutral-800">Ley Aplicable y Jurisdicción:</strong> Estos términos se rigen por las
                leyes vigentes en los Estados Unidos Mexicanos. Para cualquier controversia, el Usuario y la Plataforma se
                someten expresamente a la jurisdicción de los tribunales competentes de la Ciudad de México, renunciando a
                cualquier otro fuero que pudiera corresponderles por razón de sus domicilios presentes o futuros.</li>
        </ul>
    </div>
@endsection