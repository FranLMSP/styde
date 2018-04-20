@extends('layouts.index')

@section('content')


	<h1>{{ $title }}</h1>

	<hr>
	@if (count($users) > 0)
		<ul>
			@foreach($users as $user)
				<li>{{ $user->name }}, <a href="{{ route('users.show', ['id' => $user->id] ) }}">({{ $user->email }})</a></li>
				<a href="{{ action('UserController@show', ['id' => $user->id]) }}">Ver detalles</a>
			@endforeach
		</ul>
	@else
		<ul>No hay usuarios registrados</ul>
	@endif


@endsection

@section('sidebar')

	@parent

	<h3>Barra lateral sobreescrita</h3>
@endsection