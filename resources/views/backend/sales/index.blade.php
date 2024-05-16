@extends('backend.layouts.master')

@section('main-content')
<div class="card">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <h5 class="card-header">Sales Report
        <a href="#" id="downloadCsv" class="btn btn-primary btn-sm shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i>Generate CSV</a>
    </h5>

    <div class="card-body">
        <div class="content-header-right">
            <section class="content">
                <div class="container" style="padding-left: 0px; padding-right: 0px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-body table-responsive">
                                    <!-- Filter by dropdown -->
                                    <div class="form-group">
                                        <label for="filter">Filter by:</label>
                                        <select id="filter" class="form-control">
                                            <option value="all">All</option>
                                            <option value="year">Year</option>
                                            <option value="month">Month</option>
                                            <option value="day">Day</option>
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
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                    </div>

                                    <!-- Display selected month and year -->
                                    <div id="selectedMonthYear" style="margin-top: 10px; display: none; background-color: rgb(255, 255, 255); padding: 5px;">
                                        <strong>Selected Month:</strong> <span id="selectedMonth"></span><br>
                                        <strong>Selected Year:</strong> <span id="selectedYear"></span>
                                    </div>

                                    <table id="salesTable" class="table table-bordered table-hover table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Amount</th>
                                                <th>Payment Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="salesTableBody">
                                            @if($orders->count() > 0)
                                                @foreach($orders as $order)
                                                    <tr>
                                                        <td>{{ $order->id }}</td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
            } else if (filterValue === 'day') {
                // Additional logic for day filter can be implemented here
            } else {
                displayOrders(orders);
                updateCsvLink(); // Update CSV link without parameters
            }
        });

        document.getElementById('year').addEventListener('change', filterOrders);
        document.getElementById('month').addEventListener('change', filterOrders);

        function filterOrders() {
            var selectedYear = document.getElementById('year').value;
            var selectedMonth = document.getElementById('month').value;

            if (selectedYear && selectedMonth) {
                document.getElementById('selectedYear').innerText = selectedYear;
                document.getElementById('selectedMonth').innerText = selectedMonth;
                document.getElementById('selectedMonthYear').style.display = 'block';

                const filteredOrders = orders.filter(order => {
                    const orderDate = new Date(order.created_at);
                    return orderDate.getFullYear() == selectedYear && orderDate.toLocaleString('default', { month: 'long' }) == selectedMonth;
                });

                displayOrders(filteredOrders);
                updateCsvLink(selectedYear, selectedMonth); // Update CSV link with filtered parameters
            }
        }

        function displayOrders(filteredOrders) {
            const tableBody = document.getElementById('salesTableBody');
            tableBody.innerHTML = ''; // Clear the table

            if (filteredOrders.length > 0) {
                filteredOrders.forEach(order => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${order.id}</td>
                        <td>${order.total_amount}</td>
                        <td>${new Date(order.created_at).toLocaleString('en-US', { month: 'long', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true })}</td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                const row = document.createElement('tr');
                row.innerHTML = `<td colspan='3' class='text-center'>No payments found.</td>`;
                tableBody.appendChild(row);
            }
        }

        function updateCsvLink(year, month) {
            let url = '{{ route("sales.csv") }}';
            if (year && month) {
                url += `?year=${year}&month=${month}`;
            }
            document.getElementById('downloadCsv').href = url;
        }

        // Initial display of all orders
        displayOrders(orders);
    </script>




@endsection
