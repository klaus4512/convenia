<?php

namespace App\Domain\Repositories;

use App\Models\Employee;

interface EmployeeRepository
{
    public function find(string $id): ?Employee;

    public function findByDocumentNumberAndManager(string $documentNumber, int $managerId): ?Employee;
    public function store(Employee $employee): Employee;
}
