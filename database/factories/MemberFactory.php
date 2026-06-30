<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_code' => $this->faker->unique()->numerify('MEM-#####'),
            'name' => $this->faker->name(),
            'type' => $this->faker->randomElement(['Student', 'Teacher']),
            'contact' => $this->faker->phoneNumber(),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}
