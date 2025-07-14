<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\ClientDocument;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::select(
            'clients.*',
            DB::raw('(SELECT COUNT(*) FROM pets WHERE pets.client_id = clients.id) as pets_count'),
            DB::raw('(SELECT COUNT(*) FROM client_documents WHERE client_documents.client_id = clients.id) as documents_count')
        )
        ->orderBy('name', 'asc')
        ->get();

        return view('clients', [
            'clients' => $clients
        ]);
    }

    public function show($id)
    {
        $client = Client::select(
            'clients.*',
            DB::raw('(SELECT COUNT(*) FROM pets WHERE pets.client_id = clients.id) as pets_count')
        )
        ->where('clients.id', $id)
        ->first();

        // Load pets separately for display
        $client->pets = Pet::where('client_id', $client->id)->get();

        return view('view_client', [
            'client' => $client
        ]);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'preferred_contact_method' => 'required|in:email,phone,sms',
            'notes' => 'nullable|string',
            'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        // Create the client first
        $client = Client::create($validated);

        // Handle file uploads if any
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $filename = time() . '_' . $document->getClientOriginalName();
                $path = $document->storeAs('public/assets/uploads/docs', $filename);

                ClientDocument::create([
                    'client_id' => $client->id,
                    'filename' => $filename,
                    'path' => str_replace('public/', '', $path),
                    'document_type' => $document->getClientMimeType()
                ]);
            }
        }

        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email,' . $request->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'preferred_contact_method' => 'required|in:email,phone,sms',
            'notes' => 'nullable|string',
            'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        $client = Client::findOrFail($request->id);
        $client->update($validated);

        // Handle new document uploads (if any)
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $filename = time() . '_' . $document->getClientOriginalName();
                $path = $document->storeAs('public/assets/uploads/docs', $filename);

                ClientDocument::create([
                    'client_id' => $client->id,
                    'filename' => $filename,
                    'path' => str_replace('public/', '', $path),
                    'document_type' => $document->getClientMimeType()
                ]);
            }
        }

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        session()->flash('success', 'Client deleted successfully.');
        return redirect()->back();
    }

    public function exportExcel()
    {
        $clients = Client::select(
            'name',
            'email',
            'phone',
            'address',
            'preferred_contact_method',
            'notes',
            DB::raw('(SELECT COUNT(*) FROM pets WHERE pets.client_id = clients.id) as pets_count')
        )
        ->orderBy('name', 'asc')
        ->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=clients_" . date('Y-m-d') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($clients) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'Name', 
                'Email', 
                'Phone', 
                'Address', 
                'Preferred Contact Method', 
                'Notes', 
                'Pets Count'
            ]);

            // Add data rows
            foreach ($clients as $client) {
                fputcsv($file, [
                    $client->name,
                    $client->email,
                    $client->phone,
                    $client->address,
                    $client->preferred_contact_method,
                    $client->notes,
                    $client->pets_count
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPDF()
    {
        $clients = Client::select(
            'name',
            'email',
            'phone',
            'address',
            'preferred_contact_method',
            'notes',
            DB::raw('(SELECT COUNT(*) FROM pets WHERE pets.client_id = clients.id) as pets_count')
        )
        ->orderBy('name', 'asc')
        ->get();

        $html = view('pdf.clients_pdf', compact('clients'))->render();

        // Generate a unique filename
        $filename = 'clients_'.date('Y-m-d').'.html';

        // Return as downloadable HTML file (users can save as PDF)
        return response()->make($html, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"'
        ]);
    }
}