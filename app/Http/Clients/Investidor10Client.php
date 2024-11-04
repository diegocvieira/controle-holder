<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;

class Investidor10Client
{
    private function request(string $assetClass, string $ticker): ?\DOMXPath
    {
        if ($assetClass === 'etfs-brasil') {
            $assetClass = 'etfs';
        } else if ($assetClass === 'etfs-usa') {
            $assetClass = 'etfs-global';
        }

        $url = "https://investidor10.com.br/{$assetClass}/{$ticker}/";

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

        return $xpath->query('//div[@class="name-ticker"]//h2[@class="name-company"]')->item(0)->nodeValue ?? '';
    }

    public function getAssetPrice(string $assetClass, string $ticker): string
    {
        $xpath = $this->request($assetClass, $ticker);

        if (!$xpath) {
            return '';
        }

        $price = $xpath->query('//div[@class="_card cotacao"]//span[@class="real"]')->item(0)->nodeValue ?? '';

        if (!$price) {
            $price = $xpath->query('//div[@class="_card cotacao"]//span[@class="value"]')->item(0)->nodeValue ?? '';
        }

        $price = preg_replace('/[^\d,.]+/', '', $price);
        return number_format(str_replace(['.', ','], ['', '.'], $price), 2, '.', '');
    }
}
