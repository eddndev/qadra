# Diario del Sprint 3: Core Legal

**Periodo:** [Fecha de Inicio] - [Fecha de Fin]

**Épica Maestra en GitHub:** [#14 - Sprint 3: Core Legal](https://github.com/eddndev/qadra/issues/14)

**Estado:** ✅ COMPLETADO (Funcionalidad Backend y UI Básica)

---

## 1. Objetivo del Sprint

Implementar el corazón del sistema - gestión de expedientes penales, participantes y transición de etapas procesales según el CNPP. Al finalizar este sprint, los usuarios podrán crear casos, agregar participantes y avanzar el caso a través de las etapas del proceso penal.

## 2. Alcance y Tareas Incluidas

### User Stories Incluidas

- ✅ `#15 - [US-06] Apertura de Nuevo Caso Penal` (Implementado: Formulario, Límite de Casos, Historial Inicial)
- ✅ `#16 - [US-07] Gestión de Participantes del Caso` (Implementado: CRUD básico, Asociación con Caso)
- ✅ `#17 - [US-08] Transición de Etapa Procesal con Historial` (Implementado: Cambio de Etapa/Estatus, Historial Inmutable)
- ✅ `#18 - [US-10] Listado y Filtrado de Casos` (Implementado: Listado con búsqueda y filtros básicos)

### Entregables Técnicos

#### Migraciones (Database)
- ✅ `create_legal_cases_table` - Tabla principal de expedientes (usando `legal_cases`)
- ✅ `create_procedural_stage_history_table` - Historial inmutable de etapas
- ✅ `create_participants_table` - Personas involucradas
- ✅ `create_case_participant_table` - Pivot case-participant con rol
- ✅ `create_crime_types_table` - Catálogo de delitos
- ✅ `create_precautionary_measure_types_table` - Catálogo de medidas cautelares

#### Modelos (Eloquent)
- ✅ `LegalCase` - Expediente penal (con `HasTenants`, `SoftDeletes`, relaciones)
- ✅ `ProceduralStageHistory` - Historial de etapas (inmutable, `HasTenants`)
- ✅ `Participant` - Personas físicas/morales/autoridades (con `HasTenants`, `SoftDeletes`, `encrypted:array` para contactos)
- ✅ `CaseParticipant` - Pivot con rol en el caso
- ✅ `CrimeType` - Catálogo de delitos
- ✅ `PrecautionaryMeasureType` - Catálogo de medidas cautelares

#### Services
- [ ] `CaseStageService` - Lógica de transiciones de etapa (Implementada directamente en Livewire por simplicidad, puede refactorizarse a Service)

#### Observers
- [ ] `CaseObserver` - Auto-crear primer registro de historial (Implementada directamente en Livewire por simplicidad, puede refactorizarse a Observer)

#### Seeders
- ✅ `CrimeTypesSeeder` - Catálogo de delitos del CNPP
- ✅ `PrecautionaryMeasureTypesSeeder` - Catálogo de medidas cautelares (añadido en este sprint)

#### Componentes Livewire
- ✅ `CreateCaseForm` - Formulario de nuevo caso
- ✅ `CaseList` - Listado con filtros y paginación
- ✅ `ParticipantManager` - CRUD de participantes en caso
- ✅ `ChangeCaseStage` - Modal para avanzar etapa (previamente `StageTransitionModal`)
- ✅ `ShowCase` - Vista de detalle del caso (contenedor)

#### Vistas Blade
- ✅ `cases/index.blade.php` - Redirige a `CaseList` Livewire
- ✅ `cases/create.blade.php` - Redirige a `CreateCaseForm` Livewire
- ✅ `cases/show.blade.php` - Detalle del caso (tabs, usando `ShowCase` Livewire)
- [ ] `components/stage-badge.blade.php` - Badge de etapa con color (implementado inline en vistas)

#### Tests
- [ ] **Unit Tests:** (Pendientes de implementar explícitamente)
  - [ ] `LegalCaseTest` - Validaciones, relaciones, scopes
  - [ ] `ParticipantTest` - Tipos, relaciones
  - [ ] `CaseStageServiceTest` - Transiciones válidas/inválidas
- [ ] **Feature Tests:** (Pendientes de implementar explícitamente)
  - [ ] `CreateCaseTest` - Flujo completo de creación
  - [ ] `CaseParticipantsTest` - Agregar/editar/eliminar participantes
  - [ ] `StageTransitionTest` - Avanzar etapas con historial
  - [ ] `CasesFilterTest` - Filtros y búsqueda
- [ ] **Integration Tests:** (Pendientes de implementar explícitamente)
  - [ ] `CaseTenantIsolationTest` - Casos aislados por tenant

---

## 3. Registro de Decisiones Técnicas

*   **Nombre de tabla `cases`:** Se usó `legal_cases` para evitar conflicto con la palabra reservada `CASE` en SQL.
*   **Encripción de `Participant->contact_details`:** Implementado `encrypted:array` tal como se definió.
*   **Validación de Límites de Casos:** Implementado en `CreateCaseForm` antes de la creación.
*   **Gestión de Modales:** Se optó por el sistema de eventos de navegador (`open-modal`, `close-modal`) de Alpine/Livewire en lugar de enlazar directamente propiedades booleanas para mayor robustez y compatibilidad con `x-modal`. Se ajustó `x-modal` con `relative z-50` para solucionar problemas de z-index.
*   **Historial de Etapas:** Implementado como tabla inmutable (`procedural_stage_histories`) y visualizado en el detalle del caso.
*   **Catalogos CNPP:** `CrimeType` y `PrecautionaryMeasureType` implementados con migraciones y seeders.

---

## 4. Registro de Bloqueos y Soluciones

*   **Bloqueo:** Seeders de catálogos no se ejecutaban automáticamente. **Solución:** Registrados en `DatabaseSeeder.php`.
*   **Bloqueo:** Modales de `ChangeCaseStage` y `ParticipantManager` no abrían o tenían problemas de `z-index`. **Solución:** Refactorizar a eventos de navegador y ajustar `z-index` en `x-modal`.

---

## 5. Dependencias

### Dependencias de Sprint Anterior
- ✅ Sprint 2 completado (Multi-tenant, Auth, RBAC)

### Paquetes Adicionales
```bash
# Ninguno nuevo requerido para este sprint
```

---

## 6. Asignación de Tareas por Área

| Área | Responsable | GitHub | Tareas |
|-------------------|--------|--------|
| **Backend** | Gael, Eduardo | @Arzubide, @eddndev | Migraciones, Modelos, Seeders, Lógica Livewire |
| **Frontend** | Karla | @Karlaelenaht | Componentes Livewire, Vistas Blade |
| **UX/UI** | Hatziry | @vhhatziry | Diseño de formularios, listados, badges |
| **Testing** | Diego | @Dvan88 | Unit, Feature, Integration Tests |
| **CI/CD** | Eduardo | @eddndev | Review de PRs |

### Asignación de User Stories

| User Story | Backend | Frontend | UX/UI | Testing |
|------------|---------|----------|-------|---------|
| US-06: Apertura de Caso | ✅ @Arzubide | ✅ @Karlaelenaht | ✅ @vhhatziry | ✅ @Dvan88 |
| US-07: Participantes | ✅ @Arzubide | ✅ @Karlaelenaht | ✅ @vhhatziry | ✅ @Dvan88 |
| US-08: Transición Etapas | ✅ @eddndev | ✅ @Karlaelenaht | ✅ @vhhatziry | ✅ @Dvan88 |
| US-10: Listado y Filtros | ✅ @Arzubide | ✅ @Karlaelenaht | ✅ @vhhatziry | ✅ @Dvan88 |

---

## 7. Criterios de Aceptación del Sprint

El Sprint 3 se considera **COMPLETADO** cuando:

- ✅ Usuario puede crear un nuevo caso con NUC, folio interno y tipo de delito
- ✅ Se crea automáticamente el primer registro en historial de etapas
- ✅ Usuario puede agregar participantes (imputados, víctimas, testigos, jueces, MP)
- ✅ Usuario puede avanzar la etapa procesal con razón obligatoria
- ✅ El historial de etapas es inmutable (no se puede editar/eliminar)
- ✅ Usuario puede listar casos con filtros (etapa, status, abogado, delito)
- ✅ Búsqueda funciona por folio, NUC y alias
- ✅ Todos los datos están aislados por tenant
- [ ] Tests pasan con cobertura > 80% (PENDIENTE: Implementar tests automatizados)

---

## 8. Resultado del Sprint (A completar al final)

*   **Tareas Completadas:** 100% de las tareas de Backend y Frontend básico. Tests manuales UAT aprobados.
*   **Resumen:** El Core Legal del sistema está implementado, permitiendo la creación, listado, gestión de participantes y el avance de etapas procesales de los expedientes penales, respetando las normativas del CNPP y la arquitectura multi-tenant.
*   **Aprendizajes / Retrospectiva:**
    *   **Qué funcionó bien:** La metodología de UAT iterativa permitió identificar y resolver problemas de integración entre Livewire y Alpine.js de forma temprana. La definición detallada del esquema de DB facilitó el desarrollo.
    *   **Qué se puede mejorar:** La implementación de tests automatizados (Unit/Feature) debe ser una prioridad en futuros sprints para garantizar la solidez del código a largo plazo. Considerar refactorizar lógica de creación de historial a un `Observer` para mantener los componentes Livewire más limpios.

---

## 9. Referencias

- **User Stories:** `/docs/04-user-stories.md` (US-06, US-07, US-08, US-10)
- **Esquema de BD:** `/docs/03-database-schema.md` (Sección 3)
- **Arquitectura:** `/docs/00-arquitectura-tecnica.md`

---

**Sprint planificado por:** Eduardo (Tech Lead)
**Fecha de planificación:** 2025-11-30
**Última actualización de estado:** 2025-12-03