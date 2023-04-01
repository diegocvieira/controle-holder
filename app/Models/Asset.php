<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ticker',
        'asset_class_id'
    ];

    public function userAssets()
    {
        return $this->hasMany(UserAsset::class, 'asset_id', 'id');
    }
}
