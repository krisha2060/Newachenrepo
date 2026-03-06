<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['package_name', 'price_per_pax', 'is_active'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'package_items');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}