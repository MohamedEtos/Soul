<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\FabricType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('8472304'),
        ]);

        $this->call(CategorySeeder::class);
        $this->call(GovernoratesSeeder::class);
        $this->call(FabricSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProdImgSeeder::class);
        // $this->call(OrderSeeder::class);
        $this->call(SettingsSeeder::class);

    }
}
