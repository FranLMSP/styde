@extends('layouts.index')

@section('content')

	<h1>Crear nuevo usuario</h1>


	<form method="POST" action="{{ route('users.store') }}">
		{!! csrf_field() !!}

		<label for="name">Nombre:</label>
		<input type="text" name="name" id="name" placeholder="Franco Colmenarez">
		<br>

		<label for="email">Email:</label>
		<input type="email" name="email" id="email" placeholder="franco&#64;example.com">
		<br>

		<label for="password">Password:</label>
		<input type="password" name="password" id="password" placeholder="123456">
		<br>

		<button>Crear</button>
	</form>

@endsection
