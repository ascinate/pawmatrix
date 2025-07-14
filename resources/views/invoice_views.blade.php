<x-header/>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Invoice #{{ $invoice->id }}</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Back to Invoices
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                <i class="fas fa-money-bill-wave me-1"></i> Add Payment
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>From:</h5>
                    <address>
                        <strong>Veterinary Clinic</strong><br>
                        123 Clinic Street<br>
                        City, State 12345<br>
                        Phone: (123) 456-7890<br>
                        Email: clinic@example.com
                    </address>
                </div>
                <div class="col-md-6 text-end">
                    <h5>To:</h5>
                    <address>
                        <strong>{{ $invoice->client_name }}</strong><br>
                        {{ $invoice->client_address }}<br>
                        Phone: {{ $invoice->client_phone }}<br>
                        Email: {{ $invoice->client_email }}
                    </address>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Invoice Date:</strong> {{ $invoice->formatted_date->format('M d, Y') }}</p>
                    @if($invoice->appointment_id)
                        <p><strong>Appointment Date:</strong> {{ $invoice->appointment_date->format('M d, Y') }}</p>
                    @endif
                </div>
                <div class="col-md-6 text-end">
                    <p><strong>Status:</strong> 
                        <span class="badge 
                            @if($invoice->status == 'paid') bg-success
                            @elseif($invoice->status == 'partial') bg-warning
                            @elseif($invoice->status == 'cancelled') bg-danger
                            @else bg-secondary
                            @endif">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->unit_price, 2) }}</td>
                            <td>${{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row justify-content-end">
                <div class="col-md-4">
                    <table class="table">
                        <tr>
                            <th>Subtotal:</th>
                            <td>${{ number_format($invoice->items->sum(function($item) { return $item->quantity * $item->unit_price; }), 2) }}</td>
                        </tr>
                        @if($invoice->tax > 0)
                        <tr>
                            <th>Tax:</th>
                            <td>${{ number_format($invoice->tax, 2) }}</td>
                        </tr>
                        @endif
                        @if($invoice->discount > 0)
                        <tr>
                            <th>Discount:</th>
                            <td>-${{ number_format($invoice->discount, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="table-active">
                            <th>Total:</th>
                            <td>${{ number_format($invoice->total, 2) }}</td>
                        </tr>
                        <tr class="table-success">
                            <th>Paid:</th>
                            <td>${{ number_format($invoice->payments->sum('amount'), 2) }}</td>
                        </tr>
                        <tr class="table-warning">
                            <th>Balance:</th>
                            <td>${{ number_format($invoice->total - $invoice->payments->sum('amount'), 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Payments</h6>
        </div>
        <div class="card-body">
            @if($invoice->payments->isEmpty())
                <p class="text-muted">No payments recorded for this invoice.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->payments as $payment)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($payment->paid_at)->format('M d, Y') }}</td>
                                <td>${{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst($payment->method) }}</td>
                                <td>
                                    <form action="{{ route('invoices.payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this payment?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Payment Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentModalLabel">Add Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('invoices.payments.store', $invoice->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" 
                               min="0.01" max="{{ $invoice->total - $invoice->payments->sum('amount') }}" 
                               step="0.01" required>
                        <small class="text-muted">Maximum: ${{ number_format($invoice->total - $invoice->payments->sum('amount'), 2) }}</small>
                    </div>
                    <div class="mb-3">
                        <label for="method" class="form-label">Payment Method</label>
                        <select class="form-select" id="method" name="method" required>
                            <option value="cash">Cash</option>
                            <option value="card">Credit/Debit Card</option>
                            <option value="insurance">Insurance</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="paid_at" class="form-label">Payment Date</label>
                        <input type="date" class="form-control" id="paid_at" name="paid_at" 
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Record Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<x-footer/>