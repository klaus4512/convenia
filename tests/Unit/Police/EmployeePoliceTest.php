<?php

use App\Models\Employee;
use App\Models\User;
use App\Policies\EmployeePolicy;

test('user can view employee', function () {
    $user = User::factory()->create();
    $employee = Employee::factory()->create(['manager_id' => $user->id]);

    $policy = new EmployeePolicy();

    expect($policy->view($user, $employee))->toBeTrue();
});

test('user cannot view employee', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->create();
    $employee = Employee::factory()->create(['manager_id' => $user2->id]);

    $policy = new EmployeePolicy();

    expect($policy->view($user, $employee))->toBeFalse();
});

test('user can update employee', function () {
    $user = User::factory()->create();
    $employee = Employee::factory()->create(['manager_id' => $user->id]);

    $policy = new EmployeePolicy();

    expect($policy->update($user, $employee))->toBeTrue();
});

test('user cannot update employee', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->create();
    $employee = Employee::factory()->create(['manager_id' => $user2->id]);

    $policy = new EmployeePolicy();

    expect($policy->update($user, $employee))->toBeFalse();
});


test('user can delete employee', function () {
    $user = User::factory()->create();
    $employee = Employee::factory()->create(['manager_id' => $user->id]);

    $policy = new EmployeePolicy();

    expect($policy->delete($user, $employee))->toBeTrue();
});

test('user cannot delete employee', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->create();
    $employee = Employee::factory()->create(['manager_id' => $user2->id]);

    $policy = new EmployeePolicy();

    expect($policy->delete($user, $employee))->toBeFalse();
});
