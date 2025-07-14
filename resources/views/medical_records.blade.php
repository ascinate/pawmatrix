<x-header/>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>
        <div class="col-md-6 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMedicalRecordModal">
                <i class="fas fa-plus me-1"></i> Add Medical Record
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-file-medical me-2"></i>Medical Records</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="medicalRecordsTable">
                    <thead>
                        <tr>
                            <th>Pet</th>
                            <th>Owner</th>
                            <th>Vet</th>
                            <th>Visit Date</th>
                            <th>Attachments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medicalRecords as $record)
                        <tr>
                            <td>{{ $record->pet->name }}</td>
                            <td>{{ $record->pet->client->name }}</td>
                            <td>{{ $record->vet->name ?? 'Unassigned' }}</td>
                            <td>{{ Carbon\Carbon::parse($record->visit_date)->format('M d, Y') }}</td>
                            <td>
                                @if($record->attachments->count() > 0)
                                    <span class="badge bg-primary">{{ $record->attachments->count() }}</span>
                                @else
                                    <span class="text-muted">None</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('medical-records.show', $record->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <button class="btn btn-sm btn-warning edit-btn"
                                        data-id="{{ $record->id }}"
                                        data-pet_id="{{ $record->pet_id }}"
                                        data-vet_id="{{ $record->vet_id }}"
                                        data-visit_date="{{ Carbon\Carbon::parse($record->visit_date)->format('Y-m-d\TH:i') }}"
                                        data-subjective="{{ $record->subjective }}"
                                        data-objective="{{ $record->objective }}"
                                        data-assessment="{{ $record->assessment }}"
                                        data-plan="{{ $record->plan }}"
                                        data-custom_fields="{{ $record->custom_fields }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editMedicalRecordModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <form action="{{ route('medical-records.destroy', $record->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure? This will delete all associated attachments.')">
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

<!-- Create Modal -->
<div class="modal fade" id="createMedicalRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Medical Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('medical-records.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pet</label>
                            <select name="pet_id" id="pet_id" class="form-select" required>
                                <option value="">Select Pet</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}" data-client-id="{{ $pet->client_id }}">
                                        {{ $pet->name }} (Owner: {{ $pet->client->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Veterinarian</label>
                            <select name="vet_id" id="vet_id" class="form-select" required>
                                <option value="">Select Vet</option>
                                @foreach($vets as $vet)
                                    <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Visit Date</label>
                        <input type="datetime-local" name="visit_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subjective (Owner's Concerns)</label>
                        <textarea name="subjective" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Objective (Exam Findings)</label>
                        <textarea name="objective" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assessment (Diagnosis)</label>
                        <textarea name="assessment" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Plan (Treatment)</label>
                    <select name="plan" class="form-select" required>
                    <option value="">Select Plan</option>
                    <option value="examin">Examination</option>
                    <option value="discharge">Discharge</option>
                      </select>
                   </div>
                    <div class="mb-3">
                        <label class="form-label">Custom Fields (JSON)</label>
                        <textarea name="custom_fields" class="form-control" rows="2">{"notes":""}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Attachments (X-rays, Lab Reports, etc.)</label>
                        <input type="file" name="attachments[]" class="form-control" multiple>
                        <small class="text-muted">You can upload multiple files (PDF, JPG, PNG, DOC). Max 2MB each.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editMedicalRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Medical Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editMedicalRecordForm" action="{{ route('medical-records.update', ':id') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pet</label>
                            <select name="pet_id" id="edit-pet_id" class="form-select" required>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}">{{ $pet->name }} (Owner: {{ $pet->client->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Veterinarian</label>
                            <select name="vet_id" id="edit-vet_id" class="form-select" required>
                                @foreach($vets as $vet)
                                    <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Visit Date</label>
                        <input type="datetime-local" name="visit_date" id="edit-visit_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subjective</label>
                        <textarea name="subjective" id="edit-subjective" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Objective</label>
                        <textarea name="objective" id="edit-objective" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assessment</label>
                        <textarea name="assessment" id="edit-assessment" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Plan (Treatment)</label>
                       <select name="plan" id="edit-plan" class="form-select" required>
                      <option value="examin" {{ $record->plan == 'examin' ? 'selected' : '' }}>Examination</option>
                      <option value="discharge" {{ $record->plan == 'discharge' ? 'selected' : '' }}>Discharge</option>
                      </select>
                     </div>
                    <div class="mb-3">
                        <label class="form-label">Custom Fields (JSON)</label>
                        <textarea name="custom_fields" id="edit-custom_fields" class="form-control" rows="2"></textarea>
                    </div>
                    
                    <!-- Existing Attachments -->
                    <div class="mb-3">
                        <label class="form-label">Current Attachments</label>
                        <div id="current-attachments-container" class="border p-2 rounded">
                            <p class="text-muted mb-2">No attachments found</p>
                        </div>
                    </div>
                    
                    <!-- New Attachments -->
                    <div class="mb-3">
                        <label class="form-label">Add New Attachments</label>
                        <input type="file" name="attachments[]" class="form-control" multiple>
                        <small class="text-muted">You can upload multiple files (PDF, JPG, PNG, DOC). Max 2MB each.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Modal (shown when viewing a specific record) -->
@if(isset($medicalRecord))
<div class="modal fade show" id="viewMedicalRecordModal" tabindex="-1" aria-modal="true" style="display: block; padding-right: 17px;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Medical Record Details</h5>
                <a href="{{ route('medical-records.index') }}" class="btn-close"></a>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Pet Information</h6>
                        <p><strong>Name:</strong> {{ $medicalRecord->pet->name }}</p>
                        <p><strong>Owner:</strong> {{ $medicalRecord->pet->client->name }}</p>
                        <p><strong>Species/Breed:</strong> {{ $medicalRecord->pet->species }} / {{ $medicalRecord->pet->breed }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Visit Information</h6>
                        <p><strong>Date:</strong> {{ Carbon\Carbon::parse($medicalRecord->visit_date)->format('M d, Y h:i A') }}</p>
                        <p><strong>Veterinarian:</strong> {{ $medicalRecord->vet->name ?? 'Unassigned' }}</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6>Subjective (Owner's Concerns)</h6>
                    <div class="p-3 bg-light rounded">{{ $medicalRecord->subjective }}</div>
                </div>
                
                <div class="mb-4">
                    <h6>Objective (Exam Findings)</h6>
                    <div class="p-3 bg-light rounded">{{ $medicalRecord->objective }}</div>
                </div>
                
                <div class="mb-4">
                    <h6>Assessment (Diagnosis)</h6>
                    <div class="p-3 bg-light rounded">{{ $medicalRecord->assessment }}</div>
                </div>
               <div class="mb-4">
               <h6>Plan (Treatment)</h6>
               <div class="p-3 bg-light rounded">
              {{ $medicalRecord->plan == 'examin' ? 'Examination' : 'Discharge' }}
                  </div>
                </div>
                
                @if($medicalRecord->attachments->count() > 0)
                <div class="mb-4">
                    <h6>Attachments</h6>
                    <div class="row">
                        @foreach($medicalRecord->attachments as $attachment)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-file-alt fa-2x text-primary"></i>
                                            <p class="mt-2 mb-0">{{ pathinfo($attachment->file_path, PATHINFO_FILENAME) }}</p>
                                            <small class="text-muted">{{ strtoupper($attachment->file_type) }} file</small>
                                        </div>
                                        <div>
                                            <a href="{{ asset($attachment->file_path) }}" target="_blank" class="btn btn-sm btn-primary" download>
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">Close</a>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif

<x-footer/>

