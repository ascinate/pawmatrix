<x-header />

<body class="all-bg billingpage">
    <main class="float-start w-100 billing-pages">
        <x-sidebar />
        <section class="left-sections-right float-end">
            <div class="row p-0 m-0">
                <div class="col-lg-12">
                    <div class="row p-0 m-0">
                        <div class="col-lg-12 px-lg-0">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h2 class="headingh1 m-0"> Billing </h2>
                                <button type="button" class="patient-btn checkin" data-bs-toggle="modal"
                                    data-bs-target="#appoinment"> + Create Invoice</button>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="comon-fedds d-inline-block w-100">
                        <p> Created Invoice </p>
                        <div class="d-flex align-items-center">
                            <h2> {{ $totalInvoices }} </h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="comon-fedds d-inline-block w-100">
                        <p> Paid Invoice </p>
                        <div class="d-flex align-items-center">
                            <h2> {{ $paidInvoicesCount }} </h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="comon-fedds d-inline-block w-100">
                        <p> Overdue Invoices </p>
                        <div class="d-flex align-items-center">
                            <h2> {{ $overdueInvoicesCount  }} </h2>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 wi my-4">
                    <ul class="nav billings015-tabs crm-tabs01 crm-tabs015 nav-pills mb-3" id="pills-tab"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">All <span class="no-lines"> {{ $allInvoicesCount }}
                                </span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false"> Pending <span class="no-lines"> {{ $pendingInvoicesCount }}
                                </span> </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                                aria-selected="false"> Paid <span class="no-lines"> {{ $paidInvoicesCount }} </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-overdue-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-overdue" type="button" role="tab" aria-controls="pills-overdue"
                                aria-selected="false"> Overdue <span class="no-lines"> {{ $overdueInvoicesCount }}
                                </span> </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="col-lg-12 mt-4">
                                <div class="comon-li pt-0 d-inline-block w-100">
                                    <div class="taosy01 cmtop-b billings015-tabs  w-100 cmpt-1250">
                                        <table id="exampledirectory1" class="table table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Owner Name</th>
                                                    <th>Invoice ID</th>
                                                    <th>Invoice Date</th>
                                                    <th>Invoice Due Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody-pad">
                                                @foreach($invoices as $invoice)
                                                <tr>
                                                    <td>
                                                       <span class="cm-wit">{{ $invoice->client_name }}</span> 
                                                    </td>
                                                    <td> <span class="cm-wit">ID{{ $invoice->id }}</span></td>
                                                    <td><span class="cm-wit">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</span>
                                                    </td>
                                                    <td><span class="tc-info">
                                                        @if($invoice->due_date)
                                                        @php
                                                        $dueDate = \Carbon\Carbon::parse($invoice->due_date);
                                                        $now = \Carbon\Carbon::now();
                                                        $diff = $dueDate->diffInDays($now);
                                                        @endphp
                                                        @if($dueDate->isPast())
                                                        {{ $diff }} days ago
                                                        @else
                                                        {{ $diff }} days left
                                                        @endif
                                                        @else
                                                        -
                                                        @endif </span>
                                                    </td>
                                                    <td><span class="cm-wit">${{ number_format($invoice->total, 2) }}</span></td>
                                                    <td><span class="cm-wit">
                                                        @if($invoice->status == 'paid')
                                                        <span class="paid"> <i class="ri-circle-fill"></i> Paid</span>
                                                        @elseif($invoice->status == 'unpaid' && $invoice->due_date &&
                                                        \Carbon\Carbon::parse($invoice->due_date)->isPast())
                                                        <span class="paid-o"> <i class="ri-circle-fill"></i>
                                                            Overdue</span>
                                                        @elseif($invoice->status == 'unpaid')
                                                        <span class="btn paid2"> <i class="ri-circle-fill"></i>
                                                            Pending</span>
                                                        @elseif($invoice->status == 'partial')
                                                        <span class="btn bill-sts-p"> <i class="ri-circle-fill"></i>
                                                            Partial</span>
                                                        @endif</span>
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="my-0 ">
                                                            <form action=""
                                                                method="" class="d-inline">
                                                                <!-- @csrf
                                                                @method('DELETE') -->
                                                                <button type="submit" class="btn-delete-edit"
                                                                    onclick="return confirm('Are you sure you want to delete this invoice?')">
                                                                    <img src="{{ asset('images/idelete.svg')}}"
                                                                        alt="name" />
                                                                </button>
                                                            </form>

                                                            <a href="{{ route('invoices.update', $invoice->id) }}"
                                                                class="btn-delete-edit left-edit">
                                                                <img src="{{ asset('images/iedit.svg')}}" alt="name" />
                                                            </a>
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
                                <div class="comon-li pt-0 d-inline-block w-100">
                                    <div class="taosy01 cmtop-b  w-100">
                                        <table class="table table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Owner Name</th>
                                                    <th>Invoice ID</th>
                                                    <th>Invoice Date</th>
                                                    <th>Invoice Due Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody-pad">
                                                @foreach($pendingInvoices as $invoice)
                                                <tr>
                                                    <td> <span class="cm-wit">{{ $invoice->client->name}}</span></td>
                                                    <td><span class="cm-wit">ID{{ $invoice->id }}</span></td>
                                                    <td><span class="cm-wit">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</span>
                                                    </td>
                                                    <td><span class="tc-info">
                                                         @if($invoice->due_date)
                                                        @php
                                                        $dueDate = \Carbon\Carbon::parse($invoice->due_date);
                                                        $now = \Carbon\Carbon::now();
                                                        $diff = $dueDate->diffInDays($now);
                                                        @endphp
                                                        @if($dueDate->isPast())
                                                        {{ $diff }} days ago
                                                        @else
                                                        {{ $diff }} days left
                                                        @endif
                                                        @else
                                                        -
                                                        @endif
                                                    </span>
                                                       
                                                    </td>
                                                    <td><span class="cm-wit">${{ number_format($invoice->total, 2) }} </span></td>
                                                    <td>
                                                        <span class="btn paid2"> <i class="ri-circle-fill"></i>
                                                            Pending</span>
                                                    </td>
                                                    <td>
                                                        <figure
                                                            class="my-0 d-flex align-items-center justify-content-center gap-4">
                                                            <!-- Same action buttons as above -->
                                                        </figure>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab">
                            <div class="col-lg-12 mt-4">
                                <div class="comon-li pt-0 d-inline-block w-100">
                                    <div class="taosy01 cmtop-b  w-100">
                                        <table class="table table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Owner Name</th>
                                                    <th>Invoice ID</th>
                                                    <th>Invoice Date</th>
                                                    <th>Invoice Due Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody-pad">
                                                @foreach($paidInvoices as $invoice)
                                                <tr>
                                                    <td> <span class="cm-wit">{{ $invoice->client->name }}</span></td>
                                                    <td><span class="cm-wit">ID{{ $invoice->id }}</span></td>
                                                    <td><span class="cm-wit">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</span>
                                                    </td>
                                                    <td>-</td>
                                                    <td><span class="cm-wit">${{ number_format($invoice->total, 2) }}</span></td>
                                                    <td>
                                                        <span class="btn paid2 cm-wit"> <i class="ri-circle-fill"></i>
                                                            Paid</span>
                                                    </td>
                                                    <td>
                                                        <figure
                                                            class="my-0 d-flex align-items-center justify-content-center gap-4">
                                                            <!-- Same action buttons as above -->
                                                        </figure>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-overdue" role="tabpanel"
                            aria-labelledby="pills-overdue-tab">
                            <div class="col-lg-12 mt-4">
                                <div class="comon-li pt-0 d-inline-block w-100">
                                    <div class="taosy01 cmtop-b  w-100">
                                        <table id="exampledirectory41" class="table table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Owner Name</th>
                                                    <th>Invoice ID</th>
                                                    <th>Invoice Date</th>
                                                    <th>Invoice Due Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tbody-pad">
                                                @foreach($overdueInvoices as $invoice)
                                                <tr>
                                                    <td> <span class="cm-wit">{{$invoice->client->name}}</span></td>
                                                    <td><span class="cm-wit"> ID{{ $invoice->id }}</span></td>
                                                    <td> <span
                                                            class="cm-wit">{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}
                                                        </span> </td>
                                                    <td><span class="tc-info">
                                                        @php
                                                        $dueDate = \Carbon\Carbon::parse($invoice->due_date);
                                                        $now = \Carbon\Carbon::now();
                                                        $diff = $dueDate->diffInDays($now);
                                                        @endphp
                                                        {{ $diff }} days ago</span>
                                                    </td>
                                                    <td><span class="cm-wit">${{ number_format($invoice->total, 2) }}</span></td>
                                                    <td>
                                                        <span class="btn bill-sts-o01"> <i class="ri-circle-fill"></i>
                                                            Overdue</span>
                                                    </td>
                                                    <td>
                                                        <figure
                                                            class="my-0 d-flex align-items-center justify-content-center gap-4">
                                                            <!-- Same action buttons as above -->
                                                        </figure>
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
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade sm-modals" id="checkinmodal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Check In</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p> Are you sure you want to check in <span> {name of patient} </span> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Invoice Modal (Dynamic + Styled like Static) -->
    <div class="modal fade crm-modalsd01-forms" id="appoinment" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form method="POST" action="{{ route('invoice_items.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Invoice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="crm-form-modal">
                            <div class="row gy-3">
                                <!-- Pet Name (Dynamic) -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Pet's Name</label>
                                        <select class="form-select" name="pet_id" id="petSelect" required>
                                            <option disabled selected>Select pet</option>
                                            @foreach($pets as $pet)
                                            <option value="{{ $pet->id }}" data-client="{{ $pet->client_id }}">
                                                {{ $pet->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label">Owner Name</label>
                                        <select class="form-select" name="client_id" id="clientSelect" required>
                                            <option disabled selected>Select owner</option>
                                            @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label"> Appointment Date </label>
                                        <input class="form-control textr" type="date" name="appointment_date" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label"> Due Date </label>
                                        <input class="form-control textr" type="date" name="due_date" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label"> Tax </label>
                                        <input class="form-control" type="number" name="tax" step="0.01"
                                            placeholder="Enter tax">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label"> Discount </label>
                                        <input class="form-control" type="number" name="discount" step="0.01"
                                            placeholder="Enter discount">
                                    </div>
                                </div>
                            </div>

                            <div class="container bg-gray mt-4 pb-3" id="invoice-items-container">
                                <div class="row gy-3 invoice-item-row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="form-label"> Service </label>
                                            <select class="form-select" name="items[0][product_id]" required>
                                                @foreach($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label"> Quantity </label>
                                            <input class="form-control" type="number" name="items[0][quantity]" min="1"
                                                value="1" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label"> Unit Price </label>
                                            <input class="form-control" type="number" name="items[0][unit_price]"
                                                step="0.01" placeholder="0.00" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2 gy-3">
                                <div class="col-lg-12 mx-auto">
                                    <button type="button" id="addServiceBtn" class="btn btn-alls w-100">+ Add New
                                        Service</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pe-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Invoice</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        new DataTable('#example', {
            responsive: true,
            searching: false,
            lengthChange: false
        });
    });
    </script>
    <script>
    let serviceIndex = 1;

    document.getElementById('addServiceBtn').addEventListener('click', function() {
        const container = document.getElementById('invoice-items-container');
        const newRow = document.createElement('div');
        newRow.className = 'row gy-3 invoice-item-row mt-2';
        newRow.innerHTML = `
        <div class="col-lg-8">
            <div class="form-group">
                <label class="form-label"> Service </label>
                <select class="form-select" name="items[${serviceIndex}][product_id]" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-label"> Quantity </label>
                <input class="form-control" type="number" name="items[${serviceIndex}][quantity]" min="1" value="1" required>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-label"> Unit Price </label>
                <input class="form-control" type="number" name="items[${serviceIndex}][unit_price]" step="0.01" placeholder="0.00" required>
            </div>
        </div>
    `;
        container.appendChild(newRow);
        serviceIndex++;
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const clientSelect = document.getElementById('clientSelect');
        const petSelect = document.getElementById('petSelect');

        clientSelect.addEventListener('change', function() {
            const selectedClientId = this.value;

            // Reset pet dropdown
            petSelect.innerHTML = '<option disabled selected>Select pet</option>';

            // Get all options from the original pet select (you can keep a copy if needed)
            const allPets = @json($pets);

            // Filter pets for the selected client
            const filteredPets = allPets.filter(pet => pet.client_id == selectedClientId);

            filteredPets.forEach(pet => {
                const option = document.createElement('option');
                option.value = pet.id;
                option.textContent = pet.name;
                petSelect.appendChild(option);
            });
        });
    });
    </script>


    <x-footer />