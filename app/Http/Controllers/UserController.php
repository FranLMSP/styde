<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Validation\Rule;

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

    public function update(User $user)
    {


        $data = request()->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
             //'required|email|unique:users,email,'.$user->id, //this method is valid too
            'password' => 'nullable|min:6'
        ], [
            'name.required' => 'El campo nombre es obligatorio',

            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email no es válido',
            'email.unique' => 'El email ya está en uso',
            
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',

        ]);

        if ( $data['password'] ) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }


        $user->update($data);

        return redirect()->route('users.show', ['user' => $user->id]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users');
    }
}
