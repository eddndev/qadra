# 🔑 Configuración del Personal Access Token (PAT)

**⚠️ ACCIÓN REQUERIDA:** Para que la automatización del GitHub Project funcione correctamente, debes crear un Personal Access Token (PAT) y agregarlo como secret en el repositorio.

---

## ¿Por qué es necesario?

El workflow de GitHub Actions `.github/workflows/project-board-automation.yml` necesita permisos especiales para interactuar con GitHub Projects v2. El `GITHUB_TOKEN` por defecto **NO** tiene estos permisos, por lo que necesitamos crear un PAT con los scopes adecuados.

---

## 📋 Pasos para Crear el PAT

### 1. Generar el Token

1. **Ve a:** https://github.com/settings/tokens
2. **Click en:** "Generate new token" → "Generate new token (classic)"
3. **Nombre del token:** `PROJECT_AUTOMATION` (o el nombre que prefieras)
4. **Expiration:** Selecciona "No expiration" o el periodo que prefieras
5. **Selecciona estos scopes:**
   - ✅ `repo` (Full control of private repositories)
   - ✅ `project` (Full control of projects)
6. **Scroll down** y click en "Generate token"
7. **⚠️ COPIA EL TOKEN INMEDIATAMENTE** - Solo se muestra una vez

### 2. Agregar el Token como Secret

1. **Ve a:** https://github.com/eddndev/qadra/settings/secrets/actions
2. **Click en:** "New repository secret"
3. **Name:** `PROJECT_PAT` (debe ser exactamente este nombre)
4. **Secret:** Pega el token que copiaste en el paso anterior
5. **Click en:** "Add secret"

---

## ✅ Verificar que Funciona

Una vez configurado el PAT, puedes verificar que funciona creando una issue de prueba:

```bash
# Crear una issue de prueba
gh issue create --title "Test de automatización" --body "Verificando workflow" --label "Type: Chore"
```

El workflow debería:
1. ✅ Añadir automáticamente la issue al proyecto
2. ✅ Moverla a la columna "Todo"

Puedes verificar los workflows ejecutados en:
https://github.com/eddndev/qadra/actions

---

## 🔒 Seguridad

- ✅ **NUNCA** compartas tu PAT públicamente
- ✅ **NUNCA** lo commites al repositorio
- ✅ Solo debe estar en los Secrets de GitHub
- ✅ Puedes revocarlo en cualquier momento desde https://github.com/settings/tokens

---

## 📊 Información del Proyecto

- **Proyecto en GitHub:** https://github.com/users/eddndev/projects/3
- **Título:** Qadra - Development
- **PROJECT_ID:** `PVT_kwHOCUkKF84BExJu`
- **Workflow configurado:** `.github/workflows/project-board-automation.yml`

---

## 🚨 Troubleshooting

### Error: "Resource not accessible by integration"
**Causa:** Falta el secret `PROJECT_PAT` o tiene permisos incorrectos
**Solución:** Verifica que hayas creado el PAT con los scopes `repo` y `project`

### La issue no se movió automáticamente
1. Verifica que el workflow se ejecutó: `gh run list --limit 5`
2. Ver logs si falló: `gh run view [RUN_ID] --log`
3. Verifica que la issue NO tiene label `Epic` (las épicas no se mueven al tablero)

### El PAT expiró
1. Genera un nuevo token siguiendo los pasos del punto 1
2. Actualiza el secret en: https://github.com/eddndev/qadra/settings/secrets/actions

---

**Documentación relacionada:**
- Metodología completa: `/docs/AGENTS.md`
- Workflow de equipo: `/docs/workflow/01-team-workflow.md`
- Setup de GitHub Projects: `/docs/workflow/03-github-projects-setup.md`