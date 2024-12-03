<?php

use App\Models\Employee;
use App\Models\User;

test('employee can be created', function () {
    $employee = Employee::factory()->create();

    expect($employee)->toBeInstanceOf(Employee::class)
        ->and($employee->id)->not->toBeNull()
        ->and($employee->name)->not->toBeNull()
        ->and($employee->email)->not->toBeNull()
        ->and($employee->document_number)->not->toBeNull()
        ->and($employee->state)->not->toBeNull()
        ->and($employee->city)->not->toBeNull()
        ->and($employee->manager_id)->not->toBeNull();
});

test('employee has a manager', function () {
    $manager = User::factory()->create();
    $employee = Employee::factory()->create(['manager_id' => $manager->id]);

    expect($employee->manager)->toBeInstanceOf(User::class)
        ->and($employee->manager->id)->toBe($manager->id);
});
