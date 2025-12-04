# Diario del Sprint 7: Billing, Reportes y Portal

**Periodo:** [Fecha de Inicio] - [Fecha de Fin]

**Épica Maestra en GitHub:** [Pendiente de Creación]

**Estado:** ⏳ PENDIENTE

---

## 1. Objetivo del Sprint

Implementar la capa de inteligencia de negocios (Dashboard/Reportes), auditoría de seguridad y la infraestructura de monetización SaaS (Stripe). Este sprint cierra las funcionalidades "Premium" del sistema.

## 2. Alcance y Tareas Incluidas

### User Stories Incluidas

- [ ] `[US-28] Dashboard Ejecutivo del Despacho`
- [ ] `[US-29] Reportes Avanzados`
- [ ] `[US-24] Bitácora de Actividades (Audit Trail)`
- [ ] `[US-03] Gestión de Suscripción y Límites (Billing)`
- [ ] `[US-04] Configuración de Métodos de Pago (Stripe)`

### Entregables Técnicos

#### Migraciones (Database)
- [ ] `create_audit_logs_table` - Registro de seguridad (Spatie Activitylog)
- [ ] `create_subscriptions_table` - Tablas de Cashier (si no existen)

#### Integraciones
- [ ] **Stripe:** Configuración de Laravel Cashier, Webhooks, Planes (Products/Prices)
- [ ] **Gráficos:** Instalación de ApexCharts o Chart.js

#### Componentes Livewire
- [ ] `DashboardPage` - KPIs y Gráficos (Casos, Tiempos, Carga)
- [ ] `BillingPortal` - Gestión de suscripción y métodos de pago
- [ ] `AuditLogViewer` - Visualizador de logs de seguridad
- [ ] `ReportsGenerator` - Filtros y exportación (Excel/PDF)

#### Lógica de Negocio
- [ ] `SubscriptionPolicy` - Bloqueo de features según plan (Starter vs Pro)
- [ ] `LimitCheckService` - Validación de cuotas (Storage, Usuarios, Casos)

#### Vistas Blade
- [ ] `reports/index.blade.php`
- [ ] `billing/index.blade.php`
- [ ] `audit/index.blade.php`

#### Tests
- [ ] **Unit Tests:** Cálculo de límites, generación de reportes
- [ ] **Feature Tests:** Flujo de suscripción, acceso a reportes premium
- [ ] **Integration Tests:** Webhooks de Stripe (mocked)

---

## 3. Registro de Decisiones Técnicas

*Esta sección es un log vivo. Se actualiza durante el sprint.*

---

## 4. Registro de Bloqueos y Soluciones

*Esta sección documenta problemas y soluciones.*

---

## 5. Dependencias

- ✅ Sprint 6 completado
- 🔑 Cuenta de Stripe (Test Mode)

---

## 6. Asignación de Tareas por Área

| Área | Responsable | GitHub | Tareas |
|------|-------------|--------|--------|
| **Backend** | Gael, Eduardo | @Arzubide, @eddndev | Stripe Integration, Audit Logs, Queries de Reportes |
| **Frontend** | Karla | @Karlaelenaht | Dashboard Charts, Billing UI |
| **UX/UI** | Hatziry | @vhhatziry | Diseño de Dashboard Ejecutivo, Reportes PDF |
| **Testing** | Diego | @Dvan88 | Tests de facturación y seguridad |
| **CI/CD** | Eduardo | @eddndev | Variables de entorno Stripe |

---

## 7. Criterios de Aceptación del Sprint

- [ ] Owner ve dashboard con gráficas de rendimiento del despacho
- [ ] Owner puede exportar reportes de productividad a Excel/PDF
- [ ] Sistema bloquea acciones si se exceden límites del plan
- [ ] Owner puede suscribirse a planes de pago vía Stripe
- [ ] Se registran cambios críticos en el Audit Log (quién, qué, cuándo)
- [ ] Tests pasan con cobertura > 80%

---

**Sprint planificado por:** Eduardo (Tech Lead)
**Fecha de planificación:** 2025-12-03
