<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (request()->has('empty')) {
            $users = [];
        } else {
            $users = [
                'Franco', 'German', 'Yismeida', 'Carlos'
            ];
        }

        return view('users')
            ->with('users', $users)
            ->with('title', 'Listado de usuarios');
    }

    public function show($id)
    {
        return view('user', [
            'title' => 'Mostrar un usuario',
            'id' => $id
        ]);
    }

    public function create()
    {
        return view('create', [
            'title' => 'Crear nuevo usuario'
        ]);
    }
}
