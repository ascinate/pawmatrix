<x-header/>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Purchase Order Management</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Purchase Orders</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 border-0 shadow po-details-card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-primary">
                                <i class="lni lni-cart me-2"></i>Purchase Orders
                            </h5>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- Create Button -->
                            <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#createPOModal">
                                <i class="lni lni-plus me-2"></i>Create PO
                            </button>
                            
                            <!-- Export Dropdown -->
                           <!-- Export Dropdown -->
<div class="dropdown">
    <button class="btn btn-success px-4 dropdown-toggle" type="button" id="exportDropdown" 
            data-bs-toggle="dropdown" aria-expanded="false">
        <i class="lni lni-download me-2"></i>Export
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="exportDropdown">
        <li>
            <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('purchase-orders.export.excel') }}">
                <i class="lni lni-file-excel me-2 text-success"></i>
                <span>Excel (CSV)</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('purchase-orders.export.pdf') }}">
                <i class="lni lni-file-pdf me-2 text-danger"></i>
                <span>PDF Document</span>
            </a>
        </li>
    </ul>
</div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive rounded">
                        <table id="poTable" class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder">PO #</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder">Supplier</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder">Order Date</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder">Expected Delivery</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder">Status</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchaseOrders as $order)
                                <tr class="border-bottom">
                                    <td class="ps-4">
                                        <p class="mb-0 fw-semibold">#{{ $order->id }}</p>
                                    </td>
                                    <td>
                                        {{ $order->supplier->name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}
                                    </td>
                                    <td>
                                        {{ $order->expected_delivery ? \Carbon\Carbon::parse($order->expected_delivery)->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill badge-{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                                    type="button" 
                                                    id="dropdownMenuButton-{{ $order->id }}" 
                                                    data-bs-toggle="dropdown" 
                                                    aria-expanded="false">
                                                Action
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" 
                                                aria-labelledby="dropdownMenuButton-{{ $order->id }}">
                                                <!-- View Option -->
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('purchase-orders.show', $order->id) }}">
                                                        <i class="lni lni-eye text-info"></i>
                                                        <span>View Details</span>
                                                    </a>
                                                </li>

                                                <!-- Edit Option -->
                                                <li>
                                                 <button class="dropdown-item d-flex align-items-center gap-2 editBtn"
        data-edit-type="purchase-order"
        data-id="{{ $order->id }}"
        data-supplier_id="{{ $order->supplier_id }}"
        data-order_date="{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}"
        data-expected_delivery="{{ $order->expected_delivery ? \Carbon\Carbon::parse($order->expected_delivery)->format('Y-m-d') : '' }}"
        data-status="{{ $order->status }}"
        data-notes="{{ $order->notes }}"
        data-bs-toggle="modal"
        data-bs-target="#editPOModal">
    <i class="lni lni-pencil text-primary"></i>
    <span>Edit</span>
</button>
                                                </li>

                                                <!-- Delete Option -->
                                                <li>
                                                    <form action="{{ route('purchase-orders.destroy', $order->id) }}" method="POST" class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                                            <i class="lni lni-trash-can"></i>
                                                            <span>Delete</span>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create PO Modal -->
<div class="modal fade" id="createPOModal" tabindex="-1" aria-labelledby="createPOModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPOModalLabel">Create New Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('purchase-orders.store') }}" method="POST">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @csrf
                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label for="supplier_id" class="form-label">Supplier</label>
                            <select name="supplier_id" class="form-control" required>
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="order_date" class="form-label">Order Date</label>
                            <input type="date" name="order_date" class="form-control" value="{{ old('order_date', date('Y-m-d')) }}" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="expected_delivery" class="form-label">Expected Delivery Date</label>
                            <input type="date" name="expected_delivery" class="form-control" value="{{ old('expected_delivery') }}">
                        </div>
                        
<div class="col-md-6">
        <label for="status" class="form-label">Status</label>
        <select name="status" class="form-control" required>
            <option value="">Select Status</option>
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="received" {{ old('status') == 'received' ? 'selected' : '' }}>Received</option>
            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>
                        
                        <div class="col-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit PO Modal -->
<div class="modal fade" id="editPOModal" tabindex="-1" aria-labelledby="editPOModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPOModalLabel">Edit Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="editPOForm" action="{{ route('purchase-orders.update', ':id') }}">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label for="edit-supplier_id" class="form-label">Supplier</label>
                            <select name="supplier_id" id="edit-supplier_id" class="form-control" required>
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="edit-order_date" class="form-label">Order Date</label>
                            <input type="date" name="order_date" id="edit-order_date" class="form-control" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="edit-expected_delivery" class="form-label">Expected Delivery Date</label>
                            <input type="date" name="expected_delivery" id="edit-expected_delivery" class="form-control">
                        </div>
                        
    <!-- Update status options in edit modal -->
    <div class="col-md-6">
        <label for="edit-status" class="form-label">Status</label>
        <select name="status" id="edit-status" class="form-control" required>
            <option value="">Select Status</option>
            <option value="pending">Pending</option>
            <option value="received">Received</option>
            <option value="cancelled">Cancelled</option>
        </select>
    </div>
                        
                        <div class="col-12">
                            <label for="edit-notes" class="form-label">Notes</label>
                            <textarea name="notes" id="edit-notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Order</button>
                </div>
            </form>
        </div>
    </div>
</div>


<x-footer/>