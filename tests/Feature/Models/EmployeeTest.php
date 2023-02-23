<?php

namespace Tests\Feature\Models;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;


    public function testDepartmentRelationship(): void
    {
        $department = Department::factory()->create();
        $employee = Employee::factory()->create(
            [
                'department_id' => $department->id
            ]
        );

        $this->assertInstanceOf(Department::class, $employee->department);
    }
}
