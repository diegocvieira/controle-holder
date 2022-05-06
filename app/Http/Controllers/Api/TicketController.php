<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class TicketController extends Controller
{
    public function getAllFromLoggedUser()
    {
        $wallet = collect([
            (object) [
                'class' => 'Ações',
                'ideal_percentage' => 40,
                'tickets' => [
                    (object) [
                        'code' => 'ITSA4',
                        // 'price' => '12.12',
                        'quantity' => 3,
                        'ideal_percentage' => 50
                    ],
                    (object) [
                        'code' => 'WEGE3',
                        // 'price' => '23.12',
                        'quantity' => 5,
                        'ideal_percentage' => 50
                    ]
                ]
            ],
            (object) [
                'class' => 'FIIs',
                'ideal_percentage' => 60,
                'tickets' => [
                    (object) [
                        'code' => 'KNRI11',
                        // 'price' => '10.19',
                        'quantity' => 112,
                        'ideal_percentage' => 60
                    ],
                    (object) [
                        'code' => 'XPLG11',
                        // 'price' => '100.19',
                        'quantity' => 72,
                        'ideal_percentage' => 40
                    ]
                ]
            ]
        ]);

        foreach ($wallet as $walletItem) {
            foreach ($walletItem->tickets as $ticket) {
                $ticket->price = $this->getPriceFromSession($ticket->code);
            }
        }

        return response()->json([
            'data' => $wallet
        ]);
    }

    public function getPriceFromSession($ticket)
    {
        return '12.22';
        $cachedPrices = Cache::get('prices');

        if ($cachedPrices && array_key_exists($ticket, $cachedPrices) && ($cachedPrices[$ticket]['date'] >= Carbon::now()->subDays(1) || in_array(Carbon::now()->dayOfWeek, [0, 6]))) {
            return $cachedPrices[$ticket]['price'];
        }

        return null;
    }
}
