# Diario del Sprint 7: Monetización y Control

**Periodo:** 04 de Diciembre 2025 - [En Curso]

**Estado:** 🚧 EN PROGRESO

---

## 1. Objetivo del Sprint

Transformar la plataforma en un SaaS rentable mediante la integración de pasarela de pagos (Stripe), asegurar la integridad de datos con auditoría (Audit Logs) y proporcionar inteligencia de negocios mediante Dashboards y Reportes.

## 2. Alcance y Tareas Incluidas

### User Stories Incluidas

- [x] `[US-03] Gestión de Suscripción y Límites (Billing)` (Lógica base implementada)
- [x] `[US-04] Configuración de Métodos de Pago (Stripe)` (Integración Cashier lista)
- [ ] `[US-24] Bitácora de Actividades (Audit Trail)`
- [ ] `[US-28] Dashboard Ejecutivo del Despacho`
- [ ] `[US-29] Reportes Avanzados`
- [ ] `[US-30] Portal de Clientes`

### Entregables Técnicos

#### Facturación (Billing)
- [x] Instalación y configuración de `laravel/cashier`
- [x] Migraciones de tablas de suscripción (`subscriptions`, `subscription_items`)
- [x] Actualización de modelo `Tenant` con trait `Billable`
- [x] Componente `BillingPortal` para gestión de planes y redirección a Stripe
- [x] Middleware `EnsureTenantIsSubscribed` (Paywall)
- [ ] Configuración final de Webhooks en Producción/Staging

#### Auditoría
- [ ] Instalación de `spatie/laravel-activitylog`
- [ ] Configuración de Observers para modelos críticos (`Case`, `Evidence`, `Hearing`)
- [ ] Vista de `AuditLogViewer`

#### Reportes y Dashboard
- [ ] Componente `DashboardPage` con gráficas (Chart.js)
- [ ] Cálculo de KPIs (Casos activos, próximos vencimientos)
- [ ] Generación de PDFs con `barryvdh/laravel-dompdf`

#### Portal de Clientes
- [ ] Guard y Middleware para acceso de clientes externos
- [ ] Vista simplificada de "Mi Caso"

---

## 3. Registro de Decisiones Técnicas

- **Modelo de Facturación:** Se optó por facturar al modelo `Tenant` en lugar de `User` para centralizar el cobro por despacho.
- **Paywall:** Se implementó un middleware estricto (`EnsureTenantIsSubscribed`) que bloquea el acceso a toda la app (excepto facturación) si el trial venció o no hay suscripción.
- **Trial:** La lógica de trial se maneja dualmente: base de datos (`trial_ends_at`) para acceso sin tarjeta, y lógica de Stripe (`trialUntil`) para respetar días restantes al suscribirse.

## 4. Registro de Bloqueos y Soluciones

- **Conflicto Livewire/Cashier:** `redirectToBillingPortal` retornaba un objeto incompatible con Livewire. Se solucionó obteniendo la URL y redirigiendo manualmente.
- **Stripe Webhooks:** En entornos de Staging con subdominios, se requiere configurar el webhook al dominio central para evitar fallos de identificación de tenant.

---

## 5. Progreso Actual

| Tarea | Estado | Notas |
|-------|--------|-------|
| **Infraestructura Stripe** | ✅ Listo | Llaves configuradas, productos creados |
| **Portal de Facturación** | ✅ Listo | UI para elegir plan mensual/anual |
| **Lógica de Trial** | 🟡 En Ajuste | Funciona el bloqueo, falta validar webhook de transición |
| **Dashboard Ejecutivo** | ⏳ Pendiente | Siguiente prioridad |
| **Reportes PDF** | ⏳ Pendiente | |

---

**Sprint liderado por:** Eduardo (Tech Lead)
**Última actualización:** 04 de Diciembre 2025