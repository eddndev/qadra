# Diario del Sprint 2: Foundation & Auth

**Periodo:** 2025-11-30 - [Fecha de Fin]

**Épica Maestra en GitHub:** [#9 - Sprint 2: Foundation & Auth](https://github.com/eddndev/qadra/issues/9)

**Estado:** EN PROGRESO

---

## 1. Objetivo del Sprint

Establecer la arquitectura multi-tenant del sistema y el sistema de autenticación/autorización (RBAC) que servirán como base para todas las funcionalidades futuras. Al finalizar este sprint, un usuario podrá registrar un despacho, invitar miembros a su equipo y gestionar roles y permisos.

## 2. Alcance y Tareas Incluidas

### User Stories Incluidas

- [ ] `#10 - [US-01] Registro de Nuevo Despacho (Tenant Creation)`
- [ ] `#11 - [US-02] Invitación de Miembros al Equipo`
- [ ] `#12 - [US-05] Cambio de Tenant (Multi-Workspace)`
- [ ] `#13 - [US-25] Gestión de Roles y Permisos (RBAC Base)`

### Entregables Técnicos

#### Migraciones (Database)
- [x] `create_subscription_tiers_table` - Planes de suscripción (Starter, Professional)
- [x] `create_tenants_table` - Tabla principal de despachos/workspaces
- [x] `modify_users_table` - Agregar campos ULID y multi-tenant
- [x] `create_tenant_user_table` - Relación many-to-many users-tenants
- [x] `create_team_invitations_table` - Invitaciones pendientes

#### Modelos (Eloquent)
- [x] `SubscriptionTier` - Plan de suscripción con límites y features
- [x] `Tenant` - Despacho/workspace con datos fiscales
- [x] `User` - Usuario con soporte multi-tenant
- [x] `TeamInvitation` - Invitación a unirse al despacho

#### Traits
- [x] `TenantScoped` - Global scope para filtrar por tenant_id automáticamente
- [x] `HasTenants` - Relación de usuario con múltiples tenants

#### Middleware
- [x] `IdentifyTenant` - Detectar y establecer tenant actual en sesión
- [x] `EnsureTenantScope` - Verificar que usuario pertenece al tenant

#### Spatie Permission
- [x] Configurar teams (tenant_id) en config/permission.php
- [x] Crear 6 roles base: owner, litigante, asociado, paralegal, administrativo, cliente
- [x] Crear 40+ permisos granulares

#### Seeders
- [x] `SubscriptionTiersSeeder` - Starter y Professional con límites
- [x] `PermissionsSeeder` - Todos los permisos del sistema
- [x] `RolesSeeder` - 6 roles con permisos asignados

#### Componentes Livewire
- [ ] `RegisterTenantForm` - Formulario de registro de despacho
- [ ] `InviteTeamMemberForm` - Modal para invitar miembros
- [ ] `TenantSwitcher` - Dropdown para cambiar de workspace
- [ ] `TeamManagement` - Tabla de miembros del equipo
- [ ] `PendingInvitations` - Lista de invitaciones pendientes

#### Vistas Blade
- [ ] `auth/register-tenant.blade.php` - Página de registro
- [ ] `team/index.blade.php` - Gestión de equipo
- [ ] `team/invitations.blade.php` - Invitaciones pendientes
- [ ] `components/tenant-switcher.blade.php` - Componente de navbar

#### Otros
- [x] Jobs: `DeleteExpiredInvitationsJob` (corre diariamente)
- [ ] Notifications: `TeamInvitationNotification`, `InvitationAcceptedNotification`
- [x] Events: `TenantCreated`, `MemberJoined`
- [x] Policies: `TenantPolicy`, `TeamInvitationPolicy`

#### Tests (Area: Testing)
- [ ] **Unit Tests:**
  - [ ] `TenantTest` - Validaciones de modelo, relaciones, scopes
  - [ ] `UserTest` - Multi-tenant relationships, currentTenant method
  - [ ] `TeamInvitationTest` - Token generation, expiration logic
  - [ ] `TenantScopedTraitTest` - Global scope functionality
- [ ] **Feature Tests:**
  - [ ] `RegisterTenantTest` - Flujo completo de registro de despacho
  - [ ] `TeamInvitationTest` - Invitar, aceptar, rechazar, expirar
  - [ ] `TenantSwitchingTest` - Cambio entre workspaces
  - [ ] `RBACTest` - Verificar permisos por rol (owner, litigante, etc.)
- [ ] **Integration Tests:**
  - [ ] `TenantIsolationTest` - Verificar que datos de un tenant NO son visibles para otro
  - [ ] `MiddlewareTest` - `IdentifyTenant`, `EnsureTenantScope`
  - [ ] `SpatiePermissionTeamsTest` - Roles scoped por tenant funcionan correctamente

---

## 3. Registro de Decisiones Técnicas

*Esta sección es un log vivo. Se actualiza a medida que se toman decisiones durante el sprint.*

*   **2025-12-02:** Implementación inicial de migraciones, modelos y traits para el núcleo multi-tenant.
    *   **Razón:** Se crearon las tablas `subscription_tiers`, `tenants`, `tenant_user`, `team_invitations`. La tabla `users` fue modificada para usar ULIDs como PK y añadir campos de perfil. Los modelos `SubscriptionTier`, `Tenant`, `User` (modificado) y `TeamInvitation` fueron creados. Se implementaron los traits `HasTenants` (para `User`) y `TenantScoped` (para modelos relacionados con `Tenant`), usando `session('current_tenant_id')` como base para el scoping global. El modelo `User` también fue actualizado para incluir el trait `HasRoles` de Spatie, que será requerido para la gestión de permisos. Se ha notificado al equipo sobre la necesidad de instalar el paquete `spatie/laravel-permission`.
*   **2025-12-03:** Configuración de Middleware de Tenancy y Spatie Permission.
    *   **Razón:** Se implementaron los middleware `IdentifyTenant` (para detectar y setear el tenant global) y `EnsureTenantScope` (seguridad). Se configuró Spatie Permission con `teams=true` y se modificó su migración para soportar ULIDs en `team_foreign_key` (tenant_id) y `model_morph_key`. Se crearon Seeders para Planes de Suscripción y Permisos Base (globales). Se implementaron Jobs (`DeleteExpiredInvitationsJob`) y Eventos (`TenantCreated`, `MemberJoined`) junto con sus Listeners y Policies.

---

## 4. Registro de Bloqueos y Soluciones

*Esta sección documenta los problemas inesperados y cómo se resolvieron.*

*   **2025-12-03:**
    *   **Problema:** Conflicto de conexión de base de datos (SQLite vs MySQL) al ejecutar migraciones y seeders, debido a un fallback incorrecto en `config/database.php` y `config/cache.php` cuando falta la variable de entorno `DB_CACHE_CONNECTION`.
    *   **Solución:** Se modificó `config/database.php` para usar `mysql` como fallback default. Se modificó `config/cache.php` para usar `mysql` si `env('DB_CACHE_CONNECTION')` es null. Se comentó temporalmente la limpieza de caché en las migraciones de Spatie para desbloquear el proceso inicial.

---

## 5. Dependencias

### Paquetes a Instalar

```bash
# Autenticación base
composer require laravel/breeze --dev
php artisan breeze:install livewire

# Permisos y roles
composer require spatie/laravel-permission

# Helpers (opcional)
composer require laravel/helpers
```

### Configuraciones Requeridas

1. **Laravel Breeze con Livewire:** Ejecutar instalación y compilar assets
2. **Spatie Permission:** Publicar migraciones y configurar teams
3. **Mail:** Configurar SMTP para invitaciones (puede ser Mailtrap en dev)

---

## 6. Asignación de Tareas por Área

| Área | Responsable | GitHub | Tareas |
|------|-------------|--------|--------|
| **Backend** | Gael, Eduardo | @Arzubide, @eddndev | Migraciones, Modelos, Traits, Middleware, Seeders, Jobs, Events |
| **Frontend** | Karla | @Karlaelenaht | Componentes Livewire, Vistas Blade |
| **UX/UI** | Hatziry | @vhhatziry | Diseño de formularios de registro e invitación |
| **Testing** | Diego | @Dvan88 | Unit Tests, Feature Tests, Integration Tests (ver sección Tests) |
| **CI/CD** | Eduardo | @eddndev | Review de PRs, merge a main, GitHub Actions |

### Asignación de User Stories

| User Story | Backend | Frontend | UX/UI | Testing |
|------------|---------|----------|-------|---------|
| US-01: Registro de Despacho | @Arzubide | @Karlaelenaht | @vhhatziry | @Dvan88 |
| US-02: Invitación de Miembros | @Arzubide | @Karlaelenaht | @vhhatziry | @Dvan88 |
| US-05: Cambio de Tenant | @eddndev | @Karlaelenaht | @vhhatziry | @Dvan88 |
| US-25: Gestión de Roles (RBAC) | @eddndev, @Arzubide | - | - | @Dvan88 |

### Distribución de Tests por Área

| Test | Responsable Primario | Colaborador |
|------|---------------------|-------------|
| Unit Tests (Modelos) | @Dvan88 | @Arzubide, @eddndev |
| Feature Tests (Flujos) | @Dvan88 | @Karlaelenaht |
| Integration Tests (Multi-tenant) | @Dvan88 | @eddndev |

---

## 7. Criterios de Aceptación del Sprint

El Sprint 2 se considera **COMPLETADO** cuando:

- [ ] Un usuario puede registrar un nuevo despacho desde cero
- [ ] Al registrar, se crea automáticamente el usuario owner y los 6 roles base
- [ ] El owner puede invitar miembros por email con rol específico
- [ ] Las invitaciones expiran en 7 días y se pueden reenviar
- [ ] Al aceptar invitación, el usuario se vincula al tenant con su rol
- [ ] Si un usuario pertenece a múltiples despachos, puede cambiar entre ellos
- [ ] Los permisos funcionan correctamente (litigante puede crear casos, paralegal no puede)
- [ ] Todos los queries están filtrados automáticamente por tenant_id
- [ ] Tests de Feature pasan con cobertura > 80% para auth

---

## 8. Resultado del Sprint (A completar al final)

*   **Tareas Completadas:** [ ] X de Y
*   **Resumen:** [Escribe un resumen ejecutivo del resultado del sprint. ¿Se cumplió el objetivo?]
*   **Aprendizajes / Retrospectiva:**
    *   **Qué funcionó bien:** [Anota los puntos positivos y las prácticas exitosas.]
    *   **Qué se puede mejorar:** [Identifica áreas de mejora para futuros sprints.]

---

## 9. Referencias

- **Documentación de User Stories:** `/docs/04-user-stories.md` (US-01, US-02, US-05, US-25)
- **Esquema de Base de Datos:** `/docs/03-database-schema.md`
- **Arquitectura Técnica:** `/docs/00-arquitectura-tecnica.md`
- **Spatie Permission Docs:** https://spatie.be/docs/laravel-permission
- **Laravel Breeze Docs:** https://laravel.com/docs/11.x/starter-kits#breeze-and-livewire

---

**Sprint iniciado por:** Eduardo (Tech Lead)
**Fecha de inicio:** 2025-11-30
