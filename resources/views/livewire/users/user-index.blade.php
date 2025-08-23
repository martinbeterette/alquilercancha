<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage your all your users') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div>
        <div class="p-3">

            @if (session('success'))
                <div 
                    x-data="{ show: true }" 
                    x-init="setTimeout(() => show = false, 5000)" 
                    x-show="show"
                    x-transition
                    class="inline-flex items-center p-2 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900 dark:text-green-300 dark:border-green-800"
                    role="alert"
                >
                    <svg class="flex-shrink-0 w-8 h-8 mr-1 text-green-700 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- @session('success')
                <div 
                    x-data="{ show: true }" 
                    x-init="setTimeout(() => show = false, 5000)" 
                    x-show="show"
                    class="inline-flex items-center p-2 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900 dark:text-green-300 dark:border-green-800 transition-opacity duration-500"
                    role="alert"
                >
                    <svg class="flex-shrink-0 w-8 h-8 mr-1 text-green-700 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                    </svg>
                    <span class="font-medium">{{ $value }}</span>
                </div>
            @endsession --}}

            <div>
                @can('usuario.create')
                    <a href="{{ route("users.create") }}" class="mb-4 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                        Crear Usuario
                    </a>
                @endcan
            </div>

            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Perfiles</th>
                            <th scope="col" class="px-6 py-3 w-80">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                <td class="px-6 py-2 font-medium text-gray-900">{{ $user->id }}</td>
                                <td class="px-6 py-2 text-gray-700">{{ $user->name }}</td>
                                <td class="px-6 py-2 text-gray-700">{{ $user->email }}</td>
                                <td class="px-6 py-2 text-gray-700">
                                    @if ($user->roles)
                                        @foreach ($user->roles as $role)
                                            <flux:badge class="mt-1">{{ $role->name }}</flux:badge>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="px-6 py-2 space-x-1">
                                    @can('usuario.view')
                                        <a href="{{ route('users.show', $user->id) }}" class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                            Ver
                                        </a>
                                    @endcan

                                    @can('usuario.edit')
                                        <a href="{{ route('users.edit', $user->id) }}" class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                            Editar
                                        </a>
                                    @endcan

                                    @can('usuario.delete')
                                        <button wire:click="delete({{ $user->id }})" wire:confirm="Estas seguro de eliminar este usuario?" class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                                            Eliminar
                                        </button>
                                    @endcan
                                </td>
                            </tr>                 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>