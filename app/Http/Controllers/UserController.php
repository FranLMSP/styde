<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = [
            'Franco',
            'German',
            'Yismeida',
            'Carlos',
            '<script>alert("test")</script>'
        ];

        return view('users')
            ->with('users', $users)
            ->with('title', 'Listado de usuarios');
    }

    public function show($id)
    {
        return "Mostrando detalle del usuario: {$id}";
    }

    public function create()
    {
        return 'Crear nuevo usuario';
    }
}
