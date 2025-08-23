<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Crear Usuario') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Formulario Crear Usuairo') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div>
        <a href="{{ route("users.index") }}" class="mb-4 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
            Volver
        </a>

        <div class="w-150">
            <form wire:submit="submit" class="mt-6 space-y-6">
                <flux:input wire:model="usuario" label="Usuario" placeholder="Usuario"/>
                <flux:input wire:model="email" label="Email" type="email" placeholder="Email"/>
                <flux:input wire:model="contrasena" label="Contraseña" type="password" placeholder="Contraseña"/>
                <flux:input wire:model="confirm_contrasena" label="Confirmar Contraseña" type="password" placeholder="Confirmar Contraseña"/>
                <flux:checkbox.group wire:model="roles" label="Perfiles">
                    @foreach ($allRoles as $role)
                        <flux:checkbox label="{{ $role->name }}" value="{{ $role->name }}" />
                    @endforeach
                </flux:checkbox.group>

                <flux:button variant="primary" type="submit" class="cursor-pointer">Guardar</flux:button>
            </form>
        </div>
    </div>
</div>