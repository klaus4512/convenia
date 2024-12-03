<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\EmployeeRepository;
use App\Models\Employee;
use Illuminate\Support\Facades\Cache;

class EmployeeEloquentWithCacheRepository implements EmployeeRepository
{

    private string $cacheTag = 'employee';
    private int $cacheLifetimeSeconds = 60 * 60;

    private function cleanCache(): void
    {
        Cache::tags($this->cacheTag)->flush();
    }

    public function store(Employee $employee): Employee
    {
        $employee->save();
        $this->cleanCache();
        return $employee;
    }

    public function find(string $id): ?Employee
    {
        return Cache::tags($this->cacheTag)->remember($id, $this->cacheLifetimeSeconds, function () use ($id) {
            return Employee::query()->where('id', $id)->first();
        });
    }

    public function findByDocumentNumberAndManager(string $documentNumber, int $managerId): ?Employee
    {
        return Cache::tags($this->cacheTag)->remember( $documentNumber . '_' . $managerId, $this->cacheLifetimeSeconds, function () use ($documentNumber, $managerId) {
            return Employee::query()
                ->where('document_number', $documentNumber)
                ->where('manager_id', $managerId)
                ->first();
        });
    }

    public function listEmployersByManagerPaginate(int $managerId, int $page = 1, int $perPage = 15): object
    {
        return Cache::tags($this->cacheTag)->remember('listEmployersByManagerPaginate_' . $managerId . '_' . $perPage. '_' .$page, $this->cacheLifetimeSeconds, function () use ($managerId, $perPage, $page) {
            return Employee::query()
                ->where('manager_id', $managerId)
                ->paginate($perPage, ['*'], 'page', $page);
        });
    }

    public function update(Employee $employee): Employee
    {
        $employee->save();
        $this->cleanCache();
        return $employee;
    }

    public function delete(Employee $employee): void
    {
        $employee->delete();
        $this->cleanCache();
    }
}
