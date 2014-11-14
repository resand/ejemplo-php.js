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
$result=mysql_query("SELECT id_proveedor, rfc, razon_social, direccion, codigo_postal, correo ,telefono FROM Proveedores WHERE activo = 1");

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>SIPRD</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/bootstrap-theme.css" rel="stylesheet">
	<link href="css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="css/estilos-errores.css" rel="stylesheet">
</head>

<body>
	<div class="container-fluid">
		<div id="tabla-proveedor" class="row">
			<div class="col-md-10 col-md-offset-1">
				<table id="tbl_proveedor" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
		              <thead>
			               <tr>
			                  <th>Razon social</th>
			                  <th>Direccion</th>
			                  <th>RFC</th>
			                  <th>CP</th>
			                  <th>Correo </th>
			                  <th>Telefono</th>
			                  <th>Opciones</th>
			                  
			                  
			               </tr>
		              </thead>
		              
		              <tbody>
		               <?php while($rows=mysql_fetch_array($result)){ ?>
		               <tr>
		                  <td><?php echo $rows['razon_social']; ?></td>
		                  <td><?php echo $rows['direccion']; ?></td>
		                  <td><?php echo $rows['rfc']; ?></td>
		                   <td><?php echo $rows['codigo_postal']; ?></td>
		                    <td><?php echo $rows['correo']; ?></td>
		                     <td><?php echo $rows['telefono']; ?></td>
		                     
		                  
		                  	
		                  
		                 
		                  
		                  
		                  <td>
		                  	<div class="btn-group">
								<button type="button" class="btn btn-warning">Opciones</button>
									<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
									    <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a onclick="modificar_proveedor(<?php echo $rows['id_proveedor']; ?>);">Modificar</a></li>
									<li><a onclick="eliminar_usuario(<?php echo $rows['id_proveedor']; ?>);">Eliminar</a></li>
								</ul>
							</div>
		                  </td>
		               </tr>
		               <?php } ?>
		              </tbody>
	             </table>
			</div>
		</div>
		<button type="button" id="bt_mostrar_form_crear_proveedor" class="btn btn-success">Agregar</button>

		<div id="formulario-crear-proveedor" class="row" style="display:none;">
			<div class="col-md-4 col-md-offset-4">
				<h1>Agregar Nuevo Proveedor</h1>
				<form id="form-crear" action="php/proveedores.php" method="post" accept-charset="utf-8" >
					<div class="form-group">
						<label for="razon_social">Razon social o Nombre:</label>
						<input type="text" name="razon_social" class="form-control">
					</div>
					<div class="form-group">
						<label for="direccion">Direccion:</label>
						<input type="text" name="direccion" class="form-control">
					</div>
					<div class="form-group">
						<label for="rfc">RFC:</label>
						<input type="text" name="rfc" class="form-control">
					</div>
					<div class="form-group">
						<label for="codigo_postal">Codigo Postal:</label>
						<input type="text"  name="codigo_postal" class="form-control">
					</div>
					<div class="form-group">
						<label for="correo">Correo:</label>
						<input type="email" name="correo" class="form-control">
					</div>
					<div class="form-group">
						<label for="telefono">Telefono:</label>
						<input type="tel" name="telefono" class="form-control">
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
	<div class="modal fade bs-example-modal-sm" id="modal_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static" data-keyboard="false">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"></button>
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
	<div class="modal fade " id="modal_update_proveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerar</span></button>
	        <h4 class="modal-title" id="myModalLabel">Modificar Proveedor</h4>
	      </div>
	      <div class="modal-body">
	      	<!-- INICIO PORMULARIO DE ACTUALIZAR -->
	      	<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<form id="form-modificar" action="php/proveedores.php" method="post" accept-charset="utf-8" >
						<input type="hidden" id="id_proveedor" name="id_proveedor" class="form-control">
							<div class="form-group">
						<label for="razon_social">Razon social o Nombre:</label>
						<input type="text" name="razon_social" id="razon_up" class="form-control">
					</div>
					<div class="form-group">
						<label for="direccion">Direccion:</label>
						<input type="text" name="direccion" id="direccion_up" class="form-control">
					</div>
					<div class="form-group">
						<label for="rfc">RFC:</label>
						<input type="text" name="rfc"  id="rfc_up" class="form-control">
					</div>
					<div class="form-group">
						<label for="codigo_postal">Codigo Postal:</label>
						<input type="text"  name="codigo_postal" id="codigop_up" class="form-control">
					</div>
					<div class="form-group">
						<label for="correo">Correo:</label>
						<input type="email" name="correo"  id="correo_up" class="form-control">
					</div>
					<div class="form-group">
						<label for="telefono">Telefono:</label>
						<input type="tel" name="telefono" id="telefono_up" class="form-control">
					</div>

						<div class="form-group">
							<span id="info-cargando_up"></span>
						</div>
						<button type="submit" class="btn btn-success">Modificar</button>
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
	<script src="js/proveedores.js"></script>
	<script src="js/jquery.dataTables.js"></script>
	<script src="js/dataTables.bootstrap.js"></script>
</body>
</html>