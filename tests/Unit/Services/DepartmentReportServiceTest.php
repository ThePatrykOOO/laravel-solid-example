<?php

namespace Tests\Unit\Services;

use App\Models\Department;
use App\Models\Employee;
use App\Repositories\DepartmentRepository;
use App\Services\Departments\DepartmentReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartmentReportServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testGenerateReportListOfEmployees(): void
    {
        $department = Department::factory()->create(
            [
                'name' => "NYC Department 2"
            ]
        );

        Employee::factory()->create(
            [
                'first_name' => "Mark",
                'last_name' => "Schmidt",
                'department_id' => $department->id,
                'role' => 'tester',
                'usd_salary' => 3000,
            ]
        );

        Employee::factory()->create(
            [
                'first_name' => "Jeff",
                'last_name' => "Doe",
                'department_id' => $department->id,
                'role' => 'developer',
                'usd_salary' => 8000,
            ]
        );

        $departmentReportService = new DepartmentReportService(new  DepartmentRepository());
        $reportData = $departmentReportService->generateReport($department->id, "list");

        $expectedResult = [
            'department' => [
                "id" => 1,
                "name" => "NYC Department 2",
            ],
            'rows' => [
                [
                    "id" => 1,
                    "first_name" => "Mark",
                    "last_name" => "Schmidt",
                ],
                [
                    "id" => 2,
                    "first_name" => "Jeff",
                    "last_name" => "Doe",
                ]
            ],
            'summary' => [
                "count_rows" => 2
            ]
        ];

        $this->assertEquals($expectedResult, $reportData);
    }

    public function testGenerateReportSalaryOfEmployees(): void
    {
        $department = Department::factory()->create(
            [
                'name' => "NYC Department 2"
            ]
        );

        Employee::factory()->create(
            [
                'first_name' => "Mark",
                'last_name' => "Schmidt",
                'department_id' => $department->id,
                'role' => 'tester',
                'usd_salary' => 3000,
            ]
        );

        Employee::factory()->create(
            [
                'first_name' => "Jeff",
                'last_name' => "Doe",
                'department_id' => $department->id,
                'role' => 'developer',
                'usd_salary' => 8000,
            ]
        );

        $departmentReportService = new DepartmentReportService(new  DepartmentRepository());
        $reportData = $departmentReportService->generateReport($department->id, "salary");

        $expectedResult = [
            'department' => [
                "id" => 1,
                "name" => "NYC Department 2",
            ],
            'rows' => [
                [
                    'id' => 1,
                    'first_name' => 'Mark',
                    'last_name' => 'Schmidt',
                    'usd_salary' => 3000,
                ],
                [
                    'id' => 2,
                    'first_name' => 'Jeff',
                    'last_name' => 'Doe',
                    'usd_salary' => 8000,
                ],
            ],
            'summary' => [
                'count_rows' => 2,
                'sum_all_of_salaries' => 11000,
                'avg_salary' => 5500,
            ]
        ];

        $this->assertEquals($expectedResult, $reportData);
    }

    public function testGenerateReportTypeOfEmployees(): void
    {
        $department = Department::factory()->create(
            [
                'name' => "NYC Department 2"
            ]
        );

        Employee::factory()->create(
            [
                'first_name' => "Mark",
                'last_name' => "Schmidt",
                'department_id' => $department->id,
                'role' => 'tester',
                'usd_salary' => 3000,
            ]
        );

        Employee::factory()->create(
            [
                'first_name' => "Jeff",
                'last_name' => "Doe",
                'department_id' => $department->id,
                'role' => 'developer',
                'usd_salary' => 8000,
            ]
        );

        Employee::factory()->create(
            [
                'first_name' => "Patrick",
                'last_name' => "Filipiak",
                'department_id' => $department->id,
                'role' => 'developer',
                'usd_salary' => 8000,
            ]
        );

        $departmentReportService = new DepartmentReportService(new  DepartmentRepository());
        $reportData = $departmentReportService->generateReport($department->id, "role");

        $expectedResult = [
            'department' => [
                "id" => 1,
                "name" => "NYC Department 2",
            ],
            'rows' => [
                [
                    'id' => 1,
                    'first_name' => 'Mark',
                    'last_name' => 'Schmidt',
                    'role' => 'tester'
                ],
                [
                    'id' => 2,
                    'first_name' => 'Jeff',
                    'last_name' => 'Doe',
                    'role' => 'developer'
                ],
                [
                    'id' => 3,
                    'first_name' => "Patrick",
                    'last_name' => "Filipiak",
                    'role' => 'developer'
                ],
            ],
            'summary' => [
                'count_rows' => 3,
                'grouped_count' => [
                    "tester" => 1,
                    "developer" => 2,
                ]
            ]
        ];

        $this->assertEquals($expectedResult, $reportData);
    }

    public function testGenerateReportTypeNotExists(): void
    {
        $department = Department::factory()->create(
            [
                'name' => "NYC Department 2"
            ]
        );

        $departmentReportService = new DepartmentReportService(new  DepartmentRepository());

        $this->expectExceptionMessage("Report type not found");

        $reportData = $departmentReportService->generateReport($department->id, "blabla");
    }
}
