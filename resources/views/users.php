<!DOCTYPE html>
<html>
<head>
	<title>Listado de usuarios</title>
	<meta charset="utf-8">
</head>
<body>
	<h1><?= $title ?></h1>

	<ul>
		<?php foreach($users as $user): ?>
			<li><?= e($user) //This helper will escape the html tags ?></li>
		<?php endforeach; ?>
	</ul>
</body>
</html>