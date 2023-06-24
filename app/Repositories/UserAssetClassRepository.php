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

    public function getClassBySlug(int $userId, string $slug): ?object
    {
        return $this->model->with('assetClass')
            ->whereHas('assetClass', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->where('user_id', $userId)
            ->first();
    }
}
