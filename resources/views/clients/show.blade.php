@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card client-details-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Client Details: {{ $client->name }}</h4>
                    <div>
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary btn-sm">
                            <i class="lni lni-pencil"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Contact Information</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Email:</strong> {{ $client->email }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Phone:</strong> {{ $client->phone }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Preferred Contact:</strong> 
                                    <span class="badge bg-info">
                                        {{ ucfirst($client->preferred_contact_method) }}
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <strong>Address:</strong> {{ $client->address ?? 'N/A' }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Additional Information</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Notes:</strong> {{ $client->notes ?? 'None' }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Pets:</strong> {{ $client->pets->count() }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Appointments:</strong> {{ $client->appointments->count() }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Documents:</strong> {{ $client->documents->count() }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pets Section -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Pets</h5>
                </div>
                <div class="card-body">
                    @if($client->pets->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Species</th>
                                        <th>Breed</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client->pets as $pet)
                                    <tr>
                                        <td>{{ $pet->name }}</td>
                                        <td>{{ $pet->species }}</td>
                                        <td>{{ $pet->breed }}</td>
                                        <td>{{ ucfirst($pet->gender) }}</td>
                                        <td>{{ $pet->birthdate ? \Carbon\Carbon::parse($pet->birthdate)->age . ' years' : 'Unknown' }}</td>
                                        <td>
                                            <a href="{{ route('pets.show', $pet->id) }}" class="btn btn-sm btn-info">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mb-0">No pets registered for this client.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection