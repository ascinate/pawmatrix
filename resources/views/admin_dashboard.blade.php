<x-header />

<body class="home-page all-bg">
    <main class="float-start w-100">

        <x-sidebar />
        <section class="left-sections-right float-end">
            <div class="row p-0 m-0">
                <div class="col-lg-8">
                    <div class="row p-0 m-0">
                        <div class="col-lg-12">
                            <h2 class="headingh1"> Homepage </h2>
                        </div>

                        <div class="col-lg-4">
                            <div class="comon-fedds d-inline-block w-100">
                                <p> Today' Appointments </p>
                                <div class="d-flex align-items-center">
                                    <figure class="m-0">
                                        <img src="{{ asset('assets/images/todays.jpg')}}" alt="sm" />
                                    </figure>
                                    <h2> {{ $stats['todaysAppointments'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="comon-fedds d-inline-block w-100">
                                <p> Scheduled Appointments </p>
                                <div class="d-flex align-items-center">
                                    <figure class="m-0">
                                        <img src="{{ asset('assets/images/caler.jpg')}}" alt="sm" />
                                    </figure>
                                    <h2> {{ $stats['upcomingAppointmentsCount'] }} </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="comon-fedds d-inline-block w-100">
                                <p> Overdue Appointments </p>
                                <div class="d-flex align-items-center">
                                    <figure class="m-0">
                                        <img src="{{ asset('assets/images/notic.jpg')}}" alt="sm" />
                                    </figure>
                                    <h2> {{ $stats['overdueAppointments'] }} </h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mt-4">
                            <div class="comon-li d-inline-block w-100">
                                <h5>Today's Appointments</h5>
                                <div class="taosy01 w-100">
                                    <table id="todayTable" class="table table-striped nowrap">
                                        <thead>
                                            <tr>
                                                <th>Pet's Name</th>
                                                <th>Owner</th>
                                                <th>Time of Appointment</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($todaysAppointments as $appointment)
                                            <tr>
                                                <td>
                                                    <div class="user-div01 d-flex align-items-center">
                                                        <figure class="m-0">
                                                            @if($appointment->pet && $appointment->pet->image)
                                                            <img src="{{ asset($appointment->pet->image) }}"
                                                                alt="{{ $appointment->pet->name }}" />
                                                            @else
                                                            <img src="{{ asset('assets/images/default-pet.png') }}"
                                                                alt="No image" />
                                                            @endif
                                                        </figure>
                                                        <span
                                                            class="td-text">{{ $appointment->pet->name ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td><span
                                                        class="td-text">{{ $appointment->client->name ?? 'N/A' }}</span>
                                                </td>
                                                <td> <span
                                                        class="td-text">{{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('h:i A') }}</span>
                                                </td>

                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge td-text"
                                                            style="background-color: {{ $statusColors[$appointment->status] ?? '#ccc' }}">
                                                            {{ ucfirst($appointment->status) }}
                                                        </span>
                                                    </div>

                                                </td>

                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted">
                                                    <i class="fas fa-calendar-day fa-2x mb-2 text-secondary"></i>
                                                    <p>No appointments scheduled today</p>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="d-flex sp-padding-btn align-items-center justify-content-between w-100">
                                        <button type="button" class="btn btn-previes"> Previous </button>
                                        <p class="pater-today"> Page 1 of 1 </p>
                                        <button type="button" class="btn btn-next"> Next </button>
                                    </div>

                                </div>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="comon-box quick-calder d-block w-100">
                        <h5> Quick Scheduler </h5>
                        <div class="clader-div01 w-100 d-block">
                            <div class="calendar">
                                <div id="calendar"></div>
                            </div>

                            <div class="col-lg-11 mx-auto">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#appoinment"
                                    class="btn btn-alls w-100"> <i class="ri-add-line"></i> New Appointment </button>
                            </div>


                        </div>
                    </div>

                    <div class="recenttyle-activety comon-box w-100 mt-4">
                        <h5> Recent Activity </h5>
                        <div class="activety-div d-block w-100">
                            <ul class="position-relative">
                                @forelse($activities as $activity)
                                <li class="position-relative">
                                    <h6>{{ $activity['message'] }}</h6>
                                    <span class="d-block w-100">{{ $activity['time'] }}</span>
                                </li>
                                @empty
                                <li class="position-relative">
                                    <h6>No recent activity found</h6>
                                    <span class="d-block w-100">{{ now()->diffForHumans() }}</span>
                                </li>
                                @endforelse
                            </ul>
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


    <!-- Pet add modal -->
    <div class="modal fade login-div-modal crm-modalsd01-forms" id="lostpsModal">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Pet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @csrf

                    <div class="modal-body">
                        <div class="crm-form-modal">
                            <div class="row gy-3 gx-lg-5">
                                <div class="col-lg-6 right-border-trs">
                                    <div class="row gy-3">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="d-flex align-items-center justify-content-between w-100">
                                                    <label class="form-label">Pet&#39;s Name</label>
                                                </div>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">Breed</label>
                                                <input type="text" name="breed" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">Date of Birth</label>
                                                <input type="date" name="birthdate" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="image" class="form-label">Pet Image</label>
                                                <input type="file" name="image" class="form-control" accept="image/*">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="d-flex align-items-center justify-content-between w-100">
                                                    <label class="form-label">Important Notes</label>
                                                </div>
                                                <textarea name="notes" id="" class="form-control textr-adds"
                                                    placeholder="Please note any behavior or medical warnings the vet should be aware of"
                                                    rows="4" cols="50"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Owner Name</label>
                                        <input type="text" name="owners_name" class="form-control"
                                            placeholder="Owner's name" />
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" name="dateofbirth" class="form-control" />
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label">Gender</label>
                                            <select name="gender" class="form-select" aria-label="Gender select">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="email@example.com" />
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Phone Number</label>
                                            <input type="text" name="phone" class="form-control"
                                                placeholder="Phone number" />
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label class="form-label">Address</label>
                                            <textarea name="address" class="form-control"
                                                placeholder="Address"></textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">City</label>
                                            <input type="text" name="city" class="form-control" placeholder="City" />
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-6">
                                            <label class="form-label">State</label>
                                            <input type="text" name="state" class="form-control" placeholder="State" />
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Zip Code</label>
                                            <input type="text" name="zipcode" class="form-control"
                                                placeholder="Zip code" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pe-0 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="previewPetBtn">Create Pet</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--appointment form submission confirmation modal-->
    <div class="modal fade" id="confirmAppointmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmationText">
                        Confirm new appointment for {pet’s name} on {Date} at {Time}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmSubmitBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm New Pet Modal -->
    <div class="modal fade" id="confirmPetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Pet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="petConfirmationText">
                        You're about to add {Pet’s Name} under {Owner Name} as the pet owner
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmPetSubmitBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/js/datepick.js')}}"></script>
    <script>
    $(document).ready(function() {
        @if(session('openAppointmentModal'))
        $('#lostpsModal').modal('hide');
        setTimeout(function() {
            $('#appoinment').modal('show');

            // Auto-select newly added pet and client
            $('#pet_id').val('{{ session('
                newPetId ') }}').prop('disabled', false);
            $('#client_id').val('{{ session('
                newClientId ') }}');
        }, 500);
        @endif
    });
    </script>

    <!--appointment for confirmation popup-->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const previewBtn = document.getElementById('previewAppointmentBtn');
        const confirmBtn = document.getElementById('confirmSubmitBtn');
        const confirmationText = document.getElementById('confirmationText');
        const appointmentForm = document.querySelector('#appoinment form');

        previewBtn.addEventListener('click', function() {
            // Grab values from form
            const petSelect = document.getElementById('pet_id');
            const dateTime = appointmentForm.querySelector('input[name="appointment_datetime"]').value;

            const petName = petSelect.options[petSelect.selectedIndex]?.text || 'Unknown';
            const dateObj = new Date(dateTime);
            const formattedDate = dateObj.toLocaleDateString();
            const formattedTime = dateObj.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });

            confirmationText.innerHTML =
                `Confirm new appointment for <strong>${petName}</strong> on <strong>${formattedDate}</strong> at <strong>${formattedTime}</strong>.`;

            // Show confirmation modal
            const confirmModal = new bootstrap.Modal(document.getElementById(
                'confirmAppointmentModal'));
            confirmModal.show();
        });

        confirmBtn.addEventListener('click', function() {
            // Submit the form finally
            appointmentForm.submit();
        });
    });
    </script>

    <!--pet for confirmation popup-->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const petForm = document.querySelector('#lostpsModal form');
        const previewPetBtn = document.getElementById('previewPetBtn');
        const confirmPetBtn = document.getElementById('confirmPetSubmitBtn');
        const confirmationText = document.getElementById('petConfirmationText');

        previewPetBtn.addEventListener('click', function() {
            const petName = petForm.querySelector('input[name="name"]').value.trim();
            const ownerName = petForm.querySelector('input[name="owners_name"]').value.trim();

            if (!petName || !ownerName) {
                alert('Please fill Pet’s Name and Owner Name before continuing.');
                return;
            }

            // Set confirmation message
            confirmationText.textContent =
                `You're about to add ${petName} under ${ownerName} as the pet owner`;

            // Show the confirmation modal
            const modal = new bootstrap.Modal(document.getElementById('confirmPetModal'));
            modal.show();
        });

        confirmPetBtn.addEventListener('click', function() {
            petForm.submit(); // Submit actual form on confirm
        });
    });
    </script>


    <x-footer />