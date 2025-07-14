<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Product;
use Carbon\Carbon;

class SmartLouController extends Controller
{
    public function index()
    {
        $expiringMedsCount = Product::whereDate('expiry_date', '<=', Carbon::now()->addDays(7))->count();

      $cancelledAppointmentsCount = Appointment::where('status', 'cancelled')->count();

        $clientTaskOverdueCount = Appointment::where('status', 'missed')
            ->whereDate('appointment_datetime', '<', Carbon::now()->subDays(7))
            ->count();

        $overdueWellnessCount = Appointment::where('reason', 'like', '%wellness%')
            ->whereDate('appointment_datetime', '<', Carbon::now()->subYear())
            ->count();

        return view('smartlou', compact(
            'expiringMedsCount',
            'cancelledAppointmentsCount',
            'clientTaskOverdueCount',
            'overdueWellnessCount'
        ));
    }
}
