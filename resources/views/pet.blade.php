<x-header />

<body class="all-bg">
    <main class="float-start pets-patine-page  w-100 cm-all-page">
        <x-sidebar />
        <section class="left-sections-right float-end pading-botton">
            <div class="row p-0 m-0">
                <div class="col-lg-8">
                    <h2 class="headingh1 mg-bt-01"> Patient Flow </h2>
                </div>
                <div class="col-lg-12">
                    <ul class="nav new-actiove crm-tabs015 nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">Active Patients <span class="no-lines"> {{ $activeCount }}
                                </span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false"> Completed <span class="no-lines"> {{ $completedCount }} </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                                aria-selected="false"> Cancelled <span class="no-lines"> {{ $cancelledCount }} </span>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content stop-pagings crm-data-height" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="col-lg-12 mt-4">
                                <div class="comon-li pt-0 d-inline-block w-100">
                                    <div class="taosy01 cmtop-b w-100 cmpt-1250">
                                        <table id="activeTable" class="table table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Pet's Name</th>
                                                    <th>Owner</th>
                                                    <th>Reason for visit</th>
                                                    <th>Date/Time</th>
                                                    <th>Room assigned</th>
                                                    <th>Important notes</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody-pad">
                                                @foreach($activeAppointments as $appointment)
                                                <tr>
                                                    <td>
                                                        <div class="user-div01 d-flex align-items-center">
                                                            <figure class="m-0">
                                                                <img src="{{ $appointment->pet && $appointment->pet->image ? asset($appointment->pet->image) : asset('images/default-pet.jpg') }}"
                                                                    alt="sm" />
                                                            </figure>
                                                            <span class="tc-1">
                                                                {{ $appointment->pet->name ?? 'Unknown' }} </span>
                                                        </div>
                                                    </td>
                                                    <td> <span class="cm-wit"> {{ $appointment->client->name ?? 'N/A' }}
                                                        </span> </td>
                                                    <td> <span class="cm-wit"> {{ $appointment->reason ?? 'N/A' }}
                                                        </span> </td>
                                                    <td> <span class="cm-wit">
                                                            {{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('M jS \a\t h:i A') }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $appointment->room ?? 'Unassigned' }}</td>
                                                    <td>
                                                        <span class="warning-icon"><img
                                                                src="{{asset('images/warningIcon.svg')}}" alt=""
                                                                class="warningsvg"></span> <span class="tc-info">
                                                            {{ $appointment->notes ?? 'no notes' }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="last-btn-group">
                                                            @if($appointment->status === 'checked-in')
                                                            <button type="button" class="patient-btn start-appointment"
                                                                data-id="{{ $appointment->id }}"
                                                                data-name="{{ $appointment->pet->name ?? 'this patient' }}"
                                                                data-route="{{ url('appointment/billing') }}"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#startappointmentmodal">
                                                                Start Appointment
                                                            </button>
                                                            @elseif($appointment->status === 'in-progress')
                                                            <button type="button" class="patient-btn in-progress">In
                                                                Progress</button>
                                                            @else
                                                            <button type="button" class="patient-btn checkin"
                                                                data-id="{{ $appointment->id }}"
                                                                data-name="{{ $appointment->pet->name ?? 'this patient' }}"
                                                                data-bs-toggle="modal" data-bs-target="#checkinmodal">
                                                                Check in
                                                            </button>
                                                            <button type="button" class="patient-btn cancel"
                                                                data-id="{{ $appointment->id }}"
                                                                data-name="{{ $appointment->pet->name ?? 'this patient' }}"
                                                                data-route="{{ url('appointments/update-status/') }}/"
                                                                data-bs-toggle="modal" data-bs-target="#cancelinmodal">
                                                                Cancel
                                                            </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div
                                            class="d-flex sp-padding-btn align-items-center justify-content-between w-100">
                                            <button type="button" class="btn btn-previes"> Previous </button>
                                            <p class="pater"> Page 1 of 2 </p>
                                            <button type="button" class="btn btn-next"> Next </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            <div class="col-lg-12 mt-4">
                                <div class="comon-li  pt-0 d-inline-block w-100">
                                    <div class="taosy01 cmtop-b w-100 cmpt-1250">
                                        <table id="completedTable" class="table table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Pet's Name</th>
                                                    <th>Owner</th>
                                                    <th>Reason for visit</th>
                                                    <th>Date/Time</th>
                                                    <th>Room assigned</th>
                                                    <th>Important notes</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody-pad">
                                                @foreach($completedAppointments as $appointment)
                                                <tr>
                                                    <td>
                                                        <div class="user-div01 d-flex align-items-center">
                                                            <figure class="m-0">
                                                                <img src="{{ $appointment->pet && $appointment->pet->image ? asset($appointment->pet->image) : asset('images/default-pet.jpg') }}"
                                                                    alt="sm" />
                                                            </figure>
                                                            <span class="tc-1">
                                                                {{ $appointment->pet->name ?? 'Unknown' }} </span>
                                                        </div>
                                                    </td>
                                                    <td> <span class="cm-wit"> {{ $appointment->client->name ?? 'N/A' }}
                                                        </span> </td>
                                                    <td> <span class="cm-wit"> {{ $appointment->reason ?? 'N/A' }}
                                                        </span> </td>
                                                    <td> <span class="cm-wit">
                                                            {{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('M jS \a\t h:i A') }}
                                                        </span>
                                                    </td>
                                                    <td> <span class="cm-wit"> {{ $appointment->room ?? 'Unassigned' }}
                                                        </span> </td>
                                                    <td>
                                                        <span class="warning-icon"><img
                                                                src="{{asset('images/warningIcon.svg')}}" alt=""
                                                                class="warningsvg"></span> <span class="tc-info">
                                                            {{ $appointment->notes ?? 'no notes' }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="last-btn-group">
                                                            <button type="button"
                                                                class="patient-btn completed">Completed</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div
                                            class="d-flex sp-padding-btn align-items-center justify-content-between w-100">
                                            <button type="button" class="btn btn-previes"> Previous </button>
                                            <p class="pater-complete"> Page 1 of 2 </p>
                                            <button type="button" class="btn btn-next"> Next </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab">
                            <div class="col-lg-12 mt-4">
                                <div class="comon-li pt-0 d-inline-block w-100">
                                    <div class="taosy01 cmtop-b w-100 cmpt-1250">
                                        <table id="cancelledTable" class="table table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Pet's Name</th>
                                                    <th>Owner</th>
                                                    <th>Reason for visit</th>
                                                    <th>Date/Time</th>
                                                    <th>Room assigned</th>
                                                    <th>Important notes</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody-pad">
                                                @foreach($cancelledAppointments as $appointment)
                                                <tr>
                                                    <td>
                                                        <div class="user-div01 d-flex align-items-center">
                                                            <figure class="m-0">
                                                                <img src="{{ $appointment->pet && $appointment->pet->image ? asset($appointment->pet->image) : asset('images/default-pet.jpg') }}"
                                                                    alt="sm" />
                                                            </figure>
                                                            <span class="tc-1">
                                                                {{ $appointment->pet->name ?? 'Unknown' }} </span>
                                                        </div>
                                                    </td>
                                                    <td> <span class="cm-wit"> {{ $appointment->client->name ?? 'N/A' }}
                                                        </span> </td>
                                                    <td> <span class="cm-wit">{{ $appointment->reason ?? 'N/A' }}
                                                        </span> </td>
                                                    <td> <span class="cm-wit">
                                                            {{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('M jS \a\t h:i A') }}
                                                        </span>
                                                    </td>
                                                    <td> <span class="cm-wit"> {{ $appointment->room ?? 'Unassigned' }}
                                                        </span></td>
                                                    <td>
                                                        <span class="warning-icon"><img
                                                                src="{{asset('images/warningIcon.svg')}}" alt=""
                                                                class="warningsvg"></span> <span class="tc-info">
                                                            {{ $appointment->notes ?? 'no notes' }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="last-btn-group">
                                                            <button type="button"
                                                                class="patient-btn cancels015">Cancelled</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div
                                            class="d-flex sp-padding-btn align-items-center justify-content-between w-100">
                                            <button type="button" class="btn btn-previes"> Previous </button>
                                            <p class="pater-cancel"> Page 1 of 2 </p>
                                            <button type="button" class="btn btn-next"> Next </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Check-in Modal -->
    <div class="modal fade sm-modals md-mdoals" id="checkinmodal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog ">
            <form method="POST" id="checkinForm" action="{{ route('appointments.checkin') }}">
                @csrf
                <input type="hidden" name="appointment_id" id="checkinAppointmentId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Check In</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to check in <strong id="checkinPatientName">this patient</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Start Appointment Modal -->
    <div class="modal fade sm-modals md-mdoals" id="startappointmentmodal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog ">
            <form method="GET" id="startAppointmentForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Start Appointment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you ready to start the appointment for <strong id="startAppointmentPatientName">this
                                patient</strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Cancel Modal (remains the same) -->
    <div class="modal fade sm-modals md-mdoals" id="cancelinmodal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="cancelForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cancel Appointment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to cancel appointment for <span id="cancelPatientName">this
                                patient</span>?</p>
                        <input type="hidden" name="status" value="cancelled">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes, Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check-in Modal
        const checkinModal = document.getElementById('checkinmodal');
        checkinModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const appointmentId = button.getAttribute('data-id');
            const petName = button.getAttribute('data-name');

            document.getElementById('checkinAppointmentId').value = appointmentId;
            document.getElementById('checkinPatientName').textContent = petName;
        });

        // Start Appointment Modal
        const startAppointmentModal = document.getElementById('startappointmentmodal');
        startAppointmentModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const appointmentId = button.getAttribute('data-id');
            const petName = button.getAttribute('data-name');
            const routeBase = button.getAttribute('data-route');

            const form = document.getElementById('startAppointmentForm');
            form.action = `${routeBase}/${appointmentId}`;
            document.getElementById('startAppointmentPatientName').textContent = petName;
        });

        // Cancel Modal (remains the same)
        const cancelModal = document.getElementById('cancelinmodal');
        cancelModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const appointmentId = button.getAttribute('data-id');
            const petName = button.getAttribute('data-name');
            const routeBase = button.getAttribute('data-route');

            const cancelForm = document.getElementById('cancelForm');
            cancelForm.action = `${routeBase}${appointmentId}`;
            document.getElementById('cancelPatientName').textContent = petName;
        });
    });
    </script>

    <x-footer />