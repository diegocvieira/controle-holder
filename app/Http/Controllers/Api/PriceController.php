<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Http;

class PriceController extends Controller
{
    public function getPrice(Request $request): array
    {
        $assetClass = $request->asset_class;
        $ticker = $request->ticker;

        if (Cache::has('asset_price_' . $ticker)) {
            return [
                'ticker' => $ticker,
                'price' => Helper::getPriceFromSession($ticker)
            ];
        }

        $price = $this->getPriceFromGoogle($assetClass, $ticker);

        if ($price === '') {
            $price = $this->getPriceFromInvestidor10($assetClass, $ticker);
        }

        if ($price === '') {
            $price = $this->getPriceFromAlphavantage($assetClass, $ticker);
        }

        if ($price !== '') {
            Cache::put('asset_price_' . $ticker, $price, 86400);
        }

        return [
            'ticker' => $ticker,
            'price' => $price
        ];
    }

    public function getPriceFromGoogle(string $assetClass, string $ticker): string
    {
        if ($assetClass === 'cryptocurrencies') {
            $url = 'https://www.google.com/finance/quote/' . $ticker . '-BRL';
        } else {
            $url = 'https://www.google.com/finance/quote/' . $ticker . ':BVMF';
        }

        $response = Http::get($url);
        $html = $response->body();

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML($html);

        $xpath = new \DOMXPath($dom);
        $price = $xpath->query('//div[@class="YMlKec fxKbKc"]')->item(0)->nodeValue ?? '';

        $price = preg_replace('/[^\d,.]+/', '', $price);
        $price = str_replace(',', '', $price);

        return $price;
    }

    public function getPriceFromInvestidor10(string $assetClass, string $ticker): string
    {
        if ($assetClass === 'cryptocurrencies') {
            return '';
        } else {
            $url = 'https://investidor10.com.br/' . $assetClass . '/' . $ticker . '/';
        }

        $response = Http::get($url);
        $html = $response->body();

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML($html);

        $xpath = new \DOMXPath($dom);
        $price = $xpath->query('//div[@class="_card cotacao"]//span[@class="value"]')->item(0)->nodeValue ?? '';

        $price = preg_replace('/[^\d,.]+/', '', $price);
        $price = number_format(str_replace(['.', ','], ['', '.'], $price), 2, '.', '');

        return $price;
    }

    public function getPriceFromAlphavantage(string $assetClass, string $ticker): string
    {
        $apiKey = '9F9ZM08SVJWHSWZ1';

        if ($assetClass === 'cryptocurrencies') {
            $url = 'https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency=' . $ticker . '&to_currency=BRL&apikey=' . $apiKey;
        } else {
            $url = 'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=' . $ticker . '.sa&apikey=' . $apiKey;
        }

        $response = Http::get($url);
        $data = $response->json();

        if ($assetClass === 'cryptocurrencies') {
            return $data['Realtime Currency Exchange Rate']['5. Exchange Rate'];
        }

        return $data['Global Quote']['05. price'];
    }
}
