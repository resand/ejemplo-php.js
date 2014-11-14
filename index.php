<?php
session_start();
if(isset($_SESSION['estado']) && isset($_SESSION['perfil'])){
	if ($_SESSION['perfil'] == 1){
		echo '<script type="text/javascript">window.location = "admin.php"; </script>';	
	}else {
		echo '<script type="text/javascript">window.location = "invitado.php"; </script>';	
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>SIPRD</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/bootstrap-theme.css" rel="stylesheet">
	<link href="css/estilos-errores.css" rel="stylesheet">
</head>


<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<form id="form-login" action="php/login.php" method="post" accept-charset="utf-8" >
					<div class="form-group">
						<label for="usuario">Usuario:</label>
						<input type="text" name="usuario" class="form-control">
					</div>
					<div class="form-group">
						<label for="contrasena">Contraseña:</label>
						<input type="password" name="contrasena" class="form-control">
					</div>
					<div class="form-group">
						<span id="info-cargando"></span>
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