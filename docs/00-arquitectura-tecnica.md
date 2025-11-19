# Arquitectura Técnica: Sistema Procesal Penal Mexicano + Diseño Multi-Tenant

**Versión:** 1.0
**Fecha:** 18 de noviembre de 2025
**Autor:** Equipo Qadra - ESCOM IPN

---

## Tabla de Contenidos

1. [Investigación del Sistema Procesal Penal Mexicano](#1-investigación-del-sistema-procesal-penal-mexicano)
2. [Modelo de Entidades y Relaciones](#2-modelo-de-entidades-y-relaciones)
3. [Sistema de Tiers y Pricing](#3-sistema-de-tiers-y-pricing)
4. [Matriz de Permisos](#4-matriz-de-permisos)
5. [Arquitectura Multi-Tenant](#5-arquitectura-multi-tenant)
6. [Recomendaciones Técnicas](#6-recomendaciones-técnicas)

---

## 1. Investigación del Sistema Procesal Penal Mexicano

### 1.1 Resumen Ejecutivo del CNPP

El **Código Nacional de Procedimientos Penales (CNPP)** regula el sistema acusatorio penal mexicano, vigente desde 2016. Es un sistema oral, adversarial y garantista que busca equilibrar la persecución del delito con el respeto a los derechos humanos.

**Principios Fundamentales:**
- **Presunción de inocencia:** Nadie puede ser considerado culpable hasta que exista sentencia firme
- **Publicidad:** Los procesos son públicos (salvo excepciones)
- **Contradicción:** Las partes pueden controvertir las pruebas y argumentos
- **Inmediación:** El juez debe tener contacto directo con las partes y pruebas
- **Igualdad:** Las partes tienen las mismas oportunidades procesales

### 1.2 Etapas del Proceso Penal según el CNPP

El proceso penal se divide en **3 etapas principales** + una fase de ejecución:

```
┌─────────────────────────────────────────────────────────────────────────┐
│                        PROCESO PENAL MEXICANO                           │
└─────────────────────────────────────────────────────────────────────────┘

┌──────────────────────┐    ┌──────────────┐    ┌─────────────┐    ┌──────────┐
│  1. INVESTIGACIÓN    │ -> │ 2. INTERMEDIA│ -> │  3. JUICIO  │ -> │ EJECUCIÓN│
│  (Fase Inicial +     │    │              │    │    ORAL     │    │          │
│   Complementaria)    │    │              │    │             │    │          │
└──────────────────────┘    └──────────────┘    └─────────────┘    └──────────┘
```

#### **ETAPA 1: INVESTIGACIÓN**

**Objetivo:** Reunir elementos de convicción para determinar si existe fundamento para acusar.

Esta etapa se divide en **DOS FASES:**

##### **Fase A: Investigación Inicial**

**Inicio:**
- Denuncia, querella o flagrancia
- Ministerio Público (MP) toma conocimiento del delito

**Actividades Clave:**
- MP investiga el delito con apoyo de la policía
- Recopilación de datos de prueba
- Determinación de líneas de investigación
- Puede solicitar órdenes de aprehensión o cateo al juez de control

**Audiencia Inicial (dentro de 72 horas si hay detenido):**
1. **Control de Detención:** Juez verifica legalidad de la detención
2. **Formulación de Imputación:** MP comunica al imputado los hechos que se le atribuyen
3. **Declaración del Imputado:** Puede declarar o guardar silencio
4. **Vinculación a Proceso:** Juez decide si existen datos que establezcan un hecho delictivo y probabilidad de participación del imputado
5. **Medidas Cautelares:** Juez puede imponer medidas para asegurar comparecencia (presentaciones periódicas, prohibición de acercarse a víctimas, prisión preventiva, etc.)

**Plazos:**
- Si hay detenido: Audiencia inicial en máximo 72 horas (o 144 horas en casos excepcionales)
- MP puede investigar sin plazo hasta formular imputación

**Fin:** Cuando el MP formula imputación y el imputado queda a disposición del juez de control.

##### **Fase B: Investigación Complementaria**

**Inicio:** Después de la vinculación a proceso

**Objetivo:** Complementar la investigación bajo supervisión judicial

**Actividades Clave:**
- MP recopila pruebas adicionales
- Defensor puede investigar y aportar datos
- Víctima puede coadyuvar en la investigación
- Audiencias intermedias si se requiere (medidas cautelares, datos de prueba)

**Plazos:**
- Delitos con pena máxima ≤ 2 años: máximo 2 meses
- Delitos con pena máxima > 2 años: máximo 6 meses
- Puede ampliarse por plazo igual una sola vez con justificación

**Fin:** Cuando MP cierra la investigación y decide:
- **Acusar** (pasa a etapa intermedia)
- **No ejercer acción penal** (archiva el caso)
- **Buscar soluciones alternas** (acuerdos reparatorios, suspensión condicional)

##### **Soluciones Alternas (pueden ocurrir en investigación o intermedia):**

**1. Acuerdo Reparatorio:**
- Acuerdo entre víctima e imputado
- Solo para delitos no graves, patrimoniales sin violencia, o culposos
- Extingue la acción penal al cumplirse
- Requiere aprobación del juez

**2. Suspensión Condicional del Proceso:**
- Imputado acepta responsabilidad y cumple condiciones (reparación del daño, servicios comunitarios, tratamientos, etc.)
- Solo para delitos con pena ≤ 5 años de prisión
- Si cumple, se extingue la acción penal

**3. Procedimiento Abreviado:**
- Imputado acepta hechos y responsabilidad
- Se salta juicio oral
- Sentencia reducida (hasta 1/3 menos de la pena)

#### **ETAPA 2: INTERMEDIA**

**Inicio:** MP presenta escrito de acusación

**Objetivo:** Depurar el proceso antes del juicio. Decidir qué pruebas son admisibles.

**Fases:**
1. **Fase Escrita:**
   - MP presenta acusación formal con los hechos, clasificación jurídica y pruebas
   - Defensor puede excluir pruebas, solicitar sobreseimiento, ofrecer contra-pruebas
   - Víctima puede coadyuvar

2. **Audiencia Intermedia:**
   - Juez de control decide qué pruebas se admiten para juicio
   - Resuelve excepciones y exclusiones de evidencia
   - Emite **Auto de Apertura a Juicio Oral** (AAJO)
   - Define hechos controvertidos y pruebas admitidas

**Fin:** Auto de Apertura a Juicio Oral. El caso pasa al Tribunal de Enjuiciamiento.

#### **ETAPA 3: JUICIO ORAL**

**Inicio:** Recepción del Auto de Apertura a Juicio

**Objetivo:** Desahogar las pruebas y dictar sentencia.

**Características:**
- Ante Tribunal de Enjuiciamiento (puede ser unitario o colegiado)
- Juicio público, oral, continuo y contradictorio
- Las partes presentan sus alegatos y desahogan pruebas

**Audiencia de Juicio Oral:**
1. **Alegatos de Apertura:** MP y defensor presentan su teoría del caso
2. **Desahogo de Pruebas:** Interrogatorios, testimonios, periciales, documentales
3. **Alegatos de Clausura:** Conclusiones finales de las partes
4. **Deliberación:** Tribunal analiza pruebas (puede ser privada)
5. **Sentencia:** Se dicta en audiencia pública

**Sentencia puede ser:**
- **Absolutoria:** Imputado es absuelto
- **Condenatoria:** Se impone pena y reparación del daño

**Fin:** Sentencia firme (sin posibilidad de recurso de apelación).

#### **FASE 4: EJECUCIÓN**

**Inicio:** Sentencia condenatoria firme

**Objetivo:** Cumplir la pena impuesta.

**Actividades:**
- Tribunal envía sentencia al **Juez de Ejecución**
- Juez de Ejecución supervisa cumplimiento de la pena
- Autoridades penitenciarias ejecutan la sentencia
- Pueden solicitarse beneficios (libertad preparatoria, sustitutivos de prisión, etc.)

**Fin:** Cumplimiento total de la pena o extinción de la misma.

---

### 1.3 Actores del Proceso Penal

| Actor | Rol | Funciones |
|-------|-----|-----------|
| **Ministerio Público (MP)** | Acusador | Investiga delitos, dirige a la policía, formula imputación, acusa en juicio, representa el interés social |
| **Juez de Control** | Garante de derechos | Supervisa legalidad de investigación, controla detenciones, vincula a proceso, impone medidas cautelares, admite pruebas en audiencia intermedia |
| **Tribunal de Enjuiciamiento** | Juzgador | Conduce juicio oral, desahoga pruebas, dicta sentencia |
| **Juez de Ejecución** | Supervisor de pena | Supervisa cumplimiento de sentencia, otorga beneficios |
| **Imputado** | Persona acusada | Ejerce su defensa, puede declarar o guardar silencio, tiene presunción de inocencia |
| **Defensor** | Representante legal del imputado | Defiende al imputado, ofrece pruebas, controla legalidad del proceso |
| **Víctima/Ofendido** | Persona afectada | Puede coadyuvar con MP, solicitar reparación del daño, participar en audiencias |
| **Asesor Jurídico de Víctima** | Representante legal de víctima | Asesora y representa a la víctima |
| **Testigos** | Aportan información | Declaran sobre hechos que presenciaron |
| **Peritos** | Expertos técnicos | Emiten dictámenes técnicos, científicos o artísticos |
| **Policía de Investigación** | Auxiliar del MP | Recaba evidencias, ejecuta órdenes del MP |

---

### 1.4 Documentos y Evidencias Clave por Etapa

#### **Investigación Inicial:**
- Denuncia o Querella
- Acta de detención (si hay flagrancia)
- Registro de cadena de custodia de evidencias
- Entrevistas/declaraciones de testigos
- Dictámenes periciales iniciales
- Solicitudes de órdenes de aprehensión/cateo
- Carpeta de investigación (compilación de todos los registros)

#### **Investigación Complementaria:**
- Ampliación de denuncia
- Datos de prueba adicionales
- Pruebas periciales complementarias
- Acuerdos de medidas cautelares
- Actas de audiencias (formulación de imputación, vinculación a proceso)

#### **Etapa Intermedia:**
- Escrito de acusación del MP
- Ofrecimiento de pruebas de la defensa
- Acuerdos de exclusión de pruebas
- Auto de Apertura a Juicio Oral (AAJO)

#### **Juicio Oral:**
- Pruebas admitidas (documentales, periciales, testimoniales)
- Actas de audiencia de juicio oral
- Alegatos (apertura y clausura)
- Sentencia

#### **Ejecución:**
- Sentencia firme
- Órdenes de traslado a centro penitenciario
- Solicitudes de beneficios
- Resoluciones del juez de ejecución

---

### 1.5 Medidas Cautelares (Art. 153-175 CNPP)

Las medidas cautelares son restricciones impuestas al imputado para asegurar su comparecencia, proteger a víctimas/testigos o evitar obstaculización del proceso.

**Tipos de Medidas Cautelares:**

1. Presentación periódica ante juez o autoridad
2. Exhibición de garantía económica
3. Embargo de bienes
4. Inmovilización de cuentas bancarias
5. Prohibición de salir del país (retención de pasaporte)
6. Prohibición de salir de una demarcación geográfica
7. Prohibición de concurrir a determinados lugares
8. Prohibición de convivir o comunicarse con víctimas, testigos o coimputados
9. Separación inmediata del domicilio (violencia familiar)
10. Suspensión de derechos (patria potestad, tutela, ejercicio profesional, etc.)
11. Internamiento en centro de adicciones (si aplica)
12. Colocación de dispositivos de localización electrónica
13. Resguardo en domicilio (arresto domiciliario)
14. **Prisión Preventiva** (puede ser oficiosa o justificada)

**Prisión Preventiva:**
- **Oficiosa:** Se aplica automáticamente para delitos graves (homicidio doloso, feminicidio, secuestro, trata de personas, etc.)
- **Justificada:** MP debe justificar su necesidad si no es delito oficioso

---

### 1.6 Estados Procesales por Etapa

**Sugerencia de Estados para el Sistema:**

#### **Investigación Inicial:**
1. `Denuncia Presentada`
2. `En Investigación Inicial`
3. `Orden de Aprehensión Solicitada`
4. `Detenido / En Espera de Audiencia Inicial`
5. `Audiencia Inicial Programada`
6. `Imputación Formulada`
7. `Vinculado a Proceso`
8. `No Vinculado a Proceso` (fin del caso)
9. `Solución Alterna en Trámite`

#### **Investigación Complementaria:**
1. `En Investigación Complementaria`
2. `Ampliación de Plazo Solicitada`
3. `Próximo a Cierre de Investigación`
4. `Investigación Cerrada - Pendiente Acusación`

#### **Etapa Intermedia:**
1. `Acusación Presentada`
2. `Audiencia Intermedia Programada`
3. `En Audiencia Intermedia`
4. `Auto de Apertura a Juicio Emitido`
5. `Sobreseído` (fin del caso)

#### **Juicio Oral:**
1. `En Juicio Oral`
2. `Audiencia de Juicio Programada`
3. `Desahogo de Pruebas en Proceso`
4. `Alegatos de Clausura`
5. `En Deliberación`
6. `Sentencia Dictada - Absolutoria` (fin del caso)
7. `Sentencia Dictada - Condenatoria`

#### **Ejecución:**
1. `Sentencia Firme - En Ejecución`
2. `Cumplimiento de Pena`
3. `Solicitud de Beneficio en Trámite`
4. `Beneficio Otorgado`
5. `Pena Cumplida` (fin del caso)

#### **Soluciones Alternas:**
1. `Acuerdo Reparatorio - En Negociación`
2. `Acuerdo Reparatorio - Aprobado`
3. `Acuerdo Reparatorio - Cumplido` (fin del caso)
4. `Suspensión Condicional - En Cumplimiento`
5. `Suspensión Condicional - Cumplida` (fin del caso)
6. `Procedimiento Abreviado - Aceptado`
7. `Procedimiento Abreviado - Sentenciado`

---

## 2. Modelo de Entidades y Relaciones


## 3. Sistema de Tiers y Pricing

### 3.1 Estrategia de Pricing Recomendada

**Modelo:** **Por Equipo (Workspace) con Slots de Usuarios**

**Justificación:**
- Los despachos legales son entidades que operan como equipos completos (no usuarios individuales aislados)
- Facilita la adopción: el despacho paga una tarifa base y puede agregar usuarios según necesite
- Escalable: permite crecer el pricing conforme el despacho crece
- Predecible: el despacho sabe cuánto paga por adelantado
- Competitivo: los competidores cobran por usuario individual (más caro para equipos)

**Esquema:**
- **Precio base mensual/anual por workspace**
- **Incluye X usuarios base** según el tier
- **Usuarios adicionales:** Cargo por usuario extra si se excede el límite

---

### 3.2 Definición de Tiers

#### **TIER 1: STARTER**

**Objetivo:** Despachos pequeños o independientes (1-3 abogados)

**Precio:**
- **Mensual:** $99 USD/mes
- **Anual:** $990 USD/año (ahorro de 17%, equivalente a $82.50 USD/mes)

**Límites:**
- **Casos activos:** 20 casos activos simultáneos
- **Usuarios:** 3 miembros del equipo incluidos
- **Usuario adicional:** +$20 USD/mes por usuario extra (hasta máximo 5 usuarios totales)
- **Almacenamiento:** 10 GB

**Funcionalidades Incluidas:**
- ✅ Gestión de casos penales
- ✅ Audiencias y calendario
- ✅ Gestión de evidencias y documentos
- ✅ Actuaciones y diligencias
- ✅ Medidas cautelares
- ✅ Alertas de plazos
- ✅ Reportes básicos (casos por etapa, audiencias próximas)
- ✅ Soporte por email

**Funcionalidades Excluidas:**
- ❌ Portal de clientes
- ❌ Reportes avanzados
- ❌ API access
- ❌ Branding personalizado
- ❌ Soporte prioritario
- ❌ Auditoría de acciones (logs)

---

#### **TIER 2: PROFESSIONAL**

**Objetivo:** Despachos medianos y grandes (4+ abogados, múltiples casos complejos)

**Precio:**
- **Mensual:** $249 USD/mes
- **Anual:** $2,490 USD/año (ahorro de 17%, equivalente a $207.50 USD/mes)

**Límites:**
- **Casos activos:** 100 casos activos simultáneos
- **Usuarios:** 10 miembros del equipo incluidos
- **Usuario adicional:** +$15 USD/mes por usuario extra (usuarios ilimitados)
- **Almacenamiento:** 50 GB

**Funcionalidades Incluidas:**
- ✅ **Todo lo de Starter +**
- ✅ **Portal de Clientes:** Acceso limitado para clientes ver su caso
- ✅ **Reportes Avanzados:** Métricas de desempeño, casos por abogado, tiempos promedio
- ✅ **Soluciones Alternas:** Gestión de acuerdos reparatorios, suspensión condicional
- ✅ **Auditoría de Acciones:** Logs de quién hizo qué y cuándo
- ✅ **Branding Personalizado:** Logo del despacho en reportes y emails
- ✅ **Soporte Prioritario:** Chat en vivo + respuesta en < 4 horas
- ✅ **Integraciones:** Webhooks para integraciones básicas

**Funcionalidades Excluidas:**
- ❌ API REST completa
- ❌ SLA de uptime garantizado
- ❌ Gerente de cuenta dedicado

---

#### **TIER 3: ENTERPRISE (Futuro v2.0)**

**Objetivo:** Grandes firmas, múltiples oficinas, necesidades personalizadas

**Precio:**
- **Custom:** Cotización personalizada (estimado: $500-1000 USD/mes)

**Límites:**
- **Casos activos:** Ilimitados
- **Usuarios:** Ilimitados
- **Almacenamiento:** Ilimitado (o 500 GB+ negociable)

**Funcionalidades Incluidas:**
- ✅ **Todo lo de Professional +**
- ✅ **API REST Completa:** Integraciones custom
- ✅ **Multi-Workspace:** Gestión de múltiples oficinas bajo una cuenta
- ✅ **SLA Garantizado:** 99.9% uptime
- ✅ **Gerente de Cuenta Dedicado**
- ✅ **Onboarding Personalizado:** Setup asistido, capacitación del equipo
- ✅ **Backup Personalizado:** Frecuencia y retención custom
- ✅ **Single Sign-On (SSO):** Autenticación corporativa

---

### 3.3 Comparativa de Tiers

| Característica | STARTER | PROFESSIONAL | ENTERPRISE (v2.0) |
|---|:---:|:---:|:---:|
| **Precio Mensual** | $99 | $249 | Custom |
| **Precio Anual** | $990 | $2,490 | Custom |
| **Casos Activos** | 20 | 100 | Ilimitados |
| **Usuarios Incluidos** | 3 | 10 | Ilimitados |
| **Almacenamiento** | 10 GB | 50 GB | Ilimitado |
| **Gestión de Casos** | ✅ | ✅ | ✅ |
| **Audiencias y Calendario** | ✅ | ✅ | ✅ |
| **Evidencias y Documentos** | ✅ | ✅ | ✅ |
| **Alertas de Plazos** | ✅ | ✅ | ✅ |
| **Portal de Clientes** | ❌ | ✅ | ✅ |
| **Reportes Avanzados** | ❌ | ✅ | ✅ |
| **Auditoría de Acciones** | ❌ | ✅ | ✅ |
| **Branding Personalizado** | ❌ | ✅ | ✅ |
| **API Access** | ❌ | Webhooks | REST Completa |
| **Soporte** | Email | Prioritario | Dedicado |
| **SLA Uptime** | ❌ | ❌ | 99.9% |

---

### 3.4 Trial y Freemium

**Trial Gratuito:**
- **Duración:** 30 días
- **Tier:** Professional (para que prueben todas las funcionalidades)
- **Límites durante trial:** 5 casos, 3 usuarios, 2 GB
- **Sin tarjeta de crédito:** No requerir CC para trial (reduce fricción)
- **Conversión:** Al terminar trial, ofrecen elegir Starter o Professional

**No habrá plan Freemium gratuito permanente** (no es sostenible para un SaaS especializado).

---

### 3.5 Implementación Técnica del Pricing

**Laravel Cashier + Stripe:**

1. **Crear Productos en Stripe:**
   - Producto: "Qadra Starter"
     - Price ID Mensual: `price_starter_monthly`
     - Price ID Anual: `price_starter_yearly`
   - Producto: "Qadra Professional"
     - Price ID Mensual: `price_professional_monthly`
     - Price ID Anual: `price_professional_yearly`

2. **Tabla `subscription_tiers` en DB:**
   ```php
   Schema::create('subscription_tiers', function (Blueprint $table) {
       $table->id();
       $table->string('name'); // Starter, Professional
       $table->string('slug')->unique();
       $table->text('description')->nullable();
       $table->integer('price_monthly'); // en centavos
       $table->integer('price_yearly'); // en centavos
       $table->string('stripe_product_id')->nullable();
       $table->string('stripe_price_monthly_id')->nullable();
       $table->string('stripe_price_yearly_id')->nullable();
       $table->integer('max_active_cases')->nullable();
       $table->integer('max_users')->nullable();
       $table->integer('max_storage_gb')->nullable();
       $table->json('features')->nullable();
       $table->boolean('is_active')->default(true);
       $table->integer('sort_order')->default(0);
       $table->timestamps();
   });
   ```

3. **Enforzar Límites:**
   - Crear middleware o policies que verifiquen límites antes de crear casos/usuarios
   - Ejemplo: `CanCreateCasePolicy`:
     ```php
     public function create(User $user)
     {
         $tenant = $user->currentTenant;
         $activeCases = $tenant->cases()->whereNull('closed_at')->count();

         return $activeCases < $tenant->tier->max_active_cases;
     }
     ```

4. **Usuarios Adicionales:**
   - Si el tier permite usuarios adicionales, crear un Stripe Price con modelo `per_unit`
   - Usar `Subscription::incrementQuantity()` cuando se agregue un usuario
   - Laravel Cashier calcula el prorreo automáticamente

---

## 4. Matriz de Permisos

### 4.1 Dos Capas de Permisos

El sistema tiene **dos capas de control de acceso:**

1. **Permisos por TIER (Feature Flags):** Controlados por nosotros (Qadra Team) desde Laravel Nova
2. **Permisos por ROL (RBAC):** Controlados por el Owner del despacho dentro de su workspace

---

### 4.2 Capa 1: Permisos por TIER (Feature Flags)

Estos permisos controlan **qué módulos/funcionalidades están disponibles** según el tier de suscripción.

| Funcionalidad | STARTER | PROFESSIONAL | ENTERPRISE |
|---|:---:|:---:|:---:|
| **Gestión de Casos** | ✅ | ✅ | ✅ |
| **Audiencias y Calendario** | ✅ | ✅ | ✅ |
| **Evidencias y Documentos** | ✅ | ✅ | ✅ |
| **Actuaciones y Diligencias** | ✅ | ✅ | ✅ |
| **Medidas Cautelares** | ✅ | ✅ | ✅ |
| **Alertas de Plazos** | ✅ | ✅ | ✅ |
| **Reportes Básicos** | ✅ | ✅ | ✅ |
| **Portal de Clientes** | ❌ | ✅ | ✅ |
| **Reportes Avanzados** | ❌ | ✅ | ✅ |
| **Soluciones Alternas (tracking)** | ❌ | ✅ | ✅ |
| **Auditoría de Acciones** | ❌ | ✅ | ✅ |
| **Branding Personalizado** | ❌ | ✅ | ✅ |
| **Webhooks** | ❌ | ✅ | ✅ |
| **API REST** | ❌ | ❌ | ✅ |
| **Multi-Workspace** | ❌ | ❌ | ✅ |
| **SSO** | ❌ | ❌ | ✅ |

**Implementación:**

Middleware que verifica si el tenant tiene acceso a una funcionalidad:

```php
// app/Http/Middleware/EnsureTenantHasFeature.php
public function handle($request, Closure $next, $feature)
{
    $tenant = $request->user()->currentTenant;

    if (!$tenant->hasFeature($feature)) {
        abort(403, 'Esta funcionalidad no está disponible en tu plan actual.');
    }

    return $next($request);
}

// En Tenant model:
public function hasFeature($feature)
{
    return $this->tier->features[$feature] ?? false;
}
```

Uso en rutas:
```php
Route::get('/cases/{case}/client-portal', [CaseController::class, 'clientPortal'])
    ->middleware(['auth', 'tenant', 'feature:client_portal']);
```

---

### 4.3 Capa 2: Permisos por ROL (RBAC)

Estos permisos controlan **qué puede hacer cada miembro del equipo dentro del despacho**, gestionados por el Owner.

#### **Roles Definidos:**

1. **Owner** (Propietario del Despacho)
2. **Litigante** (Abogado Senior/Litigante)
3. **Asociado** (Abogado Junior/Asociado)
4. **Paralegal** (Asistente Legal/Paralegal)
5. **Administrativo** (Personal Administrativo)
6. **Cliente** (Cliente del Despacho - solo si el tier lo permite)

---

#### **Matriz de Permisos por Rol:**

| Permiso | Owner | Litigante | Asociado | Paralegal | Administrativo | Cliente |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| **Gestión de Casos** |
| Ver todos los casos | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Ver solo casos asignados | - | - | - | - | - | ✅ |
| Crear caso | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| Editar caso | ✅ | ✅ | ✅ | ⚠️ Solo asignados | ❌ | ❌ |
| Eliminar caso | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Cerrar caso | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Asignar abogados | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Participantes** |
| Ver participantes | ✅ | ✅ | ✅ | ✅ | ✅ | ⚠️ Solo su caso |
| Crear participante | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ |
| Editar participante | ✅ | ✅ | ✅ | ⚠️ Solo asignados | ❌ | ❌ |
| Eliminar participante | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Documentos/Evidencias** |
| Ver documentos | ✅ | ✅ | ✅ | ✅ | ✅ | ⚠️ Solo compartidos |
| Subir documentos | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ |
| Eliminar documentos | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Compartir con cliente | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Audiencias** |
| Ver audiencias | ✅ | ✅ | ✅ | ✅ | ✅ | ⚠️ Solo su caso |
| Crear audiencia | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Editar audiencia | ✅ | ✅ | ✅ | ⚠️ Solo asignados | ✅ | ❌ |
| Eliminar audiencia | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Registrar resultado | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Actuaciones** |
| Ver actuaciones | ✅ | ✅ | ✅ | ✅ | ✅ | ⚠️ Solo su caso |
| Crear actuación | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ |
| Editar actuación | ✅ | ✅ | ✅ | ⚠️ Solo asignados | ❌ | ❌ |
| Eliminar actuación | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Medidas Cautelares** |
| Ver medidas | ✅ | ✅ | ✅ | ✅ | ❌ | ⚠️ Solo su caso |
| Crear medida | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| Editar medida | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Reportes** |
| Ver reportes básicos | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Ver reportes avanzados | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Exportar reportes | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| **Gestión de Equipo** |
| Ver miembros | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Invitar miembros | ✅ | ⚠️ Solo con aprobación | ❌ | ❌ | ❌ | ❌ |
| Editar roles | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Remover miembros | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **Suscripción y Facturación** |
| Ver suscripción | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Cambiar plan | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Actualizar método de pago | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Ver facturas | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| **Configuración del Despacho** |
| Ver configuración | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Editar configuración | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Cambiar logo | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |

**Leyenda:**
- ✅ = Permitido
- ❌ = Denegado
- ⚠️ = Permitido con restricciones

---

#### **Implementación con Spatie Permission:**

```php
// Definir permisos en seeder
$permissions = [
    // Casos
    'cases.view_all',
    'cases.view_assigned',
    'cases.create',
    'cases.edit',
    'cases.delete',
    'cases.close',
    'cases.assign',

    // Documentos
    'documents.view',
    'documents.upload',
    'documents.delete',
    'documents.share_with_client',

    // Audiencias
    'hearings.view',
    'hearings.create',
    'hearings.edit',
    'hearings.delete',
    'hearings.record_result',

    // Equipo
    'team.view',
    'team.invite',
    'team.edit_roles',
    'team.remove',

    // Suscripción
    'subscription.view',
    'subscription.manage',

    // etc...
];

// Crear roles y asignar permisos
$owner = Role::create(['name' => 'owner', 'team_id' => $tenant->id]);
$owner->givePermissionTo([
    'cases.view_all', 'cases.create', 'cases.edit', 'cases.delete',
    'team.invite', 'team.edit_roles', 'subscription.manage', ...
]);

$litigante = Role::create(['name' => 'litigante', 'team_id' => $tenant->id]);
$litigante->givePermissionTo([
    'cases.view_all', 'cases.create', 'cases.edit',
    'documents.upload', 'hearings.create', ...
]);
```

**Uso en Policies:**
```php
// app/Policies/CasePolicy.php
public function delete(User $user, Case $case)
{
    return $user->hasPermissionTo('cases.delete', $case->tenant);
}
```

---

### 4.4 Interacción entre Capas de Permisos

**Ejemplo 1: Portal de Clientes**

Para que un cliente pueda acceder al portal:
1. **Tier Check:** El despacho debe tener un tier Professional o superior (feature flag)
2. **Role Check:** El usuario debe tener rol "Cliente" en ese despacho
3. **Scope Check:** Solo puede ver sus propios casos

**Ejemplo 2: Eliminar un Caso**

Para que un usuario elimine un caso:
1. **Tier Check:** No hay restricción por tier (todos los tiers pueden eliminar casos)
2. **Role Check:** Usuario debe tener permiso `cases.delete` (Owner o Litigante)
3. **Ownership Check:** El caso debe pertenecer al tenant del usuario (tenant_id)

---

## 5. Arquitectura Multi-Tenant

### 5.1 Estrategia Recomendada para Laravel

**Approach:** **Single Database + tenant_id (Shared Database, Shared Schema)**

**Justificación:**
- ✅ **Más simple de implementar:** No requiere gestión dinámica de conexiones o migraciones multi-DB
- ✅ **Cost-effective:** Un solo servidor de DB para todos los tenants
- ✅ **Escalable hasta 1000+ tenants:** Suficiente para fase de crecimiento
- ✅ **Backups centralizados:** Un solo backup cubre todos los datos
- ✅ **Queries entre tenants para analytics:** El equipo de Qadra puede hacer queries globales para métricas

**Desventajas (mitigables):**
- ⚠️ **Riesgo de data leakage:** Si olvidamos filtrar por `tenant_id` (se mitiga con Global Scopes)
- ⚠️ **Performance con muchos tenants:** Índices correctos en `tenant_id` minimizan el impacto

**Cuándo migrar a Multi-Database:**
- Si superamos los 5,000 tenants activos
- Si algún tenant requiere aislamiento total por regulaciones

---

### 5.2 Implementación Técnica

#### **5.2.1 Trait TenantScoped**

Crear un trait para aplicar automáticamente el scope de tenant en todos los modelos:

```php
// app/Traits/TenantScoped.php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait TenantScoped
{
    protected static function bootTenantScoped()
    {
        // Al crear un modelo, asignar automáticamente el tenant_id
        static::creating(function (Model $model) {
            if (!$model->tenant_id && auth()->check()) {
                $model->tenant_id = auth()->user()->currentTenant->id;
            }
        });

        // Aplicar global scope para filtrar solo por tenant actual
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check() && auth()->user()->currentTenant) {
                $builder->where('tenant_id', auth()->user()->currentTenant->id);
            }
        });
    }

    // Relación con Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
```

**Uso en modelos:**
```php
// app/Models/Case.php
use App\Traits\TenantScoped;

class Case extends Model
{
    use TenantScoped;

    // El trait se encarga de filtrar por tenant_id automáticamente
}
```

---

#### **5.2.2 Middleware de Tenant Identification**

Crear middleware que identifique y cargue el tenant actual del usuario:

```php
// app/Http/Middleware/IdentifyTenant.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IdentifyTenant
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return $next($request);
        }

        $user = auth()->user();

        // Si el usuario pertenece a un solo tenant, seleccionarlo automáticamente
        if ($user->tenants->count() === 1) {
            $user->setCurrentTenant($user->tenants->first());
        }

        // Si pertenece a múltiples tenants, usar el último seleccionado (en sesión)
        elseif (session()->has('current_tenant_id')) {
            $tenant = $user->tenants->find(session('current_tenant_id'));
            if ($tenant) {
                $user->setCurrentTenant($tenant);
            }
        }

        return $next($request);
    }
}
```

**En User model:**
```php
public function setCurrentTenant(Tenant $tenant)
{
    if (!$this->tenants->contains($tenant)) {
        abort(403, 'No perteneces a este despacho.');
    }

    $this->currentTenant = $tenant;
    session(['current_tenant_id' => $tenant->id]);
}

public function getCurrentTenantAttribute()
{
    return $this->currentTenant ?? null;
}
```

---

#### **5.2.3 Índices de Base de Datos**

**CRÍTICO:** Crear índices compuestos en `tenant_id` para todas las tablas multi-tenant:

```php
Schema::create('cases', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
    // ... otros campos

    // Índice compuesto para queries frecuentes
    $table->index(['tenant_id', 'current_stage']);
    $table->index(['tenant_id', 'assigned_to']);
    $table->index(['tenant_id', 'opened_at']);
});
```

---

### 5.3 Consideraciones de Seguridad

#### **5.3.1 Políticas de Acceso (Policies)**

Siempre verificar ownership del tenant en policies:

```php
// app/Policies/CasePolicy.php
public function view(User $user, Case $case)
{
    // Verificar que el usuario pertenece al tenant del caso
    return $user->tenants->contains($case->tenant_id);
}

public function update(User $user, Case $case)
{
    return $user->tenants->contains($case->tenant_id)
           && $user->hasPermissionTo('cases.edit', $case->tenant);
}
```

---

#### **5.3.2 Testing de Aislamiento**

Crear tests que verifiquen que un tenant NO puede acceder a datos de otro:

```php
/** @test */
public function a_tenant_cannot_see_cases_from_another_tenant()
{
    $tenant1 = Tenant::factory()->create();
    $tenant2 = Tenant::factory()->create();

    $user1 = User::factory()->create();
    $user1->tenants()->attach($tenant1);

    $case1 = Case::factory()->create(['tenant_id' => $tenant1->id]);
    $case2 = Case::factory()->create(['tenant_id' => $tenant2->id]);

    $this->actingAs($user1);
    $user1->setCurrentTenant($tenant1);

    // Debe ver solo el caso de su tenant
    $this->assertEquals(1, Case::count());
    $this->assertTrue(Case::first()->is($case1));
}
```

---

#### **5.3.3 Auditoría de Queries**

En desarrollo, usar Laravel Telescope para auditar que todas las queries incluyan `tenant_id`:

```php
// En desarrollo, alertar si una query no filtra por tenant_id
if (app()->environment('local')) {
    DB::listen(function ($query) {
        if (auth()->check() && !str_contains($query->sql, 'tenant_id')) {
            // Log de warning
            logger()->warning('Query sin tenant_id scope', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
            ]);
        }
    });
}
```

---

### 5.4 Relación Users ↔ Tenants ↔ Roles

**Modelo:**
- Un **User** puede pertenecer a **múltiples Tenants** (tabla pivot `tenant_user`)
- Cada relación User-Tenant tiene un **rol** (owner, litigante, etc.)
- Los **permisos** se asignan al rol **dentro del contexto del tenant** (team_id en Spatie Permission)

**Tabla Pivot `tenant_user`:**
```php
Schema::create('tenant_user', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('role'); // owner, litigante, asociado, paralegal, administrativo, cliente
    $table->foreignId('invited_by')->nullable()->constrained('users');
    $table->timestamp('invited_at')->nullable();
    $table->timestamp('joined_at')->nullable();
    $table->timestamps();

    $table->unique(['tenant_id', 'user_id']);
});
```

**Uso:**
```php
// Invitar un usuario a un tenant con rol
$tenant->members()->attach($user, [
    'role' => 'litigante',
    'invited_by' => auth()->id(),
    'invited_at' => now(),
]);

// Asignar permisos del rol usando Spatie Permission
$role = Role::where('name', 'litigante')
            ->where('team_id', $tenant->id)
            ->first();

$user->assignRole($role);
```

---

## 6. Recomendaciones Técnicas

### 6.1 Paquetes de Laravel Recomendados

#### **Multi-Tenancy:**
- **Custom Implementation** con trait `TenantScoped` (preferido para v1.0)
- Alternativa: [Spatie Laravel Multitenancy](https://github.com/spatie/laravel-multitenancy) (si necesitamos multi-database en futuro)

#### **Permisos y Roles:**
- **[Spatie Laravel Permission](https://github.com/spatie/laravel-permission)** (RBAC con soporte de teams)
- Instalación: `composer require spatie/laravel-permission`

#### **Suscripciones y Pagos:**
- **[Laravel Cashier (Stripe)](https://laravel.com/docs/billing)** (integración oficial de Laravel con Stripe)
- Instalación: `composer require laravel/cashier`

#### **Backoffice (Panel Admin):**
- **[Laravel Nova 5](https://nova.laravel.com)** (licencia $299 USD por proyecto)
- Instalación: Requiere licencia + `composer require laravel/nova`

#### **Notificaciones:**
- **Laravel Notifications** (built-in) + **Laravel Queue** (Redis)
- Para emails: [Mailgun](https://www.mailgun.com/) o [SendGrid](https://sendgrid.com/)

#### **Almacenamiento de Archivos:**
- **Laravel Storage** (built-in)
- Drivers: Local (dev), S3 (prod), DigitalOcean Spaces (alternativa)
- Instalación S3: `composer require --with-all-dependencies league/flysystem-aws-s3-v3 "^3.0"`

#### **Testing:**
- **[Pest](https://pestphp.com/)** (framework de testing moderno para PHP)
- Instalación: `composer require pestphp/pest --dev --with-all-dependencies`

#### **Auditoría de Acciones:**
- **[Spatie Laravel Activitylog](https://github.com/spatie/laravel-activitylog)** (para tier Professional+)
- Instalación: `composer require spatie/laravel-activitylog`

#### **Backups:**
- **[Spatie Laravel Backup](https://github.com/spatie/laravel-backup)**
- Instalación: `composer require spatie/laravel-backup`

---

### 6.2 Consideraciones de Implementación

#### **6.2.1 Seeders para Datos Legales**

Crear seeders con catálogos del sistema penal mexicano:

```php
// database/seeders/CrimeTypesSeeder.php
DB::table('crime_types')->insert([
    ['name' => 'Homicidio Doloso', 'classification' => 'doloso', 'severity' => 'grave'],
    ['name' => 'Homicidio Culposo', 'classification' => 'culposo', 'severity' => 'no_grave'],
    ['name' => 'Robo Simple', 'classification' => 'doloso', 'severity' => 'no_grave'],
    ['name' => 'Robo con Violencia', 'classification' => 'doloso', 'severity' => 'grave'],
    ['name' => 'Fraude', 'classification' => 'doloso', 'severity' => 'no_grave'],
    ['name' => 'Secuestro', 'classification' => 'doloso', 'severity' => 'grave'],
    // ... más delitos del CNPP
]);
```

#### **6.2.2 Alertas de Plazos con Laravel Queue**

Crear un job que verifique plazos próximos a vencer:

```php
// app/Jobs/CheckDeadlinesJob.php
public function handle()
{
    $deadlines = CaseDeadline::where('status', 'pendiente')
        ->where('deadline_at', '<=', now()->addDays(7))
        ->get();

    foreach ($deadlines as $deadline) {
        $daysUntil = now()->diffInDays($deadline->deadline_at);

        if (in_array($daysUntil, [7, 3, 1, 0])) {
            // Enviar notificación
            $deadline->case->assignedLawyer->notify(
                new DeadlineApproachingNotification($deadline)
            );
        }
    }
}
```

Programar con Laravel Scheduler:
```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->job(new CheckDeadlinesJob)->daily();
}
```

#### **6.2.3 Storage por Tenant**

Organizar archivos en storage separando por tenant:

```php
// En CaseDocument model
public function getStoragePath()
{
    return "tenants/{$this->tenant_id}/cases/{$this->case_id}/documents";
}

// Al subir archivo
$path = $request->file('document')->store(
    $caseDocument->getStoragePath(),
    's3' // driver
);
```

#### **6.2.4 Limitador de Rate Limiting**

Proteger APIs y acciones críticas con rate limiting:

```php
// routes/web.php
Route::middleware(['auth', 'tenant', 'throttle:60,1'])->group(function () {
    Route::post('/cases', [CaseController::class, 'store']);
});

// Para tier Professional: más requests permitidos
Route::middleware(['auth', 'tenant', 'throttle:120,1', 'feature:api_access'])->group(function () {
    Route::apiResource('api/cases', Api\CaseController::class);
});
```

---

### 6.3 Próximos Pasos de Implementación

**Orden recomendado de desarrollo (post-documentación):**

1. **Sprint 0:** Setup y configuración
   - Crear proyecto Laravel 12
   - Instalar Breeze, Livewire 3, Tailwind CSS v4, Nova 5
   - Configurar base de datos, migraciones básicas
   - Setup de CI/CD (GitHub Actions)

2. **Sprint 1:** Multi-tenancy y autenticación
   - Implementar sistema multi-tenant (Tenant, TenantScoped trait)
   - Sistema de invitaciones a despachos
   - Spatie Permission con team_id
   - Middleware de tenant identification

3. **Sprint 2:** CRUD de Casos
   - Modelos: Case, CaseParticipant
   - Vistas Livewire para gestión de casos
   - Dashboard de casos del despacho
   - Filtros por etapa procesal

4. **Sprint 3:** Audiencias y Plazos
   - Modelos: CaseHearing, CaseDeadline
   - Calendario de audiencias (Livewire + Alpine)
   - Sistema de notificaciones de plazos
   - Jobs programados para alertas

5. **Sprint 4:** Evidencias y Documentos
   - Modelo: CaseDocument
   - Subida de archivos con Laravel Storage
   - Visualizador de documentos
   - Control de límites de storage por tier

6. **Sprint 5:** Actuaciones y Medidas Cautelares
   - Modelos: CaseActivity, CaseCautelarMeasure, CaseAlternativeSolution
   - Bitácora cronológica del caso
   - Gestión de medidas y soluciones alternas

7. **Sprint 6:** Suscripciones con Cashier
   - Integración con Stripe
   - Modelo: SubscriptionTier
   - Checkout y onboarding
   - Enforcement de límites por tier

8. **Sprint 7:** Laravel Nova Backoffice
   - Recursos Nova para Tenants, Users, Cases
   - Métricas y dashboards
   - Gestión de suscripciones desde Nova

9. **Sprint 8:** Testing y QA
   - Tests de features principales
   - Tests de aislamiento multi-tenant
   - Performance testing
   - Corrección de bugs

10. **Sprint 9:** Deploy y documentación
    - Deploy a producción (DigitalOcean/AWS)
    - Documentación de usuario
    - Video demo
    - Marketing inicial

---

## Conclusión

Este documento define la **arquitectura técnica completa** de Qadra, desde el modelado del sistema procesal penal mexicano hasta la implementación multi-tenant, permisos y pricing.

**Puntos clave:**
- ✅ Sistema especializado en el CNPP (no genérico)
- ✅ Arquitectura multi-tenant escalable (single DB + tenant_id)
- ✅ Dos capas de permisos (Tier + RBAC)
- ✅ Modelo de suscripción por equipo (Starter $99, Professional $249)
- ✅ Stack moderno: Laravel 12 + Livewire 3 + Nova 5 + Cashier

**Próximo paso:** Crear `03-database-schema.md` con las migraciones completas de Laravel.

---

**Última actualización:** 18 de noviembre de 2025
**Revisado por:** Equipo Qadra
**Estado:** ✅ Aprobado - Listo para implementación
