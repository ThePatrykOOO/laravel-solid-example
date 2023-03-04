<?php

namespace App\Services\Departments;

use App\Enums\ReportType;
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

    public function generateReport(int $departmentId, ReportType $reportType): array
    {
        $department = $this->departmentRepository->findOrFail($departmentId);

        if ($department instanceof Department) {
            $departmentReport = $this->initialize($department, $reportType);

            return $departmentReport->generate();
        }

        return [];
    }

    private function initialize(Department $department, ReportType $reportType): DepartmentReport
    {
        switch ($reportType->value) {
            case 'list':
                return new ListOfEmployeesReport($department);
            case 'salary':
                return new SalaryEmployeesReport($department);
            case 'role':
                return new RoleEmployeesReport($department);
            default:
                throw new \InvalidArgumentException("Report type not found");
        }
    }
}
