<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
{
    $orders = Order::all(); // Assuming Order is your model
    return view('backend.sales.index', compact('orders'));
}
    // csv generate

    public function generateCsv(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $query = Order::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        if ($month) {
            $query->whereMonth('created_at', date('m', strtotime($month)));
        }

        $orders = $query->get();

        $totalAmount = $orders->sum('total_amount');

        // Set timezone to Manila and generate the dynamic filename
        $manilaTime = Carbon::now('Asia/Manila');
        $timestamp = $manilaTime->format('mdY_His');
        $csvFileName = "SALESREPORT_{$timestamp}.csv";
        $csvFilePath = storage_path($csvFileName);

        $file = fopen($csvFilePath, 'w');
        fputcsv($file, ['ID', 'Amount', 'Payment Date']);

        foreach ($orders as $order) {
            fputcsv($file, [
                $order->id,
                $order->total_amount,
                $order->created_at->format('F j, Y h:i A')
            ]);
        }

        // Add a blank line
        fputcsv($file, []);
        // Add total amount row
        fputcsv($file, ['Total', $totalAmount]);

        fclose($file);

        return Response::download($csvFilePath, $csvFileName, [
            'Content-Type' => 'text/csv',
        ])->deleteFileAfterSend(true);
    }

    private function getFilteredOrders()
    {
        // Implement your filtering logic here based on user selection
        $filter = request()->input('filter');
        $month = request()->input('month');
        $year = request()->input('year');
        $ordersQuery = Order::query();

        // Add condition to filter by month and year if filter is selected
        if ($filter === 'year') {
            $ordersQuery->whereYear('created_at', $year);
        } elseif ($filter === 'month') {
            $ordersQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        }

        return $ordersQuery->get();
    }
}
