<?php

use App\Http\Requests\Employee\EmployeeUpdate;
use Illuminate\Support\Facades\Validator;

test('update employee request validation passes', function () {
    $data = [
        'name' => 'Jane Doe',
        'email' => 'jane.doe@example.com',
        'document_number' => '123.456.789-00',
        'state' => 'São Paulo',
        'city' => 'São Paulo',
    ];

    $request = new EmployeeUpdate();
    $validator = Validator::make($data, $request->rules());

    expect($validator->passes())->toBeTrue();
});

test('update employee request validation fails', function () {
    $data = [
        'name' => '',
        'email' => 'invalid-email',
        'document_number' => '',
        'state' => '',
        'city' => '',
    ];

    $request = new EmployeeUpdate();
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
});
