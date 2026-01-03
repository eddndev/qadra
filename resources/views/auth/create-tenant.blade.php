    <x-slot name="header">
        Crear Nuevo Despacho
    </x-slot>
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6">
                        <p class="text-sm text-gray-600">
                            Estás creando un nuevo espacio de trabajo asociado a tu cuenta
                            <strong>{{ Auth::user()->email }}</strong>.
                            Serás el administrador (Owner) de este nuevo despacho.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('tenant.store') }}">
                        @csrf

                        <!-- Company Name -->
                        <div>
                            <x-input-label for="company_name" :value="__('Nombre del Despacho')" />
                            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name"
                                :value="old('company_name')" required autofocus />
                            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                        </div>

                        <!-- RFC -->
                        <div class="mt-4">
                            <x-input-label for="tax_id" :value="__('RFC del Despacho')" />
                            <x-text-input id="tax_id" class="block mt-1 w-full uppercase" type="text" name="tax_id"
                                :value="old('tax_id')" required placeholder="XAXX010101000" />
                            <x-input-error :messages="$errors->get('tax_id')" class="mt-2" />
                        </div>

                        <!-- Plan Selection -->
                        <div class="mt-4">
                            <x-input-label for="plan_id" :value="__('Plan')" />
                            <select id="plan_id" name="plan_id"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                        {{ $plan->name }} - ${{ number_format($plan->price_monthly / 100, 2) }}/mes
                                        ({{ $plan->max_users }} usuarios)
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('plan_id')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Cancelar
                            </a>

                            <x-primary-button>
                                {{ __('Registrar Despacho') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>