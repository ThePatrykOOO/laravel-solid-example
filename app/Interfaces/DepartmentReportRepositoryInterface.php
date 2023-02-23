<?php

namespace App\Interfaces;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

interface DepartmentReportRepositoryInterface
{
    public function getListEmployees(Department $department): Collection;

    public function getSalaryEmployees(Department $department): Collection;

    public function getRoleEmployees(Department $department): Collection;
}
