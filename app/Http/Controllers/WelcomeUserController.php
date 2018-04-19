<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeUserController extends Controller
{
    public function __invoke($name, $nickname = NULL) {
		
		$name = ucfirst($name);

		return view('welcomeUser', [
			'name' => $name,
			'nickname' => $nickname
		]);
    }
}
