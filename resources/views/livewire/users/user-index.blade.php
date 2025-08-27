<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage your all your users') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <!-- Búsqueda -->
    <div class="flex items-center justify-between mb-3">
        <input 
            type="text" 
            wire:model.live="search"
            placeholder="Buscar usuarios..."
            class="px-3 py-2 border rounded-md w-1/3"
        />

        <!-- Filtro por rol -->
        <select wire:model.live="roleFilter" class="px-2 py-1 border rounded-md text-sm cursor-pointer">
            <option class="cursor-pointer" value="">Todos los roles</option>
            @foreach ($roles as $role)
                <option class="cursor-pointer" value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
            @endforeach
        </select>

        <select wire:model.live="perPage" class="px-2 py-1 border rounded-md text-sm cursor-pointer">
            <option class="cursor-pointer" value="1">1 por página</option>
            <option class="cursor-pointer" value="2">2 por página</option>
            <option class="cursor-pointer" value="3">3 por página</option>
        </select>
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
                            <th class="px-6 py-3 cursor-pointer" wire:click="sortBy('id')">
                                ID 
                                @if($sortField == 'id')
                                    <span>{{ $sortDirection == 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th class="px-6 py-3 cursor-pointer" wire:click="sortBy('name')">
                                Nombre
                                @if($sortField == 'name')
                                    <span>{{ $sortDirection == 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th class="px-6 py-3 cursor-pointer" wire:click="sortBy('email')">
                                Email
                                @if($sortField == 'email')
                                    <span>{{ $sortDirection == 'asc' ? '↑' : '↓' }}</span>
                                @endif
                            </th>
                            <th class="px-6 py-3">Perfiles</th>
                            <th class="px-6 py-3 w-80">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                <td class="px-6 py-2 font-medium text-gray-900">{{ $user->id }}</td>
                                <td class="px-6 py-2">{{ $user->name }}</td>
                                <td class="px-6 py-2">{{ $user->email }}</td>
                                <td class="px-6 py-2">
                                    @foreach ($user->roles as $role)
                                        <flux:badge class="mt-1">{{ $role->name }}</flux:badge>
                                    @endforeach
                                </td>
                                <td class="px-6 py-2 space-x-1">
                                    @can('usuario.view')
                                        <a href="{{ route('users.show', $user->id) }}" class="px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                                            Ver
                                        </a>
                                    @endcan
                                    @can('usuario.edit')
                                        <a href="{{ route('users.edit', $user->id) }}" class="px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                                            Editar
                                        </a>
                                    @endcan
                                    @can('usuario.delete')
                                        <button wire:click="delete({{ $user->id }})" wire:confirm="¿Seguro que deseas eliminar este usuario?" class="px-3 py-2 text-xs font-medium text-white bg-red-700 rounded-lg hover:bg-red-800">
                                            Eliminar
                                        </button>
                                    @endcan
                                </td>
                            </tr>                 
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">No se encontraron usuarios.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-4 cursor-pointer>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>