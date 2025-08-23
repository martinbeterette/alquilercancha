<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Ver Roles') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Datos de role seleccionado') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div>
        <a href="{{ route("roles.index") }}" class="mb-4 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
            Volver
        </a>

        <div class="w-150">
            <p class="mt-2"><strong>Perfil: </strong>{{ $role->name }}</p>
            <p class="mt-2"><strong>Permisos: </strong>
                @if ($role->permissions)
                    @foreach ($role->permissions as $permission)
                        <flux:badge>{{ $permission->name }}</flux:badge>
                    @endforeach
                @endif
            </p>
        </div>
    </div>
</div>