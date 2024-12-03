<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();

        return [
            //
            'name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'document_number' => $faker->numerify('###########'),
            'state' => $faker->state(),
            'city' => $faker->city(),
            'manager_id' => User::factory()
        ];
    }
}
