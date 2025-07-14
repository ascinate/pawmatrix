<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Show analytics dashboard with new patients this month.
     *
     * @return \Illuminate\View\View
     */
    public function analytics(Request $request)
{
    $year = $request->get('year', now()->year);

    // New patients this month
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();
    $newPatientsCount = Appointment::whereBetween('appointment_datetime', [$startOfMonth, $endOfMonth])->count();

    // Monthly appointment count for the selected year
    $monthlyData = Appointment::selectRaw('MONTH(appointment_datetime) as month, COUNT(*) as count')
        ->whereYear('appointment_datetime', $year)
        ->whereNotNull('appointment_datetime')
        ->groupByRaw('MONTH(appointment_datetime)')
        ->pluck('count', 'month')
        ->toArray();

    // Fill missing months with 0 and format month as "01", "02", ...
$appointmentsByMonth = [];
foreach (range(1, 12) as $month) {
    $appointmentsByMonth[] = [
        'month' => str_pad($month, 2, '0', STR_PAD_LEFT), // for raw reference
        'monthLabel' => Carbon::create()->month($month)->format('M'), // this will be shown on the X-axis
        'appointments' => $monthlyData[$month] ?? 0
    ];
}

    // Get available years
    $availableYears = Appointment::whereNotNull('appointment_datetime')
        ->selectRaw('YEAR(appointment_datetime) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year')
        ->toArray();

    return view('dataAnalytics', compact('newPatientsCount', 'appointmentsByMonth', 'availableYears', 'year'));
}

}