<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $shop = Shop::query()->pluck('shop_id');
        $category = Category::query()->pluck('id');
        return [
            'category_id' => $this->faker->randomElement($category),
            'product_name' => $this->faker->unique()->name(),
            'slug' => Str::slug($this->faker->name),
            'price' => random_int(100, 10000),
            'product_code' => mt_rand(10000, 99999),
            'shop_id' => $this->faker->randomElement($shop),
        ];
    }
}
