<x-header/>


<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Add New Vet</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('vets.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Create Vet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<x-footer/>