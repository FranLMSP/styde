@extends('layouts.index')

@section('content')

	<h1>{{ $title }}</h1>

	<hr>

	<p>Mostrando detalle del usuario: {{ $user->id }}</p>

	<p>Nombre: {{ $user->name }}</p>
	<p>Correo: {{ $user->email }}</p>

@endsection
