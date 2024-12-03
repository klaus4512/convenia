<?php

namespace App\Services\Facades;

use App\Models\Employee;
use App\Models\User;
use App\Services\EmployeeFileUploadService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string save($file)
 * @method static void processFileAsync(string $file, User $user)
 * @method static void readCsvFile(string $file, User $user)
 */


class EmployeeFileUploadFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EmployeeFileUploadService::class;
    }
}
