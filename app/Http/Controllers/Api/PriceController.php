<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class PriceController extends Controller
{
    private $apiKey = '9F9ZM08SVJWHSWZ1';

    public function getPrice(Request $request)
    {
        // $cachedPrices = Cache::get('prices');

        // if ($cachedPrices && array_key_exists($ticket, $cachedPrices) && ($cachedPrices[$ticket]['date'] >= Carbon::now()->subDays(1) || in_array(Carbon::now()->dayOfWeek, [0, 6]))) {
        //     return $cachedPrices[$ticket]['price'];
        // }

        // $url = 'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=' . $ticket . '.sa&apikey=' . $this->apiKey;

        // $json = file_get_contents($url);
        // $data = json_decode($json, true);

        // $cachedPrices[$ticket] = [
        //     'price' => $data['Global Quote']['05. price'],
        //     'date' => date('Y-m-d H:i:s')
        // ];

        // Cache::put('prices', $cachedPrices);

        // return $cachedPrices[$ticket]['price'];

        $prices = [];

        foreach ($request->data as $data) {
            $prices[] = [
                'ticker' => $data['ticker'],
                'price' => 12.50
            ];
            continue;






            $cacheKey = 'asset_price_' . $data['ticker'];

            if (Cache::has($cacheKey)) {
                $prices[] = [
                    'ticker' => $data['ticker'],
                    'price' => Cache::get($cacheKey)
                ];
            } else {
                $curl = curl_init();
                $requestType = 'GET';
                $url = 'https://investidor10.com.br/' . $data['asset_class'] . '/' . strtolower($data['ticker']) . '/';
                curl_setopt_array($curl, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => $requestType,
                    CURLOPT_POSTFIELDS => '',
                    CURLOPT_HTTPHEADER => [],
                ]);

                $response = curl_exec($curl);
                curl_close($curl);
                libxml_use_internal_errors(true);
                $dom = new \DOMDocument();
                $dom->loadHTML($response);
                $xpath = new \DOMXPath($dom);

                $price = $xpath->query('//div[@class="_card cotacao"]//span[@class="value"]')->item(0)->nodeValue;
                $price = preg_replace('/[^\d,.]+/', '', $price);

                $prices[] = [
                    'ticker' => $data['ticker'],
                    'price' => $price
                ];

                Cache::put($cacheKey, $price, 86400);
            }
        }

        return $prices;

        // CRIPTOMOEDAS CONFIG
        // $url = 'https://investidor10.com.br/criptomoedas/bitcoin/';
        // $price = $xpath->query('//section[@id="cards-ticker"]//div[@class="_card"]')->item(1)->nodeValue;
    }
}
