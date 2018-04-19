<!DOCTYPE html>
<html>
<head>
	<title>Listado de usuarios</title>
	<meta charset="utf-8">
</head>
<body>
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
</body>
</html>