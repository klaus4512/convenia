<?php

namespace App\Domain\Repositories;

use App\Models\Employee;
use App\Models\User;

interface EmployeeRepository
{
    public function find(string $id): ?Employee;

    public function findByDocumentNumberAndManager(string $documentNumber, int $managerId): ?Employee;
    public function store(Employee $employee): Employee;

    public function listEmployersByManagerPaginate(int $managerId, int $page = 1, int $perPage = 15): object;

    public function update(Employee $employee): Employee;

    public function delete(Employee $employee): void;
}
