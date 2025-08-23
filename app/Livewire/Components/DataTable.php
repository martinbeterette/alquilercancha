<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class DataTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'asc';
    public int $perPage = 2;

    public string $modelClass;
    public array $columns = [];

    protected $queryString = ['search', 'sortField', 'sortDirection', 'perPage'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        /** @var Builder $query */
        $query = ($this->modelClass)::query();

        if (!empty($this->search)) {
            foreach ($this->columns as $column) {
                $query->orWhere($column['field'], 'like', '%' . $this->search . '%');
            }
        }

        $data = $query
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.components.data-table', [
            'rows' => $data,
        ]);
    }
}
