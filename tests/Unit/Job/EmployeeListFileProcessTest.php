<?php

use App\Jobs\EmployeeListFileProcess;
use App\Models\User;
use App\Services\Facades\EmployeeFileUploadFacade;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('employee list file process job is dispatched', function () {
    Queue::fake();

    $user = User::factory()->create();
    $filePath = 'path/to/employees.csv';

    EmployeeListFileProcess::dispatch($filePath, $user);

    Queue::assertPushed(EmployeeListFileProcess::class, function ($job) use ($filePath, $user) {
        return $job->filePath === $filePath && $job->user->is($user);
    });
});

test('employee list file process job handles correctly', function () {
    $user = User::factory()->create();
    $filePath = 'path/to/employees.csv';

    $job = new EmployeeListFileProcess($filePath, $user);


    EmployeeFileUploadFacade::shouldReceive('readCsvFile')
        ->once()
        ->with($filePath, $user);

    $job->handle();
});
