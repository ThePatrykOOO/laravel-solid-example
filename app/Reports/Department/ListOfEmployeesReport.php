<?php

namespace App\Reports\Department;

class ListOfEmployeesReport extends DepartmentReport
{

    public function fetchData(): void
    {
        $this->data = $this->departmentRepository->getListEmployees($this->department);
    }

    public function prepareSummarize(): void
    {
        $this->summary = [
            'count_rows' => $this->data->count()
        ];
    }
}
