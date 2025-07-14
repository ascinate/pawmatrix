<x-header/>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Appointment Details</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Appointments
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Appointment Information</h5>
        </div>
        <div class="card-body">
            <!-- Recurring Series Info (if applicable) -->
            @if($appointment->is_recurring || $appointment->parent_appointment_id)
            <div class="alert alert-info mb-4">
                <h6><i class="fas fa-calendar-week me-2"></i> Recurring Appointment Series</h6>
                @if($appointment->is_recurring)
                    <p>This is the parent appointment of a recurring series.</p>
                    <p><strong>Pattern:</strong> {{ ucfirst($appointment->recurrence_pattern) }} every {{ $appointment->recurrence_interval }} 
                        @if($appointment->recurrence_pattern == 'daily') day(s)
                        @elseif($appointment->recurrence_pattern == 'weekly') week(s)
                        @elseif($appointment->recurrence_pattern == 'monthly') month(s)
                        @else year(s)
                        @endif
                    </p>
                    @if($appointment->recurrence_weekdays)
                        <p><strong>Days:</strong> 
                            @foreach(json_decode($appointment->recurrence_weekdays) as $day)
                                {{ ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][$day] }}@if(!$loop->last), @endif
                            @endforeach
                        </p>
                    @endif
                    <p><strong>End Date:</strong> {{ Carbon\Carbon::parse($appointment->recurrence_end_date)->format('M d, Y') }}</p>
                    <p><strong>Total Appointments:</strong> {{ $appointment->childAppointments->count() + 1 }}</p>
                @else
                    <p>This is part of a recurring appointment series.</p>
                    <p><strong>Parent Appointment:</strong> 
                        <a href="{{ route('appointments.show', $appointment->parentAppointment->id) }}">
                            {{ Carbon\Carbon::parse($appointment->parentAppointment->appointment_datetime)->format('M d, Y h:i A') }}
                        </a>
                    </p>
                @endif
            </div>
            @endif

            <!-- Walk-in Indicator -->
            @if($appointment->is_walk_in)
            <div class="alert alert-warning mb-4">
                <i class="fas fa-exclamation-circle me-2"></i> This is a walk-in appointment.
            </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>Client Information</h6>
                        <p><strong>Name:</strong> {{ $appointment->client->name }}</p>
                        <p><strong>Phone:</strong> {{ $appointment->client->phone }}</p>
                        <p><strong>Email:</strong> {{ $appointment->client->email }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>Pet Information</h6>
                        <p><strong>Name:</strong> {{ $appointment->pet->name }}</p>
                        <p><strong>Species:</strong> {{ $appointment->pet->species }}</p>
                        <p><strong>Breed:</strong> {{ $appointment->pet->breed }}</p>
                        <p><strong>Age:</strong> {{ $appointment->pet->age }} years</p>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>Appointment Details</h6>
                        <p><strong>Clinic:</strong> {{ $appointment->clinic->name }}</p>
                        <p><strong>Vet:</strong> {{ $appointment->vet->name ?? 'Unassigned' }}</p>
                        <p><strong>Date & Time:</strong> {{ Carbon\Carbon::parse($appointment->appointment_datetime)->format('F j, Y, g:i a') }}</p>
                        <p><strong>Duration:</strong> {{ $appointment->duration_minutes }} minutes</p>
                        <p><strong>Status:</strong> 
                            <span class="badge 
                                @if($appointment->status == 'scheduled') bg-primary
                                @elseif($appointment->status == 'completed') bg-success
                                @else bg-danger
                                @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </p>
                        <p><strong>Type:</strong> 
                            @if($appointment->is_recurring)
                                <span class="badge bg-info">Recurring Series</span>
                            @elseif($appointment->parent_appointment_id)
                                <span class="badge bg-secondary">Recurring Instance</span>
                            @elseif($appointment->is_walk_in)
                                <span class="badge bg-warning text-dark">Walk-in</span>
                            @else
                                <span class="badge bg-light text-dark">Scheduled</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <h6>Notes</h6>
                        <p>{{ $appointment->notes ?? 'No notes available' }}</p>
                    </div>
                </div>
            </div>

            <!-- Show child appointments if this is a parent recurring appointment -->
            @if($appointment->is_recurring && $appointment->childAppointments->count() > 0)
            <hr>
            <div class="mt-4">
                <h6>Upcoming Appointments in This Series</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointment->childAppointments->sortBy('appointment_datetime') as $child)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($child->appointment_datetime)->format('M d, Y h:i A') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($child->status == 'scheduled') bg-primary
                                        @elseif($child->status == 'completed') bg-success
                                        @else bg-danger
                                        @endif">
                                        {{ ucfirst($child->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('appointments.show', $child->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <div class="card-footer text-end">
            <!-- Edit Button (Triggers Modal) -->
            <button class="btn btn-warning me-2 edit-btn"
                data-id="{{ $appointment->id }}"
                data-client_id="{{ $appointment->client_id }}"
                data-pet_id="{{ $appointment->pet_id }}"
                data-clinic_id="{{ $appointment->clinic_id }}"
                data-vet_id="{{ $appointment->vet_id }}"
                data-appointment_datetime="{{ Carbon\Carbon::parse($appointment->appointment_datetime)->format('Y-m-d\TH:i') }}"
                data-duration_minutes="{{ $appointment->duration_minutes }}"
                data-status="{{ $appointment->status }}"
                data-notes="{{ $appointment->notes }}"
                data-is_walk_in="{{ $appointment->is_walk_in }}"
                data-bs-toggle="modal"
                data-bs-target="#editAppointmentModal">
                <i class="fas fa-edit me-1"></i> Edit
            </button>

            <!-- Back Button -->
            <a href="{{ route('appointments.index') }}" class="btn btn-primary">
                <i class="fas fa-list me-1"></i> Back to List
            </a>
        </div>
    </div>
</div>

<!-- Edit Appointment Modal -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAppointmentModalLabel">Edit Appointment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ url('/appointments/update') }}" method="POST">
        @csrf
        <input type="hidden" name="id" id="edit-appointment-id">

        <div class="modal-body">
          <div class="row">
            <!-- Client -->
            <div class="col-md-6 mb-3">
              <label class="form-label">Client</label>
              <select name="client_id" id="edit-client_id" class="form-select" required>
                @foreach($clients as $client)
                  <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
              </select>
            </div>

            <!-- Pet -->
            <div class="col-md-6 mb-3">
              <label class="form-label">Pet</label>
              <select name="pet_id" id="edit-pet_id" class="form-select" required>
                @foreach($pets as $pet)
                  <option value="{{ $pet->id }}" data-client-id="{{ $pet->client_id }}">
                    {{ $pet->name }} ({{ $pet->species }})
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row">
            <!-- Clinic -->
            <div class="col-md-6 mb-3">
              <label class="form-label">Clinic</label>
              <select name="clinic_id" id="edit-clinic_id" class="form-select" required>
                @foreach($clinics as $clinic)
                  <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                @endforeach
              </select>
            </div>

            <!-- Vet -->
            <div class="col-md-6 mb-3">
              <label class="form-label">Vet</label>
              <select name="vet_id" id="edit-vet_id" class="form-select" required>
                @foreach($vets as $vet)
                  <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row">
            <!-- Date & Time -->
            <div class="col-md-6 mb-3">
              <label class="form-label">Date & Time</label>
              <input type="datetime-local" name="appointment_datetime" id="edit-appointment_datetime" class="form-control" required>
            </div>

            <!-- Duration -->
            <div class="col-md-6 mb-3">
              <label class="form-label">Duration (minutes)</label>
              <input type="number" name="duration_minutes" id="edit-duration_minutes" class="form-control" required>
            </div>
          </div>

          <!-- Status -->
          <div class="col-md-6 mb-3">
            <label class="form-label">Status</label>
            <select name="status" id="edit-status" class="form-select" required>
              <option value="scheduled">Scheduled</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>

          <!-- Walk-in Checkbox -->
          <div class="col-md-6 mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="is_walk_in" id="edit-is_walk_in" value="1">
              <label class="form-check-label" for="edit-is_walk_in">Walk-in Appointment</label>
            </div>
          </div>

          <!-- Notes -->
          <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" id="edit-notes" class="form-control" rows="3"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Appointment</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button click to pre-fill the modal
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('edit-appointment-id').value = this.getAttribute('data-id');
            document.getElementById('edit-client_id').value = this.getAttribute('data-client_id');
            document.getElementById('edit-pet_id').value = this.getAttribute('data-pet_id');
            document.getElementById('edit-clinic_id').value = this.getAttribute('data-clinic_id');
            document.getElementById('edit-vet_id').value = this.getAttribute('data-vet_id');
            document.getElementById('edit-appointment_datetime').value = this.getAttribute('data-appointment_datetime');
            document.getElementById('edit-duration_minutes').value = this.getAttribute('data-duration_minutes');
            document.getElementById('edit-status').value = this.getAttribute('data-status');
            document.getElementById('edit-notes').value = this.getAttribute('data-notes');
            document.getElementById('edit-is_walk_in').checked = this.getAttribute('data-is_walk_in') === '1';

            // Filter pet options based on client
            const clientId = this.getAttribute('data-client_id');
            const petSelect = document.getElementById('edit-pet_id');
            [...petSelect.options].forEach(option => {
                const petClientId = option.getAttribute('data-client-id');
                option.style.display = (petClientId === clientId) ? 'block' : 'none';
            });
        });
    });

    // Handle client change in edit modal to filter pets
    const editClientSelect = document.getElementById('edit-client_id');
    if (editClientSelect) {
        editClientSelect.addEventListener('change', function() {
            const clientId = this.value;
            const petSelect = document.getElementById('edit-pet_id');
            
            [...petSelect.options].forEach(option => {
                if (option.value === '') return; // keep the "Select Pet" option
                const petClientId = option.getAttribute('data-client-id');
                option.style.display = (petClientId === clientId) ? 'block' : 'none';
            });
            
            // Reset pet selection when client changes
            petSelect.value = '';
        });
    }
});
</script>

<x-footer/>