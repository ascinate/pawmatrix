@extends('layouts.app')

@section('content')
<style>
    .custom-action-btn {
        background-color: #4d8cff;
        color: black;
        border: none;
        border-radius: 30px;
        padding: 6px 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-weight: 500;
    }

    .custom-action-btn:hover {
        background-color: #3a76e0;
        color: white;
    }
    
    .appointment-details-card {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-radius: 10px;
    }

    .appointment-details-card .card-header {
        background-color: #4d8cff;
        color: white;
        border-radius: 10px 10px 0 0 !important;
    }

    .summary-table th {
        background-color: #f8f9fa;
    }
    
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 500;
    }
    
    .status-scheduled {
        background-color: #e3f2fd;
        color: #1976d2;
    }
    
    .status-completed {
        background-color: #e8f5e9;
        color: #388e3c;
    }
    
    .status-cancelled {
        background-color: #ffebee;
        color: #d32f2f;
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<section class="table-components">
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Appointment Management</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#0">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Appointments
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
                                        <i class="fas fa-calendar-alt me-2"></i>Appointment Management
                                    </h5>
                                </div>
                                <div class="d-flex gap-2">
                                    <!-- Create Button -->
                                    <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#createAppointmentModal">
                                        <i class="fas fa-plus me-2"></i>Add Appointment
                                    </button>
                                    
                                    <!-- Calendar View Button -->
                                    <a href="{{ route('appointments.calendar') }}" class="btn btn-success px-4">
                                        <i class="fas fa-calendar me-2"></i>Calendar View
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive rounded">
                                <table id="appointmentsTable" class="table table-hover align-middle mb-0" style="width:100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Client</th>
                                            <th>Pet</th>
                                            <th>Clinic</th>
                                            <th>Date & Time</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th class="text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appointments as $appointment)
                                        <tr class="border-bottom">
                                            <td class="ps-4">
                                                <p class="mb-0 fw-semibold">{{ $appointment->client->name }}</p>
                                            </td>
                                            <td>
                                                {{ $appointment->pet->name }}
                                            </td>
                                            <td>
                                                {{ $appointment->clinic->name }}
                                            </td>
                                            <td>
                                                {{ $appointment->appointment_datetime->format('M d, Y h:i A') }}
                                            </td>
                                            <td>
                                                {{ $appointment->duration_minutes }} mins
                                            </td>
                                            <td>
                                                <span class="status-badge status-{{ $appointment->status }}">
                                                    {{ ucfirst($appointment->status) }}
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
                                                            <button class="dropdown-item d-flex align-items-center gap-2 editBtn"
                                                                    data-id="{{ $appointment->id }}"
                                                                    data-client_id="{{ $appointment->client_id }}"
                                                                    data-pet_id="{{ $appointment->pet_id }}"
                                                                    data-clinic_id="{{ $appointment->clinic_id }}"
                                                                    data-appointment_datetime="{{ $appointment->appointment_datetime->format('Y-m-d\TH:i') }}"
                                                                    data-duration_minutes="{{ $appointment->duration_minutes }}"
                                                                    data-status="{{ $appointment->status }}"
                                                                    data-notes="{{ $appointment->notes }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editAppointmentModal">
                                                                <i class="fas fa-edit text-primary"></i>
                                                                <span>Edit</span>
                                                            </button>
                                                        </li>

                                                        <!-- Delete Option -->
                                                        <li>
                                                            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger" onclick="return confirm('Are you sure you want to delete this appointment?')">
                                                                    <i class="fas fa-trash-alt"></i>
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
</section>

<!-- Create Appointment Modal -->
<div class="modal fade" id="createAppointmentModal" tabindex="-1" aria-labelledby="createAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAppointmentModalLabel">Add New Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label>Client</label>
                            <select name="client_id" class="form-control" required>
                                <option value="">Select Client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Pet</label>
                            <select name="pet_id" class="form-control" required>
                                <option value="">Select Pet</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Clinic</label>
                            <select name="clinic_id" class="form-control" required>
                                <option value="">Select Clinic</option>
                                @foreach($clinics as $clinic)
                                    <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Date & Time</label>
                            <input type="datetime-local" name="appointment_datetime" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Duration (minutes)</label>
                            <input type="number" name="duration_minutes" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label>Notes</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Appointment</button>
                </div>
            </form>
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
            <form method="POST" id="editAppointmentForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label>Client</label>
                            <select name="client_id" id="edit-client_id" class="form-control" required>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Pet</label>
                            <select name="pet_id" id="edit-pet_id" class="form-control" required>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Clinic</label>
                            <select name="clinic_id" id="edit-clinic_id" class="form-control" required>
                                @foreach($clinics as $clinic)
                                    <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Date & Time</label>
                            <input type="datetime-local" name="appointment_datetime" id="edit-appointment_datetime" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Duration (minutes)</label>
                            <input type="number" name="duration_minutes" id="edit-duration_minutes" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" id="edit-status" class="form-control" required>
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label>Notes</label>
                            <textarea name="notes" id="edit-notes" class="form-control" rows="3"></textarea>
                        </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', () => {
            const appointmentId = button.getAttribute('data-id');
            const form = document.getElementById('editAppointmentForm');
            
            // Set the form action with the appointment ID
            form.action = `/appointments/${appointmentId}`;
            
            // Populate form fields
            document.getElementById('edit-client_id').value = button.getAttribute('data-client_id');
            document.getElementById('edit-pet_id').value = button.getAttribute('data-pet_id');
            document.getElementById('edit-clinic_id').value = button.getAttribute('data-clinic_id');
            document.getElementById('edit-appointment_datetime').value = button.getAttribute('data-appointment_datetime');
            document.getElementById('edit-duration_minutes').value = button.getAttribute('data-duration_minutes');
            document.getElementById('edit-status').value = button.getAttribute('data-status');
            document.getElementById('edit-notes').value = button.getAttribute('data-notes');
        });
    });
</script>
@endsection