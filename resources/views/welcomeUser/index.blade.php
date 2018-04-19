@extends('layouts.index')

@section('content')

	@if ($nickname)
		<h1>Bienvenido {{ $name }}, tu apodo es {{ $nickname }}</h1>
	@else
		<h1>Bienvenido {{ $name }}</h1>
	@endif

@endsection
