<?php

namespace App\Repositories;

use App\Models\AssetClass;

class AssetClassRepository
{
    protected $model;

    public function __construct(AssetClass $model)
    {
        $this->model = $model;
    }

    public function getAll(): object
    {
        return $this->model->orderBy('name', 'ASC')->get();
    }

    public function getBySlug(string $slug): ?object
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function createAssetClass(array $data): void
    {
        $this->model->create($data);
    }
}
