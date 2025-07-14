<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {
        // Using subquery to count products for each supplier
        $suppliers = Supplier::select(
            'suppliers.*',
            DB::raw('(SELECT COUNT(*) FROM products WHERE products.supplier_id = suppliers.id) as product_count')
        )
        ->orderBy('name', 'asc')
        ->get();

        return view('supplier', [
            'suppliers' => $suppliers,
            'products' => Product::all()
        ]);
    }

    public function show($id)
    {
        // Get supplier with their products using a join
        $supplier = Supplier::select(
            'suppliers.*',
            DB::raw('(SELECT COUNT(*) FROM products WHERE products.supplier_id = suppliers.id) as product_count')
        )
        ->where('suppliers.id', $id)
        ->first();

        // Load products separately for display
        $supplier->products = Product::where('supplier_id', $supplier->id)->get();

        return view('view_supplier', [
            'supplier' => $supplier
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'required|string',
        ]);

        $supplier = Supplier::create([
            'name' => $request->name,
            'contact_info' => $request->contact_info,
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier created successfully.');
    }

   public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'contact_info' => 'required|string',
    ]);

    $supplier = Supplier::findOrFail($id);
    $supplier->update([
        'name' => $request->name,
        'contact_info' => $request->contact_info,
    ]);

    return redirect()->route('suppliers.index')
        ->with('success', 'Supplier updated successfully.');
}


public function exportExcel()
{
    $suppliers = Supplier::select(
        'name',
        'contact_info'
    )
    ->orderBy('name', 'asc')
    ->get();

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=suppliers_" . date('Y-m-d') . ".csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $callback = function() use ($suppliers) {
        $file = fopen('php://output', 'w');
        
        // Add CSV headers
        fputcsv($file, [
            'Name', 
            'Contact Info'
        ]);

        // Add data rows
        foreach ($suppliers as $supplier) {
            fputcsv($file, [
                $supplier->name,
                $supplier->contact_info
            ]);
        }
        
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

public function exportPDF()
{
    $suppliers = Supplier::select(
        'name',
        'contact_info'
    )
    ->orderBy('name', 'asc')
    ->get();

    $html = view('pdf.supplier_pdf', compact('suppliers'))->render();

    $filename = 'suppliers_' . date('Y-m-d') . '.html';

    return response()->make($html, 200, [
        'Content-Type' => 'text/html',
        'Content-Disposition' => 'attachment; filename="'.$filename.'"'
    ]);
}

}