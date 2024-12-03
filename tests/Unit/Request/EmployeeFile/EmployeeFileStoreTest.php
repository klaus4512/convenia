<?php

use App\Http\Requests\Employee\EmployeeStore;
use App\Http\Requests\EmployeeFileUpload\EmployeeFileUploadStore;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;

test('store employee file request validation passes', function () {
    $data = [
        'file' => UploadedFile::fake()->create('employees.csv', 100, 'text/csv'),
    ];

    $request = new EmployeeFileUploadStore();
    $validator = Validator::make($data, $request->rules());
    expect($validator->passes())->toBeTrue();
});

test('store employee file request validation fails', function () {
    $data = [
        'file' => UploadedFile::fake()->create('employees.txt', 100, 'text/plain'),
    ];

    $request = new EmployeeFileUploadStore();
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
});
