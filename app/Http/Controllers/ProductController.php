<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductController extends Controller
{
public function inventory()
{
    $products = Product::orderBy('name')->get();

    // Get the 6 most recently updated products
    $recentProducts = Product::orderBy('updated_at', 'desc')->take(6)->get();

    $notifications = [];

    foreach ($recentProducts as $product) {
        $now = Carbon::now();
        $status = null;

        if ($product->expiry_date && $now->gt(Carbon::parse($product->expiry_date))) {
            $status = 'expired';
        } elseif (
            $product->quantity_in_stock !== null &&
            $product->reorder_threshold !== null &&
            $product->quantity_in_stock <= $product->reorder_threshold
        ) {
            $status = 'low';
        } else {
            $status = 'available';
        }

        $notifications[] = [
            'name'     => $product->name,
            'batch'    => $product->batch_number ?? 'N/A',
            'quantity' => $product->quantity_in_stock ?? 0,
            'status'   => $status,
            'time'     => Carbon::parse($product->updated_at)->diffForHumans(),
        ];
    }

    return view('inventory', compact('products', 'notifications'));
}

    public function create()
    {
        return view('products.create', [
            'suppliers' => Supplier::orderBy('name')->get()
        ]);
    }

 public function store(Request $request)
{
    $request->validate([
        'product_name'  => 'required|string|max:100',
        'quantity_available'      => 'required|integer|min:1',
        'expire_date'   => 'required|date|after_or_equal:today',
    ]);

    $batchNumber = 'BATCH-' . strtoupper(Str::random(6));

    Product::create([
        'name'              => $request->input('product_name'),
        'category'          => 'medication', // or dynamic if needed
        'quantity_in_stock' => $request->input('quantity_available'),
        'expiry_date'       => $request->input('expire_date'),
        'batch_number'      => $batchNumber,
        'created_at'        => now(),
        'updated_at'        => now(),
    ]);

    return redirect()->back()->with('success', 'New inventory item added successfully.');
}
    public function show(Product $product)
    {
        $product = Product::select(
            'products.*',
            'suppliers.name as supplier_name'
        )
        ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
        ->where('products.id', $product->id)
        ->first();

        return view('product_view', [
            'product' => $product,
            'suppliers' => Supplier::orderBy('name')->get()
        ]);
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'suppliers' => Supplier::orderBy('name')->get()
        ]);
    }

  public function update(Request $request)
{
    $validated = $request->validate([
        'id' => 'required|exists:products,id',
        'name' => 'required|string|max:100',
        'category' => 'required|in:medication,food,retail',
        'quantity_in_stock' => 'required|integer|min:0',
        'reorder_threshold' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'supplier_id' => 'nullable|exists:suppliers,id',
        'batch_number' => 'nullable|string|max:50',
        'expiry_date' => 'nullable|date',
    ]);

    $product = Product::findOrFail($validated['id']);
    $product->update($validated);

    return redirect()->route('products.index')->with('success', 'Product updated successfully!');
}


public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->back()->with('success', 'Product deleted successfully.');
}


    public function restock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product->increment('quantity_in_stock', $validated['quantity']);

        return redirect()->back()
            ->with('success', 'Product restocked successfully!');
    }

    public function exportExcel()
    {
        // Implement Excel export logic
        return response()->download('path/to/excel/file.xlsx');
    }

    public function exportPdf()
    {
        // Implement PDF export logic
        return response()->download('path/to/pdf/file.pdf');
    }
}