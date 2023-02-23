<?php

namespace App\Reports\Department;

class SalaryEmployeesReport extends DepartmentReport
{

    public function fetchData(): void
    {
        $this->data = $this->departmentRepository->getSalaryEmployees($this->department);
    }

    public function prepareSummarize(): void
    {
        $this->summary = [
            'count_rows' => $this->data->count(),
            'sum_all_of_salaries' => $this->data->sum('usd_salary'),
            'avg_salary' => $this->data->avg('usd_salary'),
        ];
    }
}
