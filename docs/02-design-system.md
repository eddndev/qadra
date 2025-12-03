# Sistema de Diseño: Qadra - Plataforma SaaS de Gestión Procesal Penal

**Versión:** 1.0  
**Fecha:** 20 de noviembre de 2025  
**Proyecto:** Qadra  
**Enlace al Proyecto:** [https://www.figma.com/design/4iOSfcAmiv8zABqbYlixi6/qadra?node-id=0-1&p=f&t=pDk9uQhPEaYgEcRB-0]  
**Stack Tecnológico:** Tailwind CSS v4, Laravel Blade, Livewire 3  

---

## 1. Filosofía y Paleta de Colores

La identidad visual de **Qadra** se basa en la **autoridad**, la **seguridad** y la **precisión procesal**.  
Se usan azules profundos para transmitir confianza institucional y un tono **“Legal Brown”** para estados críticos, diferenciándose del rojo genérico de error.

### 1.1 Colores de Marca (Brand Colors)

| Nombre Token      | Hex       | Uso Principal                                                       |
| :---------------- | :-------- | :------------------------------------------------------------------ |
| **Navy Deep**     | `#111344` | Sidebar, fondos en modo oscuro, títulos principales                 |
| **Justice Blue**  | `#1E40AF` | **Color primario**, botones CTA, enlaces, foco                      |
| **Slate Blue**    | `#2C5282` | Elementos secundarios, bordes activos, fondos de tarjetas           |
| **Legal Brown**   | `#A52A2A` | **Crítico/acento**, plazos por vencer, alertas de alta prioridad    |
| **Verdict Green** | `#2F855A` | **Éxito**, casos ganados, pasos completados                         |

### 1.2 Colores Primarios (Brand - Justice Blue)

Usados para botones, enlaces, estados de foco y elementos de marca.

```css
/* Definición en Tailwind v4 (CSS variables) */
--color-brand-50:  #eef2ff;
--color-brand-100: #e0e7ff;
--color-brand-200: #c7d2fe;
--color-brand-500: #1E40AF; /* Primary Action */
--color-brand-600: #1e3a8a;
--color-brand-700: #2C5282; /* Secondary / Hover */
--color-brand-900: #111344; /* Navy Deep - Sidebar/Header */
--color-brand-950: #0a0b26;
```

### 1.3 Colores de Acento (Critical - Legal Brown)

Usados exclusivamente para **plazos de término**, errores críticos y acciones destructivas.

```css
--color-legal-50:  #fdf2f2;
--color-legal-100: #fde8e8;
--color-legal-500: #A52A2A; /* Base Alert Color */
--color-legal-600: #9b2226;
--color-legal-900: #7f1d1d;
```

### 1.4 Colores Neutrales (Slate)

Usados para textos, fondos y bordes.

```css
--color-slate-50:  #f8fafc;  /* Fondo App (light) */
--color-slate-100: #f1f5f9;
--color-slate-200: #e2e8f0;  /* Bordes */
--color-slate-500: #64748b;  /* Texto secundario */
--color-slate-800: #1e293b;  /* Texto tarjetas dark */
--color-slate-900: #0f172a;  /* Texto principal */
```

### 1.5 Colores Semánticos

- **Éxito (`success`):** `#2F855A` (Verdict Green – sentencias favorables, pasos completados)  
- **Peligro (`danger`):** `#A52A2A` (Legal Brown – errores y plazos vencidos)  
- **Advertencia (`warning`):** `#D97706` (ámbar – advertencias no fatales)  
- **Información (`info`):** `#2C5282` (Slate Blue – notas informativas)

### 1.6 Uso en Tema Claro vs. Oscuro

| Uso Semántico       | Modo Claro (`light`)      | Modo Oscuro (`dark`) |
| :------------------ | :------------------------ | :------------------- |
| **Fondo Sidebar**   | `bg-[#111344]`            | `bg-[#0a0b26]`       |
| **Fondo Principal** | `bg-slate-50`             | `bg-[#111344]`       |
| **Fondo Tarjetas**  | `bg-white`                | `bg-slate-800`       |
| **Texto Principal** | `text-[#111344]`          | `text-slate-100`     |
| **Texto Secundario**| `text-slate-600`          | `text-slate-400`     |
| **Bordes**          | `border-slate-200`        | `border-slate-700`   |
| **Inputs**          | `bg-white`                | `bg-slate-900`       |
| **Botón Primario**  | `bg-[#1E40AF] text-white` | igual en dark        |

---

## 2. Tipografía

Se prioriza la **legibilidad en pantallas** y la **formalidad en documentos legales**.

- **Fuente Principal (UI):** **Inter** (o Roboto)  
  - Sans-serif moderna, excelente para interfaces densas, tablas y fechas.
- **Fuente Secundaria (Documentos/PDFs):** **Merriweather** (o Noto Serif)  
  - Para reportes y documentos que se imprimen, con estética formal jurídica.

### 2.1 Escala Tipográfica

| Etiqueta | Clase Tailwind                              | Uso                                   |
| :------ | :------------------------------------------- | :------------------------------------ |
| **H1**  | `text-3xl font-bold text-[#111344]`          | Títulos de Dashboard/Módulos          |
| **H2**  | `text-2xl font-semibold text-[#111344]`      | Título de Expediente/Caso             |
| **H3**  | `text-lg font-medium text-slate-800`         | Encabezados de tarjetas/widgets       |
| **H4**  | `text-base font-semibold text-slate-700`     | Subtítulos dentro de tarjetas         |
| **Body**| `text-base font-normal text-slate-600`       | Texto general, descripciones de hechos|
| **Small**| `text-sm font-normal text-slate-500`        | Metadatos, notas                      |
| **Caption**| `text-xs font-medium uppercase tracking-wider` | Badges, etiquetas de tablas     |

---

## 3. Espaciado y Rejilla (Grid)

Se utiliza la escala base de 4px de Tailwind.

- **Márgenes estándar:** `m-4` (16px) entre componentes, `m-6` (24px) entre secciones.  
- **Padding en contenedores:** `p-6` o `p-8` para contenedores principales.  
- **Sidebar:** ancho fijo `w-64` (oculto en móvil).  
- **Container principal:** `max-w-7xl mx-auto`.

### 3.1 Sistema de Grid (Dashboard de Casos)

- **Mobile:** `grid-cols-1`  
- **Tablet (`md`):** `grid-cols-2 gap-4`  
- **Desktop (`lg`):** `grid-cols-3 gap-6`  
- **Wide (`xl`+):** `grid-cols-4 gap-6`

---

## 4. Componentes Clave

### 4.1 Botones

**Primario (Acción principal)**  
Uso: Crear Caso, Guardar Audiencia, Iniciar trámite.

```html
<button class="bg-[#1E40AF] text-white hover:bg-[#111344]
               focus:ring-2 focus:ring-offset-2 focus:ring-[#1E40AF]
               rounded-md shadow-sm transition-colors px-4 py-2">
  Acción
</button>
```

**Secundario (Neutral)**  
Uso: Cancelar, Filtros, Ver Detalles, Exportar.

```html
<button class="bg-white text-slate-700 border border-slate-300
               hover:bg-slate-50
               focus:ring-2 focus:ring-offset-2 focus:ring-slate-500
               rounded-md shadow-sm px-4 py-2">
  Cancelar
</button>
```

**Destructivo / Urgente (Legal Brown)**  
Uso: Eliminar evidencia, cerrar caso perdido, marcar plazo vencido.

```html
<button class="bg-white text-[#A52A2A] border border-[#A52A2A]
               hover:bg-red-50
               focus:ring-2 focus:ring-[#A52A2A]
               rounded-md px-4 py-2">
  Eliminar
</button>
```

### 4.2 Inputs de Formulario

Diseñados para formularios largos de captura procesal.

**Estado normal**

```html
<input class="block w-full rounded-md border-slate-300 shadow-sm
              focus:border-[#1E40AF] focus:ring-[#1E40AF] sm:text-sm" />
```

**Estado de error**

```html
<input class="block w-full rounded-md border-[#A52A2A] text-[#A52A2A]
              focus:border-[#A52A2A] focus:ring-[#A52A2A] sm:text-sm" />
<p class="mt-1 text-sm text-[#A52A2A]">Este campo es obligatorio.</p>
```

### 4.3 Tarjetas de Caso (Case Cards)

Componente central del Dashboard.

- Contenedor base:

```html
<article class="bg-white overflow-hidden rounded-lg shadow-sm
                border border-slate-200 hover:shadow-md transition-shadow">
  ...
</article>
```

- Indicador de estado (borde izquierdo):

```html
<!-- Normal / Investigación -->
<article class="border-l-4 border-[#1E40AF] ..."></article>

<!-- Crítico / Plazo vencido -->
<article class="border-l-4 border-[#A52A2A] ..."></article>

<!-- Resuelto / Sentencia -->
<article class="border-l-4 border-[#2F855A] ..."></article>
```

### 4.4 Badges / Etiquetas de Estado

- **Investigación:**  
  `inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10`

- **Intermedia:**  
  `inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20`

- **Juicio Oral:**  
  `inline-flex items-center rounded-full bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10`

- **Alerta de plazo (Legal Brown):**  
  `inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-bold text-[#A52A2A] ring-1 ring-inset ring-[#A52A2A]/20`

### 4.5 Modales / Diálogos

- **Overlay:** `bg-slate-900/50 backdrop-blur-sm fixed inset-0`  
- **Panel principal:** `bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full`  
- **Header:** `bg-slate-50 px-4 py-3 border-b border-slate-200`

### 4.6 Notificaciones / Toasts

- **Éxito:** fondo o borde `#2F855A`, icono `CheckCircle`.  
- **Alerta legal (plazo):** fondo `#A52A2A`, texto blanco, icono `ExclamationTriangle`, mensaje tipo _“Atención: plazo por vencer”_.

---

## 5. Iconografía

Librería: **Heroicons v2**.  

- **Outline:** navegación y elementos generales (stroke 1.5).  
- **Solid:** acciones primarias y estados activos.

| Contexto           | Icono Heroicons               | Uso                      |
| :----------------- | :--------------------------- | :----------------------- |
| Justicia           | `ScaleIcon`                  | Logo, Dashboard general  |
| Expedientes        | `BriefcaseIcon`              | Listado de casos         |
| Audiencias         | `CalendarDaysIcon`           | Módulo de audiencias     |
| Juzgados           | `BuildingLibraryIcon`        | Catálogo de juzgados     |
| Plazo fatal        | `ClockIcon` / `BellAlertIcon`| Alertas de vencimiento   |
| Evidencias         | `DocumentMagnifyingGlassIcon`| Gestión de archivos      |
| Medidas cautelares | `LockClosedIcon`             | Prisión preventiva, etc. |

---

## 6. Sombras (Shadows)

Sobrias y controladas:

- **Card normal:** `shadow-sm`  
- **Card hover:** `shadow`  
- **Dropdown/Modal:** `shadow-lg`  
- **Headers fijos (sticky):** `shadow-sm`

---

## 7. Bordes y Esquinas

- **Radio estándar:** `rounded-md` (≈6px) para inputs y botones.  
- **Tarjetas/Modales:** `rounded-lg` (≈8px).  
- Evitar radios excesivamente redondeados para mantener una estética seria y profesional.

---

## 8. Animaciones y Transiciones

Uso minimalista:

- **Hover generales:** `transition-colors duration-200 ease-in-out`  
- **Skeleton loading:** `animate-pulse` en filas de tabla y tarjetas.  
- **Alertas críticas:** `animate-bounce` solo en iconos muy puntuales (no permanente).

---

## 9. Accesibilidad (A11y)

- **Contraste:**  
  - Texto sobre fondos blancos mínimo `text-slate-600`.  
  - `#1E40AF` sobre blanco cumple WCAG AA.

- **Estados de foco:**  
  - No eliminar el `outline` sin reemplazarlo por un `ring` visible.  
  - Recomendado: `focus:ring-2 focus:ring-offset-2 focus:ring-[#1E40AF]`.

- **Semántica de estado:**  
  - Nunca usar solo color para indicar estatus.  
  - Ejemplo correcto: Badge rojo + texto **“VENCIDO”** + icono de alerta.

---

## 10. Responsive Design

Estrategia **mobile-first**, pero optimizado para escritorio (uso en oficinas).

### Breakpoints clave

- **sm (≥640px):**  
  - Sidebar oculto, menú hamburguesa.  
  - Tablas pasan a tarjetas apiladas.

- **md (≥768px):**  
  - Grid de 2 columnas para tarjetas de casos.

- **lg (≥1024px):**  
  - Sidebar fijo visible.  
  - Grid de 3 columnas.

- **xl (≥1280px):**  
  - Layout más ancho, hasta 4 columnas de casos.

---

## 11. Tokens de Diseño (Referencia JSON)

Pensado para integrarse en `tailwind.config.js` o sistema de design tokens.

```json
{
  "colors": {
    "brand": {
      "50": "#eef2ff",
      "100": "#e0e7ff",
      "200": "#c7d2fe",
      "500": "#1E40AF",
      "700": "#2C5282",
      "900": "#111344"
    },
    "legal": {
      "50": "#fdf2f2",
      "100": "#fde8e8",
      "alert": "#A52A2A",
      "success": "#2F855A"
    },
    "slate": {
      "50": "#f8fafc",
      "100": "#f1f5f9",
      "200": "#e2e8f0",
      "500": "#64748b",
      "800": "#1e293b",
      "900": "#0f172a"
    }
  },
  "fontFamily": {
    "sans": ["Inter", "system-ui", "sans-serif"],
    "serif": ["Merriweather", "serif"]
  },
  "borderRadius": {
    "DEFAULT": "0.375rem",
    "lg": "0.5rem"
  }
}
```

---

**Notas Finales**  
Este sistema de diseño debe implementarse mediante componentes reutilizables de **Blade** y **Livewire** (por ejemplo, `<x-button.primary>`, `<x-card.case>`, `<x-badge.etapa>`), para asegurar consistencia visual y semántica en toda la plataforma **Qadra**, especialmente al manejar múltiples carpetas de investigación en paralelo.
