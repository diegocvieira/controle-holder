<?php

namespace App\Repositories;

use App\Models\Asset;

class AssetRepository
{
    protected $model;

    public function __construct(Asset $model)
    {
        $this->model = $model;
    }

    public function getAssetByTicker(string $ticker): ?object
    {
        return $this->model->where('ticker', $ticker)->first();
    }
}
