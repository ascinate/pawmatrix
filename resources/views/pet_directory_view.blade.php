<x-header />

<body class="all-bg">

    <main class="float-start w-100">
        <x-sidebar />
        <section class="left-sections-right float-end">
            <div class="row p-0 m-0">
                <div class="col-lg-12">
                    <div class="row p-0 m-0">
                        <div class="col-lg-12">
                            <div class="d-flex align-items-center justify-content-center petImage">
                                <img src="{{ $pet->image && file_exists($pet->image) ? asset($pet->image) : asset('images/default-pet.jpg') }}"
                                    alt="pet photo" class="rouned-circle">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="pet-dir-view-card">
                        <div class="card-head card-padding ">
                            <h6>Pet Details</h6>
                        </div>
                        <div class="card-content-padding">
                            <ul class="card-list">
                                <li>
                                    <span class="petdir-child-li-w">Pet name:</span>
                                    <span class="petdir-data">{{ $pet->name }}</span>
                                </li>
                                <li>
                                    <span class="petdir-child-li-w">Breed:</span>
                                    <span class="petdir-data">{{ $pet->breed ?? 'N/A' }}</span>
                                </li>
                                <li>
                                    <span class="petdir-child-li-w">Age:</span>
                                    <span class="petdir-data">
                                        {{ $pet->birthdate ? \Carbon\Carbon::parse($pet->birthdate)->age . ' years old' : 'N/A' }}
                                    </span>
                                </li>
                                <li>
                                    <span class="petdir-child-li-w">Important Notes:</span>
                                    <span class="petdir-data">{{ $pet->notes ?? 'No Notes' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="pet-dir-view-card">
                        <div class="card-head card-padding">
                            <h6>Owner Info</h6>
                        </div>
                        <div class="card-content-padding">
                            <ul class="card-list">
                                <li>
                                    <span class="petdir-child-li-w">Full name:</span>
                                    <span class="petdir-data">{{ $pet->client->name ?? 'N/A' }}</span>
                                </li>
                                <li>
                                    <span class="petdir-child-li-w">Address:</span>
                                    <span class="petdir-data">
                                        {{ $pet->client->address ?? '' }},
                                        {{ $pet->client->city ?? '' }},
                                        {{ $pet->client->state ?? '' }}
                                    </span>
                                </li>
                                <li>
                                    <span class="petdir-child-li-w">Phone:</span>
                                    <span class="petdir-data">{{ $pet->client->phone ?? 'N/A' }}</span>
                                </li>
                                <li>
                                    <span class="petdir-child-li-w">Email:</span>
                                    <span class="petdir-data">{{ $pet->client->email ?? 'N/A' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 my-4">
                    <ul class="nav crm-tabs015 nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">Appointment Reminders <span class="no-lines"> 5 </span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false"> RX <span class="no-lines"> 7 </span> </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button"
                                role="tab" aria-controls="pills-contact" aria-selected="false"> History <span
                                    class="no-lines"> 7 </span> </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pl1" type="button"
                                role="tab" aria-controls="pills-payment-tab" aria-selected="false"> Payment <span
                                    class="no-lines"> 7 </span> </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#medical-documents-tab"
                                type="button" role="tab" aria-controls="medical-documents" aria-selected="false">
                                Medical Documents <span class="no-lines"> 7 </span> </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="col-lg-12">
                                <div class="comon-li py-0 d-inline-block w-100">
                                    <div class="taosy01 w-100 thead-bt">
                                        <table id="example3" class="table table-striped nowrap  pet-directory">
                                            <thead class="vir-aling">
                                                <tr>
                                                    <th>reminder name</th>
                                                    <th>due date</th>
                                                    <th>
                                                        <button class="create-dir-outline-btn ">+ Create
                                                            Reminder</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody-pad">
                                                <tr>
                                                    <td>Send vaccine reminder</td>
                                                    <td>10 May 2025 <span
                                                            class="badge-dir badge-u-dir btn">Upcomming</span>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="my-0 d-flex align-items-center justify-content-evenly pe-3 ">
                                                            <button class="btn-delete-edit">
                                                                <img src="{{asset('images/idelete.svg')}}" alt="">
                                                            </button>
                                                            <button class="btn-delete-edit">
                                                                <img src="{{asset('images/iedit.svg')}}" alt="">
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Send vaccine reminder</td>
                                                    <td>10 May 2025 <span
                                                            class="badge-dir badge-l-dir btn">Lapssed</span></td>
                                                    <td>
                                                        <div
                                                            class="my-0 d-flex align-items-center justify-content-evenly pe-3">
                                                            <button class="btn-delete-edit">
                                                                <img src="{{asset('images/idelete.svg')}}" alt="">
                                                            </button>

                                                            <button class="btn-delete-edit">
                                                                <img src="{{asset('images/iedit.svg')}}" alt="">
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Follow up on appointment</td>
                                                    <td>10 May 2025 <span class="badge-dir badge-t-dir btn">Today</span>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="my-0 d-flex align-items-center justify-content-evenly pe-3">
                                                            <button class="btn-delete-edit">
                                                                <img src="{{asset('images/idelete.svg')}}" alt="">
                                                            </button>

                                                            <button class="btn-delete-edit">
                                                                <img src="{{asset('images/iedit.svg')}}" alt="">
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            <div class="comon-li py-0 d-inline-block w-100">
                                <div class="taosy01 w-100 thead-bt">
                                    <table id="rxtable" class="table table-striped nowrap pet-directory">
                                        <thead>
                                            <tr>
                                                <th>Medication</th>
                                                <th>Dosage Form</th>
                                                <th>Quantity</th>
                                                <th>Refills</th>
                                                <th>Valid Until</th>
                                                <th>Use By</th>
                                                <th>Instructions</th>
                                                <th>Authorized Vet</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody-pad">
                                            @forelse ($pet->appointments as $appointment)
                                            @foreach ($appointment->medications as $medication)
                                            <tr>
                                                <td>{{ $medication->name }}</td>
                                                <td>{{ $medication->dosage_form }}</td>
                                                <td>{{ $medication->quantity_in_stock }} tablets</td>
                                                <td>{{ $medication->refills }}</td>
                                                <td>{{ \Carbon\Carbon::parse($medication->valid_until)->format('F d, Y') }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($medication->use_by_date)->format('F d, Y') }}
                                                </td>
                                                <td>{{ $medication->instructions }}</td>
                                                <td>{{ $medication->authorized_vet }}</td>
                                            </tr>
                                            @endforeach
                                            @empty
                                            <tr>
                                                <td colspan="8">No medication data found for this pet.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab">
                            <div class="comon-li py-0 d-inline-block w-100 thead-bt">
                                <div class="taosy01 w-100">
                                    <table id="example" class="table table-striped nowrap pet-directory">
                                        <thead>
                                            <tr>
                                                <th>Reason for Visit</th>
                                                <th>Date / Time</th>
                                                <th>Clinic</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody-pad">
                                            @forelse ($pet->appointments as $appointment)
                                            <tr>
                                                <td>{{ $appointment->reason ?? 'undefined' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('F jS \\a\\t h:i A') }}
                                                </td>
                                                <td>{{ $appointment->clinic->name ?? '—' }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3">No visit history found for this pet.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pl1" role="tabpanel" aria-labelledby="pills-payment-tab">
                            <div class="col-lg-12 mt-4">
                                <div class="comon-li pt-0 pb-0 d-inline-block w-100">
                                    <div class="taosy01 thead-bt w-100">
                                        <table id="paymenttable" class="table mb-0 table-striped nowrap">
                                            <thead class="thead-bt">
                                                <tr>
                                                    <th>Invoice ID</th>
                                                    <th>Invoice Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>

                                                </tr>
                                            </thead>
                                            <tbody class="tbody-pad">
                                                <tr>
                                                    <td>
                                                        ID867453
                                                    </td>
                                                    <td>8 May 2025</td>
                                                    <td>$250</td>


                                                    <td>
                                                        <p class="bill-sts btn"><span class="sts-dot"></span> <span
                                                                class="paid">Paid</span></p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        ID867453
                                                    </td>
                                                    <td>8 May 2025</td>
                                                    <td>$250</td>


                                                    <td>
                                                        <p class="bill-sts btn"><span class="sts-dot"></span> <span
                                                                class="paid">Paid</span></p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        ID867453
                                                    </td>
                                                    <td>ID89788</td>
                                                    <td>$250</td>


                                                    <td>
                                                        <p class="bill-sts btn "><span class="sts-dot"></span> <span
                                                                class="paid">Paid</span></p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        ID867453
                                                    </td>
                                                    <td>8 May 2025</td>
                                                    <td>$250</td>


                                                    <td>
                                                        <p class="bill-sts-o btn"><span class="sts-dot-o"></span> <span
                                                                class="paid-o">Overdue</span></p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        ID867453
                                                    </td>
                                                    <td>8 May 2025</td>
                                                    <td>$250</td>


                                                    <td>
                                                        <p class="bill-sts-p btn">
                                                            <span class="sts-dot-p"></span>
                                                            <span class="paid-p">Pendding</span>
                                                        </p>
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Medical Documents Tab -->
                        <div class="tab-pane fade" id="medical-documents-tab" role="tabpanel"
                            aria-labelledby="medical-documents-tab">
                            <div class="d-flex flex-wrap gap-3">

                                <!-- Upload Card -->
                                <form action="{{ route('appointments.uploadDocument') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="client_id" value="{{ $pet->client->id }}">

                                    <div class="medical-card uploadfile" style="width: 150px;">
                                        <label for="fileupload" class="medical-card-upload uploadfile"
                                            style="cursor:pointer">
                                            <img src="{{ asset('images/iupload.svg') }}" alt="">
                                        </label>
                                        <p class="uoload-text">Add Medical Documentation</p>
                                        <input type="file" id="fileupload" name="document" class="fileupload" required
                                            hidden onchange="this.form.submit()">
                                    </div>
                                </form>

                                <!-- Uploaded Documents -->
                                @foreach ($pet->client->documents ?? [] as $doc)
                                @php
                                $filePath = $doc->file_path;
                                $fileExists = file_exists($filePath);
                                $fileSize = $fileExists ? \Illuminate\Support\Facades\File::size($filePath) : 0;
                                @endphp

                                <a href="{{ $fileExists ? asset($doc->file_path) : '#' }}" target="_blank"
                                    style="text-decoration: none; color: inherit;">
                                    <div class="medical-card" style="width: 150px;">
                                        <div class="medical-card-icon">
                                            <img src="{{ asset('images/idoc.svg') }}" alt="">
                                        </div>
                                        <p class="text-hide">
                                            {{ \Illuminate\Support\Str::limit(basename($doc->file_path), 25) }}
                                        </p>
                                        <p class="file-ext">
                                            <span>{{ strtoupper(pathinfo($doc->file_path, PATHINFO_EXTENSION)) }}</span>
                                            <span>{{ $fileSize > 0 ? number_format($fileSize / 1024 / 1024, 1) . ' MB' : '0.0 MB' }}</span>
                                        </p>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
    $(document).ready(function() {
        new DataTable('#example3', {
            columnDefs: [{
                    width: 472,
                    targets: 0
                },
                {
                    width: 472,
                    targets: 1
                },
                {
                    width: 169,
                    targets: 2
                },
            ],
            responsive: true,
            searching: false,
            lengthChange: false,
            paging: false, // Disable pagination
            info: false // Disable "Showing X to Y of Z entries"
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        new DataTable('#rxtable', {
            columnDefs: [{
                    width: 138,
                    targets: 0
                },
                {
                    width: 138,
                    targets: 1
                },
                {
                    width: 138,
                    targets: 2
                },
                {
                    width: 138,
                    targets: 4
                },
                {
                    width: 138,
                    targets: 5
                },
                {
                    width: 160,
                    targets: 6
                },
                {
                    width: 138,
                    targets: 7
                },
            ],
            responsive: true,
            searching: false,
            lengthChange: false,
            paging: false, // Disable pagination
            info: false // Disable "Showing X to Y of Z entries"
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        new DataTable('#paymenttable', {
            columnDefs: [{
                    width: 282,
                    targets: 0
                },
                {
                    width: 282,
                    targets: 1
                },
                {
                    width: 282,
                    targets: 2
                },
                {
                    width: 282,
                    targets: 3
                },
            ],
            responsive: true,
            searching: false,
            lengthChange: false,
            paging: false, // Disable pagination
            info: false // Disable "Showing X to Y of Z entries"
        });
    });
    </script>
    <script>
    document.getElementById('fileupload')?.addEventListener('change', function() {
        this.closest('form').submit();
    });
    </script>

    <x-footer />
</body>

</html>