<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'designation' => $this->faker->jobTitle,
            'joining_date' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'branch_id' => rand(1, 3), // adjust as per your branches
            'base_salary' => $this->faker->numberBetween(20000, 80000),
        ];
    }
}
