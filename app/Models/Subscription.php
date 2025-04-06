<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_id',
        'status',
        'plan_code',
        'cancel_at'
    ];

    const PAID_STATUS = 'paid';
}
