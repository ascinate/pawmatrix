<?php

namespace App\Http\Controllers;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ClinicController extends Controller
{
    public function index(){
        $clinics = Clinic::all();
        
        return view('clinic', [
            'clinics' => $clinics
        ]);
    }

    public function store(Request $request)
    {
        //VALIDATION OF INPUT DATA START
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            // 'branding_json' => 'nullable|json',
        ]);
        //VALIDATION OF INPUT DATA END

        //CREATING NEW CLINIC  OBJECT
        $clinic = new Clinic();
        $clinic->name = $request->name;
        $clinic->address = $request->address;
        $clinic->phone = $request->phone;
        $clinic->email = $request->email;
        // $clinic->branding_json = $request->branding_json;
        
        $clinic->save();

        return redirect()->route('clinics.index')
            ->with('success', 'Clinic created successfully.');
    }

   public function update(Request $request)
{
    $validated = $request->validate([
        'id' => 'required|exists:clinics,id',
        'name' => 'required|string|max:100',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:100',
        // 'branding_json' => 'nullable|json',
    ]);

    $clinic = Clinic::findOrFail($request->id);
    $clinic->update($validated);

    return redirect()->route('clinics.index')->with('success', 'Clinic updated successfully.');
}


    public function destroy(Clinic $clinic)
    {
        $clinic->delete();

        return redirect()->route('clinics.index')
            ->with('success', 'Clinic deleted successfully.');
    }

   // Add these methods to ClinicController.php
public function exportExcel()
{
    $clinics = Clinic::select(
        'name',
        'address',
        'phone',
        'email',
        'created_at'
    )
    ->orderBy('name', 'asc')
    ->get();

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=clinics_" . date('Y-m-d') . ".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $callback = function() use ($clinics) {
        $file = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($file, [
            'Name', 
            'Address', 
            'Phone', 
            'Email', 
            'Created At'
        ]);

        // Add data rows
        foreach ($clinics as $clinic) {
            fputcsv($file, [
                $clinic->name,
                $clinic->address,
                $clinic->phone,
                $clinic->email,
                $clinic->created_at->format('Y-m-d')
            ]);
        }
        
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

public function exportPDF()
{
    $clinics = Clinic::select(
        'name',
        'address',
        'phone',
        'email',
        'created_at'
    )
    ->orderBy('name', 'asc')
    ->get();

    $html = view('pdf.clinics_pdf', compact('clinics'))->render();

    // Generate a unique filename
    $filename = 'clinics_'.date('Y-m-d').'.html';

    // Return as downloadable HTML file (users can save as PDF)
    return response()->make($html, 200, [
        'Content-Type' => 'text/html',
        'Content-Disposition' => 'attachment; filename="'.$filename.'"'
    ]);
}
}