# Documentación Financiera - Qadra

Este documento detalla los costos operativos, proyecciones de almacenamiento y el análisis de punto de equilibrio para el proyecto Qadra.

## 1. Costos Fijos Operativos

Los costos fijos son aquellos que debemos cubrir independientemente del número de usuarios.

| Concepto | Costo Pesos (MXN) | Frecuencia | Costo Anualizado |
| :--- | :--- | :--- | :--- |
| **Hosting (Compartido)** | $9,081.00 | Cada 3 años | $3,027.00 |
| **Dominio (Cloudflare)** | $210.00 | Anual | $210.00 |
| **Cloudflare Pro** | $370.00 ($20 USD) | Mensual | $4,440.00 |
| **Total Costos Fijos** | | | **$7,677.00** |

*Nota: Se utilizó un tipo de cambio de $18.50 MXN/USD según lo solicitado.*

---

## 2. Costos Variables por Suscripción

Costos que escalan con el número de clientes (Tenants).

### A. Almacenamiento (AWS S3 Glacier Instant Retrieval)
*Estimado: $0.004 USD por GB/mes ($0.074 MXN aprox).*

- **Plan Starter (10GB):** ~$0.74 MXN / mes por tenant.
- **Plan Professional (50GB):** ~$3.70 MXN / mes por tenant.

### B. Pasarela de Pagos (Stripe México)
*Comisión: 3.6% + $3.00 MXN + IVA de la comisión.*

| Plan | Precio (c/ IVA) | Comis. Stripe (aprox) | Ingreso Neto (Post-Stripe) |
| :--- | :--- | :--- | :--- |
| **Starter** | $99.00 | $7.61 | $91.39 |
| **Professional** | $249.00 | $13.88 | $235.12 |

---

## 3. Otros Costos a Considerar

Aunque actualmente no son gastos directos, deben monitorearse:

1. **Correos Transaccionales:** Actualmente enviados por el servidor de hosting ($0). Si el volumen crece, se recomienda **AWS SES** ($0.10 USD x 1,000 correos).
2. **Soporte Técnico:** Tiempo dedicado a incidencias y mantenimiento.
3. **Marketing/Adquisición:** Costo de obtener cada cliente nuevo (CAC).

---

## 4. Punto de Equilibrio (Break-even Point)

Para cubrir los **$7,677.00** anuales ($639.75 mensuales) de costos fijos:

| Unidades para Punto de Equilibrio | Solo Plan Starter | Solo Plan Professional |
| :--- | :--- | :--- |
| **Clientes Mensuales** | ~7 Tenants | ~3 Tenants |

> [!TIP]
> Dado que el costo de almacenamiento S3 es extremadamente bajo para documentos en frío, el margen de ganancia por suscripción es superior al 90% después de comisiones de pago y almacenamiento básico.

---

## 5. Valoración del Activo de Software (COCOMO)

Estimación del valor de desarrollo utilizando el modelo **COCOMO I (Constructive Cost Model)** en modo "Orgánico" (equipo pequeño, entorno familiar).

**Supuestos:**
- **Tamaño del Proyecto:** ~15,000 Líneas de Código Fuente (Custom Logic + Blade).
- **Salario Promedio Desarrollador:** $30,000 MXN / mes (Costo empresa con prestaciones).

**Cálculo:**
- **Esfuerzo (Personas-Mes):** $2.4 \times (15)^{1.05} \approx 41.3 \text{ PM}$
- **Tiempo de Desarrollo:** $2.5 \times (41.3)^{0.38} \approx 10.2 \text{ Meses}$
- **Valor Económico Total:** $41.3 \text{ PM} \times \$30,000 \approx \mathbf{\$1,239,000 \text{ MXN}}$

*Este cálculo representa el costo teórico de reconstruir el software desde cero hoy.*

---

## 6. Costos de Mantenimiento y OpEx

El mantenimiento de software incluye actualizaciones de framework (Laravel), parches de seguridad y corrección de bugs.

- **Estándar de Industria:** 15% - 20% del costo de desarrollo inicial anualmente.
- **Costo Anual Estimado:** ~$185,000 - $247,000 MXN (En horas de ingeniería).
- **Deuda Técnica:** Se recomienda dedicar el **10% del tiempo de desarrollo** en cada sprint a refactorización para evitar que este costo aumente.

---

## 7. Métricas SaaS Clave

Para medir la salud financiera del modelo de suscripción:

### A. Costo de Adquisición de Cliente (CAC)
$$ CAC = \frac{\text{Gastos de Marketing + Ventas}}{\text{Nuevos Clientes Adquiridos}} $$
*Objetivo:* El CAC debe ser recuperado en < 12 meses.

### B. Valor de Vida del Cliente (LTV)
$$ LTV = \frac{\text{Ingreso Promedio por Usuario (ARPU)}}{\text{Tasa de Cancelación (Churn Rate)}} $$
*Objetivo:* LTV debe ser al menos 3x mayor que el CAC ($LTV:CAC > 3:1$).

---

## 8. Costo de Inactividad (Downtime)

Riesgo financiero asociado a caídas del servicio (servidor caído, DNS fallido).

- **Impacto Directo:** Reembolsos de SLA (si aplica).
- **Impacto Indirecto:** Pérdida de reputación y confianza.
- **Costo Estimado:** Se valora conservadoramente en **$500 - $1,000 MXN por hora** operativa perdida, considerando la afectación a múltiples despachos simultáneamente.

---

## 9. Recomendaciones Finales

- **Ciclo de AWS:** Configurar reglas de ciclo de vida en S3 para mover documentos de más de 6 meses a Glacier Deep Archive ($0.00099 USD/GB).
- **Facturación Anual:** Incentivar el pago anual para reducir la incidencia de la comisión fija de Stripe ($3.00) sobre el total recaudado.
- **Monitoreo:** Implementar UptimeRobot o similar para minimizar el costo de downtime.
