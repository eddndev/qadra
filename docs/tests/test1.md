## 🐞 Reporte de Escenario 1: Creación de Despachos Duplicados (Uno Funcional y Otro No)

### 📝 Resumen del Problema
Al registrar un nuevo despacho, la acción de registro no genera una marca clara de éxito o error, pero al revisar el panel de selección de despachos, se crean **dos** despachos. Uno de ellos funciona correctamente y permite el acceso a las otras pestañas, mientras que el otro no funciona y dirige a una página sin acceso.

### ⚙️ Detalles del Entorno
* **Ambiente:** Pruebas locales
* **Versión del sistema:** 1.X
* **Navegador:** Microsoft Edge
* **Rol del usuario:** Abogado
* **Datos usados:** Nombre del despacho, RFC del despacho, Plan

### 🔄 Pasos para Replicar el Error
1. Abrir la página de inicio de sesión en `http://domain.test.com/login`.
2. Iniciar sesión.
3. Ir a 'prueba' y seleccionar 'crear nuevo despacho'.
4. Ingresar el nombre, RFC y plan del despacho, y registrarlo.
5. Regresar al 'Panel' o seleccionar otra sección.
6. Ir a seleccionar despacho.
7. Probar los 2 despachos que se crearon.

### 💡 Resultado Actual
Se crean 2 despachos. Uno funciona y permite navegar por la página, y el otro dirige a una página sin acceso.

### ✅ Resultado Esperado
Se debe tener un **solo despacho** que funcione y permita la navegación en todas las pestañas.

---

## 🔗 Reporte de Escenario 2: Error en los Enlaces de Ingreso y Cierre de Sesión

### 📝 Resumen del Problema
Al intentar iniciar sesión con correo y contraseña, el enlace de la página cambia de `http://domain.test.com/login` a `http://pruebas.domain.test.com/login`, lo que obliga al usuario a ingresar sus credenciales dos veces. Al finalizar la sesión, el sistema tampoco regresa al enlace de login original, sino que permanece en el link alterno y modificado que incluye el nombre del cliente (`http://pruebas.domain.test.com/login`).

### ⚙️ Detalles del Entorno
* **Ambiente:** Pruebas locales
* **Versión del sistema:** 1.X
* **Navegador:** Microsoft Edge
* **Rol del usuario:** Abogado
* **Datos usados:** Correo, contraseña

### 🔄 Pasos para Replicar el Error
1. Ir a la página de inicio de sesión `http://domain.test.com/login`.
2. Ingresar correo y contraseña, y hacer clic en 'iniciar sesión'.
3. Observar que el sistema vuelve a pedir las credenciales y que el link cambió a `http://pruebas.domain.test.com/login`.
4. Ingresar de nuevo el correo y contraseña, y hacer clic en 'iniciar sesión'.
5. Ir al perfil y finalizar sesión.
6. Observar que el link que aparece es `http://pruebas.domain.test.com/login` y no regresa al link original `http://domain.test.com/login`.

### 💡 Resultado Actual
Se genera una variación de link que fuerza al usuario a registrar su correo y contraseña dos veces. Además, al cerrar sesión, se mantiene el link alterno al cual no debería regresar.

### ✅ Resultado Esperado
Con un solo inicio de sesión desde el link original, el usuario debería ingresar a su despacho con el link correspondiente. Al finalizar la sesión, el link alterno no debería mantenerse, sino que se debería redirigir al link general de inicio de sesión.
