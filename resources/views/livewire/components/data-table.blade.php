<div>
    <input type="text" wire:model.debounce.500ms="search" placeholder="Buscar..." class="input input-bordered mb-4" />

    <table class="table w-full">
        <thead>
            <tr>
                @foreach ($columns as $col)
                    <th wire:click="sortBy('{{ $col['field'] }}')" class="cursor-pointer">
                        {{ $col['label'] }}
                        @if ($sortField === $col['field'])
                            @if ($sortDirection === 'asc') ▲ @else ▼ @endif
                        @endif
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    @foreach ($columns as $col)
                        <td>{{ data_get($row, $col['field']) }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $rows->links() }}
    </div>
</div>
