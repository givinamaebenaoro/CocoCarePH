<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .header img {
            width: 100px;
            height: auto;
        }
        .header .center-text {
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }
        .header .center-text h1 {
            margin: 0;
            font-size: 1.5em;
        }
        .header .center-text p {
            margin: 5px 0;
            font-size: 1em;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .report-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.3em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.9em;
            color: #777;
        }
        .signature {
            margin-top: 40px;
            text-align: right;
            padding-right: 20px;
        }
        .date {
            margin-top: 20px;
            text-align: right;
            padding-right: 20px;
        }
        .totals-row {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('backend/img/3.png') }}" alt="Your Image" class="eco-image">
        <div class="center-text">
            <h1>CocoCare PH | CocoCocoTribe</h1>
            <p>Street B, 832 S. Marquez, Las Pinas 1745 Metro Manila, Philippines</p>
            <p>Contact No: 09995897887 | Email: phcococare@gmail.com</p>
        </div>
        <img src="{{ public_path('backend/img/2.png') }}" alt="Your Image" class="eco-image" style="order: 4;">
    </div>

    <div class="report-title">
        Sales Report
        @if(request()->has('year') && request()->has('month'))
            <br>({{ request('month') }} {{ request('year') }})
        @endif
    </div>

    <h2>Delivered and Paid Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php $totalDelivered = 0; @endphp
            @foreach($orders as $order)
                @if($order->status == 'delivered' && $order->payment_status == 'paid')
                    @php $totalDelivered += $order->total_amount; @endphp
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                        <td>{{ date('F j, Y h:i A', strtotime($order->created_at)) }}</td>
                        <td>P {{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                @endif
            @endforeach
            <tr class="totals-row">
                <td colspan="4" style="text-align: right;">Total Amount : P {{ number_format($totalDelivered, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <h2>Cancelled and Unpaid Orders</h2>
    <table>
        <thead>
            <tr>
                <th>Order Number</th>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php $totalCancelled = 0; @endphp
            @foreach($orders as $order)
                @if($order->status == 'cancel' && $order->payment_status == 'unpaid')
                    @php $totalCancelled += $order->total_amount; @endphp
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                        <td>{{ date('F j, Y h:i A', strtotime($order->created_at)) }}</td>
                        <td>P {{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                @endif
            @endforeach
            <tr class="totals-row">
                <td colspan="4" style="text-align: right;">Total Amount: P {{ number_format($totalCancelled, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="date">
        Date: {{ date('F j, Y') }}
    </div>

    <div class="signature">
        {{-- Administration Name: {{ $generatedBy }}<br> --}}
        __________________________
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} CocoCarePH. All rights reserved.
    </div>
</body>
</html>
