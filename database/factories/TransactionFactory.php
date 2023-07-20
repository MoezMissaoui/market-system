<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $sellers = Seller::has('products')->get('id');
        $buyer = User::all('id')->except($sellers->pluck('id')->toArray())->random();

        return [
            'quantity'       => $this->faker->numberBetween(1, 4),
            'buyer_id'       => $buyer->id ?? NULL,
            'product_id'     => $sellers->random()->products->random()->id ?? NULL ,  // Or Product::inRandomorder()->first('id')->id
        ];
    }
}
