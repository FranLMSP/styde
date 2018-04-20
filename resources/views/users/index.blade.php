@extends('layouts.index')

@section('content')


	<h1>{{ $title }}</h1>

	<p>
		<a href="{{ route('users.create') }}">Crear nuevo usuario</a>
	</p>

	<hr>
	@if (count($users) > 0)
		<ul>
			@foreach($users as $user)
				<li>{{ $user->name }}, <a href="{{ route('users.show', ['id' => $user->id] ) }}">({{ $user->email }})</a></li>
				<a href="{{ action('UserController@show', ['id' => $user->id]) }}">Ver detalles</a> | 
				<a href="{{ route('users.edit', $user) }}">Editar</a> | 
				<form action="{{ route('users.destroy', $user) }}" method="POST">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}
					<button type="submit">Eliminar</button>
				</form>
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