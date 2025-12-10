## 🐞 Reporte de Escenario 1: Creación de Despachos Duplicados (Uno Funcional y Otro No)

### 📝 Resumen del Problema
[cite_start]Al registrar un nuevo despacho, la acción de registro no genera una marca clara de éxito o error, pero al revisar el panel de selección de despachos, se crean **dos** despachos[cite: 2]. [cite_start]Uno de ellos funciona correctamente y permite el acceso a las otras pestañas, mientras que el otro no funciona y dirige a una página sin acceso[cite: 1, 17].

### ⚙️ Detalles del Entorno
* [cite_start]**Ambiente:** Pruebas locales [cite: 3]
* [cite_start]**Versión del sistema:** 1.X [cite: 4]
* [cite_start]**Navegador:** Microsoft Edge [cite: 5]
* [cite_start]**Rol del usuario:** Abogado [cite: 6]
* [cite_start]**Datos usados:** Nombre del despacho, RFC del despacho, Plan [cite: 7]

### 🔄 Pasos para Replicar el Error
1.  [cite_start]Abrir la página de inicio de sesión en `http://domain.test.com/login`[cite: 9].
2.  [cite_start]Iniciar sesión[cite: 10].
3.  [cite_start]Ir a 'prueba' y seleccionar 'crear nuevo despacho'[cite: 11].
4.  [cite_start]Ingresar el nombre, RFC y plan del despacho, y registrarlo[cite: 12].
5.  [cite_start]Regresar al 'Panel' o seleccionar otra sección[cite: 13].
6.  [cite_start]Ir a seleccionar despacho[cite: 14].
7.  [cite_start]Probar los 2 despachos que se crearon[cite: 15].

### 💡 Resultado Actual
[cite_start]Se crean 2 despachos[cite: 17]. [cite_start]Uno funciona y permite navegar por la página, y el otro dirige a una página sin acceso[cite: 17].

### ✅ Resultado Esperado
[cite_start]Se debe tener un **solo despacho** que funcione y permita la navegación en todas las pestañas[cite: 19].

---

## 🔗 Reporte de Escenario 2: Error en los Enlaces de Ingreso y Cierre de Sesión

### 📝 Resumen del Problema
[cite_start]Al intentar iniciar sesión con correo y contraseña, el enlace de la página cambia de `http://domain.test.com/login` a `http://pruebas.domain.test.com/login`, lo que obliga al usuario a ingresar sus credenciales dos veces[cite: 22, 32, 37]. [cite_start]Al finalizar la sesión, el sistema tampoco regresa al enlace de login original, sino que permanece en el link alterno y modificado que incluye el nombre del cliente (`http://pruebas.domain.test.com/login`)[cite: 23, 35, 37].

### ⚙️ Detalles del Entorno
* [cite_start]**Ambiente:** Pruebas locales [cite: 24]
* [cite_start]**Versión del sistema:** 1.X [cite: 25]
* [cite_start]**Navegador:** Microsoft Edge [cite: 26]
* [cite_start]**Rol del usuario:** Abogado [cite: 27]
* [cite_start]**Datos usados:** Correo, contraseña [cite: 28]

### 🔄 Pasos para Replicar el Error
1.  [cite_start]Ir a la página de inicio de sesión `http://domain.test.com/login`[cite: 30].
2.  [cite_start]Ingresar correo y contraseña, y hacer clic en 'iniciar sesión'[cite: 31].
3.  [cite_start]Observar que el sistema vuelve a pedir las credenciales y que el link cambió a `http://pruebas.domain.test.com/login`[cite: 32].
4.  [cite_start]Ingresar de nuevo el correo y contraseña, y hacer clic en 'iniciar sesión'[cite: 33].
5.  [cite_start]Ir al perfil y finalizar sesión[cite: 34].
6.  [cite_start]Observar que el link que aparece es `http://pruebas.domain.test.com/login` y no regresa al link original `http://domain.test.com/login`[cite: 35].

### 💡 Resultado Actual
[cite_start]Se genera una variación de link que fuerza al usuario a registrar su correo y contraseña dos veces[cite: 37]. [cite_start]Además, al cerrar sesión, se mantiene el link alterno al cual no debería regresar[cite: 37].

### ✅ Resultado Esperado
[cite_start]Con un solo inicio de sesión desde el link original, el usuario debería ingresar a su despacho con el link correspondiente[cite: 39]. [cite_start]Al finalizar la sesión, el link alterno no debería mantenerse, sino que se debería redirigir al link general de inicio de sesión[cite: 39].

