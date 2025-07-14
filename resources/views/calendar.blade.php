<x-header/>
<style>
    .calendar-container {
        margin-top: 30px;
    }
    
    .fc-event {
        cursor: pointer;
    }
    
    .fc-daygrid-event {
        border-radius: 4px;
        padding: 2px 4px;
    }
    
    .fc-toolbar-title {
        font-size: 1.5rem;
        font-weight: 600;
    }
    
    .fc-button {
        background-color: #4d8cff;
        border: none;
        color: white;
    }
    
    .fc-button:hover {
        background-color: #3a76e0;
    }
    
    .fc-button-active {
        background-color: #2a5cb8;
    }
    
    .fc-daygrid-day-number {
        color: #495057;
    }
    
    .fc-day-today {
        background-color: rgba(77, 140, 255, 0.1) !important;
    }
    
    .action-buttons {
        margin-bottom: 20px;
    }

    .fc-event-dragging {
    opacity: 0.7;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.fc-highlight {
    background: rgba(77, 140, 255, 0.2);
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

 <div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Appointment Calendar</h2> <!--This is left -->
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-list me-1"></i> List View
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAppointmentModal">
                <i class="fas fa-plus me-1"></i> Add Appointment
            </button>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body calendar-container">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- Create Appointment Modal start--><!--Required for creating new appointment-->
<div class="modal fade" id="createAppointmentModal" tabindex="-1" aria-labelledby="createAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAppointmentModalLabel">Create New Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client</label>
                            <select name="client_id" id="client_id" class="form-select" required>
                                <option value="">Select Client</option><!--select the client-->
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pet</label>
                            <select name="pet_id" id="pet_id" class="form-select" required>
                                <option value="">Select Pet</option>
                                @foreach($pets as $pet)<!--Select the pet-->
                                    <option value="{{ $pet->id }}" data-client-id="{{ $pet->client_id }}">{{ $pet->name }} ({{ $pet->species }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Clinic</label>
                            <select name="clinic_id" class="form-select" required>
                                <option value="">Select Clinic</option><!--Select the clinic-->
                                @foreach($clinics as $clinic)
                                    <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vet</label><!--select the vet-->
                            <select name="vet_id" class="form-select" required>
                                <option value="">Select Vet</option>
                                @foreach($vets as $vet)
                                    <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date & Time</label><!--select date and time-->
                            <input type="datetime-local" name="appointment_datetime" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Duration (minutes)</label>
                            <input type="number" name="duration_minutes" class="form-control" value="30" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label><!--select appoinment status-->
                            <select name="status" class="form-select" required>
                                <option value="scheduled" selected>Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Create Appointment Modal End-->
<!-- View Appointment Modal -->
<div class="modal fade" id="viewAppointmentModal" tabindex="-1" aria-labelledby="viewAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAppointmentModalLabel">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="appointmentDetails">
                <!-- Content will be loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" id="editAppointmentBtn" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<!-- FullCalendar and jQuery/Bootstrap dependencies -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the calendar container
        var calendarEl = document.getElementById('calendar');

        // Initialize FullCalendar
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // Start with month view

            // Header buttons for navigation
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },

            editable: true, // Allow drag-and-drop to move events
            eventDurationEditable: true, // Allow resizing events (change duration)

            // Load appointments into the calendar
            events: [
                @foreach($events as $event)
                {
                    id: '{{ $event['id'] }}', // Unique ID
                    title: '{{ $event['title'] }}', // Title shown on calendar
                    start: '{{ $event['start'] }}', // Start time
                    end: '{{ $event['end'] }}', // End time
                    color: '{{ $event['color'] }}', // Event background color
                    url: '{{ route('appointments.show', $event['id']) }}' // For AJAX view
                },
                @endforeach
            ],

            // When an event is clicked
            eventClick: function(info) {
                info.jsEvent.preventDefault(); // Prevent default redirect

                if (info.event.url) {
                    // Load appointment details into modal using AJAX
                    $.get(info.event.url, function(data) {
                        $('#appointmentDetails').html(data); // Fill modal body
                        $('#editAppointmentBtn').attr('href', info.event.url.replace('show', 'edit')); // Set edit link
                        $('#viewAppointmentModal').modal('show'); // Show view modal
                    });
                }
            },

            // When an event is dragged to a new date/time
            eventDrop: function(info) {
                updateAppointmentTime(info.event); // Call update handler
            },

            // When an event is resized to change its duration
            eventResize: function(info) {
                updateAppointmentTime(info.event); // Call update handler
            },

            // When a date is clicked (empty slot)
            dateClick: function(info) {
                $('input[name="appointment_datetime"]').val(info.dateStr + 'T12:00'); // Pre-fill datetime
                $('#createAppointmentModal').modal('show'); // Open create modal
            },

            // Format time shown in event (12-hour format)
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            }
        });

        // Render the calendar
        calendar.render();

        // AJAX function to update appointment time and duration
       function updateAppointmentTime(event) {
    $.ajax({
        url: 'https://ascinate.in/projects/pawmetric/appointments/' + event.id + '/update-time',
        method: 'PATCH',
        data: {
            _token: '{{ csrf_token() }}',
            appointment_datetime: event.start.toISOString(),
            duration_minutes: (event.end - event.start) / (1000 * 60)
        },
        success: function(response) {
            toastr.success('Appointment updated successfully');
            // If on list view, refresh the table
            if (window.location.pathname.includes('/appointments') && 
                !window.location.pathname.includes('/calendar')) {
                refreshAppointmentsTable();
            }
        },
        error: function(xhr) {
            toastr.error('Error updating appointment');
            event.revert();
        }
    });
}

function refreshAppointmentsTable() {
    $.get('https://ascinate.in/projects/pawmetric/appointments?json=1', function(data) {
        let html = '';
        data.forEach(appointment => {
            html += `<tr>
                <td>${appointment.client_name}</td>
                <td>${appointment.pet_name}</td>
                <td>${appointment.clinic_name}</td>
                <td>${appointment.vet_name || 'Unassigned'}</td>
                <td>${new Date(appointment.appointment_datetime).toLocaleString()}</td>
                <td>${appointment.duration_minutes} mins</td>
                <td><span class="status-badge status-${appointment.status}">
                    ${appointment.status.charAt(0).toUpperCase() + appointment.status.slice(1)}
                </span></td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="/appointments/${appointment.id}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <button class="btn btn-sm btn-warning edit-btn"
                            data-id="${appointment.id}" 
                            data-client_id="${appointment.client_id}"
                            data-pet_id="${appointment.pet_id}"
                            data-clinic_id="${appointment.clinic_id}"
                            data-vet_id="${appointment.vet_id}"
                            data-appointment_datetime="${appointment.appointment_datetime.replace(' ', 'T')}"
                            data-duration_minutes="${appointment.duration_minutes}"
                            data-status="${appointment.status}"
                            data-notes="${appointment.notes || ''}"
                            data-bs-toggle="modal"
                            data-bs-target="#editAppointmentModal">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="/appointments/${appointment.id}" method="POST" class="d-inline">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>`;
        });
        $('.table tbody').html(html);
    });
}

        // When client is changed, filter pet list based on client_id
        $('#client_id').change(function() {
            var clientId = $(this).val(); // Selected client ID
            $('#pet_id option').each(function() {
                var petClientId = $(this).data('client-id'); // Get each pet's client ID
                if (petClientId == clientId || clientId === '') {
                    $(this).show(); // Show matching pets
                } else {
                    $(this).hide(); // Hide others
                }
            });
            $('#pet_id').val(''); // Clear pet selection
        });

        // Show success alert if available in session
        @if(session('success'))
            alert('{{ session('success') }}');
        @endif
    });
</script>

<x-footer/>