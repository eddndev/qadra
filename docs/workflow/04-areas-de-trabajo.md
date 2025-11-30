# Áreas de Trabajo del Equipo Qadra

**Versión:** 1.0
**Última Actualización:** 29 de noviembre de 2025
**Proyecto:** Qadra - Sistema de Gestión Procesal Penal

---

## Resumen Ejecutivo

El desarrollo de Qadra se organiza en **5 áreas de trabajo** especializadas. Cada área tiene responsabilidades específicas, entregables definidos y tecnologías asociadas. Esta estructura permite:

- Especialización técnica por área
- Paralelización del trabajo entre áreas
- Claridad en la asignación de issues
- Trazabilidad de responsabilidades

---

## Estructura del Equipo

| Miembro | GitHub | Área Principal | Rol Especial |
|---------|--------|----------------|--------------|
| **Eduardo** | @eddndev | Backend, CI/CD | Tech Lead, Code Reviewer |
| **Hatziry** | @vhhatziry | UX/UI | Diseño de interfaces |
| **Karla** | @Karlaelenaht | Frontend | Implementación Livewire/Blade |
| **Gael** | @Arzubide | Backend | Modelos, Migraciones, APIs |
| **Diego** | @Dvan88 | Testing | QA, Tests unitarios e integración |

> **Nota:** Eduardo participa en Backend y es responsable exclusivo de CI/CD. También actúa como Code Reviewer para todos los PRs.

---

## 1. Diseño UX/UI

### Descripción

Área responsable de la experiencia de usuario y la interfaz visual. Define cómo se ve y cómo se siente la aplicación antes de que se implemente código.

### Responsabilidades

- Crear wireframes y mockups de nuevas funcionalidades
- Mantener y evolucionar el Design System (`docs/02-design-system.md`)
- Definir flujos de usuario (user flows) para cada módulo
- Diseñar componentes reutilizables en Figma
- Validar accesibilidad (WCAG AA) en diseños
- Especificar estados de componentes (hover, focus, error, loading, empty)
- Documentar decisiones de diseño

### Tecnologías y Herramientas

| Herramienta | Uso |
|-------------|-----|
| **Figma** | Diseño de interfaces y prototipos |
| **Heroicons v2** | Librería de iconos del proyecto |
| **Tailwind CSS Docs** | Referencia para tokens de diseño |
| **Contrast Checker** | Validación de accesibilidad |

### Entregables por Sprint

| Entregable | Formato | Destino |
|------------|---------|---------|
| Wireframes de pantallas | Figma | Link en issue |
| Especificación de componentes | Markdown + imágenes | `docs/design/` |
| Actualización Design System | Markdown | `docs/02-design-system.md` |
| Assets exportados (iconos, imágenes) | SVG/PNG | `resources/images/` |

### Labels de GitHub

- `Area: UX/UI` - Issues relacionadas con diseño
- `Type: Design` - Tareas específicas de diseño

### Flujo de Trabajo

```
1. Recibir requisito (User Story)
        ↓
2. Crear wireframe low-fidelity
        ↓
3. Validar con equipo/stakeholder
        ↓
4. Crear mockup high-fidelity
        ↓
5. Documentar especificaciones
        ↓
6. Entregar a Frontend para implementación
```

### Criterios de Aceptación para Entregables

- [ ] Diseño responsive (mobile, tablet, desktop)
- [ ] Estados de componentes definidos (normal, hover, focus, disabled, error)
- [ ] Colores usando tokens del Design System
- [ ] Tipografía consistente con escala definida
- [ ] Contraste WCAG AA validado

---

## 2. Implementación Frontend

### Descripción

Área responsable de convertir los diseños en interfaces funcionales. Implementa componentes visuales, interactividad y la capa de presentación de la aplicación.

### Responsabilidades

- Implementar vistas Blade siguiendo los diseños aprobados
- Crear componentes Livewire para funcionalidad dinámica
- Desarrollar componentes Blade reutilizables (`x-button`, `x-card`, etc.)
- Implementar interactividad con Alpine.js
- Aplicar estilos usando clases de Tailwind CSS v4
- Asegurar responsive design en todos los breakpoints
- Implementar estados de carga (skeleton, spinners)
- Manejar validación de formularios del lado cliente

### Tecnologías y Herramientas

| Tecnología | Uso |
|------------|-----|
| **Blade** | Motor de plantillas de Laravel |
| **Livewire 3** | Componentes dinámicos sin JavaScript pesado |
| **Alpine.js** | Interactividad ligera (dropdowns, modales, tabs) |
| **Tailwind CSS v4** | Framework de estilos utility-first |
| **Heroicons** | Iconos SVG |
| **Vite** | Bundler y hot reload |

### Entregables por Sprint

| Entregable | Formato | Destino |
|------------|---------|---------|
| Componentes Blade | `.blade.php` | `resources/views/components/` |
| Componentes Livewire | `.php` + `.blade.php` | `app/Livewire/` + `resources/views/livewire/` |
| Layouts | `.blade.php` | `resources/views/layouts/` |
| Páginas/Vistas | `.blade.php` | `resources/views/` |

### Labels de GitHub

- `Area: Frontend` - Issues de implementación frontend
- `Module: UI/UX` - Relacionado con interfaz visual

### Estructura de Archivos

```
resources/
├── views/
│   ├── components/           # Componentes Blade reutilizables
│   │   ├── button.blade.php
│   │   ├── card.blade.php
│   │   ├── badge.blade.php
│   │   ├── form/
│   │   │   ├── input.blade.php
│   │   │   ├── select.blade.php
│   │   │   └── textarea.blade.php
│   │   └── ...
│   ├── layouts/
│   │   ├── app.blade.php     # Layout principal (con sidebar)
│   │   ├── guest.blade.php   # Layout para auth (login, register)
│   │   └── ...
│   ├── livewire/             # Vistas de componentes Livewire
│   │   ├── cases/
│   │   ├── hearings/
│   │   └── ...
│   └── pages/                # Páginas estáticas
├── css/
│   └── app.css               # Tokens del Design System
└── js/
    └── app.js                # Alpine.js y plugins
```

### Criterios de Aceptación para Entregables

- [ ] Componente coincide con diseño aprobado (pixel-perfect no requerido, fidelidad sí)
- [ ] Funciona en Chrome, Firefox, Safari, Edge
- [ ] Responsive en mobile (≥375px), tablet (≥768px), desktop (≥1024px)
- [ ] Sin errores en consola del navegador
- [ ] Estados de loading/error implementados
- [ ] Accesible con teclado (tab navigation, focus visible)

---

## 3. Implementación Backend

### Descripción

Área responsable de la lógica de negocio, acceso a datos, autenticación, autorización y APIs. Es el corazón funcional de la aplicación.

### Responsabilidades

- Crear y mantener modelos Eloquent con relaciones
- Implementar migraciones de base de datos
- Desarrollar controladores y rutas
- Crear servicios para lógica de negocio compleja
- Implementar políticas de autorización (Policies)
- Configurar middleware (TenantScope, etc.)
- Crear seeders para datos iniciales y de prueba
- Implementar observers para auditoría
- Desarrollar jobs para tareas asíncronas
- Crear notificaciones (email, base de datos)

### Tecnologías y Herramientas

| Tecnología | Uso |
|------------|-----|
| **Laravel 12** | Framework PHP principal |
| **Eloquent ORM** | Mapeo objeto-relacional |
| **Spatie Permission** | RBAC (roles y permisos) |
| **Laravel Cashier** | Integración con Stripe |
| **MySQL 8+** | Base de datos principal |
| **Redis** | Cache y colas |
| **Laravel Queues** | Procesamiento asíncrono |

### Entregables por Sprint

| Entregable | Formato | Destino |
|------------|---------|---------|
| Modelos | `.php` | `app/Models/` |
| Controladores | `.php` | `app/Http/Controllers/` |
| Migraciones | `.php` | `database/migrations/` |
| Seeders | `.php` | `database/seeders/` |
| Policies | `.php` | `app/Policies/` |
| Services | `.php` | `app/Services/` |
| Requests (validación) | `.php` | `app/Http/Requests/` |

### Labels de GitHub

- `Area: Backend` - Issues de implementación backend
- `Module: Database` - Migraciones y esquema
- `Module: Auth` - Autenticación y autorización
- `Module: Core` - Lógica de negocio principal

### Estructura de Archivos

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── CaseController.php
│   │   ├── ParticipantController.php
│   │   └── ...
│   ├── Middleware/
│   │   ├── EnsureTenantScope.php
│   │   └── ...
│   └── Requests/
│       ├── StoreCaseRequest.php
│       └── ...
├── Models/
│   ├── Tenant.php
│   ├── User.php
│   ├── LegalCase.php          # "Case" es palabra reservada en PHP
│   ├── Participant.php
│   ├── Hearing.php
│   ├── Deadline.php
│   ├── Evidence.php
│   └── Traits/
│       ├── TenantScoped.php
│       └── HasAuditLog.php
├── Policies/
│   ├── CasePolicy.php
│   └── ...
├── Services/
│   ├── CaseService.php
│   ├── DeadlineService.php
│   └── ...
├── Observers/
│   ├── CaseObserver.php
│   └── ...
└── Jobs/
    ├── SendDeadlineReminder.php
    └── ...

database/
├── migrations/
│   ├── 2024_01_01_000001_create_subscription_tiers_table.php
│   ├── 2024_01_01_000002_create_tenants_table.php
│   └── ... (23 migraciones según docs/03-database-schema.md)
└── seeders/
    ├── SubscriptionTiersSeeder.php
    ├── PermissionsAndRolesSeeder.php
    └── ...
```

### Criterios de Aceptación para Entregables

- [ ] Modelo tiene relaciones correctamente definidas
- [ ] Migración sigue convenciones del esquema (`docs/03-database-schema.md`)
- [ ] Validación implementada en Form Requests
- [ ] Autorización implementada en Policy
- [ ] Tenant scoping aplicado (datos aislados por despacho)
- [ ] Sin queries N+1 (usar eager loading)
- [ ] Código sigue PSR-12

---

## 4. Integración y Testing

### Descripción

Área responsable de asegurar la calidad del software. Integra los componentes de frontend y backend, y verifica que el sistema funcione correctamente de extremo a extremo.

### Responsabilidades

- Escribir tests unitarios para modelos y servicios
- Escribir tests de integración para controladores
- Escribir tests de feature para flujos completos
- Realizar pruebas manuales de QA
- Verificar integración frontend-backend
- Documentar bugs encontrados con pasos para reproducir
- Validar criterios de aceptación de cada issue
- Realizar pruebas de regresión antes de releases
- Verificar rendimiento básico (no timeouts, queries optimizadas)

### Tecnologías y Herramientas

| Tecnología | Uso |
|------------|-----|
| **PHPUnit** | Tests unitarios y de integración |
| **Laravel Dusk** | Tests de navegador (E2E) |
| **Pest PHP** | Sintaxis alternativa para tests (opcional) |
| **Laravel Telescope** | Debugging y profiling |
| **Postman/Insomnia** | Testing de APIs |

### Entregables por Sprint

| Entregable | Formato | Destino |
|------------|---------|---------|
| Tests unitarios | `.php` | `tests/Unit/` |
| Tests de feature | `.php` | `tests/Feature/` |
| Tests de navegador | `.php` | `tests/Browser/` |
| Reporte de bugs | Issue en GitHub | Con label `Type: Bug` |
| Checklist de QA | Comentario en PR | - |

### Labels de GitHub

- `Area: Testing` - Issues relacionadas con testing
- `Type: Bug` - Bugs encontrados durante QA
- `Status: Needs QA` - PRs listos para testing

### Estructura de Archivos

```
tests/
├── Unit/
│   ├── Models/
│   │   ├── CaseTest.php
│   │   ├── ParticipantTest.php
│   │   └── ...
│   └── Services/
│       ├── DeadlineServiceTest.php
│       └── ...
├── Feature/
│   ├── Auth/
│   │   ├── LoginTest.php
│   │   ├── RegistrationTest.php
│   │   └── ...
│   ├── Cases/
│   │   ├── CreateCaseTest.php
│   │   ├── UpdateCaseTest.php
│   │   └── ...
│   └── ...
└── Browser/                    # Laravel Dusk (E2E)
    ├── LoginTest.php
    └── ...
```

### Checklist de QA por Feature

```markdown
## Checklist de QA - [Nombre de la Feature]

### Funcionalidad
- [ ] Happy path funciona correctamente
- [ ] Edge cases manejados (inputs vacíos, límites, etc.)
- [ ] Mensajes de error claros y útiles
- [ ] Validaciones funcionan correctamente

### UI/UX
- [ ] Diseño coincide con mockup aprobado
- [ ] Responsive en mobile/tablet/desktop
- [ ] Estados de loading visibles
- [ ] Feedback visual en acciones (toasts, alerts)

### Seguridad
- [ ] Solo usuarios autorizados pueden acceder
- [ ] Datos de otros tenants no son accesibles
- [ ] Sin exposición de datos sensibles en respuestas

### Performance
- [ ] Página carga en < 3 segundos
- [ ] Sin queries N+1 (verificar con Telescope)
- [ ] Sin errores en consola del navegador
```

### Criterios de Aceptación para Entregables

- [ ] Tests pasan en CI (`php artisan test`)
- [ ] Cobertura de código > 60% para código nuevo
- [ ] Bugs documentados con pasos para reproducir
- [ ] Checklist de QA completado antes de aprobar PR

---

## 5. CI/CD (Eduardo)

### Descripción

Área responsable de la automatización del pipeline de desarrollo, despliegue y mantenimiento de infraestructura. **Esta área es responsabilidad exclusiva de Eduardo.**

### Responsabilidades

- Configurar y mantener GitHub Actions workflows
- Automatizar ejecución de tests en cada PR
- Configurar linters y análisis estático de código
- Gestionar ambientes (desarrollo, staging, producción)
- Configurar despliegue automático
- Gestionar secrets y variables de entorno
- Monitorear salud de la aplicación en producción
- Configurar backups de base de datos
- Gestionar dominios y certificados SSL

### Tecnologías y Herramientas

| Tecnología | Uso |
|------------|-----|
| **GitHub Actions** | CI/CD pipelines |
| **Laravel Forge** / **Ploi** | Deployment (opcional) |
| **Docker** | Contenedorización (opcional) |
| **Laravel Envoy** | Deployment scripts |
| **Sentry** | Monitoreo de errores |
| **Laravel Horizon** | Monitoreo de colas |

### Entregables

| Entregable | Formato | Destino |
|------------|---------|---------|
| Workflows de CI | `.yml` | `.github/workflows/` |
| Scripts de deploy | `.php` / `.sh` | `Envoy.blade.php` / `scripts/` |
| Documentación de infraestructura | Markdown | `docs/infrastructure/` |

### Labels de GitHub

- `Area: CI/CD` - Issues de infraestructura y automatización
- `Type: Chore` - Tareas de mantenimiento

### Workflows Mínimos Requeridos

```yaml
# .github/workflows/ci.yml
name: CI Pipeline

on:
  push:
    branches: [main]
  pull_request:
    branches: [main]

jobs:
  tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      - name: Install dependencies
        run: composer install --no-interaction
      - name: Run tests
        run: php artisan test

  lint:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Run Pint (PHP CS Fixer)
        run: ./vendor/bin/pint --test
```

### Criterios de Aceptación

- [ ] CI ejecuta tests en cada PR
- [ ] PRs no pueden mergearse si CI falla
- [ ] Deploy automático a staging en merge a `main`
- [ ] Secrets gestionados de forma segura (no en código)

---

## Matriz de Responsabilidades (RACI)

| Actividad | UX/UI | Frontend | Backend | Testing | CI/CD |
|-----------|:-----:|:--------:|:-------:|:-------:|:-----:|
| Diseño de interfaces | **R** | C | I | I | - |
| Implementación de vistas | C | **R** | I | I | - |
| Lógica de negocio | I | I | **R** | I | - |
| Migraciones de BD | I | I | **R** | I | - |
| Tests unitarios | - | I | **R** | C | - |
| Tests de integración | - | I | C | **R** | - |
| QA manual | I | I | I | **R** | - |
| Pipelines de CI | - | - | - | I | **R** |
| Deployment | - | - | I | I | **R** |
| Code Review | C | C | C | C | **A** |

**Leyenda:**
- **R** = Responsible (Ejecuta el trabajo)
- **A** = Accountable (Responsable final - Eduardo para Code Review)
- **C** = Consulted (Se le consulta)
- **I** = Informed (Se le informa)

---

## Flujo de Colaboración entre Áreas

```
┌─────────────┐     Diseños      ┌─────────────┐
│   UX/UI     │ ───────────────→ │  Frontend   │
└─────────────┘                  └──────┬──────┘
                                        │
                                        │ Eventos/Datos
                                        ↓
┌─────────────┐     APIs/Data    ┌─────────────┐
│   Backend   │ ←───────────────→│  Frontend   │
└──────┬──────┘                  └─────────────┘
       │
       │ Código completo
       ↓
┌─────────────┐     Validación   ┌─────────────┐
│   Testing   │ ←───────────────→│  Todas      │
└──────┬──────┘                  └─────────────┘
       │
       │ PR aprobado
       ↓
┌─────────────┐
│   CI/CD     │ ──→ Deploy
└─────────────┘
```

---

## Asignación de Issues por Área

Cada issue debe tener un label de área para facilitar la asignación:

```bash
# Crear labels de área (ejecutar una vez)
gh label create "Area: UX/UI" --color "E99695" --description "Diseño de interfaces"
gh label create "Area: Frontend" --color "C5DEF5" --description "Implementación de vistas"
gh label create "Area: Backend" --color "BFD4F2" --description "Lógica de negocio y APIs"
gh label create "Area: Testing" --color "D4C5F9" --description "Tests y QA"
gh label create "Area: CI/CD" --color "FEF2C0" --description "Infraestructura y deployment"
```

---

## Documentación Relacionada

- **Metodología:** `docs/AGENTS.md`
- **Flujo de trabajo:** `docs/workflow/01-team-workflow.md`
- **Design System:** `docs/02-design-system.md`
- **Esquema de BD:** `docs/03-database-schema.md`
- **User Stories:** `docs/04-user-stories.md`

---

**Última actualización:** 30 de noviembre de 2025
**Autor:** Equipo Qadra
**Asignaciones confirmadas:** Sprint 2
