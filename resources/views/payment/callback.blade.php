<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Callback - Paw and Paws Petmart</title>
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            text-align: center;
            max-width: 450px;
            width: 100%;
        }
        .icon {
            background-color: #ecfdf5;
            color: #10b981;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 24px;
            font-size: 40px;
        }
        h1 {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 12px;
            color: #0f172a;
        }
        p {
            font-size: 15px;
            color: #64748b;
            line-height: 1.6;
            margin: 0 0 32px;
        }
        .reference {
            background-color: #f1f5f9;
            padding: 12px;
            border-radius: 8px;
            font-size: 13px;
            color: #475569;
            margin-bottom: 32px;
            word-break: break-all;
        }
        .reference strong {
            color: #1e293b;
        }
        .button {
            display: inline-block;
            background-color: #3b82f6;
            color: #ffffff;
            font-weight: 600;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 12px;
            transition: all 0.2s ease;
            width: 100%;
            box-sizing: border-box;
        }
        .button:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">✓</div>
        <h1>Payment Processed</h1>
        <p>Your payment details have been received successfully. You can now close this window and return to the app to complete your booking.</p>
        
        @if(request()->has('reference'))
            <div class="reference">
                Reference: <strong>{{ request()->get('reference') }}</strong>
            </div>
        @endif

        <a href="pawlly://" class="button" onclick="window.close();">Return to App</a>
    </div>
</body>
</html>
