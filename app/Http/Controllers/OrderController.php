<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Package;
use App\Models\OrderAddonItem;
use App\Models\OrderPackageSelection;
use App\Models\KidsOrderItem;
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
            'package_group_items' => 'nullable|string',
            // kids
            'kids_package_id'     => 'nullable|exists:packages,id',
            'kids_count'          => 'nullable|integer|min:10',
            'kids_items'          => 'nullable|string', // JSON array of item names: ["Chicken Nuggets", "Veg Chowmein"]
        ]);


        //dd($request->all());

        $orderDetails = DB::transaction(function () use ($request) {

            $package      = Package::findOrFail($request->package_id);
            $guestCount   = $request->guest_count;
            $packageTotal = $package->price_per_pax * $guestCount;
            $addonTotal   = 0;

            //  Kids pre-calc 
            $kidsPackageId    = $request->filled('kids_package_id') ? (int) $request->kids_package_id : null;
            $kidsCount        = $request->filled('kids_count')      ? (int) $request->kids_count      : null;
            $kidsPackageTotal = null;

            if ($kidsPackageId && $kidsCount) {
                $kidsPackage      = Package::findOrFail($kidsPackageId);
                $kidsPackageTotal = $kidsPackage->price_per_pax * $kidsCount;
            }

            // Create Order 
            $order = Order::create([
                'package_id'         => $package->id,
                'customer_name'      => $request->customer_name,
                'customer_phone'     => '+61' . $request->customer_phone,
                'email'              => $request->email,
                'delivery_address'   => $request->delivery_address,
                'event_date'         => $request->event_date,
                'event_time'         => $request->event_time,
                'guest_count'        => $guestCount,
                'package_price'      => $package->price_per_pax,
                'package_total'      => $packageTotal,
                'addon_total'        => 0.0,
                'grand_total'        => 0.0,
                'advance_amount'     => 0.0,
                'remaining_amount'   => 0.0,
                'notes'              => $request->notes,
                'order_status'       => 'Pending',
                'kids_package_id'    => $kidsPackageId,
                'kids_count'         => $kidsCount,
                'kids_package_total' => $kidsPackageTotal,
            ]);

            if (!$order) throw new \Exception('Order creation failed');

            // Main Package Group Selections 
            $selectedItemNames = [];

            if ($request->filled('package_group_items')) {
                $groupSelections = json_decode($request->package_group_items, true);

                if (is_array($groupSelections)) {
                    foreach ($groupSelections as $groupId => $chosenItemName) {
                        $item = DB::table('items')
                            ->where('item_name', $chosenItemName)
                            ->first();

                        $packageItem = DB::table('package_items')
                            ->where('package_id', $package->id)
                            ->where('group_id', $groupId)
                            ->when($item, fn($q) => $q->where('item_id', $item->id))
                            ->first();

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

            //  Kids Order Items 
            // JS sends item names: ["Chicken Nuggets (4pcs) & Chips", "Veg Chowmein"]
           
            if ($kidsPackageId && $request->filled('kids_items')) {
                $kidsItemNames = json_decode($request->kids_items, true);

                if (is_array($kidsItemNames)) {
                    foreach ($kidsItemNames as $itemName) {
                        $item = DB::table('items')
                            ->where('item_name', $itemName)
                            ->first();

                        if ($item) {
                            KidsOrderItem::create([
                                'order_id' => $order->id,
                                'item_id'  => $item->id,
                            ]);
                        }
                    }
                }
            }



            //  Save Add-ons 
            $addonsData = [];

            if ($request->filled('addons')) {
                $addons = json_decode($request->addons, true);

                if (is_array($addons)) {
                    foreach ($addons as $addon) {
                        $quantity = isset($addon['qty']) && is_numeric($addon['qty']) ? max(1, (int) $addon['qty']) : 1;
                        $total = isset($addon['qty']) && is_numeric($addon['qty'])
                            ? $addon['price'] * $quantity
                            : $addon['price'] * $guestCount;

                        $addonItem = OrderAddonItem::create([
                            'order_id'      => $order->id,
                            'item_name'     => $addon['name'],
                            'price_per_pax' => $addon['price'],
                            'guest_count'   => $guestCount,
                            'quantity'      => $quantity,
                            'total_price'   => $total,
                        ]);

                        if (!$addonItem) throw new \Exception('Addon creation failed');

                        $addonTotal   += $total;
                        $addonsData[]  = $addonItem;
                    }
                }
            }

            //  Update totals 
            $grandTotal = $packageTotal + $addonTotal + ($kidsPackageTotal ?? 0);

            $updated = $order->update([
                'addon_total'      => $addonTotal,
                'grand_total'      => $grandTotal,
                'remaining_amount' => $grandTotal,
            ]);

            if (!$updated) throw new \Exception('Order update failed');

            return [
                'order'            => $order,
                'addons'           => $addonsData,
                'selected_items'   => $selectedItemNames,
                'notes'            => $request->notes,
                'delivery_address' => $request->delivery_address,
                'event_date'       => $request->event_date,
                'event_time'       => $request->event_time,
            ];
        });

        return response()->json([
            'success'        => true,
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

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

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
            'package_group_items' => 'nullable|string',
            'kids_package_id'     => 'nullable|exists:packages,id',
            'kids_count'          => 'nullable|integer|min:10',
            'kids_items'          => 'nullable|string',
        ]);

        $order = Order::findOrFail($id);

        DB::transaction(function () use ($request, $order) {
            $package      = Package::findOrFail($request->package_id);
            $guestCount   = $request->guest_count;
            $packageTotal = $package->price_per_pax * $guestCount;
            $addonTotal   = 0;

            $kidsPackageId    = $request->filled('kids_package_id') ? (int) $request->kids_package_id : null;
            $kidsCount        = $request->filled('kids_count')      ? (int) $request->kids_count      : null;
            $kidsPackageTotal = null;

            if ($kidsPackageId && $kidsCount) {
                $kidsPackage      = Package::findOrFail($kidsPackageId);
                $kidsPackageTotal = $kidsPackage->price_per_pax * $kidsCount;
            }

            // Update main order fields
            $order->update([
                'package_id'         => $package->id,
                'customer_name'      => $request->customer_name,
                'customer_phone'     => '+61' . $request->customer_phone,
                'email'              => $request->email,
                'delivery_address'   => $request->delivery_address,
                'event_date'         => $request->event_date,
                'event_time'         => $request->event_time,
                'guest_count'        => $guestCount,
                'package_price'      => $package->price_per_pax,
                'package_total'      => $packageTotal,
                'notes'              => $request->notes,
                'kids_package_id'    => $kidsPackageId,
                'kids_count'         => $kidsCount,
                'kids_package_total' => $kidsPackageTotal,
            ]);

            // Delete & recreate related records
            OrderPackageSelection::where('order_id', $order->id)->delete();
            OrderAddonItem::where('order_id', $order->id)->delete();
            KidsOrderItem::where('order_id', $order->id)->delete();

            // Recreate package group selections
            if ($request->filled('package_group_items')) {
                $groupSelections = json_decode($request->package_group_items, true);
                if (is_array($groupSelections)) {
                    foreach ($groupSelections as $groupId => $chosenItemName) {
                        $item = DB::table('items')->where('item_name', $chosenItemName)->first();
                        $packageItem = DB::table('package_items')
                            ->where('package_id', $package->id)
                            ->where('group_id', $groupId)
                            ->when($item, fn($q) => $q->where('item_id', $item->id))
                            ->first();
                        OrderPackageSelection::create([
                            'order_id'   => $order->id,
                            'package_id' => $package->id,
                            'group_id'   => $groupId,
                            'item_id'    => $packageItem?->item_id ?? $item?->id,
                        ]);
                    }
                }
            }

            // Recreate kids items
            if ($kidsPackageId && $request->filled('kids_items')) {
                $kidsItemNames = json_decode($request->kids_items, true);
                if (is_array($kidsItemNames)) {
                    foreach ($kidsItemNames as $itemName) {
                        $item = DB::table('items')->where('item_name', $itemName)->first();
                        if ($item) {
                            KidsOrderItem::create(['order_id' => $order->id, 'item_id' => $item->id]);
                        }
                    }
                }
            }

            // Recreate addons
            if ($request->filled('addons')) {
                $addons = json_decode($request->addons, true);
                if (is_array($addons)) {
                    foreach ($addons as $addon) {
                        $quantity = isset($addon['qty']) && is_numeric($addon['qty']) ? max(1, (int) $addon['qty']) : 1;
                        $total = isset($addon['qty']) && is_numeric($addon['qty'])
                            ? $addon['price'] * $quantity
                            : $addon['price'] * $guestCount;
                        OrderAddonItem::create([
                            'order_id'      => $order->id,
                            'item_name'     => $addon['name'],
                            'price_per_pax' => $addon['price'],
                            'guest_count'   => $guestCount,
                            'quantity'      => $quantity,
                            'total_price'   => $total,
                        ]);
                        $addonTotal += $total;
                    }
                }
            }

            // Update totals
            $grandTotal = $packageTotal + $addonTotal + ($kidsPackageTotal ?? 0);
            $order->update([
                'addon_total'      => $addonTotal,
                'grand_total'      => $grandTotal,
                'remaining_amount' => $grandTotal,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
        ]);
    }
}