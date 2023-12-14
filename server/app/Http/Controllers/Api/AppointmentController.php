<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentStatus;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Branch $branch)
    {



        $appointments =
            $branch->appointments()->with(['user'])->get();
        return view('appointments.index', ['appointments' => $appointments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Branch $branch)
    {
        $request->validate([
            'date' => ['required', 'date'],
            'time' => ['required', 'regex:/^(?:[01]\d|2[0-3]):[0-5]\d$/']
        ]);


        Appointment::create(['user_id' => auth()->id(), 'branch_id' => $branch->id, 'date' => $request->date, 'time' => $request->time, 'appointment_status_id' => AppointmentStatus::SCHEDULED],);

        return response()->json(['message' => 'Marcação criado com sucesso.', 'type' => 'success'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $branch)
    {
        return view('appointments.edit', ['branch' => $branch]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $branch)
    {
        $request->validate([
            'image' => ['sometimes', File::image()->extensions(['png', 'jpg', 'jpeg'])],
            'name' => ['required', 'string'],
            'address' => ['required', 'string']
        ]);

        $data = $request->only('name', 'address');


        $branch->update($data);

        return redirect()->route('appointments.index')->with('status', ['message' => 'Marcação atualizado com sucesso.', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $branch)
    {
        $branch->deleteOrFail();
        return redirect()->back()->with('status', ['message' => 'Marcação excluido com sucesso.', 'type' => 'success']);
    }
}
