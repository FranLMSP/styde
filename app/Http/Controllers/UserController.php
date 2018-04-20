<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index')
            ->with('users', $users)
            ->with('title', 'Listado de usuarios');
    }

    public function show(User $user)
    {
        return view('users.show', [
            'title' => 'Mostrar un usuario',
            'user' => $user
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store()
    {

        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ], [
            'name.required' => 'El campo nombre es obligatorio',

            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email no es válido',
            'email.unique' => 'El email ya está en uso',

            'password.required' => 'El campo password es obligatorio',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres'
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return redirect()->route('users');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }
}
