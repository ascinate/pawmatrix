<x-header/>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Product Details</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Products
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Product Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>Basic Information</h6>
                        <p><strong>Name:</strong> {{ $product->name }}</p>
                        <p><strong>Category:</strong> {{ ucfirst($product->category) }}</p>
                        <p><strong>Batch Number:</strong> {{ $product->batch_number ?? 'N/A' }}</p>
                        <p><strong>Supplier:</strong> {{ $product->supplier->name ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>Inventory Details</h6>
                        <p><strong>Quantity in Stock:</strong> 
                            <span class="{{ $product->quantity_in_stock <= $product->reorder_threshold ? 'text-danger' : '' }}">
                                {{ $product->quantity_in_stock }}
                                @if($product->quantity_in_stock <= $product->reorder_threshold)
                                    (Low Stock)
                                @endif
                            </span>
                        </p>
                        <p><strong>Reorder Threshold:</strong> {{ $product->reorder_threshold }}</p>
                        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                        <p><strong>Expiry Date:</strong> {{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('M d, Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button class="btn btn-warning me-2 edit-btn"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-category="{{ $product->category }}"
                data-quantity_in_stock="{{ $product->quantity_in_stock }}"
                data-reorder_threshold="{{ $product->reorder_threshold }}"
                data-batch_number="{{ $product->batch_number }}"
                data-expiry_date="{{ $product->expiry_date }}"
                data-price="{{ $product->price }}"
                data-supplier_id="{{ $product->supplier_id }}"
                data-bs-toggle="modal"
                data-bs-target="#editProductModal">
                <i class="fas fa-edit me-1"></i> Edit
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="fas fa-list me-1"></i> Back to List
            </a>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="editProductForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" id="edit-category" class="form-select" required>
                                <option value="medication">Medication</option>
                                <option value="food">Food</option>
                                <option value="retail">Retail</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Quantity in Stock</label>
                            <input type="number" name="quantity_in_stock" id="edit-quantity_in_stock" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Reorder Threshold</label>
                            <input type="number" name="reorder_threshold" id="edit-reorder_threshold" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" id="edit-price" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Supplier</label>
                            <select name="supplier_id" id="edit-supplier_id" class="form-select">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Batch Number</label>
                            <input type="text" name="batch_number" id="edit-batch_number" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" name="expiry_date" id="edit-expiry_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<x-footer/>