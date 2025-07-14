<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Pet;

class InvoiceController extends Controller
{
    //besically fetches the data for the join 
public function index()
{
    // Main invoices query with client and appointment data
    $invoices = Invoice::select(
        'invoices.*',
        'clients.name as client_name',
        'appointments.id as appointment_id',
        'appointments.appointment_datetime as appointment_date'
    )
    ->leftJoin('clients', 'invoices.client_id', '=', 'clients.id')
    ->leftJoin('appointments', 'invoices.appointment_id', '=', 'appointments.id')
    ->orderBy('invoice_date', 'desc')
    ->get();

    // Count totals
    $totalInvoices = Invoice::count();
    $paidInvoices = Invoice::where('status', 'paid')->count();

    $overdueInvoices = Invoice::where('status', 'unpaid')
        ->whereDate('invoice_date', '<', now())
        ->count();

    $pendingInvoicesCount = Invoice::where('status', 'unpaid')
        ->whereDate('invoice_date', '>=', now())
        ->count();

    // Tab content
    $pendingInvoices = Invoice::where('status', 'unpaid')
        ->whereDate('invoice_date', '>=', now())
        ->with('client')
        ->get();

    $paidInvoicesList = Invoice::where('status', 'paid')
        ->with('client')
        ->get();

    $overdueInvoicesList = Invoice::where('status', 'unpaid')
        ->whereDate('invoice_date', '<', now())
        ->with('client')
        ->get();

    return view('billing', [
        'invoices' => $invoices,
        'totalInvoices' => $totalInvoices,
        'paidInvoices' => $paidInvoicesList,
        'overdueInvoices' => $overdueInvoicesList,
        'allInvoicesCount' => $totalInvoices,
        'pendingInvoicesCount' => $pendingInvoicesCount,
        'paidInvoicesCount' => $paidInvoices,
        'overdueInvoicesCount' => $overdueInvoices,
        'pendingInvoices' => $pendingInvoices,
        'clients' => Client::all(),
        'products' => Product::all(),
        'appointments' => Appointment::with('client', 'pet')->get(),
        'pets' => Pet::all() // ✅ Added this line
    ]);
}


 public function show($id)
{
    $invoice = Invoice::select(
        'invoices.*',
        'clients.name as client_name',
        'clients.email as client_email',
        'clients.phone as client_phone',
        'clients.address as client_address',
        'appointments.id as appointment_id',
        'appointments.appointment_datetime as appointment_date'
    )
    ->leftJoin('clients', 'invoices.client_id', '=', 'clients.id')
    ->leftJoin('appointments', 'invoices.appointment_id', '=', 'appointments.id')
    ->where('invoices.id', $id)
    ->first();

    $invoice->items = InvoiceItem::where('invoice_id', $invoice->id)
        ->join('products', 'invoice_items.product_id', '=', 'products.id')
        ->get([
            'invoice_items.*',
            'products.name as product_name'
        ]);

    $invoice->payments = Payment::where('invoice_id', $invoice->id)->get();

    $invoice->formatted_date = Carbon::parse($invoice->invoice_date);
    if ($invoice->appointment_date) {
        $invoice->appointment_date = Carbon::parse($invoice->appointment_date);
    }

    return view('invoice', compact('invoice'));
}
   

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:invoices,id',
            'client_id' => 'required|exists:clients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'invoice_date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'status' => 'required|in:unpaid,paid,partial,cancelled',
        ]);

        $subtotal = collect($validated['items'])->sum(function($item) {
            return $item['quantity'] * $item['unit_price'];
        });

        $total = $subtotal;
        if (isset($validated['tax'])) {
            $total += $validated['tax'];
        }
        if (isset($validated['discount'])) {
            $total -= $validated['discount'];
        }

        $invoice = Invoice::findOrFail($validated['id']);
        $invoice->update([
            'client_id' => $validated['client_id'],
            'appointment_id' => $validated['appointment_id'] ?? null,
            'invoice_date' => $validated['invoice_date'],
            'total' => $total,
            'tax' => $validated['tax'] ?? 0,
            'discount' => $validated['discount'] ?? 0,
            'status' => $validated['status'],
        ]);

        $invoice->items()->delete();
        foreach ($validated['items'] as $item) {
            $invoice->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'description' => Product::find($item['product_id'])->name,
            ]);
        }

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->items()->delete();
        $invoice->payments()->delete();
        $invoice->delete();

        session()->flash('success', 'Invoice deleted successfully.');
        return redirect()->back();
    }
//adding user payment and checking the payment & invoice 
    public function addPayment(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id); //find the invoice by its id
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . ($invoice->total - $invoice->payments->sum('amount')),//required and doesnot exceed the remaining
            'method' => 'required|in:cash,card,insurance',//it is required and it has 3 options
            'paid_at' => 'required|date', //it is in date format
        ]);
//Now it is creating payment and adding the payment into invoice
        $payment = $invoice->payments()->create([
            'amount' => $validated['amount'], //amount
            'method' => $validated['method'], //payment method
            'paid_at' => $validated['paid_at'],//date of payment
        ]);

        $totalPaid = $invoice->payments->sum('amount');  //summing all payment
        if ($totalPaid >= $invoice->total) {//if sum of all payment is equal or greater than invoice
            $invoice->update(['status' => 'paid']);
        } elseif ($totalPaid > 0) { //less than ivoice and greater than 0
            $invoice->update(['status' => 'partial']);
        }

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Payment added successfully.');
    }

       public function getClientAppointments($clientId)
    {
        $appointments = Appointment::where('client_id', $clientId)
            ->with('pet')
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'text' => Carbon::parse($appointment->appointment_datetime)->format('M d, Y') . 
                              ' - ' . $appointment->pet->name
                ];
            });

        return response()->json($appointments);
    }
//Destroy payment and update payment status
    public function destroyPayment($paymentId)
{
    $payment = Payment::findOrFail($paymentId);//retrieve payment by its id
    $invoice = $payment->invoice;
    
    $payment->delete();
    
    // Update invoice status based on remaining balance
    $totalPaid = $invoice->payments->sum('amount');
    if ($totalPaid >= $invoice->total) {
        $invoice->update(['status' => 'paid']);
    } elseif ($totalPaid > 0) {
        $invoice->update(['status' => 'partial']);
    } else {
        $invoice->update(['status' => 'unpaid']);
    }
    
    return redirect()->back()
        ->with('success', 'Payment deleted successfully.');
}

public function storeInvoiceItems(Request $request)
{
    $request->validate([
        'appointment_id' => 'required|exists:appointments,id',
        'client_id' => 'required|exists:clients,id',
        'items' => 'required|array',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
    ]);

    $appointment = Appointment::findOrFail($request->appointment_id);

    $invoice = Invoice::firstOrCreate(
        ['appointment_id' => $appointment->id],
        [
            'client_id' => $request->client_id,
            'invoice_date' => now(),
            'total' => 0,
            'tax' => $request->input('tax', 0),
            'discount' => $request->input('discount', 0),
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

    return redirect()->route('invoices.show', $invoice->id)->with('success', 'Services added successfully.');
}


//store medication 
public function storeMedication(Request $request)
{
    $request->validate([
        'appointment_id' => 'required|exists:appointments,id',
        'client_id' => 'required|exists:clients,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'refills' => 'nullable|integer|min:0',
        'valid_until' => 'nullable|date',
        'use_by' => 'nullable|date',
        'instructions' => 'nullable|string',
        'authorized_vet' => 'nullable|integer',
        'dosage_form' => 'nullable|string',
    ]);

    $product = Product::find($request->product_id);
    $subtotal = $request->quantity * $product->price;

    // Create or find invoice
    $invoice = Invoice::firstOrCreate(
        ['appointment_id' => $request->appointment_id],
        [
            'client_id' => $request->client_id,
            'invoice_date' => now(),
            'total' => 0,
            'tax' => 0,
            'discount' => 0,
            'status' => 'unpaid',
        ]
    );

    // Save invoice item
    InvoiceItem::create([
        'invoice_id' => $invoice->id,
        'product_id' => $product->id,
        'description' => $product->name,
        'quantity' => $request->quantity,
        'unit_price' => $product->price,
    ]);

    $invoice->total += $subtotal;
    $invoice->save();

    // Flash prescription data to session for display
    $prescriptionData = [
        'medication' => $product->name,
        'dosage_form' => $request->dosage_form,
        'quantity' => $request->quantity,
        'refills' => $request->refills,
        'valid_until' => $request->valid_until,
        'use_by' => $request->use_by,
        'instructions' => $request->instructions,
        'authorized_vet' => \App\Models\User::find($request->authorized_vet)->name ?? 'N/A',
    ];

    // Push to session list
    session()->push('prescriptions', $prescriptionData);

    return redirect()->back()->with('success', 'Medication added and shown in prescription list.');
}

}