<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    protected $fillable = [
        'package_id',
        'customer_name',
        'customer_phone',
        'email',              
        'delivery_address',
        'event_date',          
        'event_time',          
        'guest_count',
        'package_price',
        'package_total',
        'addon_total',
        'grand_total',
        'notes',               
        'order_status',
        'advance_amount',
        'remaining_amount',
        'kids_package_id',
        'kids_count',
        'kids_package_total',
        'delivery_charge'
    ];
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function addonItems()
    {
        return $this->hasMany(OrderAddonItem::class);
    }
    public function ItemsList()
    {
        return $this->hasMany(OrderPackageSelection::class, 'order_id');
    }
        public function kidsPackage()
    {
        return $this->belongsTo(Package::class, 'kids_package_id');
    }

    public function kidsOrderItems()
    {
        return $this->hasMany(KidsOrderItem::class, 'order_id');
    }
    
}