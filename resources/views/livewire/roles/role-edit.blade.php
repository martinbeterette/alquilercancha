<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Editar Role') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Formulario para editar Role') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div>
        <a href="{{ route("roles.index") }}" class="mb-4 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
            Volver
        </a>

        <div class="w-150">
            <form wire:submit="submit" class="mt-6 space-y-6">
                <flux:input wire:model="name" label="Perfil" placeholder="Perfil"/>
                <flux:checkbox.group wire:model="permissions" label="Permisos">
                    @foreach ($allpermissions as $permission)
                        <flux:checkbox label="{{ $permission->name }}" value="{{ $permission->name }}" checked />
                    @endforeach
                </flux:checkbox.group>
                <flux:button variant="primary" type="submit" class="cursor-pointer">Guardar</flux:button>
            </form>
        </div>
    </div>
</div>