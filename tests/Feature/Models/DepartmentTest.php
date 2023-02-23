<?php

namespace Tests\Feature\Models;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;


    public function testEmployeesRelationship(): void
    {
        $department = Department::factory()->create();

        Employee::factory(2)->create(
            [
                'department_id' => $department->id
            ]
        );

        $this->assertInstanceOf(Employee::class, $department->employees[0]);
        $this->assertInstanceOf(Employee::class, $department->employees[1]);
    }
}
