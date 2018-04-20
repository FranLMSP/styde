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

    public function show($id)
    {
        return view('users.show', [
            'title' => 'Mostrar un usuario',
            'id' => $id
        ]);
    }

    public function create()
    {
        return view('users.create', [
            'title' => 'Crear nuevo usuario'
        ]);
    }
}
