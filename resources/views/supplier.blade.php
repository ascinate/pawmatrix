<x-header/>

{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}


 <div class="container mt-4">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Supplier Management</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin.dashboard')}}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Suppliers
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="tables-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4 border-0 shadow">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 fw-bold text-primary">
                                        <i class="lni lni-delivery me-2"></i>Supplier Management
                                    </h5>
                                </div>
                                <div class="d-flex gap-2">
                                    <!-- Create Button -->
                                    <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#createSupplierModal">
                                        <i class="lni lni-plus me-2"></i>Add Supplier
                                    </button>
                                    
                                    <!-- Export Dropdown -->
                                   <div class="dropdown">
    <button class="btn btn-success px-4 dropdown-toggle" type="button" id="exportDropdown" 
            data-bs-toggle="dropdown" aria-expanded="false">
        <i class="lni lni-download me-2"></i>Export
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="exportDropdown">
        <li>
            <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('suppliers.export.excel') }}">
                <i class="lni lni-file-excel me-2 text-success"></i>
                <span>Excel (CSV)</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('suppliers.export.pdf') }}">
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
                                <table id="suppliersTable" class="table table-hover align-middle mb-0" style="width:100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder">Name</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder">Contact Info</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder">Products</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($suppliers as $supplier)
                                        <tr class="border-bottom">
                                            <td class="ps-4">
                                                <p class="mb-0 fw-semibold">{{ $supplier->name }}</p>
                                            </td>
                                            <td>
                                                {{ $supplier->contact_info ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">
                                                    {{ $supplier->products->count() }} products
                                                </span>
                                            </td>
                                            <td class="pe-4 text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary" 
                                                            type="button" 
                                                            id="dropdownMenuButton" 
                                                            data-bs-toggle="dropdown" 
                                                            aria-expanded="false">
                                                        Action
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" 
                                                        aria-labelledby="dropdownMenuButton">

                                                        <!-- Edit Option -->
                                                        <li>
                                                            <button class="dropdown-item d-flex align-items-center gap-2 editSupplierBtn"
                                                                        data-id="{{ $supplier->id }}"
                                                                        data-name="{{ $supplier->name }}"
                                                                        data-contact_info="{{ $supplier->contact_info }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editSupplierModal">
                                                                    <i class="lni lni-pencil text-primary"></i>
                                                                    <span>Edit</span>
                                                                </button>
                                                        </li>

                                                        <!-- Delete Option -->
                                                        <li>
                                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger" onclick="return confirm('Are you sure you want to delete this supplier?')">
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
    </div>


<!-- Create Supplier Modal -->
<div class="modal fade" id="createSupplierModal" tabindex="-1" aria-labelledby="createSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSupplierModalLabel">Add New Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('suppliers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-lg-12">
                            <label>Supplier Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-lg-12">
                            <label>Contact Information</label>
                            <textarea name="contact_info" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Supplier Modal -->
<div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="editSupplierForm" action="{{ route('suppliers.update', ':id') }}">
       @csrf
         @method('PUT')
                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-lg-12">
                            <label>Supplier Name</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                        <div class="col-lg-12">
                            <label>Contact Information</label>
                            <textarea name="contact_info" id="edit-contact_info" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.editSupplierBtn');
        const form = document.getElementById('editSupplierForm');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const contactInfo = this.dataset.contact_info;

                // Fill the form fields
                document.getElementById('edit-name').value = name;
                document.getElementById('edit-contact_info').value = contactInfo;

                // Set the form action URL
                const action = form.getAttribute('action').replace(':id', id);
                form.setAttribute('action', action);
            });
        });
    });
</script> -->

<x-footer/>