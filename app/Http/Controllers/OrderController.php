<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Package;
//use App\Models\Item;
use App\Models\OrderAddonItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        'package_id' => 'required|exists:packages,id',
        'customer_name' => 'required|string',
        'customer_phone' => 'required|string',
        'email' => 'nullable|email',
        'delivery_address' => 'nullable|string',
        'event_date' => 'nullable|date',
        'event_time' => 'nullable',
        'guest_count' => 'required|integer|min:1',
        'notes' => 'nullable|string',
        'addons' => 'nullable|string',
    ]);

    $orderDetails = DB::transaction(function () use ($request) {

        $package = Package::findOrFail($request->package_id);
        $guestCount = $request->guest_count;

        $packageTotal = $package->price_per_pax * $guestCount;
        $addonTotal = 0;

        $order = Order::create([
            'package_id'       => $package->id,
            'customer_name'    => $request->customer_name,
            'customer_phone'   => $request->customer_phone,
            'email'            => $request->email,
            'delivery_address' => $request->delivery_address,
            'event_date'       => $request->event_date,
            'event_time'       => $request->event_time,
            'guest_count'      => $guestCount,
            'package_price'    => $package->price_per_pax,
            'package_total'    => $packageTotal,
            'addon_total'      => 0.0, 
            'grand_total'      => 0.0, 
            'notes'            => $request->notes,
            'order_status'     => 'Pending',
        ]);

        $addonsData = [];
        if ($request->has('addons')) {
            $addons = json_decode($request->addons, true); 
            foreach ($addons as $addon) {
                $total = $addon['price'] * $guestCount;

                $addonItem = OrderAddonItem::create([
                    'order_id'      => $order->id,
                    'item_name'     => $addon['name'],
                    'price_per_pax' => $addon['price'],
                    'guest_count'   => $guestCount,
                    'total_price'   => $total,
                ]);

                $addonTotal += $total;
                $addonsData[] = $addonItem;
            }
        }

        $order->update([
            'addon_total' => $addonTotal,
            'grand_total' => $packageTotal + $addonTotal,
        ]);

        return [
            'order' => $order,
            'addons' => $addonsData,
            'notes' => $request->notes,
            'delivery_address' =>$request->delivery_address,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,            
        ];
    });

    return response()->json([
        'message' => 'Order created successfully',
        'order_details' => $orderDetails['order'],
        'addons' => $orderDetails['addons'],
        'notes' => $orderDetails['notes'],
        'delivery_address' => $orderDetails['delivery_address'],
        'event_date'=> $orderDetails['event_date'],
        'event_time' => $orderDetails['event_time'],
    ]);
}
}
