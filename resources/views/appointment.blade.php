<x-header/>

<body class="all-bg">
    <main class="float-start w-100">
        <x-sidebar />
        <section class="left-sections-right float-end">
            <div class="row p-0 m-0">
                <div class="col-lg-12">
                    <div class="row p-0 m-0">
                        <div class="col-lg-12 ">

                            <div class="d-flex align-items-center justify-content-between w-100">
                                <h2 class="headingh1 mb-0">Appointments</h2>
                                <div class="dates-t d-flex align-items-center">
                                     <p class="dat me-2">{{ \Carbon\Carbon::now()->isoFormat('ddd, MMM D') }}</p>
                                        <div class="dropdown">
                                            <button class="btn btn-amodasl" type="button" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-arrow-down-s-line"></i>
                                            </button>
                                            <ul class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton1">
                                                <li>
                                                    <div class="calendar">
                                                        <div id="calendar1"></div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>


                                <button type="button" data-bs-toggle="modal" data-bs-target="#appoinment"
                                    class="btn btn-alls new-btn01"> <i class="ri-add-line"></i> New Appointment
                                </button>
                            </div>

                        </div>
                    </div>
                   <div class="row p-0 m-0">
                        <div class="col-lg-12">
                            <div class="custome-calsder d-block w-100 table-shadow over-x">
                                <div class="whites015">
                                    <!-- Time headers & appointment columns dynamically injected -->
                                    <div class="grais-sections w-100 d-block" id="appointment-container" style="overflow-x: auto;">
                                        <div class="d-flex flex-nowrap align-items-start" id="appointment-row">
                                            <!-- JavaScript will inject time headers + appointment cards here -->
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


    <!-- appoinment modal -->

    <div class="modal fade crm-modalsd01-forms" id="appoinment" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="crm-form-modal">
                            <div class="row gy-3">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label"> Pet's ID </label>
                                        <input type="text" class="form-control" placeholder="Pet's ID"
                                            id="pet_id_input" />
                                    </div>
                                    <p> Enter the Pet's ID to autofil Pet's name and Owner name </p>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <label class="form-label"> Pet's Name </label>
                                            <a data-bs-toggle="modal" class="regster-bn" data-bs-target="#lostpsModal"
                                                data-bs-dismiss="modal"> + NewPet </a>
                                        </div>

                                        <select name="pet_id" id="pet_id" class="form-select" required disabled>
                                            <option value="">Select Client First</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label"> Owner Name </label>
                                        <select name="client_id" id="client_id" class="form-select" required>
                                            <option value="">Select Client</option>
                                            @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label"> Date / Time </label>
                                        <input type="datetime-local" name="appointment_datetime" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label"> Room Assigned </label>
                                        <select name="room" class="form-select" required>
                                            <option value="">Select room</option>
                                            <option value="One">One</option>
                                            <option value="Two">Two</option>
                                            <option value="Three">Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label"> Veterinarian Assigned </label>
                                        <select name="vet_id" class="form-select" required>
                                            <option value="">Select Vet</option>
                                            @foreach($vets as $vet)
                                            <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label"> Reason for Visit </label>
                                        <select name="reason" class="form-select" required>
                                            <option value="">Select reason</option>
                                            <option value="One">One</option>
                                            <option value="Two">Two</option>
                                            <option value="Three">Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Duration (minutes)</label>
                                        <input type="number" name="duration_minutes" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label"> Appointment Notes </label>
                                        <textarea name="notes" class="form-control textr"
                                            placeholder="Enter appointment notes here"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pe-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Appointment</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>

@if(session('appointment_created'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('successModal'));
        modal.show();
    });
</script>
@endif

<!-- Modal HTML -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Appointment Created</h5>
      </div>
      <div class="modal-body">
        The appointment was successfully added.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const calendarEl = document.getElementById('calendar1');
    const dateDisplay = document.querySelector('.dat');
    const appointmentRow = document.getElementById('appointment-row');

    function formatTime(dateStr) {
        const date = new Date(dateStr);
        const h = date.getUTCHours();
        const m = date.getUTCMinutes();
        const ampm = h >= 12 ? 'PM' : 'AM';
        const hour12 = h % 12 || 12;
        return `${hour12}:${m.toString().padStart(2, '0')} ${ampm}`;
    }

    function formatHourLabel(hour) {
        const h = hour % 12 || 12;
        const ampm = hour >= 12 ? 'PM' : 'AM';
        return `${h}:00 ${ampm}`;
    }

    function loadAppointments(dateStr) {
        fetch(`/projects/pawmetric/appointments/json?date=${dateStr}`)
            .then(response => response.json())
            .then(data => {
                appointmentRow.innerHTML = '';

                if (data.length === 0) {
                    const noDataMsg = document.createElement('div');
                    noDataMsg.className = 'text-center w-100 py-5';
                    noDataMsg.innerHTML = `
                        <h5>No appointments found</h5>
                        <p>There are no scheduled appointments on this date.</p>
                    `;
                    appointmentRow.appendChild(noDataMsg);
                    return;
                }

                let allHours = new Set();
                const hourMap = {};

                data.forEach(appt => {
                    const start = new Date(appt.start);
                    const end = new Date(appt.end);
                    const startHour = start.getUTCHours();
                    const endHour = end.getUTCHours();
                    const span = (end - start) / (1000 * 60 * 60);

                    allHours.add(startHour);
                    allHours.add(endHour);

                    if (!hourMap[startHour]) hourMap[startHour] = [];
                    hourMap[startHour].push({ ...appt, start, end, span });
                });

                const sortedHours = Array.from(allHours).sort((a, b) => a - b);

                sortedHours.forEach(hour => {
                    const appointments = hourMap[hour] || [];

                    const col = document.createElement('div');
                    col.classList.add('col', 'me-0');
                    col.style.minWidth = '260px';
                    col.style.display = 'flex';
                    col.style.flexDirection = 'column';
                    col.style.gap = '10px';

                    const header = document.createElement('div');
                    header.className = 'comon-th mb-2';
                    header.innerHTML = `<h5>${formatHourLabel(hour)}</h5>`;
                    col.appendChild(header);

                    appointments.forEach(appt => {
                        const block = document.createElement('div');
                        block.className = 'w-th-md crm-div w01-big mb-2';
                        const spanHours = (appt.end - appt.start) / (1000 * 60 * 60);
                        const width = spanHours * 460;
                        block.style.width = `${width}px`;

                        const [petInfo, vetInfo] = appt.title.split('|');
                        const statusText = appt.status?.trim() ?? 'Unknown';
                        let statusColor = 'text-secondary';

                        switch (statusText.toLowerCase()) {
                            case 'scheduled':
                                statusColor = 'text-warning';
                                break;
                            case 'completed':
                                statusColor = 'text-success';
                                break;
                            case 'cancelled':
                                statusColor = 'text-danger';
                                break;
                        }

                        block.innerHTML = `
                            <h5>${petInfo?.trim() ?? ''}</h5>
                            <p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">
                                        <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9z"/>
                                        <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1z"/>
                                    </svg>
                                </span> 
                                ${formatTime(appt.start)} - ${formatTime(appt.end)} | ${vetInfo?.trim() ?? ''}
                            </p>
                            <h6 class="stas ${statusColor}">${statusText}</h6>
                        `;

                        col.appendChild(block);
                    });

                    appointmentRow.appendChild(col);
                });
            });
    }

    if (calendarEl) {
        $('#calendar1').datepicker({
            todayHighlight: true,
            autoclose: true,
            format: 'yyyy-mm-dd'
        }).on("changeDate", function (e) {
            if (!e.date) return;
            const selected = e.date;
            const yyyy = selected.getFullYear();
            const mm = String(selected.getMonth() + 1).padStart(2, '0');
            const dd = String(selected.getDate()).padStart(2, '0');
            const formattedDate = `${yyyy}-${mm}-${dd}`;
            const options = { weekday: 'short', month: 'short', day: 'numeric' };
            dateDisplay.textContent = selected.toLocaleDateString('en-US', options);
            dateDisplay.dataset.date = formattedDate;
            loadAppointments(formattedDate);
        });

        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const todayFormatted = `${yyyy}-${mm}-${dd}`;
        const options = { weekday: 'short', month: 'short', day: 'numeric' };
        dateDisplay.textContent = today.toLocaleDateString('en-US', options);
        dateDisplay.dataset.date = todayFormatted;
        loadAppointments(todayFormatted);
    }
});
</script>









 

    <x-footer />
    <!-- <script src="{{ asset('js/datepick.js')}}" ></script> -->


    <!--For this appointment page calender-->