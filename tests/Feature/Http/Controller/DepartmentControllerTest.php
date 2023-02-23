<?php

namespace Tests\Feature\Http\Controller;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartmentControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testIndex(): void
    {
        Department::factory(5)->create();

        $response = $this->get('/api/departments');

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'address',
                    ]
                ]
            ]
        );

        $this->assertCount(5, $response->json('data'));
    }

    public function testStore(): void
    {
        $body = [
            'name' => "Gold Company",
            'address' => "Golden Street 2040",
        ];

        $response = $this->post('/api/departments/', $body);

        $response->assertStatus(201);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'address',
                ]
            ]
        );

        $this->assertCount(1, Department::all());
    }

    public function testShow(): void
    {
        $department = Department::factory()->create();

        $response = $this->get('/api/departments/'.$department->id);

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    'id',
                    'name',
                    'address',
                ]
            ]
        );

        $this->assertEquals($department->id, $response->json('data.id'));
    }

    public function testUpdate(): void
    {
        $department = Department::factory()->create(
            [
                'name' => "Silver Company",
                'address' => "Silver Street 2000",
            ]
        );

        $body = [
            'name' => "Gold Company",
            'address' => "Golden Street 2040",
        ];

        $response = $this->put('/api/departments/'.$department->id, $body);

        $response->assertStatus(204);

        $department->refresh();

        $this->assertEquals('Gold Company', $department->name);
        $this->assertEquals('Golden Street 2040', $department->address);
    }

    public function testDestroy(): void
    {
        $department = Department::factory()->create();

        $response = $this->delete('/api/departments/'.$department->id);

        $response->assertStatus(204);


        $this->assertCount(0, Department::all());
    }

    public function testDepartmentRepositorySuccess(): void
    {
        $department = Department::factory()->create();


        Employee::factory(2)->create(
            [
                'department_id' => $department->id
            ]
        );

        $type = 'list';

        $response = $this->post("/api/departments/report/{$department->id}/{$type}");

        $response->assertStatus(201);

        $response->assertJsonStructure(
            [
                'department' => [
                    'id',
                    'name',
                ],
                'rows',
                'summary'
            ]
        );


        $this->assertEquals($department->id, $response->json('department.id'));
    }
}
