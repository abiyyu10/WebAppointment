<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create New Appointment</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1a1a1a;
            color: #ffffff;
            line-height: 1.6;
            padding: 30px;
        }

        h1 {
            color: #2f7cbb;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5em;
            text-shadow: 0 0 10px rgba(25, 143, 186, 0.3);
        }

        .error-container {
            background-color: #2d1f1f;
            border-left: 4px solid #ff4444;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .error-container ul {
            list-style-type: none;
        }

        .error-container li {
            color: #ff4444;
            margin-bottom: 5px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #2d2d2d;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #109feb;
            font-weight: 500;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            background-color: #1a1a1a;
            border: 1px solid #404040;
            color: #ffffff;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #235997;
            box-shadow: 0 0 5px rgba(91, 158, 234, 0.5);
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #176187;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #166ee0;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 169, 236, 0.3);
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

        form {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>

    <h1>Create New Appointment</h1>

    @if ($errors->any())
        <div class="error-container">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('appointments.store') }}" id="appointmentForm">
        @csrf

        <div class="form-group">
            <label for="patient_name">Patient Name</label>
            <input type="text" name="patient_name" id="patient_name" required
                   placeholder="Enter patient name" value="{{ old('patient_name') }}">
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" required value="{{ old('date') }}">
        </div>

        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" name="time" id="time" required value="{{ old('time') }}">
        </div>

        <div class="form-group">
            <label for="consultation_area">Consultation Area</label>
            <input type="text" name="consultation_area" id="consultation_area"
                   required placeholder="Enter consultation area" value="{{ old('consultation_area') }}">
        </div>

        <div class="form-group">
            <label for="purpose">Purpose</label>
            <input type="text" name="purpose" id="purpose" required
                   placeholder="Enter purpose" value="{{ old('purpose') }}">
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" required
                      placeholder="Enter additional notes">{{ old('notes') }}</textarea>
        </div>

        <div class="form-group">
            <button type="submit">Create Appointment</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date');
    const form = document.getElementById('appointmentForm');
    const inputs = document.querySelectorAll('input, textarea');
    const timeInput = document.getElementById('time');
    const notesTextarea = document.getElementById('notes');
    const submitButton = document.querySelector('button[type="submit"]');
    const patientNameInput = document.getElementById('patient_name');

    dateInput.min = new Date().toISOString().split('T')[0];

    form.addEventListener('submit', handleFormSubmit);

    inputs.forEach(input => {
        input.addEventListener('focus', handleInputFocus);
        input.addEventListener('blur', handleInputBlur);
        input.addEventListener('input', handleInputChange);
    });

    timeInput.addEventListener('change', validateTimeInput);

    notesTextarea.addEventListener('input', updateCharacterCounter);

    submitButton.addEventListener('mouseover', () => submitButton.style.transform = 'translateY(-2px) scale(1.02)');

    submitButton.addEventListener('mouseout', () => submitButton.style.transform = 'translateY(0) scale(1)');

    addCustomStyling();
    smoothScrollToErrors();

    patientNameInput.addEventListener('input', () => patientNameInput.value = patientNameInput.value.replace(/[0-9]/g, ''));

    document.querySelectorAll('.form-group').forEach(group => group.style.transition = 'all 0.3s ease');

    document.addEventListener('contextmenu', handleContextMenu);

    setupUnsavedChangesWarning();
});

function handleFormSubmit(e) {
    let isValid = true;
    this.querySelectorAll('input, textarea').forEach(input => {
        if (input.value.trim() === '') {
            isValid = false;
            input.style.borderColor = '#ff4444';
            showError(input);
        } else {
            input.style.borderColor = '#404040';
        }
    });

    if (!isValid) {
        e.preventDefault();
    } else if (this.checkValidity()) {
        const button = this.querySelector('button[type="submit"]');
        button.disabled = true;
        button.innerHTML = '<span class="loading">Creating appointment...</span>';
        button.style.backgroundColor = '#008f5a';
    }
}

function handleInputFocus() {
    this.parentElement.style.transform = 'translateX(10px)';
}

function handleInputBlur() {
    this.parentElement.style.transform = 'translateX(0)';
}

function handleInputChange() {
    if (this.value.trim() !== '') {
        this.style.borderColor = '#404040';
    }
}

function showError(input) {
    const formGroup = input.parentElement;
    if (!formGroup.querySelector('.error-message')) {
        const error = document.createElement('div');
        error.className = 'error-message';
        error.style.cssText = 'color: #ff4444; font-size: 12px; margin-top: 5px; animation: fadeIn 0.3s ease-in;';
        error.textContent = 'This field is required';
        formGroup.appendChild(error);
    }
}

function validateTimeInput() {
    const [hours] = this.value.split(':');
    if (hours < 8 || hours >= 17) {
        alert('Please select a time between 8:00 AM and 5:00 PM');
        this.value = '';
    }
}

function updateCharacterCounter() {
    const maxLength = 500;
    const remainingChars = maxLength - this.value.length;
    let counterDiv = this.parentElement.querySelector('.char-counter');

    if (!counterDiv) {
        counterDiv = document.createElement('div');
        counterDiv.className = 'char-counter';
        counterDiv.style.cssText = 'color: #666; font-size: 12px; margin-top: 5px;';
        this.parentElement.appendChild(counterDiv);
    }

    counterDiv.textContent = `${remainingChars} characters remaining`;
    counterDiv.style.color = remainingChars < 50 ? '#ff9900' : '#666';
}

function addCustomStyling() {
    const style = document.createElement('style');
    style.textContent = `
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #1a1a1a inset !important;
            -webkit-text-fill-color: #ffffff !important;
        }
    `;
    document.head.appendChild(style);
}

function smoothScrollToErrors() {
    const errorContainer = document.querySelector('.error-container');
    if (errorContainer) {
        errorContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function handleContextMenu(e) {
    if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
        e.preventDefault();
    }
}

function setupUnsavedChangesWarning() {
    let formChanged = false;
    document.querySelectorAll('input, textarea').forEach(input => {
        input.addEventListener('input', () => formChanged = true);
    });

    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
}
    </script>
</body>
</html>
