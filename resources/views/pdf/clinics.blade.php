<!DOCTYPE html>
<html>
<head>
    <title>Clinics List</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { color: #333; text-align: center; }
    </style>
</head>
<body>
    <h1>Clinics List</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clinics as $clinic)
            <tr>
                <td>{{ $clinic->name }}</td>
                <td>{{ $clinic->address }}</td>
                <td>{{ $clinic->phone }}</td>
                <td>{{ $clinic->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>