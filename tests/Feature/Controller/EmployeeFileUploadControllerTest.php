<?php

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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


it('uploads a file with employers successfully', function () {
    Storage::fake('local');
    $file = UploadedFile::fake()->create('document.csv', 100);
    $response = $this->post("/api/employee_file_upload", [
        'file' => $file,
    ], [
        'Authorization' => 'Bearer ' . $this->token,
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(201);
    $storedFiles = Storage::disk('local')->allFiles('employee_files');
    $this->assertCount(1, $storedFiles);
    $this->assertMatchesRegularExpression('/employee_files\/[a-zA-Z0-9]{40}\.csv/', $storedFiles[0]);
});


it('fails to upload an invalid file type with employers', function () {
    Storage::fake('local');
    $file = UploadedFile::fake()->create('document.txt', 100); // Arquivo com tipo inválido

    $response = $this->post("/api/employee_file_upload", [
        'file' => $file,
    ], [
        'Authorization' => 'Bearer ' . $this->token,
        'Accept' => 'application/json',
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['file']);
});
