<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\BloodType;
use App\Models\Branch;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DonationController extends Controller
{

    public function index(Branch $branch)

    {
        $donations = $branch->donations()->get();

        return view('donations.index', ['donations' => $donations]);
    }

    public function create(Appointment $appointment)

    {
        $appointmentWithUser = Appointment::with('user')->find($appointment->id);
        $blood_types = BloodType::all();

        return view('donations.create', ['appointment' => $appointmentWithUser, 'blood_types' => $blood_types]);
    }


    public function store(Request $request, Appointment $appointment)
    {
        $request->validate([
            'volume' => ['required', 'decimal:0,4'],
            'hemoglobin' => ['required', 'decimal:0,4'],
            'blood_pressure' => ['required', 'decimal:0,4'],
            'blood_type_id' => ['required', 'integer', Rule::exists('blood_types', 'id')]
        ]);

        $appointment->update(['appointment_status_id' => AppointmentStatus::COMPLETED]);

        Donation::create([
            'appointment_id' => $appointment->id,
            'blood_type_id' => $request->blood_type_id,
            'branch_id' => $appointment->branch_id,
            'volume' => $request->volume,
            'hemoglobin' => $request->hemoglobin,
            'blood_pressure' => $request->blood_pressure,
            'blood_type_id' => $request->blood_type_id,
        ]);

        return redirect()->route('branches.appointments.index', ['branch' => $appointment->branch->id])->with('status', ['message' => 'Doação registada com sucesso.', 'type' => 'success']);
    }

    public function destroy(Branch $branch, Donation $donation)
    {
        $donation->deleteOrFail();
        return redirect()->back()->with('status', ['message' => 'Doação excluido com sucesso.', 'type' => 'success']);
    }
}
