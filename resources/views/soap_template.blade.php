<x-header/>
<div class="container mt-4">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title">
                    <h2>SOAP Templates</h2>
                </div>
            </div>
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                SOAP Templates
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="tables-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4 border-0 shadow">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 fw-bold text-primary">
                                    <i class="lni lni-text-format me-2"></i>SOAP Template Management
                                </h5>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#createSoapTemplateModal">
                                    <i class="lni lni-plus me-2"></i>New Template
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive rounded">
                            <table class="table table-hover align-middle mb-0" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Name</th>
                                        <th>Category</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($templates as $template)
                                    <tr class="border-bottom">
                                        <td class="ps-4">
                                            <p class="mb-0 fw-semibold">{{ $template->name }}</p>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-1 rounded-pill">
                                                {{ ucfirst($template->category) }}
                                            </span>
                                        </td>
                                        <td>{{ $template->creator->name ?? 'System' }}</td>
                                        <td>{{ $template->created_at->format('m/d/Y H:i') }}</td>
                                        <td class="pe-4 text-end">
                                            <div class="action-buttons">
                                                <button class="btn btn-sm btn-primary action-btn edit-template-btn"
                                                    data-id="{{ $template->id }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editSoapTemplateModal"
                                                    title="Edit">
                                                    <i class="lni lni-pencil"></i>
                                                </button>

                                                <form action="{{ route('soap-templates.destroy', $template->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger action-btn" 
                                                            onclick="return confirm('Are you sure you want to delete this template?')"
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

<!-- Create Template Modal -->
<div class="modal fade" id="createSoapTemplateModal" tabindex="-1" aria-labelledby="createSoapTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSoapTemplateModalLabel">Create New SOAP Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('soap-templates.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label>Template Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Category</label>
                            <select name="category" class="form-control" required>
                                <option value="general">General</option>
                                <option value="surgery">Surgery</option>
                                <option value="dental">Dental</option>
                                <option value="vaccination">Vaccination</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Subjective</label>
                            <textarea class="form-control" name="subjective" rows="3" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <label>Objective</label>
                            <textarea class="form-control" name="objective" rows="3" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <label>Assessment</label>
                            <textarea class="form-control" name="assessment" rows="3" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <label>Plan</label>
                            <textarea class="form-control" name="plan" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Template</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Template Modal -->
<div class="modal fade" id="editSoapTemplateModal" tabindex="-1" aria-labelledby="editSoapTemplateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit SOAP Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSoapTemplateForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label>Template Name</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Category</label>
                            <select name="category" id="edit-category" class="form-control" required>
                                <option value="general">General</option>
                                <option value="surgery">Surgery</option>
                                <option value="dental">Dental</option>
                                <option value="vaccination">Vaccination</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>Subjective</label>
                            <textarea class="form-control" name="subjective" id="edit-subjective" rows="3" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <label>Objective</label>
                            <textarea class="form-control" name="objective" id="edit-objective" rows="3" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <label>Assessment</label>
                            <textarea class="form-control" name="assessment" id="edit-assessment" rows="3" required></textarea>
                        </div>
                        <div class="col-md-12">
                            <label>Plan</label>
                            <textarea class="form-control" name="plan" id="edit-plan" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Template</button>
                </div>
            </form>
        </div>
    </div>
</div>

<x-footer/>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button click to fetch template data
    document.querySelectorAll('.edit-template-btn').forEach(button => {
        button.addEventListener('click', function() {
            const templateId = this.getAttribute('data-id');
            const editForm = document.getElementById('editSoapTemplateForm');
            
            // Set the form action
            editForm.action = `/soap-templates/${templateId}`;
            
            // Fetch the template data
            fetch(`/soap-templates/template-content?id=${templateId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit-name').value = data.name;
                    document.getElementById('edit-category').value = data.category;
                    document.getElementById('edit-subjective').value = data.subjective;
                    document.getElementById('edit-objective').value = data.objective;
                    document.getElementById('edit-assessment').value = data.assessment;
                    document.getElementById('edit-plan').value = data.plan;
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Quick apply template in medical records form
    if (document.getElementById('soap-template-select')) {
        document.getElementById('soap-template-select').addEventListener('change', function() {
            const templateId = this.value;
            if (!templateId) return;
            
            fetch('/soap-templates/quick-apply', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ template_id: templateId })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('subjective').value = data.subjective;
                document.getElementById('objective').value = data.objective;
                document.getElementById('assessment').value = data.assessment;
                document.getElementById('plan').value = data.plan;
            })
            .catch(error => console.error('Error:', error));
        });
    }
});
</script>