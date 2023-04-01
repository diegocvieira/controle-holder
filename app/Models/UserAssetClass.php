<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAssetClass extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_asset_class_id',
        'asset_class_id',
        'percentage'
    ];

    public function assetClass()
    {
        return $this->belongsTo(AssetClass::class, 'asset_class_id', 'id');
    }

    public function userAssets()
    {
        return $this->hasMany(UserAsset::class, 'user_asset_class_id', 'id');
    }
}
