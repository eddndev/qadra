# Diario del Sprint 3: Core Legal

**Periodo:** [Fecha de Inicio] - [Fecha de Fin]

**Épica Maestra en GitHub:** [#14 - Sprint 3: Core Legal](https://github.com/eddndev/qadra/issues/14)

**Estado:** PENDIENTE

---

## 1. Objetivo del Sprint

Implementar el corazón del sistema - gestión de expedientes penales, participantes y transición de etapas procesales según el CNPP. Al finalizar este sprint, los usuarios podrán crear casos, agregar participantes y avanzar el caso a través de las etapas del proceso penal.

## 2. Alcance y Tareas Incluidas

### User Stories Incluidas

- [ ] `#15 - [US-06] Apertura de Nuevo Caso Penal`
- [ ] `#16 - [US-07] Gestión de Participantes del Caso`
- [ ] `#17 - [US-08] Transición de Etapa Procesal con Historial`
- [ ] `#18 - [US-10] Listado y Filtrado de Casos`

### Entregables Técnicos

#### Migraciones (Database)
- [ ] `create_cases_table` - Tabla principal de expedientes
- [ ] `create_procedural_stage_history_table` - Historial inmutable de etapas
- [ ] `create_participants_table` - Personas involucradas
- [ ] `create_case_participant_table` - Pivot case-participant con rol

#### Modelos (Eloquent)
- [ ] `LegalCase` - Expediente penal (Case es palabra reservada en PHP)
- [ ] `ProceduralStageHistory` - Historial de etapas (inmutable)
- [ ] `Participant` - Personas físicas/morales/autoridades
- [ ] `CaseParticipant` - Pivot con rol en el caso

#### Services
- [ ] `CaseStageService` - Lógica de transiciones de etapa

#### Observers
- [ ] `CaseObserver` - Auto-crear primer registro de historial

#### Seeders
- [ ] `CrimeTypesSeeder` - Catálogo de delitos del CNPP

#### Componentes Livewire
- [ ] `CreateCaseForm` - Formulario de nuevo caso
- [ ] `CasesTable` - Listado con filtros y paginación
- [ ] `ParticipantManager` - CRUD de participantes en caso
- [ ] `StageTransitionModal` - Modal para avanzar etapa

#### Vistas Blade
- [ ] `cases/index.blade.php` - Listado de casos
- [ ] `cases/create.blade.php` - Crear caso
- [ ] `cases/show.blade.php` - Detalle del caso (tabs)
- [ ] `components/stage-badge.blade.php` - Badge de etapa con color

#### Tests
- [ ] **Unit Tests:**
  - [ ] `LegalCaseTest` - Validaciones, relaciones, scopes
  - [ ] `ParticipantTest` - Tipos, relaciones
  - [ ] `CaseStageServiceTest` - Transiciones válidas/inválidas
- [ ] **Feature Tests:**
  - [ ] `CreateCaseTest` - Flujo completo de creación
  - [ ] `CaseParticipantsTest` - Agregar/editar/eliminar participantes
  - [ ] `StageTransitionTest` - Avanzar etapas con historial
  - [ ] `CasesFilterTest` - Filtros y búsqueda
- [ ] **Integration Tests:**
  - [ ] `CaseTenantIsolationTest` - Casos aislados por tenant

---

## 3. Registro de Decisiones Técnicas

*Esta sección es un log vivo. Se actualiza durante el sprint.*

---

## 4. Registro de Bloqueos y Soluciones

*Esta sección documenta problemas y soluciones.*

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
|------|-------------|--------|--------|
| **Backend** | Gael, Eduardo | @Arzubide, @eddndev | Migraciones, Modelos, Services, Observers, Seeders |
| **Frontend** | Karla | @Karlaelenaht | Componentes Livewire, Vistas Blade |
| **UX/UI** | Hatziry | @vhhatziry | Diseño de formularios, listados, badges |
| **Testing** | Diego | @Dvan88 | Unit, Feature, Integration Tests |
| **CI/CD** | Eduardo | @eddndev | Review de PRs |

### Asignación de User Stories

| User Story | Backend | Frontend | UX/UI | Testing |
|------------|---------|----------|-------|---------|
| US-06: Apertura de Caso | @Arzubide | @Karlaelenaht | @vhhatziry | @Dvan88 |
| US-07: Participantes | @Arzubide | @Karlaelenaht | @vhhatziry | @Dvan88 |
| US-08: Transición Etapas | @eddndev | @Karlaelenaht | @vhhatziry | @Dvan88 |
| US-10: Listado y Filtros | @Arzubide | @Karlaelenaht | @vhhatziry | @Dvan88 |

---

## 7. Criterios de Aceptación del Sprint

El Sprint 3 se considera **COMPLETADO** cuando:

- [ ] Usuario puede crear un nuevo caso con NUC, folio interno y tipo de delito
- [ ] Se crea automáticamente el primer registro en historial de etapas
- [ ] Usuario puede agregar participantes (imputados, víctimas, testigos, jueces, MP)
- [ ] Usuario puede avanzar la etapa procesal con razón obligatoria
- [ ] El historial de etapas es inmutable (no se puede editar/eliminar)
- [ ] Usuario puede listar casos con filtros (etapa, status, abogado, delito)
- [ ] Búsqueda funciona por folio, NUC y alias
- [ ] Todos los datos están aislados por tenant
- [ ] Tests pasan con cobertura > 80%

---

## 8. Resultado del Sprint (A completar al final)

*   **Tareas Completadas:** [ ] X de Y
*   **Resumen:** [Por completar]
*   **Aprendizajes / Retrospectiva:**
    *   **Qué funcionó bien:** [Por completar]
    *   **Qué se puede mejorar:** [Por completar]

---

## 9. Referencias

- **User Stories:** `/docs/04-user-stories.md` (US-06, US-07, US-08, US-10)
- **Esquema de BD:** `/docs/03-database-schema.md` (Sección 3)
- **Arquitectura:** `/docs/00-arquitectura-tecnica.md`

---

**Sprint planificado por:** Eduardo (Tech Lead)
**Fecha de planificación:** 2025-11-30
