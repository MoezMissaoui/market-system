<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => $this->faker->word(),
            'description'    => $this->faker->paragraph(),
            'quantity'      => $this->faker->numberBetween(4, 50),
            'is_available'  => true,
            'image'         => asset('assets/img/products'. $this->faker->numberBetween(1, 4) . '.png'),
            'seller_id'     => User::all('id')->random()->id ?? NULL,  // Or User::inRandomorder()->first('id')->id
        ];
    }
}
