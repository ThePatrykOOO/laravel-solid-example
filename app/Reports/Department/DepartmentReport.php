<?php

namespace App\Reports\Department;

use App\Models\Department;
use App\Repositories\DepartmentRepository;
use Illuminate\Database\Eloquent\Collection;

abstract class DepartmentReport
{
    protected DepartmentRepository $departmentRepository;
    protected Department $department;

    protected Collection $data;
    protected array $summary;

    public function __construct(Department $department)
    {
        $this->departmentRepository = new DepartmentRepository();
        $this->department = $department;
    }

    final public function generate(): array
    {
        $this->fetchData();
        $this->prepareSummarize();

        return [
            'department' => [
                'id' => $this->department->id,
                'name' => $this->department->name,
            ],
            'rows' => $this->data->toArray(),
            'summary' => $this->summary
        ];
    }

    abstract public function fetchData(): void;

    abstract public function prepareSummarize(): void;


}
