<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PDF;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        // Apply filtering based on user input
        $ordersQuery = Order::query();

        if ($request->has('year')) {
            $ordersQuery->whereYear('created_at', $request->year);
        }

        if ($request->has('month')) {
            $ordersQuery->whereMonth('created_at', date('m', strtotime($request->month)));
        }

        // Fetch filtered orders
        $orders = $ordersQuery->get();

        // Separate orders by status and payment status
        $deliveredAndPaidOrders = $orders->filter(function ($order) {
            return $order->status == 'delivered' && $order->payment_status == 'paid';
        });

        $cancelAndUnpaidOrders = $orders->filter(function ($order) {
            return $order->status == 'cancel' && $order->payment_status == 'unpaid';
        });

        return view('backend.sales.index', compact('deliveredAndPaidOrders', 'cancelAndUnpaidOrders', 'orders'));
    }

    // PDF generation
    public function generatePdf(Request $request)
    {
        $query = Order::query();

        // Apply filtering if year and month are provided
        if ($request->has('year')) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->has('month')) {
            $query->whereMonth('created_at', date('m', strtotime($request->month)));
        }

        // Get the filtered or all orders
        $orders = $query->get();

        // Generate a filename for the PDF
        $file_name = 'SALESREPORT' . now()->format('Ymd_His') . '.pdf';

        // Get the name of the user who generated the PDF
        $generatedBy = auth()->user()->name;

        // Create an instance of PDF
        $pdf = PDF::loadView('backend.sales.pdf', compact('orders', 'generatedBy'));

        // Return the generated PDF for download
        return $pdf->download($file_name);
    }


    public function test(Request $request){
        // Fetch the orders from the database
    $orders = Order::all();

    // Pass the orders to the view
    return view('backend.sales.test')->with('orders', $orders);
    }
}
