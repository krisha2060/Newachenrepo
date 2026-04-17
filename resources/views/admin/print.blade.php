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
        .invoice-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:40px; border-bottom:2px solid #000; padding-bottom:20px; }
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
        .bill-sections { display:grid; grid-template-columns:1fr 1fr; gap:40px; margin-bottom:40px; }
        .bill-section h3 { font-size:11px; font-weight:700; text-transform:uppercase; color:#000; letter-spacing:1px; margin-bottom:12px; border-bottom:1px solid #000; padding-bottom:8px; }
        .bill-section p { font-size:14px; color:#000; margin:5px 0; line-height:1.6; }
        .bill-section .label { color:#000; font-size:12px; font-weight:600; }
        .items-table { width:100%; border-collapse:collapse; margin-bottom:30px; }
        .items-table thead { background:#e8e8e8; border-bottom:2px solid #000; }
        .items-table th { padding:12px; text-align:left; font-size:12px; font-weight:700; text-transform:uppercase; color:#000; letter-spacing:0.5px; }
        .items-table td { padding:14px 12px; border-bottom:1px solid #000; font-size:13px; color:#000; }
        .items-table tr:last-child td { border-bottom:none; }
        .invoice-footer { border-top:1px solid #000; padding-top:20px; text-align:center; color:#000; font-size:12px; }
        .payment-notice { background:#e8e8e8; color:#000; padding:12px; border-radius:5px; font-size:12px; margin-bottom:15px; border-left:3px solid #000; }
        .print-controls { display:flex; gap:10px; justify-content:flex-end; margin-bottom:20px; padding:0 0 20px 0; }
        .btn { padding:10px 20px; border-radius:5px; border:1px solid #000; cursor:pointer; font-size:13px; font-weight:600; font-family:'DM Sans',Arial,sans-serif; transition:all 0.2s; }
        .btn-print { background:#000; color:#fff; }
        .btn-print:hover { background:#333; }
        .btn-close { background:#e8e8e8; color:#000; }
        .btn-close:hover { background:#ccc; }
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
        <button class="btn btn-print" onclick="window.print()"><i class="bi bi-printer"></i> Print Invoice</button>
    </div>

    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1>NewaChen</h1>
                <p><strong>Catering Services</strong></p>
                <p>Email: newa.catering.sydney@gmail.com</p>
                <p>Phone: +61 451 211 959</p>
            </div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <div class="invoice-number">{{ $booking['id'] }}</div>
                <div class="invoice-dates">
                    <div><strong>Invoice Date:</strong> {{ $booking['created_at'] }}</div>
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
                <div class="status-badge {{ $badgeClass }}">{{ $booking['status'] }}</div>
            </div>
        </div>

        <!-- Bill To Section -->
        <div class="bill-sections">
            <div class="bill-section">
                <h3>Bill To</h3>
                <p><strong>{{ $booking['client'] }}</strong></p>
                <p class="label">Contact:</p>
                <p>{{ $booking['contact'] }}</p>
                @if(isset($booking['email']))
                <p class="label">Email:</p>
                <p>{{ $booking['email'] }}</p>
                @endif
                <p class="label">Delivery Address:</p>
                <p>{{ $booking['venue'] }}</p>
            </div>
            <div class="bill-section">
                <h3>Event Details</h3>
                <p><strong>Date:</strong> {{ date('l, F j, Y', strtotime($booking['date'])) }}</p>
                <p><strong>Time:</strong> {{ $booking['time'] ?? '—' }}</p>
                <p><strong>Guest Count:</strong> {{ $booking['guests'] }} {{ $booking['guests'] == 1 ? 'guest' : 'guests' }}</p>
                <p><strong>Package:</strong> {{ $booking['package'] }}</p>
                @if(isset($booking['kids_count']) && $booking['kids_count'] > 0)
                    <p><strong>Kids Count:</strong> {{ $booking['kids_count'] }}</p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    @if($showAmount)
                    <th style="text-align:right;width:120px">Amount</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <!-- Main Package Items -->
                @if(!empty($booking['menu1']))
                    <tr>
                        <td style="font-weight:700;"><i class="bi bi-egg-fried"></i> {{ $booking['package'] }}</td>
                        @if($showAmount)
                        <td style="text-align:right;font-weight:700;">${{ isset($booking['package_price']) ? number_format($booking['package_price'], 2) : '0.00' }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td style="padding-left:30px;font-size:12px;" @if(!$showAmount) colspan="1" @endif>{{ implode(', ', $booking['menu1']) }}</td>
                        @if($showAmount)
                        <td style="text-align:right;"></td>
                        @endif
                    </tr>
                @endif

                <!-- Add-on Items -->
                @if(!empty($booking['menu']))
                    <tr>
                        <td colspan="{{ $showAmount ? 2 : 1 }}" style="font-weight:700;background:#e8e8e8;padding:10px 12px;border-bottom:1px solid #000;">
                            <i class="bi bi-plus-circle"></i> Add-on Items
                        </td>
                    </tr>
                    @foreach($booking['menu'] as $item)
                        <tr>
                            <td style="padding-left:30px;">{{ is_array($item) ? $item['name'] : $item }}</td>
                            @if($showAmount)
                            <td style="text-align:right;font-weight:600;">${{ is_array($item) && isset($item['price']) ? number_format($item['price'], 2) : '0.00' }}</td>
                            @endif
                        </tr>
                    @endforeach
                @endif

                <!-- Kids Package Items -->
                @if(!empty($booking['kids_items']))
                    <tr>
                        <td style="font-weight:700;"><i class="bi bi-emoji-smile"></i> Kids Package ({{ $booking['kids_count'] }} kids)</td>
                        @if($showAmount)
                        <td style="text-align:right;font-weight:700;">${{ isset($booking['kids_price']) ? number_format($booking['kids_price'], 2) : '0.00' }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td style="padding-left:30px;font-size:12px;">{{ implode(', ', $booking['kids_items']) }}</td>
                        @if($showAmount)
                        <td style="text-align:right;"></td>
                        @endif
                    </tr>
                @endif

                @if($showAmount)
                <!-- Charges Summary -->
                <tr style="background:#e8e8e8;border-top:1px solid #000;">
                    <td colspan="2" style="padding:14px 12px;font-weight:600;border:none;"></td>
                </tr>
                <tr>
                    <td><strong>Subtotal</strong></td>
                    <td style="text-align:right;font-weight:600;">${{ number_format($booking['amountRaw'], 2) }}</td>
                </tr>
                @if(isset($booking['delivery_charge']) && $booking['delivery_charge'] > 0)
                    <tr>
                        <td>Delivery Charge</td>
                        <td style="text-align:right;">+${{ number_format($booking['delivery_charge'], 2) }}</td>
                    </tr>
                @endif
                <tr style="background:#e8e8e8;border-top:1px solid #000;border-bottom:2px solid #000;">
                    <td style="font-weight:700;">TOTAL AMOUNT DUE</td>
                    <td style="text-align:right;font-weight:700;font-size:18px;">${{ number_format($booking['amountRaw'] + ($booking['delivery_charge'] ?? 0), 2) }}</td>
                </tr>
                @if(isset($booking['advance_amount']) && $booking['advance_amount'] > 0)
                    <tr>
                        <td><strong>Advance Paid</strong></td>
                        <td style="text-align:right;font-weight:600;">${{ number_format($booking['advance_amount'], 2) }}</td>
                    </tr>
                @endif
                @if(isset($booking['remaining_amount']) && $booking['remaining_amount'] > 0)
                    <tr>
                        <td><strong>Remaining Balance</strong></td>
                        <td style="text-align:right;font-weight:700;">${{ number_format($booking['remaining_amount'], 2) }}</td>
                    </tr>
                @endif
                @endif {{-- end showAmount --}}
            </tbody>
        </table>

        <!-- Special Notes -->
        @if(!empty($booking['notes']))
            <div style="background:#e8e8e8;padding:15px;border-radius:5px;margin-bottom:30px;border-left:3px solid #000;">
                <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;">Special Notes</strong>
                <p style="margin-top:8px;font-size:13px;line-height:1.6;">{{ $booking['notes'] }}</p>
            </div>
        @endif

        <!-- Payment Status -->
        @if($booking['status'] === 'Payment Done')
            <div class="payment-notice">
                <i class="bi bi-check-circle"></i> <strong>Payment Received</strong> - Invoice fully paid
            </div>
        @elseif($booking['status'] === 'Pending')
            <div class="payment-notice">
                <i class="bi bi-exclamation-circle"></i> <strong>Pending</strong> - Awaiting confirmation
            </div>
        @endif

        <!-- Footer -->
        <div class="invoice-footer">
            <p><strong>Thank you for choosing NewaChen!</strong></p>
            <p>For any inquiries, please contact us at newa.catering.sydney@gmail.com or call +61 451 211 959</p>
            <p style="margin-top:15px;font-size:11px;">This is a computer-generated invoice. No signature is required.</p>
        </div>
    </div>
</body>
</html>