<div class="p-6 bg-white shadow sm:rounded-lg">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Miembros del Equipo</h3>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unido
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $user->name }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($currentUserRole === 'owner' && $user->id !== Auth::id())
                                <select wire:change="updateRole('{{ $user->id }}', $event.target.value)"
                                    class="block w-full pl-3 pr-10 py-1 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="owner" {{ $user->pivot->role === 'owner' ? 'selected' : '' }}>Owner</option>
                                    <option value="litigante" {{ $user->pivot->role === 'litigante' ? 'selected' : '' }}>Litigante
                                    </option>
                                    <option value="asociado" {{ $user->pivot->role === 'asociado' ? 'selected' : '' }}>Asociado
                                    </option>
                                    <option value="paralegal" {{ $user->pivot->role === 'paralegal' ? 'selected' : '' }}>Paralegal
                                    </option>
                                    <option value="administrativo" {{ $user->pivot->role === 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                                </select>
                            @else
                                <span class="capitalize">{{ $user->pivot->role }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($user->pivot->joined_at)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($currentUserRole === 'owner' && $user->id !== Auth::id())
                                <button wire:click="confirmUserRemoval('{{ $user->id }}')"
                                    class="text-red-600 hover:text-red-900">
                                    Eliminar
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <!-- Confirmation Modal (Simple) -->
    @if($confirmingUserRemoval)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-50 p-4 md:inset-0 h-modal md:h-full">
            <div class="relative w-full max-w-md h-full md:h-auto">
                <div class="relative bg-white rounded-lg shadow">
                    <div class="p-6 text-center">
                        <h3 class="mb-5 text-lg font-normal text-gray-500">¿Estás seguro de eliminar a este usuario del
                            despacho?</h3>
                        <button wire:click="removeUser" type="button"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Sí, eliminar
                        </button>
                        <button wire:click="$set('confirmingUserRemoval', false)" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>