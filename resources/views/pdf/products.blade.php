<!DOCTYPE html>
<html>
<head>
    <title>Products Inventory Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .low-stock { background-color: #fff3cd; }
        .expired { background-color: #f8d7da; }
    </style>
</head>
<body>
    <h1>Products Inventory Report</h1>
    <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>In Stock</th>
                <th>Reorder Level</th>
                <th>Price</th>
                <th>Supplier</th>
                <th>Batch No.</th>
                <th>Expiry Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="@if($product->quantity_in_stock <= $product->reorder_threshold) low-stock @endif @if($product->expiry_date && $product->expiry_date->isPast()) expired @endif">
                <td>{{ $product->name }}</td>
                <td>{{ ucfirst($product->category) }}</td>
                <td>{{ $product->quantity_in_stock }}</td>
                <td>{{ $product->reorder_threshold }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->supplier ? $product->supplier->name : 'N/A' }}</td>
                <td>{{ $product->batch_number ?? 'N/A' }}</td>
                <td>{{ $product->expiry_date ? $product->expiry_date->format('Y-m-d') : 'N/A' }}</td>
                <td>
                    @if($product->expiry_date && $product->expiry_date->isPast())
                        Expired
                    @elseif($product->quantity_in_stock <= $product->reorder_threshold)
                        Low Stock
                    @else
                        Normal
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>