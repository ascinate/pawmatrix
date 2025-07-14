<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Appointment; 
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    /**
     * Display a listing of the pets.
     */
 public function index()
    {
        $pets = Pet::with(['client'])->latest()->get();
        $clients = Client::all();

        // Get appointments categorized by status
        $activeAppointments = Appointment::with(['pet', 'client'])
            ->whereIn('status', ['scheduled', 'checked-in'])
            ->latest()
            ->get();

        $completedAppointments = Appointment::with(['pet', 'client'])
            ->where('status', 'completed')
            ->latest()
            ->get();

        $cancelledAppointments = Appointment::with(['pet', 'client'])
            ->where('status', 'cancelled')
            ->latest()
            ->get();

        // Get counts for each status
        $activeCount = $activeAppointments->count();
        $completedCount = $completedAppointments->count();
        $cancelledCount = $cancelledAppointments->count();

        return view('pet', [
            'pets' => $pets,
            'clients' => $clients,
            'activeAppointments' => $activeAppointments,
            'completedAppointments' => $completedAppointments,
            'cancelledAppointments' => $cancelledAppointments,
            'activeCount' => $activeCount,
            'completedCount' => $completedCount,
            'cancelledCount' => $cancelledCount
        ]);
    }


    /**
     * Show the form for editing the specified pet.
     */
    public function edit(Pet $pet)
    {
        $clients = Client::all();
        return view('pet_edit', [
            'pet' => $pet,
            'clients' => $clients
        ]);
    }

    /**
     * Store a newly created pet in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:100',
        'breed' => 'required|string|max:100',
        'birthdate' => 'required|date',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'notes' => 'nullable|string',
        'owners_name' => 'required|string|max:100',
        'email' => 'nullable|email|max:100',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'zipcode' => 'nullable|string|max:20',
        'gender' => 'nullable|in:male,female,other',
        'dateofbirth' => 'nullable|date',
    ]);

    $client = Client::where('email', $request->email)
        ->orWhere(function ($query) use ($request) {
            $query->where('name', $request->owners_name)
                  ->where('phone', $request->phone);
        })->first();

    if (!$client) {
        $client = new Client();
    }

    $client->name = $request->owners_name;
    $client->email = $request->email;
    $client->phone = $request->phone;
    $client->address = $request->address;
    $client->city = $request->city;
    $client->state = $request->state;
    $client->zipcode = $request->zipcode;
    $client->gender = $request->gender;
    $client->dateofbirth = $request->dateofbirth;
    $client->save();

    $pet = new Pet();
    $pet->client_id = $client->id;
    $pet->name = $request->name;
    $pet->breed = $request->breed;
    $pet->birthdate = $request->birthdate;
    $pet->notes = $request->notes;

    if ($request->hasFile('image')) {
        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
        $destination = 'assets/uploads/pets';
        $request->file('image')->move($destination, $filename);
        $pet->image = $destination . '/' . $filename;
    }

    $pet->save();

    return redirect()->route('admin.dashboard')  // Replace with your Blade page route where modals exist
        ->with('success', 'Pet created successfully.')
        ->with('openAppointmentModal', true)
        ->with('newPetId', $pet->id)
        ->with('newClientId', $client->id);
}

    /**
     * Display the specified pet.
     */
    public function show(Pet $pet)
    {
        $pet->load('client', 'appointments', 'medicalRecords');
        return view('pet_viewdetails', [
            'pet' => $pet
        ]);
    }

    /**
     * Update the specified pet in storage.
     */
  public function update(Request $request, Pet $pet)
{
    $validated = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'name' => 'required|string|max:100',
        'species' => 'required|string|max:50',
        'breed' => 'required|string|max:100',
        'gender' => 'required|in:male,female,unknown',
        'birthdate' => 'required|date',
        'weight_kg' => 'required|numeric|min:0|max:200',
        'microchip_number' => 'nullable|string|max:50',
        'vaccination_status' => 'required|string',
        'allergies' => 'nullable|string',
        'notes' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $pet->client_id = $request->client_id;
    $pet->name = $request->name;
    $pet->species = $request->species;
    $pet->breed = $request->breed;
    $pet->gender = $request->gender;
    $pet->birthdate = $request->birthdate;
    $pet->weight_kg = $request->weight_kg;
    $pet->microchip_number = $request->microchip_number;
    $pet->vaccination_status = $request->vaccination_status;
    $pet->allergies = $request->allergies;
    $pet->notes = $request->notes;

    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($pet->image && file_exists($pet->image)) {
            unlink($pet->image);
        }

        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
        $destination = 'assets/uploads/pets';
        $request->file('image')->move($destination, $filename);
        $pet->image = 'assets/uploads/pets/' . $filename;
    }

    $pet->save();

    return redirect()->route('pets.index')
        ->with('success', 'Pet updated successfully.');
}

    /**
     * Remove the specified pet from storage.
     */
  public function destroy(Pet $pet)
{
    // Delete the associated image if it exists
    if ($pet->image && file_exists($pet->image)) {
        unlink($pet->image);
    }

    $pet->delete();

    return redirect()->route('pets.index')
        ->with('success', 'Pet deleted successfully.');
}

public function petDirectory()
{
    $pets = Pet::with('client')->latest()->get(); // 👈 appointments removed
    return view('pet_directory', ['pets' => $pets]);
}

public function view($id)
{
    $pet = Pet::with(['client', 'appointments.medications'])->findOrFail($id);
    return view('pet_directory_view', compact('pet'));
}



// public function sendEmail(Request $request, Pet $pet)
// {
//     $request->validate([
//         'client_email' => 'required|email',
//         'client_name' => 'required|string',
//     ]);

//     $sections = $request->input('visit_sections', []);
//     $actions = $request->input('email_actions', []);
//     $ownerEmail = $request->input('client_email');
//     $ownerName = $request->input('client_name');
//     $message = $request->input('message');

//     // Build the email body
//     $emailBody = "Hello $ownerName,\n\n";
//     $emailBody .= "Your pet's visit summary includes:\n";

//     foreach ($sections as $section) {
//         $emailBody .= "- " . ucfirst(str_replace('_', ' ', $section)) . "\n";
//     }

//     $emailBody .= "\nMessage from clinic:\n" . $message;

//     // Send email
//     $subject = "Visit Summary for " . $pet->name;
//     $headers = "From: clinic@example.com";

//     mail($ownerEmail, $subject, $emailBody, $headers);

//     // Optional: Mark visit complete
//     if (in_array('mark_completed', $actions)) {
//         $pet->notes = trim($pet->notes . "\n\n[Visit marked as completed via email form]");
//         $pet->save();
//     }

//     return back()->with('success', 'Email sent successfully to owner.');
// }


}
