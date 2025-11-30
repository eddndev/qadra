# Backlog de Historias de Usuario - Qadra v1.0

**Versión:** 1.0
**Última Actualización:** 19 de noviembre de 2025
**Basado en:** Manifiesto v1.0 + Arquitectura Técnica v1.0 + Esquema DB v1.0

---

## Tabla de Contenidos

1. [Epic 1: Onboarding y Arquitectura SaaS](#epic-1-onboarding-y-arquitectura-saas-multi-tenant)
2. [Epic 2: Gestión Procesal (Core Legal)](#epic-2-gestión-procesal-core-legal)
3. [Epic 3: Agenda y Tiempos](#epic-3-agenda-y-tiempos-audiencias-y-plazos)
4. [Epic 4: Evidencias y Cadena de Custodia](#epic-4-evidencias-y-cadena-de-custodia)
5. [Epic 5: Gestión Documental](#epic-5-gestión-documental)
6. [Epic 6: Especialización CNPP](#epic-6-especialización-cnpp-medidas-y-soluciones)
7. [Epic 7: Seguridad y Auditoría](#epic-7-seguridad-y-auditoría)
8. [Epic 8: Actuaciones Diarias](#epic-8-actuaciones-diarias)
9. [Epic 9: Reportes y Dashboard](#epic-9-reportes-y-dashboard)
10. [Epic 10: Portal de Clientes (Professional)](#epic-10-portal-de-clientes-tier-professional)
11. [Matriz de Priorización](#matriz-de-priorización)
12. [Roadmap de Implementación](#roadmap-de-implementación)

---

## Epic 1: Onboarding y Arquitectura SaaS (Multi-Tenant)

**Objetivo:** Garantizar el aislamiento de datos entre despachos y la gestión de cuentas.

**Prioridad:** CRÍTICA (P0) - Fundación del sistema

---

### US-01: Registro de Nuevo Despacho (Tenant Creation)

**Como** Abogado Independiente o Owner de Despacho,
**Quiero** registrar mi firma legal en la plataforma y configurar mis datos fiscales,
**Para** obtener un espacio de trabajo (workspace) aislado y comenzar a operar.

**Criterios de Aceptación:**

1. ✅ El sistema muestra un formulario de registro con:
   - Nombre del despacho
   - RFC del despacho (validado con formato correcto)
   - Selección de plan (Starter / Professional)
   - Datos del usuario owner (nombre, email, contraseña)
2. ✅ Al enviar el formulario:
   - Se crea un registro en `tenants` con ULID único
   - Se genera automáticamente un `slug` URL-friendly basado en el nombre
   - Se asigna el `subscription_tier_id` del plan seleccionado
   - El estado inicial es `trial` con 30 días de prueba
3. ✅ Se crea automáticamente el primer usuario:
   - Registro en `users` con ULID
   - Registro en `tenant_user` con role `owner`
   - Envío de email de verificación
4. ✅ Se inicializan contadores en 0:
   - `current_users_count` = 1
   - `current_active_cases_count` = 0
   - `current_storage_usage_bytes` = 0
5. ✅ Se crea automáticamente el conjunto de roles base en `roles` con `team_id` del tenant:
   - owner, litigante, asociado, paralegal, administrativo, cliente
6. ✅ Redirección automática a dashboard del despacho con onboarding wizard

**Notas Técnicas:**
- Usar Laravel Breeze para autenticación base
- Implementar observer `TenantCreated` para inicialización de roles
- Validar unicidad de `slug` a nivel de aplicación

**Prioridad:** P0 - Sprint 1

---

### US-02: Invitación de Miembros al Equipo

**Como** Owner del Despacho,
**Quiero** invitar a otros abogados y asistentes por correo electrónico asignándoles un rol,
**Para** que puedan colaborar en los casos del despacho.

**Criterios de Aceptación:**

1. ✅ El sistema valida límites del tier:
   - Starter: máximo 3 usuarios totales
   - Professional: máximo 10 usuarios incluidos
   - Mostrar mensaje de error si se excede el límite
2. ✅ Formulario de invitación:
   - Email del invitado (validación de formato)
   - Rol a asignar (dropdown: litigante, asociado, paralegal, administrativo)
   - Mensaje personalizado (opcional)
3. ✅ Al enviar invitación:
   - Se crea registro en `team_invitations` con:
     - Token único (UUID)
     - Expiración en 7 días (`expires_at`)
     - `invited_by` = usuario actual
   - Se envía email transaccional con:
     - Link de aceptación con token
     - Nombre del despacho
     - Rol asignado
     - Mensaje personalizado
4. ✅ Al aceptar invitación:
   - Validar que token no haya expirado
   - Si el email ya existe en `users`, vincular existente
   - Si no existe, crear nuevo usuario con wizard de setup
   - Crear registro en `tenant_user` con rol especificado
   - Eliminar registro de `team_invitations`
   - Incrementar `current_users_count` del tenant
5. ✅ Owner puede ver invitaciones pendientes y re-enviarlas o cancelarlas

**Notas Técnicas:**
- Usar Laravel Queue para envío asíncrono de emails
- Job `DeleteExpiredInvitations` que corre diariamente
- Notificación al owner cuando alguien acepta invitación

**Prioridad:** P0 - Sprint 1

---

### US-03: Gestión de Suscripción y Límites (Billing)

**Como** Sistema Qadra (Lógica de Negocio),
**Quiero** impedir acciones que excedan los límites del plan contratado,
**Para** forzar el upgrade y monetizar el uso intensivo.

**Criterios de Aceptación:**

1. ✅ **Límite de Casos Activos:**
   - Antes de crear un caso, verificar `current_active_cases_count < max_active_cases`
   - Si se excede, mostrar modal "Has alcanzado el límite de tu plan" con botón "Actualizar Plan"
   - Permitir archivar casos inactivos para liberar cuota
2. ✅ **Límite de Usuarios:**
   - Antes de invitar, verificar `current_users_count < max_users`
   - Si se excede (solo en Starter), ofrecer upgrade a Professional
3. ✅ **Límite de Almacenamiento:**
   - Antes de subir archivo, verificar `current_storage_usage_bytes + file_size < (max_storage_gb * 1GB)`
   - Si se excede, mostrar error "Almacenamiento lleno" con opción de upgrade
4. ✅ **Feature Flags por Tier:**
   - Crear middleware `EnsureTenantHasFeature`
   - Rutas protegidas por features:
     - `/client-portal/*` → requiere `client_portal` = true
     - `/reports/advanced` → requiere `advanced_reports` = true
     - `/audit-logs` → requiere `audit_logs` = true
5. ✅ **Estado de Suscripción:**
   - Si `stripe_status` = `past_due` o `canceled`:
     - Mostrar banner rojo permanente
     - Bloquear creación de nuevos casos
     - Permitir solo lectura y descarga de datos
6. ✅ **Trial Expirado:**
   - Si `trial_ends_at` < NOW() y no hay suscripción activa:
     - Redirigir a página de checkout obligatoriamente
     - Bloquear acceso a toda la app excepto billing

**Notas Técnicas:**
- Crear `TierLimitPolicy` para centralizar validaciones
- Job `CheckExpiredTrials` que corre cada hora
- Incrementar/decrementar contadores con observers en modelos

**Prioridad:** P0 - Sprint 6

---

### US-04: Configuración de Métodos de Pago (Stripe)

**Como** Owner del Despacho,
**Quiero** agregar mi tarjeta de crédito y seleccionar un plan de pago,
**Para** continuar usando la plataforma después del trial.

**Criterios de Aceptación:**

1. ✅ Integración con Laravel Cashier:
   - Formulario de Stripe Elements embebido
   - Selección de plan: Starter Monthly/Yearly, Professional Monthly/Yearly
   - Mostrar descuento del 17% en planes anuales
2. ✅ Al confirmar pago:
   - Crear `subscription` en Stripe
   - Guardar `stripe_id` en `tenants`
   - Crear registro en `subscriptions` con `stripe_status` = `active`
   - Actualizar `subscription_tier_id` si cambió de plan
   - Limpiar `trial_ends_at` (ya no está en trial)
3. ✅ Manejo de webhooks de Stripe:
   - `invoice.payment_succeeded` → mantener status activo
   - `invoice.payment_failed` → cambiar a `past_due`, enviar email
   - `customer.subscription.deleted` → cambiar a `canceled`, bloquear acceso
4. ✅ Owner puede ver:
   - Próxima fecha de cobro
   - Historial de facturas (downloadable)
   - Actualizar método de pago
   - Cancelar suscripción (con confirmación)

**Notas Técnicas:**
- Usar `STRIPE_SECRET_KEY` y `STRIPE_WEBHOOK_SECRET`
- Route `/billing/webhook` para webhooks de Stripe
- Página `/billing/portal` usando Stripe Customer Portal

**Prioridad:** P1 - Sprint 6

---

### US-05: Cambio de Tenant (Multi-Workspace)

**Como** Usuario que pertenece a múltiples despachos,
**Quiero** cambiar entre mis workspaces con un dropdown,
**Para** gestionar casos de diferentes firmas sin cerrar sesión.

**Criterios de Aceptación:**

1. ✅ Si el usuario tiene más de un tenant en `tenant_user`:
   - Mostrar dropdown en navbar con lista de despachos
   - Resaltar el tenant actual con badge
2. ✅ Al seleccionar otro tenant:
   - Guardar en sesión: `current_tenant_id`
   - Recargar página con scope del nuevo tenant
   - Todos los queries automáticamente filtran por nuevo `tenant_id`
3. ✅ Si el usuario tiene un solo tenant:
   - No mostrar dropdown (auto-select)
4. ✅ Global scope en modelos con `TenantScoped` trait:
   - Automáticamente filtrar queries por `tenant_id`
   - Auto-asignar `tenant_id` al crear registros

**Notas Técnicas:**
- Middleware `IdentifyTenant` en todas las rutas web
- Método `setCurrentTenant()` en User model
- Livewire component `TenantSwitcher` en navbar

**Prioridad:** P2 - Sprint 2

---

## Epic 2: Gestión Procesal (Core Legal)

**Objetivo:** Digitalizar la carpeta de investigación penal y su flujo procesal.

**Prioridad:** CRÍTICA (P0) - Core del producto

---

### US-06: Apertura de Nuevo Caso Penal

**Como** Abogado Litigante,
**Quiero** crear un expediente digital con los identificadores oficiales del caso,
**Para** tener un registro centralizado del asunto legal.

**Criterios de Aceptación:**

1. ✅ Formulario de creación de caso solicita:
   - **Folio Interno** (auto-generado o customizable según settings del tenant)
   - **NUC** (Número Único de Caso - asignado por Fiscalía)
   - **Número de Causa Penal** (asignado por Juzgado, opcional al inicio)
   - **Alias del Caso** (ej: "Caso Lozoya", para identificación rápida)
   - **Tipo de Delito** (select desde catálogo precargado)
   - **Clasificación** (doloso/culposo - se autocompleta según delito)
   - **Gravedad** (grave/no_grave - se autocompleta según delito)
   - **Fecha de Inicio** (date picker)
   - **Abogado Responsable** (select de usuarios del tenant con rol litigante/asociado)
   - **Juzgado/Tribunal** (text input)
   - **Juez** (text input)
   - **Ministerio Público** (text input)
2. ✅ Validaciones:
   - `internal_folio` debe ser único dentro del tenant
   - `nuc` debe ser único dentro del tenant (si se proporciona)
   - Verificar límite de casos activos del tier antes de crear
3. ✅ Al guardar:
   - Se crea registro en `cases` con:
     - `id` = ULID
     - `tenant_id` = tenant actual
     - `stage` = `inv_inicial` (por defecto)
     - `status` = `activo`
     - `lead_lawyer_id` = usuario seleccionado
     - `start_date` = fecha seleccionada
   - Se crea automáticamente primer registro en `procedural_stage_history`:
     - `previous_stage` = NULL
     - `new_stage` = `inv_inicial`
     - `reason` = "Apertura de expediente"
4. ✅ Incrementar `current_active_cases_count` del tenant
5. ✅ Redireccionar a vista de detalle del caso

**Notas Técnicas:**
- Livewire component `CreateCaseForm`
- Usar `CasePolicy` para verificar permiso `cases.create`
- Observer `CaseCreated` para crear history entry automático

**Prioridad:** P0 - Sprint 2

---

### US-07: Gestión de Participantes del Caso

**Como** Abogado o Asistente Legal,
**Quiero** registrar a las personas involucradas en el caso (imputados, víctimas, testigos, jueces, peritos),
**Para** tener un directorio completo y vincularlos a actuaciones.

**Criterios de Aceptación:**

1. ✅ **Creación de Participante:**
   - Formulario modal dentro del caso
   - Campos:
     - Tipo: `fisica`, `moral` (persona moral/empresa), `autoridad`
     - Nombre completo / Razón Social
     - RFC (opcional, validado con formato)
     - CURP (solo personas físicas, validado)
     - Género (masculino/femenino/otro - solo físicas)
     - Fecha de nacimiento (solo físicas)
     - Datos de contacto (JSON): email, teléfono, dirección
     - Notas
   - Buscar si ya existe participante con mismo nombre/RFC en el tenant (evitar duplicados)
   - Opción de "Usar existente" o "Crear nuevo"
2. ✅ **Vinculación al Caso:**
   - Al agregar participante al caso, solicitar:
     - Rol en este caso: `imputado`, `victima`, `testigo`, `perito`, `juez_control`, `juez_juicio`, `mp`, `defensor`
     - Alias en el caso (opcional, ej: "El Chapo")
     - Si es imputado: checkbox `is_detained` (¿Está detenido?)
     - Si es imputado: Nombre del abogado defensor (si es contraparte)
   - Crear registro en `case_participant`
3. ✅ **Reutilización:**
   - Mostrar autocompletar al escribir nombre
   - Si ya existe en `participants` del tenant, auto-rellenar datos
   - Un mismo participante puede estar en múltiples casos con roles diferentes
4. ✅ **Vista en Caso:**
   - Tabla de participantes agrupados por rol
   - Badge visual si está detenido
   - Acciones: Editar, Eliminar (del caso, no del sistema)

**Notas Técnicas:**
- Livewire component `ParticipantManager`
- JSON casting para `contact_details`
- Soft delete en `participants` pero hard delete en `case_participant`

**Prioridad:** P0 - Sprint 2

---

### US-08: Transición de Etapa Procesal con Historial

**Como** Abogado Senior,
**Quiero** cambiar la etapa procesal del caso (ej: de Investigación Complementaria a Intermedia) registrando el motivo legal,
**Para** reflejar el avance real del proceso y mantener trazabilidad histórica.

**Criterios de Aceptación:**

1. ✅ **Acción "Avanzar Etapa":**
   - Botón prominente en vista de caso
   - Solo visible para usuarios con permiso `cases.edit`
2. ✅ **Modal de Transición:**
   - Mostrar etapa actual
   - Dropdown con etapas válidas según el flujo:
     - `inv_inicial` → `inv_complementaria`, `intermedia`, `solucion_alterna`
     - `inv_complementaria` → `intermedia`, `solucion_alterna`
     - `intermedia` → `juicio`
     - `juicio` → `ejecucion`, `solucion_alterna`
   - Campo obligatorio "Razón del cambio" (ej: "Auto de Vinculación a Proceso emitido el 15/11/2025")
   - Opción de cambiar también el status del caso si aplica
3. ✅ **Al confirmar:**
   - Actualizar `stage` en tabla `cases`
   - Crear registro **inmutable** en `procedural_stage_history`:
     - `previous_stage` = etapa anterior
     - `new_stage` = nueva etapa
     - `previous_status` = status anterior
     - `new_status` = nuevo status
     - `reason` = texto ingresado
     - `changed_by` = usuario actual
     - `created_at` = timestamp exacto
4. ✅ **Validaciones:**
   - No permitir saltos ilógicos (ej: Investigación Inicial → Ejecución directamente)
   - Mostrar warning si se intenta retroceder etapa (permitir con confirmación)
5. ✅ **Vista de Historial:**
   - Pestaña "Historial de Etapas" en detalle del caso
   - Timeline visual con todas las transiciones
   - Mostrar: Fecha, Usuario, Etapa Anterior → Nueva, Razón

**Notas Técnicas:**
- Service class `CaseStageService` para lógica de transiciones
- Event `CaseStageChanged` para hooks futuros
- No permitir edición de `procedural_stage_history` (inmutable)

**Prioridad:** P0 - Sprint 3

---

### US-09: Dashboard del Caso (Vista Integral)

**Como** Abogado asignado a un caso,
**Quiero** ver toda la información del caso en una sola pantalla organizada por secciones,
**Para** tener contexto completo antes de tomar decisiones.

**Criterios de Aceptación:**

1. ✅ **Header del Caso:**
   - Folio interno + NUC
   - Alias del caso
   - Badge de etapa procesal (con color según etapa)
   - Badge de status (activo/suspendido/cerrado)
   - Tipo de delito
   - Fecha de inicio
   - Abogado responsable (con avatar)
2. ✅ **Tabs principales:**
   - **Resumen:** Información general del caso
   - **Participantes:** Tabla de imputados, víctimas, testigos
   - **Audiencias:** Calendario y lista de audiencias
   - **Plazos:** Deadlines próximos a vencer
   - **Evidencias:** Listado de evidencias con estado
   - **Documentos:** Repositorio de archivos
   - **Medidas Cautelares:** Si hay imputados con medidas
   - **Soluciones Alternas:** Si aplica
   - **Actuaciones:** Timeline de actividades
   - **Historial:** Cambios de etapa
3. ✅ **Sidebar de Acciones Rápidas:**
   - Nueva Audiencia
   - Nuevo Plazo
   - Subir Documento
   - Registrar Actuación
   - Avanzar Etapa
   - Editar Caso
   - Cerrar Caso (con modal de confirmación)
4. ✅ **Alertas Contextuales:**
   - Mostrar alerta roja si hay plazos fatales próximos (< 3 días)
   - Mostrar warning si caso lleva más de 6 meses en investigación complementaria
   - Mostrar info si hay audiencia en próximas 48 horas

**Notas Técnicas:**
- Livewire component `CaseDetailPage` con sub-components
- Eager loading de relaciones para performance
- Cache de contadores (audiencias pendientes, documentos, etc.)

**Prioridad:** P0 - Sprint 3

---

### US-10: Listado y Filtrado de Casos

**Como** Usuario del despacho,
**Quiero** ver todos los casos del despacho con filtros avanzados,
**Para** encontrar rápidamente el expediente que necesito.

**Criterios de Aceptación:**

1. ✅ **Vista de Tabla:**
   - Columnas: Folio, NUC, Alias, Delito, Etapa, Status, Abogado, Fecha Inicio
   - Sorteable por cualquier columna
   - Paginación de 25 registros
2. ✅ **Filtros:**
   - Buscador de texto libre (busca en: folio, NUC, alias, delito)
   - Filtro por etapa procesal (multi-select)
   - Filtro por status (multi-select)
   - Filtro por abogado responsable (multi-select)
   - Filtro por rango de fechas
   - Filtro por tipo de delito
3. ✅ **Vistas Guardadas:**
   - "Mis Casos" (donde soy lead_lawyer o assigned_to)
   - "Casos Activos" (status = activo)
   - "Próximos a Juicio" (stage = juicio)
   - "Investigación Complementaria" (stage = inv_complementaria)
4. ✅ **Acciones en Tabla:**
   - Click en fila → Ir a detalle del caso
   - Menú de 3 puntos: Editar, Archivar, Ver Historial

**Notas Técnicas:**
- Livewire component `CasesTable` con `WithPagination`, `WithSorting`
- Query scopes en `Case` model para filtros
- Session storage para recordar filtros aplicados

**Prioridad:** P0 - Sprint 3

---

## Epic 3: Agenda y Tiempos (Audiencias y Plazos)

**Objetivo:** Evitar la pérdida de términos fatales y mantener agenda organizada.

**Prioridad:** ALTA (P1)

---

### US-11: Programación de Audiencias

**Como** Abogado,
**Quiero** agendar una audiencia vinculada a un caso específico,
**Para** que aparezca en mi calendario y reciba recordatorios oportunos.

**Criterios de Aceptación:**

1. ✅ **Formulario de Audiencia:**
   - Caso vinculado (pre-seleccionado si viene desde detalle de caso)
   - Tipo de audiencia (select):
     - Audiencia Inicial
     - Vinculación a Proceso
     - Audiencia Intermedia
     - Juicio Oral
     - Revisión de Medidas Cautelares
     - Otra (texto libre)
   - Fecha y Hora (datetime picker)
   - Duración estimada (en minutos, opcional)
   - Sala/Juzgado (text input)
   - Link de videoconferencia (URL, opcional - para audiencias virtuales)
   - Juez que preside (select de participantes tipo `juez_control` o `juez_juicio`)
   - Notas previas (textarea)
2. ✅ **Validaciones:**
   - Fecha no puede ser en el pasado
   - Mostrar warning si hay conflicto de horario para el abogado asignado al caso
3. ✅ **Al guardar:**
   - Crear registro en `hearings`
   - Status inicial = `programada`
   - Crear automáticamente deadline de recordatorio:
     - Título: "Audiencia: [tipo]"
     - `expires_at` = fecha de audiencia
     - `is_fatal` = true
     - Alertas en: 7 días, 3 días, 1 día, mismo día
4. ✅ **Notificaciones:**
   - Email al lead_lawyer del caso
   - Email a todos los usuarios con permiso de ver el caso (opcional)

**Notas Técnicas:**
- Livewire component `HearingForm`
- Integración con Google Calendar API (v2.0)
- Observer `HearingCreated` para crear deadline automático

**Prioridad:** P1 - Sprint 4

---

### US-12: Registro de Resultado de Audiencia

**Como** Litigante que asistió a la audiencia,
**Quiero** registrar qué sucedió y qué se acordó,
**Para** mantener el expediente actualizado y generar los siguientes pasos.

**Criterios de Aceptación:**

1. ✅ **Botón "Registrar Resultado":**
   - Visible solo en audiencias con status `programada`
   - Solo usuarios que asistieron o lead_lawyer pueden completar
2. ✅ **Modal de Resultado:**
   - Cambiar status a:
     - `celebrada` (se realizó normalmente)
     - `cancelada` (no se realizó)
     - `reprogramada` (se difirió)
   - Campo obligatorio: Resumen de acuerdos/resoluciones (WYSIWYG editor)
   - Opción de agregar documentos adjuntos (ej: acta de audiencia)
   - Si fue `reprogramada`:
     - Mostrar botón "Crear Nueva Audiencia" que clona datos básicos
     - Campo de nueva fecha/hora
3. ✅ **Si la audiencia fue de Vinculación a Proceso:**
   - Checkbox: "¿Se vinculó a proceso?"
   - Si SÍ: Sugerir avanzar caso a etapa `inv_complementaria` automáticamente
   - Solicitar fecha de cierre de investigación complementaria para crear deadline
4. ✅ **Si la audiencia fue Intermedia:**
   - Checkbox: "¿Se emitió Auto de Apertura a Juicio?"
   - Si SÍ: Sugerir avanzar a etapa `juicio`
5. ✅ **Registro de asistentes:**
   - Multi-select de usuarios del despacho que asistieron
   - Guardar en campo JSON `attended_by`

**Notas Técnicas:**
- Livewire component `HearingResultForm`
- Trigger automático de sugerencias de transición de etapa
- Adjuntar documentos usando relación polimórfica

**Prioridad:** P1 - Sprint 4

---

### US-13: Calendario de Audiencias del Despacho

**Como** Miembro del despacho,
**Quiero** ver todas las audiencias en un calendario mensual,
**Para** coordinar agendas y evitar conflictos.

**Criterios de Aceptación:**

1. ✅ **Vista de Calendario:**
   - Librería FullCalendar.js integrada con Livewire
   - Vista mensual por defecto (con opción de semana/día)
   - Eventos de audiencias con código de color:
     - Verde: `programada`
     - Gris: `celebrada`
     - Rojo: `cancelada`
     - Naranja: `reprogramada`
2. ✅ **Información del Evento:**
   - Título: Tipo de audiencia + Alias del caso
   - Hora de inicio
   - Sala/Link virtual
   - Al hacer click: modal con detalles completos
3. ✅ **Filtros:**
   - Ver solo mis audiencias (donde soy assigned_to)
   - Ver todas las del despacho
   - Filtrar por tipo de audiencia
   - Filtrar por abogado responsable
4. ✅ **Acciones:**
   - Click en fecha vacía → Crear nueva audiencia
   - Drag & drop para re-agendar (con confirmación)
   - Click en evento → Ver detalles / Editar / Registrar resultado

**Notas Técnicas:**
- Livewire component `HearingsCalendar`
- API endpoint `/api/hearings/calendar` que devuelve JSON de eventos
- Usar FullCalendar v6

**Prioridad:** P1 - Sprint 4

---

### US-14: Configuración de Plazos Fatales (Deadlines)

**Como** Abogado,
**Quiero** crear plazos procesales vinculados a casos o audiencias,
**Para** asegurar que no se pierda ningún término.

**Criterios de Aceptación:**

1. ✅ **Formulario de Deadline:**
   - Caso vinculado (obligatorio)
   - Audiencia vinculada (opcional - si deriva de una)
   - Título del plazo (ej: "Cierre de Investigación Complementaria", "Plazo para Presentar Amparo")
   - Descripción detallada (textarea)
   - Fecha y hora de vencimiento (datetime picker)
   - Checkbox: ¿Es término fatal? (impacta color de alerta)
   - Configuración de alertas (checkboxes):
     - 7 días antes
     - 3 días antes
     - 1 día antes
     - El mismo día
     - Custom (input de días)
   - Guardar como JSON en `reminder_config`
2. ✅ **Validaciones:**
   - Fecha de vencimiento no puede ser en el pasado
   - Si es fatal, obligar al menos una alerta
3. ✅ **Al guardar:**
   - Crear registro en `deadlines`
   - Status inicial = `pendiente`
4. ✅ **Acciones:**
   - Marcar como cumplido (cambia status a `cumplido`, registra `completed_at` y `completed_by`)
   - Extender plazo (editar fecha, registrar en audit log)
   - Eliminar (soft delete)

**Notas Técnicas:**
- Livewire component `DeadlineForm`
- Policy `DeadlinePolicy` para verificar permisos
- Observer para registrar cambios en audit log

**Prioridad:** P1 - Sprint 4

---

### US-15: Sistema de Alertas y Notificaciones de Plazos

**Como** Usuario del sistema,
**Quiero** recibir notificaciones automáticas sobre plazos próximos a vencer,
**Para** tomar acción antes de que sea tarde.

**Criterios de Aceptación:**

1. ✅ **Job Programado:**
   - `CheckDeadlinesJob` corre diariamente a las 8:00 AM
   - Consulta `deadlines` donde:
     - `status` = `pendiente`
     - `expires_at` está dentro del rango de alerta configurado
2. ✅ **Lógica de Notificación:**
   - Para cada deadline que cumple condición:
     - Calcular días restantes
     - Verificar si hay que notificar según `reminder_config`
     - Si SÍ: Enviar notificación
3. ✅ **Canales de Notificación:**
   - Email al `lead_lawyer_id` del caso
   - Notificación in-app (bell icon en navbar)
   - Opcional (v2.0): SMS si es término fatal < 24h
4. ✅ **Contenido de Notificación:**
   - Título del plazo
   - Caso vinculado
   - Días/horas restantes
   - Clasificación: Fatal o Normal
   - Link directo al caso
5. ✅ **Dashboard Widget:**
   - Widget en home que muestra "Plazos Próximos" (< 7 días)
   - Ordenados por urgencia (fatales primero)
   - Color coding: Rojo (< 1 día), Naranja (< 3 días), Amarillo (< 7 días)

**Notas Técnicas:**
- Laravel Notification system
- Queue `notifications` para envío asíncrono
- Tabla `notifications` para in-app notifications

**Prioridad:** P1 - Sprint 4

---

## Epic 4: Evidencias y Cadena de Custodia

**Objetivo:** Garantizar integridad probatoria con trazabilidad rigurosa.

**Prioridad:** ALTA (P1)

---

### US-16: Registro de Evidencia Material/Digital

**Como** Encargado de Evidencias o Abogado,
**Quiero** dar de alta un objeto o documento físico como "Evidencia" con un folio de cadena de custodia,
**Para** iniciar su trazabilidad legal.

**Criterios de Aceptación:**

1. ✅ **Formulario de Evidencia:**
   - Caso vinculado (obligatorio)
   - Folio de Cadena de Custodia (auto-generado o manual)
   - Descripción del objeto (ej: "Arma de fuego calibre 9mm", "iPhone 12 Pro Max")
   - Tipo de evidencia (select):
     - Arma
     - Documento Original
     - Dispositivo Electrónico
     - Biológico (sangre, cabello, etc.)
     - Droga
     - Dinero/Valores
     - Otro
   - Ubicación física inicial (ej: "Caja Fuerte 1 - Oficina", "Bodega de Evidencias")
   - Fecha y hora de recolección
   - Quién recolectó (autoridad - text input)
   - Notas adicionales
2. ✅ **Validaciones:**
   - `chain_of_custody_folio` debe ser único dentro del tenant
   - Todos los campos obligatorios excepto notas
3. ✅ **Al guardar:**
   - Crear registro en `evidence`
   - Status inicial = `en_custodia`
   - Crear automáticamente primer registro en `chain_of_custody_entries`:
     - `movement_at` = fecha de recolección
     - `given_by` = quien recolectó
     - `received_by` = despacho/usuario actual
     - `reason` = "Recepción inicial de evidencia"
     - `location` = ubicación inicial
4. ✅ **Opción de adjuntar fotos:**
   - Permitir subir imágenes de la evidencia
   - Guardar como `documents` polimórficos vinculados a la evidencia

**Notas Técnicas:**
- Livewire component `EvidenceForm`
- Auto-generador de folios: `EV-{YEAR}-{CASE_ID}-{SEQUENCE}`
- Observer `EvidenceCreated` para crear primer custody entry

**Prioridad:** P1 - Sprint 5

---

### US-17: Registro de Movimiento de Cadena de Custodia

**Como** Usuario que entrega/recibe una evidencia,
**Quiero** registrar el traspaso con datos de quién entrega, quién recibe y el motivo,
**Para** mantener la integridad de la cadena de custodia.

**Criterios de Aceptación:**

1. ✅ **Acción "Registrar Movimiento":**
   - Botón en detalle de evidencia
   - Solo usuarios con permiso `evidence.custody_manage`
2. ✅ **Formulario de Movimiento:**
   - Fecha y hora del movimiento (datetime picker, default: ahora)
   - Quien entrega:
     - Nombre completo (text input)
     - Placa/Identificación oficial (opcional)
   - Quien recibe:
     - Nombre completo (text input)
     - Placa/Identificación oficial (opcional)
   - Motivo del movimiento (select + text):
     - Traslado a Peritaje
     - Entrega a Fiscalía
     - Entrega a Juzgado
     - Devolución a propietario
     - Destrucción autorizada
     - Otro (especificar)
   - Nueva ubicación física (text input)
   - Condición de la evidencia (ej: "Intacta", "Dañada", "Abierta")
3. ✅ **Al guardar:**
   - Crear registro **inmutable** en `chain_of_custody_entries`
   - Actualizar automáticamente en `evidence`:
     - `current_location` = nueva ubicación
     - `status` = según el motivo:
       - "Traslado a Peritaje" → `en_fiscalia`
       - "Entrega a Juzgado" → `en_juzgado`
       - "Devolución" → `devuelto`
       - "Destrucción" → `destruido`
4. ✅ **Vista de Historial:**
   - Pestaña "Cadena de Custodia" en detalle de evidencia
   - Timeline cronológico con todos los movimientos
   - Mostrar: Fecha, De → A, Motivo, Ubicación
   - Exportable a PDF (para presentar en juicio)
5. ✅ **Restricciones:**
   - No permitir editar o eliminar registros de `chain_of_custody_entries` (inmutable)
   - Mostrar warning si se intenta mover evidencia con status `destruido`

**Notas Técnicas:**
- Livewire component `CustodyMovementForm`
- Policy `EvidencePolicy` con método `manageCustody()`
- PDF generator usando Laravel DOMPDF

**Prioridad:** P1 - Sprint 5

---

### US-18: Listado y Búsqueda de Evidencias

**Como** Usuario del despacho,
**Quiero** ver todas las evidencias del despacho con filtros,
**Para** localizar rápidamente un objeto específico.

**Criterios de Aceptación:**

1. ✅ **Vista de Tabla:**
   - Columnas: Folio, Caso, Descripción, Tipo, Ubicación Actual, Status, Última Actualización
   - Sorteable y paginada
2. ✅ **Filtros:**
   - Buscador (busca en folio, descripción, tipo)
   - Filtro por caso
   - Filtro por tipo de evidencia
   - Filtro por status
   - Filtro por ubicación actual
3. ✅ **Vistas Guardadas:**
   - "En Custodia del Despacho"
   - "En Fiscalía"
   - "En Juzgado"
4. ✅ **Acciones:**
   - Ver Detalle
   - Registrar Movimiento
   - Ver Cadena de Custodia

**Notas Técnicas:**
- Livewire component `EvidenceTable`
- Eager loading de relación `case`

**Prioridad:** P2 - Sprint 5

---

## Epic 5: Gestión Documental

**Objetivo:** Repositorio digital centralizado y organizado.

**Prioridad:** ALTA (P1)

---

### US-19: Carga y Clasificación de Documentos

**Como** Paralegal o Abogado,
**Quiero** subir archivos digitales al caso categorizándolos,
**Para** tener respaldo digital del expediente físico.

**Criterios de Aceptación:**

1. ✅ **Drag & Drop Upload:**
   - Componente de drag & drop en detalle de caso
   - Soportar múltiples archivos simultáneos
   - Preview de archivos antes de subir
2. ✅ **Formulario de Documento:**
   - Título del documento (texto libre o auto-detect del filename)
   - Descripción (textarea, opcional)
   - Categoría (select):
     - Sentencia
     - Auto
     - Acuerdo
     - Promoción
     - Oficio
     - Acta
     - Amparo
     - Evidencia Documental
     - Otro
   - Tags (input de chips, ej: "urgente", "confidencial", "público")
   - Checkbox: ¿Compartir con cliente? (solo si tier tiene feature `client_portal`)
3. ✅ **Validaciones:**
   - Tipos de archivo permitidos: PDF, DOCX, XLSX, JPG, PNG, ZIP
   - Tamaño máximo por archivo: 10 MB (Starter) / 25 MB (Professional)
   - Verificar que `current_storage_usage_bytes + file_size < max_storage_gb`
4. ✅ **Al subir:**
   - Upload a S3/MinIO con path: `tenants/{tenant_id}/cases/{case_id}/documents/{ulid}.{ext}`
   - Crear registro en `documents`:
     - `documentable_type` = `App\Models\Case`
     - `documentable_id` = case_id
     - Guardar metadata: `file_path`, `file_name`, `mime_type`, `size_bytes`
   - Incrementar `current_storage_usage_bytes` del tenant
   - Registrar en `audit_logs` (quien subió, cuándo)
5. ✅ **Vista de Documentos:**
   - Grid view con thumbnails (usar preview de S3)
   - List view con detalles
   - Filtros por categoría, tags, fecha de subida
   - Buscador de texto en título/descripción

**Notas Técnicas:**
- Livewire component `DocumentUploader` con FilePond.js
- Laravel Storage con driver S3
- Queue job para generar thumbnails de PDFs (v2.0)

**Prioridad:** P1 - Sprint 5

---

### US-20: Visualización y Descarga de Documentos

**Como** Usuario del despacho,
**Quiero** ver y descargar documentos del caso,
**Para** revisarlos o compartirlos externamente.

**Criterios de Aceptación:**

1. ✅ **Visualizador Embebido:**
   - Para PDFs: Renderizar con PDF.js en modal fullscreen
   - Para imágenes: Lightbox
   - Para Office docs: Botón de descarga (preview en v2.0)
2. ✅ **Descarga:**
   - Botón "Descargar" genera signed URL temporal (válido 5 min)
   - Registrar descarga en `audit_logs` (quien, cuándo)
3. ✅ **Compartir:**
   - Botón "Copiar Link" genera signed URL temporal (válido 24h)
   - Solo si tier tiene feature `document_sharing` (Professional)
4. ✅ **Acciones:**
   - Editar metadata (título, categoría, tags)
   - Eliminar (soft delete, con confirmación)
   - Mover a otro caso (con confirmación, actualizar `documentable_id`)

**Notas Técnicas:**
- Laravel signed URLs para seguridad
- Policy `DocumentPolicy` para verificar acceso
- Audit log automático en descarga

**Prioridad:** P1 - Sprint 5

---

### US-21: Asociación de Documentos a Entidades Específicas

**Como** Usuario del despacho,
**Quiero** adjuntar documentos específicamente a una Audiencia, Evidencia o Actividad,
**Para** mantener el contexto preciso (ej: acta de audiencia vinculada al evento del calendario).

**Criterios de Aceptación:**

1. ✅ **Upload Contextual:**
   - En detalle de Audiencia: Botón "Adjuntar Acta"
   - En detalle de Evidencia: Botón "Adjuntar Foto"
   - En formulario de Actividad: Botón "Adjuntar Archivo"
2. ✅ **Uso de Polimorfismo:**
   - Al subir, establecer:
     - `documentable_type` = `App\Models\Hearing` (o `Evidence`, `Activity`)
     - `documentable_id` = ID de la entidad
3. ✅ **Vista en Entidad:**
   - En detalle de Audiencia: Sección "Documentos Adjuntos"
   - Mostrar solo documentos vinculados a esa audiencia específica
4. ✅ **Búsqueda Global:**
   - En buscador de documentos, poder filtrar por tipo de entidad
   - Ver documentos de "Todas las Audiencias" o "Todas las Evidencias"

**Notas Técnicas:**
- Relación `morphMany` en modelos `Hearing`, `Evidence`, `Activity`
- Mismo componente `DocumentUploader` reutilizable con parámetros

**Prioridad:** P2 - Sprint 5

---

## Epic 6: Especialización CNPP (Medidas y Soluciones)

**Objetivo:** Cubrir casos de uso específicos del sistema penal acusatorio.

**Prioridad:** MEDIA (P2)

---

### US-22: Control de Medidas Cautelares

**Como** Abogado Defensor,
**Quiero** registrar las medidas cautelares impuestas a mi cliente con sus fechas de revisión,
**Para** gestionar su cumplimiento o solicitar su revocación a tiempo.

**Criterios de Aceptación:**

1. ✅ **Formulario de Medida Cautelar:**
   - Caso vinculado
   - Participante (select de participantes con rol `imputado` del caso)
   - Tipo de medida (select desde catálogo):
     - Presentación periódica ante autoridad
     - Exhibición de garantía económica
     - Embargo de bienes
     - Inmovilización de cuentas bancarias
     - Prohibición de salir del país
     - Prohibición de salir de circunscripción geográfica
     - Prohibición de concurrir a determinados lugares
     - Prohibición de comunicarse con víctimas/testigos
     - Separación inmediata del domicilio
     - Suspensión de derechos (patria potestad, etc.)
     - Internamiento en centro de adicciones
     - Colocación de localizador electrónico
     - Resguardo domiciliario
     - Prisión preventiva
   - Descripción específica de la medida (textarea)
   - Fecha de imposición (date picker)
   - Juez que la impuso (text input)
   - Fecha de revisión obligatoria (date picker - obligatorio si es prisión preventiva)
   - Fecha de expiración (date picker, opcional)
2. ✅ **Validaciones:**
   - Si tipo = "Prisión Preventiva":
     - `review_date` es obligatorio (CNPP establece revisión cada 2 años máximo)
     - Crear deadline automático en `review_date` - 30 días para preparar solicitud
3. ✅ **Al guardar:**
   - Crear registro en `precautionary_measures`
   - Status inicial = `vigente`
   - Si hay `review_date`, crear deadline de alerta
4. ✅ **Acciones:**
   - Modificar medida (registrar en audit log)
   - Revocar medida (cambiar status a `revocada`, solicitar `revoked_reason`)
   - Marcar como cumplida

**Notas Técnicas:**
- Livewire component `PrecautionaryMeasureForm`
- Seeder `PrecautionaryMeasureTypesSeeder` para catálogo
- Observer para crear deadline automático si aplica

**Prioridad:** P2 - Sprint 7

---

### US-23: Gestión de Soluciones Alternas

**Como** Abogado,
**Quiero** registrar un Acuerdo Reparatorio, Suspensión Condicional o Procedimiento Abreviado,
**Para** monitorear que el cliente cumpla las condiciones y se extinga la acción penal.

**Criterios de Aceptación:**

1. ✅ **Formulario de Solución Alterna:**
   - Caso vinculado
   - Tipo de solución (select):
     - Acuerdo Reparatorio
     - Suspensión Condicional del Proceso
     - Procedimiento Abreviado
   - Fecha de propuesta (date picker)
   - Fecha de aprobación judicial (date picker, opcional)
   - Juez que aprobó (text input, opcional)
   - Condiciones específicas (WYSIWYG editor):
     - Para Acuerdo Reparatorio: Monto de reparación, forma de pago, disculpa pública, etc.
     - Para Suspensión Condicional: Reparación del daño, servicios comunitarios, terapias, no delinquir, etc.
     - Para Abreviado: Aceptación de hechos, reducción de pena aplicada
   - Fecha límite de cumplimiento (date picker)
2. ✅ **Al guardar:**
   - Crear registro en `alternative_solutions`
   - Status inicial = `propuesta` (cambia a `aprobada` cuando se ingresa fecha de aprobación)
   - Si hay `compliance_deadline`, crear deadline de alerta 30 días antes
3. ✅ **Checklist de Cumplimiento:**
   - Permitir convertir las condiciones en checklist interactivo
   - Cada ítem puede marcarse como cumplido (con fecha y evidencia opcional)
4. ✅ **Acciones:**
   - Marcar como cumplida (status = `cumplida`, requiere que todas las condiciones checklist estén OK)
   - Revocar (status = `revocada`, solicitar `revoked_reason`)
   - Editar condiciones (registrar cambio en audit log)
5. ✅ **Efecto en el Caso:**
   - Si solución es aprobada y cumplida:
     - Sugerir cambiar status del caso a `cerrado` (extinción de acción penal)

**Notas Técnicas:**
- Livewire component `AlternativeSolutionForm`
- WYSIWYG editor: TipTap o CKEditor
- Checklist dinámico almacenado en JSON adicional (opcional)

**Prioridad:** P2 - Sprint 7

---

## Epic 7: Seguridad y Auditoría

**Objetivo:** Confianza corporativa y cumplimiento normativo.

**Prioridad:** MEDIA (P2) - Solo en tier Professional

---

### US-24: Bitácora de Actividades (Audit Trail)

**Como** Owner del Despacho (tier Professional),
**Quiero** ver quién creó, modificó o eliminó elementos sensibles en un caso,
**Para** supervisar a mi equipo y detectar errores o malas prácticas.

**Criterios de Aceptación:**

1. ✅ **Feature Flag:**
   - Solo disponible si `tenant.tier.features.audit_logs = true`
   - Mostrar upgrade message si tier es Starter
2. ✅ **Observers en Modelos Críticos:**
   - `Case`: created, updated, deleted, restored
   - `Evidence`: created, updated, deleted, custody movements
   - `Hearing`: created, updated, deleted, result registered
   - `Document`: uploaded, deleted, downloaded
   - `PrecautionaryMeasure`: created, updated, revoked
   - `AlternativeSolution`: created, updated, completed, revoked
3. ✅ **Datos Registrados:**
   - Evento (created/updated/deleted/etc.)
   - Usuario que realizó la acción
   - Timestamp exacto
   - IP address
   - User agent
   - Valores anteriores (JSON)
   - Valores nuevos (JSON)
   - Descripción legible (ej: "Eduardo Ramírez eliminó la evidencia EV-2025-001")
4. ✅ **Vista de Audit Logs:**
   - Pestaña "Historial de Cambios" en detalle de caso
   - Tabla con: Fecha, Usuario, Acción, Entidad, Descripción
   - Filtros: Por usuario, por tipo de evento, por entidad
   - Expandible para ver diff de cambios (old_values vs new_values)
5. ✅ **Acceso Restringido:**
   - Solo usuarios con rol `owner` pueden ver logs
   - Opcional: Rol específico `auditor`

**Notas Técnicas:**
- Usar Spatie Laravel Activitylog package
- Tabla `audit_logs` con índices optimizados
- JSON diff viewer en frontend

**Prioridad:** P2 - Sprint 8 (solo Professional)

---

### US-25: Gestión de Roles y Permisos (RBAC)

**Como** Owner del Despacho,
**Quiero** asignar roles específicos a mi equipo y customizar permisos,
**Para** restringir acciones sensibles como eliminar casos o cambiar etapas.

**Criterios de Aceptación:**

1. ✅ **Roles Base (pre-configurados):**
   - **Owner:** Acceso total, puede gestionar suscripción y equipo
   - **Litigante:** Puede crear/editar/eliminar casos, avanzar etapas, todo lo legal
   - **Asociado:** Puede crear/editar casos asignados, no puede eliminar ni cambiar etapas críticas
   - **Paralegal:** Puede subir documentos, registrar actuaciones, no puede modificar datos del caso
   - **Administrativo:** Solo lectura de casos, puede gestionar calendario
   - **Cliente:** Solo lectura de sus casos (si tier tiene portal de clientes)
2. ✅ **Matriz de Permisos:**
   - Implementar con Spatie Permission package
   - 40+ permisos granulares (ver doc de arquitectura sección 4.3)
3. ✅ **Vista de Gestión de Equipo:**
   - Tabla de miembros del despacho
   - Columnas: Nombre, Email, Rol, Status, Fecha de Ingreso
   - Acción: Cambiar Rol (dropdown)
   - Acción: Desactivar/Reactivar usuario
   - Acción: Eliminar del despacho (con confirmación)
4. ✅ **Validación en Capa de Aplicación:**
   - Policies de Laravel para cada modelo
   - Middleware en rutas sensibles
   - Validación en Livewire actions
5. ✅ **Custom Permissions (v2.0):**
   - Permitir al Owner customizar permisos de un rol específico
   - Checkbox matrix de permisos

**Notas Técnicas:**
- Spatie Laravel Permission con soporte de teams (`team_id`)
- Seeders para roles y permisos base
- Gate definitions en `AuthServiceProvider`

**Prioridad:** P1 - Sprint 2 (roles base) / P3 - Sprint 9 (custom permissions)

---

## Epic 8: Actuaciones Diarias

**Objetivo:** CRM legal básico - registro de gestiones cotidianas.

**Prioridad:** MEDIA (P2)

---

### US-26: Registro de Bitácora de Actuaciones

**Como** Abogado o Asistente,
**Quiero** registrar notas rápidas sobre llamadas, correos, visitas, reuniones,
**Para** que todo el equipo sepa qué gestión se realizó en el caso.

**Criterios de Aceptación:**

1. ✅ **Formulario Rápido de Actuación:**
   - Caso vinculado (pre-seleccionado si viene desde detalle)
   - Tipo de actividad (select):
     - Llamada Telefónica
     - Email
     - Reunión con Cliente
     - Visita a Juzgado
     - Presentación de Escrito
     - Diligencia
     - Visita Carcelaria
     - Otro
   - Título breve (text input, ej: "Llamada con testigo Juan Pérez")
   - Descripción detallada (WYSIWYG editor)
   - Fecha y hora de realización (datetime picker, default: ahora)
   - Duración (en minutos, opcional - para tracking de tiempo billable en v2.0)
   - Adjuntar archivos (opcional)
2. ✅ **Al guardar:**
   - Crear registro en `activities`
   - `performed_by` = usuario actual
   - Si hay archivos adjuntos, usar relación polimórfica con `documents`
3. ✅ **Timeline de Actividades:**
   - En detalle de caso, pestaña "Actuaciones"
   - Vista de timeline cronológico descendente (más reciente primero)
   - Cada entrada muestra:
     - Avatar del usuario
     - Tipo de actividad (con icon)
     - Título
     - Descripción (collapsible si es muy largo)
     - Fecha/hora relativa ("hace 2 horas")
     - Archivos adjuntos (si hay)
   - Filtros: Por tipo de actividad, por usuario, por rango de fechas
4. ✅ **Acciones:**
   - Editar (solo quien creó la actividad o owner)
   - Eliminar (soft delete, solo owner)
   - Compartir (copiar link)

**Notas Técnicas:**
- Livewire component `ActivityForm` y `ActivityTimeline`
- Usar Carbon `diffForHumans()` para timestamps relativos
- Infinite scroll en timeline (pagination)

**Prioridad:** P2 - Sprint 7

---

### US-27: Filtro de Actividades por Usuario

**Como** Owner o Litigante Senior,
**Quiero** ver todas las actuaciones realizadas por un miembro específico del equipo,
**Para** supervisar su productividad y calidad de trabajo.

**Criterios de Aceptación:**

1. ✅ **Vista "Mis Actuaciones":**
   - Página dedicada `/activities/mine`
   - Listado de todas las actividades donde `performed_by` = usuario actual
   - Agrupadas por caso
   - Métricas: Total de actuaciones este mes, promedio por día
2. ✅ **Vista "Actuaciones del Equipo":**
   - Página `/activities/team` (solo para owners/litigantes)
   - Filtro por miembro del equipo
   - Filtro por tipo de actividad
   - Filtro por rango de fechas
   - Exportable a Excel (v2.0)
3. ✅ **Dashboard Widget:**
   - Widget en home: "Actividad Reciente del Equipo"
   - Últimas 5 actuaciones de cualquier miembro
   - Link a vista completa

**Notas Técnicas:**
- Query scopes en `Activity` model
- Livewire component `ActivitiesTable`

**Prioridad:** P3 - Sprint 8

---

## Epic 9: Reportes y Dashboard

**Objetivo:** Visibilidad y métricas del despacho.

**Prioridad:** MEDIA (P2)

---

### US-28: Dashboard Ejecutivo del Despacho

**Como** Owner o Litigante,
**Quiero** ver un dashboard con KPIs principales del despacho,
**Para** tener visibilidad del estado general de la firma.

**Criterios de Aceptación:**

1. ✅ **KPIs Principales (Cards):**
   - Total de Casos Activos
   - Casos en Juicio (críticos)
   - Plazos Próximos a Vencer (< 7 días)
   - Audiencias esta Semana
   - Evidencias en Custodia
   - Documentos Totales
   - Uso de Almacenamiento (progress bar con %)
2. ✅ **Gráficas (Básicas):**
   - **Casos por Etapa:** Pie chart con distribución
   - **Casos por Abogado:** Bar chart horizontal
   - **Audiencias por Mes:** Line chart de tendencia (últimos 6 meses)
3. ✅ **Widgets de Alertas:**
   - "Plazos Fatales" - Lista de términos < 3 días
   - "Audiencias Próximas" - Próximas 3 audiencias
   - "Casos sin Actividad" - Casos que no tienen actuaciones en > 30 días
4. ✅ **Filtros Globales:**
   - Por abogado responsable
   - Por rango de fechas
5. ✅ **Exportar Dashboard:**
   - Botón "Exportar a PDF" (genera snapshot del dashboard)

**Notas Técnicas:**
- Livewire component `DashboardPage`
- Chart.js o ApexCharts para gráficas
- Cache de queries pesadas (refresh cada 15 min)

**Prioridad:** P2 - Sprint 8

---

### US-29: Reportes Avanzados (Tier Professional)

**Como** Owner del Despacho (tier Professional),
**Quiero** generar reportes avanzados con filtros customizables,
**Para** analizar desempeño y tomar decisiones estratégicas.

**Criterios de Aceptación:**

1. ✅ **Feature Flag:**
   - Solo disponible si `tenant.tier.features.advanced_reports = true`
2. ✅ **Tipos de Reportes:**
   - **Reporte de Productividad por Abogado:**
     - Casos gestionados
     - Audiencias asistidas
     - Actuaciones registradas
     - Documentos subidos
     - Rango de fechas seleccionable
   - **Reporte de Casos por Delito:**
     - Tabla con: Tipo de delito, # de casos, % del total, Etapa promedio
   - **Reporte de Tiempos Procesales:**
     - Tiempo promedio en cada etapa
     - Casos que exceden plazos legales
   - **Reporte de Evidencias:**
     - Total por tipo
     - Status actual
     - Movimientos de custodia este mes
3. ✅ **Filtros Avanzados:**
   - Rango de fechas
   - Por abogado
   - Por etapa procesal
   - Por tipo de delito
   - Por status
4. ✅ **Exportación:**
   - PDF (con logo del despacho si tier Professional)
   - Excel (XLSX)
   - CSV
5. ✅ **Programación de Reportes (v2.0):**
   - Enviar reporte por email automáticamente cada semana/mes

**Notas Técnicas:**
- Laravel Excel package para exports
- DOMPDF para PDFs
- Jobs en queue para generación asíncrona de reportes pesados

**Prioridad:** P3 - Sprint 8 (solo Professional)

---

## Epic 10: Portal de Clientes (Tier Professional)

**Objetivo:** Transparencia y comunicación con clientes del despacho.

**Prioridad:** BAJA (P3) - Feature Premium

---

### US-30: Acceso de Cliente a su Caso

**Como** Cliente del Despacho (tier Professional),
**Quiero** ver el estado de mi caso legal en un portal web,
**Para** estar informado sin tener que llamar constantemente al abogado.

**Criterios de Aceptación:**

1. ✅ **Feature Flag:**
   - Solo disponible si `tenant.tier.features.client_portal = true`
2. ✅ **Invitación de Cliente:**
   - Owner/Litigante puede invitar cliente desde detalle de caso
   - Botón "Invitar Cliente al Portal"
   - Email del cliente (asociado a un participante tipo `victima` o creado como usuario)
   - Enviar invitación con credenciales temporales
3. ✅ **Login de Cliente:**
   - URL dedicada: `cliente.qadra.com` o `/portal`
   - Rol especial `cliente` en `tenant_user`
   - Solo puede ver casos donde está vinculado como participante
4. ✅ **Vista de Cliente:**
   - Dashboard simplificado:
     - Resumen del caso (folio, alias, delito, etapa actual, status)
     - Próximas audiencias
     - Documentos compartidos (solo los que tienen `is_shared_with_client = true`)
     - Timeline de actuaciones (filtrado, sin datos internos sensibles)
   - No puede editar nada, solo lectura
5. ✅ **Comunicación:**
   - Sección de "Mensajes" para comunicarse con su abogado
   - Notificación al abogado cuando cliente envía mensaje
   - Cliente puede adjuntar archivos (ej: documentos solicitados)

**Notas Técnicas:**
- Guard separado `client` en autenticación
- Middleware `EnsureIsClient` para rutas del portal
- Policy `ClientPortalPolicy` para verificar acceso a casos

**Prioridad:** P3 - Sprint 9 (solo Professional)

---

## Matriz de Priorización

| Epic | # User Stories | Prioridad | Sprint Recomendado |
|------|----------------|-----------|---------------------|
| Epic 1: Onboarding y SaaS | 5 | P0 - CRÍTICA | Sprint 1, 2, 6 |
| Epic 2: Gestión Procesal | 5 | P0 - CRÍTICA | Sprint 2, 3 |
| Epic 3: Agenda y Tiempos | 5 | P1 - ALTA | Sprint 4 |
| Epic 4: Evidencias | 3 | P1 - ALTA | Sprint 5 |
| Epic 5: Documentos | 3 | P1 - ALTA | Sprint 5 |
| Epic 6: CNPP Especialización | 2 | P2 - MEDIA | Sprint 7 |
| Epic 7: Seguridad | 2 | P2 - MEDIA | Sprint 8 |
| Epic 8: Actuaciones | 2 | P2 - MEDIA | Sprint 7 |
| Epic 9: Reportes | 2 | P2 - MEDIA | Sprint 8 |
| Epic 10: Portal Clientes | 1 | P3 - BAJA | Sprint 9 |

**Total:** 30 User Stories

---

## Roadmap de Implementación

### Vista General de Sprints

| Sprint | Nombre | User Stories | Enfoque |
|--------|--------|--------------|---------|
| 1 | Documentación | - | COMPLETADO |
| 2 | Foundation & Auth | US-01, US-02, US-05, US-25 | Base multi-tenant + RBAC |
| 3 | Core Legal | US-06, US-07, US-08, US-10 | Casos + Participantes + Etapas |
| 4 | Agenda & Tiempos | US-09, US-11-US-15 | Dashboard + Audiencias + Plazos |
| 5 | Evidencias & Documentos | US-16-US-21 | Cadena custodia + Archivos |
| 6 | CNPP & Actuaciones | US-22, US-23, US-26, US-27 | Medidas + Soluciones + Bitácora |
| 7 | Billing, Reportes & Portal | US-03, US-04, US-24, US-28-US-30 | Stripe + Audit + Dashboard + Portal |
| 8 | Testing & QA | - | Tests + Bug fixes |
| 9 | Deploy & Lanzamiento | - | Producción |

---

### Sprint 1: Documentación y Setup ✅ COMPLETADO

**Periodo:** 2025-10-05 - 2025-11-29

**Entregables:**
- ✅ Manifiesto del proyecto (`01-manifest.md`)
- ✅ Sistema de diseño (`02-design-system.md`)
- ✅ Esquema de base de datos (`03-database-schema.md`)
- ✅ Historias de usuario (`04-user-stories.md`)
- ✅ Arquitectura técnica (`00-arquitectura-tecnica.md`)
- ✅ Tokens CSS implementados (`resources/css/app.css`)
- ✅ Áreas de trabajo del equipo (`workflow/04-areas-de-trabajo.md`)

---

### Sprint 2: Foundation & Auth

**Objetivo:** Establecer la arquitectura multi-tenant y el sistema de autenticación/autorización.

**User Stories:**
- US-01: Registro de Nuevo Despacho (Tenant Creation)
- US-02: Invitación de Miembros al Equipo
- US-05: Cambio de Tenant (Multi-Workspace)
- US-25: Gestión de Roles y Permisos (RBAC Base)

**Entregables Técnicos:**
- Migraciones: `subscription_tiers`, `tenants`, `users`, `tenant_user`, `team_invitations`
- Modelos: `Tenant`, `User`, `TeamInvitation`
- Trait: `TenantScoped`
- Middleware: `IdentifyTenant`, `EnsureTenantScope`
- Spatie Permission con 6 roles base
- Seeders: `SubscriptionTiersSeeder`, `PermissionsAndRolesSeeder`
- Componentes Livewire: `RegisterTenantForm`, `InviteTeamMemberForm`, `TenantSwitcher`

**Dependencias:** Laravel Breeze instalado

---

### Sprint 3: Core Legal

**Objetivo:** Implementar el corazón del sistema - gestión de expedientes penales y participantes.

**User Stories:**
- US-06: Apertura de Nuevo Caso Penal
- US-07: Gestión de Participantes del Caso
- US-08: Transición de Etapa Procesal con Historial
- US-10: Listado y Filtrado de Casos

**Entregables Técnicos:**
- Migraciones: `cases`, `procedural_stage_history`, `participants`, `case_participant`
- Modelos: `LegalCase`, `ProceduralStageHistory`, `Participant`
- Service: `CaseStageService`
- Observer: `CaseObserver`
- Seeders: `CrimeTypesSeeder`
- Componentes Livewire: `CreateCaseForm`, `CasesTable`, `ParticipantManager`, `StageTransitionModal`

**Dependencias:** Sprint 2 completado

---

### Sprint 4: Agenda & Tiempos

**Objetivo:** Sistema de audiencias, plazos fatales y alertas - crítico para el flujo legal.

**User Stories:**
- US-09: Dashboard del Caso (Vista Integral)
- US-11: Programación de Audiencias
- US-12: Registro de Resultado de Audiencia
- US-13: Calendario de Audiencias del Despacho
- US-14: Configuración de Plazos Fatales (Deadlines)
- US-15: Sistema de Alertas y Notificaciones de Plazos

**Entregables Técnicos:**
- Migraciones: `hearings`, `deadlines`
- Modelos: `Hearing`, `Deadline`
- Jobs: `CheckDeadlinesJob`, `SendDeadlineReminderJob`
- Observer: `HearingObserver`
- Notifications: `DeadlineApproachingNotification`
- Componentes Livewire: `CaseDetailPage`, `HearingForm`, `HearingsCalendar`, `DeadlineForm`
- Integración: FullCalendar.js

**Dependencias:** Sprint 3 completado

---

### Sprint 5: Evidencias & Documentos

**Objetivo:** Gestión de evidencias físicas con cadena de custodia y repositorio documental.

**User Stories:**
- US-16: Registro de Evidencia Material/Digital
- US-17: Registro de Movimiento de Cadena de Custodia
- US-18: Listado y Búsqueda de Evidencias
- US-19: Carga y Clasificación de Documentos
- US-20: Visualización y Descarga de Documentos
- US-21: Asociación de Documentos a Entidades Específicas

**Entregables Técnicos:**
- Migraciones: `evidence`, `chain_of_custody_entries`, `documents`
- Modelos: `Evidence`, `ChainOfCustodyEntry`, `Document`
- Storage: Configuración S3/MinIO
- Componentes Livewire: `EvidenceForm`, `CustodyMovementForm`, `DocumentUploader`
- Integración: FilePond.js, PDF.js

**Dependencias:** Sprint 4 completado

---

### Sprint 6: CNPP & Actuaciones

**Objetivo:** Funcionalidades específicas del CNPP mexicano y bitácora de gestiones.

**User Stories:**
- US-22: Control de Medidas Cautelares
- US-23: Gestión de Soluciones Alternas
- US-26: Registro de Bitácora de Actuaciones
- US-27: Filtro de Actividades por Usuario

**Entregables Técnicos:**
- Migraciones: `precautionary_measures`, `alternative_solutions`, `activities`
- Modelos: `PrecautionaryMeasure`, `AlternativeSolution`, `Activity`
- Seeders: `PrecautionaryMeasureTypesSeeder`
- Componentes Livewire: `PrecautionaryMeasureForm`, `AlternativeSolutionForm`, `ActivityTimeline`

**Dependencias:** Sprint 5 completado

---

### Sprint 7: Billing, Reportes & Portal

**Objetivo:** Monetización, auditoría y portal de clientes (features premium).

**User Stories:**
- US-03: Gestión de Suscripción y Límites (Billing)
- US-04: Configuración de Métodos de Pago (Stripe)
- US-24: Bitácora de Actividades (Audit Trail)
- US-28: Dashboard Ejecutivo del Despacho
- US-29: Reportes Avanzados (Tier Professional)
- US-30: Acceso de Cliente a su Caso (Portal)

**Entregables Técnicos:**
- Migraciones: `subscriptions`, `subscription_items`, `audit_logs`
- Integración: Laravel Cashier + Stripe
- Middleware: `EnsureTenantHasFeature`
- Jobs: `CheckExpiredTrials`
- Componentes Livewire: `BillingPortal`, `AuditLogViewer`, `DashboardPage`, `ClientPortal`
- Charts: Chart.js o ApexCharts

**Dependencias:** Sprint 6 completado

---

### Sprint 8: Testing & QA

**Objetivo:** Asegurar calidad y estabilidad del sistema antes del lanzamiento.

**Actividades:**
- Tests unitarios para todos los modelos y servicios
- Tests de feature para flujos críticos (auth, casos, audiencias)
- Tests de integración para Stripe
- QA manual de todos los módulos
- Pruebas de regresión
- Bug fixes
- Optimización de queries (eliminar N+1)
- Validación de seguridad (OWASP top 10)

**Entregables:**
- Suite de tests con cobertura > 70%
- Reporte de bugs encontrados y corregidos
- Checklist de QA completado por módulo

---

### Sprint 9: Deploy & Lanzamiento

**Objetivo:** Puesta en producción y lanzamiento oficial.

**Actividades:**
- Configuración de servidor de producción
- Setup de CI/CD para deploy automático
- Configuración de SSL/HTTPS
- Setup de monitoreo (Sentry, Laravel Telescope)
- Configuración de backups automáticos
- Performance optimization (cache, CDN)
- Documentación de usuario final
- Capacitación del equipo
- Lanzamiento soft (beta)
- Lanzamiento público

**Entregables:**
- Aplicación en producción
- Documentación de operaciones
- Runbook de emergencias
- Métricas de monitoreo configuradas

---

### Diagrama de Dependencias

```
Sprint 1 (Docs) ✅
      │
      ▼
Sprint 2 (Foundation)
      │
      ├── Multi-tenant
      ├── Auth + RBAC
      └── Team Management
            │
            ▼
Sprint 3 (Core Legal)
      │
      ├── Cases
      ├── Participants
      └── Stage Transitions
            │
            ▼
Sprint 4 (Agenda)
      │
      ├── Hearings
      ├── Deadlines
      └── Notifications
            │
            ▼
Sprint 5 (Evidence & Docs)
      │
      ├── Chain of Custody
      └── Document Storage
            │
            ▼
Sprint 6 (CNPP)
      │
      ├── Precautionary Measures
      ├── Alternative Solutions
      └── Activities Log
            │
            ▼
Sprint 7 (Premium)
      │
      ├── Billing (Stripe)
      ├── Audit Logs
      ├── Reports
      └── Client Portal
            │
            ▼
Sprint 8 (Testing)
      │
      └── QA + Bug Fixes
            │
            ▼
Sprint 9 (Deploy)
      │
      └── Production Launch
```

**Duración Total Estimada:** 16-18 semanas (4-4.5 meses)

---

## Resumen de Cobertura Funcional

| Concepto del Manifiesto | User Stories que lo cubren |
|-------------------------|----------------------------|
| **Multi-Tenant SaaS** | US-01, US-02, US-05 |
| **Billing y Límites** | US-03, US-04 |
| **Gestión Procesal Penal** | US-06, US-07, US-08, US-09, US-10 |
| **Audiencias y Plazos** | US-11, US-12, US-13, US-14, US-15 |
| **Evidencias (Cadena Custodia)** | US-16, US-17, US-18 |
| **Documentos** | US-19, US-20, US-21 |
| **CNPP (Medidas/Soluciones)** | US-22, US-23 |
| **Seguridad / Auditoría** | US-24, US-25 |
| **Actuaciones Diarias** | US-26, US-27 |
| **Reportes y Dashboard** | US-28, US-29 |
| **Portal de Clientes** | US-30 |

**Cobertura:** 100% del alcance funcional definido en Manifiesto v1.0 + Arquitectura Técnica v1.0

---

**Última actualización:** 19 de noviembre de 2025
**Revisado por:** Equipo Qadra
**Estado:** ✅ Listo para desarrollo
