<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;
use App\Http\Utils\PriceUtil;

class BrapiClient
{
    public function __construct(private PriceUtil $priceUtil)
    {
    }

    private function request(string $ticker): array
    {
        $token = '4eiRZ1TxVvsdeNyQvGrJTo';
        $url = "https://brapi.dev/api/quote/{$ticker}?token={$token}";

        $response = Http::get($url);
        $results = $response->json();

        return $results['results'][0] ?? [];
    }

    public function getAssetName(string $ticker): string
    {
        $data = $this->request($ticker);

        return $data['longName'] ?? '';
    }

    public function getAssetPrice(string $assetClass, string $ticker): float
    {
        if ($assetClass === 'criptomoedas') {
            return 0;
        }

        $data = $this->request($ticker);
        $price = $data['regularMarketPrice'];

        if ($data['currency'] === 'USD') {
            return $this->priceUtil->convertDollarToReal($price);
        }

        return $price;
    }
}
