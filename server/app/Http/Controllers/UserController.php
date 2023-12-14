<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Carbon::setLocale('pt');

        $users = User::all();

        $formatted_users = $users->map(function ($user) {
            $user->formatted_created_at = Carbon::parse($user->created_at)
                ->diffForHumans();
            $user->formatted_updated_at = Carbon::parse($user->updated_at)
                ->diffForHumans();
            return $user;
        });

        return view('users.index', ['users' => $formatted_users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('status', ['message' => 'Utilizador criado com sucesso.', 'type' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'is_admin' => ['sometimes', 'accepted'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin')
        ]);

        return redirect()->route('users.index')->with('status', ['message' => 'Utilizador atualizado com sucesso.', 'type' => 'success']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editPassword(User $user): View
    {
        return view('users.edit-password', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('status', ['message' => 'Palavra-passe atualizada com sucesso.', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->deleteOrFail();
        return redirect()->back()->with('status', ['message' => 'Utilizador excluido com sucesso.', 'type' => 'success']);
    }
}
