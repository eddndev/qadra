# 📚 Documentación del Proyecto Qadra

Bienvenido a la documentación central del proyecto Qadra. Esta carpeta contiene toda la información necesaria para entender, desarrollar y colaborar en el proyecto siguiendo la metodología **AGENTS.md**.

---

## 📁 Estructura de la Documentación

```
docs/
├── AGENTS.md                    # 🔴 METODOLOGÍA INQUEBRANTABLE - Leer primero
├── SETUP-PAT.md                 # 🔑 Configuración del Personal Access Token
├── 01-manifest.md               # 📋 Constitución del proyecto (visión, objetivos, alcance)
├── 02-design-system.md          # 🎨 Sistema de diseño (colores, tipografía, componentes)
├── 03-database-schema.md        # 🗄️ Esquema de la base de datos (diagrama ERD)
├── 04-user-stories.md           # 📝 Backlog de historias de usuario
├── workflow/                    # 🔄 Documentación de procesos de trabajo
│   ├── 01-team-workflow.md      # 👥 Flujo de trabajo en equipo
│   ├── 02-branch-protection.md  # 🔒 Protección de la rama main
│   └── 03-github-projects-setup.md  # 📊 Setup de GitHub Projects
└── sprints/                     # 🚀 Diarios de sprints
    └── [sprint-number]-[sprint-name].md
```

---

## 🚀 Inicio Rápido

### 1. Lectura Obligatoria (Antes de empezar)

**⚠️ IMPORTANTE: Leer en este orden:**

1. **`AGENTS.md`** - La metodología completa del proyecto. **INQUEBRANTABLE e INAMOVIBLE.**
2. **`workflow/01-team-workflow.md`** - Entender el flujo de trabajo en equipo
3. **`01-manifest.md`** - Visión y alcance del proyecto

### 2. Acción Requerida: Configurar PAT

Para que la automatización funcione:
1. Lee `SETUP-PAT.md`
2. Crea el Personal Access Token
3. Agrégalo como secret `PROJECT_PAT` en el repositorio

### 3. Documentos por Completar

Los siguientes documentos son **templates** que deben ser completados con la información real del proyecto:

- [ ] **01-manifest.md** - Define la visión, objetivos y alcance del proyecto
- [ ] **02-design-system.md** - Documenta colores, tipografía y componentes del diseño
- [ ] **03-database-schema.md** - Crea el diagrama ERD de la base de datos
- [ ] **04-user-stories.md** - Lista todas las historias de usuario del backlog

---

## 🎯 Filosofía: Docs-First

Este proyecto sigue la filosofía **"Docs-First"**:

1. **La documentación precede al código** - Se define el "qué", "porqué" y "cómo" antes de implementar
2. **GitHub como única fuente de verdad** - Todo vive en GitHub (código, docs, issues, discusiones)
3. **Documentación viva** - Los documentos se actualizan cuando cambian decisiones de arquitectura

---

## 📊 GitHub Project

- **Proyecto:** [Qadra - Development](https://github.com/users/eddndev/projects/3)
- **PROJECT_ID:** `PVT_kwHOCUkKF84BExJu`
- **Workflow:** `.github/workflows/project-board-automation.yml`

### Automatizaciones Activas (requiere PAT configurado):

- ✅ Nueva issue → se añade al proyecto y mueve a "Todo"
- ✅ Asignar issue → se mueve a "In Progress"
- ✅ Cerrar issue → se mueve a "Done"
- ❌ Issues con label `Epic` NO se añaden al tablero Kanban

---

## 📋 Sistema de Etiquetas (Labels)

### Tipo de Tarea
- `Type: Feature` - Nueva funcionalidad
- `Type: Chore` - Mantenimiento, configuración
- `Type: Bug` - Corrección de errores
- `Type: Documentation` - Documentación

### Módulo
- `Module: Auth` - Autenticación y usuarios
- `Module: Database` - Migraciones y esquema
- `Module: UI/UX` - Frontend y estilos
- `Module: Core` - Lógica de negocio

### Prioridad
- `Priority: Critical` 🔴 - Inmediato
- `Priority: High` 🟠 - Importante
- `Priority: Medium` 🟡 - Normal
- `Priority: Low` 🟢 - Baja urgencia

### Especiales
- `Epic` 📚 - Issues "padre" que agrupan tareas
- `Sprint: X` 🚀 - Tareas del sprint X
- `Status: Blocked` 🚧 - Bloqueada
- `Status: Needs Review` 👀 - PR abierto

---

## 🔄 Flujo de Trabajo Básico

```bash
# 1. Ver issues asignadas
gh issue list --assignee "@me"

# 2. Crear rama desde main
git checkout main
git pull origin main
git checkout -b feature/issue-X-descripcion

# 3. Trabajar y commitear
git add .
git commit -m "feat(module): descripción

Detalles del cambio

Refs #X"

# 4. Push y crear PR
git push -u origin feature/issue-X-descripcion
gh pr create --fill

# 5. Esperar review y merge
```

---

## 📝 Plantilla de Issue

Cada issue debe seguir esta estructura:

```markdown
**Descripción:**
> [Propósito de la tarea]

---

### Criterios de Aceptación (AC)
- [ ] Criterio 1 (condición medible)
- [ ] Criterio 2
- [ ] Criterio 3

---

### Tareas Técnicas
- [ ] Tarea técnica 1
- [ ] Tarea técnica 2
- [ ] Tarea técnica 3
```

---

## 🚀 Sprints

Cada sprint debe tener:
1. **Épica Maestra** (issue con label `Epic`) que agrupa todas las tareas
2. **Diario del Sprint** en `/docs/sprints/[number]-[name].md`

### Crear un nuevo sprint:

```bash
# 1. Crear el diario del sprint
cp docs/sprints/template.md docs/sprints/02-nombre-sprint.md

# 2. Crear la Épica Maestra en GitHub
gh issue create --title "Sprint 2: Nombre del Sprint" --label "Epic,Sprint: 2"

# 3. Crear las issues del sprint y vincularlas a la épica
```

---

## 🔗 Enlaces Útiles

- **Metodología completa:** `/docs/AGENTS.md`
- **Proyecto en GitHub:** https://github.com/users/eddndev/projects/3
- **Issues:** https://github.com/eddndev/qadra/issues
- **Pull Requests:** https://github.com/eddndev/qadra/pulls
- **Actions (workflows):** https://github.com/eddndev/qadra/actions

---

## 📞 Contacto

- **Maintainer:** @eddndev
- **Código de Conducta:** Respetar la metodología AGENTS.md
- **Reportar problemas:** Crear un issue con label `Type: Bug`

---

**Última actualización:** 2025-10-05
**Versión de la metodología:** 1.1