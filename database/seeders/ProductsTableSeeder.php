<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('products')->delete();

        Product::factory(18)->create()->each(
            function($product) {
                $categories = Category::all('id')->random(mt_rand(0, 10))->pluck('id');
                $product->categories()->sync($categories);
            }
        ); 
    
    }
}