<x-header/>
<div class="container">
    <h1 class="mb-4">Reports & Analytics</h1>
    
    <ul class="nav nav-tabs mb-4" id="reportTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'revenue' ? 'active' : '' }}" id="revenue-tab" data-bs-toggle="tab" data-bs-target="#revenue" type="button" role="tab">
                Revenue
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'appointments' ? 'active' : '' }}" id="appointments-tab" data-bs-toggle="tab" data-bs-target="#appointments" type="button" role="tab">
                Appointments
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'inventory' ? 'active' : '' }}" id="inventory-tab" data-bs-toggle="tab" data-bs-target="#inventory" type="button" role="tab">
                Inventory
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $activeTab === 'outstanding' ? 'active' : '' }}" id="outstanding-tab" data-bs-toggle="tab" data-bs-target="#outstanding" type="button" role="tab">
                Outstanding
            </button>
        </li>
    </ul>
    
    <div class="tab-content" id="reportTabsContent">
        <!-- Revenue Tab -->
        <div class="tab-pane fade {{ $activeTab === 'revenue' ? 'show active' : '' }}" id="revenue" role="tabpanel">
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.index') }}" class="row">
                        <input type="hidden" name="tab" value="revenue">
                        <div class="col-md-3 mb-2">
                            <select name="revenue_period" class="form-select">
                                <option value="daily" {{ $revenuePeriod === 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ $revenuePeriod === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ $revenuePeriod === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="date" name="revenue_date" class="form-control" value="{{ $revenueDate }}">
                        </div>
                        <div class="col-md-2 mb-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Revenue Summary</h5>
                </div>
                <div class="card-body">
                    <p><strong>Period:</strong> {{ ucfirst($revenuePeriod) }} report for {{ $revenueData['startDate']->format('M d, Y') }} to {{ $revenueData['endDate']->format('M d, Y') }}</p>
                    <p><strong>Total Revenue:</strong> ${{ number_format($revenueData['totalRevenue'], 2) }}</p>
                    <p><strong>Number of Payments:</strong> {{ $revenueData['payments']->count() }}</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Payment Details</h5>
                </div>
                <div class="card-body">
                    @if($revenueData['payments']->isEmpty())
                        <p>No payments found for this period.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Invoice #</th>
                                        <th>Client</th>
                                        <th>Method</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($revenueData['payments'] as $payment)
                                        <tr>
                                            <td>{{ $payment->paid_at->format('M d, Y h:i A') }}</td>
                                            <td>{{ $payment->invoice_id }}</td>
                                            <td>{{ $payment->invoice->client->name ?? 'N/A' }}</td>
                                            <td>{{ ucfirst($payment->method) }}</td>
                                            <td>${{ number_format($payment->amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Appointments Tab -->
        <div class="tab-pane fade {{ $activeTab === 'appointments' ? 'show active' : '' }}" id="appointments" role="tabpanel">
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.index') }}" class="row">
                        <input type="hidden" name="tab" value="appointments">
                        <div class="col-md-3 mb-2">
                            <select name="appointment_period" class="form-select">
                                <option value="daily" {{ $appointmentPeriod === 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ $appointmentPeriod === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ $appointmentPeriod === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="date" name="appointment_date" class="form-control" value="{{ $appointmentDate }}">
                        </div>
                        <div class="col-md-2 mb-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Appointment Summary</h5>
                </div>
                <div class="card-body">
                    <p><strong>Period:</strong> {{ ucfirst($appointmentPeriod) }} report for {{ $appointmentData['startDate']->format('M d, Y') }} to {{ $appointmentData['endDate']->format('M d, Y') }}</p>
                    <p><strong>Total Appointments:</strong> {{ $appointmentData['appointments']->count() }}</p>
                    <p><strong>Scheduled:</strong> {{ $appointmentData['statusCounts']['scheduled'] }}</p>
                    <p><strong>Completed:</strong> {{ $appointmentData['statusCounts']['completed'] }}</p>
                    <p><strong>Cancelled:</strong> {{ $appointmentData['statusCounts']['cancelled'] }}</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Appointment Details</h5>
                </div>
                <div class="card-body">
                    @if($appointmentData['appointments']->isEmpty())
                        <p>No appointments found for this period.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Client</th>
                                        <th>Pet</th>
                                        <th>Vet</th>
                                        <th>Status</th>
                                        <th>Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointmentData['appointments'] as $appointment)
                                        <tr>
                                            <td>{{ $appointment->appointment_datetime->format('M d, Y h:i A') }}</td>
                                            <td>{{ $appointment->client->name }}</td>
                                            <td>{{ $appointment->pet->name }}</td>
                                            <td>{{ $appointment->vet->name ?? 'N/A' }}</td>
                                            <td>{{ ucfirst($appointment->status) }}</td>
                                            <td>{{ $appointment->duration_minutes }} minutes</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Inventory Tab -->
        <div class="tab-pane fade {{ $activeTab === 'inventory' ? 'show active' : '' }}" id="inventory" role="tabpanel">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Inventory Valuation</h5>
                </div>
                <div class="card-body">
                    <p><strong>Total Inventory Value:</strong> ${{ number_format($inventoryData['totalValue'], 2) }}</p>
                    <p><strong>Number of Products:</strong> {{ $inventoryData['products']->count() }}</p>
                    <p><strong>Low Stock Items:</strong> {{ $inventoryData['lowStock']->count() }}</p>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Low Stock Items</h5>
                </div>
                <div class="card-body">
                    @if($inventoryData['lowStock']->isEmpty())
                        <p>No low stock items.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Reorder Threshold</th>
                                        <th>Price</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventoryData['lowStock'] as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ ucfirst($product->category) }}</td>
                                            <td class="{{ $product->quantity_in_stock <= $product->reorder_threshold ? 'text-danger fw-bold' : '' }}">
                                                {{ $product->quantity_in_stock }}
                                            </td>
                                            <td>{{ $product->reorder_threshold }}</td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>${{ number_format($product->quantity_in_stock * $product->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Full Inventory</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Reorder Threshold</th>
                                    <th>Price</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inventoryData['products'] as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ ucfirst($product->category) }}</td>
                                        <td class="{{ $product->quantity_in_stock <= $product->reorder_threshold ? 'text-danger fw-bold' : '' }}">
                                            {{ $product->quantity_in_stock }}
                                        </td>
                                        <td>{{ $product->reorder_threshold }}</td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td>${{ number_format($product->quantity_in_stock * $product->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Outstanding Tab -->
        <div class="tab-pane fade {{ $activeTab === 'outstanding' ? 'show active' : '' }}" id="outstanding" role="tabpanel">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Summary</h5>
                </div>
                <div class="card-body">
                    <p><strong>Total Outstanding:</strong> ${{ number_format($outstandingData['totalOutstanding'], 2) }}</p>
                    <p><strong>Number of Unpaid Invoices:</strong> {{ $outstandingData['invoices']->count() }}</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Invoice Details</h5>
                </div>
                <div class="card-body">
                    @if($outstandingData['invoices']->isEmpty())
                        <p>No outstanding invoices.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Date</th>
                                        <th>Client</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($outstandingData['invoices'] as $invoice)
                                        @php
                                            $paidAmount = $invoice->payments->sum('amount');
                                            $balance = $invoice->total - $paidAmount;
                                        @endphp
                                        <tr>
                                            <td>{{ $invoice->id }}</td>
                                            <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
                                            <td>{{ $invoice->client->name }}</td>
                                            <td>${{ number_format($invoice->total, 2) }}</td>
                                            <td>${{ number_format($paidAmount, 2) }}</td>
                                            <td class="{{ $balance > 0 ? 'text-danger fw-bold' : '' }}">
                                                ${{ number_format($balance, 2) }}
                                            </td>
                                            <td>{{ ucfirst($invoice->status) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Activate tab from URL hash if present
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash;
        if (hash) {
            const tab = new bootstrap.Tab(document.querySelector(`[data-bs-target="${hash}"]`));
            tab.show();
        }
    });
</script>
<x-footer/>