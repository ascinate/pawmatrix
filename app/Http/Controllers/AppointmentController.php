<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Pet;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\SoapTemplate;
use App\Models\Client;
use App\Models\Clinic;
use App\Models\User;
use App\Models\Invoice;
use App\Models\ClientDocument;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\DischargeNote;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Storage; 

class AppointmentController extends Controller
{
    //Show the list of all appointments
public function index()
{
    $appointments = Appointment::select(
        'appointments.*',
        'clients.name as client_name',
        'pets.name as pet_name',
        'clinics.name as clinic_name',
        'users.name as vet_name'
    )
    ->leftJoin('clients', 'appointments.client_id', '=', 'clients.id')
    ->leftJoin('pets', 'appointments.pet_id', '=', 'pets.id')
    ->leftJoin('clinics', 'appointments.clinic_id', '=', 'clinics.id')
    ->leftJoin('users', 'appointments.vet_id', '=', 'users.id')
    ->orderBy('appointment_datetime', 'desc')
    ->get();

    if(request()->wantsJson()) {
        return response()->json(
            $appointments->map(function($appointment) {
                $start = Carbon::parse($appointment->appointment_datetime);
                $end = $start->copy()->addMinutes($appointment->duration_minutes);
                
                return [
                    'id' => $appointment->id,
                    'title' => $appointment->pet_name . ': ' . ($appointment->reason ?? 'Appointment'),
                    'start' => $start->toDateTimeString(),
                    'end' => $end->toDateTimeString(),
                    'resourceId' => $appointment->room,
                    'extendedProps' => [
                        'vet_name' => $appointment->vet_name,
                        'status' => $appointment->status,
                        'pet_name' => $appointment->pet_name,
                        'reason' => $appointment->reason
                    ]
                ];
            })
        );
    }

    return view('appointment', [
        'appointments' => $appointments,
        'clients' => Client::all(),
        'pets' => Pet::all(),
        'clinics' => Clinic::all(),
        'vets' => User::where('role', 'vet')->get()
    ]);
}
// typically used to display appointments on a calendar view.
//  public function calendar()
// {
//     $appointments = Appointment::with(['client', 'pet', 'clinic', 'vet'])->get();//Retrieves all appointments with their related client, pet, clinic, and vet data

//     $events = [];//Initializes an empty array to hold calendar event data.

//     foreach ($appointments as $appointment) {
//         $start = Carbon::parse($appointment->appointment_datetime);
//         $end = $start->copy()->addMinutes($appointment->duration_minutes);

//         $events[] = [
//             'id' => $appointment->id,
//             'title' => $appointment->pet->name . ' (' . $appointment->client->name . ') - ' . ($appointment->vet ? $appointment->vet->name : 'Unassigned'),
//             'start' => $start->toDateTimeString(),
//             'end' => $end->toDateTimeString(),
//             'color' => $this->getStatusColor($appointment->status),
//         ];
//     }

//     $clients = Client::all();
//     $pets = Pet::all();
//     $clinics = Clinic::all();
//     $vets = User::where('role', 'vet')->get();

//     return view('calendar', [
//         'events' => $events,
//         'clients' => $clients,
//         'pets' => $pets,
//         'clinics' => $clinics,
//         'vets' => $vets,
//     ]);
// }
    public function show($id)
    {
        $appointment = Appointment::select(
            'appointments.*',
            'clients.name as client_name',
            'pets.name as pet_name',
            'clinics.name as clinic_name',
            'users.name as vet_name'
        )
        ->leftJoin('clients', 'appointments.client_id', '=', 'clients.id')
        ->leftJoin('pets', 'appointments.pet_id', '=', 'pets.id')
        ->leftJoin('clinics', 'appointments.clinic_id', '=', 'clinics.id')
        ->leftJoin('users', 'appointments.vet_id', '=', 'users.id')
        ->where('appointments.id', $id)
        ->first();

        $appointment->formatted_datetime = Carbon::parse($appointment->appointment_datetime);
        
        return view('view_appointment', [
            'appointment' => $appointment
        ]);
    }

// public function store(Request $request)
// {
//     $validated = $request->validate([
//         'pet_id' => 'required|exists:pets,id',
//         'client_id' => 'required|exists:clients,id',
//         'clinic_id' => 'required|exists:clinics,id',
//         'vet_id' => 'required|exists:users,id',
//         'appointment_datetime' => 'required|date',
//         'duration_minutes' => 'required|integer|min:1',
//         'status' => 'required|in:scheduled,completed,cancelled',
//         'notes' => 'nullable|string',
//     ]);

//     $appointment = Appointment::create($validated);

 

//     return redirect()->route('appointments.index')
//         ->with('success', 'Appointment created successfully.');
// }

public function checkin(Request $request)
{
    $request->validate([
        'appointment_id' => 'required|exists:appointments,id'
    ]);

    $appointment = Appointment::findOrFail($request->appointment_id);
    $appointment->status = 'checked-in';
    $appointment->save();

    return redirect()->back()->with('success', 'Patient checked in successfully.');
}

public function store(Request $request)
{
   $validated = $request->validate([
     'pet_id' => 'required|exists:pets,id',
     'client_id' => 'required|exists:clients,id',
     'vet_id' => 'required|exists:users,id',
     'appointment_datetime' => 'required|date',
     'duration_minutes' => 'required|integer|min:1',
     'notes' => 'nullable|string',
     'room' => 'nullable|string',    // ENUM validation
     'reason' => 'nullable|string',  // ENUM validation
]);

   Appointment::create([
     'pet_id' => $validated['pet_id'],
     'client_id' => $validated['client_id'],
     'vet_id' => $validated['vet_id'],
     'clinic_id' => auth()->user()->clinic_id ?? 1,
     'appointment_datetime' => $validated['appointment_datetime'],
     'duration_minutes' => $validated['duration_minutes'],
     'status' => 'scheduled',
     'notes' => $validated['notes'] ?? null,
     'room' => $validated['room'] ?? null,
     'reason' => $validated['reason'] ?? null,
]);
    return redirect()->route('appointments.index')->with('appointment_created', true);
      
}


  public function update(Request $request)
{
    $validated = $request->validate([
        'id' => 'required|exists:appointments,id',
        'pet_id' => 'required|exists:pets,id',
        'client_id' => 'required|exists:clients,id',
        'clinic_id' => 'required|exists:clinics,id',
        'vet_id' => 'required|exists:users,id',
        'appointment_datetime' => [
            'required',
            'date',
            function ($attribute, $value, $fail) use ($request) {
                $startTime = Carbon::parse($value);
                $endTime = $startTime->copy()->addMinutes((int) $request->duration_minutes);
                
                $overlappingAppointments = Appointment::where('vet_id', $request->vet_id)
                    ->where('id', '!=', $request->id)
                    ->where('status', '!=', 'cancelled')
                    ->where(function($query) use ($startTime, $endTime) {
                        $query->where(function($q) use ($startTime, $endTime) {
                            $q->where('appointment_datetime', '>=', $startTime)
                              ->where('appointment_datetime', '<', $endTime);
                        })->orWhere(function($q) use ($startTime, $endTime) {
                            $q->whereRaw('DATE_ADD(appointment_datetime, INTERVAL duration_minutes MINUTE) > ?', [$startTime])
                              ->whereRaw('DATE_ADD(appointment_datetime, INTERVAL duration_minutes MINUTE) <= ?', [$endTime]);
                        })->orWhere(function($q) use ($startTime, $endTime) {
                            $q->where('appointment_datetime', '<=', $startTime)
                              ->whereRaw('DATE_ADD(appointment_datetime, INTERVAL duration_minutes MINUTE) >= ?', [$endTime]);
                        });
                    })
                    ->exists();
                
                if ($overlappingAppointments) {
                    $fail('The selected vet already has an appointment during this time.');
                }
            }
        ],
        'duration_minutes' => 'required|integer|min:1',
        'status' => 'required|in:scheduled,completed,cancelled',
        'notes' => 'nullable|string',
    ]);

    $appointment = Appointment::findOrFail($request->id);
    $appointment->update($validated);

    return redirect()->route('appointments.index')
        ->with('success', 'Appointment updated successfully.');
}
    //IT IS FOR DELETING AND APPOINTMENT BY ITS ID
    public function destroy($id)
    {
        //FINDING APPOINTMENT THROUGH ID IF FAILS THEN THROW A 404 does not exists
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        session()->flash('success', 'Appointment deleted successfully.');
        return redirect()->back();
    }

    public function getClientPets($clientId)
    {
        $client = Client::findOrFail($clientId);
        return response()->json($client->pets);
    }

     private function getStatusColor($status)
    {
        switch ($status) {
            case 'completed':
                return '#28a745'; // green
            case 'cancelled':
                return '#dc3545'; // red
            default:
                return '#007bff'; // blue
        }
    }


    public function updateTime(Request $request, Appointment $appointment)
{
    $validated = $request->validate([
        'appointment_datetime' => 'required|date',
        'duration_minutes' => 'required|integer|min:1'
    ]);

    $appointment->update([
        'appointment_datetime' => $validated['appointment_datetime'],
        'duration_minutes' => $validated['duration_minutes']
    ]);

    return response()->json(['message' => 'Appointment updated successfully']);
}


public function checkConflict(Request $request)
{
    $request->validate([
        'vet_id' => 'required|exists:users,id',
        'appointment_datetime' => 'required|date',
        'duration_minutes' => 'required|integer|min:1',
        'exclude_id' => 'nullable|exists:appointments,id'
    ]);

    $startTime = Carbon::parse($request->appointment_datetime);
    $endTime = $startTime->copy()->addMinutes($request->duration_minutes);

    $query = Appointment::where('vet_id', $request->vet_id)
        ->where('status', '!=', 'cancelled')
        ->where(function($q) use ($startTime, $endTime) {
            // Check if existing appointment overlaps with new appointment time range
            $q->where(function($innerQ) use ($startTime, $endTime) {
                // Existing appointment starts during new appointment
                $innerQ->where('appointment_datetime', '>=', $startTime)
                      ->where('appointment_datetime', '<', $endTime);
            })->orWhere(function($innerQ) use ($startTime, $endTime) {
                // Existing appointment ends during new appointment
                $innerQ->whereRaw('DATE_ADD(appointment_datetime, INTERVAL duration_minutes MINUTE) > ?', [$startTime])
                      ->whereRaw('DATE_ADD(appointment_datetime, INTERVAL duration_minutes MINUTE) <= ?', [$endTime]);
            })->orWhere(function($innerQ) use ($startTime, $endTime) {
                // Existing appointment completely contains new appointment
                $innerQ->where('appointment_datetime', '<=', $startTime)
                      ->whereRaw('DATE_ADD(appointment_datetime, INTERVAL duration_minutes MINUTE) >= ?', [$endTime]);
            });
        });

    if ($request->exclude_id) {
        $query->where('id', '!=', $request->exclude_id);
    }
    
    return response()->json([
        'has_conflict' => $query->exists()
    ]);
}

public function getPetInfo($id)
{
    $pet = \App\Models\Pet::with('client')->find($id);

    if (!$pet) {
        return response()->json(['error' => 'Pet not found'], 404);
    }

    return response()->json([
        'pet_name' => $pet->name,
        'pet_species' => $pet->species,
        'owner_id' => $pet->client->id ?? null,
        'owner_name' => $pet->client->name ?? 'Unknown',
    ]);
}




public function calendarData(Request $request)
{
    $query = \App\Models\Appointment::with(['pet', 'vet']);

    if ($request->has('date')) {
        $date = \Carbon\Carbon::parse($request->date)->toDateString();
        $query->whereDate('appointment_datetime', $date);
    }

    $appointments = $query->get();

    $events = [];
    foreach ($appointments as $appt) {
        $start = \Carbon\Carbon::parse($appt->appointment_datetime);
        $end = $start->copy()->addMinutes($appt->duration_minutes);
        $events[] = [
            'id' => $appt->id,
            'resourceId' => $appt->room ?? 'Unassigned',
            'start' => $start->toIso8601String(),
            'end' => $end->toIso8601String(),
            'title' => "{$appt->pet?->name}: {$appt->reason} | {$appt->vet?->name}",
            'status' => $appt->status, // ✅ Include this line
        ];
    }

    return response()->json($events);
}

public function updateTimee(Request $request)
{
    $appt = \App\Models\Appointment::findOrFail($request->id);
    $appt->appointment_datetime = \Carbon\Carbon::parse($request->start);
    $appt->duration_minutes = \Carbon\Carbon::parse($request->end)->diffInMinutes($request->start);
    $appt->save();

    return response()->json(['success' => true]);
}




public function updateStatus(Request $request, $id)
{
    $appointment = Appointment::findOrFail($id);
    $status = $request->input('status'); // 'completed' or 'cancelled'

    if (!in_array($status, ['completed', 'cancelled'])) {
        return redirect()->back()->with('error', 'Invalid status.');
    }

    $appointment->status = $status;
    $appointment->save();

    return redirect()->back()->with('success', 'Appointment status updated successfully.');
}

//for appointment billing
public function billing($id)
{
    $appointment = Appointment::with([
        'pet', 
        'client', 
        'clinic', 
        'vet', 
        'invoice.invoiceItems.product'
    ])->findOrFail($id);

    $soap = SoapTemplate::where('category', 'general')->latest()->first();
    $products = Product::all();
    $invoiceItems = $appointment->invoice ? $appointment->invoice->invoiceItems : collect();
    
    // Explicit query for medications
    $medications = Product::where('appointment_id', $appointment->id)
        ->where('category', 'medication')
        ->latest()
        ->get();

    return view('appointments_billing', compact(
        'appointment',
        'soap',
        'products',
        'invoiceItems',
        'medications'
    ));
}
//appointment dischargenotes
public function storeDischargeNote(Request $request, $id)
{
    $request->validate([
        'note' => 'required|string',
    ]);

    $appointment = Appointment::findOrFail($id);

    // Create or update discharge note
    DischargeNote::updateOrCreate(
        ['appointment_id' => $appointment->id],
        ['note' => $request->note]
    );

    return redirect()->back()->with('success', 'Discharge note saved.');
}

//appointment medical note
public function storeMedication(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:100',
        'authorized_vet' => 'nullable|string|max:100',
        'dosage_form' => 'nullable|string|max:50',
        'quantity_in_stock' => 'nullable|integer',
        'refills' => 'nullable|integer',
        'valid_until' => 'nullable|date',
        'use_by_date' => 'nullable|date',
        'instructions' => 'nullable|string',
    ]);

    // Use the $id parameter from the route instead of request input
    $appointment = Appointment::findOrFail($id);

    $appointment->medications()->create([
        'name' => $request->name,
        'category' => 'medication',
        'authorized_vet' => $request->authorized_vet,
        'dosage_form' => $request->dosage_form,
        'quantity_in_stock' => $request->quantity_in_stock,
        'refills' => $request->refills,
        'valid_until' => $request->valid_until,
        'use_by_date' => $request->use_by_date,
        'instructions' => $request->instructions,
    ]);

    return redirect()->back()->with('success', 'Medication added successfully.');
}

//appointment soap note
public function storeSoapNote(Request $request, $id)
{
    $request->validate([
        'subjective' => 'required|string',
        'objective' => 'required|string',
        'assessment' => 'required|string',
        'plan' => 'required|string',
    ]);

    $appointment = Appointment::findOrFail($id);

    MedicalRecord::updateOrCreate(
        [
            'appointment_id' => $appointment->id, // Make unique per appointment
        ],
        [
            'pet_id' => $appointment->pet_id,
            'vet_id' => $appointment->vet_id,
            'visit_date' => $appointment->appointment_datetime,
            'subjective' => $request->subjective,
            'objective' => $request->objective,
            'assessment' => $request->assessment,
            'plan' => $request->plan,
        ]
    );

    return redirect()->back()->with('success', 'SOAP note saved.');
}


public function cancelStatus(Request $request, $id)
{
    $appointment = Appointment::findOrFail($id);
    $appointment->status = $request->input('status'); // 'cancelled'
    $appointment->save();

    return redirect()->back()->with('success', 'Appointment status updated.');
}

public function storeInvoiceItems(Request $request, $appointmentId)
{
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'items' => 'required|array',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
    ]);

    $appointment = Appointment::findOrFail($appointmentId);

    $invoice = Invoice::firstOrCreate(
        ['appointment_id' => $appointment->id],
        [
            'client_id' => $request->client_id,
            'invoice_date' => now(),
            'total' => 0,
            'tax' => 0,
            'discount' => 0,
            'status' => 'unpaid',
        ]
    );

    $total = 0;

    foreach ($request->items as $item) {
        $subtotal = $item['quantity'] * $item['unit_price'];
        $total += $subtotal;

        InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'product_id' => $item['product_id'],
            'description' => Product::find($item['product_id'])->name,
            'quantity' => $item['quantity'],
            'unit_price' => $item['unit_price'],
        ]);
    }

    $invoice->total = $total;
    $invoice->save();

    return redirect()->back()->with('success', 'Services added successfully.');
}


public function uploadDocument(Request $request)
{
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
    ]);

    $file = $request->file('document');
    $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

    $destination = 'assets/uploads/medical_docs';
    if (!File::exists($destination)) {
        File::makeDirectory($destination, 0755, true);
    }

    $file->move($destination, $filename);

    ClientDocument::create([
        'client_id' => $request->client_id,
        'document_type' => 'medical',
        'file_path' => 'assets/uploads/medical_docs/' . $filename,
        'uploaded_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Document uploaded successfully.');
}

public function sendEmail(Request $request, Pet $pet) 
{
    $request->validate([
        'client_email' => 'required|email',
        'client_name'  => 'required|string',
        'message'      => 'nullable|string',
    ]);

    $sections     = $request->input('visit_sections', []);
    $emailActions = $request->input('email_actions', []);
    $ownerEmail   = $request->input('client_email');
    $ownerName    = $request->input('client_name');
    $message      = $request->input('message', '');

    $appointment = Appointment::where('pet_id', $pet->id)
                              ->latest()
                              ->firstOrFail();

    if (in_array('mark_completed', $emailActions)) {
        $appointment->status = 'completed';
        $appointment->save();
    }

    $emailBody   = "Hello $ownerName,\n\nHere is your visit summary for {$pet->name}:\n\n";
    $attachments = [];

    // Dompdf common options
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('defaultFont', 'Helvetica');

    foreach ($sections as $section) {
        switch ($section) {
case 'soap_notes':
    $soap = MedicalRecord::where('appointment_id', $appointment->id)->first();
    $emailBody .= "\n--- SOAP Notes ---\n";
    
    if ($soap) {
        $dompdf = new Dompdf($options);
        $html = view('pdf.soap_notes', [
            'soap' => $soap,
            'appointment' => $appointment,
            'pet' => $pet
        ])->render();
        
           $dompdf->loadHtml($html);
           $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

           $pdfData = $dompdf->output();
           $filename = "SOAP_Notes_{$pet->name}_" . $appointment->appointment_datetime->format('Y-m-d') . ".pdf";
           $attachments[] = [
            'pdfData' => $pdfData,
            'filename' => $filename,
            'mime' => 'application/pdf'
        ];
        
           $emailBody .= "Please see the attached PDF for detailed SOAP notes.\n";
       } else {
        $emailBody .= "No SOAP notes available.\n";
       }
       break;
                case 'invoice_summary':
                    $invoice = $appointment->invoice;
                    $emailBody .= "\n--- Invoice Summary ---\n";
                    if ($invoice && $invoice->invoiceItems->count()) {
                        $dompdf = new Dompdf($options);
                        $html   = view('pdf.invoice_pdf', compact('invoice','appointment','pet'))->render();
                        $dompdf->loadHtml($html);
                        $dompdf->setPaper('A4','portrait');
                        $dompdf->render();

                        $pdfData  = $dompdf->output();
                        $filename = "Invoice_{$pet->name}_" . $appointment->appointment_datetime->format('Y-m-d') . ".pdf";
                        $attachments[] = compact('pdfData','filename');
                    } else {
                        $emailBody .= "No invoice data found.\n";
                    }
                    break;

               case 'medication':
    $meds = Product::where('appointment_id', $appointment->id)
                   ->where('category', 'medication')->get();
    $emailBody .= "\n--- Medication Prescription ---\n";
    if ($meds->count()) {
        $dompdf = new Dompdf($options);
        $html = view('pdf.medications', compact('meds', 'appointment', 'pet'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfData = $dompdf->output();
        $filename = "Medications_{$pet->name}_" . $appointment->appointment_datetime->format('Y-m-d') . ".pdf";
        $attachments[] = [
            'pdfData' => $pdfData,
            'filename' => $filename,
            'mime' => 'application/pdf'
        ];
    } else {
        $emailBody .= "No medication prescribed.\n";
    }
    break;

                case 'discharge_notes':
                    $note = DischargeNote::where('appointment_id',$appointment->id)->first();
                    $emailBody .= "\n--- Discharge Notes ---\n";
                    if ($note) {
                        $dompdf = new Dompdf($options);
                        $html   = view('pdf.discharge_notes', compact('note','appointment','pet'))->render();
                        $dompdf->loadHtml($html);
                        $dompdf->setPaper('A4','portrait');
                        $dompdf->render();

                        $pdfData  = $dompdf->output();
                        $filename = "Discharge_Notes_{$pet->name}_" . $appointment->appointment_datetime->format('Y-m-d') . ".pdf";
                        $attachments[] = compact('pdfData','filename');
                    } else {
                        $emailBody .= "No discharge notes available.\n";
                    }
                    break;
            }
        }

        $emailBody .= "\n\nMessage from Clinic:\n" . $message;

        // Send to owner
        Mail::raw($emailBody, function($m) use($ownerEmail,$attachments) {
            $m->to($ownerEmail)
              ->subject("Visit Summary")
              ->from('clinic@example.com','PawMetric Veterinary');
            foreach($attachments as $att) {
                $m->attachData($att['pdfData'], $att['filename']);
            }
        });

        // Copy to clinic
        if (in_array('copy_to_clinic',$emailActions)) {
            $clinicEmail = $appointment->clinic->email ?? 'clinic@example.com';
            Mail::raw($emailBody, function($m) use($clinicEmail,$attachments){
                $m->to($clinicEmail)
                  ->subject("COPY: Visit Summary")
                  ->from('clinic@example.com','PawMetric Veterinary');
                foreach($attachments as $att) {
                    $m->attachData($att['pdfData'], $att['filename']);
                }
            });
        }

        // Save to patient file
        if (in_array('attach_pdf',$emailActions)) {
            foreach($attachments as $att) {
                Storage::put("public/assets/uploads/medical_docs/{$att['filename']}", $att['pdfData']);
                ClientDocument::create([
                    'client_id'    => $appointment->client_id,
                    'document_type'=> 'medical',
                    'file_path'    => "assets/uploads/medical_docs/{$att['filename']}",
                    'uploaded_at'  => now(),
                ]);
            }
        }

        return back()->with('success','Email sent successfully with PDF attachments.');
    }

}