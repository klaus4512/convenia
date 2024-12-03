<?php

namespace App\Services;

use App\Domain\Repositories\EmployeeFileRepository;
use App\Jobs\EmployeeListFileProcess;
use App\Models\Employee;
use App\Models\User;
use App\Notifications\EmployeeFileProcess;
use App\Services\Facades\EmployeeFacade;

class EmployeeFileUploadService
{
    public function __construct(private readonly  EmployeeFileRepository $employeeFileRepository)
    {
    }

    public function save($file): string
    {
        return $this->employeeFileRepository->saveFile($file);
    }

    public function processFileAsync(string $file, User $user): void
    {
        EmployeeListFileProcess::dispatch($file, $user);
    }

    public function readCsvFile(string $file, User $user): void
    {
        $handle = fopen($file, 'rb');
        fgetcsv($handle, null, ',');
        while(false !== ($data = fgetcsv($handle, null, ','))){
            $employee = new Employee();
            $employee->fill([
                'name' => $data[0],
                'email' => $data[1],
                'document_number' => $data[2],
                'city' => $data[3],
                'state' => $data[4],
                'manager_id' => $user->id
            ]);
            try{
                EmployeeFacade::store($employee);
            }catch (\Exception $e){
                echo $e->getMessage();
            }
        }
        fclose($handle);
        $user->notify(new EmployeeFileProcess());
    }
}
