<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmed</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cormorant Garamond', serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            color: #28a745;
            border-bottom: 2px solid #28a745;
            padding-bottom: 10px;
            font-size: 28px;
        }
        h3 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            color: #555;
            margin-top: 25px;
            font-size: 22px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        li strong {
            font-weight: 600;
            color: #28a745;
            width: 100px;
            display: inline-block;
        }
        .addons {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .addons li {
            border-bottom: none;
            padding: 5px 0;
            font-size: 17px;
        }
        .addons li:before {
            content: "•";
            color: #28a745;
            font-weight: bold;
            display: inline-block;
            width: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dear {{ $order->customer_name }},</h1>
        
        <p style="font-family: 'Cormorant Garamond', serif; font-size: 18px;">Your booking has been <strong style="color: #28a745;">CONFIRMED</strong>!</p>
        
        <h3>Booking Details:</h3>
        <ul>
            <li><strong>Package:</strong> {{ $order->package->package_name ?? 'Custom Package' }}</li>
            <li><strong>Date:</strong> {{ date('F j, Y', strtotime($order->event_date)) }}</li>
            <li><strong>Time:</strong> {{ $order->event_time }}</li>
            <li><strong>Guests:</strong> {{ $order->guest_count }}</li>
            <li><strong>Venue:</strong> {{ $order->delivery_address }}</li>
            <li><strong>Total:</strong> ${{ number_format($order->grand_total, 2) }}</li>
        </ul>
        
        @if($order->addonItems && $order->addonItems->count() > 0)
            <h3>Addons Selected:</h3>
            <div class="addons">
                <ul>
                    @foreach($order->addonItems as $addon)
                        <li>{{ $addon->item_name }} @if($addon->price) (${{ number_format($addon->price, 2) }}) @endif</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="footer">
            <p>Thank you for choosing Newa Chen!</p>
            <p style="font-size: 16px;">We look forward to serving you</p>
        </div>
    </div>
</body>
</html>