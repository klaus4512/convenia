<?php

namespace App\Services;

use App\Domain\Repositories\EmployeeRepository;
use App\Models\Employee;
use Illuminate\Support\Facades\Cache;

class EmployeeService
{
    public function __construct(private readonly EmployeeRepository $employeeRepository)
    {
    }


    /**
     * Não tinha descrito no desafio se existia alguma regra para cadastro duplicados de pessoas no sistema
     * Em virtude disso, foi criada uma regra para não permitir que um colaborador seja cadastrado com o mesmo documento para o mesmo gestor
     * Mas a regra pode ser alterada aqui caso seja necessário
     */
    public function store(Employee $employee): Employee
    {
        $employeeExists = $this->employeeRepository->findByDocumentNumberAndManager($employee->document_number, $employee->manager_id);
        if ($employeeExists) {
            throw new \LogicException('Já existe um colaborador com esse documento cadastrado para esse gestor');
        }
        return $this->employeeRepository->store($employee);
    }
}
