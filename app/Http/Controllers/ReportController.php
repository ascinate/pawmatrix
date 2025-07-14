<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
{
    $activeTab = $request->input('tab', 'revenue');
    
    // Revenue Report Data
    $revenuePeriod = $request->input('revenue_period', 'daily');//it is fetching user input (dailty, weekly or monthly else default is daily)
    $revenueDate = $request->input('revenue_date', now()->format('Y-m-d'));//try to take date input otherwise it will take current time
    $revenueData = $this->getRevenueData($revenuePeriod, $revenueDate);//get revenue data has 2 input revenuePeriod & revenueDate
    
    // Appointment Report Data
    $appointmentPeriod = $request->input('appointment_period', 'daily');//user select daily monthly or weekly appointment or default daily
    $appointmentDate = $request->input('appointment_date', now()->format('Y-m-d')); //userentered date or current time
    $appointmentData = $this->getAppointmentData($appointmentPeriod, $appointmentDate);//take two input
    
    // Inventory Report Data
// This calls a function that gets all product stock info, like:

// List of products

// Total stock value

// Products that are low in stock
    $inventoryData = $this->getInventoryData();
    
    // Outstanding Balances Data
    $outstandingData = $this->getOutstandingData();
// This calls a function that calculates all unpaid invoice balances, like:

// List of unpaid invoices

// Total money that is still due
    
    return view('report', [
        'activeTab' => $activeTab,
        'revenuePeriod' => $revenuePeriod,
        'revenueDate' => $revenueDate,
        'revenueData' => $revenueData,
        'appointmentPeriod' => $appointmentPeriod,
        'appointmentDate' => $appointmentDate,
        'appointmentData' => $appointmentData,
        'inventoryData' => $inventoryData,
        'outstandingData' => $outstandingData
    ]);
}

    private function getRevenueData($period, $date)
{
    $startDate = Carbon::parse($date);
    
    switch ($period) {
        case 'weekly':
            $endDate = $startDate->copy()->endOfWeek();
            $startDate = $startDate->copy()->startOfWeek();
            break;
        case 'monthly':
            $endDate = $startDate->copy()->endOfMonth();
            $startDate = $startDate->copy()->startOfMonth();
            break;
        default: // daily
            $endDate = $startDate->copy()->endOfDay();
            $startDate = $startDate->copy()->startOfDay();
            break;
    }

    // Make sure to convert any string dates to Carbon
    $payments = Payment::whereBetween('paid_at', [$startDate, $endDate])
        ->orderBy('paid_at')
        ->get()
        ->map(function ($payment) {
            $payment->paid_at = Carbon::parse($payment->paid_at); // Ensure paid_at is Carbon
            return $payment;
        });

    $totalRevenue = $payments->sum('amount');
    
    return [
        'payments' => $payments,
        'totalRevenue' => $totalRevenue,
        'startDate' => $startDate,
        'endDate' => $endDate
    ];
}

private function getAppointmentData($period, $date)
{
    $startDate = Carbon::parse($date);
    
    switch ($period) {
        case 'weekly':
            $endDate = $startDate->copy()->endOfWeek();
            $startDate = $startDate->copy()->startOfWeek();
            break;
        case 'monthly':
            $endDate = $startDate->copy()->endOfMonth();
            $startDate = $startDate->copy()->startOfMonth();
            break;
        default: // daily
            $endDate = $startDate->copy()->endOfDay();
            $startDate = $startDate->copy()->startOfDay();
            break;
    }

    $appointments = Appointment::whereBetween('appointment_datetime', [$startDate, $endDate])
        ->with(['client', 'pet', 'vet'])
        ->orderBy('appointment_datetime')
        ->get()
        ->map(function ($appointment) {
            $appointment->appointment_datetime = Carbon::parse($appointment->appointment_datetime); // Ensure datetime is Carbon
            return $appointment;
        });

    $statusCounts = [
        'scheduled' => $appointments->where('status', 'scheduled')->count(),
        'completed' => $appointments->where('status', 'completed')->count(),
        'cancelled' => $appointments->where('status', 'cancelled')->count(),
    ];
    
    return [
        'appointments' => $appointments,
        'statusCounts' => $statusCounts,
        'startDate' => $startDate,
        'endDate' => $endDate
    ];
}
    
    private function getInventoryData()
    {
        $products = Product::orderBy('name')->get();
        
        $totalValue = $products->sum(function($product) {
            return $product->quantity_in_stock * $product->price;
        });
        
        $lowStock = $products->where('quantity_in_stock', '<=', $products->first()->reorder_threshold ?? 5);
        
        return [
            'products' => $products,
            'totalValue' => $totalValue,
            'lowStock' => $lowStock
        ];
    }
    
    private function getOutstandingData()
    {
        $invoices = Invoice::with(['client', 'payments'])
            ->where('status', '!=', 'paid')
            ->orderBy('invoice_date')
            ->get();
            
        $totalOutstanding = $invoices->sum(function($invoice) {
            return $invoice->total - $invoice->payments->sum('amount');
        });
        
        return [
            'invoices' => $invoices,
            'totalOutstanding' => $totalOutstanding
        ];
    }
}