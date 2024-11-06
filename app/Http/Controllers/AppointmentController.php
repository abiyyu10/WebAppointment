<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;


class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return view('appointments.index', compact('appointments'));
    }


    public function create()
    {
        return view('appointments.create');
    }


    public function store(Request $request)
    {

        $data = $request->validate([
            'patient_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'consultation_area' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'notes' => 'required|string',
        ]);

        $newAppointment = Appointment::create($data);
        return redirect()->route('appointments.index');
    }

    public function edit(Appointment $appointment){
        return view('appointments.edit', ['appointment' => $appointment]);
    }

    public function update(Appointment $appointment, Request $request)
    {

        $data = $request->validate([
            'patient_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'consultation_area' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'notes' => 'required|string',
        ]);

        $appointment->update($data);
        return redirect()->route('appointments.index')->with('success', 'Yosh....Datamu saget diupload');
    }

    public function destroy($id)
{
    $appointment = Appointment::findOrFail($id);

    $appointment->delete();

    return redirect()->route('appointments.index')->with('success', 'Datamu sampun dipucal');
}

}

