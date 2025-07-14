<x-header />

<body class="login-page">
    <main class="float-start w-100">

        <x-sidebar />
        <div class="container">
            <div class="invoice-card col-lg-8 col-xl-8  mx-auto">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="headingh1 m-0"> Invoice </h2>
                        <p><span class="invoice-label">Invoice number:</span> <span
                                class="invoice-num">ID{{ $invoice->id }}</span></p>
                    </div>
                    <img src="{{ asset('images/logo-w.png') }}" alt="logo">
                </div>

                <div class="d-flex justify-content-between align-items-start w-75 mt-4">
                    <div>
                        <p class="invoice-num">Pet & Owner Info:</p>
                        <p><span class="invoice-label">Pet's Name:</span> <span
                                class="invoice-num">{{ $invoice->appointment->pet->name ?? 'N/A' }}</span></p>
                        <p><span class="invoice-label">Owner's Fullname:</span> <span
                                class="invoice-num">{{ $invoice->client_name }}</span></p>
                        <p><span class="invoice-label">Owner's Email:</span> <span
                                class="invoice-num">{{ $invoice->client_email }}</span></p>
                        <p><span class="invoice-label">Owner's Phone:</span> <span
                                class="invoice-num">{{ $invoice->client_phone }}</span></p>
                    </div>
                    <div>
                        <p class="invoice-num">Appointment Details:</p>
                        <p><span class="invoice-label">Appointment Date:</span> <span
                                class="invoice-num">{{ $invoice->appointment_date->format('d M Y') }}</span></p>
                        <p><span class="invoice-label">Due Date:</span> <span
                                class="invoice-num">{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</span>
                        </p>
                    </div>
                </div>

                <div class="col-lg-12 mt-4">
                    <div class="invoice-li py-0 w-100">
                        <div class="taosy01 thead-bt w-100">
                            <table class="table table-striped invoice-table-border nowrap">
                                <thead>
                                    <tr>
                                        <th>Services Description</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody-invoice">
                                    @foreach($invoice->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->unit_price, 2) }}</td>
                                        <td>${{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="sub-border">
                    <div class="border-btm">
                        <p class="d-flex justify-content-between">
                            <span class="invoice-label">Sub-total:</span>
                            <span class="invoice-num">${{ number_format($invoice->total, 2) }}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <span class="invoice-label">Tax:</span>
                            <span class="invoice-num">${{ number_format($invoice->tax, 2) }}</span>
                        </p>
                        <p class="d-flex justify-content-between">
                            <span class="invoice-label">Discount:</span>
                            <span class="invoice-num">${{ number_format($invoice->discount, 2) }}</span>
                        </p>
                    </div>
                    <p class="d-flex justify-content-between pad">
                        <span class="invoice-label">Total:</span>
                        <span
                            class="invoice-num">${{ number_format($invoice->total + $invoice->tax - $invoice->discount, 2) }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="modal-footer invoice-footer">
            <button type="button" class="btn btn-secondary invoice-cancel-btn">Cancel</button>
            <button type="button" class="btn btn-primary invoice-btn d-flex">
                <img src="./images/send.svg" alt="" class="me-2">Send Invoice</button>
        </div>
    </main>
    <script>
    $(document).ready(function() {
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye-slash fa-eye");
            input = $(this).parent().find("input");
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    });
    </script>
    <x-footer />
</body>

</html>