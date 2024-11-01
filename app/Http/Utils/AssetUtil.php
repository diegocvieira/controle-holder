<?php

namespace App\Http\Utils;

use App\Http\Clients\GoogleClient;
use App\Http\Clients\Investidor10Client;
use App\Http\Clients\BrapiClient;
use App\Http\Clients\AlphavantageClient;
use Illuminate\Support\Facades\Cache;

class AssetUtil
{
    public function __construct(private GoogleCLient $googleClient, private Investidor10CLient $investidor10Client, private BrapiCLient $brapiClient, private AlphavantageClient $alphavantageClient)
    {
    }

    public function getScrapingName(string $assetClass, string $ticker): string
    {
        $assetName = $this->investidor10Client->getAssetName($assetClass, $ticker);

        if ($assetName) {
            return $assetName;
        }

        $assetName = $this->googleClient->getAssetName($assetClass, $ticker);

        if ($assetName) {
            return $assetName;
        }

        $assetName = $this->brapiClient->getAssetName($ticker);

        if ($assetName) {
            return $assetName;
        }

        $assetName = $this->alphavantageClient->getAssetName($ticker);

        if ($assetName) {
            return $assetName;
        }

        return '';
    }

    public function getScrapingPrice(string $assetClass, string $ticker): string
    {
        $cacheIndex = "asset_price_{$ticker}";

        if (Cache::has($cacheIndex)) {
            return Cache::get($cacheIndex);
        }

        $price = $this->investidor10Client->getAssetPrice($assetClass, $ticker);

        if (!$price) {
            $price = $this->googleClient->getAssetPrice($assetClass, $ticker);
        }

        if (!$price) {
            $price = $this->brapiClient->getAssetPrice($assetClass, $ticker);
        }

        if (!$price) {
            $price = $this->alphavantageClient->getAssetPrice($assetClass, $ticker);
        }

        if ($price) {
            Cache::put($cacheIndex, $price, 2592000);
        }

        return $price;
    }

    public function getPriceFromCache(string $assetClass, string $ticker): ?string
    {
        if ($assetClass === 'renda-fixa') {
            return "1.00";
        }

        if (Cache::has("asset_price_{$ticker}")) {
            return Cache::get("asset_price_{$ticker}");
        }

        return null;
    }
}
