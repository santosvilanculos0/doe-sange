<?php

namespace App\Http\Controllers;

use App\Models\AppointmentStatus;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $branches = Branch::withCount(['appointments' => function ($query) {
            $query->where('appointment_status_id', AppointmentStatus::SCHEDULED);
        }, 'donations'])->get();
        return view('branches.index', ['branches' => $branches]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', File::image()->extensions(['png', 'jpg', 'jpeg'])],
            'name' => ['required', 'string'],
            'address' => ['required', 'string']
        ]);

        $path = $request->file('image')->store(date('Y-m-d'), ['disk' => 'public']);
        Branch::create([
            'image' => $path,
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('branches.index')->with('status', ['message' => 'Sucursal criado com sucesso.', 'type' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return view('branches.edit', ['branch' => $branch]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'image' => ['sometimes', File::image()->extensions(['png', 'jpg', 'jpeg'])],
            'name' => ['required', 'string'],
            'address' => ['required', 'string']
        ]);

        $data = $request->only('name', 'address');

        if ($request->hasFile('image')) {

            if (Storage::exists($branch->image)) {
                Storage::delete($branch->image);
            }

            $path = $request->file('image')->store(date('Y-m-d'), ['disk' => 'public']);
            $data = array_merge($data, ['image' => $path]);
        }

        $branch->update($data);

        return redirect()->route('branches.index')->with('status', ['message' => 'Sucursal atualizado com sucesso.', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->deleteOrFail();
        return redirect()->back()->with('status', ['message' => 'Sucursal excluido com sucesso.', 'type' => 'success']);
    }
}
