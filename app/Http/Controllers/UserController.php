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
        $user = User::find($id);
        $title = 'Mostrar un usuario';

        if (!$user) {
            return response()->view('errors.404', [
                'title' => $title
            ], 404);
        }

        return view('users.show', [
            'title' => $title,
            'user' => $user
        ]);
    }

    public function create()
    {
        return view('users.create', [
            'title' => 'Crear nuevo usuario'
        ]);
    }
}
