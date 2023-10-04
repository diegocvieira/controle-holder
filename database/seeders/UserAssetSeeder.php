<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Repositories\AssetClassRepository;
use App\Repositories\AssetRepository;
use App\Repositories\UserAssetClassRepository;
use App\Repositories\UserAssetRepository;
use App\Repositories\UserRepository;

class UserAssetSeeder extends Seeder
{
    protected $assetClassRepository;
    protected $assetRepository;
    protected $userAssetClassRepository;
    protected $userAssetRepository;
    protected $userRepository;

    public function __construct(AssetClassRepository $assetClassRepository, AssetRepository $assetRepository, UserAssetClassRepository $userAssetClassRepository, UserAssetRepository $userAssetRepository, UserRepository $userRepository)
    {
        $this->assetClassRepository = $assetClassRepository;
        $this->assetRepository = $assetRepository;
        $this->userAssetClassRepository = $userAssetClassRepository;
        $this->userAssetRepository = $userAssetRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->userRepository->createUser([
            'name' => 'Test',
            'email' => 'test@holder.com',
            'password' => bcrypt('12345678')
        ]);
        $user = $this->userRepository->getByEmail('test@holder.com');

        foreach ($this->getData() as $data) {
            $assetClass = $this->assetClassRepository->getBySlug($data['slug']);

            $this->userAssetClassRepository->save($user->id, $assetClass->id, $data['percentage']);
            $userAssetClass = $this->userAssetClassRepository->getByAssetClassId($user->id, $assetClass->id);

            foreach ($data['assets'] as $dataAsset) {
                $asset = $this->assetRepository->getAssetByTicker($dataAsset['ticker']);

                $this->userAssetRepository->createAsset([
                    'user_id' => $user->id,
                    'user_asset_class_id' => $userAssetClass->id,
                    'asset_id' => $asset->id,
                    'quantity' => $dataAsset['quantity'],
                    'rating' => $dataAsset['rating']
                ]);
            }
        }
    }

    public function getData(): array
    {
        return [
            [
                'slug' => 'acoes',
                'percentage' => 50,
                'assets' => [
                    [
                        'ticker' => 'ITSA4',
                        'quantity' => 3,
                        'rating' => 50
                    ], [
                        'ticker' => 'WEGE3',
                        'quantity' => 5,
                        'rating' => 50
                    ], [
                        'ticker' => 'ABEV3',
                        'quantity' => 29,
                        'rating' => 70
                    ]
                ]
            ], [
                'slug' => 'fiis',
                'percentage' => 50,
                'assets' => [
                    [
                        'ticker' => 'KNRI11', // lajes corporativas e galpões logísticos
                        'quantity' => 32,
                        'rating' => 100
                    ], [
                        'ticker' => 'HGBS11', // shoppings
                        'quantity' => 18,
                        'rating' => 100
                    ], [
                        'ticker' => 'HGLG11', // galpões logísticos
                        'quantity' => 18,
                        'rating' => 100
                    ], [
                        'ticker' => 'HGRE11', // lajes corporativas
                        'quantity' => 25,
                        'rating' => 100
                    ], [
                        'ticker' => 'GGRC11', // galpões logísticos
                        'quantity' => 17,
                        'rating' => 80
                    ], [
                        'ticker' => 'HGRU11', // renda urbana
                        'quantity' => 8,
                        'rating' => 80
                    ], [
                        'ticker' => 'KNIP11', // IPCA
                        'quantity' => 10,
                        'rating' => 50
                    ], [
                        'ticker' => 'IRDM11', // CDI e IPCA/IGPM
                        'quantity' => 9,
                        'rating' => 25
                    ], [
                        'ticker' => 'HCTR11', // IPCA
                        'quantity' => 8,
                        'rating' => 25
                    ]
                ]
            ]
        ];
    }
}
