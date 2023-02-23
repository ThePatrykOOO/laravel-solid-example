<?php

namespace App\Repositories;

use App\Interfaces\CrudRepositoryInterface;
use App\Interfaces\DepartmentReportRepositoryInterface;
use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DepartmentRepository implements CrudRepositoryInterface, DepartmentReportRepositoryInterface
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

    public function getListEmployees(Department $department): Collection
    {
        return $department
            ->employees()
            ->select('id', 'first_name', 'last_name')
            ->get();
    }

    public function getSalaryEmployees(Department $department): Collection
    {
        return $department
            ->employees()
            ->select('id', 'first_name', 'last_name', 'usd_salary')
            ->get();
    }

    public function getRoleEmployees(Department $department): Collection
    {
        return $department
            ->employees()
            ->select('id', 'first_name', 'last_name', 'role')
            ->get();
    }
}
