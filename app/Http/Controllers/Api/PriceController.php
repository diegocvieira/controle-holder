<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class PriceController extends Controller
{
    private $apiKey = '9F9ZM08SVJWHSWZ1';

    public function getPrice($ticket)
    {
        $cachedPrices = Cache::get('prices');

        if ($cachedPrices && array_key_exists($ticket, $cachedPrices) && ($cachedPrices[$ticket]['date'] >= Carbon::now()->subDays(1) || in_array(Carbon::now()->dayOfWeek, [0, 6]))) {
            return $cachedPrices[$ticket]['price'];
        }

        $url = 'https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=' . $ticket . '.sa&apikey=' . $this->apiKey;

        $json = file_get_contents($url);
        $data = json_decode($json, true);

        $cachedPrices[$ticket] = [
            'price' => $data['Global Quote']['05. price'],
            'date' => date('Y-m-d H:i:s')
        ];

        Cache::put('prices', $cachedPrices);

        return $cachedPrices[$ticket]['price'];
    }
}
