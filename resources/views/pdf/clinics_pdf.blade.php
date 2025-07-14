<!DOCTYPE html>
<html>
<head>
    <title>Clinics Export</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .title { text-align: center; margin-bottom: 20px; }
        @media print {
            body { padding: 20px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="title">
        <h1>Clinics List</h1>
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
        <p class="no-print">Note: Use your browser's "Print to PDF" function to save as PDF</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clinics as $clinic)
            <tr>
                <td>{{ $clinic->name }}</td>
                <td>{{ $clinic->address }}</td>
                <td>{{ $clinic->phone }}</td>
                <td>{{ $clinic->email }}</td>
                <td>{{ $clinic->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print/Save as PDF
        </button>
    </div>
</body>
</html>