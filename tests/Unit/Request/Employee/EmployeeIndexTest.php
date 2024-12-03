<?php

use App\Http\Requests\Employee\EmployeeIndex;
use Illuminate\Support\Facades\Validator;

test('employee index request validation passes', function () {
    $data = [
        'page' => 1,
    ];

    $request = new EmployeeIndex();
    $validator = Validator::make($data, $request->rules());

    expect($validator->passes())->toBeTrue();
});

test('employee index request validation fails', function () {
    $data = [
        'page' => 'teste',
    ];

    $request = new EmployeeIndex();
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
});
