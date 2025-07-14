<x-header />

<body>
    <main class="float-start appointment-page w-100">
        <x-sidebar />
        <section class="left-sections-right float-end">
            <div class="row p-0 m-0">
                <div class="col-lg-8">
                    <div class="row p-0 m-0">
                        <div class="col-lg-12 ps-lg-0">
                            <div class="d-flex top-headings align-items-center">
                                <a href="#" class="btn">
                                    <i class="ri-arrow-left-s-line"></i>
                                </a>
                                <h2 class="headingh1 mb-0">
                                    Appointment Notes & Billing
                                </h2>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="comon-box d-block w-100 spa-pading0150">
                        <div class="row">
                            <div class="col-lg-1">
                                <div class="apointmentnote-img">
                                    <img src="{{ $appointment->pet && $appointment->pet->image ? asset($appointment->pet->image) : asset('images/default-pet.jpg') }}"
                                        alt="">
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <p>
                                    <span class="apointmentnote-label">Pet name: </span>
                                    <span
                                        class="common-settings-card-heading">{{ $appointment->pet->name ?? 'N/A' }}</span>
                                </p>
                                <p>
                                    <span class="apointmentnote-label">Breed: </span>
                                    <span
                                        class="common-settings-card-heading">{{ $appointment->pet->breed ?? 'N/A' }}</span>
                                </p>
                                <p>
                                    <span class="apointmentnote-label">Age: </span>
                                    <span class="common-settings-card-heading">
                                        {{ $appointment->pet->birthdate ? \Carbon\Carbon::parse($appointment->pet->birthdate)->age . ' years old' : 'N/A' }}
                                    </span>
                                </p>
                                <p>
                                    <span class="apointmentnote-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                            height="18" fill="rgba(238,96,96,1)">
                                            <path
                                                d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 7H13V9H11V7ZM11 11H13V17H11V11Z" />
                                        </svg> Important Notes:
                                    </span>
                                    <span
                                        class="common-settings-card-heading">{{ $appointment->notes ?? 'No notes available' }}</span>
                                </p>
                            </div>
                            <div class="col-lg-5">
                                <p>
                                    <span class="apointmentnote-label">Date: </span>
                                    <span
                                        class="common-settings-card-heading">{{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('F jS') }}</span>
                                </p>
                                <p>
                                    <span class="apointmentnote-label">Time: </span>
                                    <span
                                        class="common-settings-card-heading">{{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('h:i A') }}</span>
                                </p>
                                <p>
                                    <span class="apointmentnote-label">Room assigned: </span>
                                    <span
                                        class="common-settings-card-heading">{{ $appointment->room ?? 'Unassigned' }}</span>
                                </p>
                                <p>
                                    <span class="apointmentnote-label">Vet assigned: </span>
                                    <span
                                        class="common-settings-card-heading">{{ $appointment->vet->name ?? 'Not Assigned' }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="div-box">
                            <p>
                                <span class="apointmentnote-label">Reason for visit: </span>
                                <span class="common-settings-card-heading">{{ $appointment->reason ?? 'N/A' }}</span>
                            </p>
                            <p>
                                <span class="apointmentnote-label">Appointment notes: </span>
                                <span
                                    class="common-settings-card-heading">{{ $appointment->appointment_notes ?? 'N/A' }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 top-sacing">
                    <ul class="nav crm-tabs015 nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">SOAP Notes <span class="no-lines"> 5 </span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false"> RX <span class="no-lines"> 7 </span> </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                                aria-selected="false"> Discharge Notes <span class="no-lines"> 7 </span> </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-fina" type="button" role="tab" aria-controls="pills-contact"
                                aria-selected="false"> Finalize & Send <span class="no-lines"> 7 </span> </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="row">
                                <!--For soap submit-->
                                <div class="col-lg-8 mt-4">
                                    {{-- ✅ Flash Messages --}}
                                    @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif

                                    @if($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif

                                    {{-- 📝 SOAP Notes Form --}}
                                    <form action="{{ route('appointment.soap.store', $appointment->id) }}"
                                        method="POST">
                                        @csrf

                                        <div class="comon-li d-inline-block w-100">
                                            <h5 class="cl">SOAP Notes:</h5>

                                            <div class="soap-padding">
                                                <label for="subjective"
                                                    class="common-settings-card-heading">Subjective</label>
                                                <textarea name="subjective" id="subjective" class="form-control"
                                                    rows="4" cols="50"
                                                    placeholder="Enter owner's observations and concerns here"></textarea>
                                            </div>

                                            <div class="soap-padding">
                                                <label for="objective"
                                                    class="common-settings-card-heading">Objective</label>
                                                <textarea name="objective" id="objective" class="form-control" rows="4"
                                                    cols="50" placeholder="Record vitals and physical exam findings">

                                                </textarea>
                                            </div>

                                            <div class="soap-padding">
                                                <label for="assessment"
                                                    class="common-settings-card-heading">Assessment</label>
                                                <textarea name="assessment" id="assessment" class="form-control"
                                                    rows="4" cols="50"
                                                    placeholder="Write vet's diagnosis or impressions">

                                                </textarea>
                                            </div>

                                            <div class="soap-padding">
                                                <label for="plan" class="common-settings-card-heading">Plan</label>
                                                <textarea name="plan" id="plan" class="form-control" rows="4" cols="50"
                                                    placeholder="Outline treatments, tests, and next steps">

                                                </textarea>
                                            </div>

                                            <div class="mt-3">
                                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!--soap template end-->
                                <div class="col-lg-4 mt-4">
                                    <div class="comon-li d-inline-block w-100">
                                        <h5 class="cl">Billing & Services:</h5>
                                        <div class="soap-padding">
                                            <button data-bs-toggle="modal" data-bs-target="#addnewservice"
                                                class="common-outline-btn btn btn-alls w-100 add-service margin-b">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                                    height="18" fill="rgba(0,0,0,1)">
                                                    <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path>
                                                </svg>Add New Service
                                            </button>
                                        </div>
                                        <div class="soap-padding ">
                                            <div class="table-style">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <td class="service">Services</td>
                                                            <td>Qty</td>
                                                            <td>Unit Price</td>
                                                            <td>Amount</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="tbody-color">
                                                        @php $subTotal = 0; @endphp
                                                        @foreach($invoiceItems as $item)
                                                        <tr>
                                                            <td>{{ $item->product->name ?? $item->description }}</td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>${{ number_format($item->unit_price, 2) }}</td>
                                                            <td class="price">
                                                                ${{ number_format($item->unit_price * $item->quantity, 2) }}
                                                            </td>
                                                        </tr>
                                                        @php $subTotal += $item->unit_price * $item->quantity; @endphp
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <p class="d-table ms-lg-auto table-total">Sub-total
                                                    <span class="total">${{ number_format($subTotal, 2) }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="col-lg-12 mt-4">
                                <div class="comon-li d-inline-block w-100">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5>Prescription</h5>
                                        <button class="common-outline-btn btn btn-alls me-4 add-service margin-b"
                                            data-bs-toggle="modal" data-bs-target="#addnewmedication">
                                            Add New Medication
                                        </button>
                                    </div>

                                    <div class="taosy01 w-100">
                                        <table id="example-medication" class="table table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>medication</th>
                                                    <th>dosage form</th>
                                                    <th>quantity</th>
                                                    <th>refills</th>
                                                    <th>Valid until</th>
                                                    <th>use by</th>
                                                    <th>instructions</th>
                                                    <th>authorized vet</th>
                                                </tr>
                                            </thead>
                                            <tbody class="common-tbody-text">
                                                @forelse($medications as $med)
                                                <tr>
                                                    <td>{{ $med->name }}</td>
                                                    <td>{{ $med->dosage_form ?? '-' }}</td>
                                                    <td>{{ $med->quantity_in_stock ?? '-' }}</td>
                                                    <td>{{ $med->refills ?? '-' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($med->valid_until)->format('F d, Y') }}
                                                    </td>
                                                    <td>{{ $med->use_by_date ? \Carbon\Carbon::parse($med->use_by_date)->format('F d, Y') : '-' }}
                                                    </td>
                                                    <td>{{ $med->instructions ?? '-' }}</td>
                                                    <td>{{ $med->authorized_vet ?? '-' }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No medications added yet.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--appointment discharge note start-->
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-home-tab">

                            {{-- ✅ Success message --}}
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            @endif

                            {{-- ❌ Validation errors --}}
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            @endif

                            {{-- 🚀 Discharge Note Form --}}
                            <form action="{{ route('appointment.discharge.store', $appointment->id) }}" method="POST">
                                @csrf
                                <div class="comon-li d-inline-block w-100">
                                    <div class="soap-padding">
                                        <label for="discharge_note" class="common-settings-card-heading">Discharge
                                            Notes</label>
                                        <textarea name="note" id="discharge_note" class="form-control" rows="4"
                                            cols="50"
                                            placeholder="Write discharge note here...">{{ old('note', $appointment->dischargeNote->note ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                </div>
                            </form>
                        </div>

                        <!--appointment discharge note end-->
                        <div class="tab-pane fade" id="pills-fina" role="tabpanel" aria-labelledby="pills-home-tab">
                            <form action="{{ route('pets.sendEmail', $appointment->pet->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-5 mt-4">
                                        <div class="comon-li d-inline-block w-100">
                                            <div class="soap-padding finalizeSend">
                                                <!--VISIT SUMMARY START-->
                                                <h5 class="common-settings-card-heading p-0">Visit Summary</h5>
                                                <p class="text-gray">Select which parts of the visit to include in the
                                                    email.</p>
                                                <ul>
                                                    <li>
                                                        <input type="checkbox" name="visit_sections[]"
                                                            value="soap_notes" id="soap_notes">
                                                        <label for="soap_notes" class="service common-color-blue">SOAP
                                                            Notes</label>
                                                    </li>
                                                    <li>
                                                        <input type="checkbox" name="visit_sections[]"
                                                            value="invoice_summary" id="invoice_summary">
                                                        <label for="invoice_summary"
                                                            class="service common-color-blue">Invoice Summary</label>
                                                    </li>
                                                    <li>
                                                        <input type="checkbox" name="visit_sections[]"
                                                            value="medication" id="medication">
                                                        <label for="medication"
                                                            class="service common-color-blue">Medication
                                                            Prescription</label>
                                                    </li>
                                                    <li>
                                                        <input type="checkbox" name="visit_sections[]"
                                                            value="discharge_notes" id="discharge_notes">
                                                        <label for="discharge_notes"
                                                            class="service common-color-blue">Discharge Notes</label>
                                                    </li>
                                                </ul>

                                            </div>
                                            <!--VISIT SUMMARY END-->
                                            <!--This is the Additional actions to take when sending the email start-->
                                            <div class="soap-padding finalizeSend">
                                                <h5 class="common-settings-card-heading p-0">Email & Output Settings
                                                </h5>

                                                <p class="text-gray">Additional actions to take when sending the email.
                                                </p>
                                                <ul>
                                                    <li>
                                                        <input type="checkbox" name="email_actions[]"
                                                            value="copy_to_clinic" id="copy_to_clinic">
                                                        <label for="copy_to_clinic"
                                                            class="service common-color-blue">Send copy to clinic
                                                            email</label>
                                                    </li>
                                                    <li>
                                                        <input type="checkbox" name="email_actions[]"
                                                            value="mark_completed" id="mark_completed">
                                                        <label for="mark_completed"
                                                            class="service common-color-blue">Mark visit as
                                                            Completed</label>
                                                    </li>
                                                    <li>
                                                        <input type="checkbox" name="email_actions[]" value="attach_pdf"
                                                            id="attach_pdf">
                                                        <label for="attach_pdf" class="service common-color-blue">Add
                                                            PDF to patient file</label>
                                                    </li>
                                                </ul>
                                                <!--This is the Additional actions to take when sending the email end-->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-7 mt-4">
                                        <div class="comon-li d-inline-block w-100">
                                            <div class="d-flex justify-content-between">
                                                <h5 class="cl">To:</h5>
                                                <button type="button" class="edit-btn" data-bs-toggle="modal"
                                                    data-bs-target="#appoinment">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="18" height="18" fill="currentColor">
                                                        <path
                                                            d="M15.7279 9.57627L14.3137 8.16206L5 17.4758V18.89H6.41421L15.7279 9.57627ZM17.1421 8.16206L18.5563 6.74785L17.1421 5.33363L15.7279 6.74785L17.1421 8.16206ZM7.24264 20.89H3V16.6473L16.435 3.21231C16.8256 2.82179 17.4587 2.82179 17.8492 3.21231L20.6777 6.04074C21.0682 6.43126 21.0682 7.06443 20.6777 7.45495L7.24264 20.89Z">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </button>
                                            </div>

                                            <div class="d-flex gap-2 justify-content-between soap-padding">
                                                <div class="position-relative w-100">
                                                    <input type="text" name="client_name"
                                                        class="form-control sendtoform"
                                                        value="{{ $appointment->client->name }}" readonly>
                                                </div>
                                                <div class="position-relative w-100">
                                                    <input type="email" name="client_email"
                                                        class="form-control sendtoform"
                                                        value="{{ $appointment->client->email }}" readonly>
                                                </div>
                                            </div>

                                            <div class="soap-padding">
                                                <label for="message" class="common-settings-card-heading">Message to
                                                    Owner:</label>
                                                <textarea name="message" id="message" class="form-control" rows="4"
                                                    cols="50" placeholder="Write your message here..."></textarea>
                                            </div>

                                            <button type="submit" class="common-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                                    height="18" fill="rgba(255,255,255,1)">
                                                    <path
                                                        d="M1.94607 9.31543C1.42353 9.14125 1.4194 8.86022 1.95682 8.68108L21.043 2.31901C21.5715 2.14285 21.8746 2.43866 21.7265 2.95694L16.2733 22.0432C16.1223 22.5716 15.8177 22.59 15.5944 22.0876L11.9999 14L17.9999 6.00005L9.99992 12L1.94607 9.31543Z">
                                                    </path>
                                                </svg>
                                                Send Email to Owner
                                            </button>
                                        </div>
                                        <!--SEND MAIL TO OWNER DISPLAY END-->
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>


            </div>

        </section>
    </main>
    <!-- EMAIL SEND OPENING MODAL START-->
    <div class="modal fade crm-modalsd01-forms" id="appoinment" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="{{ route('appointments.sendEmail', $appointment->pet->id) }}" method="POST">
                    @csrf

                    <input type="hidden" name="client_name" value="{{ $appointment->client->name }}">
                    <input type="hidden" name="client_email" value="{{ $appointment->client->email }}">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Send Email to Owner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="crm-form-modal">
                            <div class="row gy-3">
                                <!-- Visit Summary Checkboxes -->
                                <div class="col-lg-12 mt-3">
                                    <h5 class="common-settings-card-heading p-0">Visit Summary</h5>
                                    <p class="text-gray">Select which parts of the visit to include in the email.</p>
                                    <ul>
                                        <li>
                                            <input type="checkbox" name="visit_sections[]" value="soap_notes"
                                                id="soap_notes">
                                            <label for="soap_notes" class="service common-color-blue">SOAP Notes</label>
                                        </li>
                                        <li>
                                            <input type="checkbox" name="visit_sections[]" value="invoice_summary"
                                                id="invoice_summary">
                                            <label for="invoice_summary" class="service common-color-blue">Invoice
                                                Summary</label>
                                        </li>
                                        <li>
                                            <input type="checkbox" name="visit_sections[]" value="medication"
                                                id="medication">
                                            <label for="medication" class="service common-color-blue">Medication
                                                Prescription</label>
                                        </li>
                                        <li>
                                            <input type="checkbox" name="visit_sections[]" value="discharge_notes"
                                                id="discharge_notes">
                                            <label for="discharge_notes" class="service common-color-blue">Discharge
                                                Notes</label>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Subject -->
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Subject</label>
                                        <input type="text" name="subject" class="form-control input-text"
                                            value="Visit Summary for {{ $appointment->pet->name }}">
                                    </div>
                                </div>

                                <!-- Message -->
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label-modal">Message to Owner</label>
                                        <textarea name="message" class="form-control" rows="4" cols="50"
                                            placeholder="Hi {{ $appointment->client->name }}, Here's the summary from {{ $appointment->pet->name }}'s visit today. Please review the details attached. Let us know if you have any questions or concerns."></textarea>
                                    </div>
                                </div>


                                <!-- Attachments Display -->
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Attachments:</label>
                                        @if(in_array('soap_notes', $request->visit_sections ?? []))
                                        <div class="send-email-owner">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                                height="18" fill="#424CA8">
                                                <path
                                                    d="M9 2.00318V2H19.9978C20.5513 2 21 2.45531 21 2.9918V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5501 3 20.9932V8L9 2.00318ZM5.82918 8H9V4.83086L5.82918 8ZM11 4V9C11 9.55228 10.5523 10 10 10H5V20H19V4H11Z" />
                                            </svg>
                                            <span>SOAP Notes</span>
                                        </div>
                                        @endif

                                        @if(in_array('invoice_summary', $request->visit_sections ?? []))
                                        <div class="send-email-owner">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                                height="18" fill="#424CA8">
                                                <path
                                                    d="M9 2.00318V2H19.9978C20.5513 2 21 2.45531 21 2.9918V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5501 3 20.9932V8L9 2.00318ZM5.82918 8H9V4.83086L5.82918 8ZM11 4V9C11 9.55228 10.5523 10 10 10H5V20H19V4H11Z" />
                                            </svg>
                                            <span>Invoice Summary</span>
                                        </div>
                                        @endif

                                        @if(in_array('medication', $request->visit_sections ?? []))
                                        <div class="send-email-owner">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                                height="18" fill="#424CA8">
                                                <path
                                                    d="M9 2.00318V2H19.9978C20.5513 2 21 2.45531 21 2.9918V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5501 3 20.9932V8L9 2.00318ZM5.82918 8H9V4.83086L5.82918 8ZM11 4V9C11 9.55228 10.5523 10 10 10H5V20H19V4H11Z" />
                                            </svg>
                                            <span>Medication Prescription</span>
                                        </div>
                                        @endif

                                        @if(in_array('discharge_notes', $request->visit_sections ?? []))
                                        <div class="send-email-owner">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                                height="18" fill="#424CA8">
                                                <path
                                                    d="M9 2.00318V2H19.9978C20.5513 2 21 2.45531 21 2.9918V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5501 3 20.9932V8L9 2.00318ZM5.82918 8H9V4.83086L5.82918 8ZM11 4V9C11 9.55228 10.5523 10 10 10H5V20H19V4H11Z" />
                                            </svg>
                                            <span>Discharge Notes</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pe-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EMAIL SEND OPENING MODAL END -->

    <!-- add New Service -->
    <!-- add New Service -->
    <div class="modal fade crm-modalsd01-forms" id="addnewservice" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="{{ route('appointments.invoice_items.store', $appointment->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                    <input type="hidden" name="client_id" value="{{ $appointment->client->id }}">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Send Email to Owner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="crm-form-modal">
                            <div class="row gy-3">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="d-flex gap-2 justify-content-between ">
                                            <div class="position-relative w-100" id="service-items-container">
                                                <!-- Start with 1 row -->
                                                <div class="row my-2 service-row">
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Service</label>
                                                        <select name="items[0][product_id]"
                                                            class="form-control input-text">
                                                            <option value="">Select Service</option>
                                                            @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">
                                                                {{ $product->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="number" name="items[0][quantity]" value="1"
                                                            class="form-control input-text" min="1">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label class="form-label">Unit Price</label>
                                                        <input type="number" name="items[0][unit_price]" step="0.01"
                                                            class="form-control input-text" placeholder="Enter price">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add new row button -->
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="button"
                                            class="common-outline-btn-modal btn btn-alls w-100 add-service margin-b"
                                            onclick="addServiceRow()">
                                            Add New Service
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pe-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add New Medication -->

    <div class="modal fade crm-modalsd01-forms" id="addnewmedication" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="{{ route('appointment.storeMedication', $appointment->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id ?? '' }}">
                    <input type="hidden" name="client_id" value="{{ $appointment->client->id ?? '' }}">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Medication</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="crm-form-modal">
                            <div class="row gy-3">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="d-flex gap-2 justify-content-between">
                                            <div class="position-relative w-100">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between w-100">
                                                            <label class="form-label">Medication Name</label>
                                                        </div>
                                                        <input type="text" name="name" class="form-control input-text"
                                                            required>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between w-100">
                                                            <label class="form-label">Authorized Vet</label>
                                                        </div>
                                                        <input type="text" name="authorized_vet"
                                                            class="form-control input-text"
                                                            value="{{ $appointment->vet->name ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="row my-2">
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between w-100">
                                                            <label class="form-label">Dosage Form</label>
                                                        </div>
                                                        <select name="dosage_form" class="form-control input-text"
                                                            required>
                                                            <option value="">Select Form</option>
                                                            <option value="Tablet">Tablet</option>
                                                            <option value="Capsule">Capsule</option>
                                                            <option value="Syrup">Syrup</option>
                                                            <option value="Injection">Injection</option>
                                                            <option value="Ointment">Ointment</option>
                                                            <option value="Cream">Cream</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between w-100">
                                                            <label class="form-label">Quantity</label>
                                                        </div>
                                                        <input type="number" name="quantity_in_stock"
                                                            class="form-control input-text" value="1">
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between w-100">
                                                            <label class="form-label">Refills</label>
                                                        </div>
                                                        <input type="number" name="refills"
                                                            class="form-control input-text" value="0">
                                                    </div>
                                                </div>

                                                <div class="row my-2">
                                                    <div class="col-lg-6">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between w-100">
                                                            <label class="form-label">Valid Until</label>
                                                        </div>
                                                        <input type="date" name="valid_until"
                                                            class="form-control input-text">
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between w-100">
                                                            <label class="form-label">Use By</label>
                                                        </div>
                                                        <input type="date" name="use_by_date"
                                                            class="form-control input-text">
                                                    </div>
                                                </div>

                                                <div class="row my-2">
                                                    <div class="col-lg-12">
                                                        <label for="instructions"
                                                            class="common-settings-card-heading">Instructions</label>
                                                        <textarea name="instructions"
                                                            class="form-control d-table textarea-h" rows="4" cols="50"
                                                            placeholder="e.g. Take once daily after food."></textarea>
                                                    </div>
                                                </div>
                                            </div> <!-- /.position-relative -->
                                        </div> <!-- /.d-flex -->
                                    </div> <!-- /.form-group -->
                                </div> <!-- /.col-lg-12 -->
                            </div> <!-- /.row -->
                        </div> <!-- /.crm-form-modal -->
                    </div> <!-- /.modal-body -->

                    <div class="modal-footer border-0 pe-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    let serviceIndex = 1;

    <
    script >
        let serviceIndex = 1;

    function addServiceRow() {
        event.preventDefault();
        const container = document.getElementById('service-items-container');

        const html = `
        <div class="row my-2 service-row">
            <div class="col-lg-6">
                <label class="form-label">Service</label>
                <select name="items[${serviceIndex}][product_id]" class="form-control input-text" required>
                    <option value="">Select Service</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="items[${serviceIndex}][quantity]" value="1" class="form-control input-text" required>
            </div>
            <div class="col-lg-3">
                <label class="form-label">Unit Price</label>
                <input type="number" name="items[${serviceIndex}][unit_price]" step="0.01" class="form-control input-text" required>
            </div>
        </div>
    `;

        container.insertAdjacentHTML('beforeend', html);
        serviceIndex++;
    }
    </script>



    <x-footer />