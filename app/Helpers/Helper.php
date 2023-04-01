<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class Helper
{
    public static function formatPrice($price)
    {
        return number_format($price, 2, ',', '.');
    }

    public static function getPriceFromSession($ticker)
    {
        $cacheKey = 'asset_price_' . $ticker;

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        return null;
    }
}
