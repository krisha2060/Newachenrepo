<!DOCTYPE html>
<html>
<head>
    <title>Booking Cancelled</title>
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
            color: #dc3545;
            border-bottom: 2px solid #dc3545;
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
            color: #dc3545;
            width: 100px;
            display: inline-block;
        }
        .contact-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
            border-left: 4px solid #dc3545;
        }
        .contact-box p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px;
            margin: 5px 0;
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
        
        <p style="font-family: 'Cormorant Garamond', serif; font-size: 18px;">Your booking has been <strong style="color: #dc3545;">CANCELLED</strong>.</p>
        
        <h3>Booking Details:</h3>
        <ul>
            <li><strong>Package:</strong> {{ $order->package->package_name ?? 'Custom Package' }}</li>
            <li><strong>Date:</strong> {{ date('F j, Y', strtotime($order->event_date)) }}</li>
            <li><strong>Time:</strong> {{ $order->event_time }}</li>
        </ul>
        
        
        
        <div class="footer">
            <p>We apologize for any inconvenience caused.</p>
            <p style="font-size: 16px;">Newa Chen Family</p>
        </div>
    </div>
</body>
</html>