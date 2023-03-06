<?php

namespace Database\Factories;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $shop = Shop::query()->pluck('shop_id');
        return [
            'name' => $this->faker->unique()->name(),
            'slug' => Str::slug($this->faker->name),
            'shop_id' => $this->faker->randomElement($shop),
            'status' => 1
        ];
    }
}
