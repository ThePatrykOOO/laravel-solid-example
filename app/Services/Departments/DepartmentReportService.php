<?php

namespace App\Services\Departments;

use App\Models\Department;
use App\Reports\Department\DepartmentReport;
use App\Reports\Department\ListOfEmployeesReport;
use App\Reports\Department\RoleEmployeesReport;
use App\Reports\Department\SalaryEmployeesReport;
use App\Repositories\DepartmentRepository;

class DepartmentReportService
{
    private DepartmentRepository $departmentRepository;

    public function __construct()
    {
        $this->departmentRepository = new DepartmentRepository();
    }

    public function generateReport(int $departmentId, string $reportType): array
    {
        $department = $this->departmentRepository->findOrFail($departmentId);

        $departmentReport = $this->initialize($department, $reportType);

        return $departmentReport->generate();
    }

    private function initialize(Department $department, string $reportType): DepartmentReport
    {
        return match ($reportType) {
            'list' => new ListOfEmployeesReport($department),
            'salary' => new SalaryEmployeesReport($department),
            'role' => new RoleEmployeesReport($department),
            default => throw new \InvalidArgumentException("Report type not found"),
        };
    }
}
