# Protocolo de Pruebas de Aceptación (UAT) - Sprint 5

**Versión:** 1.0  
**Módulo:** Evidencias y Documentos  
**Fecha:** 03 de Diciembre 2025  
**Estado:** ✅ Validado

---

## 1. Objetivo
Validar el correcto funcionamiento del repositorio digital seguro (S3), la gestión de evidencias físicas y la integridad de la cadena de custodia implementados en el Sprint 5.

---

## 2. Prerrequisitos
- Sprint 4 Validado.
- Credenciales AWS S3 configuradas y verificadas (`php artisan test:s3` exitoso).
- Usuario con rol `owner`, `litigante` o `paralegal` logueado.
- Al menos un Caso creado para vincular evidencias.

---

## 3. Escenarios de Prueba

### Escenario A: Registro e Inventario de Evidencias (US-16, US-18)
*Verificar el alta de objetos y su correcta catalogación.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| A1 | Acceso | Ir al menú **Evidencias** > **+ Nueva Evidencia** (o desde la pestaña Evidencias en un Caso). | Formulario de registro visible. | ✅ |
| A2 | Registro | Llenar formulario: Caso=`EXP-001`, Tipo=`Arma`, Ubicación=`Caja Fuerte`. Guardar. | Mensaje de éxito. Redirección o limpieza de formulario. Folio generado automáticamente (ej: `EV-2025-EXP-001-001`). | ✅ |
| A3 | Validación Custodia Inicial | Revisar base de datos o detalle. | Se creó automáticamente un registro en `chain_of_custody_entries` con motivo "Recepción inicial". | ✅ |
| A4 | Inventario | Ir al listado principal `/evidence`. | La nueva evidencia aparece en la tabla con estatus `En Custodia`. | ✅ |
| A5 | Filtros | Filtrar por Tipo: "Documento". | La tabla se actualiza y oculta el arma creada (si no coincide). | ✅ |

### Escenario B: Cadena de Custodia (US-17)
*Verificar la trazabilidad y cambio de estados.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| B1 | Iniciar Movimiento | En el listado, clic en **"Mover"** sobre la evidencia creada. | Redirección al formulario de movimiento `/evidence/{id}/move`. Se muestra historial actual. | ✅ |
| B2 | Registrar Traslado | Llenar: Motivo=`Traslado a Fiscalía`, Recibe=`Lic. Perito`, Ubicación=`Bodega Fiscalía`. Firmar. | Mensaje de éxito. | ✅ |
| B3 | Verificar Estado | Volver al listado `/evidence`. | El estatus de la evidencia cambió a `En Fiscalía` (amarillo) y la ubicación se actualizó. | ✅ |
| B4 | Integridad | Intentar editar el movimiento anterior (Verificación técnica). | No existe UI para edición. Registros en DB son inmutables. | ✅ |

### Escenario C: Gestión Documental S3 (US-19, US-20, US-21)
*Verificar la subida, almacenamiento seguro y visualización de archivos.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| C1 | Subida | En el detalle de un caso > Pestaña **Documentos**. Arrastrar un PDF/Imagen. | Barra de progreso completa. Mensaje "Procesando". Archivo aparece en la lista de adjuntos. | ✅ |
| C2 | Verificación S3 | (Técnico) Verificar en consola AWS o mediante script de prueba. | El archivo existe en el bucket S3. | ✅ |
| C3 | Visualización | Clic en el icono de descarga/ver del documento en la lista. | Se abre nueva pestaña con URL firmada de AWS. El archivo se visualiza correctamente. | ✅ |
| C4 | Seguridad | (Técnico) Verificar expiración de URL. | URL deja de funcionar después de 5 minutos (configurado). | ✅ |
| C5 | Borrado | Clic en "Eliminar" documento. Confirmar. | El documento desaparece de la lista. | ✅ |

---

## 4. Notas Técnicas Post-Implementación

- **S3:** Los archivos se suben con visibilidad privada (`private`). El acceso es **exclusivo** mediante `TemporarySignedUrl`.
- **Multi-tenancy:** Se aplicó un parche de seguridad a la tabla `media` para incluir `tenant_id` y garantizar el aislamiento de archivos entre despachos.
- **Navegación:** Se habilitó el acceso al inventario global de evidencias desde el menú principal y la gestión contextual desde dentro de cada Caso.

## 5. Aprobación

**Fecha de Ejecución:** 03 de Diciembre 2025  
**Ejecutado por:** Eduardo (QA Lead)  
**Resultado:** ✅ Aprobado Exitosamente