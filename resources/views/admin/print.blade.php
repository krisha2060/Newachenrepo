{{-- resources/views/admin/print.blade.php - Professional Invoice/Bill Format --}}
<!DOCTYPE html>
<html>
<head>
    <title>{{ $booking['id'] }} – Invoice</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:#fff; font-family:'DM Sans',Arial,sans-serif; color:#000; padding:20px; }
        .invoice-container { max-width:950px; margin:0 auto; background:#fff; padding:40px; box-shadow:0 0 20px rgba(0,0,0,0.1); }
        .invoice-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px; border-bottom:2px solid #000;}
        .company-info h1 { font-size:32px; color:#000; margin:0 0 5px 0; letter-spacing:-1px; }
        .company-info p { color:#000; font-size:13px; margin:2px 0; }
        .invoice-title { text-align:right; }
        .invoice-title h2 { font-size:28px; color:#000; margin:0; }
        .invoice-number { color:#000; font-size:18px; font-weight:700; margin:5px 0; }
        .invoice-dates { color:#000; font-size:12px; }
        .status-badge { display:inline-block; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; margin-top:8px; background:#e8e8e8; color:#000; border:1px solid #000; }
        .badge-confirmed { background:#e8e8e8; color:#000; border:1px solid #000; }
        .badge-pending { background:#e8e8e8; color:#000; border:1px solid #000; }
        .badge-cancelled { background:#e8e8e8; color:#000; border:1px solid #000; }
        .badge-paymentdone { background:#e8e8e8; color:#000; border:1px solid #000; }
        .badge-infosent { background:#e8e8e8; color:#000; border:1px solid #000; }
        .bill-sections { display:grid; grid-template-columns:1fr 1fr; gap:40px;  }
        .bill-section h3 { font-size:11px; font-weight:700; text-transform:uppercase; color:#000; letter-spacing:1px; margin-bottom:8px; border-bottom:1px solid #000; padding-bottom:5px; }
        .bill-section p { font-size:12px; color:#000; margin:5px 0; line-height:1.6; }
        .bill-section .label { color:#000; font-size:12px; font-weight:600; }
        .items-table { width:100%; border-collapse:collapse; margin-bottom:10px; }
        .items-table thead {  border-bottom:2px solid #000; }
        .items-table th { padding:8px; text-align:left; font-size:12px; font-weight:700; text-transform:uppercase; color:#000; letter-spacing:0.5px; }
        .items-table td { padding:14px 12px; border-bottom:1px solid #000000; font-size:13px; color:#000; }
        .items-table tr:last-child td { border-bottom:none; }
        .invoice-footer { border-top:1px solid #000; padding-top:20px; text-align:center; color:#000; font-size:12px; }
        .payment-notice { color:#000; padding:12px; border-radius:5px; font-size:12px; margin-bottom:15px; border-left:3px solid #000; }
        .print-controls { display:flex; gap:10px; justify-content:flex-end; margin-bottom:20px; padding:0 0 20px 0; }
        .btn { padding:10px 20px; border-radius:5px; border:1px solid #000000; cursor:pointer; font-size:13px; font-weight:600; font-family:'DM Sans',Arial,sans-serif; transition:all 0.2s; }
        .btn-print { background:#000; color:#fff; }
        .btn-print:hover { background:#333; }
        .btn-close { background:#e8e8e8; color:#000; }
        .btn-close:hover { background:#000000; }
        li{margin-bottom:6px;}
        .amountprice{ font-size:12px; color:#000; border-bottom:1px solid #000000; padding-bottom:10px;}
        @media print {
  
    @page {
        margin: 0;
    }
    
    body {
        
        margin-top: 40px;
        padding: 0;
    }

    header, footer {
        display: none;
    }
    
  
    @page {
        size: auto;
        margin: 0.5cm;
    }
}
        @media print { body { background:#fff; padding:0; } .invoice-container { box-shadow:none; padding:0; } .print-controls { display:none; } .invoice-container { max-width:100%; } }
    </style>
</head>
<body>
    @php
        // show_amount: default true; pass ?show_amount=0 to hide amounts
        $showAmount = request('show_amount', '1') !== '0';
    @endphp

    <div class="print-controls">
        <button class="btn btn-close" onclick="window.close()"><i class="bi bi-x-lg"></i> Close</button>
        <button class="btn btn-print" onclick="window.print()"><i class="bi bi-printer"></i> Print</button>
    </div>

    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h3>NewaChen</h3>
            </div>
            <div class="invoice-title">
                <div class="invoice-number">{{ $booking['id'] }}</div>
                <!-- <div class="invoice-dates">
                    <div><strong>Event Date:</strong> {{ date('M d, Y', strtotime($booking['date'])) }}</div>
                </div>
                @php
                    $badgeClass = match($booking['status']) {
                        'Confirmed'    => 'badge-confirmed',
                        'Pending'      => 'badge-pending',
                        'Cancelled'    => 'badge-cancelled',
                        'Payment Done' => 'badge-paymentdone',
                        'Info Sent'    => 'badge-infosent',
                        default        => ''
                    };
                @endphp
                <div class="status-badge {{ $badgeClass }}">{{ $booking['status'] }}</div> -->
            </div>
        </div>

        <!-- Bill To Section -->
        <div class="bill-sections">
            <div class="bill-section">
                <p><strong>Name:</strong> <strong>{{ $booking['client'] }}</strong></p>
                <p><strong>Contact:</strong>
                {{ $booking['contact'] }}</p>
                <!-- @if(isset($booking['email']))
                <p class="label"><strong>Email:</strong>
                {{ $booking['email'] }}</p>
                @endif -->
                <p><strong>Address:</strong>
                {{ $booking['venue'] }}</p>
                <p><strong>Package:</strong> {{ $booking['package'] }}</p>
            </div>
            <div class="bill-section">
                <!-- <h3>Event Details</h3> -->
                <p><strong>Date:</strong> {{ date('l, F j, Y', strtotime($booking['date'])) }}</p>
                <p><strong>Time:</strong> {{ $booking['time'] ?? '—' }}</p>
                <p><strong>Guest Count:</strong> {{ $booking['guests'] }} {{ $booking['guests'] == 1 ? 'guest' : 'guests' }}</p>
                
                @if(isset($booking['kids_count']) && $booking['kids_count'] > 0)
                    <p><strong>Kids Count:</strong> {{ $booking['kids_count'] }}</p>
                @endif
            </div>
            
        </div>
          @if($showAmount)

    
                <div class="amountprice" style="margin-top:20px; border-top:1px solid #000000; padding-top:15px;">
                    <div style="display:flex; justify-content:space-between; margin-top:5px;">
                       <strong>Item Total:</strong>
                        <span>${{ number_format($booking['amountRaw'], 2) }}</span>
                    </div>
                    @if(isset($booking['delivery_charge']) && $booking['delivery_charge'] > 0)
                    <div style="display:flex; justify-content:space-between; margin-top:5px;">
                        <strong>Delivery Charge: </strong>
                        <span>+${{ number_format($booking['delivery_charge'], 2) }}</span>
                    </div>
                    @endif
                    <div style="display:flex; justify-content:space-between;background:#e8e8e8; border-radius:5px; margin-top:5px;">
                        <strong>Total Amount: </strong>
                        <strong>${{ number_format($booking['amountRaw'] + ($booking['delivery_charge'] ?? 0), 2) }}</strong>
                    </div>
                    @if(isset($booking['advance_amount']) && $booking['advance_amount'] > 0)
                    <div style="display:flex; justify-content:space-between; margin-top:5px;">
                        <strong>Advance Paid:</strong>
                        <span>${{ number_format($booking['advance_amount'], 2) }}</span>
                    </div>
                    @endif
                    @if(isset($booking['remaining_amount']) && $booking['remaining_amount'] > 0  && $booking['advance_amount'] > 0)
                    <div style="display:flex; justify-content:space-between; margin-top:5px;">
                        <strong>Remaining Balance: </strong>
                        <span>${{ number_format($booking['remaining_amount'], 2) }}</span>
                    </div>
                    @endif
                </div>
                
@endif
        <!-- Items Table -->
        <table class="items-table">
            <thead>
                
                <tr>
                <h4 style="margin-top:20px; margin-bottom: 3px;"><i class="bi bi-list-ul"></i> Order Items</h4>
                    <!-- <th>Items</th> -->
                    @if($showAmount)
                    <!-- <th style="text-align:right;width:120px">Amount</th> -->
                    @endif
                </tr>
            </thead>
            <tbody>
    

<div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px; margin-top:10px;">

    <!-- Main Package -->
    <div style="padding:15px;">
        <h5 style="margin-bottom:10px; border-bottom:1px solid #000000; padding-bottom:5px;">
            <i class="bi bi-egg-fried"></i> Main Item
        </h5>

        @if(!empty($booking['menu1']))
            <p style="font-weight:700; margin-bottom:8px;">
                {{ $booking['package'] }}
                @if($showAmount)
                    (${{ isset($booking['package_price']) ? number_format($booking['package_price'], 2) : '0.00' }})
                @endif
            </p>

         <ol style="font-size:16px; line-height:1.6; margin-bottom:8px; padding-left:18px;">
    @if(is_array($booking['menu1']))
        @foreach($booking['menu1'] as $menuItem)
            <li>{{ $menuItem }}</li>
        @endforeach
    @else
        <li>{{ $booking['menu1'] }}</li>
    @endif
</ol>
        @endif
    </div>

    <!-- Add-ons -->
    <div style="padding:15px;">
        <h5 style="margin-bottom:10px; border-bottom:1px solid #000000; padding-bottom:5px;">
            <i class="bi bi-plus-circle"></i> Add-ons
        </h5>

      @if(!empty($booking['menu']))
 <ol style="padding-left:20px; font-size:16px;">
    @foreach($booking['menu'] as $item)
        <li style="padding-bottom:6px;">
    <div style="display:flex; align-items:flex-start; {{ $showAmount ? 'justify-content:space-between;' : '' }}">

        <span style="word-break:break-word; {{ $showAmount ? 'max-width:75%;' : 'width:100%;' }}">
            {{ is_array($item) ? $item['name'] : $item }}
        </span>

        @if($showAmount)
            <span style="font-size:14px; white-space:nowrap; margin-left:10px;">
                ${{ is_array($item) && isset($item['price']) ? number_format($item['price'], 2) : '0.00' }}
            </span>
        @endif

    </div>
</li>
    @endforeach
</ol>
@else
    <p style="font-size:13px;">No add-ons</p>
@endif
    </div>

    <!-- Kids Items -->
    <div style="padding:15px;">
        <h5 style="margin-bottom:8px; border-bottom:1px solid #000000; padding-bottom:5px;">
            <i class="bi bi-emoji-smile"></i> Kids Items
        </h5>

        @if(!empty($booking['kids_items']))
            <p style="font-weight:700; margin-bottom:8px;">
                {{ $booking['kids_count'] ?? 0 }} Kids
                @if($showAmount)
                    ( ${{ isset($booking['kids_price']) ? number_format($booking['kids_price'], 2) : '0.00' }})
                @endif
            </p>

           <ol style="font-size:16px; line-height:1.6; padding-left:18px;">
    @if(is_array($booking['kids_items']))
        @foreach($booking['kids_items'] as $kidsItem)
            <li>{{ $kidsItem }}</li>
        @endforeach
    @else
        <li>{{ $booking['kids_items'] }}</li>
    @endif
</ol>
        @else
            <p style="font-size:13px;">No kids items</p>
        @endif
    </div>

</div>
             

            </tbody>
        </table>

        <!-- Special Notes -->
        @if(!empty($booking['notes']))
            <div style=";padding:15px;border-radius:5px;margin-bottom:30px;border-left:3px solid #000;">
            
                <p style="margin-top:8px;font-size:13px;line-height:1.6;">    <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;">Special Notes: </strong>{{ $booking['notes'] }}</p>
            </div>
        @endif

        <!-- Payment Status -->
        <!-- @if($booking['status'] === 'Payment Done')
            <div class="payment-notice">
                <i class="bi bi-check-circle"></i> <strong>Payment Received</strong> - Invoice fully paid
            </div>
        @elseif($booking['status'] === 'Pending')
            <div class="payment-notice">
                <i class="bi bi-exclamation-circle"></i> <strong>Pending</strong> - Awaiting confirmation
            </div>
        @endif -->

        <!-- Footer -->
        <!-- <div class="invoice-footer">
            <p><strong>Thank you for choosing NewaChen!</strong></p>
            <p>For any inquiries, please contact us at newa.catering.sydney@gmail.com or call +61 451 211 959</p>
            <p style="margin-top:15px;font-size:11px;">This is a computer-generated invoice. No signature is required.</p>
        </div> -->
    </div>
    <script>
    
        window.onload = function() {
        window.print();
    };
        window.onafterprint = function() {
        window.close();
    };
</script>
</body>
</html>
