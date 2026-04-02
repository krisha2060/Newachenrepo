<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KidsOrderItem extends Model
{
    protected $table = 'kids_order_items';

    protected $fillable = [
        'order_id',
        'item_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}