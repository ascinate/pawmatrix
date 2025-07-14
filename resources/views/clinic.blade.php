<x-header/>
<style>
    element.style {
    width: calc(100% - 260px);
    margin-right: inherit !important;
    /* max-width: calc(100% - 260px); */
}
</style>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClinicModal">
            <i class="lni lni-plus me-1"></i> Add Clinic
        </button>

        <!-- Export Dropdown -->
        <div class="dropdown d-inline">
            <button class="btn btn-success dropdown-toggle" type="button" id="exportDropdown" 
                    data-bs-toggle="dropdown" aria-expanded="false">
                <i class="lni lni-download me-2"></i>Export
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="exportDropdown">
                <li>
                    <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('clinics.export.excel') }}">
                        <i class="lni lni-file-excel me-2 text-success"></i>
                        <span>Excel (CSV)</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center py-2" href="{{ route('clinics.export.pdf') }}">
                        <i class="lni lni-file-pdf me-2 text-danger"></i>
                        <span>PDF Document</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clinics as $clinic)
                            <tr>
                                <td class="ps-4">{{ $clinic->name }}</td>
                                <td>{{ $clinic->address }}</td>
                                <td>{{ $clinic->phone }}</td>
                                <td>{{ $clinic->email }}</td>
                                <td class="pe-4 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                                type="button" 
                                                id="dropdownMenuButton" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                            Actions
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" 
                                            aria-labelledby="dropdownMenuButton">
                                            <li>
                                              
                                                <button class="btn btn-sm btn-warning edit-btn"
                                                    data-id="{{ $clinic->id }}"
                                                    data-name="{{ $clinic->name }}"
                                                    data-address="{{ $clinic->address }}"
                                                    data-phone="{{ $clinic->phone }}"
                                                    data-email="{{ $clinic->email }}"
                                                    data-branding_json="{{ $clinic->branding_json }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editClinicModal">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>

                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('clinics.destroy', $clinic->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this clinic?')">
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

<!-- Add Clinic Modal -->
<div class="modal fade" id="addClinicModal" tabindex="-1" aria-labelledby="addClinicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClinicModalLabel">Add New Clinic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('clinics.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3" required></textarea>
                        </div>
                        <!-- <div class="col-12">
                            <label class="form-label">Branding Settings (JSON)</label>
                            <textarea name="branding_json" class="form-control" rows="5" placeholder='{"primary_color":"#4d8cff","logo_url":"path/to/logo.png"}'></textarea>
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Clinic</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Clinic Modal -->
<!-- Edit Clinic Modal -->
<div class="modal fade" id="editClinicModal" tabindex="-1" aria-labelledby="editClinicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editClinicModalLabel">Edit Clinic</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ url('/clinics/update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" id="edit-clinic-id"> <!-- clinic id -->

        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Clinic Name</label>
              <input type="text" name="name" id="edit-name" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Phone</label>
              <input type="text" name="phone" id="edit-phone" class="form-control" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" id="edit-email" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Address</label>
              <input type="text" name="address" id="edit-address" class="form-control" required>
            </div>
          </div>

          <!-- <div class="mb-3">
            <label class="form-label">Branding Settings (JSON)</label>
            <textarea name="branding_json" id="edit-branding_json" class="form-control" rows="4"></textarea>
          </div> -->
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Clinic</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- @endsection

@section('scripts')
<script>
   
</script>
@endsection --}}
<x-footer/>