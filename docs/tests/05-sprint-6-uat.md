# Protocolo de Pruebas de Aceptación (UAT) - Sprint 6

**Versión:** 1.0  
**Módulo:** CNPP Especialización y Bitácora (CRM)  
**Fecha:** 04 de Diciembre 2025  
**Estado:** ✅ Validado

---

## 1. Objetivo
Validar la correcta implementación de las herramientas jurídicas especializadas del CNPP (Medidas Cautelares y Soluciones Alternas) y el sistema de registro de actuaciones diarias (Bitácora) desarrollados en el Sprint 6.

---

## 2. Prerrequisitos
- Sprint 5 Validado.
- Al menos un Caso Penal activo con participantes registrados (Rol: Imputado).
- Catálogo de Medidas Cautelares poblado (Seeder ejecutado).
- Credenciales S3 activas (para adjuntos en bitácora).

---

## 3. Escenarios de Prueba

### Escenario A: Control de Medidas Cautelares (US-22)
*Verificar el registro de restricciones a la libertad y la generación de alertas obligatorias.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| A1 | Acceso | Ir al detalle de un caso (`EXP-001`) > Pestaña **Medidas Cautelares**. | Lista vacía o existente. Botón "+ Nueva Medida". | ✅ |
| A2 | Validación Prisión | Clic "+ Nueva Medida". Seleccionar Imputado. Tipo: **Prisión Preventiva**. Intentar guardar sin fecha de revisión. | **Error:** El sistema impide guardar y exige "Fecha de Revisión Obligatoria". | ✅ |
| A3 | Registro Exitoso | Llenar: Imputado=`Juan Pérez`, Tipo=`Prisión Preventiva`, Revisión=`En 2 años`. Guardar. | Medida guardada. Estatus `Vigente`. | ✅ |
| A4 | Alerta Automática | Ir a la pestaña **Plazos y Términos**. | Existe un nuevo plazo: "Revisión de Medida: Prisión Preventiva" con fecha a 2 años. | ✅ |
| A5 | Revocación | En la lista de medidas, clic en **Revocar**. Confirmar. | El estatus cambia a `Revocada` (Gris/Rojo). Ya no aparece como activa. | ✅ |

### Escenario B: Gestión de Soluciones Alternas (US-23)
*Verificar el flujo de salidas alternas al juicio.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| B1 | Acceso | Ir al detalle del caso > Pestaña **Soluciones Alternas**. | Botón "+ Registrar Propuesta". | ✅ |
| B2 | Propuesta | Clic "+". Tipo=`Acuerdo Reparatorio`. Fecha Propuesta=`Hoy`. Condiciones=`Pago de $50,000`. Guardar. | Tarjeta creada con estatus `Propuesta` (Gris). | ✅ |
| B3 | Aprobación Judicial | Clic **Editar**. Llenar Fecha Aprobación=`Hoy`, Juez=`Lic. Juez 1`. Guardar. | Tarjeta se actualiza. Estatus cambia automáticamente a `Aprobada` (Azul). | ✅ |
| B4 | Cumplimiento | En la tarjeta aprobada, clic en **Marcar Cumplida**. Confirmar. | Estatus cambia a `Cumplida` (Verde). Borde verde en la tarjeta. | ✅ |

### Escenario C: Bitácora de Actuaciones - CRM (US-26, US-27)
*Verificar el registro de actividades diarias y adjuntos.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| C1 | Acceso | Ir al detalle del caso > Pestaña **Actuaciones (Bitácora)**. | Formulario de registro a la izquierda, Timeline a la derecha. | ✅ |
| C2 | Registro Actividad | Tipo=`Llamada Telefónica`, Título=`Llamada con MP`, Desc=`Se acordó cita`, Adjuntar archivo (img/pdf). Guardar. | Formulario se limpia. Nueva actividad aparece arriba en el Timeline. | ✅ |
| C3 | Verificación Adjunto | En el timeline, clic en el archivo adjunto (📎). | Se abre el archivo en nueva pestaña (URL firmada S3) correctamente. | ✅ |
| C4 | Filtro por Usuario | Usar dropdown "Todos los Usuarios" > Seleccionar otro usuario. | El timeline se filtra correctamente. | ✅ |
| C5 | Filtro por Tipo | Usar dropdown "Todos los Tipos" > Seleccionar "Email". | El timeline muestra solo los Emails. | ✅ |
| C6 | Eliminación | Clic en "Eliminar" en una actividad propia. | La actividad desaparece del timeline. | ✅ |

---

## 4. Notas Técnicas

- **S3 Integration:** Confirmada la carga y descarga segura de adjuntos en la bitácora.
- **Lógica CNPP:** Las alertas automáticas para prisión preventiva funcionan según lo esperado.
- **Performance:** La carga de timelines con adjuntos es rápida gracias a la paginación y S3.

## 5. Aprobación

**Fecha de Ejecución:** 04 de Diciembre 2025  
**Ejecutado por:** Eduardo (QA Lead)  
**Resultado:** ✅ Aprobado Exitosamente