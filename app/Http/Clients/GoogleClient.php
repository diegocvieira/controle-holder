<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;
use App\Http\Utils\PriceUtil;

class GoogleClient
{
    public function __construct(private PriceUtil $priceUtil)
    {
    }

    private function request(string $assetClass, string $ticker): ?\DOMXPath
    {
        if ($assetClass === 'criptomoedas') {
            $url = "https://www.google.com/finance/quote/{$ticker}-BRL";
        } elseif ($assetClass === 'stocks') {
            $url = "https://www.google.com/finance/quote/{$ticker}:NASDAQ";
        } elseif ($assetClass === 'reits') {
            $url = "https://www.google.com/finance/quote/{$ticker}:NYSE";
        } elseif ($assetClass === 'etfs-usa') {
            $url = "https://www.google.com/finance/quote/{$ticker}:NYSEARCA";
        } else {
            $url = "https://www.google.com/finance/quote/{$ticker}:BVMF";
        }

        $response = Http::get($url);

        if (!$response->successful()) {
            return null;
        }

        $html = $response->body();

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML($html);

        return new \DOMXPath($dom);
    }

    public function getAssetName(string $assetClass, string $ticker): string
    {
        $xpath = $this->request($assetClass, $ticker);

        if (!$xpath) {
            return '';
        }

        return $xpath->query('//div[@class="zzDege"]')->item(0)->nodeValue ?? '';
    }

    public function getAssetPrice(string $assetClass, string $ticker): string
    {
        $xpath = $this->request($assetClass, $ticker);

        if (!$xpath) {
            return '';
        }

        $price = $xpath->query('//div[@class="YMlKec fxKbKc"]')->item(0)->nodeValue ?? '';
        $price = preg_replace('/[^\d,.]+/', '', $price);

        if (in_array($assetClass, ['stocks', 'reits', 'etfs-usa'])) {
           return $this->priceUtil->convertDollarToReal($price);
        }

        return $price;
    }
}
