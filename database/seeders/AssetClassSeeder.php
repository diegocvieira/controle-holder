<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Repositories\AssetClassRepository;

class AssetClassSeeder extends Seeder
{
    protected $assetClassRepository;

    public function __construct(AssetClassRepository $assetClassRepository)
    {
        $this->assetClassRepository = $assetClassRepository;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getData() as $data) {
            $assetClass = $this->assetClassRepository->getBySlug($data['slug']);

            if ($assetClass) {
                continue;
            }

            $this->assetClassRepository->createAssetClass([
                'name' => $data['name'],
                'slug' => $data['slug']
            ]);
        }
    }

    public function getData(): array
    {
        return [
            ['name' => 'Ações', 'slug' => 'acoes'],
            ['name' => 'FIIs', 'slug' => 'fiis'],
            ['name' => 'Criptomoedas', 'slug' => 'cryptocurrencies']
        ];
    }
}
