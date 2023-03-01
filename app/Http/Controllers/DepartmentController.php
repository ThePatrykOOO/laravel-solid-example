<?php

namespace App\Http\Controllers;

use App\Enums\ReportType;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Repositories\DepartmentRepository;
use App\Services\Departments\DepartmentReportService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    private DepartmentRepository $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $listOfDepartments = $this->departmentRepository->findAll();
        return DepartmentResource::collection($listOfDepartments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request): DepartmentResource
    {
        $department = $this->departmentRepository->store($request->validated());
        return new DepartmentResource($department);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $departmentId): DepartmentResource
    {
        $department = $this->departmentRepository->findOrFail($departmentId);
        return new DepartmentResource($department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, int $departmentId): JsonResponse
    {
        $this->departmentRepository->update($request->validated(), $departmentId);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $departmentId): JsonResponse
    {
        $this->departmentRepository->delete($departmentId);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function generateReportListOfEmployees(
        int $departmentId,
        string $reportType,
        DepartmentReportService $departmentReportService
    ): JsonResponse {
        $reportType = ReportType::tryFrom($reportType);
        if (!$reportType) {
            return new JsonResponse(['message' => "Report Type not found"], Response::HTTP_BAD_REQUEST);
        }
        $reportData = $departmentReportService->generateReport($departmentId, $reportType);
        return new JsonResponse($reportData, Response::HTTP_CREATED);
    }
}
