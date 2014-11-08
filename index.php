<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Hola Mundo</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/bootstrap-theme.css" rel="stylesheet">
</head>


<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<form id="form" action="php/login.php" method="post" accept-charset="utf-8" >
					<div class="form-group">
						<label for="usuario">Usuario:</label>
						<input type="usuario" name="usuario" class="form-control">
					</div>
					<div class="form-group">
						<label for="contrasena">Contraseña:</label>
						<input type="contrasena" name="contrasena" class="form-control">
					</div>
					<button type="submit" class="btn btn-default">Iniciar Sesión</button>
				</form>
			</div>
		</div>
	</div>
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/login.js"></script>
</body>
</html>