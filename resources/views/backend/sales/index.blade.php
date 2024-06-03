@extends('backend.layouts.master')

@section('main-content')
<div class="card">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <h5 class="card-header">Sales Report
        <a href="{{ route('sales.pdf') }}" id="downloadPdf" class="btn btn-primary btn-sm shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
    </h5>

    <div class="card-body">
        <div class="content-header-right">
            <section class="content">
                <div class="container" style="padding-left: 0px; padding-right: 0px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div>
                                    <!-- Filter by dropdown -->
                                    <div class="form-group">
                                        <label for="filter">Filter by:</label>
                                        <select id="filter" class="form-control">
                                            <option value="all">All</option>
                                            <option value="year">Year</option>
                                            <option value="month">Month</option>
                                        </select>
                                    </div>

                                    <!-- Year dropdown -->
                                    <div class="form-group" id="yearFilter" style="display: none;">
                                        <label for="year">Year:</label>
                                        <select id="year" class="form-control">
                                            @php
                                                $currentYear = date("Y");
                                                for ($i = $currentYear; $i >= 2000; $i--) {
                                                    echo "<option value='$i'>$i</option>";
                                                }
                                            @endphp
                                        </select>
                                    </div>

                                    <!-- Month dropdown -->
                                    <div class="form-group" id="monthFilter" style="display: none;">
                                        <label for="month">Month:</label>
                                        <select id="month" class="form-control">
                                            @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                                <option value="{{ $month }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="selectedMonthYear" style="margin-top: 10px; display: none; background-color: rgb(255, 255, 255); padding: 5px;">
                                        <strong>Selected Month:</strong> <span id="selectedMonth"></span><br>
                                        <strong>Selected Year:</strong> <span id="selectedYear"></span>
                                    </div>

                                    <div class="row">
                                        <!-- Delivered and Paid Orders Table -->
                                        <div class="col-md-6">
                                            <h5 class="mt-4">Delivered and Paid Orders</h5>
                                            <table id="salesTable" class="table table-bordered table-hover table-striped">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Amount</th>
                                                        <th>Payment Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="salesTableBody">
                                                    @if($deliveredAndPaidOrders->count() > 0)
                                                        @foreach($deliveredAndPaidOrders as $order)
                                                            <tr>
                                                                <td>{{ $order->order_number }}</td>
                                                                <td>{{ $order->total_amount }}</td>
                                                                <td>{{ date('F j, Y h:i A', strtotime($order->created_at)) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan='3' class='text-center'>No payments found.</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Cancelled and Unpaid Orders Table -->
                                        <div class="col-md-6">
                                            <h5 class="mt-4">Cancelled and Unpaid Orders</h5>
                                            <table id="cancelledTable" class="table table-bordered table-hover table-striped">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Amount</th>
                                                        <th>Order Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="cancelledTableBody">
                                                    @if($cancelAndUnpaidOrders->count() > 0)
                                                        @foreach($cancelAndUnpaidOrders as $order)
                                                            <tr>
                                                                <td>{{ $order->order_number }}</td>
                                                                <td>{{ $order->total_amount }}</td>
                                                                <td>{{ date('F j, Y h:i A', strtotime($order->created_at)) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan='3' class='text-center'>No cancelled or unpaid orders found.</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <script>
                                        const orders = @json($orders);

                                        document.getElementById('filter').addEventListener('change', function () {
                                            var filterValue = this.value;
                                            document.getElementById('yearFilter').style.display = 'none';
                                            document.getElementById('monthFilter').style.display = 'none';
                                            document.getElementById('selectedMonthYear').style.display = 'none';

                                            if (filterValue === 'year') {
                                                document.getElementById('yearFilter').style.display = 'block';
                                            } else if (filterValue === 'month') {
                                                document.getElementById('monthFilter').style.display = 'block';
                                                document.getElementById('yearFilter').style.display = 'block';
                                            } else {
                                                displayOrders(orders.filter(order => order.status === 'delivered' && order.payment_status === 'paid'), 'salesTableBody');
                                                displayOrders(orders.filter(order => order.status === 'cancel' && order.payment_status === 'unpaid'), 'cancelledTableBody');
                                                updatePdfLink(); // Update PDF link without parameters
                                            }
                                        });

                                        document.getElementById('year').addEventListener('change', filterOrders);
                                        document.getElementById('month').addEventListener('change', filterOrders);

                                        function updatePdfLink(year, month) {
                                            let url = '{{ route("sales.pdf") }}';
                                            if (year && month) {
                                                url += `?year=${year}&month=${month}`;
                                            }
                                            document.getElementById('downloadPdf').href = url;
                                        }

                                        function filterOrders() {
                                            var selectedYear = document.getElementById('year').value;
                                            var selectedMonth = document.getElementById('month').value;

                                            if (selectedYear && selectedMonth) {
                                                document.getElementById('selectedYear').innerText = selectedYear;
                                                document.getElementById('selectedMonth').innerText = selectedMonth;
                                                document.getElementById('selectedMonthYear').style.display = 'block';

                                                const filteredDeliveredOrders = orders.filter(order => {
                                                    const orderDate = new Date(order.created_at);
                                                    return orderDate.getFullYear() == selectedYear && orderDate.toLocaleString('default', { month: 'long' }) == selectedMonth && order.status === 'delivered' && order.payment_status === 'paid';
                                                });

                                                const filteredCancelledOrders = orders.filter(order => {
                                                    const orderDate = new Date(order.created_at);
                                                    return orderDate.getFullYear() == selectedYear && orderDate.toLocaleString('default', { month: 'long' }) == selectedMonth && order.status === 'cancel' && order.payment_status === 'unpaid';
                                                });

                                                displayOrders(filteredDeliveredOrders, 'salesTableBody');
                                                displayOrders(filteredCancelledOrders, 'cancelledTableBody');
                                                updatePdfLink(selectedYear, selectedMonth); // Update PDF link with filtered parameters
                                            }
                                        }

                                        function displayOrders(filteredOrders, tableBodyId) {
                                            const tableBody = document.getElementById(tableBodyId);
                                            tableBody.innerHTML = ''; // Clear the table

                                            if (filteredOrders.length > 0) {
                                                filteredOrders.forEach(order => {
                                                    const row = document.createElement('tr');
                                                    row.innerHTML = `
                                                        <td>${order.order_number}</td>
                                                        <td>${order.total_amount}</td>
                                                        <td>${new Date(order.created_at).toLocaleString('en-US', { month: 'long', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true })}</td>
                                                    `;
                                                    tableBody.appendChild(row);
                                                });
                                            } else {
                                                const row = document.createElement('tr');
                                                row.innerHTML = `<td colspan='3' class='text-center'>No orders found.</td>`;
                                                tableBody.appendChild(row);
                                            }
                                        }

                                        // Initial display of all orders
                                        displayOrders(orders.filter(order => order.status === 'delivered' && order.payment_status === 'paid'), 'salesTableBody');
                                        displayOrders(orders.filter(order => order.status === 'cancel' && order.payment_status === 'unpaid'), 'cancelledTableBody');
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
