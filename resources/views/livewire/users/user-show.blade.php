<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Ver Usuario') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Datos de usuario seleccionado') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div>
        <a href="{{ route("users.index") }}" class="mb-4 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
            Volver
        </a>

        <div class="w-150">
            <p class="mt-2"><strong>Usuario: </strong>{{ $user->name }}</p>
            <p class="mt-2"><strong>Email: </strong>{{ $user->email }}</p>
            <p class="mt-2"><strong>Creacion: </strong>{{ $user->created_at }}</p>
            <p class="mt-2"><strong>Verificacion: </strong>{{ $user->email_verified_at }}</p>
        </div>
    </div>
</div>