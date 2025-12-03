# Protocolo de Pruebas de Aceptación (UAT) - Sprint 2

**Versión:** 1.0  
**Módulo:** Foundation & Auth (Multi-tenant)  
**Fecha:** 03 de Diciembre 2025  
**Estado:** ✅ Validado

---

## 1. Objetivo
Validar el correcto funcionamiento de la arquitectura multi-tenant, el sistema de invitaciones, la gestión de roles base y los límites de suscripción implementados en el Sprint 2.

---

## 2. Prerrequisitos
- Entorno con subdominios habilitados (wildcard DNS o configuración local de hosts).
- Servidor de correos configurado (o Mailtrap para desarrollo).
- Base de datos limpia (recomendado, no obligatorio).

---

## 3. Escenarios de Prueba

### Escenario A: Registro y Límites (US-01, US-02)
*Verificar que un despacho nuevo se crea correctamente y respeta los límites del plan.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| A1 | Registro Inicial | Ir a `/register` y crear despacho **"Prueba Starter"** con plan **Starter**. | Redirección exitosa al subdominio `prueba-starter.dominio.com`. Dashboard visible. | ✅ |
| A2 | Verificar Owner | Ir a **Equipo**. | El usuario actual aparece con rol `Owner`. | ✅ |
| A3 | Invitar Miembros | Invitar a `usuario2@test.com` y `usuario3@test.com` (roles variados). | Invitaciones enviadas y listadas en "Pendientes". | ✅ |
| A4 | Validar Límite | Intentar invitar a `usuario4@test.com` (4to usuario). | **Error:** "Has alcanzado el límite de usuarios para tu plan (3)". | ✅ |

### Escenario B: Flujo de Invitación (US-02)
*Verificar que un usuario externo puede unirse mediante invitación.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| B1 | Recepción | Revisar correo de `usuario2@test.com`. | Correo recibido con link de aceptación y mensaje personalizado. | ✅ |
| B2 | Click Link | Hacer clic en el enlace de aceptación. | Redirección a formulario de registro especial `/register/invited`. | ✅ |
| B3 | Registro Invitado | Completar nombre y contraseña (email prellenado). | Redirección al dashboard de `prueba-starter`. | ✅ |
| B4 | Verificación | Login como Owner > Ir a Equipo. | `usuario2` aparece en la lista principal, ya no en pendientes. | ✅ |

### Escenario C: Múltiples Despachos (Tenant Switcher) (US-05)
*Verificar que un usuario puede pertenecer a varios despachos y cambiar entre ellos.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| C1 | Crear 2do Tenant | Logueado como Owner, ir al menú de usuario > **"+ Crear Nuevo Despacho"**. | Formulario simplificado (sin pedir pass/email). | ✅ |
| C2 | Registro Tenant B | Crear **"Despacho Pro"** con plan **Professional**. | Redirección al subdominio `despacho-pro`. | ✅ |
| C3 | Switch Context | Click en selector de despachos (navbar) > Seleccionar "Prueba Starter". | Navegador recarga y cambia URL a `prueba-starter`. Sesión activa. | ✅ |

### Escenario D: Gestión de Roles (RBAC) (US-25)
*Verificar que los permisos se respetan según el rol.*

| ID | Paso | Acción | Resultado Esperado | Estado |
|----|------|--------|--------------------|--------|
| D1 | Editar Rol (Owner) | En "Prueba Starter" (como Owner), cambiar rol de `usuario2` a "Administrativo". | Cambio guardado exitosamente. | ✅ |
| D2 | Eliminar (Owner) | Eliminar a `usuario3` del despacho. | Usuario eliminado de la lista. | ✅ |
| D3 | Restricción (User) | Login como `usuario2`. Ir a Equipo. | Ve la lista pero **NO** ve botones de eliminar ni selectores de rol. | ✅ |

---

## 4. Notas Técnicas

- **Manejo de Sesión:** La sesión se comparte entre subdominios (`.dominio.com`), pero el middleware `IdentifyTenant` valida el acceso basándose en el host actual.
- **Registro de Invitados:** Se implementó un flujo dedicado (`InvitedUserController`) para evitar conflictos con el registro público de despachos.
- **Límites:** Los límites se validan contra `SubscriptionTier` + conteo de usuarios activos + invitaciones pendientes.
