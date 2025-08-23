<div>
    <input type="text" wire:model.debounce.500ms="search" placeholder="Buscar..." class="mb-4 border p-2 w-full">

    <table class="min-w-full border-collapse border">
        <thead>
            <tr class="bg-gray-100">
                @foreach ($columns as $field => $label)
                    <th 
                        class="border p-2 cursor-pointer"
                        wire:click="sortBy('{{ $field }}')"
                    >
                        {{ $label }}
                        @if ($sortField === $field)
                            {{ $sortDirection === 'asc' ? '▲' : '▼' }}
                        @endif
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    @foreach (array_keys($columns) as $field)
                        <td class="border p-2">{{ $item->$field }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $data->links() }}
    </div>
</div>
