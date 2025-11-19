# Manifiesto del Proyecto: QADRA - Plataforma SaaS de Gestión Procesal Penal

**Versión:** 2.0
**Fecha:** 18 de noviembre de 2025
**Autor:** Equipo Qadra - ESCOM IPN

---

## 1. Resumen Ejecutivo

**Qadra** es una plataforma SaaS (Software as a Service) especializada en la **gestión procesal de casos penales** para despachos legales en México. A diferencia de los sistemas tradicionales de gestión de casos, Qadra se enfoca exclusivamente en el **control y seguimiento del proceso procesal penal** bajo el Código Nacional de Procedimientos Penales (CNPP), desde la investigación inicial hasta la ejecución de sentencias.

El sistema permite a los despachos legales especializados en derecho penal llevar un control exhaustivo de las etapas procesales, audiencias, evidencias, actuaciones, medidas cautelares y estados de cada caso, optimizando la gestión administrativa y reduciendo el riesgo de pérdida de plazos críticos.

Qadra no es un sistema de gestión de "casos legales" genéricos, es un **sistema procesal especializado** que entiende y modela el flujo completo del sistema acusatorio penal mexicano.

---

## 2. Declaración del Problema

Los despachos legales especializados en derecho penal en México enfrentan desafíos críticos en la gestión procesal:

* **Problema 1: Complejidad del Sistema Procesal Penal Acusatorio**
  El CNPP establece 3 etapas principales (Investigación, Intermedia, Juicio) con múltiples fases, audiencias y plazos. Los despachos necesitan un sistema que entienda esta complejidad específica, no un CRM genérico.

* **Problema 2: Riesgo de Pérdida de Plazos Procesales**
  Los plazos en materia penal son críticos (72 horas para audiencia inicial, 2-6 meses para investigación complementaria, etc.). No hay margen de error. Los sistemas genéricos no ofrecen alertas especializadas.

* **Problema 3: Gestión Deficiente de Evidencias y Cadena de Custodia**
  El manejo de evidencias, documentos, datos de prueba y medios de prueba requiere trazabilidad completa y acceso rápido para preparar audiencias. Los despachos suelen manejar esto en carpetas físicas o sistemas dispersos.

* **Problema 4: Falta de Visibilidad del Estado Procesal en Tiempo Real**
  Los despachos con múltiples casos necesitan ver de un vistazo qué casos están en qué etapa, cuáles tienen audiencias próximas, cuáles están en riesgo de vencer plazos, y cuáles requieren actuaciones urgentes.

* **Problema 5: Dificultad para Gestionar Equipos y Clientes en Multi-Despacho**
  Los despachos necesitan autonomía para gestionar su equipo interno (abogados, paralegales, asistentes) con permisos granulares, sin depender de un administrador externo para cada cambio.

* **Problema 6: Falta de Sistemas Especializados para el Mercado Mexicano**
  La mayoría de los sistemas de gestión legal son genéricos (casos civiles, mercantiles, etc.) o están diseñados para sistemas legales de otros países. No existen soluciones SaaS especializadas en el proceso penal mexicano.

---

## 3. Visión y Solución Propuesta

**Visión:**
Convertirnos en la plataforma SaaS líder en México para despachos legales penales, siendo la **única fuente de verdad procesal** que garantiza que ningún despacho pierda un plazo, olvide una actuación o desorganice sus evidencias.

**Solución:**
Qadra es un sistema SaaS multi-tenant que modela completamente el **Sistema Procesal Penal Acusatorio Mexicano** según el CNPP, ofreciendo:

1. **Módulo de Gestión de Casos Penales**
   - Creación y seguimiento de expedientes penales (carpetas de investigación)
   - Modelado de las 3 etapas procesales + ejecución (Investigación Inicial/Complementaria, Intermedia, Juicio Oral, Ejecución)
   - Estados procesales dinámicos por etapa
   - Gestión de participantes (imputados, víctimas, testigos, ministerio público, jueces)

2. **Módulo de Audiencias y Plazos**
   - Calendario de audiencias con alertas automáticas
   - Tipos de audiencias especializadas (audiencia inicial, formulación de imputación, vinculación a proceso, audiencia intermedia, juicio oral)
   - Control de plazos procesales críticos con notificaciones preventivas
   - Registro de resultados y acuerdos de audiencias

3. **Módulo de Evidencias y Documentos**
   - Gestión de evidencias con cadena de custodia digital
   - Almacenamiento seguro de documentos por etapa procesal
   - Clasificación de datos de prueba vs medios de prueba vs pruebas admitidas
   - Versionado y trazabilidad de documentos clave

4. **Módulo de Actuaciones y Diligencias**
   - Registro de todas las actuaciones procesales (denuncias, querellas, citatorios, notificaciones, solicitudes)
   - Bitácora cronológica de eventos del caso
   - Asignación de responsables y seguimiento de cumplimiento

5. **Módulo de Medidas Cautelares y Soluciones Alternas**
   - Gestión de medidas cautelares impuestas (prisión preventiva, presentaciones periódicas, monitoreo electrónico, etc.)
   - Seguimiento de soluciones alternas (acuerdos reparatorios, suspensión condicional del proceso)
   - Control de procedimientos abreviados

6. **Sistema de Equipos (Workspaces) Multi-Tenant**
   - Cada despacho legal es un "workspace" aislado
   - Gestión autónoma de miembros del equipo con roles y permisos
   - Control de suscripción y límites operacionales por tier
   - Portal para clientes (opcional según tier)

7. **Sistema de Suscripciones y Tiers**
   - Modelo de suscripción por equipo con límites de casos activos, usuarios y almacenamiento
   - Múltiples tiers con funcionalidades escalonadas
   - Facturación automatizada con Laravel Cashier + Stripe

8. **Backoffice con Laravel Nova 5**
   - Panel administrativo para el equipo de Qadra
   - Gestión de tenants, suscripciones, límites y configuraciones globales
   - Métricas de uso, facturación y soporte

---

## 4. Perfiles de Usuario (Target Audience)

El sistema tiene dos niveles de usuarios: **usuarios del sistema (nosotros)** y **usuarios de los despachos (clientes)**:

### Usuarios del Sistema (Qadra Team):
* **Super Admin (Equipo Qadra):**
  Gestiona la plataforma completa desde Laravel Nova. Controla tenants, suscripciones, límites, funcionalidades por tier, facturación global, métricas y soporte.

### Usuarios de los Despachos (Clientes de Qadra):

* **Owner/Host del Despacho:**
  El propietario del despacho legal que contrató Qadra. Tiene control total sobre su workspace: gestiona miembros del equipo, asigna roles y permisos, controla la suscripción, configura el despacho. Puede gestionar todos los casos del despacho.

* **Abogado Litigante/Senior:**
  Abogado con experiencia que lleva casos penales como responsable principal. Necesita crear casos, gestionar evidencias, programar audiencias, asignar tareas al equipo, acceder a reportes de sus casos. Puede delegar trabajo a abogados junior o paralegales.

* **Abogado Asociado/Junior:**
  Abogado que apoya en casos bajo supervisión de un senior. Necesita acceder a casos asignados, subir documentos, registrar actuaciones, preparar evidencias, actualizar estados procesales. Puede tener restricciones para eliminar o cerrar casos.

* **Paralegal/Asistente Legal:**
  Personal de apoyo que ayuda en tareas administrativas del proceso. Necesita subir documentos, programar audiencias, hacer seguimiento de plazos, registrar actuaciones básicas. No tiene permisos para decisiones procesales críticas ni acceso a información financiera del despacho.

* **Administrativo:**
  Personal que gestiona aspectos no legales del despacho. Puede gestionar clientes, programar citas, generar reportes básicos. No tiene acceso a información procesal sensible ni evidencias.

* **Cliente del Despacho (Portal de Cliente):**
  Persona que contrató los servicios del despacho (víctima o imputado representado). Necesita ver el estado de su caso, documentos compartidos, próximas audiencias, comunicarse con su abogado. Acceso limitado solo a su(s) caso(s) y sin permisos de edición.

---

## 5. Objetivos Principales (Goals)

### Para el Negocio/Organización (Qadra):
* **Objetivo 1: Capturar el mercado de despachos penales en México**
  Lograr que 500 despachos legales penales en México adopten Qadra como su sistema de gestión procesal en los primeros 24 meses.

* **Objetivo 2: Generar ingresos recurrentes escalables**
  Alcanzar $50,000 USD MRR (Monthly Recurring Revenue) en los primeros 18 meses con un modelo de suscripción SaaS escalable.

* **Objetivo 3: Posicionarse como especialistas en legal tech penal mexicano**
  Ser reconocidos como la única plataforma SaaS especializada en el proceso penal acusatorio mexicano, diferenciándonos de sistemas genéricos.

### Para el Usuario (Despachos Legales):
* **Objetivo 1: Reducir a cero la pérdida de plazos procesales críticos**
  Garantizar que ningún despacho que use Qadra pierda un plazo procesal por desorganización o falta de alertas, mediante notificaciones automáticas y calendarios inteligentes.

* **Objetivo 2: Reducir el tiempo administrativo en 60%**
  Automatizar tareas repetitivas (registro de actuaciones, generación de reportes, alertas de plazos) permitiendo a los abogados enfocarse en la estrategia legal, no en la administración.

* **Objetivo 3: Centralizar toda la información procesal en un solo lugar**
  Eliminar la dispersión de información en carpetas físicas, emails, WhatsApp, Excel. Qadra es la única fuente de verdad del estado procesal de cada caso.

* **Objetivo 4: Facilitar la colaboración entre equipos**
  Permitir que múltiples abogados, paralegales y asistentes trabajen en el mismo caso de forma coordinada, con visibilidad en tiempo real de actuaciones y responsabilidades.

---

## 6. Alcance del Proyecto (Scope)

### Funcionalidades INCLUIDAS (Producto Mínimo Viable - MVP v1.0)

#### **Módulo 1: Gestión de Workspaces (Equipos/Despachos)**
* Creación de workspace al registrarse (onboarding)
* Gestión de miembros del equipo (invitar, remover, cambiar roles)
* Configuración del despacho (nombre, logo, información de contacto)
* Control de suscripción y límites operacionales según tier

#### **Módulo 2: Gestión de Casos Penales**
* CRUD de casos penales (expedientes)
* Registro de información básica del caso (número de carpeta, delito, fecha de inicio)
* Asignación de caso a etapa procesal (Investigación Inicial, Complementaria, Intermedia, Juicio, Ejecución)
* Estados dinámicos por etapa
* Gestión de participantes del caso (imputados, víctimas, testigos, ministerio público, jueces, peritos)
* Asignación de abogados responsables del caso
* Dashboard con vista general de todos los casos del despacho

#### **Módulo 3: Audiencias y Plazos**
* CRUD de audiencias vinculadas a casos
* Tipos de audiencias especializadas (audiencia inicial, formulación de imputación, vinculación a proceso, audiencia intermedia, juicio oral)
* Registro de fecha, hora, juzgado, juez, asistentes, resultado
* Calendario de audiencias del despacho
* Alertas automáticas de audiencias próximas (7 días, 3 días, 1 día, día de)
* Control de plazos procesales críticos con alertas preventivas

#### **Módulo 4: Evidencias y Documentos**
* Subida y almacenamiento de archivos por caso
* Clasificación de documentos por tipo (denuncia, querella, ampliación de denuncia, solicitudes, oficios, acuerdos, evidencias, etc.)
* Metadatos de documentos (fecha de emisión, autoridad emisora, descripción)
* Visualizador de documentos en navegador
* Control de acceso a documentos según permisos del usuario
* Límites de almacenamiento según tier de suscripción

#### **Módulo 5: Actuaciones y Diligencias**
* Registro de actuaciones procesales vinculadas a casos
* Bitácora cronológica de eventos del caso
* Tipos de actuaciones (denuncia, querella, citatorio, notificación, solicitud, comparecencia, etc.)
* Asignación de responsables y fechas de cumplimiento
* Notas y observaciones por actuación

#### **Módulo 6: Autenticación y Usuarios**
* Registro de despachos (workspaces)
* Login con email/password (Laravel Breeze)
* Gestión de perfil de usuario
* Sistema de roles por workspace (Owner, Litigante, Asociado, Paralegal, Administrativo)
* Permisos granulares por rol

#### **Módulo 7: Suscripciones y Facturación**
* Integración con Stripe vía Laravel Cashier
* Modelo de suscripción mensual/anual
* 2 Tiers: Starter y Professional
* Límites operacionales por tier (casos activos, usuarios, almacenamiento)
* Dashboard de facturación para el Owner del despacho
* Facturación automática y gestión de métodos de pago

#### **Módulo 8: Backoffice (Laravel Nova 5)**
* Panel administrativo para equipo de Qadra
* Gestión de workspaces (despachos)
* Gestión de usuarios y suscripciones
* Métricas de uso (casos creados, usuarios activos, almacenamiento)
* Configuración de tiers y límites
* Soporte y resolución de incidencias

### Funcionalidades EXCLUIDAS (Fuera de Alcance para la v1.0)

* **Portal de Clientes:**
  En v1.0 solo los miembros del despacho pueden acceder. El portal para que los clientes vean el estado de sus casos se implementará en v2.0 (funcionalidad premium).

* **Integraciones Externas:**
  No habrá integración con sistemas judiciales oficiales, WhatsApp Business, email (más allá de notificaciones básicas), ni sistemas contables en v1.0.

* **Aplicación Móvil:**
  La v1.0 será solo web responsive. Apps nativas iOS/Android se planifican para v3.0.

* **Reportes Avanzados y BI:**
  Solo habrá reportes básicos de casos. Reportes avanzados con métricas de desempeño, rentabilidad por caso, y análisis predictivo se implementarán en v2.0.

* **Gestión Financiera Completa:**
  No habrá módulo de facturación a clientes ni control de pagos de honorarios en v1.0. Solo gestión de la suscripción de Qadra.

* **Gestión de Recursos Humanos:**
  No habrá control de asistencia, nómina ni evaluaciones de desempeño del equipo.

* **Firma Electrónica:**
  No habrá integración con proveedores de e-firma (FielSign, Adobe Sign, etc.) en v1.0.

* **Inteligencia Artificial:**
  No habrá análisis de documentos con IA, sugerencias de estrategia legal, ni chatbots en v1.0.

---

## 7. Stack Tecnológico

### Backend
* **Framework:** Laravel 12 (PHP 8.2+)
* **Autenticación:** Laravel Breeze (sesiones web)
* **OAuth Social:** Laravel Socialite (Google, Microsoft - opcional)
* **Panel Admin:** Laravel Nova 5 (backoffice para equipo Qadra)
* **Base de Datos:** MySQL 8.0+ o PostgreSQL 14+
* **ORM:** Eloquent
* **Permisos:** Spatie Laravel Permission (roles y permisos por workspace)
* **Suscripciones:** Laravel Cashier (Stripe)
* **Colas:** Redis + Laravel Queue (notificaciones, procesamiento de archivos)
* **Cache:** Redis
* **Almacenamiento:** Laravel Storage (local en dev, S3/DigitalOcean Spaces en prod)

### Frontend
* **Framework:** Livewire 3 (componentes reactivos sin escribir JavaScript)
* **CSS:** Tailwind CSS v4
* **JavaScript:** Alpine.js (interactividad mínima en frontend)
* **Animaciones:** GSAP (opcional para UX premium)
* **Templating:** Blade (motor de plantillas de Laravel)
* **Build Tool:** Vite

### Infraestructura
* **Servidor Web:** Nginx
* **Entorno Local:** Laravel Sail (Docker)
* **Hosting Producción:** DigitalOcean Droplets / AWS EC2 / Laravel Forge + Envoyer
* **CDN:** Cloudflare (archivos estáticos)
* **Email:** Mailgun / SendGrid / Amazon SES
* **Monitoreo:** Laravel Telescope (dev) + Sentry (errores en prod)
* **Backups:** Laravel Backup (diario, almacenado en S3)

### Multi-Tenancy
* **Estrategia:** Single Database + tenant_id (approach recomendado para v1.0)
* **Paquete:** Custom implementation con Spatie Permission para scoping

### Otros
* **Control de Versiones:** Git + GitHub
* **CI/CD:** GitHub Actions
* **Documentación:** Markdown en `/docs/` (metodología AGENTS.md)
* **Testing:** PHPUnit + Pest (tests unitarios y de feature)

---

## 8. Stakeholders Clave

* **Propietario del Producto:** Equipo Qadra (Eduardo, Hatziry, Gael, Karla, Diego)
* **Líder de Desarrollo:** Eduardo (@eddndev)
* **Arquitecto de Base de Datos:** Por asignar
* **Diseñador UX/UI:** Por asignar (o usar templates de Tailwind UI)
* **Product Owner:** Hatziry (@vhhatziry)
* **QA/Testing:** Todo el equipo
* **Profesor/Asesor:** Ismael Rojas Mexicano (ESCOM - IPN)

---

## 9. Métricas de Éxito

### Métricas de Producto (KPIs):
* **Tasa de Adopción:** 50 despachos registrados en los primeros 6 meses
* **Retención:** Tasa de churn < 10% mensual
* **Actividad:** 70% de los despachos registran al menos 1 caso nuevo por semana
* **NPS (Net Promoter Score):** > 50 en los primeros 12 meses

### Métricas Técnicas:
* **Uptime:** 99.5% de disponibilidad de la plataforma
* **Performance:** Tiempo de carga < 2 segundos en páginas principales
* **Cobertura de Tests:** > 70% de cobertura de código
* **Bugs Críticos:** < 5 bugs críticos por sprint

### Métricas de Negocio:
* **MRR (Monthly Recurring Revenue):** $5,000 USD en primeros 6 meses, $20,000 USD en 12 meses
* **LTV (Lifetime Value):** > $3,000 USD por despacho
* **CAC (Customer Acquisition Cost):** < $500 USD por despacho
* **Conversión Trial-to-Paid:** > 25%

---

## 10. Línea de Tiempo Estimada

### Fase 1 - Documentación y Setup (2 semanas)
* Sprint 0: Documentación completa (manifest, database schema, user stories, design system)
* Setup del proyecto Laravel 12 + Breeze + Livewire 3 + Nova 5
* Configuración de base de datos, migraciones iniciales, seeders
* Setup de CI/CD con GitHub Actions

### Fase 2 - Core Features (6 semanas)
* Sprint 1: Autenticación, Workspaces, Usuarios, Roles y Permisos (2 semanas)
* Sprint 2: CRUD de Casos, Participantes, Estados Procesales (2 semanas)
* Sprint 3: Audiencias, Plazos, Alertas, Calendario (2 semanas)

### Fase 3 - Evidencias y Actuaciones (4 semanas)
* Sprint 4: Gestión de Documentos, Evidencias, Almacenamiento (2 semanas)
* Sprint 5: Actuaciones, Diligencias, Bitácora de Caso (2 semanas)

### Fase 4 - Suscripciones y Backoffice (3 semanas)
* Sprint 6: Integración con Stripe, Tiers, Límites Operacionales (2 semanas)
* Sprint 7: Laravel Nova 5, Panel Admin, Métricas (1 semana)

### Fase 5 - Testing, QA y Deploy (3 semanas)
* Sprint 8: Testing completo, corrección de bugs, optimización de performance (2 semanas)
* Sprint 9: Deploy a producción, documentación de usuario, video demo (1 semana)

**Lanzamiento MVP:** Semana 18 (aproximadamente 4.5 meses)

---

## 11. Riesgos y Consideraciones

### Riesgos Técnicos:

* **Riesgo 1: Complejidad del Sistema Procesal Penal**
  **Descripción:** El CNPP es complejo con múltiples estados, transiciones y reglas. Modelar esto incorrectamente puede causar inconsistencias.
  **Mitigación:** Investigación exhaustiva del CNPP, validación con abogados penales reales, testing intensivo de flujos procesales.

* **Riesgo 2: Escalabilidad del Multi-Tenancy**
  **Descripción:** El approach single database + tenant_id puede tener problemas de performance con muchos tenants.
  **Mitigación:** Usar índices correctos en tenant_id, implementar global scopes, monitorear queries, considerar migración a multi-database en v2.0 si es necesario.

* **Riesgo 3: Seguridad y Aislamiento de Datos**
  **Descripción:** Un error en el scoping de tenant_id puede causar data leakage entre despachos (catastrófico).
  **Mitigación:** Testing exhaustivo de aislamiento, middleware de tenant verification, auditoría de queries, implementación de políticas de acceso estrictas.

### Riesgos de Negocio:

* **Riesgo 4: Adopción del Mercado**
  **Descripción:** Los despachos legales pueden ser conservadores y resistirse a adoptar nueva tecnología.
  **Mitigación:** Ofrecer trial gratuito de 30 días, demos personalizadas, onboarding asistido, casos de éxito visibles.

* **Riesgo 5: Competencia con Sistemas Genéricos**
  **Descripción:** Despachos pueden optar por usar CRMs genéricos (Monday, Notion, Excel) en vez de pagar por Qadra.
  **Mitigación:** Diferenciación clara como sistema especializado, marketing enfocado en el nicho penal, pricing competitivo, ROI demostrable.

### Riesgos Operacionales:

* **Riesgo 6: Conocimiento Legal Limitado del Equipo**
  **Descripción:** El equipo de desarrollo no son abogados penales, pueden malentender conceptos legales.
  **Mitigación:** Validación constante con abogados penales asesores, investigación profunda del CNPP, documentación legal exhaustiva en `/docs/`.

* **Riesgo 7: Dependencia de Stripe**
  **Descripción:** Stripe puede bloquear la cuenta o cambiar políticas, afectando facturación.
  **Mitigación:** Mantener documentación completa de transacciones, tener plan B con otro proveedor (Conekta para México), diversificar métodos de pago.

---

## Notas Finales

Este manifiesto es la constitución del proyecto Qadra. Cualquier cambio en el alcance, visión o arquitectura debe documentarse aquí y comunicarse a todo el equipo.

**Próximos pasos inmediatos:**
1. Validar este manifiesto con el equipo completo
2. Crear `02-design-system.md` con tokens de diseño y componentes UI
3. Crear `03-database-schema.md` con el modelo completo de entidades y diagrama Mermaid ER
4. Crear `04-user-stories.md` con el backlog completo de funcionalidades
5. Iniciar Sprint 0 con setup del proyecto Laravel 12

**Última actualización:** 18 de noviembre de 2025
**Revisado por:** Equipo Qadra
**Estado:** ✅ Aprobado - Listo para implementación
