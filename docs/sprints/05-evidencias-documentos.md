# Diario del Sprint 5: Evidencias y Documentos

**Periodo:** [Fecha de Inicio] - [Fecha de Fin]

**Épica Maestra en GitHub:** [Pendiente de Creación]

**Estado:** ⏳ PENDIENTE

---

## 1. Objetivo del Sprint

Convertir Qadra en un repositorio digital seguro, implementando la gestión de archivos en la nube (AWS S3) y la trazabilidad legal de evidencias físicas mediante cadena de custodia. Al finalizar este sprint, los usuarios podrán subir documentos y gestionar evidencias con integridad probatoria.

## 2. Alcance y Tareas Incluidas

### User Stories Incluidas

- [ ] `[US-16] Registro de Evidencia Material/Digital`
- [ ] `[US-17] Registro de Movimiento de Cadena de Custodia`
- [ ] `[US-18] Listado y Búsqueda de Evidencias`
- [ ] `[US-19] Carga y Clasificación de Documentos`
- [ ] `[US-20] Visualización y Descarga de Documentos`
- [ ] `[US-21] Asociación de Documentos a Entidades Específicas`

### Entregables Técnicos

#### Migraciones (Database)
- [ ] `create_evidence_table` - Registro de objetos físicos/digitales
- [ ] `create_chain_of_custody_entries_table` - Historial inmutable de movimientos
- [ ] `create_documents_table` - Metadatos de archivos (polimórfico)
- [ ] `add_tenant_id_to_media_table` - **CRÍTICO:** Parche de seguridad para `spatie/laravel-medialibrary`

#### Modelos (Eloquent)
- [ ] `Evidence` - Objeto de prueba (con `HasTenants`, `SoftDeletes`)
- [ ] `ChainOfCustodyEntry` - Movimiento de custodia (inmutable)
- [ ] `Document` - Archivo digital (polimórfico, con `HasTenants`)

#### Integraciones Cloud
- [ ] Configuración de AWS S3 Bucket (Políticas IAM, CORS)
- [ ] Configuración de `config/filesystems.php` con driver `s3`
- [ ] Implementación de Signed URLs para descarga segura

#### Componentes Livewire
- [ ] `EvidenceForm` - Alta de evidencias
- [ ] `CustodyMovementForm` - Registro de traspasos
- [ ] `EvidenceTable` - Listado y filtrado
- [ ] `DocumentUploader` - Carga de archivos (FilePond/Dropzone)
- [ ] `DocumentViewer` - Previsualización (PDF.js)

#### Vistas Blade
- [ ] `evidence/index.blade.php`
- [ ] `evidence/show.blade.php` - Detalle con timeline de custodia
- [ ] `components/document-list.blade.php` - Reutilizable en Casos/Audiencias

#### Tests
- [ ] **Unit Tests:** `EvidenceTest`, `ChainOfCustodyTest`, `DocumentTest`
- [ ] **Feature Tests:** Flujos de carga, permisos de visualización, validación de cadena de custodia
- [ ] **Integration Tests:** Conexión S3 (mocked), Polimorfismo

---

## 3. Registro de Decisiones Técnicas

*Esta sección es un log vivo. Se actualiza durante el sprint.*

*   **Uso de `spatie/laravel-medialibrary`:** Se evaluará si continuar con este paquete aplicando el parche de `tenant_id` o migrar a una implementación custom `documents` como definía la arquitectura original. *Decisión pendiente de validación en implementación.*

---

## 4. Registro de Bloqueos y Soluciones

*Esta sección documenta problemas y soluciones.*

---

## 5. Dependencias

- ✅ Sprint 4 completado
- 🔑 Credenciales AWS (Access Key, Secret Key, Bucket Name, Region)

---

## 6. Asignación de Tareas por Área

| Área | Responsable | GitHub | Tareas |
|------|-------------|--------|--------|
| **Backend** | Gael, Eduardo | @Arzubide, @eddndev | Migraciones, Modelos, S3 Integration |
| **Frontend** | Karla | @Karlaelenaht | Componentes Livewire, Uploaders |
| **UX/UI** | Hatziry | @vhhatziry | Diseño de timeline de custodia, preview de docs |
| **Testing** | Diego | @Dvan88 | Tests de carga y seguridad de archivos |
| **CI/CD** | Eduardo | @eddndev | Variables de entorno S3 en producción |

---

## 7. Criterios de Aceptación del Sprint

- [ ] Usuario puede registrar evidencias con folio único
- [ ] Se genera automáticamente el primer registro de cadena de custodia al crear evidencia
- [ ] Usuario puede registrar movimientos de custodia (inmutables)
- [ ] Usuario puede subir archivos a S3 vinculados a un Caso
- [ ] Usuario puede visualizar documentos sin hacerlos públicos (Signed URLs)
- [ ] Documentos pueden asociarse a Audiencias específicas
- [ ] Tests pasan con cobertura > 80%

---

**Sprint planificado por:** Eduardo (Tech Lead)
**Fecha de planificación:** 2025-12-03
