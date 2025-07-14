<x-header/>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Product Management</h2>
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
                <i class="fas fa-plus me-1"></i> Add Product
            </button>
        </div>
    </div>

    <div class="card product-card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Products</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Supplier</th>
                            <th>Expiry Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ ucfirst($product->category) }}</td>
                            <td>
                                <span class="{{ $product->quantity_in_stock <= $product->reorder_threshold ? 'text-danger' : '' }}">
                                    {{ $product->quantity_in_stock }}
                                    @if($product->quantity_in_stock <= $product->reorder_threshold)
                                        <i class="fas fa-exclamation-circle" title="Low stock! Reorder needed"></i>
                                    @endif
                                </span>
                            </td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->supplier->name ?? 'N/A' }}</td>
                            <td>{{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('M d, Y') : 'N/A' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <button class="btn btn-sm btn-warning edit-product-btn"
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
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
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

<!-- Create Product Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="">Select Category</option>
                                <option value="medication">Medication</option>
                                <option value="food">Food</option>
                                <option value="retail">Retail</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Quantity in Stock</label>
                            <input type="number" name="quantity_in_stock" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Reorder Threshold</label>
                            <input type="number" name="reorder_threshold" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Supplier</label>
                            <select name="supplier_id" class="form-select">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Batch Number</label>
                            <input type="text" name="batch_number" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
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

      <form action="{{ url('/products/update') }}" method="POST" id="editProductForm">
        @csrf
        <input type="hidden" name="id" id="edit-id">
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