# Tests Sprint 2 al 6

## Sprint 2

### Escenario A

- A1: El registro es fácil de comprender; se recomienda modificar el texto del recuadro para indicar claramente el formato correcto.
- A2: Funciona correctamente.
- A3: Se observan las invitaciones y se pueden enviar correctamente.
- A4: La versión de prueba sí tiene límite.

### Escenario B

- B1: Existe un link de aceptación.
- B2: Redirige al formulario para el invitado.
- B3: Se pueden ingresar nombre y contraseña; el email aparece precargado.
- B4: En el equipo, cuando el otro usuario acepta, se refleja correctamente.

### Escenario C

- C1: Se permite crear un nuevo despacho.
- C2: Puede ser profesional.
- C3: Se pueden cambiar secciones correctamente.

### Escenario D

- D1: Se pueden cambiar roles y se reflejan correctamente.
- D2: Se puede eliminar a un usuario correctamente.
- D3: Se puede iniciar sesión con el otro usuario y se verifica que no tiene los mismos privilegios que el creador del despacho.

## Sprint 3

### Escenario A

- A1: Acceso fácil a expedientes.
- A2: La opción de crear caso se visualiza correctamente.
- A3: Se aprecian todos los delitos disponibles.
- A4: El formulario se puede llenar y siempre pide requisitos mínimos.
- A5: En el plan Starter se pueden crear más casos de los que debería; se crearon hasta 11 sin encontrar límite.

### Escenario B

- B1: Se pueden ver los casos creados.
- B2: Se puede ver la pestaña de participantes.
- B3: Se pueden agregar personas.
- B4: Se puede agregar un fiscal con su rol.
- B5: Se puede eliminar al Ministerio Público.

### Escenario C

- C1: Se observa la etapa del caso.
- C2: Se redirige correctamente al cambio de etapa.
- C3: Se cambia la etapa y se observa el cambio.
- C4: En resumen e historial se observan eventos y razones.

### Escenario D

- D1: Al buscar "Juan" (involucrado) no aparece; pero sí funciona cuando se filtra por folio o alias.
- D2: El filtrado por etapas funciona correctamente.

## Sprint 4

### Escenario A

- A1: Acceso correcto a audiencias.
- A2: Se puede crear una audiencia con datos mínimos y aparece en la lista.
- A3: En Plazos y términos aparece la audiencia inicial y la fecha.
- A4: El evento aparece en el calendario.

### Escenario B

- B1: Se crean casos y se aprecia la etiqueta "Fatal" cuando corresponde.
- B2: En dashboard aparece el próximo plazo.
- B3: Llegan correos de notificación.
- B4: Se puede ver el listado de plazos y cambiar estatus a "cumplido", observando el cambio de color.

### Escenario C

- C1: Se puede ver/editar una audiencia con datos cargados.
- C2: Se pueden cambiar los estatus y se reflejan en lista y calendario.

### Escenario D

- D1: Se puede abrir el calendario y ver eventos del mes.
- D2: Se puede cambiar la vista y los eventos se adaptan correctamente.
- D3: Al hacer clic en un evento, redirige al detalle del caso.

## Sprint 5

### Escenario A

- A1: En evidencias se puede crear una nueva, pero aparecen dos botones de "Nueva evidencia" (se debe eliminar uno).
- A2: El formulario funciona y registra correctamente.
- A3: No aparecen registros en chain_of_custody_entries en la base del .env; parece que se guarda en otra BD.
- A4: La evidencia nueva aparece en estatus "En custodia".
- A5: Se puede filtrar; en "Documento" no aparece, pero en "Arma" sí.

### Escenario B

- B1: En "Mover" redirige correctamente al formulario.
- B2: Se completa el formulario correctamente.
- B3: El estatus cambia a "En fiscalía" (amarillo).
- B4: No se puede modificar el movimiento anterior, pero sí volver a mover.

**Observación:**
Al ver la evidencia, no muestra los datos del último movimiento, solo sube la pantalla hacia arriba. No se observa origen/destino del movimiento.

### Escenario C

- C1: En detalle del caso se puede subir PDF/imagen.
- C2: No se supo realizar (pendiente de guía).
- C3: Al descargar/ver, abre un link en la misma pestaña; sería mejor abrir una nueva pestaña o modal.
- C4: El URL no expira en 5 minutos, no parece caducar.
- C5: Los documentos se eliminan de forma correcta.

## Sprint 6

### Escenario A

- A1: En los detalles del caso existe la pestaña de medidas cautelares con opción para agregar.
- A2: Se puede guardar una medida; la fecha de revisión obligatoria solo es requerida para prisión preventiva.
- A3: Registro exitoso incluso sin la fecha obligatoria.
- A4: En plazos y términos aparece la revisión de medida.
- A5: Se puede revocar la medida.

**Fallo encontrado:**
En dos ocasiones no se permitió registrar la medida "Prohibición de convivencia/acercamiento". Luego sí funcionó. Posible error intermitente que requiere monitoreo.

### Escenario B

- B1: En soluciones alternas existe botón para registrar propuestas.
- B2: Se pueden crear propuestas correctamente.
- B3: Se pueden editar las tarjetas y se observa el cambio.
- B4: Se puede marcar como cumplida.

### Escenario C

- C1: Se puede entrar a la pestaña de actuaciones.
- C2: Se puede llenar el formulario y funciona correctamente.
- C3: Los archivos se abren en una pestaña nueva (correcto).
- C4: Se puede filtrar por usuarios.
- C5: Se puede filtrar por tipos.
- C6: Se puede eliminar una actividad correctamente.