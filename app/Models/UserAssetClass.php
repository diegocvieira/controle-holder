<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAssetClass extends Model
{
    protected $fillable = [
        'user_id',
        'asset_class_id',
        'wallet_id',
        'percentage'
    ];

    public function assetClass()
    {
        return $this->belongsTo(AssetClass::class, 'asset_class_id', 'id');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }
}
