<?php

use App\Infrastructure\Repositories\EmployeeEloquentWithCacheRepository;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

uses(RefreshDatabase::class);

test('store employee', function () {

    $employee = Employee::factory()->make();

    $repository = new EmployeeEloquentWithCacheRepository();

    $savedEmployee = $repository->store($employee);

    expect($savedEmployee)->toBeInstanceOf(Employee::class)
        ->and($savedEmployee->id)->toBeUuid()
        ->and($savedEmployee->name)->toBe($employee->name)
        ->and($savedEmployee->email)->toBe($employee->email)
        ->and($savedEmployee->document_number)->toBe($employee->document_number)
        ->and($savedEmployee->state)->toBe($employee->state)
        ->and($savedEmployee->city)->toBe($employee->city)
        ->and($savedEmployee->manager_id)->toBe($employee->manager_id);
});

test('find employee', function () {
    $employee = Employee::factory()->create();

    $repository = new EmployeeEloquentWithCacheRepository();

    $foundEmployee = $repository->find($employee->id);

    expect($foundEmployee)->toBeInstanceOf(Employee::class)
        ->and($foundEmployee->id)->toBe($employee->id)
        ->and($foundEmployee->name)->toBe($employee->name)
        ->and($foundEmployee->email)->toBe($employee->email)
        ->and($foundEmployee->document_number)->toBe($employee->document_number)
        ->and($foundEmployee->state)->toBe($employee->state)
        ->and($foundEmployee->city)->toBe($employee->city)
        ->and($foundEmployee->manager_id)->toBe($employee->manager_id);
});

test('find with document number and manager id employee', function () {
    $employee = Employee::factory()->create();

    $repository = new EmployeeEloquentWithCacheRepository();

    $foundEmployee = $repository->findByDocumentNumberAndManager($employee->document_number, $employee->manager_id);

    expect($foundEmployee)->toBeInstanceOf(Employee::class)
        ->and($foundEmployee->id)->toBe($employee->id)
        ->and($foundEmployee->name)->toBe($employee->name)
        ->and($foundEmployee->email)->toBe($employee->email)
        ->and($foundEmployee->document_number)->toBe($employee->document_number)
        ->and($foundEmployee->state)->toBe($employee->state)
        ->and($foundEmployee->city)->toBe($employee->city)
        ->and($foundEmployee->manager_id)->toBe($employee->manager_id);
});

test('list employers by manager paginate test ', function () {

    $manager = User::factory()->create();
    $employees = Employee::factory()->count(20)->create(['manager_id' => $manager->id]);

    $repository = new EmployeeEloquentWithCacheRepository();

    $foundEmployees = $repository->listEmployersByManagerPaginate($manager->id, 1, 10);

    expect($foundEmployees)->toBeInstanceOf(LengthAwarePaginator::class)
        ->and($foundEmployees->total())->toBe(20)
        ->and($foundEmployees->perPage())->toBe(10)
        ->and($foundEmployees->currentPage())->toBe(1)
        ->and($foundEmployees->items())->toHaveCount(10)
        ->and($foundEmployees->items()[0])->toBeInstanceOf(Employee::class);
});

test('update employee', function () {
    $employee = Employee::factory()->create();

    $repository = new EmployeeEloquentWithCacheRepository();

    $employee->name = 'Updated Name';
    $employee->email = 'teste@gmail.com';
    $employee->city = 'São Paulo';
    $employee->state = 'São Paulo';

    $updatedEmployee = $repository->update($employee);

    expect($updatedEmployee)->toBeInstanceOf(Employee::class)
        ->and($updatedEmployee->id)->toBe($employee->id)
        ->and($updatedEmployee->name)->toBe($employee->name)
        ->and($updatedEmployee->email)->toBe($employee->email)
        ->and($updatedEmployee->document_number)->toBe($employee->document_number)
        ->and($updatedEmployee->state)->toBe($employee->state)
        ->and($updatedEmployee->city)->toBe($employee->city)
        ->and($updatedEmployee->manager_id)->toBe($employee->manager_id);
});

test('delete employee', function () {
    $employee = Employee::factory()->create();

    $repository = new EmployeeEloquentWithCacheRepository();

    $repository->delete($employee);

    $foundEmployee = $repository->find($employee->id);

    expect($foundEmployee)->toBeNull();
});
