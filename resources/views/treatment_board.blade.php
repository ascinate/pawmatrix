<x-header/>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Today's Treatment Board</h5>
            <small class="text-muted">{{ \Carbon\Carbon::today()->format('l, F j, Y') }}</small>
        </div>
        <div class="col-md-6 text-end">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Active Treatments</h5>
                <div>
                    <span class="badge bg-secondary me-1">Waiting</span>
                    <span class="badge bg-info me-1">In Exam</span>
                    <span class="badge bg-warning me-1">In Treatment</span>
                    <span class="badge bg-success">Ready for Discharge</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="treatmentBoardTable">
                    <thead>
                        <tr>
                            <th>Appointment Time</th>
                            <th>Pet</th>
                            <th>Owner</th>
                            <th>Scheduled Vet</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                            <th>Updated By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            @php
                                $onBoard = $onBoardPets[$appointment->pet_id] ?? null;
                            @endphp
                            <tr>
                                <td>{{ $appointment->appointment_datetime->format('h:i A') }}</td>
                                <td>{{ $appointment->pet->name }}</td>
                                <td>{{ $appointment->pet->client->name }}</td>
                                <td>{{ $appointment->vet->name ?? 'Unassigned' }}</td>
                                <td>
                                    @if($onBoard)
                                        <span class="badge 
                                            @if($onBoard->status == 'waiting') bg-secondary
                                            @elseif($onBoard->status == 'in_exam') bg-info
                                            @elseif($onBoard->status == 'in_treatment') bg-warning
                                            @elseif($onBoard->status == 'ready_for_discharge') bg-success
                                            @endif">
                                            {{ str_replace('_', ' ', $onBoard->status) }}
                                        </span>
                                    @else
                                        <span class="badge bg-light text-dark">Not on board</span>
                                    @endif
                                </td>
                                <td>
                                    @if($onBoard)
                                        {{ $onBoard->updated_at ? $onBoard->updated_at->format('h:i A') : 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($onBoard && $onBoard->updatedBy)
                                        {{ $onBoard->updatedBy->name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($onBoard)
                                        <button class="btn btn-sm btn-primary edit-btn"
                                            data-id="{{ $onBoard->id }}"
                                            data-pet_id="{{ $appointment->pet_id }}"
                                            data-status="{{ $onBoard->status }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editTreatmentBoardModal">
                                            <i class="fas fa-edit"></i> Update
                                        </button>
                                    @else
                                        <form action="{{ route('treatment-board.store') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="pet_id" value="{{ $appointment->pet_id }}">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-plus"></i> Add to Board
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editTreatmentBoardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Treatment Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="editTreatmentBoardForm" action="{{ route('treatment-board.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <input type="hidden" name="pet_id" id="edit-pet_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit-status" class="form-select" required>
                            <option value="waiting">Waiting</option>
                            <option value="in_exam">In Examination</option>
                            <option value="in_treatment">In Treatment</option>
                            <option value="ready_for_discharge">Ready for Discharge</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#treatmentBoardTable').DataTable({
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [7] } // Disable sorting for Actions column
            ],
            order: [[0, 'asc']] // Default sort by Appointment Time
        });

        // Edit modal prefilling
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('edit-id').value = this.getAttribute('data-id');
                document.getElementById('edit-pet_id').value = this.getAttribute('data-pet_id');
                document.getElementById('edit-status').value = this.getAttribute('data-status');
            });
        });
    });
</script>

<x-footer/>