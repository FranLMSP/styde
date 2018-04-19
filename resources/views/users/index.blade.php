@extends('layouts.index')

@section('content')


	<h1>{{ $title }}</h1>

	<hr>

	@if (! empty($users))
		<ul>
			@foreach($users as $user)
				<li>{{ $user }}</li>
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