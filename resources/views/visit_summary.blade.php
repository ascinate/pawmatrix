<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Visit Summary</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        h2 { color: #424CA8; }
        .section { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Visit Summary for {{ $pet->name }}</h2>
    <p>Hello {{ $ownerName }},</p>
    <p>Here is your visit summary:</p>

    @if(isset($data['soap']))
        <div class="section">
            <h3>SOAP Notes</h3>
            <p><strong>Subjective:</strong> {{ $data['soap']->subjective }}</p>
            <p><strong>Objective:</strong> {{ $data['soap']->objective }}</p>
            <p><strong>Assessment:</strong> {{ $data['soap']->assessment }}</p>
            <p><strong>Plan:</strong> {{ $data['soap']->plan }}</p>
        </div>
    @endif

    @if(isset($data['invoice']))
        <div class="section">
            <h3>Invoice Summary</h3>
            @foreach($data['invoice']->invoiceItems as $item)
                <p>- {{ $item->product->name }}: ₹{{ $item->unit_price }} x {{ $item->quantity }} = ₹{{ $item->unit_price * $item->quantity }}</p>
            @endforeach
            <p><strong>Total:</strong> ₹{{ $data['invoice']->total }}</p>
        </div>
    @endif

    @if(isset($data['medications']))
        <div class="section">
            <h3>Medication Prescription</h3>
            @foreach($data['medications'] as $med)
                <p>- {{ $med->name }} ({{ $med->dosage_form }}) - Qty: {{ $med->quantity_in_stock }}, Refills: {{ $med->refills }}</p>
            @endforeach
        </div>
    @endif

    @if(isset($data['discharge']))
        <div class="section">
            <h3>Discharge Notes</h3>
            <p>{{ $data['discharge']->note }}</p>
        </div>
    @endif

    <hr>
    <p><strong>Message from Clinic:</strong></p>
    <p>{{ $message }}</p>
</body>
</html>
