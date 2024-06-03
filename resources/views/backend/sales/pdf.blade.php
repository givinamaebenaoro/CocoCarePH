<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
}

.header {
    text-align: center;
    margin: 20px 0;
}

.header img {
    width: 100%;
    max-width: 500px;
    height: auto;
}

.report-title {
    text-align: center;
    font-size: 1.3em;
    margin: 20px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    border: 1px solid #3b3b3b;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #007c02;
    color: #f1f1f1;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

.totals-row {
    font-weight: bold;
    text-align: right;
}

.footer {
    text-align: center;
    margin-top: 40px;
    font-size: 0.9em;
    color: #777;
}

.signature-container {
    display: flex;
    justify-content: space-between;
    margin-top: 40px;
    padding: 0 20px;
}

.signature, .signature1 {
    font-weight: bold;
    text-align: right;
}

.signature1 {
    text-align: left;
}

.date {
    font-size: 15px;
    font-weight: 500;
    margin-top: 0;
    text-align: right;
    padding-right: 20px;
}
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('backend/img/CocoCare.png') }}" alt="Your Image" class="eco-image">
    </div>

    <div class="report-title">
        <h2>Sales Report</h2>
        @if(request()->has('year') && request()->has('month'))
            <br>({{ request('month') }} {{ request('year') }})
        @endif
    </div>

    <h3>Delivered and Paid Orders</h3>
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

    <h4>Cancelled and Unpaid Orders</h4>
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
       Generated Date: {{ date('F j, Y') }}
    </div>
    <div class="signature1">
        ______________________<br>
        Owner Name:<br>
         Daniel Panida
    </div>
    <div class="signature">
        ______________________<br>
        Administration Name:<br>
         {{ $generatedBy }}
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} CocoCarePH. All rights reserved.
    </div>
</body>
</html>
