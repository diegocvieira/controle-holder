<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AssetClass;
use App\Models\UserAssetClass;
use App\Models\Asset;
use App\Models\UserAsset;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $assetClasses = [
            [
                'name' => 'Ações',
                'percentage' => 50,
                'assets' => [
                    [
                        'ticker' => 'ITSA4',
                        'quantity' => 3,
                        'rating' => 50
                    ],
                    [
                        'ticker' => 'WEGE3',
                        'quantity' => 5,
                        'rating' => 50
                    ],
                    [
                        'ticker' => 'ABEV3',
                        'quantity' => 29,
                        'rating' => 70
                    ]
                ]
            ],
            [
                'name' => 'FIIs',
                'percentage' => 50,
                'assets' => [
                    [
                        'ticker' => 'KNRI11', // lajes corporativas e galpões logísticos
                        'quantity' => 32,
                        'rating' => 100
                    ],
                    [
                        'ticker' => 'HGBS11', // shoppings
                        'quantity' => 18,
                        'rating' => 100
                    ],
                    [
                        'ticker' => 'HGLG11', // galpões logísticos
                        'quantity' => 18,
                        'rating' => 100
                    ],
                    [
                        'ticker' => 'HGRE11', // lajes corporativas
                        'quantity' => 25,
                        'rating' => 100
                    ],
                    [
                        'ticker' => 'GGRC11', // galpões logísticos
                        'quantity' => 17,
                        'rating' => 80
                    ],
                    [
                        'ticker' => 'HGRU11', // renda urbana
                        'quantity' => 8,
                        'rating' => 80
                    ],
                    [
                        'ticker' => 'KNIP11', // IPCA
                        'quantity' => 10,
                        'rating' => 50
                    ],
                    [
                        'ticker' => 'IRDM11', // CDI e IPCA/IGPM
                        'quantity' => 9,
                        'rating' => 25
                    ],
                    [
                        'ticker' => 'HCTR11', // IPCA
                        'quantity' => 8,
                        'rating' => 25
                    ]
                ]
            ]
        ];

        $userId = User::create([
            'name' => 'Diego',
            'email' => 'vieiracdiego@gmail.com',
            'password' => bcrypt('123')
        ])->id;

        foreach ($assetClasses as $assetClass) {
            $assetClassId = AssetClass::create([
                'name' => $assetClass['name'],
                'slug' => \Str::slug($assetClass['name'])
            ])->id;

            $userAssetClassId = UserAssetClass::create([
                'user_id' => $userId,
                'asset_class_id' => $assetClassId,
                'percentage' => $assetClass['percentage']
            ])->id;

            foreach ($assetClass['assets'] as $asset) {
                $assetId = Asset::create([
                    'ticker' => $asset['ticker'],
                    'asset_class_id' => $assetClassId
                ])->id;

                UserAsset::create([
                    'user_id' => $userId,
                    'user_asset_class_id' => $userAssetClassId,
                    'asset_id' => $assetId,
                    'quantity' => $asset['quantity'],
                    'rating' => $asset['rating']
                ]);
            }
        }
    }
}
