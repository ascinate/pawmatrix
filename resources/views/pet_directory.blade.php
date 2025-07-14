<x-header />

<body class="all-bg petdirectory">
    <main class="float-start w-100">
        <x-sidebar />
        <section class="left-sections-right float-end">
            <div class="row p-0 m-0">
                <div class="col-lg-12">
                    <div class="row p-0 m-0">
                        <div class="col-lg-12 px-lg-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h2 class="headingh1 mb-0">Pet Directory</h2>
                                <button type="button" class="new-pet" data-bs-toggle="modal" data-bs-target="#lostpsModal" data-bs-dismiss="modal"> <i class="ri-add-line"></i> New Pet</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 marign-smae">

                    <div class="comon-li now-shadow pets-tabls pt-0 pets-tabls-01 d-inline-block w-100">

                        <div class="taosy01 w-100 cmpt-1250">
                            <table id="examplepetdirectory" class="table table-striped nowrap tbody-pad">
                                <thead>
                                    <tr>
                                        <th>Pet's Name</th>
                                        <th>Breed</th>
                                        <th>Age</th>
                                        <th>Important notes</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pets as $pet)
                                    @php
                                    $age = $pet->birthdate ? \Carbon\Carbon::parse($pet->birthdate)->age . ' years old'
                                    : 'N/A';
                                    $note = $pet->notes ?? null;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="user-div01 d-flex align-items-center">
                                                <figure class="m-0">
                                                    <img src="{{ $pet->image && file_exists($pet->image) ? asset($pet->image) : asset('images/default-pet.jpg') }}"
                                                        alt="sm" />
                                                </figure>
                                                <span class="cm-wit">{{ $pet->name ?? 'Unknown' }}</span>
                                            </div>
                                        </td>
                                        <td><span class="cm-wit">{{ $pet->breed ?? 'Unknown' }}</span></td>
                                        <td><span class="cm-wit">{{ $age }}</span></td>
                                        <td>
                                            @if ($note)
                                           
                                              <span class="warning-icon"><img
                                                                src="{{asset('images/warningIcon.svg')}}" alt=""
                                                                class="warningsvg"></span> <span class="tc-info">
                                                            {{ $note }}</span>
                                            @else
                                            <span class="no-notes">No Notes</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn view-btn"
                                                href="{{ route('pet.directory.view', ['id' => $pet->id]) }}">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No pets found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex sp-padding-btn align-items-center justify-content-between w-100">
                                <button type="button" class="btn btn-previes"> Previous </button>
                                <p class="pater"> Page 1 of 2 </p>
                                <button type="button" class="btn btn-next"> Next </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>



    </main>
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

    <script>
    $(document).ready(function() {
        new DataTable('#example', {
            responsive: true,
            searching: false,
            lengthChange: false,
            pageLength: 5,
        });
    });
    </script>

    <x-footer />