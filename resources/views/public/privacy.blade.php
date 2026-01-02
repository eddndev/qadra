@extends('layouts.public')

@section('content')
    <div class="container-app py-24 max-w-4xl mx-auto">
        <!-- I. POLÍTICA DE PRIVACIDAD -->
        <h1 class="text-3xl font-bold text-brand-900 mb-2">I. POLÍTICA DE PRIVACIDAD</h1>
        <h2 class="text-xl text-brand-700 mb-8 font-medium">(AVISO DE PRIVACIDAD INTEGRAL)</h2>

        <p class="mb-6 text-neutral-600 leading-relaxed">
            En cumplimiento con el Reglamento General de Protección de Datos (GDPR) y la Ley Federal de Protección de Datos
            Personales en Posesión de los Particulares (LFPDPPP), informamos sobre el tratamiento de sus datos.
        </p>

        <h3 class="text-xl font-bold text-brand-800 mt-8 mb-4">1. Datos Personales Recolectados</h3>
        <p class="mb-4 text-neutral-600">Para garantizar la operatividad técnica y legal, recolectamos las siguientes
            categorías de datos:</p>
        <ul class="list-disc pl-5 space-y-3 mb-8 text-neutral-600 marker:text-brand-500">
            <li><strong class="text-neutral-800">Datos del Titular de la Cuenta:</strong> Nombre completo, dirección de
                correo electrónico, contraseña bajo cifrado irreversible y secretos de autenticación de dos factores (2FA).
            </li>
            <li><strong class="text-neutral-800">Datos de Identificación Fiscal (Tenants):</strong> Nombre o razón social de
                la organización, Registro Federal de Contribuyentes (RFC) y domicilio de facturación.</li>
            <li><strong class="text-neutral-800">Datos de Terceros y Participantes:</strong> Nombres, números telefónicos,
                correos electrónicos y roles procesales de personas vinculadas a los expedientes gestionados (clientes,
                contrapartes, testigos).</li>
            <li><strong class="text-neutral-800">Datos de Pago:</strong> Información de suscripción procesada exclusivamente
                a través de Stripe (incluyendo identificadores de método de pago y últimos cuatro dígitos de tarjeta). La
                Plataforma no almacena números de tarjeta completos.</li>
            <li><strong class="text-neutral-800">Datos Técnicos y de Auditoría:</strong> Dirección IP, metadatos de archivos
                cargados, registros de actividad del sistema (logs) y cookies técnicas esenciales.</li>
        </ul>

        <h3 class="text-xl font-bold text-brand-800 mt-8 mb-4">2. Finalidad del Tratamiento</h3>
        <p class="mb-4 text-neutral-600">Los datos se utilizan estrictamente para las siguientes finalidades primarias:</p>
        <ol class="list-decimal pl-5 space-y-3 mb-8 text-neutral-600 marker:text-brand-500 marker:font-bold">
            <li><strong class="text-neutral-800">Gestión de Identidad:</strong> Administrar el acceso y la seguridad de la
                cuenta.</li>
            <li><strong class="text-neutral-800">Operación Legal:</strong> Gestionar expedientes, evidencias, plazos
                procesales y agenda de audiencias.</li>
            <li><strong class="text-neutral-800">Administración Financiera:</strong> Procesar pagos de suscripción y
                cumplimiento de obligaciones fiscales.</li>
            <li><strong class="text-neutral-800">Comunicaciones Críticas:</strong> Enviar alertas automáticas sobre plazos
                legales vencidos o por vencer y actualizaciones del servicio.</li>
        </ol>

        <h3 class="text-xl font-bold text-brand-800 mt-8 mb-4">3. Transferencia de Datos a Terceros</h3>
        <p class="mb-4 text-neutral-600">La Plataforma comparte información únicamente con proveedores necesarios para la
            prestación del servicio:</p>
        <ul class="list-disc pl-5 space-y-3 mb-8 text-neutral-600 marker:text-brand-500">
            <li><strong class="text-neutral-800">Stripe Inc.:</strong> Procesamiento seguro de transacciones financieras.
            </li>
            <li><strong class="text-neutral-800">Amazon Web Services (AWS):</strong> Almacenamiento cifrado de documentos y
                bases de datos.</li>
            <li><strong class="text-neutral-800">Proveedores de Infraestructura de Correo:</strong> Gestión de
                notificaciones y alertas del sistema.</li>
        </ul>

        <h3 class="text-xl font-bold text-brand-800 mt-8 mb-4">4. Derechos ARCO</h3>
        <p class="mb-6 text-neutral-600 leading-relaxed">
            Como titular de los datos, usted tiene derecho a Acceder, Rectificar, Cancelar u Oponerse al tratamiento de su
            información. Para ejercer estos derechos, debe contactar a nuestro Oficial de Privacidad en: <a
                href="mailto:soporte@qadra.com.mx"
                class="text-brand-600 hover:text-brand-800 font-medium underline transition-colors">soporte@qadra.com.mx</a>
        </p>

        <div class="my-12 border-t border-neutral-200"></div>

        <!-- II. SEGURIDAD DE LA INFORMACIÓN -->
        <h1 class="text-3xl font-bold text-brand-900 mb-6">II. SEGURIDAD DE LA INFORMACIÓN</h1>
        <p class="mb-6 text-neutral-600 leading-relaxed">
            Qadra implementa medidas técnicas, administrativas y físicas de grado industrial para la protección de la
            información sensible de carácter legal.
        </p>

        <h3 class="text-xl font-bold text-brand-800 mt-8 mb-4">1. Medidas Técnicas y Protocolos</h3>
        <ul class="list-disc pl-5 space-y-3 mb-8 text-neutral-600 marker:text-brand-500">
            <li><strong class="text-neutral-800">Cifrado en Tránsito:</strong> Todo el tráfico de datos entre el Usuario y
                la Plataforma se realiza bajo protocolos HTTPS con certificados de cifrado TLS 1.2 o superior.</li>
            <li><strong class="text-neutral-800">Protección de Credenciales:</strong> Las contraseñas se almacenan mediante
                algoritmos de hashing de alta seguridad (bcrypt), garantizando que no sean legibles incluso en caso de
                acceso no autorizado.</li>
            <li><strong class="text-neutral-800">Aislamiento Lógico (Multi-tenancy):</strong> El sistema utiliza una
                arquitectura de inquilinos separados. Cada organización opera en un entorno lógico independiente, impidiendo
                técnica y legalmente el acceso cruzado de datos entre diferentes despachos o empresas.</li>
            <li>
                <strong class="text-neutral-800">Mitigación de Vulnerabilidades:</strong> Implementación nativa de defensas
                contra:
                <ul class="list-[circle] pl-5 mt-2 space-y-2 marker:text-brand-400">
                    <li>Inyección SQL mediante el uso de ORM y sentencias preparadas.</li>
                    <li>Cross-Site Scripting (XSS) vía filtrado estricto de salida de datos.</li>
                    <li>Cross-Site Request Forgery (CSRF) mediante validación de tokens únicos por sesión.</li>
                </ul>
            </li>
        </ul>

        <h3 class="text-xl font-bold text-brand-800 mt-8 mb-4">2. Almacenamiento y Resguardo</h3>
        <ul class="list-disc pl-5 space-y-3 mb-8 text-neutral-600 marker:text-brand-500">
            <li><strong class="text-neutral-800">Infraestructura en la Nube:</strong> Los datos se hospedan en centros de
                datos de alta seguridad (Amazon Web Services).</li>
            <li><strong class="text-neutral-800">Gestión de Evidencias:</strong> Los archivos y documentos cargados se
                almacenan con acceso restringido, utilizando firmas digitales temporales para su visualización segura.</li>
        </ul>

        <h3 class="text-xl font-bold text-brand-800 mt-8 mb-4">3. Responsabilidad Compartida</h3>
        <p class="mb-4 text-neutral-600">La Plataforma es responsable de la seguridad de la infraestructura; sin embargo, el
            Usuario asume la responsabilidad total sobre:</p>
        <ul class="list-disc pl-5 space-y-3 mb-8 text-neutral-600 marker:text-brand-500">
            <li>La confidencialidad de su contraseña y la activación de la Autenticación de Dos Factores (2FA).</li>
            <li>El control y supervisión de los usuarios invitados a su equipo de trabajo.</li>
        </ul>
    </div>
@endsection