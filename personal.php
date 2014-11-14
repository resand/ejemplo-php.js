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
$result=mysql_query("SELECT id_personal, clave_elector, clave_partido, nombres, apellidos, puesto,departamento,correo ,telefono,foto FROM personal WHERE activo = 1");

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
	<h2 class="alert alert-warning">Datos del personal PRD</h2>
	<div class="container-fluid">
		<div id="tabla-personal" class="row">
			<div class="col-md-10 col-md-offset-1">
				<table id="tbl_personal" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="110%" style="font-size: 10px;">
		              <thead>
			               <tr>
			                  <th>Nombres</th>
			                  <th>Apellidos</th>
			                  <th>Clave elector</th>
			                  <th>Clave del partido</th>
			                  <th>Puesto </th>
			                  <th>Departamento</th>
			                  <th>Correo</th>
			                   <th>Telefono</th>
			                   <th>Foto</th>
			                   <th>Opciones</th>


			                  
			               </tr>
		              </thead>
		              
		              <tbody>
		               <?php while($rows=mysql_fetch_array($result)){ ?>
		               <tr>
		                  <td><?php echo $rows['nombres']; ?></td>
		                  <td><?php echo $rows['apellidos']; ?></td>
		                  <td><?php echo $rows['clave_elector']; ?></td>
		                   <td><?php echo $rows['clave_partido']; ?></td>
		                    <td><?php echo $rows['puesto']; ?></td>
		                     <td><?php echo $rows['departamento']; ?></td>
		                     <td><?php echo $rows['correo']; ?></td>
		                     <td><?php echo $rows['telefono']; ?></td>
		                     <td><?php echo $rows['foto']; ?></td>



		                     
		                  
		                  	
		                  
		                 
		                  
		                  
		                  <td>
		                  	<div class="btn-group btn-small">
								<button type="button" class="btn btn-warning btn-small" >Opciones</button>
									<button type="button" class="btn btn-warning  dropdown-toggle" data-toggle="dropdown">
									    <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a onclick="modificar_personal(<?php echo $rows['id_proveedor']; ?>);">Modificar</a></li>	
									<li><a onclick="eliminar_personal(<?php echo $rows['id_proveedor']; ?>);">Eliminar</a></li>								</ul>
							</div>
		                  </td>
		               </tr>
		               <?php } ?>
		              </tbody>
	             </table>
			</div>
		</div>
		<button type="button" id="bt_mostrar_form_crear_personal" class="btn btn-success">Agregar</button>

		<div id="formulario-crear-personal" class="row" style="display:;">
			<div class="col-md-4 col-md-offset-4">
				<h1>Personal PRD</h1>
				<form id="form-crear" action="php/personal.php" method="post" accept-charset="utf-8" enctype ="multipart/form-data">
					<div class="form-group">
						<label for="nombres">Nombres:</label>
						<input type="text" name="nombres" class="form-control">
					</div>
					<div class="form-group">
						<label for="apellidos">Apellidos:</label>
						<input type="text" name="apellidos" class="form-control">
					</div>
					<div class="form-group">
						<label for="clave_elector">Clave de elector:</label>
						<input type="text" name="clave_elector" class="form-control">
					</div>
					<div class="form-group">
						<label for="clave_partido">Clave del partido:</label>
						<input type="text"  name="clave_partido" class="form-control">
					</div>
					<div class="form-group">
						<label for="puesto">Puesto:</label>
						<input type="text" name="puesto" class="form-control">
					</div>
					<div class="form-group">
						<label for="dèpartamento">Departamento:</label>
						<input type="text" name="departamento" class="form-control">
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
						<label for="foto">Foto:</label>
						<input type="file" name="foto" class="form-control" id="files">
						<label>Vista pervia:</label>
						<output id="list"></output>

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
	<div class="modal fade " id="modal_update_personal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerar</span></button>
	        <h4 class="modal-title" id="myModalLabel">Modificar Datos  del Personal</h4>
	      </div>
	      <div class="modal-body">
	      	<!-- INICIO PORMULARIO DE ACTUALIZAR -->
	      	<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<form id="form-modificar" action="php/personal.php" method="post" accept-charset="utf-8" >
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
	<script src="js/personal.js"></script>
	<script src="js/jquery.dataTables.js"></script>
	<script src="js/dataTables.bootstrap.js"></script>
</body>
</html>
<script type="text/javascript">
	function archivo(evt) {
      var files = evt.target.files; // FileList object
       
        //Obtenemos la imagen del campo "file". 
      for (var i = 0, f; f = files[i]; i++) {         
           //Solo admitimos imágenes.
           if (!f.type.match('image.*')) {
                continue;
           }
       
           var reader = new FileReader();
           
           reader.onload = (function(theFile) {
               return function(e) {
               // Creamos la imagen.
                      document.getElementById("list").innerHTML = ['<img class="thumb"  style="width:120px;"src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
               };
           })(f);
 
           reader.readAsDataURL(f);
       }
}
             
      document.getElementById('files').addEventListener('change', archivo, false);
</script>
