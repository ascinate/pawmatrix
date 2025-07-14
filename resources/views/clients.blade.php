<x-header/>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />

<div class="container mt-4">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>Client Management</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="admin.dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Clients
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
                                    <i class="lni lni-users me-2"></i>Client Management
                                </h5>
                            </div>
                            <div class="d-flex gap-2">
                                <!-- Create Button -->
                                <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#createClientModal">
                                    <i class="lni lni-plus me-2"></i>Create Client
                                </button>
                                
                                <!-- Export Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-success px-4 dropdown-toggle" type="button" id="exportDropdown" 
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="lni lni-download me-2"></i>Export
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="exportDropdown">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('clients.export.excel') }}">
                                                <i class="lni lni-file-excel me-2 text-success"></i>
                                                <span>Excel (CSV)</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('clients.export.pdf') }}">
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
                            <table id="clientsTable" class="table table-hover align-middle mb-0" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 text-uppercase text-secondary text-xs font-weight-bolder">Name</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">Phone</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">Email</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">Preferred Contact</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">Pets</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder">Documents</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bolder text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clients as $client)
                                    <tr class="border-bottom">
                                        <td class="ps-4">
                                            <p class="mb-0 fw-semibold">{{ $client->name }}</p>
                                        </td>
                                        <td>
                                            <a href="tel:{{ $client->phone }}" class="text-decoration-none">
                                                {{ $client->phone }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $client->email }}" class="text-primary text-decoration-none">
                                                {{ $client->email }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-1 rounded-pill">
                                                {{ ucfirst($client->preferred_contact_method) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill">
                                                {{ $client->pets_count }} pets
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-1 rounded-pill">
                                                {{ $client->documents_count }} docs
                                            </span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <div class="action-buttons">
                                                <!-- View Button -->
                                                <a href="{{ route('clients.show', $client->id) }}" 
                                                   class="btn btn-sm btn-info action-btn" 
                                                   title="View Details">
                                                    <i class="lni lni-eye"></i>
                                                </a>
                                                
                                                <!-- Edit Client Button -->
                                                <button class="btn btn-sm btn-primary action-btn edit-client-btn"
                                                    data-id="{{ $client->id }}"
                                                    data-name="{{ $client->name }}"
                                                    data-email="{{ $client->email }}"
                                                    data-phone="{{ $client->phone }}"
                                                    data-address="{{ $client->address }}"
                                                    data-preferred_contact_method="{{ $client->preferred_contact_method }}"
                                                    data-notes="{{ $client->notes }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editClientModal"
                                                    title="Edit">
                                                    <i class="lni lni-pencil"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger action-btn" 
                                                            onclick="return confirm('Are you sure you want to delete this client?')"
                                                            title="Delete">
                                                        <i class="lni lni-trash-can"></i>
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
        </div>
    </div>
</div>

<!-- Create Client Modal -->
<div class="modal fade" id="createClientModal" tabindex="-1" aria-labelledby="createClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClientModalLabel">Add New Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-lg-6">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Preferred Contact Method</label>
                            <select name="preferred_contact_method" class="form-control" required>
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="sms">SMS</option>
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <label>Documents</label>
                            <input type="file" name="documents[]" class="form-control" multiple>
                            <small class="text-muted">You can upload multiple documents (PDF, JPG, PNG, DOC)</small>
                        </div>

                        <div class="col-lg-12">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control">
                        </div>
                        <div class="col-lg-12">
                            <label>Notes</label>
                            <textarea name="notes" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Client</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Client Modal -->
<div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ url('/clients/update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-client-id">

                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-lg-6">
                            <label>Name</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Email</label>
                            <input type="email" name="email" id="edit-email" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Phone</label>
                            <input type="text" name="phone" id="edit-phone" class="form-control" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Preferred Contact Method</label>
                            <select name="preferred_contact_method" id="edit-contact-method" class="form-select" required>
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="sms">SMS</option>
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <label>Address</label>
                            <input type="text" name="address" id="edit-address" class="form-control">
                        </div>

                        <div class="col-lg-12">
                            <label>Notes</label>
                            <textarea name="notes" id="edit-notes" class="form-control"></textarea>
                        </div>

                        <div class="col-lg-12">
                            <label>Upload Additional Documents (optional)</label>
                            <input type="file" name="documents[]" class="form-control" multiple>
                            <small class="text-muted">You can upload multiple documents (PDF, JPG, PNG, DOC)</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Client</button>
                </div>
            </form>
        </div>
    </div>
</div>

<x-footer/>


<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.edit-client-btn').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('edit-client-id').value = this.getAttribute('data-id');
                document.getElementById('edit-name').value = this.getAttribute('data-name');
                document.getElementById('edit-email').value = this.getAttribute('data-email');
                document.getElementById('edit-phone').value = this.getAttribute('data-phone');
                document.getElementById('edit-address').value = this.getAttribute('data-address');
                document.getElementById('edit-contact-method').value = this.getAttribute('data-preferred_contact_method');
                document.getElementById('edit-notes').value = this.getAttribute('data-notes');
            });
        });
    });
</script> -->
