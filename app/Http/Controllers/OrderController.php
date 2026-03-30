<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Package;
use App\Models\OrderAddonItem;
use App\Models\OrderPackageSelection; // ← new model
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'package_id'          => 'required|exists:packages,id',
            'customer_name'       => 'required|string',
            'customer_phone'      => 'required|string',
            'email'               => 'nullable|email',
            'delivery_address'    => 'nullable|string',
            'event_date'          => 'nullable|date',
            'event_time'          => 'nullable',
            'guest_count'         => 'required|integer|min:1',
            'notes'               => 'nullable|string',
            'addons'              => 'nullable|string',
            'package_group_items' => 'nullable|string', // JSON: { groupId: itemName }
        ]);

        $orderDetails = DB::transaction(function () use ($request) {

            $package    = Package::findOrFail($request->package_id);
            $guestCount = $request->guest_count;
            $packageTotal = $package->price_per_pax * $guestCount;
            $addonTotal   = 0;

            // ── Create Order ──────────────────────────────────
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
                'advance_amount'   => 0.0,
                'remaining_amount' => 0.0,
                'notes'            => $request->notes,
                'order_status'     => 'Pending',
            ]);

            if (!$order) throw new \Exception('Order creation failed');

            // Save Package Group Selections 
            $selectedItemNames = [];

            if ($request->filled('package_group_items')) {
                $groupSelections = json_decode($request->package_group_items, true);

                if (is_array($groupSelections)) {
                    foreach ($groupSelections as $groupId => $chosenItemName) {
                        // Find the item_id by name in the items table
                        $item = DB::table('items')
                            ->where('item_name', $chosenItemName)
                            ->first();

                        // Find the package_items row to get group_id
                        // group_id corresponds to groupId position in this package
                        $packageItem = DB::table('package_items')
                            ->where('package_id', $package->id)
                            ->where('group_id', $groupId)
                            ->when($item, fn($q) => $q->where('item_id', $item->id))
                            ->first();

                        // If no exact match found 
                        // fall back to just storing the name with what we have
                        OrderPackageSelection::create([
                            'order_id'   => $order->id,
                            'package_id' => $package->id,
                            'group_id'   => $groupId,
                            'item_id'    => $packageItem?->item_id ?? $item?->id,
                        ]);

                        $selectedItemNames[] = $chosenItemName;
                    }
                }
            }

            // ── Save Add-ons ──────────────────────────────────
            $addonsData = [];

            if ($request->filled('addons')) {
                $addons = json_decode($request->addons, true);

                if (is_array($addons)) {
                    foreach ($addons as $addon) {
                        $total = $addon['price'] * $guestCount;

                        $addonItem = OrderAddonItem::create([
                            'order_id'       => $order->id,
                            'item_name'      => $addon['name'],
                            'price_per_pax'  => $addon['price'],
                            'guest_count'    => $guestCount,
                            'total_price'    => $total,
                        ]);

                        if (!$addonItem) throw new \Exception('Addon creation failed');

                        $addonTotal  += $total;
                        $addonsData[] = $addonItem;
                    }
                }
            }

            // ── Update totals ─────────────────────────────────
            $updated = $order->update([
                'addon_total'      => $addonTotal,
                'grand_total'      => $packageTotal + $addonTotal,
                'remaining_amount' => $packageTotal + $addonTotal,
            ]);

            if (!$updated) throw new \Exception('Order update failed');

            return [
                'order'              => $order,
                'addons'             => $addonsData,
                'selected_items'     => $selectedItemNames,
                'notes'              => $request->notes,
                'delivery_address'   => $request->delivery_address,
                'event_date'         => $request->event_date,
                'event_time'         => $request->event_time,
            ];
        });

        return response()->json([
            'message'        => 'Order created successfully',
            'order_details'  => $orderDetails['order'],
            'addons'         => $orderDetails['addons'],
            'selected_items' => $orderDetails['selected_items'],
            'notes'          => $orderDetails['notes'],
            'event_venue'    => $orderDetails['delivery_address'],
            'event_date'     => $orderDetails['event_date'],
            'event_time'     => $orderDetails['event_time'],
        ]);
    }
}