<?php

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create(['password' => Hash::make('password')]);

    // Cria um cliente OAuth
    $client = Client::factory()->create([
        'user_id' =>  $this->user->id,
        'redirect' => 'http://localhost',
        'personal_access_client' => false,
        'password_client' => true,
        'revoked' => false,
    ]);

    $tokenResponse = $this->post('/oauth/token', [
        'grant_type' => 'password',
        'client_id' => $client->id,
        'client_secret' => $client->secret,
        'username' =>  $this->user->email,
        'password' => 'password',
    ]);

    $this->token = json_decode($tokenResponse->getContent(), false, 512, JSON_THROW_ON_ERROR)->access_token;
});

it('fails to store an employee due to validation errors', function () {
    $response = $this->post('/api/employee', [
        'name' => '',
        'email' => 'invalid-email',
        'document_number' => '',
        'state' => '',
        'city' => '',
    ], [
        'Authorization' => 'Bearer ' . $this->token,
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name', 'email', 'document_number', 'state', 'city']);
});

it('stores an employee successfully', function () {
    $response = $this->post('/api/employee', [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'document_number' => '445.753.290-88',
        'state' => 'SP',
        'city' => 'São Paulo',
    ], [
        'Authorization' => 'Bearer ' . $this->token,
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(201);
    $response->assertJson([
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'document_number' => '44575329088',
        'state' => 'SP',
        'city' => 'São Paulo',
        'manager_id' => $this->user->id,
    ]);
});

it('retrieves a list of employees', function () {
    $employees = Employee::factory()->count(3)->create(['manager_id' => $this->user->id]);

    $response = $this->get('/api/employee', [
        'Authorization' => 'Bearer ' . $this->token,
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(200);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonFragment(['id' => $employees[0]->id]);
    $response->assertJsonFragment(['id' => $employees[1]->id]);
    $response->assertJsonFragment(['id' => $employees[2]->id]);
});

it('updates an employee successfully', function () {

    $employee = Employee::factory()->create(['manager_id' => $this->user->id]);

    $updatedData = [
        'name' => 'Jane Doe',
        'email' => 'jane.doe@example.com',
        'state' => 'RJ',
        'city' => 'Rio de Janeiro',
    ];

    $response = $this->put("/api/employee/{$employee->id}", $updatedData, [
        'Authorization' => 'Bearer ' . $this->token,
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(200);
    $response->assertJsonFragment($updatedData);
});

it('fails to update an employee due to validation errors', function () {
    $employee = Employee::factory()->create(['manager_id' => $this->user->id]);

    $invalidData = [
        'name' => '',
        'email' => 'invalid-email',
        'document_number' => '',
        'state' => '',
        'city' => '',
    ];

    $response = $this->put("/api/employee/{$employee->id}", $invalidData, [
        'Authorization' => 'Bearer ' . $this->token,
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name', 'email', 'state', 'city']);
});

it('fails to update an employee of another user', function () {

    $otherUser = User::factory()->create();
    $employee = Employee::factory()->create(['manager_id' => $otherUser->id]);

    $updatedData = [
        'name' => 'Jane Doe',
        'email' => 'jane.doe@example.com',
        'state' => 'RJ',
        'city' => 'Rio de Janeiro',
    ];

    $response = $this->put("/api/employee/{$employee->id}", $updatedData, [
        'Authorization' => 'Bearer ' . $this->token,
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(403);
    $response->assertJson([
        'message' => 'Você não tem permissão para alterar este colaborador'
    ]);
});

it('deletes an employee successfully', function () {
    $employee = Employee::factory()->create(['manager_id' => $this->user->id]);

    $response = $this->delete("/api/employee/{$employee->id}", [], [
        'Authorization' => 'Bearer ' . $this->token,
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
});

it('fails to delete an employee of another user', function () {

    $otherUser = User::factory()->create();
    $employee = Employee::factory()->create(['manager_id' => $otherUser->id]);

    $response = $this->delete("/api/employee/{$employee->id}", [], [
        'Authorization' => 'Bearer ' . $this->token,
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(403);
    $response->assertJson([
        'message' => 'Você não tem permissão para excluir este colaborador'
    ]);
});
