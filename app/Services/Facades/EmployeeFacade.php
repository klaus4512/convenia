<?php

namespace App\Services\Facades;

use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Employee store(Employee $employee)
 */


class EmployeeFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EmployeeService::class;
    }
}
