<x-header/>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Purchase Order Details</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('purchase-orders.index') }}">Purchase Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">PO #{{ $purchaseOrder->id }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Supplier Information</h6>
                            <p class="mb-1"><strong>Name:</strong> {{ $purchaseOrder->supplier->name ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Contact:</strong> {{ $purchaseOrder->supplier->contact_info ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Order Information</h6>
                            <p class="mb-1"><strong>Status:</strong> 
                                <span class="badge badge-{{ $purchaseOrder->status }}">
                                    {{ ucfirst($purchaseOrder->status) }}
                                </span>
                            </p>
                            <p class="mb-1"><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($purchaseOrder->order_date)->format('M d, Y') }}</p>
                            <p class="mb-1"><strong>Expected Delivery:</strong> 
                                {{ $purchaseOrder->expected_delivery ? \Carbon\Carbon::parse($purchaseOrder->expected_delivery)->format('M d, Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6>Notes</h6>
                        <p>{{ $purchaseOrder->notes ?? 'No notes available' }}</p>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary me-2">Back to List</a>
                        <a href="{{ route('purchase-orders.edit', $purchaseOrder->id) }}" class="btn btn-primary">Edit Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-footer/>