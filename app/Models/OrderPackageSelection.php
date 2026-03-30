<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPackageSelection extends Model
{
    protected $fillable = [
        'order_id',
        'package_id',
        'group_id',
        'item_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}