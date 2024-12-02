<?php

namespace App\Http\Controllers;

use App\Domain\Repositories\EmployeeRepository;
use App\Http\Requests\EmployeeStore;
use App\Models\Employee;
use App\Services\Facades\EmployeeFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(private readonly EmployeeRepository $employeeRepository)
    {
    }

    //
    public function store(EmployeeStore $request): JsonResponse
    {
        $employee = new Employee();
        $employee->fill($request->validated());
        $employee->manager_id = auth()->user()->id;

        try{
            $employee = EmployeeFacade::store($employee);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Não foi possível cadastrar o colaborador',
                'data' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Colaborador cadastrado com sucesso!',
            'data' => $employee
        ], 201);
    }
}
