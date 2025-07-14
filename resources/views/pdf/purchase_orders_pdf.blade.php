<!DOCTYPE html>
<html>
<head>
    <title>Purchase Orders Export</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .title { text-align: center; margin-bottom: 20px; }
        .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }
        .badge-pending { background-color: #ffc107; }
        .badge-received { background-color: #28a745; }
        .badge-cancelled { background-color: #dc3545; }
        @media print {
            body { padding: 20px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="title">
        <h1>Purchase Orders List</h1>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
        <p class="no-print">Note: Use your browser's "Print to PDF" function to save as PDF</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>PO #</th>
                <th>Supplier</th>
                <th>Order Date</th>
                <th>Expected Delivery</th>
                <th>Status</th>
                <th>Notes</th>
                <!-- <th>Created At</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseOrders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->supplier->name ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</td>
                <td>{{ $order->expected_delivery ? \Carbon\Carbon::parse($order->expected_delivery)->format('Y-m-d') : 'N/A' }}</td>
                <td>
                    <span class="badge badge-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>{{ $order->notes ?? 'N/A' }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print/Save as PDF
        </button>
    </div>
</body>
</html>