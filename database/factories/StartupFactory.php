<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Startup>
 */
class StartupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(45),
            'sector' => ucfirst($this->faker->word()),
            'founders' => $this->faker->firstName() . ', ' . $this->faker->firstName(),
            'founders_nationality' => $this->faker->country(),
            'team_size' => $this->faker->randomNumber(2),
            'headquarters' => $this->faker->country(),
            'investment_stage' => $this->faker->sentence(4),
            'funds_raised' => '$' . $this->faker->numberBetween(10, 500) . 'M',
            'fund_value' => $this->faker->randomFloat(1, 0, 40)
        ];
    }
}
