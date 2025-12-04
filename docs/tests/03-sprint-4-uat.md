# Protocolo de Pruebas de Aceptación (UAT) - Sprint 4

**Versión:** 1.0  
**Módulo:** Agenda & Tiempos (Audiencias y Plazos)  
**Fecha:** 03 de Diciembre 2025  
**Estado:** ✅ Validado

---

## 1. Objetivo
Validar el correcto funcionamiento del módulo de tiempos procesales, incluyendo la programación de audiencias, el registro de resultados, la configuración de plazos fatales y el sistema de notificaciones automáticas.

---

## 2. Prerrequisitos
- Sprint 3 Validado (Casos creados y activos).
- Usuario con rol `owner` o `litigante` logueado.
- Configuración de correo (Mailtrap/Log) verificada para notificaciones.
- Job `CheckDeadlinesJob` ejecutado manualmente o via schedule.

---

## 3. Escenarios de Prueba

### Escenario A: Programación de Audiencias (US-11)
*Verificar que se pueden agendar audiencias y que generan recordatorios automáticos.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| A1 | Acceso | Ir al detalle de un caso (`/cases/{id}`) > Pestaña **Audiencias**. | Lista vacía (o con audiencias previas) y botón "Nueva Audiencia". | ✅ |
| A2 | Programar | Clic "Nueva Audiencia". Llenar: Tipo="Inicial", Fecha=Mañana 10:00, Sala="Sala 1". Guardar. | Audiencia aparece en la lista con estatus `Programada`. | ✅ |
| A3 | Validación Automática | Ir a pestaña **Plazos y Términos**. | Debe existir un plazo automático titulado "Audiencia: Inicial" con fecha de mañana. | ✅ |
| A4 | Calendario Global | Ir a menú **Calendario**. | El evento aparece en el calendario en el día y hora correctos. | ✅ |

### Escenario B: Gestión de Plazos y Alertas (US-14, US-15)
*Verificar la creación manual de plazos y el sistema de urgencia visual.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| B1 | Crear Plazo Fatal | En pestaña **Plazos**, clic "Nuevo Plazo". Título="Cierre Investigación", Fecha=En 2 días, Fatal=Sí. Guardar. | Plazo aparece en la lista. Etiqueta "FATAL". Color de urgencia (Naranja/Rojo). | ✅ |
| B2 | Widget Dashboard | Ir al **Dashboard** principal. | El widget "Plazos Próximos" debe mostrar el plazo creado (Cierre Investigación). | ✅ |
| B3 | Notificación (Simulada) | Ejecutar comando `php artisan queue:work` o forzar el Job. | Se recibe correo de notificación "TÉRMINO FATAL" para el abogado responsable. | ✅ |
| B4 | Cumplimiento | En el listado de plazos, editar y cambiar estatus a "Cumplido". | El plazo cambia a color verde/gris y deja de aparecer como urgente. | ✅ |

### Escenario C: Resultado de Audiencia (US-12)
*Verificar el cierre del ciclo de una audiencia.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| C1 | Edición | En pestaña **Audiencias**, clic "Ver/Editar" en la audiencia creada. | Modal abre con datos cargados. | ✅ |
| C2 | Registrar Resultado | Cambiar estatus a "Celebrada". (Nota: En v1.0 es manual, futuro tendrá formulario dedicado). Guardar. | Estatus cambia a verde (`Celebrada`) en la lista y calendario. | ✅ |

### Escenario D: Calendario Interactivo (US-13)
*Verificar la visualización global de la agenda.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| D1 | Vista Mensual | Abrir **Calendario**. | Se ven los eventos del mes. | ✅ |
| D2 | Vista Agenda | Cambiar a vista "Lista" o "Semana" (si disponible en toolbar). | Los eventos se adaptan a la nueva vista correctamente. | ✅ |
| D3 | Navegación | Clic en un evento del calendario. | Redirige al detalle del caso correspondiente. | ✅ |

---

## 4. Notas Técnicas Post-Implementación

- **Notificaciones:** El Job `CheckDeadlinesJob` está configurado para correr a las 08:00 AM diariamente. Para pruebas inmediatas, ejecutar manualmente.
- **Timezones:** Asegurar que la configuración de `APP_TIMEZONE` coincida con la del usuario para que las alertas sean precisas.
- **FullCalendar:** Se usa la versión 6 vía CDN/NPM con idioma español configurado.

## 5. Aprobación

**Fecha de Ejecución:** 03 de Diciembre 2025
**Ejecutado por:** Eduardo (Usuario Final)
**Resultado:** ✅ Aprobado
