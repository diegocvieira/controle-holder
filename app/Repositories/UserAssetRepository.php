<?php

namespace App\Repositories;

use App\Models\UserAsset;

class UserAssetRepository
{
    protected $model;

    public function __construct(UserAsset $model)
    {
        $this->model = $model;
    }

    public function getAllAssets(int $userId): object
    {
        return $this->model->with([
            'asset' => function ($query) {
                $query->select(['id', 'ticker']);
            },
            'userAssetClass.assetClass' => function ($query) {
                $query->select(['id', 'name', 'slug']);
            },
        ])
        ->where('user_id', $userId)
        ->get();
    }

    public function getAssetByTicker(int $userId, string $ticker): ?object
    {
        return $this->model->with('asset')
            ->whereHas('asset', function ($query) use ($ticker) {
                $query->where('ticker', $ticker);
            })
            ->where('user_id', $userId)
            ->first();
    }

    public function updateAsset(int $userId, string $ticker, array $data): void
    {
        $this->model->whereHas('asset', function ($query) use ($ticker) {
                $query->where('ticker', $ticker);
            })
            ->where('user_id', $userId)
            ->update($data);
    }

    public function createAsset(array $data): void
    {
        $this->model->create($data);
    }

    public function getAssetsCountByUser($userId): int
    {
        return $this->model->where('user_id', $userId)->count();
    }
}
