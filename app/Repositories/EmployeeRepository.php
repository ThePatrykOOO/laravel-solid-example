<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EmployeeRepository implements CrudRepositoryInterface
{
    public function findAll(): Collection
    {
        return Employee::all();
    }

    public function findOrFail(int $id): Model
    {
        return Employee::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return Employee::query()
            ->create($data);
    }

    public function update(array $data, int $id): void
    {
        Employee::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }
}
