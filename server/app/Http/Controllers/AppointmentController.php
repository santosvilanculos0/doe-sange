<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Branch $branch)
    {
        $appointments = $branch->appointments()->with('user')->where('appointment_status_id', AppointmentStatus::SCHEDULED)->get();

        return view('appointments.index', ['appointments' => $appointments]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch, Appointment $appointment)
    {
        $appointment->deleteOrFail();
        return redirect()->back()->with('status', ['message' => 'Marcação excluido com sucesso.', 'type' => 'success']);
    }
}
