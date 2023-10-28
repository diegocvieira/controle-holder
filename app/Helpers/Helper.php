<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class Helper
{
    public function getPriceFromSession(string $ticker): ?string
    {
        $cacheKey = 'asset_price_' . $ticker;

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        return null;
    }

    public function formatDecimalValue(float $value): float
    {
        if (floor($value) == $value) {
            return number_format($value, 0, '.', '.');
        }

        return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
    }
}
