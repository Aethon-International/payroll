<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;

        }

        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            font-size: 12px;
            color: #888;
        }
        .content {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Salary Slip</h1>
        </div>

        <div class="content">
            <p>Dear {{ $employee->name }},</p>
            <p>Please find attached your salary slip for {{ $payroll_period->month }} {{ $payroll_period->year }}.</p>
            <p>Thank you for your continued hard work at Aethon.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Aethon. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
