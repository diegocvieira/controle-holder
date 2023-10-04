<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
Use Database\Seeders\AssetClassSeeder;
Use Database\Seeders\FiiSeeder;
Use Database\Seeders\AcaoSeeder;
Use Database\Seeders\CryptocurrencySeeder;
Use Database\Seeders\UserAssetSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AssetClassSeeder::class);
        $this->call(FiiSeeder::class);
        $this->call(AcaoSeeder::class);
        $this->call(UserAssetSeeder::class);
        $this->call(CryptocurrencySeeder::class);
    }
}
