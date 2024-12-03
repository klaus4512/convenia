<?php

use App\Models\Employee;
use App\Services\EmployeeService;
use App\Domain\Repositories\EmployeeRepository;

test('store employee successfully', function () {
    $employeeRepository = mock(EmployeeRepository::class)
        ->shouldReceive('findByDocumentNumberAndManager')
        ->with('12345678900', 1)
        ->andReturn(null)
        ->shouldReceive('store')
        ->andReturn(new Employee())
        ->getMock();

    $employeeService = new EmployeeService($employeeRepository);

    $employee = new Employee([
        'document_number' => '123.456.789-00',
    ]);
    $employee->manager_id = 1;

    $result = $employeeService->store($employee);

    expect($result)->toBeInstanceOf(Employee::class);
});

test('store employee throws exception', function () {
    $this->expectException(\LogicException::class);
    $this->expectExceptionMessage('Já existe um colaborador com esse documento cadastrado para esse gestor');

    $employeeRepository = mock(EmployeeRepository::class)
        ->shouldReceive('findByDocumentNumberAndManager')
        ->with('12345678900', 1)
        ->andReturn(new Employee())
        ->getMock();

    $employeeService = new EmployeeService($employeeRepository);

    $employee = new Employee([
        'document_number' => '123.456.789-00',
    ]);
    $employee->manager_id = 1;

    $employeeService->store($employee);
});
