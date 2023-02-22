<?php

namespace App\Repositories;

use App\Interfaces\CrudRepository;
use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DepartmentRepository implements CrudRepository
{
    public function findAll(): Collection
    {
        return Department::all();
    }

    public function findOrFail(int $id): Model
    {
        return Department::query()
            ->findOrFail($id);
    }

    public function store(array $data): Model
    {
        return Department::query()
            ->create($data);
    }

    public function update(array $data, int $id): void
    {
        Department::query()
            ->findOrFail($id)
            ->update($data);
    }

    public function delete(int $id): void
    {
        $this->findOrFail($id)->delete();
    }
}
