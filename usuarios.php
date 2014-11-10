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

<?php
include 'php/conex.php';
conectar();
mysql_query("SET NAMES 'utf8'");
$result=mysql_query("SELECT id_usuario, nombres, apellidos, usuario, perfil FROM Usuarios");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Hola Mundo</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/bootstrap-theme.css" rel="stylesheet">
	<link href="css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="css/estilos-errores.css" rel="stylesheet">
</head>

<body>
	<div class="container-fluid">
		<div id="tabla-usuarios" class="row">
			<div class="col-md-10 col-md-offset-1">
				<table id="tbl_usuarios" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
		              <thead>
			               <tr>
			                  <th>Nombres</th>
			                  <th>Apellidos</th>
			                  <th>Usuario</th>
			                  <th>Perfil</th>
			                  <th>Opciones</th>
			               </tr>
		              </thead>
		              <tfoot>
			               <tr>
			                 <th>Nombres</th>
			                  <th>Apellidos</th>
			                  <th>Usuario</th>
			                  <th>Perfil</th>
			                  <th>Opciones</th>
			               </tr>
		              </tfoot>
		              <tbody>
		               <?php while($rows=mysql_fetch_array($result)){ ?>
		               <tr>
		                  <td><?php echo $rows['nombres']; ?></td>
		                  <td><?php echo $rows['apellidos']; ?></td>
		                  <td><?php echo $rows['usuario']; ?></td>
		                  <td>
		                  	<?php if ($rows['perfil'] == 1): ?>
		                  		Administrador
		                  	<?php else: ?>
		                  		Invitado
		                  	<?php endif; ?>
		                  </td>
		                  <td>
		                  	<div class="btn-group">
								<button type="button" class="btn btn-warning">Opciones</button>
									<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
									    <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a onclick="modificar_usuario(<?php echo $rows['id_usuario']; ?>);">Modificar</a></li>
									<li><a onclick="eliminar_usuario(<?php echo $rows['id_usuario']; ?>);">Eliminar</a></li>
								</ul>
							</div>
		                  </td>
		               </tr>
		               <?php } ?>
		              </tbody>
	             </table>
			</div>
		</div>
		<button type="button" id="bt_mostrar_form_crear_usuario" class="btn btn-success">Agregar</button>

		<div id="formulario-crear-usuario" class="row" style="display:none;">
			<div class="col-md-4 col-md-offset-4">
				<h1>Crear Usuario</h1>
				<form id="form-crear" action="php/usuarios.php" method="post" accept-charset="utf-8" >
					<div class="form-group">
						<label for="nombres">Nombres:</label>
						<input type="text" name="nombres" class="form-control">
					</div>
					<div class="form-group">
						<label for="apellidos">Apellidos:</label>
						<input type="text" name="apellidos" class="form-control">
					</div>
					<div class="form-group">
						<label for="usuario">Usuario:</label>
						<input type="text" name="usuario" class="form-control">
					</div>
					<div class="form-group">
						<label for="contrasena">Contraseña:</label>
						<input type="password" id="contrasena" name="contrasena" class="form-control">
					</div>
					<div class="form-group">
						<label for="contrasena_confi">Confirme Contraseña:</label>
						<input type="password" name="contrasena_confi" class="form-control">
					</div>
					<div class="form-group">
						<label for="perfil">Perfil:</label>
							<select class="form-control" name="perfil">
								<option value="">Seleccione un perfil de usuarios</option>
							  	<option value="1">Administrador</option>
							  	<option value="2">Invitado</option>
							</select>					
					</div>
					<div class="form-group">
						<span id="info-cargando"></span>
					</div>
					<button type="submit" class="btn btn-default">Crear</button>
					<button type="button" id="bt_regregar" class="btn btn-success">Cancelar</button>
				</form>
			</div>
		</div>
	</div><!-- fin container-fluid -->

	<!-- Modal de información -->
	<div class="modal fade bs-example-modal-sm" id="modal_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerar</span></button>
	        <h4 class="modal-title" id="myModalLabel">Información</h4>
	      </div>
	      <div class="modal-body">
	      	<span id="respuesta"></span>
	      </div>
	      <div class="modal-footer">
	        <button type="button" id="bt_mensaje_ok" class="btn btn-default" data-dismiss="modal">Aceptar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal para actualizar datos -->
	<div class="modal fade " id="modal_update_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerar</span></button>
	        <h4 class="modal-title" id="myModalLabel">Modificar Usuario</h4>
	      </div>
	      <div class="modal-body">
	      	<!-- INICIO PORMULARIO DE ACTUALIZAR -->
	      	<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<form id="form-modificar" action="php/usuarios.php" method="post" accept-charset="utf-8" >
						<input type="hidden" id="id_usuario" name="id_usuario" class="form-control">
						<div class="form-group">
							<label for="nombres">Nombres:</label>
							<input type="text" id="nombres_up" name="nombres" class="form-control">
						</div>
						<div class="form-group">
							<label for="apellidos">Apellidos:</label>
							<input type="text" id="apellidos_up" name="apellidos" class="form-control">
						</div>
						<div class="form-group">
							<label for="usuario">Usuario:</label>
							<input type="text" id="usuario_up" name="usuario" class="form-control">
						</div>
						<div class="form-group">
							<label for="perfil">Perfil:</label>
								<select class="form-control" id="perfil_up" name="perfil">
									<option value="">Seleccione un perfil de usuarios</option>
								  	<option value="1">Administrador</option>
								  	<option value="2">Invitado</option>
								</select>					
						</div>
						<div class="form-group">
							<span id="info-cargando_up"></span>
						</div>
						<button type="submit" class="btn btn-success">Crear</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					</form>
				</div>
			</div>
			<!-- FIN PORMULARIO DE ACTUALIZAR -->
	     </div>
	    </div>
	  </div>
	</div>
	
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/jquery.validate.js"></script>
	<script src="js/usuarios.js"></script>
	<script src="js/jquery.dataTables.js"></script>
	<script src="js/dataTables.bootstrap.js"></script>
</body>
</html>