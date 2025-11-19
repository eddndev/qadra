# Esquema de Base de Datos - Qadra

**Versión:** 1.0
**Última Actualización:** 19 de noviembre de 2025
**Motor:** MySQL 8.0+ / PostgreSQL 14+
**ORM:** Laravel Eloquent
**Estrategia Multi-Tenant:** Single Database + tenant_id

---

## Tabla de Contenidos

1. [Convenciones y Estándares](#1-convenciones-y-estándares)
2. [Módulo SaaS y Gestión de Tenants](#2-módulo-saas-y-gestión-de-tenants)
3. [Módulo Gestión Procesal (Core Legal)](#3-módulo-gestión-procesal-core-legal)
4. [Módulo de Tiempo y Actuaciones](#4-módulo-de-tiempo-y-actuaciones)
5. [Módulo de Evidencias y Documentos](#5-módulo-de-evidencias-y-documentos)
6. [Módulo Especialización CNPP](#6-módulo-especialización-cnpp)
7. [Módulo Seguridad y Auditoría](#7-módulo-seguridad-y-auditoría)
8. [Índices Críticos para Performance](#8-índices-críticos-para-performance)
9. [Relaciones entre Tablas](#9-relaciones-entre-tablas)
10. [Migraciones de Laravel (Orden de Ejecución)](#10-migraciones-de-laravel-orden-de-ejecución)
11. [Seeders Requeridos](#11-seeders-requeridos)
12. [Consideraciones de Seguridad](#12-consideraciones-de-seguridad)

---

## 1. Convenciones y Estándares

### 1.1 Nomenclatura

- **Nombres de tablas:** snake_case, plural (ej: `cases`, `participants`, `hearings`)
- **Nombres de columnas:** snake_case (ej: `tenant_id`, `created_at`)
- **Primary Keys:** `id` en todas las tablas
- **Foreign Keys:** `{tabla_singular}_id` (ej: `tenant_id`, `case_id`)

### 1.2 Tipos de Datos

- **Primary Keys (PK):**
  - `ULID` (CHAR 26) para entidades principales (ordenables cronológicamente, seguros para URLs)
  - `BIGINT UNSIGNED AUTO_INCREMENT` para tablas pivot y catálogos
- **Foreign Keys:** Mismo tipo que la PK referenciada
- **Strings:** `VARCHAR(255)` por defecto, especificar longitud diferente si se requiere
- **Textos largos:** `TEXT` o `LONGTEXT`
- **JSON:** `JSON` nativo (MySQL 5.7+, PostgreSQL 9.4+)
- **Booleanos:** `BOOLEAN` (TINYINT(1) en MySQL)
- **Fechas:** `DATE` para fechas, `DATETIME` para fecha+hora, `TIMESTAMP` para timestamps
- **Enums:** `VARCHAR` con validación en capa de aplicación (más flexible que ENUM nativo)

### 1.3 Campos Estándar

Todas las tablas incluyen (salvo excepciones):

- `created_at TIMESTAMP` - Fecha de creación del registro
- `updated_at TIMESTAMP` - Fecha de última actualización
- `deleted_at TIMESTAMP NULL` - Soft delete (solo en tablas principales)

### 1.4 Multi-Tenancy

- **Todas las tablas transaccionales incluyen:** `tenant_id ULID`
- **Constraint:** `ON DELETE CASCADE` para asegurar eliminación en cascada si se elimina un tenant
- **Índices:** Índice compuesto `(tenant_id, id)` en todas las tablas con tenant_id

### 1.5 Soft Deletes

Tablas que usan soft delete (`deleted_at`):
- `tenants`
- `users`
- `cases`
- `participants`
- `hearings`
- `deadlines`
- `evidence`
- `documents`
- `precautionary_measures`
- `alternative_solutions`

---

## 2. Módulo SaaS y Gestión de Tenants

Este módulo controla la arquitectura multi-despacho, suscripciones y acceso de usuarios.

### 2.1 Tabla: `subscription_tiers`

**Propósito:** Define los planes de suscripción disponibles (Starter, Professional, Enterprise).

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Identificador del tier |
| `name` | VARCHAR(50) | NOT NULL | Nombre visible (ej: "Professional") |
| `slug` | VARCHAR(50) | UNIQUE, NOT NULL | Identificador único (ej: "professional") |
| `description` | TEXT | NULL | Descripción del plan |
| `price_monthly` | INTEGER | NOT NULL | Precio mensual en centavos (ej: 9900 = $99 USD) |
| `price_yearly` | INTEGER | NOT NULL | Precio anual en centavos |
| `stripe_product_id` | VARCHAR(255) | NULL | ID del producto en Stripe |
| `stripe_price_monthly_id` | VARCHAR(255) | NULL | ID del precio mensual en Stripe |
| `stripe_price_yearly_id` | VARCHAR(255) | NULL | ID del precio anual en Stripe |
| `max_users` | INTEGER | NOT NULL | Límite de usuarios permitidos |
| `max_storage_gb` | INTEGER | NOT NULL | Límite de almacenamiento en GB |
| `max_active_cases` | INTEGER | NOT NULL | Límite de casos activos simultáneos |
| `features` | JSON | NULL | Feature flags (ej: `{"client_portal": true, "advanced_reports": true}`) |
| `is_active` | BOOLEAN | DEFAULT TRUE | Si el tier está disponible para nuevas suscripciones |
| `sort_order` | INTEGER | DEFAULT 0 | Orden de visualización |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |

**Relaciones:**
- Uno a Muchos con `tenants` (un tier puede tener múltiples tenants)

**Índices:**
- PRIMARY KEY: `id`
- UNIQUE: `slug`
- INDEX: `is_active`

---

### 2.2 Tabla: `tenants`

**Propósito:** Representa los despachos legales (clientes de Qadra). Cada tenant es un workspace aislado.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador único del despacho |
| `name` | VARCHAR(255) | NOT NULL | Nombre comercial del despacho |
| `slug` | VARCHAR(255) | UNIQUE, NOT NULL | Identificador URL-friendly |
| `tax_id` | VARCHAR(50) | NULL | RFC del despacho (para facturación) |
| `subscription_tier_id` | BIGINT UNSIGNED | FK, NOT NULL | Plan de suscripción actual |
| `status` | VARCHAR(20) | NOT NULL | `active`, `suspended`, `trial`, `cancelled` |
| `settings` | JSON | NULL | Configuración del despacho (logo, colores, prefijos de casos) |
| `stripe_id` | VARCHAR(255) | NULL | Customer ID en Stripe |
| `pm_type` | VARCHAR(50) | NULL | Tipo de método de pago (card, paypal, etc.) |
| `pm_last_four` | VARCHAR(4) | NULL | Últimos 4 dígitos del método de pago |
| `trial_ends_at` | TIMESTAMP | NULL | Fecha de fin del trial gratuito |
| `subscription_ends_at` | TIMESTAMP | NULL | Fecha de fin de suscripción (si fue cancelada) |
| `current_users_count` | INTEGER | DEFAULT 0 | Caché: contador de usuarios activos |
| `current_active_cases_count` | INTEGER | DEFAULT 0 | Caché: contador de casos activos |
| `current_storage_usage_bytes` | BIGINT | DEFAULT 0 | Caché: uso actual de storage en bytes |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Relaciones:**
- Muchos a Uno con `subscription_tiers`
- Uno a Muchos con `cases`, `participants`, `hearings`, etc.
- Muchos a Muchos con `users` (a través de `tenant_user`)

**Índices:**
- PRIMARY KEY: `id`
- UNIQUE: `slug`
- INDEX: `subscription_tier_id`
- INDEX: `status`
- INDEX: `stripe_id`

---

### 2.3 Tabla: `users`

**Propósito:** Usuarios del sistema. Existen globalmente pero se asocian a tenants específicos.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador único del usuario |
| `name` | VARCHAR(255) | NOT NULL | Nombre completo |
| `email` | VARCHAR(255) | UNIQUE, NOT NULL | Correo electrónico (login) |
| `email_verified_at` | TIMESTAMP | NULL | Fecha de verificación de email |
| `password` | VARCHAR(255) | NOT NULL | Hash de contraseña (bcrypt) |
| `professional_license` | VARCHAR(50) | NULL | Cédula profesional (opcional) |
| `phone` | VARCHAR(20) | NULL | Teléfono móvil |
| `avatar_path` | VARCHAR(255) | NULL | Ruta de imagen de perfil |
| `remember_token` | VARCHAR(100) | NULL | Token de "recordarme" |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Relaciones:**
- Muchos a Muchos con `tenants` (a través de `tenant_user`)
- Uno a Muchos con `cases` (como `lead_lawyer_id`)
- Uno a Muchos con `activities` (como `performed_by`)

**Índices:**
- PRIMARY KEY: `id`
- UNIQUE: `email`
- INDEX: `deleted_at`

---

### 2.4 Tabla: `tenant_user` (Pivot)

**Propósito:** Relación N:M entre usuarios y tenants. Define la membresía y rol en cada despacho.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Identificador de la relación |
| `tenant_id` | CHAR(26) | FK, NOT NULL | El despacho |
| `user_id` | CHAR(26) | FK, NOT NULL | El usuario |
| `role` | VARCHAR(50) | NOT NULL | Rol base: `owner`, `litigante`, `asociado`, `paralegal`, `administrativo`, `cliente` |
| `permissions` | JSON | NULL | Overrides de permisos específicos (opcional) |
| `is_active` | BOOLEAN | DEFAULT TRUE | Si el acceso está habilitado |
| `invited_by` | CHAR(26) | FK, NULL | Usuario que invitó (si aplica) |
| `invited_at` | TIMESTAMP | NULL | Fecha de invitación |
| `joined_at` | TIMESTAMP | NULL | Fecha de aceptación |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Uno con `users`

**Índices:**
- PRIMARY KEY: `id`
- UNIQUE: `(tenant_id, user_id)`
- INDEX: `tenant_id`
- INDEX: `user_id`
- INDEX: `role`

---

### 2.5 Tabla: `team_invitations`

**Propósito:** Invitaciones pendientes para unirse a un despacho.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador de la invitación |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Despacho que invita |
| `email` | VARCHAR(255) | NOT NULL | Correo del invitado |
| `role` | VARCHAR(50) | NOT NULL | Rol que tendrá al aceptar |
| `token` | VARCHAR(255) | UNIQUE, NOT NULL | Token único de validación |
| `invited_by` | CHAR(26) | FK, NOT NULL | Usuario que envió la invitación |
| `expires_at` | TIMESTAMP | NOT NULL | Fecha de expiración (7 días típico) |
| `accepted_at` | TIMESTAMP | NULL | Fecha de aceptación |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Uno con `users` (invited_by)

**Índices:**
- PRIMARY KEY: `id`
- UNIQUE: `token`
- INDEX: `(tenant_id, email)`
- INDEX: `expires_at`

---

### 2.6 Tabla: `subscriptions`

**Propósito:** Suscripciones activas de Stripe (Laravel Cashier). Una por tenant.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Identificador de la suscripción |
| `tenant_id` | CHAR(26) | FK, NOT NULL | El despacho suscrito |
| `type` | VARCHAR(50) | NOT NULL | Tipo de suscripción (ej: "default") |
| `stripe_id` | VARCHAR(255) | UNIQUE, NOT NULL | Subscription ID en Stripe |
| `stripe_status` | VARCHAR(50) | NOT NULL | Estado: `active`, `canceled`, `incomplete`, etc. |
| `stripe_price` | VARCHAR(255) | NULL | Price ID activo en Stripe |
| `quantity` | INTEGER | NULL | Cantidad (para seat-based pricing) |
| `trial_ends_at` | TIMESTAMP | NULL | Fin del trial |
| `ends_at` | TIMESTAMP | NULL | Fin de la suscripción (si cancelada) |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |

**Relaciones:**
- Muchos a Uno con `tenants`

**Índices:**
- PRIMARY KEY: `id`
- UNIQUE: `stripe_id`
- INDEX: `(tenant_id, stripe_status)`

---

### 2.7 Tabla: `subscription_items`

**Propósito:** Items de la suscripción (Laravel Cashier). Para suscripciones con múltiples productos.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Identificador del item |
| `subscription_id` | BIGINT UNSIGNED | FK, NOT NULL | Suscripción padre |
| `stripe_id` | VARCHAR(255) | UNIQUE, NOT NULL | Subscription Item ID en Stripe |
| `stripe_product` | VARCHAR(255) | NOT NULL | Product ID en Stripe |
| `stripe_price` | VARCHAR(255) | NOT NULL | Price ID en Stripe |
| `quantity` | INTEGER | NULL | Cantidad |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |

**Relaciones:**
- Muchos a Uno con `subscriptions`

**Índices:**
- PRIMARY KEY: `id`
- UNIQUE: `stripe_id`
- INDEX: `subscription_id`

---

## 3. Módulo Gestión Procesal (Core Legal)

El corazón del sistema para el manejo del expediente penal según el CNPP.

### 3.1 Tabla: `cases`

**Propósito:** Representa el expediente o carpeta de investigación penal. Entidad principal del sistema.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador único del caso |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Despacho propietario del caso |
| `internal_folio` | VARCHAR(100) | NOT NULL | Folio interno del despacho (ej: "EXP-2025-001") |
| `nuc` | VARCHAR(100) | NULL | Número Único de Caso (asignado por Fiscalía) |
| `judicial_file_number` | VARCHAR(100) | NULL | Número de Causa Penal (asignado por Juzgado) |
| `case_alias` | VARCHAR(255) | NULL | Nombre corto del caso (ej: "Caso Lozoya") |
| `crime_type` | VARCHAR(255) | NOT NULL | Tipo de delito principal |
| `crime_classification` | VARCHAR(50) | NULL | `doloso`, `culposo` |
| `crime_severity` | VARCHAR(50) | NULL | `grave`, `no_grave` |
| `stage` | VARCHAR(50) | NOT NULL | Etapa procesal: `inv_inicial`, `inv_complementaria`, `intermedia`, `juicio`, `ejecucion` |
| `status` | VARCHAR(50) | NOT NULL | Estado: `activo`, `suspendido`, `cerrado`, `archivado` |
| `start_date` | DATE | NOT NULL | Fecha de inicio en el despacho |
| `close_date` | DATE | NULL | Fecha de cierre del caso |
| `lead_lawyer_id` | CHAR(26) | FK, NOT NULL | Abogado responsable principal |
| `assigned_to_id` | CHAR(26) | FK, NULL | Abogado asignado actualmente (puede ser diferente) |
| `court_name` | VARCHAR(255) | NULL | Nombre del juzgado |
| `prosecutor_name` | VARCHAR(255) | NULL | Nombre del Ministerio Público |
| `judge_name` | VARCHAR(255) | NULL | Nombre del juez |
| `initial_hearing_date` | DATETIME | NULL | Fecha de audiencia inicial |
| `arraignment_date` | DATETIME | NULL | Fecha de vinculación a proceso |
| `trial_date` | DATETIME | NULL | Fecha de juicio oral |
| `notes` | LONGTEXT | NULL | Notas internas del caso |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Uno con `users` (lead_lawyer_id, assigned_to_id)
- Uno a Muchos con `participants` (a través de `case_participant`)
- Uno a Muchos con `hearings`
- Uno a Muchos con `deadlines`
- Uno a Muchos con `activities`
- Uno a Muchos con `evidence`
- Uno a Muchos con `documents` (polimórfico)
- Uno a Muchos con `precautionary_measures`
- Uno a Muchos con `alternative_solutions`

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `(tenant_id, id)`
- INDEX: `(tenant_id, internal_folio)`
- INDEX: `(tenant_id, nuc)`
- INDEX: `(tenant_id, stage)`
- INDEX: `(tenant_id, status)`
- INDEX: `(tenant_id, lead_lawyer_id)`
- INDEX: `deleted_at`

---

### 3.2 Tabla: `procedural_stage_history`

**Propósito:** Bitácora inmutable de cambios de etapa procesal. Garantiza trazabilidad histórica.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador del registro histórico |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Scope de seguridad |
| `case_id` | CHAR(26) | FK, NOT NULL | Caso afectado |
| `previous_stage` | VARCHAR(50) | NULL | Etapa anterior (NULL si es el primer registro) |
| `new_stage` | VARCHAR(50) | NOT NULL | Nueva etapa establecida |
| `previous_status` | VARCHAR(50) | NULL | Status anterior |
| `new_status` | VARCHAR(50) | NOT NULL | Nuevo status |
| `reason` | TEXT | NULL | Razón del cambio (ej: "Auto de Vinculación a Proceso") |
| `changed_by` | CHAR(26) | FK, NOT NULL | Usuario que ejecutó el cambio |
| `created_at` | TIMESTAMP | NOT NULL | Momento exacto del cambio |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Uno con `cases`
- Muchos a Uno con `users` (changed_by)

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `(tenant_id, case_id, created_at)`
- INDEX: `case_id`

**Nota:** Esta tabla NO tiene `updated_at` ni `deleted_at` porque es inmutable.

---

### 3.3 Tabla: `participants`

**Propósito:** Base de datos de personas involucradas en casos (imputados, víctimas, testigos, jueces, MP).

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador del participante |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Scope de seguridad |
| `type` | VARCHAR(50) | NOT NULL | `fisica`, `moral` (empresa), `autoridad` |
| `name` | VARCHAR(255) | NOT NULL | Nombre completo o Razón Social |
| `rfc` | VARCHAR(13) | NULL | Registro Federal de Contribuyentes |
| `curp` | VARCHAR(18) | NULL | CURP (personas físicas) |
| `gender` | VARCHAR(20) | NULL | `masculino`, `femenino`, `otro` |
| `date_of_birth` | DATE | NULL | Fecha de nacimiento |
| `contact_details` | JSON | NULL | `{"email": "", "phone": "", "address": {}}` |
| `notes` | TEXT | NULL | Notas adicionales |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Muchos con `cases` (a través de `case_participant`)

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `(tenant_id, id)`
- INDEX: `(tenant_id, name)`
- INDEX: `(tenant_id, rfc)`

---

### 3.4 Tabla: `case_participant` (Pivot)

**Propósito:** Relaciona personas con casos y define su rol específico en ESE caso.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Identificador de la relación |
| `case_id` | CHAR(26) | FK, NOT NULL | El caso |
| `participant_id` | CHAR(26) | FK, NOT NULL | La persona |
| `role` | VARCHAR(50) | NOT NULL | `imputado`, `victima`, `juez_control`, `juez_juicio`, `mp`, `testigo`, `perito`, `defensor` |
| `alias` | VARCHAR(255) | NULL | Alias en este caso (ej: "El Chapo") |
| `is_detained` | BOOLEAN | DEFAULT FALSE | ¿Está privado de la libertad? |
| `defense_attorney_name` | VARCHAR(255) | NULL | Nombre del abogado (si es contraparte) |
| `notes` | TEXT | NULL | Notas específicas del rol en este caso |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |

**Relaciones:**
- Muchos a Uno con `cases`
- Muchos a Uno con `participants`

**Índices:**
- PRIMARY KEY: `id`
- UNIQUE: `(case_id, participant_id, role)`
- INDEX: `case_id`
- INDEX: `participant_id`
- INDEX: `role`

---

## 4. Módulo de Tiempo y Actuaciones

Control de agenda, audiencias y plazos procesales fatales.

### 4.1 Tabla: `hearings`

**Propósito:** Audiencias programadas o celebradas en el proceso penal.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador de la audiencia |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Scope de seguridad |
| `case_id` | CHAR(26) | FK, NOT NULL | Caso relacionado |
| `type` | VARCHAR(100) | NOT NULL | Tipo: `inicial`, `vinculacion`, `intermedia`, `juicio_oral`, `revision_medidas`, etc. |
| `scheduled_at` | DATETIME | NOT NULL | Fecha y hora programada |
| `duration_minutes` | INTEGER | NULL | Duración estimada en minutos |
| `courtroom` | VARCHAR(255) | NULL | Sala o juzgado físico |
| `virtual_link` | VARCHAR(500) | NULL | Link de Zoom/WebEx/Teams |
| `judge_participant_id` | CHAR(26) | FK, NULL | Juez que preside (referencia a participants) |
| `status` | VARCHAR(50) | NOT NULL | `programada`, `celebrada`, `cancelada`, `reprogramada` |
| `result_summary` | LONGTEXT | NULL | Resumen de acuerdos/resoluciones |
| `next_hearing_date` | DATETIME | NULL | Fecha de próxima audiencia (si aplica) |
| `attended_by` | JSON | NULL | Array de user_ids que asistieron |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Uno con `cases`
- Muchos a Uno con `participants` (judge_participant_id)
- Uno a Muchos con `deadlines` (una audiencia puede generar plazos)
- Uno a Muchos con `documents` (polimórfico)

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `(tenant_id, id)`
- INDEX: `(tenant_id, case_id, scheduled_at)`
- INDEX: `(tenant_id, scheduled_at)`
- INDEX: `status`

---

### 4.2 Tabla: `deadlines`

**Propósito:** Plazos procesales y términos fatales que deben cumplirse.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador del plazo |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Scope de seguridad |
| `case_id` | CHAR(26) | FK, NOT NULL | Caso relacionado |
| `hearing_id` | CHAR(26) | FK, NULL | Audiencia de la que deriva (opcional) |
| `title` | VARCHAR(255) | NOT NULL | Nombre del plazo (ej: "Cierre de Investigación Complementaria") |
| `description` | TEXT | NULL | Descripción detallada |
| `expires_at` | DATETIME | NOT NULL | Momento exacto del vencimiento |
| `is_fatal` | BOOLEAN | DEFAULT FALSE | Si es término fatal (crítico) |
| `reminder_config` | JSON | NULL | Configuración de alertas: `{"days_before": [7, 3, 1, 0]}` |
| `status` | VARCHAR(50) | NOT NULL | `pendiente`, `cumplido`, `vencido` |
| `completed_at` | TIMESTAMP | NULL | Cuándo se cumplió |
| `completed_by` | CHAR(26) | FK, NULL | Usuario que marcó como cumplido |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Uno con `cases`
- Muchos a Uno con `hearings` (opcional)
- Muchos a Uno con `users` (completed_by)

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `(tenant_id, id)`
- INDEX: `(tenant_id, case_id, expires_at)`
- INDEX: `(tenant_id, status, expires_at)`
- INDEX: `is_fatal`

---

### 4.3 Tabla: `activities`

**Propósito:** Bitácora general de actuaciones y actividades realizadas en el caso.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador de la actividad |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Scope de seguridad |
| `case_id` | CHAR(26) | FK, NOT NULL | Caso relacionado |
| `type` | VARCHAR(100) | NOT NULL | `llamada`, `email`, `escrito`, `reunion`, `diligencia`, `visita_carcelaria`, etc. |
| `title` | VARCHAR(255) | NOT NULL | Título breve de la actividad |
| `description` | LONGTEXT | NULL | Descripción detallada de lo realizado |
| `performed_by` | CHAR(26) | FK, NOT NULL | Usuario que realizó la actividad |
| `performed_at` | DATETIME | NOT NULL | Cuándo ocurrió la actividad |
| `duration_minutes` | INTEGER | NULL | Duración en minutos (para tracking de tiempo) |
| `metadata` | JSON | NULL | Datos adicionales específicos del tipo |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Uno con `cases`
- Muchos a Uno con `users` (performed_by)
- Uno a Muchos con `documents` (polimórfico - pueden adjuntarse archivos a actividades)

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `(tenant_id, case_id, performed_at)`
- INDEX: `(tenant_id, performed_by)`
- INDEX: `type`

---

## 5. Módulo de Evidencias y Documentos

Gestión de elementos probatorios y archivos digitales.

### 5.1 Tabla: `evidence`

**Propósito:** Objetos físicos o digitales que requieren cadena de custodia rigurosa.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador de la evidencia |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Scope de seguridad |
| `case_id` | CHAR(26) | FK, NOT NULL | Caso relacionado |
| `chain_of_custody_folio` | VARCHAR(100) | NOT NULL | Identificador único de etiqueta/folio |
| `description` | VARCHAR(500) | NOT NULL | Descripción del objeto |
| `type` | VARCHAR(100) | NOT NULL | `arma`, `documento_original`, `dispositivo_electronico`, `biologico`, `droga`, etc. |
| `current_location` | VARCHAR(255) | NULL | Ubicación física actual |
| `status` | VARCHAR(50) | NOT NULL | `en_custodia`, `en_fiscalia`, `en_juzgado`, `destruido`, `devuelto` |
| `collected_at` | DATETIME | NULL | Fecha de recolección |
| `collected_by` | VARCHAR(255) | NULL | Quien recolectó (autoridad) |
| `notes` | TEXT | NULL | Notas adicionales |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Uno con `cases`
- Uno a Muchos con `chain_of_custody_entries`
- Uno a Muchos con `documents` (polimórfico - fotos, escaneos de la evidencia)

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `(tenant_id, case_id)`
- INDEX: `chain_of_custody_folio`
- INDEX: `status`

---

### 5.2 Tabla: `chain_of_custody_entries`

**Propósito:** Historial inmutable de movimientos de evidencia física. Garantiza integridad probatoria.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador del movimiento |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Scope de seguridad |
| `evidence_id` | CHAR(26) | FK, NOT NULL | Evidencia movida |
| `movement_at` | DATETIME | NOT NULL | Fecha y hora del movimiento |
| `given_by` | VARCHAR(255) | NOT NULL | Nombre completo de quien entrega |
| `given_by_badge` | VARCHAR(100) | NULL | Placa/Identificación oficial |
| `received_by` | VARCHAR(255) | NOT NULL | Nombre completo de quien recibe |
| `received_by_badge` | VARCHAR(100) | NULL | Placa/Identificación oficial |
| `reason` | VARCHAR(255) | NOT NULL | Motivo del movimiento (ej: "Traslado a Peritaje") |
| `location` | VARCHAR(255) | NULL | Ubicación después del movimiento |
| `condition` | VARCHAR(255) | NULL | Estado/condición de la evidencia |
| `registered_by` | CHAR(26) | FK, NOT NULL | Usuario del sistema que registra |
| `created_at` | TIMESTAMP | NOT NULL | |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Uno con `evidence`
- Muchos a Uno con `users` (registered_by)

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `(tenant_id, evidence_id, movement_at)`
- INDEX: `evidence_id`

**Nota:** Esta tabla NO tiene `updated_at` ni `deleted_at` porque es inmutable (auditoría).

---

### 5.3 Tabla: `documents`

**Propósito:** Archivos digitales (PDF, DOCX, JPG, etc.). Relación polimórfica con múltiples entidades.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador del documento |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Scope de seguridad |
| `documentable_type` | VARCHAR(255) | NOT NULL | Modelo padre (`App\Models\Case`, `App\Models\Hearing`, etc.) |
| `documentable_id` | CHAR(26) | NOT NULL | ID del modelo padre |
| `title` | VARCHAR(255) | NOT NULL | Nombre amigable del archivo |
| `description` | TEXT | NULL | Descripción del contenido |
| `file_path` | VARCHAR(500) | NOT NULL | Ruta en storage (`tenants/{tenant_id}/cases/{case_id}/...`) |
| `file_name` | VARCHAR(255) | NOT NULL | Nombre original del archivo |
| `mime_type` | VARCHAR(100) | NOT NULL | Tipo MIME (`application/pdf`, `image/jpeg`, etc.) |
| `size_bytes` | BIGINT | NOT NULL | Peso en bytes |
| `category` | VARCHAR(100) | NULL | `sentencia`, `amparo`, `evidencia`, `oficio`, `acta`, `otro` |
| `tags` | JSON | NULL | Array de tags para búsqueda: `["urgente", "confidencial"]` |
| `is_shared_with_client` | BOOLEAN | DEFAULT FALSE | Si es visible para el cliente en portal |
| `uploaded_by` | CHAR(26) | FK, NOT NULL | Usuario que subió el archivo |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Relaciones:**
- Muchos a Uno con `tenants`
- Polimórfico con `cases`, `hearings`, `evidence`, `activities`, etc.
- Muchos a Uno con `users` (uploaded_by)

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `(tenant_id, id)`
- INDEX: `(documentable_type, documentable_id)`
- INDEX: `category`
- INDEX: `uploaded_by`

---

## 6. Módulo Especialización CNPP

Funcionalidades exclusivas del sistema procesal penal acusatorio mexicano.

### 6.1 Tabla: `precautionary_measures`

**Propósito:** Medidas cautelares impuestas al imputado según CNPP Art. 153-175.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador de la medida |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Scope de seguridad |
| `case_id` | CHAR(26) | FK, NOT NULL | Caso relacionado |
| `participant_id` | CHAR(26) | FK, NOT NULL | Imputado sujeto a la medida |
| `measure_type` | VARCHAR(100) | NOT NULL | Ver catálogo en sección 11.3 |
| `description` | TEXT | NULL | Descripción específica de la medida |
| `imposed_at` | DATE | NOT NULL | Fecha de imposición |
| `imposed_by` | VARCHAR(255) | NULL | Nombre del juez que la impuso |
| `review_date` | DATE | NULL | Fecha obligatoria de revisión (CNPP) |
| `expires_at` | DATE | NULL | Fecha de expiración (si aplica) |
| `status` | VARCHAR(50) | NOT NULL | `vigente`, `cumplida`, `revocada`, `modificada` |
| `revoked_at` | DATE | NULL | Fecha de revocación |
| `revoked_reason` | TEXT | NULL | Motivo de revocación |
| `notes` | TEXT | NULL | Notas adicionales |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Uno con `cases`
- Muchos a Uno con `participants`

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `(tenant_id, case_id)`
- INDEX: `(tenant_id, participant_id)`
- INDEX: `status`
- INDEX: `review_date`

---

### 6.2 Tabla: `alternative_solutions`

**Propósito:** Salidas alternas al juicio oral (acuerdos reparatorios, suspensión condicional, procedimiento abreviado).

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador de la solución |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Scope de seguridad |
| `case_id` | CHAR(26) | FK, NOT NULL | Caso relacionado |
| `type` | VARCHAR(100) | NOT NULL | `acuerdo_reparatorio`, `suspension_condicional`, `procedimiento_abreviado` |
| `proposed_at` | DATE | NOT NULL | Fecha de propuesta |
| `approved_at` | DATE | NULL | Fecha de aprobación judicial |
| `approved_by` | VARCHAR(255) | NULL | Nombre del juez que aprobó |
| `conditions` | LONGTEXT | NOT NULL | Condiciones específicas (ej: "Pagar $50,000 MXN, Terapia psicológica 6 meses") |
| `compliance_deadline` | DATE | NULL | Fecha límite para cumplir condiciones |
| `status` | VARCHAR(50) | NOT NULL | `propuesta`, `aprobada`, `en_cumplimiento`, `cumplida`, `revocada` |
| `completed_at` | DATE | NULL | Fecha de cumplimiento total |
| `revoked_at` | DATE | NULL | Fecha de revocación |
| `revoked_reason` | TEXT | NULL | Motivo de revocación |
| `notes` | TEXT | NULL | Notas adicionales |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |
| `deleted_at` | TIMESTAMP | NULL | Soft delete |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Uno con `cases`

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `(tenant_id, case_id)`
- INDEX: `type`
- INDEX: `status`
- INDEX: `compliance_deadline`

---

## 7. Módulo Seguridad y Auditoría

Control de acceso y trazabilidad de acciones.

### 7.1 Tabla: `audit_logs`

**Propósito:** Registro completo de actividad del sistema para auditoría (disponible en tier Professional+).

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | CHAR(26) | PK (ULID) | Identificador del log |
| `tenant_id` | CHAR(26) | FK, NOT NULL | Scope de seguridad |
| `user_id` | CHAR(26) | FK, NULL | Usuario que realizó la acción (NULL si es sistema) |
| `event` | VARCHAR(100) | NOT NULL | `created`, `updated`, `deleted`, `viewed`, `downloaded`, etc. |
| `auditable_type` | VARCHAR(255) | NOT NULL | Modelo afectado (`App\Models\Case`, `App\Models\Evidence`, etc.) |
| `auditable_id` | CHAR(26) | NOT NULL | ID del modelo afectado |
| `description` | TEXT | NOT NULL | Descripción legible del cambio |
| `old_values` | JSON | NULL | Valores anteriores (para updates) |
| `new_values` | JSON | NULL | Valores nuevos (para updates/creates) |
| `ip_address` | VARCHAR(45) | NULL | IP del cliente (soporta IPv6) |
| `user_agent` | VARCHAR(500) | NULL | User agent del navegador |
| `created_at` | TIMESTAMP | NOT NULL | Fecha y hora del evento |

**Relaciones:**
- Muchos a Uno con `tenants`
- Muchos a Uno con `users`
- Polimórfico con cualquier modelo

**Índices:**
- PRIMARY KEY: `id`
- INDEX: `(tenant_id, created_at)`
- INDEX: `(auditable_type, auditable_id)`
- INDEX: `user_id`
- INDEX: `event`

**Nota:** Esta tabla NO tiene `updated_at` ni `deleted_at` porque es inmutable.

---

### 7.2 Tablas de Spatie Permission

El sistema usa [Spatie Laravel Permission](https://github.com/spatie/laravel-permission) para RBAC con soporte de teams.

#### 7.2.1 Tabla: `permissions`

**Propósito:** Catálogo global de permisos del sistema.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| `name` | VARCHAR(255) | NOT NULL | Nombre del permiso (ej: `cases.create`) |
| `guard_name` | VARCHAR(255) | NOT NULL | Guard (ej: `web`) |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |

**Índices:**
- PRIMARY KEY: `id`
- UNIQUE: `(name, guard_name)`

---

#### 7.2.2 Tabla: `roles`

**Propósito:** Roles del sistema, scoped por tenant (usando team_id de Spatie).

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `id` | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| `team_id` | CHAR(26) | FK, NULL | Tenant al que pertenece el rol (NULL para roles globales) |
| `name` | VARCHAR(255) | NOT NULL | Nombre del rol (ej: `owner`, `litigante`) |
| `guard_name` | VARCHAR(255) | NOT NULL | Guard (ej: `web`) |
| `created_at` | TIMESTAMP | NOT NULL | |
| `updated_at` | TIMESTAMP | NOT NULL | |

**Índices:**
- PRIMARY KEY: `id`
- UNIQUE: `(team_id, name, guard_name)`
- INDEX: `team_id`

---

#### 7.2.3 Tabla: `model_has_permissions`

**Propósito:** Asigna permisos directamente a modelos (users).

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `permission_id` | BIGINT UNSIGNED | FK, NOT NULL | |
| `model_type` | VARCHAR(255) | NOT NULL | `App\Models\User` |
| `model_id` | CHAR(26) | NOT NULL | User ID |
| `team_id` | CHAR(26) | FK, NULL | Tenant scope |

**Índices:**
- PRIMARY KEY: `(permission_id, model_id, model_type)`
- INDEX: `model_id`
- INDEX: `team_id`

---

#### 7.2.4 Tabla: `model_has_roles`

**Propósito:** Asigna roles a modelos (users).

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `role_id` | BIGINT UNSIGNED | FK, NOT NULL | |
| `model_type` | VARCHAR(255) | NOT NULL | `App\Models\User` |
| `model_id` | CHAR(26) | NOT NULL | User ID |
| `team_id` | CHAR(26) | FK, NULL | Tenant scope |

**Índices:**
- PRIMARY KEY: `(role_id, model_id, model_type)`
- INDEX: `model_id`
- INDEX: `team_id`

---

#### 7.2.5 Tabla: `role_has_permissions`

**Propósito:** Asigna permisos a roles.

**Estructura:**

| Columna | Tipo | Constraints | Descripción |
|---------|------|-------------|-------------|
| `permission_id` | BIGINT UNSIGNED | FK, NOT NULL | |
| `role_id` | BIGINT UNSIGNED | FK, NOT NULL | |

**Índices:**
- PRIMARY KEY: `(permission_id, role_id)`

---

## 8. Índices Críticos para Performance

### 8.1 Índices Multi-Tenant

Todas las tablas con `tenant_id` DEBEN tener:

```sql
INDEX idx_tenant_id (tenant_id, id)
```

Esto asegura queries rápidas dentro del scope del tenant.

### 8.2 Índices por Tabla Principal

**cases:**
- `(tenant_id, id)` - Lookup por tenant
- `(tenant_id, internal_folio)` - Búsqueda por folio
- `(tenant_id, nuc)` - Búsqueda por NUC
- `(tenant_id, stage)` - Filtrar por etapa
- `(tenant_id, status)` - Filtrar por status
- `(tenant_id, lead_lawyer_id)` - Casos por abogado
- `deleted_at` - Soft deletes

**hearings:**
- `(tenant_id, case_id, scheduled_at)` - Audiencias de un caso
- `(tenant_id, scheduled_at)` - Calendario general

**deadlines:**
- `(tenant_id, status, expires_at)` - Plazos próximos a vencer
- `is_fatal` - Filtrar términos fatales

**documents:**
- `(tenant_id, id)`
- `(documentable_type, documentable_id)` - Polimorfismo
- `uploaded_by`

**audit_logs:**
- `(tenant_id, created_at)` - Logs recientes
- `(auditable_type, auditable_id)` - Logs de una entidad

---

## 9. Relaciones entre Tablas

### 9.1 Relaciones Principales

```
tenants
├── 1:N → cases
├── 1:N → participants
├── 1:N → hearings
├── 1:N → deadlines
├── 1:N → activities
├── 1:N → evidence
├── 1:N → documents
├── 1:N → precautionary_measures
├── 1:N → alternative_solutions
├── 1:N → audit_logs
└── N:M → users (a través de tenant_user)

cases
├── N:1 → tenants
├── N:1 → users (lead_lawyer_id)
├── N:1 → users (assigned_to_id)
├── N:M → participants (a través de case_participant)
├── 1:N → hearings
├── 1:N → deadlines
├── 1:N → activities
├── 1:N → evidence
├── 1:N → documents (polimórfico)
├── 1:N → precautionary_measures
├── 1:N → alternative_solutions
└── 1:N → procedural_stage_history

participants
├── N:1 → tenants
└── N:M → cases (a través de case_participant)

evidence
├── N:1 → tenants
├── N:1 → cases
├── 1:N → chain_of_custody_entries
└── 1:N → documents (polimórfico)
```

### 9.2 Constraints de Foreign Keys

**Regla general:**
- `ON DELETE CASCADE` para relaciones donde el hijo no tiene sentido sin el padre (ej: tenant → cases)
- `ON DELETE RESTRICT` para relaciones donde se debe prevenir eliminación (ej: user → cases.lead_lawyer_id)
- `ON DELETE SET NULL` para relaciones opcionales (ej: completed_by en deadlines)

**Ejemplos:**

```sql
-- cases → tenants: CASCADE (si se elimina tenant, eliminar todos sus casos)
FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE

-- cases → users (lead_lawyer): RESTRICT (no permitir eliminar usuario que es lead de casos)
FOREIGN KEY (lead_lawyer_id) REFERENCES users(id) ON DELETE RESTRICT

-- deadlines → users (completed_by): SET NULL (si se elimina usuario, mantener el deadline)
FOREIGN KEY (completed_by) REFERENCES users(id) ON DELETE SET NULL
```

---

## 10. Migraciones de Laravel (Orden de Ejecución)

Las migraciones deben ejecutarse en este orden para respetar dependencias de Foreign Keys:

### Fase 1: Infraestructura
1. `2024_01_01_000001_create_subscription_tiers_table.php`
2. `2024_01_01_000002_create_tenants_table.php`
3. `2024_01_01_000003_create_users_table.php`
4. `2024_01_01_000004_create_password_reset_tokens_table.php` (Laravel Breeze)
5. `2024_01_01_000005_create_sessions_table.php` (Laravel Breeze)

### Fase 2: Multi-Tenancy
6. `2024_01_02_000001_create_tenant_user_table.php`
7. `2024_01_02_000002_create_team_invitations_table.php`

### Fase 3: Suscripciones (Cashier)
8. `2024_01_03_000001_create_subscriptions_table.php`
9. `2024_01_03_000002_create_subscription_items_table.php`

### Fase 4: Permisos (Spatie)
10. `2024_01_04_000001_create_permission_tables.php` (Spatie Permission)

### Fase 5: Core Legal
11. `2024_01_05_000001_create_cases_table.php`
12. `2024_01_05_000002_create_procedural_stage_history_table.php`
13. `2024_01_05_000003_create_participants_table.php`
14. `2024_01_05_000004_create_case_participant_table.php`

### Fase 6: Tiempo y Actuaciones
15. `2024_01_06_000001_create_hearings_table.php`
16. `2024_01_06_000002_create_deadlines_table.php`
17. `2024_01_06_000003_create_activities_table.php`

### Fase 7: Evidencias y Documentos
18. `2024_01_07_000001_create_evidence_table.php`
19. `2024_01_07_000002_create_chain_of_custody_entries_table.php`
20. `2024_01_07_000003_create_documents_table.php`

### Fase 8: Especialización CNPP
21. `2024_01_08_000001_create_precautionary_measures_table.php`
22. `2024_01_08_000002_create_alternative_solutions_table.php`

### Fase 9: Auditoría
23. `2024_01_09_000001_create_audit_logs_table.php`

---

## 11. Seeders Requeridos

### 11.1 SubscriptionTiersSeeder

Crear los tiers iniciales (Starter, Professional):

```php
DB::table('subscription_tiers')->insert([
    [
        'name' => 'Starter',
        'slug' => 'starter',
        'price_monthly' => 9900, // $99 USD
        'price_yearly' => 99000, // $990 USD
        'max_users' => 3,
        'max_storage_gb' => 10,
        'max_active_cases' => 20,
        'features' => json_encode([
            'client_portal' => false,
            'advanced_reports' => false,
            'audit_logs' => false,
            'api_access' => false,
        ]),
    ],
    [
        'name' => 'Professional',
        'slug' => 'professional',
        'price_monthly' => 24900, // $249 USD
        'price_yearly' => 249000, // $2490 USD
        'max_users' => 10,
        'max_storage_gb' => 50,
        'max_active_cases' => 100,
        'features' => json_encode([
            'client_portal' => true,
            'advanced_reports' => true,
            'audit_logs' => true,
            'api_access' => false,
        ]),
    ],
]);
```

### 11.2 PermissionsAndRolesSeeder

Crear los 40+ permisos y 6 roles base:

**Permisos:**
- `cases.view_all`, `cases.view_assigned`, `cases.create`, `cases.edit`, `cases.delete`, `cases.close`, `cases.assign`
- `participants.view`, `participants.create`, `participants.edit`, `participants.delete`
- `documents.view`, `documents.upload`, `documents.delete`, `documents.share_with_client`
- `hearings.view`, `hearings.create`, `hearings.edit`, `hearings.delete`, `hearings.record_result`
- `activities.view`, `activities.create`, `activities.edit`, `activities.delete`
- `evidence.view`, `evidence.create`, `evidence.edit`, `evidence.custody_manage`
- `deadlines.view`, `deadlines.create`, `deadlines.edit`, `deadlines.complete`
- `measures.view`, `measures.create`, `measures.edit`
- `solutions.view`, `solutions.create`, `solutions.edit`
- `reports.basic`, `reports.advanced`, `reports.export`
- `team.view`, `team.invite`, `team.edit_roles`, `team.remove`
- `subscription.view`, `subscription.manage`
- `settings.view`, `settings.edit`

**Roles:** (sin team_id, se crean por tenant al crear el despacho)
- `owner`, `litigante`, `asociado`, `paralegal`, `administrativo`, `cliente`

### 11.3 CrimeTypesSeeder

Catálogo de delitos del CNPP:

```php
DB::table('crime_types')->insert([
    ['name' => 'Homicidio Doloso', 'classification' => 'doloso', 'severity' => 'grave'],
    ['name' => 'Homicidio Culposo', 'classification' => 'culposo', 'severity' => 'no_grave'],
    ['name' => 'Feminicidio', 'classification' => 'doloso', 'severity' => 'grave'],
    ['name' => 'Robo Simple', 'classification' => 'doloso', 'severity' => 'no_grave'],
    ['name' => 'Robo con Violencia', 'classification' => 'doloso', 'severity' => 'grave'],
    ['name' => 'Fraude', 'classification' => 'doloso', 'severity' => 'no_grave'],
    ['name' => 'Abuso Sexual', 'classification' => 'doloso', 'severity' => 'grave'],
    ['name' => 'Violación', 'classification' => 'doloso', 'severity' => 'grave'],
    ['name' => 'Secuestro', 'classification' => 'doloso', 'severity' => 'grave'],
    ['name' => 'Extorsión', 'classification' => 'doloso', 'severity' => 'grave'],
    ['name' => 'Trata de Personas', 'classification' => 'doloso', 'severity' => 'grave'],
    ['name' => 'Narcomenudeo', 'classification' => 'doloso', 'severity' => 'grave'],
    ['name' => 'Portación de Arma Prohibida', 'classification' => 'doloso', 'severity' => 'grave'],
    // ... más delitos
]);
```

### 11.4 PrecautionaryMeasureTypesSeeder

Catálogo de tipos de medidas cautelares (CNPP Art. 155):

```php
$measures = [
    'presentacion_periodica',
    'exhibicion_garantia',
    'embargo_bienes',
    'inmovilizacion_cuentas',
    'prohibicion_salir_pais',
    'prohibicion_salir_circunscripcion',
    'prohibicion_concurrir_lugares',
    'prohibicion_comunicarse',
    'separacion_domicilio',
    'suspension_derechos',
    'internamiento_adicciones',
    'localizador_electronico',
    'resguardo_domiciliario',
    'prision_preventiva',
];
```

---

## 12. Consideraciones de Seguridad

### 12.1 Tenant Scoping

**Implementación con Global Scope:**

```php
// app/Models/Traits/TenantScoped.php
trait TenantScoped
{
    protected static function bootTenantScoped()
    {
        static::creating(function ($model) {
            if (!$model->tenant_id && auth()->check()) {
                $model->tenant_id = auth()->user()->currentTenant->id;
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check() && auth()->user()->currentTenant) {
                $builder->where('tenant_id', auth()->user()->currentTenant->id);
            }
        });
    }
}
```

### 12.2 Políticas de Acceso (Policies)

Siempre verificar tenant ownership:

```php
public function view(User $user, Case $case)
{
    return $user->tenants->contains($case->tenant_id)
           && $user->hasPermissionTo('cases.view_all', $case->tenant);
}
```

### 12.3 Validación de Límites por Tier

Ejemplo para crear caso:

```php
public function store(Request $request)
{
    $tenant = auth()->user()->currentTenant;
    $activeCases = $tenant->cases()->where('status', 'activo')->count();

    if ($activeCases >= $tenant->subscriptionTier->max_active_cases) {
        abort(403, 'Has alcanzado el límite de casos activos de tu plan.');
    }

    // Crear caso...
}
```

### 12.4 Encriptación de Datos Sensibles

Campos sensibles deben usar Laravel casting `encrypted`:

```php
// En model Participant
protected $casts = [
    'contact_details' => 'encrypted:array',
];
```

---

## Conclusión

Este esquema de base de datos está diseñado para:

- ✅ **Multi-tenancy seguro** con aislamiento total entre despachos
- ✅ **Escalabilidad** hasta 1000+ tenants en single database
- ✅ **Performance optimizado** con índices estratégicos
- ✅ **Trazabilidad completa** con audit logs y history tables
- ✅ **Especialización en CNPP** con entidades específicas del proceso penal mexicano
- ✅ **Flexibilidad** con campos JSON para evolución sin migraciones
- ✅ **Integridad referencial** con foreign keys y soft deletes

**Próximo paso:** Implementar las migraciones de Laravel siguiendo este esquema.

---

**Última actualización:** 19 de noviembre de 2025
**Revisado por:** Equipo Qadra
**Estado:** ✅ Aprobado para implementación
