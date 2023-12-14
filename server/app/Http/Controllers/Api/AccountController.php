<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\Status;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{

    public function cancelAppointment(Appointment $appointment)
    {
        $appointment->update(['appointment_status_id' => AppointmentStatus::CANCELED]);
        return response()->json(['message' => 'Marcação cancelada com sucesso']);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update(['name' => $request->name, 'email' => $request->email]);

        return response()->json(['name' => $user->name, 'email' => $user->email]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function password(Request $request)
    {
        $user = auth()->user();

        // Validate request data
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'A palavra-passe atual fornecida está incorreta.',
                'errors' => ['current_password' => ['Palavra-passe inválida.']],
            ], 422);
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Sua palavra-passe foi alterada com sucesso.',
        ]);
    }





    public function donations(Request $request)
    {
        $user = auth()->user();

        return response()->json($user->donations()->with('bloodType')->get());
    }

    public function appointments(Request $request)
    {
        $user = auth()->user();

        return response()->json($user->appointments()->with(['branch', 'status'])->get());
    }
}
