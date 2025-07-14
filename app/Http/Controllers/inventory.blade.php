<x-header />
<style>
#inventoryTable_paginate {
    display: none !important;
}
</style>

<body class="all-bg">
    <main class="float-start w-100">
        <x-sidebar />
        <section class="left-sections-right float-end">
            <div class="row p-0 m-0">
                <div class="col-lg-12">
                    <div class="row p-0 m-0">
                        <div class="col-lg-12">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h2 class="headingh1 m-0"> Inventory </h2>
                                <!-- Button to trigger modal -->
                                <button type="button" class="patient-btn checkin" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18"
                                        fill="rgba(255,255,255,1)">
                                        <path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path>
                                    </svg>
                                    Add New Inventory
                                </button>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="comon-li pt-0 d-inline-block w-100">
                            <div class="taosy01 w-100 thead-bt">
                                <table id="inventoryTable" class="table table-striped nowrap">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Batch #</th>
                                            <th>Qty Available</th>
                                            <th>Expiry Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody-pad">
                                        @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->batch_number ?? 'N/A' }}</td>
                                            <td>{{ $product->quantity_in_stock }} {{ $product->dosage_form ?? 'units' }}
                                            </td>
                                            <td>{{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('d M Y') : 'N/A' }}
                                            </td>
                                            <td>
                                                @php
                                                $status = 'Available';
                                                $statusClass = 'paid';

                                                if($product->quantity_in_stock <= 0) { $status='Out of Stock' ;
                                                    $statusClass='paid-o' ; } elseif($product->expiry_date &&
                                                    \Carbon\Carbon::parse($product->expiry_date)->isPast()) {
                                                    $status = 'Expired';
                                                    $statusClass = 'paid-o';
                                                    } elseif($product->expiry_date &&
                                                    \Carbon\Carbon::parse($product->expiry_date)->diffInDays(now()) <=
                                                        30) { $status='Near Expiration' ; $statusClass='paid-p' ; }
                                                        elseif($product->quantity_in_stock <= ($product->
                                                            reorder_threshold ?? 5)) {
                                                            $status = 'Low Stock';
                                                            $statusClass = 'paid-p';
                                                            }
                                                            @endphp
                                                            <p
                                                                class="bill-sts @if($statusClass !== 'paid') bill-sts-{{ substr($statusClass, -1) }} @endif">
                                                                <span class="{{ $statusClass }}">{{ $status }}</span>
                                                            </p>
                                            </td>
                                            <td>
                                                <div
                                                    class="my-0 d-flex align-items-center justify-content-between pe-3">
                                                    <form action="{{ route('inventory.destroy', $product->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-delete-edit"
                                                            onclick="return confirm('Are you sure you want to delete this product?')">
                                                            <img src="{{ asset('images/idelete.svg') }}" alt="Delete">
                                                        </button>
                                                    </form>

                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="btn-delete-edit">
                                                        <img src="{{ asset('images/iedit.svg') }}" alt="Edit">
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex sp-padding-btn align-items-center justify-content-between w-100">
                                    <button type="button" class="btn btn-previes"> Previous </button>
                                    <p class="pater-inventory dt-info-inven"> Page 1 of 2 </p>
                                    <button type="button" class="btn btn-next"> Next </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="recenttyle-activety comon-box w-100">
                            <h5> Notifications </h5>
                            <div class="activety-div d-block w-100">
                                <ul class="position-relative">
                                    @forelse($notifications as $notify)
                                    <li class="position-relative">
                                        <h6>
                                            {{ $notify['name'] }} (Batch#{{ $notify['batch'] }}) is
                                            <span style="text-transform: capitalize;">{{ $notify['status'] }}</span>:
                                            only {{ $notify['quantity'] }} units left
                                        </h6>
                                        <span class="d-block w-100">{{ $notify['time'] }}</span>
                                    </li>
                                    @empty
                                    <li class="position-relative">
                                        <h6>No notifications available</h6>
                                        <span class="d-block w-100">{{ now()->diffForHumans() }}</span>
                                    </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- appoinment modal -->

    <div class="modal fade crm-modalsd01-forms" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered cm-widths modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('inventory.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Inventory</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="crm-form-modal">
                            <div class="row gy-3">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" name="product_name" class="form-control"
                                            placeholder="Product Name" required />
                                    </div>
                                </div>

                                <div class="col-lg-6 cm-form">
                                    <div class="form-group">
                                        <label class="form-label">Quantity Available</label>
                                        <input type="number" name="quantity_available" class="form-control"
                                            placeholder="Quantity" min="1" required />
                                    </div>
                                </div>

                                <div class="col-lg-6 cm-form">
                                    <div class="form-group">
                                        <label class="form-label">Expire Date</label>
                                        <input type="date" name="expire_date" class="form-control" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pb-0 pe-0 mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add New Inventory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <x-footer />
</body>

</html>