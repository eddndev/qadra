# Diario del Sprint 4: Agenda & Tiempos

**Periodo:** [Fecha de Inicio] - [Fecha de Fin]

**Épica Maestra en GitHub:** [#19 - Sprint 4: Agenda & Tiempos](https://github.com/eddndev/qadra/issues/19)

**Estado:** PENDIENTE

---

## 1. Objetivo del Sprint

Implementar el sistema de audiencias, plazos fatales y alertas - crítico para el flujo legal del CNPP. Al finalizar este sprint, los usuarios podrán programar audiencias, configurar plazos con alertas y visualizar todo en un calendario integrado.

## 2. Alcance y Tareas Incluidas

### User Stories Incluidas

- [ ] `#20 - [US-09] Dashboard del Caso (Vista Integral)`
- [ ] `#21 - [US-11] Programación de Audiencias`
- [ ] `#22 - [US-12] Registro de Resultado de Audiencia`
- [ ] `#23 - [US-13] Calendario de Audiencias del Despacho`
- [ ] `#24 - [US-14] Configuración de Plazos Fatales (Deadlines)`
- [ ] `#25 - [US-15] Sistema de Alertas y Notificaciones de Plazos`

### Entregables Técnicos

#### Migraciones (Database)
- [ ] `create_hearings_table` - Audiencias programadas
- [ ] `create_deadlines_table` - Plazos procesales

#### Modelos (Eloquent)
- [ ] `Hearing` - Audiencia con tipos CNPP
- [ ] `Deadline` - Plazo con configuración de alertas

#### Jobs (Queue)
- [ ] `CheckDeadlinesJob` - Verificar plazos próximos (scheduler 8:00 AM)
- [ ] `SendDeadlineReminderJob` - Enviar notificación de plazo

#### Observers
- [ ] `HearingObserver` - Auto-crear deadline al programar audiencia

#### Notifications
- [ ] `DeadlineApproachingNotification` - Email + In-app notification
- [ ] `HearingReminderNotification` - Recordatorio de audiencia

#### Componentes Livewire
- [ ] `CaseDetailPage` - Dashboard del caso con tabs
- [ ] `HearingForm` - Crear/editar audiencia
- [ ] `HearingResultForm` - Registrar resultado
- [ ] `HearingsCalendar` - Calendario con FullCalendar.js
- [ ] `DeadlineForm` - Crear/editar plazo
- [ ] `DeadlinesWidget` - Widget de plazos próximos

#### Vistas Blade
- [ ] `cases/show.blade.php` - Dashboard del caso (mejorado)
- [ ] `hearings/index.blade.php` - Listado de audiencias
- [ ] `hearings/calendar.blade.php` - Vista de calendario
- [ ] `deadlines/index.blade.php` - Listado de plazos
- [ ] `components/deadline-badge.blade.php` - Badge de urgencia

#### Integraciones Frontend
- [ ] FullCalendar.js v6 - Calendario interactivo
- [ ] API endpoint `/api/hearings/calendar` - JSON de eventos

#### Tests
- [ ] **Unit Tests:**
  - [ ] `HearingTest` - Validaciones, tipos, estados
  - [ ] `DeadlineTest` - Cálculo de alertas, vencimiento
  - [ ] `CheckDeadlinesJobTest` - Lógica de notificación
- [ ] **Feature Tests:**
  - [ ] `HearingCRUDTest` - Crear, editar, resultado
  - [ ] `DeadlineCRUDTest` - Crear, cumplir, extender
  - [ ] `CalendarTest` - API de eventos
  - [ ] `NotificationsTest` - Envío correcto de alertas
- [ ] **Integration Tests:**
  - [ ] `HearingDeadlineIntegrationTest` - Audiencia crea deadline automático

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
- ✅ Sprint 3 completado (Cases, Participants, Stages)

### Paquetes Adicionales
```bash
# FullCalendar (via npm)
npm install @fullcalendar/core @fullcalendar/daygrid @fullcalendar/timegrid @fullcalendar/interaction
```

### Configuración de Queue
```bash
# Configurar scheduler en crontab del servidor
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1

# En app/Console/Kernel.php
$schedule->job(new CheckDeadlinesJob)->dailyAt('08:00');
```

---

## 6. Asignación de Tareas por Área

| Área | Responsable | GitHub | Tareas |
|------|-------------|--------|--------|
| **Backend** | Gael, Eduardo | @Arzubide, @eddndev | Migraciones, Modelos, Jobs, Notifications |
| **Frontend** | Karla | @Karlaelenaht | Componentes Livewire, FullCalendar, Vistas |
| **UX/UI** | Hatziry | @vhhatziry | Diseño calendario, dashboard caso, badges |
| **Testing** | Diego | @Dvan88 | Unit, Feature, Integration Tests |
| **CI/CD** | Eduardo | @eddndev | Review de PRs, configurar Queue |

### Asignación de User Stories

| User Story | Backend | Frontend | UX/UI | Testing |
|------------|---------|----------|-------|---------|
| US-09: Dashboard Caso | @eddndev | @Karlaelenaht | @vhhatziry | @Dvan88 |
| US-11: Programar Audiencias | @Arzubide | @Karlaelenaht | @vhhatziry | @Dvan88 |
| US-12: Resultado Audiencia | @Arzubide | @Karlaelenaht | @vhhatziry | @Dvan88 |
| US-13: Calendario | @eddndev | @Karlaelenaht | @vhhatziry | @Dvan88 |
| US-14: Plazos Fatales | @Arzubide | @Karlaelenaht | @vhhatziry | @Dvan88 |
| US-15: Alertas | @eddndev | @Karlaelenaht | @vhhatziry | @Dvan88 |

---

## 7. Criterios de Aceptación del Sprint

El Sprint 4 se considera **COMPLETADO** cuando:

- [ ] Dashboard del caso muestra toda la información en tabs organizados
- [ ] Usuario puede programar audiencias con tipo CNPP (inicial, vinculación, intermedia, juicio)
- [ ] Al programar audiencia se crea automáticamente deadline de recordatorio
- [ ] Usuario puede registrar resultado de audiencia (celebrada, cancelada, reprogramada)
- [ ] Calendario muestra todas las audiencias con código de color por estado
- [ ] Usuario puede crear plazos fatales con configuración de alertas
- [ ] Sistema envía notificaciones según la configuración (7, 3, 1, 0 días antes)
- [ ] Widget de plazos próximos funciona en dashboard
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

- **User Stories:** `/docs/04-user-stories.md` (US-09, US-11-US-15)
- **Esquema de BD:** `/docs/03-database-schema.md` (Sección 4)
- **FullCalendar Docs:** https://fullcalendar.io/docs
- **Laravel Notifications:** https://laravel.com/docs/11.x/notifications

---

**Sprint planificado por:** Eduardo (Tech Lead)
**Fecha de planificación:** 2025-11-30
