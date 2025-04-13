<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AssetClass;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $assetClasses = [
            [
                'name' => 'Ações',
                'slug' => 'acoes'
            ], [
                'name' => 'FIIs',
                'slug' => 'fiis'
            ], [
                'name' => 'Criptomoedas',
                'slug' => 'criptomoedas'
            ], [
                'name' => 'BDRs',
                'slug' => 'bdrs'
            ], [
                'name' => 'ETFs Brasil',
                'slug' => 'etfs-brasil'
            ], [
                'name' => 'Renda Fixa',
                'slug' => 'renda-fixa'
            ], [
                'name' => 'Stocks',
                'slug' => 'stocks'
            ], [
                'name' => 'Reits',
                'slug' => 'reits'
            ], [
                'name' => 'ETFs USA',
                'slug' => 'etfs-usa'
            ]
        ];

        foreach ($assetClasses as $assetClass) {
            AssetClass::create($assetClass);
        }
    }
}
