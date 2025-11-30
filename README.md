<div align="center">

# ⚖️ Qadra

### Sistema de Gestión Procesal Penal para el CNPP Mexicano

**Plataforma SaaS Multi-Tenant para Despachos de Abogados Penalistas**

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

*Gestiona expedientes penales, audiencias, plazos fatales y evidencias bajo el Código Nacional de Procedimientos Penales*

[🚀 Demo](#demo) • [📖 Documentación](#documentación) • [✨ Características](#características) • [🛠️ Instalación](#instalación)

</div>

---

## 📋 Tabla de Contenidos

- [Equipo](#-equipo)
- [⚠️ Metodología AGENTS.md](#️-metodología-agentsmd)
- [Acerca del Proyecto](#-acerca-del-proyecto)
- [Características Principales](#-características-principales)
- [Stack Tecnológico](#-stack-tecnológico)
- [Requisitos Previos](#-requisitos-previos)
- [Instalación](#-instalación)
- [Configuración](#-configuración)
- [Uso](#-uso)
- [Arquitectura](#-arquitectura)
- [Roadmap](#-roadmap)
- [Contribución](#-contribución)
- [Licencia](#-licencia)

---

## 👥 Equipo

Este proyecto fue desarrollado por:

<table>
  <tr>
    <td align="center">
      <a href="https://github.com/eddndev">
        <img src="https://github.com/eddndev.png" width="100px;" alt="Eduardo"/><br />
        <sub><b>Eduardo</b></sub>
      </a><br />
    </td>
    <td align="center">
      <a href="https://github.com/vhhatziry">
        <img src="https://github.com/vhhatziry.png" width="100px;" alt="Hatziry"/><br />
        <sub><b>Hatziry</b></sub>
      </a><br />
    </td>
    <td align="center">
      <a href="https://github.com/Arzubide">
        <img src="https://github.com/Arzubide.png" width="100px;" alt="Gael"/><br />
        <sub><b>Gael</b></sub>
      </a><br />
    </td>
    <td align="center">
      <a href="https://github.com/Karlaelenaht">
        <img src="https://github.com/Karlaelenaht.png" width="100px;" alt="Karla"/><br />
        <sub><b>Karla</b></sub>
      </a><br />
    </td>
    <td align="center">
      <a href="https://github.com/Dvan88">
        <img src="https://github.com/Dvan88.png" width="100px;" alt="Diego"/><br />
        <sub><b>Diego</b></sub>
      </a><br />
    </td>
  </tr>
</table>

### Información Académica

- **Profesor:** Ismael Rojas Mexicano
- **Materia:** Ingeniería de Software
- **Institución:** ESCOM - IPN
- **Semestre:** 7mo semestre - 2026-1

---

## ⚠️ Metodología AGENTS.md

**IMPORTANTE:** Este proyecto sigue la metodología **AGENTS.md**, un sistema de gestión inquebrantable e inamovible para el desarrollo de software.

### 🔴 Lectura Obligatoria para Desarrolladores

Antes de trabajar en este proyecto, **DEBES** leer:

1. **[📚 /docs/AGENTS.md](/docs/AGENTS.md)** - Metodología completa (INQUEBRANTABLE)
2. **[👥 /docs/workflow/01-team-workflow.md](/docs/workflow/01-team-workflow.md)** - Flujo de trabajo en equipo
4. **[📂 /docs/README.md](/docs/README.md)** - Índice completo de la documentación

### 🎯 Filosofía: Docs-First

- ✅ **La documentación precede al código** - Planificar antes de implementar
- ✅ **GitHub como única fuente de verdad** - Todo vive en el ecosistema de GitHub
- ✅ **Issues con criterios de aceptación** - Tareas claras y medibles
- ✅ **Sprints documentados** - Bitácora en `/docs/sprints/`

### 📊 GitHub Project

- **Proyecto:** [Qadra - Development](https://github.com/users/eddndev/projects/3)
- **Automatización:** Issues se mueven automáticamente (requiere PAT configurado)
- **Kanban:** Todo → In Progress → Done

### 🔗 Enlaces Importantes

- 📋 [Issues](https://github.com/eddndev/qadra/issues) - Ver tareas pendientes
- 🔀 [Pull Requests](https://github.com/eddndev/qadra/pulls) - Revisar código
- 📊 [Project Board](https://github.com/users/eddndev/projects/3) - Kanban visual
- 📚 [Documentación](/docs) - Toda la documentación del proyecto

---

## 🎯 Acerca del Proyecto

**Qadra** es una plataforma SaaS (Software as a Service) especializada en la gestión de casos penales bajo el **Código Nacional de Procedimientos Penales (CNPP)** de México. Diseñada para despachos de abogados penalistas, permite gestionar expedientes, audiencias, plazos procesales y evidencias de manera eficiente y segura. Desarrollado como parte del curso de **Ingeniería de Software**, este proyecto implementa arquitectura multi-tenant con las mejores prácticas de desarrollo moderno.

### 🎨 Problema que Resuelve

Los despachos de abogados penalistas enfrentan desafíos críticos:
- ⏰ **Plazos fatales** del CNPP que no pueden perderse (términos constitucionales)
- 📁 **Gestión dispersa** de múltiples expedientes y carpetas de investigación
- 🔒 **Cadena de custodia** de evidencias sin trazabilidad adecuada
- 📅 **Audiencias múltiples** difíciles de coordinar entre casos
- 👥 **Colaboración deficiente** entre abogados del mismo despacho
- 📊 **Falta de visibilidad** del estado procesal de cada caso

### 💡 Nuestra Solución

Qadra centraliza la gestión procesal penal en una única plataforma:
- ⚖️ **Expedientes digitales** con seguimiento de etapas procesales (CNPP)
- ⏱️ **Alertas de plazos fatales** para términos constitucionales y procesales
- 📅 **Calendario de audiencias** integrado con notificaciones
- 🔐 **Cadena de custodia digital** para evidencias físicas
- 👥 **Multi-tenant** para aislar datos entre despachos
- 📈 **Dashboard ejecutivo** con KPIs de casos activos

---

## ✨ Características Principales

### ⚖️ Gestión de Expedientes (Casos Penales)
- **Carpetas de investigación** con NUC y número de causa penal
- **Seguimiento de etapas procesales** (Investigación → Intermedia → Juicio → Ejecución)
- **Historial inmutable** de cambios de etapa procesal
- **Asignación de abogados** responsables por caso

### 👥 Gestión de Participantes
- **Base de datos de personas** (imputados, víctimas, testigos, jueces, MP)
- **Roles por caso** con información específica de cada participante
- **Datos de contacto** y documentación asociada
- **Historial de participación** en múltiples casos

### 📅 Audiencias y Calendario
- **Programación de audiencias** con tipos del CNPP (inicial, vinculación, intermedia, juicio oral)
- **Calendario integrado** con vista por día/semana/mes
- **Notificaciones y recordatorios** previos a audiencias
- **Registro de resultados** y acuerdos de cada audiencia

### ⏱️ Plazos Fatales y Términos
- **Control de plazos procesales** con alertas configurables
- **Términos constitucionales** (48/72/144 horas) con countdown
- **Clasificación de urgencia** (fatales vs. no fatales)
- **Dashboard de vencimientos** próximos

### 🔐 Evidencias y Cadena de Custodia
- **Registro de evidencias físicas** con folio de custodia
- **Historial inmutable** de movimientos (quién entrega, quién recibe)
- **Ubicación actual** de cada evidencia
- **Documentos digitales** asociados a evidencias

### 📄 Gestión Documental
- **Almacenamiento seguro** de documentos por caso
- **Categorización** (sentencias, amparos, oficios, actas)
- **Compartir con clientes** a través del portal
- **Versionado y auditoría** de cambios

### 📊 Reportes y Dashboard
- **Dashboard ejecutivo** con KPIs de casos activos
- **Reportes por etapa procesal** y por abogado
- **Análisis de carga de trabajo** del despacho
- **Exportación** a PDF y Excel

### 🔒 Seguridad Multi-Tenant
- **Aislamiento total** de datos entre despachos
- **RBAC** con 6 roles predefinidos (owner, litigante, asociado, paralegal, administrativo, cliente)
- **Auditoría completa** de acciones del sistema
- **Encriptación** de datos sensibles

---

## 🛠️ Stack Tecnológico

### Backend
- **[Laravel 12](https://laravel.com)** - Framework PHP robusto y elegante
- **[Laravel Breeze](https://laravel.com/docs/breeze)** - Sistema de autenticación liviano
- **[Livewire 3](https://livewire.laravel.com)** - Componentes dinámicos sin JavaScript
- **MySQL/PostgreSQL** - Base de datos relacional

### Frontend
- **[Tailwind CSS v4](https://tailwindcss.com)** - Framework CSS utility-first
- **[Alpine.js](https://alpinejs.dev)** - Framework JavaScript minimalista
- **[GSAP](https://greensock.com/gsap/)** - Animaciones profesionales
- **Blade Templates** - Motor de plantillas de Laravel

### Herramientas de Desarrollo
- **Vite** - Build tool ultrarrápido
- **Composer** - Gestor de dependencias PHP
- **NPM** - Gestor de paquetes JavaScript
- **Git** - Control de versiones

### Infraestructura
- **Docker** - Contenedorización (opcional)
- **Laravel Sail** - Entorno de desarrollo local
- **Redis** - Cache y colas de trabajo

---

## 📦 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado:

- **PHP** >= 8.2
- **Composer** >= 2.6
- **Node.js** >= 18.x
- **NPM** o **Yarn**
- **MySQL** >= 8.0 o **PostgreSQL** >= 14
- **Git**

---

## 🚀 Instalación

### 1. Clonar el Repositorio

```bash
git clone https://github.com/eddndev/qadra.git
cd qadra
```

### 2. Instalar Dependencias PHP

```bash
composer install
```

### 3. Instalar Dependencias JavaScript

```bash
npm install
```

### 4. Configurar Variables de Entorno

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurar Base de Datos

Edita el archivo `.env` con tus credenciales de base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=qadra
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 6. Ejecutar Migraciones y Seeders

```bash
php artisan migrate --seed
```

### 7. Compilar Assets

```bash
npm run dev
```

### 8. Iniciar el Servidor

```bash
php artisan serve
```

Visita [http://localhost:8000](http://localhost:8000) en tu navegador.

---

## ⚙️ Configuración

### Configuración del Correo

Para habilitar notificaciones por email, configura el servicio SMTP en `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña
MAIL_ENCRYPTION=tls
```

### Configuración de Almacenamiento

Para almacenamiento en la nube (AWS S3, DigitalOcean Spaces):

```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=tu-access-key
AWS_SECRET_ACCESS_KEY=tu-secret-key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=tu-bucket
```

---

## 📖 Uso

### Usuarios de Prueba

Después de ejecutar los seeders, puedes iniciar sesión con:

**Owner (Dueño del Despacho):**
- Email: `owner@qadra.legal`
- Password: `password`

**Litigante (Abogado Principal):**
- Email: `litigante@qadra.legal`
- Password: `password`

**Cliente:**
- Email: `cliente@qadra.legal`
- Password: `password`

### Flujo de Trabajo Básico

1. **Crear un Nuevo Expediente**
   - Ve a "Casos" → "Nuevo Caso"
   - Ingresa el NUC (si ya existe) o el folio interno
   - Selecciona el tipo de delito y etapa procesal inicial
   - Asigna al abogado responsable

2. **Registrar Participantes**
   - Dentro del caso, ve a "Participantes"
   - Agrega imputados, víctimas, testigos según corresponda
   - Define el rol específico de cada persona en el caso

3. **Programar Audiencias**
   - Ve a "Audiencias" → "Nueva Audiencia"
   - Selecciona el tipo de audiencia (inicial, vinculación, intermedia, juicio oral)
   - El sistema creará automáticamente los plazos asociados

4. **Controlar Plazos Fatales**
   - El dashboard muestra plazos próximos a vencer
   - Configura alertas para términos constitucionales (48/72/144 hrs)
   - Marca plazos como cumplidos cuando corresponda

---

## 🏗️ Arquitectura

El proyecto sigue una **arquitectura MVC** (Model-View-Controller) con **Multi-Tenancy** y componentes **Livewire**:

```
qadra/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Controladores de la aplicación
│   │   ├── Middleware/       # Middleware (TenantScope, etc.)
│   │   └── Livewire/         # Componentes Livewire
│   ├── Models/               # Modelos Eloquent (Case, Participant, Hearing...)
│   │   └── Traits/           # TenantScoped, HasAuditLog
│   ├── Services/             # Lógica de negocio
│   ├── Policies/             # Políticas de autorización
│   └── Observers/            # Observers para auditoría
├── database/
│   ├── migrations/           # Migraciones (23 tablas)
│   ├── seeders/              # Tiers, Permissions, Roles, CrimeTypes
│   └── factories/            # Factories para testing
├── resources/
│   ├── views/                # Vistas Blade + Componentes
│   │   ├── components/       # Componentes reutilizables
│   │   ├── livewire/         # Vistas de componentes Livewire
│   │   └── layouts/          # Layouts (app, guest, sidebar)
│   ├── js/                   # Alpine.js
│   └── css/                  # Tailwind v4 + Design System Tokens
├── docs/                     # Documentación del proyecto
│   ├── sprints/              # Diarios de sprint
│   └── workflow/             # Flujos de trabajo del equipo
├── routes/
│   ├── web.php               # Rutas web
│   └── api.php               # Rutas API
└── tests/                    # Tests unitarios y de integración
```

### Patrones de Diseño Utilizados

- **Repository Pattern** - Abstracción de la capa de datos
- **Service Layer** - Lógica de negocio centralizada
- **Observer Pattern** - Eventos y listeners de Laravel
- **Factory Pattern** - Creación de objetos complejos
- **Singleton Pattern** - Servicios compartidos

---

## 🗺️ Roadmap (9 Sprints)

| Sprint | Nombre | Enfoque | Estado |
|--------|--------|---------|--------|
| 1 | Documentación & Setup | Docs-First, Design System, DB Schema | ✅ Completado |
| 2 | Foundation & Auth | Multi-tenancy, autenticación, RBAC | 🔜 Próximo |
| 3 | Core Legal | Casos, participantes, etapas CNPP | ⏳ Pendiente |
| 4 | Agenda & Tiempos | Audiencias, plazos fatales, calendario | ⏳ Pendiente |
| 5 | Evidencias & Documentos | Cadena custodia, archivos, compartir | ⏳ Pendiente |
| 6 | CNPP & Actuaciones | Medidas cautelares, soluciones alternas | ⏳ Pendiente |
| 7 | Billing, Reportes & Portal | Stripe, dashboard, portal clientes | ⏳ Pendiente |
| 8 | Testing & QA | Pruebas integración, E2E, performance | ⏳ Pendiente |
| 9 | Deploy & Lanzamiento | CI/CD, producción, documentación final | ⏳ Pendiente |

### Sprint 1 - Documentación & Setup ✅ Completado
- [x] Manifiesto del proyecto (`01-manifest.md`)
- [x] Sistema de diseño y tokens (`02-design-system.md`)
- [x] Esquema de base de datos (`03-database-schema.md`)
- [x] Historias de usuario (`04-user-stories.md`)
- [x] Configuración de Design System en CSS (Tailwind v4)
- [x] Documentación de áreas de trabajo del equipo

### Sprint 2 - Foundation & Auth 🔜 Próximo
- [ ] Multi-tenancy (Tenant model, tenant_id en tablas)
- [ ] Sistema de autenticación (Laravel Breeze + Livewire)
- [ ] Registro de despachos con owner automático
- [ ] Gestión de usuarios e invitaciones
- [ ] RBAC con Spatie Permission (6 roles)
- [ ] Seeders de roles, permisos y tiers

### Sprint 3 - Core Legal
- [ ] CRUD de casos/expedientes con NUC
- [ ] Gestión de participantes (imputados, víctimas, testigos, jueces, MP)
- [ ] Relación caso-participante con roles
- [ ] Transición de etapas procesales (CNPP)
- [ ] Historial inmutable de cambios de etapa

### Sprint 4 - Agenda & Tiempos
- [ ] Programación de audiencias (tipos CNPP)
- [ ] Control de plazos fatales con alertas
- [ ] Términos constitucionales (48/72/144 hrs)
- [ ] Calendario integrado con filtros
- [ ] Sistema de notificaciones

### Sprint 5 - Evidencias & Documentos
- [ ] Gestión de evidencias físicas
- [ ] Cadena de custodia digital inmutable
- [ ] Almacenamiento seguro de documentos
- [ ] Categorización de archivos
- [ ] Compartir documentos con clientes

### Sprint 6 - CNPP & Actuaciones
- [ ] Medidas cautelares (prisión preventiva, arraigo, etc.)
- [ ] Soluciones alternas (acuerdos reparatorios, suspensión condicional)
- [ ] Registro de actuaciones/actividades
- [ ] Historial de procedimientos especiales

### Sprint 7 - Billing, Reportes & Portal
- [ ] Integración con Stripe (Laravel Cashier)
- [ ] Planes de suscripción (Starter/Professional)
- [ ] Dashboard ejecutivo con KPIs
- [ ] Reportes por etapa procesal y abogado
- [ ] Portal de clientes con acceso limitado
- [ ] Exportación a PDF y Excel

### Sprint 8 - Testing & QA
- [ ] Pruebas unitarias completas
- [ ] Pruebas de integración
- [ ] Tests E2E con Playwright/Cypress
- [ ] Pruebas de carga y rendimiento
- [ ] Auditoría de seguridad
- [ ] Corrección de bugs críticos

### Sprint 9 - Deploy & Lanzamiento
- [ ] Configuración de CI/CD (GitHub Actions)
- [ ] Setup de servidor de producción
- [ ] Migración de datos de prueba
- [ ] Documentación de usuario final
- [ ] Monitoreo y logging (Sentry, Laravel Telescope)
- [ ] Lanzamiento MVP

---

## 🤝 Contribución

¡Las contribuciones son bienvenidas! Para contribuir:

1. **Fork** el proyecto
2. Crea una **rama** para tu feature (`git checkout -b feature/NuevaCaracteristica`)
3. **Commit** tus cambios (`git commit -m 'Add: Nueva característica'`)
4. **Push** a la rama (`git push origin feature/NuevaCaracteristica`)
5. Abre un **Pull Request**

### Estándares de Código

- Seguimos **PSR-12** para código PHP
- Usamos **ESLint** para JavaScript
- Commits siguiendo **Conventional Commits**
- Tests obligatorios para nuevas features

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

---

## 📞 Contacto

¿Preguntas o sugerencias?

- 🐛 Issues: [GitHub Issues](https://github.com/eddndev/qadra/issues)
- 💬 Discusiones: [GitHub Discussions](https://github.com/eddndev/qadra/discussions)
- 📊 Proyecto: [GitHub Project](https://github.com/users/eddndev/projects/3)

---

<div align="center">

**⭐ Si este proyecto te fue útil, no olvides darle una estrella ⭐**

Hecho con ❤️ por el equipo de Qadra

[⬆ Volver arriba](#-qadra)

</div>