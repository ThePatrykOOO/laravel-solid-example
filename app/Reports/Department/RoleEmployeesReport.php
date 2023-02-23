<?php

namespace App\Reports\Department;

class RoleEmployeesReport extends DepartmentReport
{

    public function fetchData(): void
    {
        $this->data = $this->departmentRepository->getRoleEmployees($this->department);
    }

    public function prepareSummarize(): void
    {
        $this->summary = [
            'count_rows' => $this->data->count(),
            'grouped_count' => collect($this->data->groupBy('role')->map->count())->toArray(),
        ];
    }
}
