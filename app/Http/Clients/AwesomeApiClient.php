<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;

class AwesomeApiClient
{
    public function getDollarQuote(): float
    {
        $url = 'https://economia.awesomeapi.com.br/last/USD-BRL';

        $response = Http::get($url);
        $data = $response->json();

        return (float) $data['USDBRL']['ask'];
    }
}
