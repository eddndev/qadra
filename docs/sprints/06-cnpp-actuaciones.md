# Diario del Sprint 6: CNPP y Actuaciones

**Periodo:** [Fecha de Inicio] - [Fecha de Fin]

**Épica Maestra en GitHub:** [Pendiente de Creación]

**Estado:** ⏳ PENDIENTE

---

## 1. Objetivo del Sprint

Implementar la lógica jurídica especializada del Código Nacional de Procedimientos Penales (CNPP) y el sistema de bitácora de operaciones diarias (CRM Legal). Al finalizar, el sistema podrá gestionar medidas cautelares complejas, soluciones alternas y registrar toda la actividad del despacho.

## 2. Alcance y Tareas Incluidas

### User Stories Incluidas

- [ ] `[US-22] Control de Medidas Cautelares`
- [ ] `[US-23] Gestión de Soluciones Alternas`
- [ ] `[US-26] Registro de Bitácora de Actuaciones`
- [ ] `[US-27] Filtro de Actividades por Usuario`

### Entregables Técnicos

#### Migraciones (Database)
- [ ] `create_precautionary_measures_table` - Medidas (prisión preventiva, brazalete, etc.)
- [ ] `create_alternative_solutions_table` - Acuerdos y suspensiones
- [ ] `create_activities_table` - Bitácora de eventos (llamadas, visitas)

#### Modelos (Eloquent)
- [ ] `PrecautionaryMeasure` - Lógica de vigencia y revisión
- [ ] `AlternativeSolution` - Condiciones y cumplimiento
- [ ] `Activity` - Registro de tiempo y responsable

#### Lógica de Negocio (Services/Observers)
- [ ] `MeasureReviewObserver` - Crear alertas automáticas para revisión de medidas (ej. 2 años prisión preventiva)
- [ ] `ComplianceChecklistService` - Gestión de condiciones para soluciones alternas

#### Componentes Livewire
- [ ] `PrecautionaryMeasureForm` - Alta y modificación de medidas
- [ ] `AlternativeSolutionForm` - Registro de acuerdos con checklist
- [ ] `ActivityTimeline` - Visualización cronológica de actuaciones
- [ ] `ActivityForm` - Registro rápido de actividades

#### Vistas Blade
- [ ] `measures/index.blade.php`
- [ ] `solutions/show.blade.php` - Detalle de cumplimiento
- [ ] `activities/team-report.blade.php` - Reporte por usuario

#### Integraciones Frontend
- [ ] Editor WYSIWYG (TipTap/CKEditor) para redacción de condiciones y acuerdos

#### Tests
- [ ] **Unit Tests:** Lógica de fechas de revisión, validación de estados
- [ ] **Feature Tests:** Flujo de aprobación de acuerdos, registro de actividades

---

## 3. Registro de Decisiones Técnicas

*Esta sección es un log vivo. Se actualiza durante el sprint.*

---

## 4. Registro de Bloqueos y Soluciones

*Esta sección documenta problemas y soluciones.*

---

## 5. Dependencias

- ✅ Sprint 5 completado

---

## 6. Asignación de Tareas por Área

| Área | Responsable | GitHub | Tareas |
|------|-------------|--------|--------|
| **Backend** | Gael, Eduardo | @Arzubide, @eddndev | Migraciones, Modelos, Lógica CNPP |
| **Frontend** | Karla | @Karlaelenaht | Componentes Livewire, Timelines |
| **UX/UI** | Hatziry | @vhhatziry | Diseño de checklist de cumplimiento, cards de actividades |
| **Testing** | Diego | @Dvan88 | Tests de reglas de negocio |
| **CI/CD** | Eduardo | @eddndev | - |

---

## 7. Criterios de Aceptación del Sprint

- [ ] Usuario puede registrar medidas cautelares del catálogo CNPP
- [ ] Sistema genera alertas de revisión obligatoria para Prisión Preventiva
- [ ] Usuario puede gestionar Acuerdos Reparatorios con checklist de condiciones
- [ ] Usuario puede registrar actividades diarias (llamadas, correos) vinculadas a casos
- [ ] Se puede filtrar el historial de actividades por usuario del equipo
- [ ] Tests pasan con cobertura > 80%

---

**Sprint planificado por:** Eduardo (Tech Lead)
**Fecha de planificación:** 2025-12-03
