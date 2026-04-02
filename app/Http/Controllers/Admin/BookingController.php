<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Mail\BookingConfirmedMail;           
use App\Mail\BookingCancelledMail; 
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'package',
            'addonItems',
            'ItemsList.item',
            'kidsPackage',           
            'kidsOrderItems.item',  
        ])->get();
        
        $bookings = $orders->map(function($order) {
            
            $bookingId = 'BK-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
            
            $nameParts = explode(' ', $order->customer_name);
            $initials = '';
            foreach ($nameParts as $part) {
                if (!empty($part)) {
                    $initials .= strtoupper(substr($part, 0, 1));
                }
            }
            $initials = substr($initials, 0, 2);
            
            $colors = ['#7c3aed', '#0891b2', '#be185d', '#d97706', '#059669', '#dc2626'];
            $color = $colors[$order->id % count($colors)];
            
            $packageName = $order->package ? $order->package->package_name : 'Custom Package';
            
            // ── Addons ────────────────────────────────────────
            $menu = [];
            if ($order->addonItems && $order->addonItems->count() > 0) {
                foreach ($order->addonItems as $addon) {
                    $menu[] = $addon->item_name;
                }
            }

            // ── Main package selected items ───────────────────
            $menu1 = [];
            foreach ($order->ItemsList as $sel) {
                if ($sel->item) {
                    $menu1[] = $sel->item->item_name;
                }
            }

            // ── Kids items ────────────────────────────────────
            $kidsItems = $order->kidsOrderItems
                ->map(fn($k) => $k->item?->item_name)
                ->filter()
                ->values()
                ->toArray();

                
            
            $formattedAmount = '$ ' . number_format($order->grand_total, 0);
            
            return [
                'id'                 => $bookingId,
                'client'             => $order->customer_name,
                'email'              => $order->email,
                'initials'           => $initials,
                'color'              => $color,
                'type'               => $packageName,            
                'date'               => $order->event_date,
                'time'               => $order->event_time,
                'guests'             => $order->guest_count,
                'venue'              => $order->delivery_address,
                'amount'             => $formattedAmount,
                'amountRaw'          => (int) $order->grand_total,
                'status'             => $order->order_status,
                'contact'            => $order->customer_phone,
                'bookedOn'           => $order->created_at->format('Y-m-d'),
                'notes'              => $order->notes,
                'menu'               => $menu,
                'menu1'              => $menu1,
                'advance_amount'     => (float) $order->advance_amount,      
                'remaining_amount'   => (float) $order->remaining_amount,
                'delivery_charge'    => (float) $order->delivery_charge,  
                // ── kids ──────────────────────────────────────
                'kids_package_name'  => $order->kidsPackage?->package_name,
                'kids_count'         => $order->kids_count,
                'kids_package_total' => $order->kids_package_total,
                'kids_items'         => $kidsItems,
            ];
        });
        
        return view('admin.dashboard', compact('bookings'));
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}

     public function updateStatus(Request $request)
{
    try {
        $request->validate([
            'booking_id' => 'required',
            'status'     => 'required|in:Confirmed,Pending,Cancelled,Payment Done,Info Sent'  
        ]);
        
        $numericId = (int) str_replace('BK-', '', $request->booking_id);
        $order     = Order::with('package')->find($numericId);
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }
        
        $oldStatus           = $order->order_status;
        $order->order_status = $request->status;

        if ($request->has('advance_amount')) {
            $order->advance_amount   = $request->advance_amount;
            $order->remaining_amount = $request->remaining_amount;
        }

        if ($request->has('remaining_amount') && !$request->has('advance_amount')) {
            $order->remaining_amount = $request->remaining_amount;
        }

        // ← save delivery charge when Info Sent
        if ($request->has('delivery_charge')) {
            $order->delivery_charge = $request->delivery_charge;
        }

        $order->save();
        
        if ($request->status == 'Confirmed') {
            Mail::to($order->email)->send(new BookingConfirmedMail($order));
        } else if ($request->status == 'Cancelled') {
            Mail::to($order->email)->send(new BookingCancelledMail($order));
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
}