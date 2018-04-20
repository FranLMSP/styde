@extends('layouts.index')

@section('content')

	<h1>Crear nuevo usuario</h1>


	<form method="POST" action="{{ route('users.store') }}">
		{!! csrf_field() !!}

		<button>Crear</button>
	</form>

@endsection
