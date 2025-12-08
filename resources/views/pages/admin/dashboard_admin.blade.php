<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Municipality Dashboard</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* Basic CSS based on your original file structure */
    body {
        font-family: Arial, sans-serif;
        background: #f2f2f2;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
    }

    .dashboard {
        width: 90%;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }

    th {
        background: #4CAF50;
        color: white;
    }

    select {
        padding: 6px;
        border-radius: 5px;
    }
</style>
</head>

<body>

<h2>Municipality Dashboard</h2>

<div class="dashboard">
    <table>
        <thead>
            <tr>
                <th>Type</th> <th>ID</th> 
                <th>Description</th>
                <th>Department</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody id="dataTable">
            {{-- Loop through the combined data passed from the Controller --}}
            @foreach($dashboardData as $item)
            <tr>
                <td>{{ $item->type }}</td>
                {{-- Format the ID based on the type (C- for Complaint, S- for Service Request) --}}
                <td>{{ $item->type === 'Complaint' ? 'C-' . $item->id : 'S-' . $item->id }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->department }}</td>
                <td>
                    {{-- The onchange event calls the JavaScript function with the item's ID, Type, and the new Status value --}}
                    <select onchange="updateStatus('{{ $item->id }}', '{{ $item->type }}', this.value)">
                        {{-- Loop through the status options defined for this item in the controller --}}
                        @foreach($item->statusOptions as $option)
                            <option 
                                value="{{ $option }}" 
                                {{ $option === $item->status ? 'selected' : '' }}
                            >
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($dashboardData->isEmpty())
        <p style="text-align: center; margin-top: 20px;">No records found.</p>
    @endif
</div>

<script>
    // Get the CSRF token from the meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function updateStatus(id, type, newStatus) {
        // Send an AJAX (fetch) request to the Laravel backend
        fetch("{{ route('admin.update.status') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // Laravel requires the CSRF token for all POST requests
                'X-CSRF-TOKEN': csrfToken 
            },
            // Send the data as JSON
            body: JSON.stringify({
                id: id,
                type: type, // 'Complaint' or 'Service Request'
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Status for ${type} #${id} successfully updated to: ${newStatus}`);
            } else {
                alert('Failed to update status.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while communicating with the server.');
        });
    }
</script>

</body>
</html>