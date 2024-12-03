<?php

namespace App\Http\Controllers;

use App\Domain\Repositories\EmployeeRepository;
use App\Http\Requests\Employee\EmployeeIndex;
use App\Http\Requests\Employee\EmployeeStore;
use App\Http\Requests\Employee\EmployeeUpdate;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\Facades\EmployeeFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(private readonly EmployeeRepository $employeeRepository)
    {
    }

    public function index(EmployeeIndex $request): JsonResponse
    {
        $employees = $this->employeeRepository->listEmployersByManagerPaginate($request->user()->id, $request->input('page', 1));

        return response()
            ->json(
                EmployeeResource::collection($employees)->resource,
                200
            );
    }

    public function store(EmployeeStore $request): JsonResponse
    {
        $employee = new Employee();
        $employee->fill($request->validated());
        $employee->manager_id = auth()->user()->id;

        try{
            $employee = EmployeeFacade::store($employee);
        } catch (\LogicException $e) {
            return response()->json([
                'message' =>  $e->getMessage()
                ], 500);
        }
        return response()->json(EmployeeResource::make($employee), 201);
    }

    public function update(Employee $employee, EmployeeUpdate $request): JsonResponse
    {
        if($request->user()->cannot('update', $employee)){
            return response()->json([
                'message' => 'Você não tem permissão para alterar este colaborador'
            ], 403);
        }

        $employee->fill($request->validated());
        $employee = $this->employeeRepository->update($employee);
        return response()->json(EmployeeResource::make($employee), 200);
    }

    public function destroy(Employee $employee, Request $request): JsonResponse
    {
        if ($request->user()->cannot('delete', $employee)) {
            return response()
                ->json([
                    'message' => 'Você não tem permissão para excluir este colaborador'
                ], 403);
        }

        $this->employeeRepository->delete($employee);
        return response()->json([
            'message' => 'Colaborador removido com sucesso!'
            ], 200);
    }
}
