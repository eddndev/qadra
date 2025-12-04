# Protocolo de Pruebas de Aceptación (UAT) - Sprint 5

**Versión:** 1.0  
**Módulo:** Evidencias y Documentos  
**Fecha:** 03 de Diciembre 2025  
**Estado:** ⏳ Pendiente de Validación

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
| A1 | Acceso | Ir al menú **Evidencias** > **+ Nueva Evidencia**. | Formulario de registro visible. | ⏳ |
| A2 | Registro | Llenar formulario: Caso=`EXP-001`, Tipo=`Arma`, Ubicación=`Caja Fuerte`. Guardar. | Mensaje de éxito. Redirección o limpieza de formulario. Folio generado automáticamente (ej: `EV-2025-EXP-001-001`). | ⏳ |
| A3 | Validación Custodia Inicial | Revisar base de datos o detalle (futuro). | Se debe haber creado automáticamente un registro en `chain_of_custody_entries` con motivo "Recepción inicial". | ⏳ |
| A4 | Inventario | Ir al listado principal `/evidence`. | La nueva evidencia aparece en la tabla con estatus `En Custodia`. | ⏳ |
| A5 | Filtros | Filtrar por Tipo: "Documento". | La tabla debe actualizarse y (si no hay docs) ocultar el arma creada. | ⏳ |

### Escenario B: Cadena de Custodia (US-17)
*Verificar la trazabilidad y cambio de estados.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| B1 | Iniciar Movimiento | En el listado, clic en **"Mover"** sobre la evidencia creada. | Redirección al formulario de movimiento `/evidence/{id}/move`. Se muestra historial actual. | ⏳ |
| B2 | Registrar Traslado | Llenar: Motivo=`Traslado a Fiscalía`, Recibe=`Lic. Perito`, Ubicación=`Bodega Fiscalía`. Firmar. | Mensaje de éxito. | ⏳ |
| B3 | Verificar Estado | Volver al listado `/evidence`. | El estatus de la evidencia cambió a `En Fiscalía` (amarillo) y la ubicación se actualizó. | ⏳ |
| B4 | Integridad | Intentar editar el movimiento anterior (No debe haber UI para esto). | El sistema no permite modificar registros históricos de custodia. | ⏳ |

### Escenario C: Gestión Documental S3 (US-19, US-20, US-21)
*Verificar la subida, almacenamiento seguro y visualización de archivos.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| C1 | Subida | En el detalle de un caso (o vista de prueba), usar el widget **Adjuntar Documentos**. Arrastrar un PDF de prueba. | Barra de progreso completa. Mensaje "Procesando". Archivo aparece en la lista de adjuntos. | ⏳ |
| C2 | Verificación S3 | Revisar bucket en consola AWS (opcional) o confiar en sistema. | El archivo existe en la ruta del tenant correspondiente. | ⏳ |
| C3 | Visualización | Clic en el icono de descarga/ver del documento en la lista. | Se abre nueva pestaña con URL firmada de AWS (larga y con tokens). El archivo se visualiza. | ⏳ |
| C4 | Seguridad | Copiar la URL firmada y esperar 5 minutos (o modificar URL quitando firma). Intentar acceder. | AWS debe responder `AccessDenied` (403). | ⏳ |
| C5 | Borrado | Clic en "Eliminar" documento. Confirmar. | El documento desaparece de la lista. (Opcional: verificar borrado en S3). | ⏳ |

---

## 4. Notas Técnicas

- **S3:** Los archivos se suben con visibilidad privada (`private`). El acceso es **exclusivo** mediante `TemporarySignedUrl`.
- **FilePond:** El componente de subida maneja archivos de hasta 10MB por defecto.
- **Folios:** El formato de folio es `EV-{AÑO}-{FOLIO_CASO}-{SECUENCIAL}`.

## 5. Aprobación

**Fecha de Ejecución:** [Pendiente]  
**Ejecutado por:** [Nombre]  
**Resultado:** [Pendiente]
