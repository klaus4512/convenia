<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;

uses(RefreshDatabase::class);

//it('stores an employee successfully', function () {
//    $user = Passport::actingAs(
//        User::factory()->create()
//    );
//
//    $response = $this->post('/api/employee', [
//        'name' => 'John Doe',
//        'email' => 'john.doe@example.com',
//        'document_number' => '564.693.030-80',
//        'state' => 'São Paulo',
//        'city' => 'São Paulo',
//    ]);
//
//    $response->assertStatus(201);
//    $this->assertDatabaseHas('employees', [
//        'name' => 'John Doe',
//        'email' => 'john.doe@example.com',
//        'document_number' => '56469303080',
//        'state' => 'São Paulo',
//        'city' => 'São Paulo',
//        'manager_id' => $user->id,
//    ]);
//});

//it('fails to store an employee due to validation errors', function () {
//
//    $user = Passport::actingAs(
//        User::factory()->create(),
//        ['*']
//    );
//
//    $response = $this->actingAs($user, 'auth:api')->post('/api/employee', [
//        'name' => '',
//        'email' => 'invalid-email',
//        'document_number' => '',
//        'state' => '',
//        'city' => '',
//    ]);
//
//    $response->assertStatus(422);
//    $response->assertJsonValidationErrors(['name', 'email', 'document_number', 'state', 'city']);
//});
