<x-header />

<body class="all-bg settings-page">
    <main class="float-start w-100">
        <x-sidebar />
        <section class="left-sections-right float-end">
            <div class="row p-0 m-0">
                <div class="col-lg-12">
                    <div class="row p-0 m-0">
                        <div class="col-lg-12">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h2 class="headingh1 m-0"> Settings </h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 mt-4">
                        <div class="common-shadow settings-card">
                            <h3 class="common-settings-card-heading">Clinic Information</h3>
                            <p class="settings-sub-title my-1">Update your clinic's basic contact and identity details.
                            </p>

                            <div class="settings-card-form d-flex mt-4 align-items-center">
                                <label for="clinicname">Clinic Name</label>
                                <input type="text" class="form-control" value="{{ $user->name ?? '' }}">
                            </div>

                            <div class="settings-card-form d-flex align-items-center">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" value="{{ $user->address ?? '' }}">
                            </div>

                            <div class="settings-card-form d-flex align-items-center">
                                <label for="phone">Phone Number</label>
                                <input type="text" class="form-control" value="{{ $user->phone_no ?? '' }}">
                            </div>

                            <div class="settings-card-form d-flex align-items-center">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" value="{{ $user->email ?? '' }}">
                            </div>
                            <!--added just for now-->
                            @if(is_null($user->address) || is_null($user->phone_no))
                            <form method="POST" action="{{ route('settings.insertContact') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                <div class="settings-card-form d-flex align-items-center mt-3">
                                    <label for="insert_address">Insert Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Enter Address"
                                        required>
                                </div>

                                <div class="settings-card-form d-flex align-items-center">
                                    <label for="insert_phone">Insert Phone</label>
                                    <input type="text" class="form-control" name="phone_no" placeholder="Enter Phone No"
                                        required>
                                </div>

                                <button class="common-outline-btn btn d-table ms-lg-auto mt-2">Insert</button>
                            </form>
                            @endif
                       <!--added just for now-->     
                            <button class="common-outline-btn btn d-table ms-lg-auto">Save Changes</button>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                        <div class="common-shadow settings-card" id="service-container">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h3 class="common-settings-card-heading">Services Type <span
                                            class="color-gray">&#40;5&#41;</span></h3>
                                    <p class="settings-sub-title my-1">Manage your clinics service types. </p>
                                </div>
                                <!-- Button -->
                                <button class="settings-add-outline-btn inline-block mt-0" id="settings-services-add">
                                    Add Service Type
                                </button>



                            </div>
                            <!-- Input div, hidden by default -->
                            <div id="service-input-container" style="display: none;">
                                <input type="text" class="form-control add-services" placeholder="Add Service Type"
                                    id="service-input">
                                <button id="add-service-btn"
                                    class="common-outline-btn btn d-table ms-lg-auto">Add</button>
                            </div>

                            @foreach($categories as $key => $category)
                            <div
                                class="settings-vac d-flex align-items-start justify-content-between {{ $key === 2 ? 'border-red-b' : ($key === 0 ? 'vac-rad' : '') }}">
                                <p>{{ $category }}</p>
                                <div class="my-0 d-flex align-items-center justify-content-between wten">
                                    <button class="btn-delete-edit m-0">
                                        <img src="{{ asset('images/idelete.svg') }}" alt="">
                                    </button>
                                    <button class="btn-delete-edit m-0" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Edit">
                                        <img class="nohovers" src="{{ asset('images/iedit.svg') }}" alt="">
                                        <img class="hovers" src="{{ asset('images/edit-2.svg') }}" alt="">
                                    </button>
                                </div>
                            </div>
                            @endforeach

                            <button class="common-outline-btn btn d-table ms-lg-auto">Save Changes</button>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 mt-4">
                        <div class="common-shadow settings-card">
                            <h3 class="common-settings-card-heading">Change Password</h3>
                            <p class="settings-sub-title my-1">For account security, change your login password
                                here.
                            </p>

                            <div class="settings-card-form d-flex mt-4 align-items-center">
                                <label for="clinicname">Current Password</label>
                                <input type="text" class="form-control" value="{{ $user->password ?? '' }}"
                                    placeholder="Current Password">
                            </div>
                            <div class="settings-card-form d-flex align-items-center">
                                <label for="clinicname">New Password</label>
                                <input type="text" class="form-control" value="" placeholder="New Password">
                            </div>
                            <div class="settings-card-form d-flex align-items-center">
                                <label for="clinicname">Confirm Password</label>
                                <input type="text" class="form-control" value="" placeholder="Confirm Password">
                            </div>

                            <button class="common-outline-btn btn d-table ms-lg-auto">Save Changes</button>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-4">
                        <!--adding medication start-->
                        <div class="common-shadow settings-card mb-5">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h3 class="common-settings-card-heading">
                                        Medications <span
                                            class="color-gray">&#40;{{ $medications->count() }}&#41;</span>
                                    </h3>
                                    <p class="settings-sub-title my-1">Manage your clinics medication types.</p>
                                </div>
                                <!-- Button -->
                                <button class="settings-add-outline-btn inline-block mt-0" id="medication-add-btn">
                                    Add Medication Type
                                </button>
                            </div>

                            <!-- Input -->
                            <div id="medication-input-container" style="display: none;">
                                <input type="text" class="form-control add-medications"
                                    placeholder="Add Medication Type" id="medication-input">
                                <button id="add-medication-btn"
                                    class="settings-add-outline-btn inline-block">Add</button>
                            </div>

                            @foreach($medications as $key => $medication)
                            <div class="settings-vac d-flex align-items-center justify-content-between
            {{ $key === 0 ? 'vac-rad' : '' }} {{ $key === 2 ? 'border-red-b' : '' }}">
                                <p>{{ $medication }}</p>
                                <div class="my-0 d-flex align-items-center justify-content-between wten">
                                    <button class="btn-delete-edit m-0">
                                        <img src="{{ asset('images/idelete.svg') }}" alt="">
                                    </button>
                                    <button class="btn-delete-edit m-0" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Edit">
                                        <img class="nohovers" src="{{ asset('images/iedit.svg') }}" alt="">
                                        <img class="hovers" src="{{ asset('images/edit-2.svg') }}" alt="">
                                    </button>
                                </div>
                            </div>
                            @endforeach
                            <!--Pagination-->
                            <div class="d-flex align-items-center justify-content-between col-lg-3 mt-4 mb-2 mx-auto">
                                <button type="button" class="common-outline-btn23 btn"><i
                                        class="ri-arrow-left-s-line"></i></button>
                                <p class="nol"> 1 / 4 </p>
                                <button type="button" class="common-outline-btn23 btn"><i
                                        class="ri-arrow-right-s-line"></i></button>
                            </div>


                            <!-- <button class="common-outline-btn btn d-table ms-lg-auto">Save Changes</button> -->
                        </div>

                        <!--adding medication end-->
                    </div>
                </div>
            </div>


        </section>
    </main>


    <script>
    $(document).ready(function() {
        new DataTable('#example', {
            responsive: true,
            searching: false,
            lengthChange: false
        });
    });
    </script>

    <x-footer />

</body>

</html>