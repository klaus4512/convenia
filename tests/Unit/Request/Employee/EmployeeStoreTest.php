<?php

use App\Http\Requests\Employee\EmployeeStore;
use Illuminate\Support\Facades\Validator;

test('store employee request validation passes', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'document_number' => '426.168.790-93',
        'state' => 'Amazonas',
        'city' => 'Manaus',
    ];

    $request = new EmployeeStore();
    $validator = Validator::make($data, $request->rules());

    expect($validator->passes())->toBeTrue();
});

test('store employee request validation fails', function () {
    $data = [
        'name' => '',
        'email' => 'not-an-email',
        'document_number' => '',
        'state' => '',
        'city' => '',
    ];

    $request = new EmployeeStore();
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
});
