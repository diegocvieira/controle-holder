<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;
use App\Http\Utils\PriceUtil;

class AlphavantageClient
{
    public function __construct(private PriceUtil $priceUtil)
    {
    }

    public function getAssetName(string $ticker): string
    {
        $apiKey = '9F9ZM08SVJWHSWZ1';
        $url = "https://www.alphavantage.co/query?function=SYMBOL_SEARCH&keywords={$ticker}&apikey={$apiKey}";

        $response = Http::get($url);
        $data = $response->json();

        return $data['bestMatches'][0]['2. name'] ?? '';
    }

    public function getAssetPrice(string $assetClass, string $ticker): string
    {
        $apiKey = '9F9ZM08SVJWHSWZ1';

        if ($assetClass === 'criptomoedas') {
            $url = "https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency={$ticker}&to_currency=USD&apikey={$apiKey}";
        } else if (in_array($assetClass, ['stocks', 'reits', 'etfs-usa'])) {
            $url = "https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol={$ticker}&apikey={$apiKey}";
        } else {
            $url = "https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol={$ticker}.sa&apikey={$apiKey}";
        }

        $response = Http::get($url);
        $data = $response->json();
        $price = $assetClass === 'criptomoedas' ? $data['Realtime Currency Exchange Rate']['9. Ask Price'] : $data['Global Quote']['05. price'];

        if (in_array($assetClass, ['criptomoedas', 'stocks', 'reits', 'etfs-usa'])) {
            return $this->priceUtil->convertDollarToReal($price);
        }

        return $price;
    }
}
