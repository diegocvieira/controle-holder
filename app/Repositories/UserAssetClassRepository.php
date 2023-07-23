<?php

namespace App\Repositories;

use App\Models\UserAssetClass;

class UserAssetClassRepository
{
    protected $model;

    public function __construct(UserAssetClass $model)
    {
        $this->model = $model;
    }

    public function getAllAssetClasses(int $userId): object
    {
        return $this->model->with('assetClass')
            ->where('user_id', $userId)
            ->get();
    }

    public function getByAssetClassId(int $userId, int $assetClassId): ?object
    {
        return $this->model->with('assetClass')
            ->where('user_id', $userId)
            ->where('asset_class_id', $assetClassId)
            ->first();
    }

    public function save(int $userId, int $assetClassId, int $percentage): void
    {
        $this->model->updateOrCreate(
            ['user_id' => $userId, 'asset_class_id' => $assetClassId],
            ['percentage' => $percentage]
        );
    }
}
