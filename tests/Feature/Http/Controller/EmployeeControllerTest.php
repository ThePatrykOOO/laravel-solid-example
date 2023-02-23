<?php

namespace Tests\Feature\Http\Controller;

use App\Enums\EmployeePositions;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testIndex(): void
    {
        Employee::factory(5)->create(
            [
                'department_id' => Department::factory()->create()->id
            ]
        );

        $response = $this->get('/api/employees');

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'first_name',
                        'last_name',
                        'department_id',
                        'role',
                        'usd_salary',
                    ]
                ]
            ]
        );

        $this->assertCount(5, $response->json('data'));
    }

    public function testStore(): void
    {
        $department = Department::factory()->create();
        $body = [
            'first_name' => "John",
            'last_name' => "Doe",
            'department_id' => $department->id,
            'role' => EmployeePositions::DEVELOPER->value,
            'usd_salary' => 5000,
        ];

        $response = $this->post('/api/employees/', $body);

        $response->assertStatus(201);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'department_id',
                    'role',
                    'usd_salary',
                ]
            ]
        );

        $this->assertCount(1, Employee::all());
    }

    public function testShow(): void
    {
        $employee = Employee::factory()->create(
            [
                'department_id' => Department::factory()->create()->id
            ]
        );

        $response = $this->get('/api/employees/'.$employee->id);

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'department_id',
                    'role',
                    'usd_salary',
                ]
            ]
        );

        $this->assertEquals($employee->id, $response->json('data.id'));
    }

    public function testUpdate(): void
    {
        $department = Department::factory()->create();

        $employee = Employee::factory()->create(
            [
                'department_id' => $department->id
            ]
        );

        $body = [
            'first_name' => "John",
            'last_name' => "Doe",
            'department_id' => $department->id,
            'role' => EmployeePositions::DEVELOPER->value,
            'usd_salary' => 5000,
        ];

        $response = $this->put('/api/employees/'.$employee->id, $body);

        $response->assertStatus(204);

        $employee->refresh();

        $this->assertEquals('John', $employee->first_name);
        $this->assertEquals('Doe', $employee->last_name);
        $this->assertEquals($department->id, $employee->department_id);
        $this->assertEquals(EmployeePositions::DEVELOPER->value, $employee->role);
        $this->assertEquals(5000, $employee->usd_salary);
    }

    public function testDestroy(): void
    {
        $department = Department::factory()->create();

        $employee = Employee::factory()->create(
            [
                'department_id' => $department->id
            ]
        );

        $response = $this->delete('/api/employees/'.$employee->id);

        $response->assertStatus(204);


        $this->assertCount(0, Employee::all());
    }
}
