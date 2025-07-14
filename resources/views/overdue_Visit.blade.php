<x-header />

<body class="all-bg">
    <main class="float-start w-100">
        <x-sidebar />
        <!--Section start-->
        <section class="left-sections-right float-end">
            <div class="row p-0 m-0">
                <div class="col-lg-12">
                    <div class="row p-0 m-0">
                        <div class="col-lg-12 ">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="headingh1">Overdue Visit</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="col-lg-12 mt-4">
                                <div class="comon-li d-inline-block w-100">
                                    <div class="taosy01 w-100">
                                        <table id="exampleoverdue" class="table table-striped nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Pet&#39;s Name</th>
                                                    <th>Owner Name</th>
                                                    <th>Overdue Since</th>
                                                    <th>reason</th>
                                                    <th>reminder</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="common-tbody-text">
                                                @forelse($overdueAppointments as $appointment)
                                                <tr>
                                                    <td>
                                                        <div class="user-div01 d-flex align-items-center">
                                                            <figure class="m-0">
                                                                <img src="{{ $appointment->pet && $appointment->pet->image ? asset($appointment->pet->image) : asset('images/default-pet.jpg') }}"
                                                                    alt="sm" />
                                                            </figure>
                                                            <span
                                                                class="text-bold ms-2">{{ $appointment->pet->name ?? 'Unknown' }}</span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $appointment->client->name ?? 'Unknown' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('d M Y') }}
                                                    </td>
                                                    <td>{{ $appointment->reason ?? 'N/A' }}</td>
                                                    <td>
                                                        @php
                                                        $status = strtolower($appointment->reminder_status ?? 'not
                                                        sent');
                                                        @endphp
                                                        @if($status === 'sent')
                                                        <p class="bill-sts btn">
                                                            <span class="sts-dot"></span>
                                                            <span class="paid">sent</span>
                                                        </p>
                                                        @else
                                                        <p class="bill-sts-n btn">
                                                            <span class="sts-dot-n"></span>
                                                            <span class="paid-n">Not Sent</span>
                                                        </p>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <figure
                                                            class="my-0 d-flex align-items-center justify-content-center gap-4">
                                                            <button class="btn-delete-edit">
                                                                <!-- Delete icon (same as in your design) -->
                                                            <img src="{{ asset('images/idelete.svg')  }}" alt="">
                                                            </button>
                                                        </figure>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No overdue appointments found.
                                                    </td>
                                                </tr>
                                                @endforelse
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
                            aria-labelledby="pills-profile-tab">...
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab">...
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </main>



    <x-footer />

</body>

</html>