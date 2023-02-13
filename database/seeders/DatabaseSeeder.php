<?php

namespace Database\Seeders;

use App\Models\CustomerInfo;
use App\Models\MerchantInfo;
use App\Models\Role;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    private $faker;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create();
        $this->faker = Faker::create();

        $name = $this->faker->name();
        User::factory(10)->merchant()->create()->each(function (User $user) use ($name) {
            Shop::query()->create([
                'user_id' => $user->id,
                'name' => $name,
                'domain' => Str::lower(Str::replace(' ','-',  $name)),
                'address' => $this->faker->address(),
                'shop_id' => mt_rand(111111, 999999),
            ]);

            MerchantInfo::query()->create([
                'user_id' => $user->id,
            ]);
        });

        $merchant = User::query()->where('role', 'merchant')->pluck('id');


        User::factory(10)->customer()->create()->each(function (User $user) use ($merchant) {

            CustomerInfo::query()->create([
                'user_id' => $user->id,
                'merchant_id' => $this->faker->randomElement($merchant)
            ]);

        });



        User::factory(200)->staff()->create();


        $roles = [
            [
                'name' => 'Senior Quality Analyst',
                'slug' => 'senior-quality-analyst',
            ],
            [
                'name' => 'Senior Data Analyst',
                'slug' => 'senior-data-analyst',
            ],
            [
                'name' => 'Senior Web Developer',
                'slug' => 'senior-web-developer',
            ],
            [
                'name' => 'Inside Sales Head',
                'slug' => 'inside-sales-head',
            ],
            [
                'name' => 'Hub Manager',
                'slug' => 'hub-manager',
            ],
        ];

        foreach ($roles as $role) {
            Role::query()->create([
                'name' => $role['name'],
                'slug' => $role['slug'],
            ]);
        }
    }
}
