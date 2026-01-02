<x-app-layout>
    <x-slot name="header">
        {{ __('Gestión del Equipo') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Invite Form & Pending Invitations -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <livewire:team.invite-team-member-form />
                </div>
                <div>
                    <livewire:team.pending-invitations />
                </div>
            </div>

            <!-- Team List -->
            <div>
                <livewire:team.team-management />
            </div>

        </div>
    </div>
</x-app-layout>