<?php

namespace App\Livewire\Documents;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Database\Eloquent\Model;

class DocumentUploader extends Component
{
    use WithFileUploads;

    public $files = [];
    public $category = 'documento_general'; // Default category
    public $description;
    
    public Model $model; // The parent model (Case, Evidence, Hearing)
    public $collection = 'documents'; // Media collection name

    protected $rules = [
        'files.*' => 'required|file|max:10240', // 10MB max
        'category' => 'required|string',
        'description' => 'nullable|string|max:255',
    ];

    public function mount(Model $model, string $collection = 'documents')
    {
        $this->model = $model;
        $this->collection = $collection;
    }

    public function updatedFiles()
    {
        $this->validate();
    }

    public function save()
    {
        $this->validate();

        foreach ($this->files as $file) {
            $this->model->addMedia($file)
                ->withCustomProperties([
                    'category' => $this->category,
                    'description' => $this->description,
                    'uploaded_by' => auth()->id(),
                ])
                ->toMediaCollection($this->collection, 's3'); // Force S3 disk
        }

        // Reset form
        $this->files = [];
        $this->description = '';
        
        // Emit event so parent or other components can refresh
        $this->dispatch('documents-uploaded');
        
        session()->flash('message', 'Documentos subidos exitosamente.');
    }

    public function render()
    {
        return view('livewire.documents.document-uploader');
    }
}