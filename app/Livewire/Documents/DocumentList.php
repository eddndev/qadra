<?php

namespace App\Livewire\Documents;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use App\Models\Media;

class DocumentList extends Component
{
    public Model $model;
    public $collection = 'documents';

    protected $listeners = ['documents-uploaded' => '$refresh'];

    public function mount(Model $model, string $collection = 'documents')
    {
        $this->model = $model;
        $this->collection = $collection;
    }

    public function download(string $mediaId)
    {
        $media = Media::findOrFail($mediaId);
        
        // Verify Tenant Access (Security Check)
        // The TenantScoped trait on Media model handles this implicitly for finding,
        // but explicit check is good practice before generating URL.
        if ($media->tenant_id !== session('current_tenant_id')) {
            abort(403);
        }

        // Generate Temporary URL (5 minutes)
        // This works seamlessly with S3 driver
        return redirect($media->getTemporaryUrl(now()->addMinutes(5)));
    }

    public function delete(string $mediaId)
    {
        $media = Media::findOrFail($mediaId);
        
        if ($media->tenant_id !== session('current_tenant_id')) {
            abort(403);
        }

        $media->delete(); // Spatie Media Library handles file deletion from S3
        
        session()->flash('message', 'Documento eliminado.');
    }

    public function render()
    {
        // Get media from specific collection
        $documents = $this->model->getMedia($this->collection);

        return view('livewire.documents.document-list', [
            'documents' => $documents
        ]);
    }
}