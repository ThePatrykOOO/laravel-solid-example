<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    private EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $listOfEmployees = $this->employeeRepository->findAll();
        return EmployeeResource::collection($listOfEmployees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request): EmployeeResource
    {
        $employee = $this->employeeRepository->store((array)$request->validated());
        return new EmployeeResource($employee);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $employeeId): EmployeeResource
    {
        $employee = $this->employeeRepository->findOrFail($employeeId);
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, int $employeeId): JsonResponse
    {
        $this->employeeRepository->update((array)$request->validated(), $employeeId);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $employeeId): JsonResponse
    {
        $this->employeeRepository->delete($employeeId);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
