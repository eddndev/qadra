# Protocolo de Pruebas de Aceptación (UAT) - Sprint 3

**Versión:** 1.0  
**Módulo:** Core Legal (Gestión Procesal)  
**Fecha:** 03 de Diciembre 2025  
**Estado:** ✅ Validado

---

## 1. Objetivo
Validar el flujo completo de gestión de expedientes penales: desde la apertura del caso, pasando por la asignación de participantes, hasta la transición de etapas procesales y su trazabilidad histórica.

---

## 2. Prerrequisitos
- Sprint 2 Validado (Auth & Tenants activos).
- Seeders ejecutados (`CrimeTypesSeeder`, `PrecautionaryMeasureTypesSeeder`).
- Usuario con rol `owner` o `litigante` logueado.

---

## 3. Escenarios de Prueba

### Escenario A: Apertura de Expediente (US-06)
*Verificar la creación de un nuevo caso y el uso de catálogos.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| A1 | Acceso | Ir a la sección **Expedientes**. | Tabla vacía (o con datos previos) y botón "+ Nuevo Caso". | ✅ |
| A2 | Formulario | Clic en "+ Nuevo Caso". | Formulario visible con campos de Folio, Delito, etc. | ✅ |
| A3 | Catálogos | Intentar seleccionar "Delito". | Desplegable muestra delitos reales (Homicidio, Robo, etc.) y su gravedad. | ✅ |
| A4 | Creación | Llenar formulario (Folio: `EXP-001`, Delito: `Fraude`, Etapa: `Inv. Inicial`) y Guardar. | Redirección al listado. Mensaje de éxito. El caso aparece en la tabla. | ✅ |
| A5 | Límite Plan | (Opcional) Intentar crear casos hasta superar el límite del plan. | El sistema impide crear el caso N+1 y muestra alerta de upgrade. | ✅ |

### Escenario B: Gestión de Participantes (US-07)
*Verificar la asignación de personas al caso.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| B1 | Detalle | Clic en "Ver" en el caso creado (`EXP-001`). | Se muestra la vista de detalle con pestañas. | ✅ |
| B2 | Pestaña | Ir a pestaña **Participantes**. | Tabla vacía con botón "+ Agregar Persona". | ✅ |
| B3 | Agregar | Clic en "+ Agregar Persona". Modal abre. Llenar: Nombre="Juan Pérez", Rol="Imputado", Detenido=Sí. Guardar. | Modal cierra. "Juan Pérez" aparece en la tabla con etiqueta "Imputado" y alerta "DETENIDO". | ✅ |
| B4 | Agregar 2 | Agregar: Nombre="Lic. Fiscal", Rol="Ministerio Público". Guardar. | Aparece en la lista correctamente. | ✅ |
| B5 | Eliminar | Clic en "Eliminar" en el Ministerio Público. | Se pide confirmación. Al aceptar, el registro desaparece de la lista. | ✅ |

### Escenario C: Transición de Etapas (US-08)
*Verificar el avance procesal y la inmutabilidad del historial.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| C1 | Verificar Inicial | En la cabecera del caso, ver etapa actual. | Debe decir "Investigación Inicial" (o lo que se eligió al crear). | ✅ |
| C2 | Cambio Etapa | Clic en **"Cambiar Etapa / Estatus"**. Modal abre. | Campos prellenados con estado actual. | ✅ |
| C3 | Ejecutar Cambio | Seleccionar Nueva Etapa: "Investigación Complementaria". Escribir Razón: "Auto de Vinculación". Confirmar. | Página recarga. Cabecera muestra "Investigación Complementaria". | ✅ |
| C4 | Historial | Ir a pestaña **Resumen e Historial**. | Se ve el evento original "Apertura" Y el nuevo evento "Investigación Complementaria" con la razón escrita. | ✅ |

### Escenario D: Buscador y Filtros (US-10)
*Verificar la capacidad de encontrar casos.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| D1 | Búsqueda | En el listado, escribir "Juan" (o el alias del caso). | La tabla se filtra y muestra solo coincidencias. | ✅ |
| D2 | Filtro Etapa | Seleccionar filtro "Juicio Oral". | La tabla muestra solo casos en esa etapa (o vacía si no hay). | ✅ |

---

## 4. Notas de Cierre

- **Archivos:** La gestión de documentos y evidencias (S3) se pospuso para el siguiente sprint/US.
- **Edición Participantes:** La edición de datos de participantes ya creados se pospuso para futuras mejoras (se debe eliminar y recrear por ahora).
- **Modales:** Se ajustó la gestión de modales para funcionar correctamente con Livewire 3 y Alpine.js.

## 5. Aprobación

**Fecha de Ejecución:** 03 de Diciembre 2025  
**Ejecutado por:** Eduardo (Usuario Final)  
**Resultado:** ✅ Aprobado