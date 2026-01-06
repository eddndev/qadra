<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileUpdate extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public ?string $phone = '';
    public ?string $position = '';
    public $avatar;

    public bool $hasChanges = false;
    public string $avatarUrl = '';

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->position = $user->position;
        $this->avatarUrl = $user->getAvatarUrl() ?? '';
    }

    public function updated($propertyName)
    {
        $this->hasChanges = true;

        if ($propertyName === 'avatar') {
            $this->validateOnly('avatar', [
                'avatar' => ['nullable', 'image', 'max:5120', 'mimes:jpg,jpeg,png,webp'],
            ]);
        }
    }

    public function save()
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'position' => ['nullable', 'string', 'max:100'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($this->avatar) {
            $user->addMedia($this->avatar->getRealPath())
                ->usingFileName($this->avatar->getClientOriginalName())
                ->toMediaCollection('avatar', 's3');

            $this->avatar = null;
            $this->avatarUrl = $user->fresh()->getAvatarUrl() ?? '';
        }

        $this->hasChanges = false;

        session()->flash('status', 'profile-updated');

        // Dispatch event for topbar update if needed, 
        // though topbar uses fresh() it might need a trigger or just page refresh
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.profile.profile-update');
    }
}
