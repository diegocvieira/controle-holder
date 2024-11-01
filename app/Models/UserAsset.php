<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAsset extends Model
{
    protected $fillable = [
        'user_id',
        'user_asset_class_id',
        'asset_id',
        'quantity',
        'rating'
    ];

    protected $casts = [
        'quantity' => 'float',
        'rating' => 'float'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }

    public function userAssetClass()
    {
        return $this->belongsTo(UserAssetClass::class, 'user_asset_class_id', 'id');
    }
}
