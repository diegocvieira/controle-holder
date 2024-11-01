<?php

namespace App\Http\Utils;

use App\Http\Clients\AwesomeApiClient;

class PriceUtil
{
    public function __construct(private AwesomeApiClient $awesomeApiClient)
    {
    }

    public function convertDollarToReal(float $priceInDollar): string
    {
        $dollarQuote = $this->awesomeApiClient->getDollarQuote();

        return number_format($priceInDollar * $dollarQuote, 2, '.', '');
    }
}
