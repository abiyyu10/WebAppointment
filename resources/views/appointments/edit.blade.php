<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Appointment</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
         font-family: 'Arial', sans-serif;
         background-color: #1a1a1a;
         color: #e0e0e0;
         line-height: 1.6;
         padding: 30px;
         display: flex;
         flex-direction: column;
         align-items: center;
         min-height: 100vh;

        }

        h1 {
            color: #4da6ff;
            margin-bottom: 30px;
            font-size: 2.5em;
            text-shadow: 0 0 10px rgba(77, 166, 255, 0.3);
        }

        .error-list {
            background-color: #2d1f1f;
            border-left: 4px solid #ff4d4d;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            list-style-type: none;
        }

        .error-list li {
            color: #ff4d4d;
            margin-bottom: 5px;
        }

        form {
          width: 100%;
          max-width: 600px;
          background-color: #2a2a2a;
          padding: 30px;
          border-radius: 10px;
          box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #4da6ff;
            font-weight: 500;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            background-color: #1a1a1a;
            border: 1px solid #444444;
            color: #ffffff;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #4da6ff;
            box-shadow: 0 0 5px rgba(77, 166, 255, 0.5);
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #00bfff;
            color: #1a1a1a;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 0 15px rgba(0, 191, 255, 0.3);
        }

        button:hover {
            background-color: #0099ff;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 191, 255, 0.5);
        }

        input[type="date"], input[type="time"] {
            color-scheme: dark;
        }

        ::placeholder {
            color: #666;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-group {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .container {
          width: 100%;
          max-width: 800px;
          display: flex;
          flex-direction: column;
          align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Edit Appointment</h1>
    @if ($errors->any())
        <ul class="error-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('appointment.update', $appointment->id) }}" method="POST" id="editForm">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="patient_name">Patient Name</label>
            <input type="text" name="patient_name" id="patient_name"
                   placeholder="Enter patient name"
                   value="{{ old('patient_name', $appointment->patient_name) }}" required />
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date"
                   value="{{ old('date', $appointment->date) }}" required />
        </div>

        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" name="time" id="time"
                   value="{{ old('time', $appointment->time) }}" required />
        </div>

        <div class="form-group">
            <label for="consultation_area">Consultation Area</label>
            <input type="text" name="consultation_area" id="consultation_area"
                   placeholder="Enter consultation area"
                   value="{{ old('consultation_area', $appointment->consultation_area) }}" required />
        </div>

        <div class="form-group">
            <label for="purpose">Purpose</label>
            <input type="text" name="purpose" id="purpose"
                   placeholder="Enter purpose"
                   value="{{ old('purpose', $appointment->purpose) }}" required />
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes"
                      placeholder="Enter any additional notes" required>{{ old('notes', $appointment->notes) }}</textarea>
        </div>

        <div class="form-group">
            <button type="submit">Update Appointment</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date');
    const today = new Date().toISOString().split('T')[0];
    dateInput.min = today;

    const form = document.getElementById('editForm');
    const inputs = form.querySelectorAll('input, textarea');

    inputs.forEach(input => {
        input.addEventListener('focus', () => input.parentElement.style.transform = 'translateX(10px)');
        input.addEventListener('blur', () => input.parentElement.style.transform = 'translateX(0)');
        input.addEventListener('input', () => {
            input.style.borderColor = input.value.trim() === '' ? '#ff4d4d' : '#444444';
        });
    });

    const timeInput = document.getElementById('time');
    timeInput.addEventListener('change', function() {
        const [hours] = this.value.split(':');
        if (hours < 8 || hours >= 17) {
            alert('Please select a time between 8:00 AM and 5:00 PM');
            this.value = '';
        }
    });

    form.addEventListener('submit', function(e) {
        let isValid = true;
        inputs.forEach(input => {
            if (input.value.trim() === '') {
                isValid = false;
                input.style.borderColor = '#ff4d4d';
                input.style.animation = 'shake 0.5s ease';
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields');
        } else {
            const button = this.querySelector('button[type="submit"]');
            button.innerHTML = 'Updating...';
            button.style.backgroundColor = '#0077cc';
            button.disabled = true;
        }
    });

    const notesTextarea = document.getElementById('notes');
    const maxLength = 500;
    notesTextarea.addEventListener('input', function() {
        const remaining = maxLength - this.value.length;
        let counter = this.parentElement.querySelector('.char-counter');
        if (!counter) {
            counter = document.createElement('div');
            counter.className = 'char-counter';
            counter.style.cssText = 'color: #666; font-size: 12px; margin-top: 5px;';
            this.parentElement.appendChild(counter);
        }
        counter.textContent = `${remaining} characters remaining`;
        counter.style.color = remaining < 50 ? '#ff9900' : '#666';
    });

    const formGroups = document.querySelectorAll('.form-group');
    formGroups.forEach(group => {
        group.addEventListener('mouseover', () => group.style.transform = 'translateX(5px)');
        group.addEventListener('mouseout', () => group.style.transform = 'translateX(0)');
    });

    let formChanged = false;
    inputs.forEach(input => input.addEventListener('input', () => formChanged = true));
    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        @keyframes glow {
            0% { box-shadow: 0 0 5px rgba(0, 191, 255, 0.5); }
            50% { box-shadow: 0 0 20px rgba(0, 191, 255, 0.8); }
            100% { box-shadow: 0 0 5px rgba(0, 191, 255, 0.5); }
        }
        button:focus { animation: glow 1.5s infinite; }
        .form-group { transition: all 0.3s ease; }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #1a1a1a inset !important;
            -webkit-text-fill-color: #ffffff !important;
        }
    `;
    document.head.appendChild(style);

    const errorList = document.querySelector('.error-list');
    if (errorList) {
        errorList.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    const patientNameInput = document.getElementById('patient_name');
    patientNameInput.addEventListener('input', function() {
        this.value = this.value.replace(/[0-9]/g, '');
    });

    const addTooltip = (element, message) => {
        element.setAttribute('title', message);
        element.style.position = 'relative';

        const createTooltip = () => {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = message;
            tooltip.style.cssText = `
                position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%);
                background-color: #333; padding: 5px 10px; border-radius: 5px;
                font-size: 12px; z-index: 1000;
            `;
            element.appendChild(tooltip);
        };

        element.addEventListener('mouseover', createTooltip);
        element.addEventListener('mouseout', () => {
            const tooltip = element.querySelector('.tooltip');
            if (tooltip) tooltip.remove();
        });
    };

    addTooltip(document.getElementById('time'), 'Select time between 8:00 AM and 5:00 PM');
    addTooltip(document.getElementById('date'), 'Select a date from today onwards');
});
    </script>
</body>
</html>
