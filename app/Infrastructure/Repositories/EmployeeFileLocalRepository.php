<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\EmployeeFileRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeFileLocalRepository implements EmployeeFileRepository
{

    public function saveFile($file): string
    {
        $path = 'employee_files/'.Str::random(40).'.csv';
        Storage::disk('local')->put($path, $file);
        return Storage::disk('local')->path($path);
    }
}
