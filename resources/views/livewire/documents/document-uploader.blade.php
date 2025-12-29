<div class="p-4 bg-white rounded-lg shadow-sm border border-gray-200">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Adjuntar Documentos</h3>

    @if (session()->has('message'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded text-sm">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                <select wire:model="category"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="documento_general">Documento General</option>
                    <option value="evidencia_digital">Evidencia Digital</option>
                    <option value="sentencia">Sentencia / Resolución</option>
                    <option value="oficio">Oficio / Notificación</option>
                    <option value="acta_audiencia">Acta de Audiencia</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción (Opcional)</label>
                <input type="text" wire:model="description"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Breve descripción del contenido">
            </div>
        </div>

        <!-- FilePond Widget -->
        <div wire:ignore x-data x-init="
                FilePond.registerPlugin(FilePondPluginImagePreview);
                FilePond.registerPlugin(FilePondPluginFileValidateSize);
                
                const pond = FilePond.create($refs.input, {
                    allowMultiple: true,
                    credits: false,
                    maxFileSize: '10MB',
                    server: {
                        process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                            @this.upload('files', file, load, error, progress)
                        },
                        revert: (filename, load) => {
                            @this.removeUpload('files', filename, load)
                        },
                    },
                });
                
                $watch('$wire.files', value => {
                    // Reset pond when files are processed/cleared from PHP side
                    if (value.length === 0) {
                        // pond.removeFiles(); // Optional: Auto clear if PHP clears
                    }
                });
            ">
            <input type="file" x-ref="input" multiple>
        </div>

        <div class="mt-4 flex justify-end">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow-sm disabled:opacity-50"
                wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="save">Subir Archivos</span>
                <span wire:loading wire:target="save">Procesando...</span>
            </button>
        </div>
    </form>
</div>