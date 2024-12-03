<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\Facades\EmployeeFileUploadFacade;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class EmployeeListFileProcess implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly string  $filePath, public readonly User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        EmployeeFileUploadFacade::readCsvFile($this->filePath, $this->user);
    }
}
