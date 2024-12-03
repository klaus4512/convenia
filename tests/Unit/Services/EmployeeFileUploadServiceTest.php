<?php

use App\Jobs\EmployeeListFileProcess;
use App\Models\User;
use App\Notifications\EmployeeFileProcess;
use App\Services\EmployeeFileUploadService;
use App\Services\Facades\EmployeeFileUploadFacade;
use App\Domain\Repositories\EmployeeFileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->repository = mock(EmployeeFileRepository::class);
    $this->service = new EmployeeFileUploadService($this->repository);
    Queue::fake();
});

it('saves the file', function () {
    Storage::fake('local');
    $file = UploadedFile::fake()->create('employees.csv', 100, 'text/csv');
    $fileContent = file_get_contents($file);

    $this->repository->shouldReceive('saveFile')
        ->once()
        ->with($fileContent)
        ->andReturn('path/to/employees.csv');

    $filePath = $this->service->save($fileContent);

    expect($filePath)->toBe('path/to/employees.csv');
});

it('start job to processes the file asynchronously', function () {
    $filePath = 'path/to/employees.csv';
    $user = User::factory()->create();

    $this->service->processFileAsync($filePath, $user);

    Queue::assertPushed(EmployeeListFileProcess::class, function ($job) use ($filePath, $user) {
        return $job->filePath === $filePath && $job->user->is($user);
    });
});

