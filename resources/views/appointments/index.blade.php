<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #1a1a1a;
            color: #e0e0e0;
        }

        h1 {
            color: #4da6ff;
            text-align: left;
            margin-bottom: 30px;
        }

        .success-message {
            background-color: #2d4a22;
            border: 1px solid #3d6a2e;
            color: #a3ffb2;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            animation: fadeOut 5s forwards;
        }

        .create-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1a75ff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: background-color 0.3s;
        }

        .create-btn:hover {
            background-color: #0056b3;
        }

        .table-container {
            background-color: #2a2a2a;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #2a2a2a;
        }

        th {
            background-color: #333333;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #444444;
            color: #4da6ff;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #444444;
        }

        tr:hover {
            background-color: #333333;
        }

        .edit-btn {
            color: #4da6ff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 3px;
            transition: background-color 0.3s;
        }

        .edit-btn:hover {
            background-color: #4da6ff;
            color: #1a1a1a;
        }

        .delete-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-btn:hover {
            background-color: #cc0000;
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            70% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>
</head>
<body>
    <h1>Appointments</h1>
    @if (session()->has('success'))
        <div class="success-message">
            <p style="margin: 0;">{{ session('success') }}</p>
        </div>
    @endif

    <div>
        <a href="{{ route('appointments.create') }}" class="create-btn">Create New Appointment</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Consultation Area</th>
                    <th>Purpose</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->patient_name }}</td>
                        <td>{{ date('d M Y', strtotime($appointment->date)) }}</td>
                        <td>{{ date('H:i', strtotime($appointment->time)) }}</td>
                        <td>{{ $appointment->consultation_area }}</td>
                        <td>{{ $appointment->purpose }}</td>
                        <td>{{ $appointment->notes ?? '-' }}</td>
                        <td>
                            <a href="{{ route('appointments.edit', $appointment) }}" class="edit-btn">Edit</a>
                            <form action="{{ route('appointments.destroy', $appointment) }}"
                                  method="POST"
                                  style="display: inline-block;"
                                  onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 20px;">No appointments found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this appointment?');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 500);
                }, 4500);
            }

            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseover', function() {
                    this.style.backgroundColor = '#333333';
                    this.style.transition = 'background-color 0.3s';
                });
                row.addEventListener('mouseout', function() {
                    this.style.backgroundColor = '';
                });
            });

            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(btn => {
                btn.addEventListener('mouseover', function() {
                    this.style.boxShadow = '0 0 5px #4da6ff';
                });
                btn.addEventListener('mouseout', function() {
                    this.style.boxShadow = 'none';
                });
            });

            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(btn => {
                btn.addEventListener('mouseover', function() {
                    this.style.boxShadow = '0 0 5px #ff4d4d';
                });
                btn.addEventListener('mouseout', function() {
                    this.style.boxShadow = 'none';
                });
            });
        });
    </script>
</body>
</html>
