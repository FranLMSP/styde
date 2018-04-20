@extends('layouts.index')

@section('content')

	<h1>Crear nuevo usuario</h1>

	@if ($errors->any())

		<div class="alert alert-danger">
			<h6>Por favor corrige los siguientes errores: </h6>
			<ul>
				@foreach ($errors->all() as $error)

					<li>{{ $error }}</li>

				@endforeach
			</ul>
		</div>

	@endif

	<form method="POST" action="{{ route('users.store') }}">
		{!! csrf_field() !!}

		<label for="name">Nombre:</label>
		<input type="text" name="name" id="name" placeholder="Franco Colmenarez" value="{{ old('name') }}">
		@if ($errors->has('name'))
			<p>{{ $errors->first('name') }}</p>
		@endif
		<br>

		<label for="email">Email:</label>
		<input type="email" name="email" id="email" placeholder="franco&#64;example.com" value="{{ old('email') }}">
		@if ($errors->has('email'))
			<p>{{ $errors->first('email') }}</p>
		@endif
		<br>

		<label for="password">Password:</label>
		<input type="password" name="password" id="password" placeholder="123456">
		@if ($errors->has('password'))
			<p>{{ $errors->first('password') }}</p>
		@endif
		<br>

		<button>Crear</button>
	</form>

@endsection
