<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name'         => $this->faker->firstName(),
            'last_name'          => $this->faker->lastName(),
            'age'                => $this->faker->randomNumber(2),
            'mobile'             => $this->faker->phoneNumber(),
            'adress'             => $this->faker->address(),
            'is_admin'           => $this->faker->boolean(),

            'email'              => $this->faker->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            'verification_token' => $this->faker->unique()->randomNumber(),

            'password'           => Crypt::encryptString('password'),
            'remember_token'     => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
