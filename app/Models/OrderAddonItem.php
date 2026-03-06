<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OrderAddonItem extends Model
{
    protected $fillable = [
        'order_id',
        'item_id',
        'item_name',
        'price_per_pax',
        'guest_count',
        'total_price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}