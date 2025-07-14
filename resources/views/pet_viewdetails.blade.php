<x-header/>

<div class="container py-4">
    <!-- Breadcrumb and Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 text-primary">
                    <i class="lni lni-paw me-2"></i>Pet Details
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pets.index') }}">Pets</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $pet->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden">
                <!-- Card Header with Actions -->
                <div class="card-header bg-primary text-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold">
                                <i class="lni lni-paw me-2"></i>{{ $pet->name }}'s Profile
                            </h5>
                        </div>
                        <div>
                            <a href="{{ route('pets.index') }}" class="btn btn-light btn-sm me-2">
                                <i class="lni lni-arrow-left me-1"></i>Back
                            </a>
                            <a href="{{ route('pets.index') }}?edit={{ $pet->id }}" class="btn btn-light btn-sm">
                                <i class="lni lni-pencil me-1"></i>Edit
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body p-0">
                    <!-- Pet Image and Basic Info -->
                    <div class="row g-0">
                        <!-- Pet Image -->
                        <div class="col-md-4 bg-light p-4 d-flex flex-column align-items-center">
                            @if($pet->image)
                                <img src="{{ asset($pet->image) }}" alt="{{ $pet->name }}" class="img-fluid rounded-circle shadow mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-white rounded-circle shadow mb-3" style="width: 200px; height: 200px;">
                                    <i class="lni lni-paw text-muted" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                            
                            <h4 class="mb-1">{{ $pet->name }}</h4>
                            <p class="text-muted mb-2">{{ $pet->species }} • {{ $pet->breed }}</p>
                            
                            <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                                <span class="badge bg-info">
                                    <i class="lni lni-{{ $pet->gender == 'male' ? 'male' : 'female' }} me-1"></i>
                                    {{ ucfirst($pet->gender) }}
                                </span>
                                @if($pet->birthdate)
                                    <span class="badge bg-secondary">
                                        <i class="lni lni-calendar me-1"></i>
                                        {{ $pet->birthdate->diffInYears(now()) }} yrs
                                    </span>
                                @endif
                                <span class="badge bg-warning text-dark">
                                    <i class="lni lni-weight me-1"></i>
                                    {{ $pet->weight_kg }} kg
                                </span>
                            </div>
                            
                            <div class="text-center">
                                <p class="mb-1"><strong>Owner:</strong> {{ $pet->client->name ?? 'N/A' }}</p>
                                <p class="mb-0"><strong>Microchip:</strong> {{ $pet->microchip_number ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Detailed Information -->
                        <div class="col-md-8 p-4">
                            <!-- Tabs Navigation -->
                            <ul class="nav nav-tabs mb-4" id="petDetailsTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">Basic Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="medical-tab" data-bs-toggle="tab" data-bs-target="#medical" type="button" role="tab">Medical</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="appointments-tab" data-bs-toggle="tab" data-bs-target="#appointments" type="button" role="tab">Appointments</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="records-tab" data-bs-toggle="tab" data-bs-target="#records" type="button" role="tab">Medical Records</button>
                                </li>
                            </ul>

                            <!-- Tabs Content -->
                            <div class="tab-content" id="petDetailsTabsContent">
                                <!-- Basic Info Tab -->
                                <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-2">Species & Breed</h6>
                                                <p>{{ $pet->species }} • {{ $pet->breed }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-2">Gender</h6>
                                                <p>{{ ucfirst($pet->gender) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-2">Birthdate</h6>
                                                <p>{{ $pet->birthdate?->format('M d, Y') ?? 'N/A' }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-2">Age</h6>
                                                <p>{{ $pet->birthdate ? $pet->birthdate->diffInYears(now()) . ' years' : 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Medical Info Tab -->
                                <div class="tab-pane fade" id="medical" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-2">Vaccination Status</h6>
                                                <p>
                                                    <span class="badge bg-{{ $pet->vaccination_status == 'up to date' ? 'success' : ($pet->vaccination_status == 'not vaccinated' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($pet->vaccination_status) }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-2">Allergies</h6>
                                                <p>{{ $pet->allergies ?? 'None recorded' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-2">Additional Notes</h6>
                                                <p>{{ $pet->notes ?? 'No additional notes' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Appointments Tab -->
                                <div class="tab-pane fade" id="appointments" role="tabpanel">
                                    @if($pet->appointments->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Date & Time</th>
                                                        <th>Status</th>
                                                        <th>Notes</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pet->appointments->take(5) as $appointment)
                                                        <tr>
                                                            <td>{{ $appointment->appointment_datetime->format('M d, Y H:i') }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $appointment->status == 'completed' ? 'success' : ($appointment->status == 'cancelled' ? 'danger' : 'primary') }}">
                                                                    {{ ucfirst($appointment->status) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ Str::limit($appointment->notes, 30) }}</td>
                                                            <td>
                                                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @if($pet->appointments->count() > 5)
                                            <div class="text-center mt-3">
                                                <a href="#" class="btn btn-primary">View All Appointments ({{ $pet->appointments->count() }})</a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-info">
                                            <i class="lni lni-info-circle me-2"></i> No appointments recorded for this pet.
                                        </div>
                                    @endif
                                </div>

                                <!-- Medical Records Tab -->
                                <div class="tab-pane fade" id="records" role="tabpanel">
                                    @if($pet->medicalRecords->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Assessment</th>
                                                        <th>Diagnosis</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pet->medicalRecords->take(5) as $record)
                                                        <tr>
                                                            <td>{{ $record->visit_date->format('M d, Y') }}</td>
                                                            <td>{{ Str::limit($record->assessment, 30) }}</td>
                                                            <td>{{ Str::limit($record->diagnosis, 30) }}</td>
                                                            <td>
                                                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @if($pet->medicalRecords->count() > 5)
                                            <div class="text-center mt-3">
                                                <a href="#" class="btn btn-primary">View All Records ({{ $pet->medicalRecords->count() }})</a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-info">
                                            <i class="lni lni-info-circle me-2"></i> No medical records found for this pet.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-footer/>