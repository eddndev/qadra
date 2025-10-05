<div align="center">

# ⚖️ Nombre del proyecto

### Sistema SaaS para la Gestión Procesal de Despachos Legales y Financieros

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

*Transformando la gestión legal con tecnología de vanguardia*

[🚀 Demo](#demo) • [📖 Documentación](#documentación) • [✨ Características](#características) • [🛠️ Instalación](#instalación)

</div>

---

## 📋 Tabla de Contenidos

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
- [Equipo](#-equipo)
- [Licencia](#-licencia)

---

## ⚠️ Metodología AGENTS.md

**IMPORTANTE:** Este proyecto sigue la metodología **AGENTS.md**, un sistema de gestión inquebrantable e inamovible para el desarrollo de software.

### 🔴 Lectura Obligatoria para Desarrolladores

Antes de trabajar en este proyecto, **DEBES** leer:

1. **[📚 /docs/AGENTS.md](/docs/AGENTS.md)** - Metodología completa (INQUEBRANTABLE)
2. **[🔑 /docs/SETUP-PAT.md](/docs/SETUP-PAT.md)** - Configurar Personal Access Token
3. **[👥 /docs/workflow/01-team-workflow.md](/docs/workflow/01-team-workflow.md)** - Flujo de trabajo en equipo
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

**LegalFlow Pro** es una plataforma SaaS (Software as a Service) diseñada específicamente para revolucionar la gestión procesal en despachos legales y financieros. Desarrollado como parte del curso de **Ingeniería de Software**, este proyecto combina las mejores prácticas de desarrollo moderno con una comprensión profunda de las necesidades del sector legal.

### 🎨 Problema que Resuelve

Los despachos legales y financieros enfrentan desafíos diarios:
- 📊 **Gestión desorganizada** de expedientes y casos
- ⏰ **Pérdida de plazos** y fechas críticas
- 👥 **Comunicación fragmentada** entre abogados y clientes
- 📄 **Documentación dispersa** y difícil de rastrear
- 💰 **Facturación manual** propensa a errores

### 💡 Nuestra Solución

LegalFlow Pro centraliza todas las operaciones del despacho en una única plataforma intuitiva y potente:
- ✅ **Gestión integral de casos** con seguimiento en tiempo real
- 🔔 **Notificaciones automáticas** de plazos y audiencias
- 📱 **Portal del cliente** para comunicación directa
- 🗂️ **Repositorio documental** organizado y seguro
- 💳 **Facturación automatizada** y control financiero

---

## ✨ Características Principales

### 🏛️ Gestión de Casos
- **Dashboard intuitivo** con vista general de todos los expedientes
- **Seguimiento de plazos** procesales con alertas automáticas
- **Asignación de tareas** a miembros del equipo
- **Historial completo** de actuaciones y movimientos

### 👤 Gestión de Clientes
- **Portal del cliente** con acceso 24/7 a su información
- **Sistema de mensajería** integrado
- **Generación automática** de contratos y documentos
- **Historial de comunicaciones** y consultas

### 📂 Gestión Documental
- **Almacenamiento seguro** en la nube
- **Versionado de documentos** con control de cambios
- **Búsqueda avanzada** por múltiples criterios
- **Plantillas personalizables** para escritos y demandas

### 💰 Gestión Financiera
- **Facturación electrónica** automatizada
- **Control de honorarios** y gastos procesales
- **Reportes financieros** detallados
- **Integración con sistemas de pago**

### 📊 Reportes y Análisis
- **Dashboards personalizables** con métricas clave
- **Reportes de productividad** del equipo
- **Análisis de rentabilidad** por caso
- **Exportación a Excel/PDF**

### 🔒 Seguridad y Cumplimiento
- **Autenticación de dos factores** (2FA)
- **Encriptación end-to-end** de datos sensibles
- **Auditoría completa** de acciones y cambios
- **Cumplimiento GDPR** y protección de datos

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
git clone https://github.com/tu-usuario/legalflow-pro.git
cd legalflow-pro
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
DB_DATABASE=legalflow
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

**Administrador:**
- Email: `admin@legalflow.com`
- Password: `password`

**Abogado:**
- Email: `abogado@legalflow.com`
- Password: `password`

**Cliente:**
- Email: `cliente@legalflow.com`
- Password: `password`

### Flujo de Trabajo Básico

1. **Crear un Nuevo Caso**
   - Ve a "Casos" → "Nuevo Caso"
   - Completa la información del cliente y detalles del caso
   - Asigna abogados y establece plazos

2. **Gestionar Documentos**
   - Dentro del caso, ve a la pestaña "Documentos"
   - Sube archivos relevantes y organízalos por categorías
   - Comparte documentos con el cliente según sea necesario

3. **Facturación**
   - Ve a "Finanzas" → "Nueva Factura"
   - Selecciona el cliente y añade conceptos
   - Genera y envía la factura automáticamente

---

## 🏗️ Arquitectura

El proyecto sigue una **arquitectura MVC** (Model-View-Controller) mejorada con:

```
ing-soft/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Controladores de la aplicación
│   │   ├── Middleware/       # Middleware personalizado
│   │   └── Livewire/         # Componentes Livewire
│   ├── Models/               # Modelos Eloquent
│   ├── Services/             # Lógica de negocio
│   └── Repositories/         # Capa de acceso a datos
├── database/
│   ├── migrations/           # Migraciones de base de datos
│   ├── seeders/              # Datos de prueba
│   └── factories/            # Factories para testing
├── resources/
│   ├── views/                # Vistas Blade
│   ├── js/                   # JavaScript y Alpine.js
│   └── css/                  # Estilos Tailwind
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

## 🗺️ Roadmap

### Fase 1 - MVP ✅ (Completado)
- [x] Sistema de autenticación
- [x] CRUD de clientes
- [x] Gestión básica de casos
- [x] Dashboard principal

### Fase 2 - Core Features 🔄 (En Progreso)
- [x] Sistema de notificaciones
- [ ] Gestión documental avanzada
- [ ] Facturación automatizada
- [ ] Portal del cliente

### Fase 3 - Mejoras (Planificado)
- [ ] Integración con e-firma
- [ ] API RESTful completa
- [ ] App móvil (iOS/Android)
- [ ] Inteligencia artificial para análisis de documentos

### Fase 4 - Escalabilidad (Futuro)
- [ ] Multi-tenancy completo
- [ ] Integración con sistemas judiciales
- [ ] Reportes avanzados con BI
- [ ] Módulo de CRM integrado

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

## 👥 Equipo

Este proyecto fue desarrollado por:

<table>
  <tr>
    <td align="center">
      <a href="https://github.com/colaborador1">
        <img src="https://github.com/colaborador1.png" width="100px;" alt="Colaborador 1"/><br />
        <sub><b>Nombre Colaborador 1</b></sub>
      </a><br />
      <sub>Full Stack Developer</sub>
    </td>
    <td align="center">
      <a href="https://github.com/colaborador2">
        <img src="https://github.com/colaborador2.png" width="100px;" alt="Colaborador 2"/><br />
        <sub><b>Nombre Colaborador 2</b></sub>
      </a><br />
      <sub>Backend Developer</sub>
    </td>
    <td align="center">
      <a href="https://github.com/colaborador3">
        <img src="https://github.com/colaborador3.png" width="100px;" alt="Colaborador 3"/><br />
        <sub><b>Nombre Colaborador 3</b></sub>
      </a><br />
      <sub>Frontend Developer</sub>
    </td>
    <td align="center">
      <a href="https://github.com/colaborador4">
        <img src="https://github.com/colaborador4.png" width="100px;" alt="Colaborador 4"/><br />
        <sub><b>Nombre Colaborador 4</b></sub>
      </a><br />
      <sub>UI/UX Designer</sub>
    </td>
    <td align="center">
      <a href="https://github.com/colaborador5">
        <img src="https://github.com/colaborador5.png" width="100px;" alt="Colaborador 5"/><br />
        <sub><b>Nombre Colaborador 5</b></sub>
      </a><br />
      <sub>QA Engineer</sub>
    </td>
  </tr>
</table>

### Información Académica

- **Profesor:** [Nombre del Profesor]
- **Materia:** Ingeniería de Software
- **Institución:** [Tu Universidad]
- **Semestre:** [Semestre/Año]

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

---

## 📞 Contacto

¿Preguntas o sugerencias?

- 📧 Email: contacto@legalflow.com
- 🐛 Issues: [GitHub Issues](https://github.com/tu-usuario/legalflow-pro/issues)
- 💬 Discusiones: [GitHub Discussions](https://github.com/tu-usuario/legalflow-pro/discussions)

---

<div align="center">

**⭐ Si este proyecto te fue útil, no olvides darle una estrella ⭐**

Hecho con ❤️ por el equipo de LegalFlow Pro

[⬆ Volver arriba](#️-legalflow-pro)

</div>