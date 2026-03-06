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
        $orders = Order::with(['package', 'addonItems'])->get();
        
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
            
            $menu = [];
            if ($order->addonItems && $order->addonItems->count() > 0) {
                foreach ($order->addonItems as $addon) {
                    $menu[] = $addon->item_name;
                }
            }
            
            $formattedAmount = '$ ' . number_format($order->grand_total, 0);
            
            return [
                'id' => $bookingId,
                'client' => $order->customer_name,
                'email' => $order->email,
                'initials' => $initials,
                'color' => $color,
                'type' => $packageName,            
                'date' => $order->event_date,
                'time' => $order->event_time,
                'guests' => $order->guest_count,
                'venue' => $order->delivery_address,
                'amount' => $formattedAmount,
                'amountRaw' => (int) $order->grand_total,
                'status' => $order->order_status,
                'contact' => $order->customer_phone,
                'bookedOn' => $order->created_at->format('Y-m-d'),
                'notes' => $order->notes,
                'menu' => $menu
            ];
        });
        
        return view('admin.dashboard', compact('bookings'));
    }
     public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        
    }

  
    public function show(string $id)
    {
        
    }

  
    public function edit(string $id)
    {
        
    }

   
    public function update(Request $request, string $id)
    {
        
    }

    
    public function destroy(string $id)
    {
        
    }

public function updateStatus(Request $request)
{
    try {
        $request->validate([
            'booking_id' => 'required',
            'status' => 'required|in:Confirmed,Pending,Cancelled,Payment Done'
        ]);
        
        // Extract numeric ID from BK-0001 format
        $numericId = (int) str_replace('BK-', '', $request->booking_id);
        
        // Find the order - THIS GETS ALL ORDER DATA
        $order = Order::with('package')->find($numericId);  // Load package too
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }
        
        // Save old status and update
        $oldStatus = $order->order_status;
        $order->order_status = $request->status;
        $order->save();
        
        // SEND EMAIL BASED ON STATUS
        if ($request->status == 'Confirmed') {
            
            Mail::to($order->email)->send(new BookingConfirmedMail($order));
        } 
        else if ($request->status == 'Cancelled') {
            
            Mail::to($order->email)->send(new BookingCancelledMail($order));
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully and email sent!'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}
}