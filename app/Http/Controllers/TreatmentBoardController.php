<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TreatmentBoard;
use App\Models\Pet;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class TreatmentBoardController extends Controller
{
    public function index()
    {
        // Get today's date
        $today = Carbon::today()->toDateString();
        
        // Get all appointments for today with their pets and clients
        $appointments = Appointment::with(['pet.client', 'vet'])
            ->whereDate('appointment_datetime', $today)
            ->where('status', 'scheduled')
            ->orderBy('appointment_datetime')
            ->get();

        // Get all pets that are already on the treatment board
        $onBoardPets = TreatmentBoard::with(['pet.client', 'updatedBy'])
            ->whereHas('pet', function($query) use ($today) {
                $query->whereHas('appointments', function($q) use ($today) {
                    $q->whereDate('appointment_datetime', $today);
                });
            })
            ->get()
            ->keyBy('pet_id');

        return view('treatment_board', [
            'appointments' => $appointments,
            'onBoardPets' => $onBoardPets
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pet_id' => 'required|exists:pets,id'
        ]);

        TreatmentBoard::create([
            'pet_id' => $request->pet_id,
            'status' => 'waiting',
            'updated_by' => auth()->id(),
            'updated_at' => now()
        ]);

        return redirect()->route('treatment-board.index')
            ->with('success', 'Pet added to treatment board successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:treatment_board,id',
            'status' => 'required|in:waiting,in_exam,in_treatment,ready_for_discharge'
        ]);

        $treatment = TreatmentBoard::find($request->id);
        $treatment->update([
            'status' => $request->status,
            'updated_by' => auth()->id(),
            'updated_at' => now()
        ]);

        return redirect()->route('treatment-board.index')
            ->with('success', 'Treatment status updated successfully');
    }
}