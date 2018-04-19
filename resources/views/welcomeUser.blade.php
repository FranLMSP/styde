<!DOCTYPE html>
<html>
<head>
	<title>Listado de usuarios</title>
	<meta charset="utf-8">
</head>
<body>

	@if ($nickname)
		<h1>Bienvenido {{ $name }}, tu apodo es {{ $nickname }}</h1>
	@else
		<h1>Bienvenido {{ $name }}</h1>
	@endif
</body>
</html>