<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::select(
            'purchase_orders.*',
            'suppliers.name as supplier_name'
        )
        ->leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
        ->orderBy('order_date', 'desc')
        ->get();

        return view('purchase_order', [
            'purchaseOrders' => $purchaseOrders,
            'suppliers' => Supplier::all()
        ]);
    }

    public function create()
    {
        return view('purchase_orders.create', [
            'suppliers' => Supplier::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery' => 'nullable|date',
            'status' => 'required|in:pending,received,cancelled',
            'notes' => 'nullable|string',
        ]);

        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->supplier_id = $request->supplier_id;
        $purchaseOrder->order_date = $request->order_date;
        $purchaseOrder->expected_delivery = $request->expected_delivery;
        $purchaseOrder->status = $request->status;
        $purchaseOrder->notes = $request->notes;
        $purchaseOrder->save();

        return redirect()->route('purchase-orders.show', $purchaseOrder->id)
            ->with('success', 'Purchase order created successfully.');
    }

    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::select(
            'purchase_orders.*',
            'suppliers.name as supplier_name'
        )
        ->leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
        ->where('purchase_orders.id', $id)
        ->firstOrFail();

        return view('purchase_show', [
            'purchaseOrder' => $purchaseOrder
        ]);
    }

    public function edit($id)
    {
        return view('purchase_orders.edit', [
            'purchaseOrder' => PurchaseOrder::findOrFail($id),
            'suppliers' => Supplier::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery' => 'nullable|date',
            'status' => 'required|in:pending,received,cancelled',
            'notes' => 'nullable|string',
        ]);

        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->supplier_id = $request->supplier_id;
        $purchaseOrder->order_date = $request->order_date;
        $purchaseOrder->expected_delivery = $request->expected_delivery;
        $purchaseOrder->status = $request->status;
        $purchaseOrder->notes = $request->notes;
        $purchaseOrder->save();

        return redirect()->route('purchase-orders.show', $purchaseOrder->id)
            ->with('success', 'Purchase order updated successfully.');
    }


      // Add these new methods for export
    public function exportExcel()
    {
        $purchaseOrders = PurchaseOrder::with('supplier')
            ->select(
                'id',
                'supplier_id',
                'order_date',
                'expected_delivery',
                'status',
                'notes',
                // 'created_at'
            )
            ->orderBy('order_date', 'desc')
            ->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=purchase_orders_" . date('Y-m-d') . ".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($purchaseOrders) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'PO Number',
                'Supplier',
                'Order Date',
                'Expected Delivery',
                'Status',
                'Notes',
                // 'Created At'
            ]);

            // Add data rows
            foreach ($purchaseOrders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->supplier->name ?? 'N/A',
                    $order->order_date,
                    $order->expected_delivery ?? 'N/A',
                    ucfirst($order->status),
                    $order->notes
                    // $order->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPDF()
    {
        $purchaseOrders = PurchaseOrder::with('supplier')
            ->select(
                'id',
                'supplier_id',
                'order_date',
                'expected_delivery',
                'status',
                'notes',
                // 'created_at'
            )
            ->orderBy('order_date', 'desc')
            ->get();

        $html = view('pdf.purchase_orders_pdf', compact('purchaseOrders'))->render();

        $filename = 'purchase_orders_'.date('Y-m-d').'.html';

        return response()->make($html, 200, [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"'
        ]);
    }

    public function destroy($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);
        $purchaseOrder->delete();

        session()->flash('success', 'Purchase order deleted successfully.');
        return redirect()->back();
    }
}