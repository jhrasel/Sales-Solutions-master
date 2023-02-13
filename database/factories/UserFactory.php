<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'phone' => '+8801800000000',
            'role' => 'admin',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'password' => '123456789', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return Factory
     */
    public function merchant(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->email(),
                'phone' => $this->faker->unique()->phoneNumber(),
                'role' => 'merchant',
            ];
        });
    }

    public function customer(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->email(),
                'phone' => $this->faker->unique()->phoneNumber(),
                'role' => 'customer',
            ];
        });
    }


    /**
     * @return Factory
     */
    public function staff(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->email(),
                'phone' => $this->faker->unique()->phoneNumber(),
                'role' => 'staff',
            ];
        });
    }
}
