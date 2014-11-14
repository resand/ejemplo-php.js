<?php
session_start();
if(!isset($_SESSION['estado']) && !isset($_SESSION['perfil'])){
  echo '<script type="text/javascript">window.location = "index.php"; </script>';
}else{
	if ($_SESSION['perfil'] == 1) {
		$id_usuario = $_SESSION['id_usuario'];
  		$usuario = $_SESSION['usuario'];
  		$nombres = $_SESSION['nombres'];
  	}else {
  		echo '<script type="text/javascript">window.location = "index.php"; </script>';
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
				<h1>ADMIN</h1>
				<button type="button" id="cerrar_sesion" class="btn btn-warning">Cerrar Sesión</button>
			</div>
		</div>
	</div>
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/login.js"></script>
</body>
</html>