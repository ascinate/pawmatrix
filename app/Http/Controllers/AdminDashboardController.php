<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Clinic;
use App\Models\Pet;
use App\Models\User;
use App\Models\MedicalRecord;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\TreatmentBoard;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash; 




class AdminDashboardController extends Controller
{
public function index()
{
    // Stats
    $stats = [
        'todaysAppointments' => Appointment::whereDate('appointment_datetime', now()->toDateString())->count(),
        'upcomingAppointmentsCount' => Appointment::whereDate('appointment_datetime', '>', now()->toDateString())->count(),
        'overdueAppointments' => Appointment::whereDate('appointment_datetime', '<', now()->subMonths(6))->count(),
        'lowInventory' => Product::whereColumn('quantity_in_stock', '<=', 'reorder_threshold')->count(),
        'outstandingInvoices' => Invoice::where('status', 'unpaid')->orWhere('status', 'partial')->count(),
        'medicalRecords' => MedicalRecord::count(),
        'pets' => Pet::count(),
        'clients' => Client::count(),
    ];

    // Treatment board stats
    $treatmentStats = [
        'waiting' => TreatmentBoard::where('status', 'waiting')->count(),
        'in_exam' => TreatmentBoard::where('status', 'in_exam')->count(),
        'in_treatment' => TreatmentBoard::where('status', 'in_treatment')->count(),
        'ready_for_discharge' => TreatmentBoard::where('status', 'ready_for_discharge')->count(),
    ];

    // Upcoming appointments
    $upcomingAppointments = Appointment::with(['pet', 'client'])
        ->where('appointment_datetime', '>=', now())
        ->orderBy('appointment_datetime', 'asc')
        ->limit(10)
        ->get();

    // Calendar events
    $events = Appointment::with('pet')->get()->map(function ($appointment) {
        return [
            'title' => $appointment->pet->name . ' - ' . $appointment->status,
            'start' => $appointment->appointment_datetime,
            'end' => Carbon::parse($appointment->appointment_datetime)
                ->addMinutes($appointment->duration_minutes)
                ->toDateTimeString(),
            'url' => route('appointments.show', $appointment->id),
            'color' => $this->getStatusColor($appointment->status),
        ];
    });

    // Overdue appointments
    $overdueAppointments = Appointment::with(['pet', 'client'])
        ->where('appointment_datetime', '<', now()->subMonths(6))
        ->orderBy('appointment_datetime', 'desc')
        ->limit(10)
        ->get();

    // Today's appointments
    $todaysAppointments = Appointment::with(['pet', 'client'])
        ->whereDate('appointment_datetime', now()->toDateString())
        ->orderBy('appointment_datetime', 'asc')
        ->get();

    // Supporting data
    $clients = Client::all();
    $clinics = Clinic::all();
    $pets = Pet::all();
    $vets = User::where('role', 'vet')->get();

    // 🔽 Dynamic Recent Activity
    $activities = [];

    // Recent Pets
    $recentPets = Pet::latest()->take(2)->get();
    foreach ($recentPets as $pet) {
        $activities[] = [
            'message' => "New patient added: {$pet->name} ({$pet->breed}, {$pet->age} years old)",
           'time' => $pet->created_at ? $pet->created_at->diffForHumans() : 'N/A',
            'created_at' => $pet->created_at,
        ];
    }

    // Recent Clients
    $recentClients = Client::latest()->take(2)->get();
    foreach ($recentClients as $client) {
        $petCount = Pet::where('client_id', $client->id)->count();
        $activities[] = [
            'message' => "{$client->name} registered with {$petCount} pet" . ($petCount !== 1 ? 's' : '') . '.',
            'time' => $client->created_at ? $client->created_at->diffForHumans() : 'N/A',
            'created_at' => $client->created_at,
        ];
    }

    // Recent Invoices
$recentInvoices = Invoice::with('appointment.pet')->latest()->take(2)->get();
    foreach ($recentInvoices as $invoice) {
       $petName = optional($invoice->appointment->pet)->name ?? 'Pet';
        $status = $invoice->status;
        $amount = $invoice->amount;

        $message = $status === 'paid'
            ? "\${$amount} payment received for {$petName}"
            : "Invoice #{$invoice->id} created for {$petName}";

        $activities[] = [
            'message' => $message,
            'time' => $invoice->created_at ? $invoice->created_at->diffForHumans() : 'N/A',
            'created_at' => $invoice->created_at,
        ];
    }

    // Sort and limit
    $activities = collect($activities)
        ->sortByDesc('created_at')
        ->take(6)
        ->values()
        ->all();

    return view('admin_dashboard', compact(
        'stats',
        'treatmentStats',
        'upcomingAppointments',
        'events',
        'clients',
        'pets',
        'clinics',
        'vets',
        'overdueAppointments',
        'todaysAppointments',
        'activities' // ✅ pass to view
    ));
}






    private function getStatusColor($status)
    {
        switch ($status) {
            case 'scheduled':
                return '#3c8dbc'; // Blue
            case 'walk-in':
                return '#f39c12'; // Orange
            case 'completed':
                return '#00a65a'; // Green
            case 'cancelled':
                return '#dd4b39'; // Red
            default:
                return '#777'; // Gray
        }
    }


     public function createvet()
    {
        return view('create_vet');
    }

  public function storevet(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->role = 'vet';
    $user->save();

    return redirect()->route('admin.dashboard')->with('success', 'Vet created successfully.');
}



//for mail notification
public function sendVetNotifications()
{
    // Get upcoming appointments (next 24 hours)
    $upcomingAppointments = Appointment::with(['vet', 'pet', 'client'])
        ->whereBetween('appointment_datetime', [now(), now()->addDay()])
        ->get();

    foreach ($upcomingAppointments as $appointment) {
        // Send to vet
        if ($appointment->vet && $appointment->vet->email) {
            $this->sendAppointmentReminder(
                $appointment->vet->email,
                $appointment->vet->name,
                $appointment,
                'Vet Appointment Reminder'
            );
        }

        // Send to client
        if ($appointment->client && $appointment->client->email) {
            $this->sendAppointmentReminder(
                $appointment->client->email,
                $appointment->client->name,
                $appointment,
                'Pet Appointment Reminder'
            );
        }
    }

    return back()->with('success', 'Notifications sent successfully.');
}

private function sendAppointmentReminder($to, $name, $appointment, $subject)
{
    $messageBody = "
        <html>
        <body>
            <h2>{$subject}</h2>
            <p>Dear {$name},</p>
            <p>This is a reminder for your upcoming appointment:</p>
            
            <p><strong>Pet:</strong> {$appointment->pet->name}</p>
            <p><strong>Date:</strong> {$appointment->appointment_datetime->format('l, F j, Y')}</p>
            <p><strong>Time:</strong> {$appointment->appointment_datetime->format('h:i A')}</p>
            <p><strong>Type:</strong> {$appointment->service_type}</p>
            
            <p>Please arrive 10 minutes before your scheduled time.</p>
            <p>Thank you for choosing our veterinary services!</p>
        </body>
        </html>";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: <no-reply@yourvetclinic.com>" . "\r\n";

    mail($to, $subject, $messageBody, $headers);
}

public function overdue()
{ 
    $overdueAppointments = Appointment::with(['pet', 'client'])
        ->where('appointment_datetime', '<', now()->subMonths(6))
        ->get();
    return view('overdue_Visit', [
        'overdueAppointments' => $overdueAppointments
    ]);
}


}