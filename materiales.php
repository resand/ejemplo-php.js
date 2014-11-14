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
$result=mysql_query("SELECT id_producto, codigo_producto, nombre_producto, descripcion_producto, fecha_adquisicion, monto_original, porcentaje_depreciacion, factura_pdf, factura_xml, id_estado, id_responsable_activo, id_responsable_departament, ubicacion_id_departamento, foto FROM materiales WHERE activo = 1");
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
		<div id="tabla-materiales" class="row">
			<div class="col-md-10 col-md-offset-1">
				<table id="tbl_materiales" class="table table-striped table-bordered table-hover table-condensed table-responsive" cellspacing="0" width="10%">
		              <thead>
			               <tr>
			                  <th>Codigo</th>
			                  <th>Nombre</th>
			                  <th>Descripcion</th>
			                  <th>Clasificacion</th>
			                  <th>Fecha Adq.</th>
			                  <th>Precio</th>
			                  <th>% de Depre.</th>
			                  <th>Factura PDF</th>
			                  <th>Factura XML</th>
			                  <th>Estado</th>
			                  
			                  <th>Foto</th>
			                  
			               </tr>
		              </thead>
		              <tfoot>
			               
			               </tr>
		              </tfoot>
		              <tbody>
		               <?php while($rows=mysql_fetch_array($result)){ ?>
		               <tr>
		                  <td><?php echo $rows['codigo_producto']; ?></td>
		                  <td><?php echo $rows['nombre_producto']; ?></td>
		                  <td><?php echo $rows['descripcion_producto']; ?></td>
		                  <td><?php echo $rows['id_clasificacion']; ?></td>
		                  <td><?php echo $rows['fecha_adquisicion']; ?></td>
		                  <td><?php echo $rows['monto_original']; ?></td>
		                  <td><?php echo $rows['porcentaje_depreciacion']; ?></td>
		                  <td><?php echo $rows['factura_pdf']; ?></td>
		                  <td><?php echo $rows['factura_xml']; ?></td>
		                  <td><?php echo $rows['id_estado']; ?></td>
		                  <td><?php echo $rows['id_responsable_activo']; ?></td>
		                  <td><?php echo $rows['id_responsable_departament']; ?></td>
		                  <td><?php echo $rows['foto']; ?></td>
		                  
		                  <td>
		                  	<div class="btn-group">
								<button type="button" class="btn btn-warning">Opciones</button>
									<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
									    <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a onclick="ver_materiales(<?php echo $rows['id_usuario']; ?>);">Ver</a></li>
									<li><a onclick="modificar_materiales(<?php echo $rows['id_usuario']; ?>);">Modificar</a></li>
									<li><a onclick="eliminar_materiales(<?php echo $rows['id_usuario']; ?>);">Eliminar</a></li>
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
			<div  style=" width: 900px; margin-left: 200px;">
				<h1>Ingresar Recurso Material</h1>
				<form id="form-crear" action="php/materiales.php" method="post" accept-charset="utf-8"  >
					<table><tr>
						<td width="50%">

					<div class="form-group">
						<label for="codigo_producto">Codigo:</label>
						<input type="text" name="codigo_producto" class="form-control" style="">

					</div>
					<div class="form-group">
						<label for="descripcion_producto">Descripcion:</label>
						<input type="text" name="descripcion_producto" class="form-control"style="">
					</div></td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<td width="50%">
					<div class="form-group">
						<label for="nombre_producto">Nombre:</label>
						<input type="text" name="nombre_producto" class="form-control"style="">
						
					</div>
					<div class="form-group">
						<label for="fecha_adquisicion">Fecha:</label>
						<input type="date" id="" name="fecha_adquisicion" class="form-control"style="">
					</div></td></tr>
					<tr>
						<td width="50%"><div class="form-group">
						<label for="monto_original">Precio:</label>
						<input type="text" name="monto_original" class="form-control">
					</div></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<td width="50%"><div class="form-group">
						<label for="porcentaje_depreciacion">% De Depreciacion:</label>
						<input type="text" name="porcentaje_depreciacion" class="form-control">
					</div></td>
					</tr>
					<tr>
						<td widt="50%"><div class="form-group">
						<label for="clave_factura">Clave de factura:</label>
						<input type="text" name="clave_factura" class="form-control">
					</div>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
						<td width="50%"><div class="form-group">
						<label for="factura_pdf">Factura PDF:</label>
						<input type="file" name="factura_pdf" class="form-control">
					</div></td>
					</tr>
					<tr>
						<td width="50%"><div class="form-group">
						<label for="factura_xml">Factura XML:</label>
						<input type="file" name="factura_xml" class="form-control">
					</div></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<td width="50%"><div class="form-group">
						<label for="id_clasificacion">Clasificacion:</label>
							<select class="form-control" name="id_clasificacion">
								<option value="">Seleccione un perfil de usuarios</option>
							  	
							</select>					
					</div></td>
					</tr>
					<tr>
						<td width="50%"><div class="form-group">
						<label for="id_proveedor">Proveedor:</label>
							<select class="form-control" name="id_proveedor">
								<option value="">Seleccione Proveedor</option>
							  	
							</select>					
					</div></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<td width="50%"><div class="form-group">
						<label for="id_estado">Estado del recurso:</label>
							<select class="form-control" name="id_estado">
								<option value="">Seleccione un estado</option>
							  	
							</select>					
					</div></td>
					</tr>
					<tr>
						<td width="50%"><div class="form-group">
						<label for="id_responsable_departament">Responsable del departamento:</label>
							<select class="form-control" name="id_responsable_departament">
								<option value="">Seleccione un Responsable</option>
							  	
							</select>					
					</div></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<td width="50%"><div class="form-group">
						<label for="id_responsable_activo">Responsable del activo:</label>
							<select class="form-control" name="id_responsable_activo">
								<option value="">Seleccione un Responsable</option>
							  	
							</select>					
					</div></td>
					</tr>
					<tr>
						<td width="50%"><div class="form-group">
						<label for="ubicacion_id_departamento">Ubicacion:</label>
							<select class="form-control" name="ubicacion_id_departamento">
								<option value="">Seleccione una ubicacion</option>
							  	
							</select>					
					</div></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<td width="50%"><div class="form-group">
						<label for="foto">Foto:</label>
						<input type="file" name="foto" class="form-control">
					</div></td>
					
					</tr>
					<tr>
						<td><label>Vista pervia:</label><output id="list"></output></td>
					</tr>
				</table>
					
					
					
					
					
					
					
					
					
					
					
					
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
	<div class="modal fade " id="modal_update_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerar</span></button>
	        <h4 class="modal-title" id="myModalLabel">Modificar Recurso Material</h4>
	      </div>
	      <div class="modal-body">
	      	<!-- INICIO PORMULARIO DE ACTUALIZAR -->
	      	<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<form id="form-modificar" action="php/materiales.php" method="post" accept-charset="utf-8" >
						<input type="hidden" id="id_materiales" name="id_materiales" class="form-control">
							<table><tr>
						<td width="50%">

					<div class="form-group">
						<label for="codigo_producto">Codigo:</label>
						<input type="text" name="codigo_producto" class="form-control" style="">

					</div>
					<div class="form-group">
						<label for="descripcion_producto">Descripcion:</label>
						<input type="text" name="descripcion_producto" class="form-control"style="">
					</div></td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<td width="50%">
					<div class="form-group">
						<label for="nombre_producto">Nombre:</label>
						<input type="text" name="nombre_producto" class="form-control"style="">
						
					</div>
					<div class="form-group">
						<label for="fecha_adquisicion">Fecha:</label>
						<input type="date" id="" name="fecha_adquisicion" class="form-control"style="">
					</div></td></tr>
					<tr>
						<td width="50%"><div class="form-group">
						<label for="monto_original">Precio:</label>
						<input type="text" name="monto_original" class="form-control">
					</div></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<td width="50%"><div class="form-group">
						<label for="porcentaje_depreciacion">% De Depreciacion:</label>
						<input type="text" name="porcentaje_depreciacion" class="form-control">
					</div></td>
					</tr>
					<tr>
						<td widt="50%"><div class="form-group">
						<label for="clave_factura">Clave de factura:</label>
						<input type="text" name="clave_factura" class="form-control">
					</div>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
						<td width="50%"><div class="form-group">
						<label for="factura_pdf">Factura PDF:</label>
						<input type="file" name="factura_pdf" class="form-control">
					</div></td>
					</tr>
					<tr>
						<td width="50%"><div class="form-group">
						<label for="factura_xml">Factura XML:</label>
						<input type="file" name="factura_xml" class="form-control">
					</div></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<td width="50%"><div class="form-group">
						<label for="id_clasificacion">Clasificacion:</label>
							<select class="form-control" name="id_clasificacion">
								<option value="">Seleccione un perfil de usuarios</option>
							  	
							</select>					
					</div></td>
					</tr>
					<tr>
						<td width="50%"><div class="form-group">
						<label for="id_proveedor">Proveedor:</label>
							<select class="form-control" name="id_proveedor">
								<option value="">Seleccione Proveedor</option>
							  	
							</select>					
					</div></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<td width="50%"><div class="form-group">
						<label for="id_estado">Estado del recurso:</label>
							<select class="form-control" name="id_estado">
								<option value="">Seleccione un estado</option>
							  	
							</select>					
					</div></td>
					</tr>
					<tr>
						<td width="50%"><div class="form-group">
						<label for="id_responsable_departament">Responsable del departamento:</label>
							<select class="form-control" name="id_responsable_departament">
								<option value="">Seleccione un Responsable</option>
							  	
							</select>					
					</div></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<td width="50%"><div class="form-group">
						<label for="id_responsable_activo">Responsable del activo:</label>
							<select class="form-control" name="id_responsable_activo">
								<option value="">Seleccione un Responsable</option>
							  	
							</select>					
					</div></td>
					</tr>
					<tr>
						<td width="50%"><div class="form-group">
						<label for="ubicacion_id_departamento">Ubicacion:</label>
							<select class="form-control" name="ubicacion_id_departamento">
								<option value="">Seleccione una ubicacion</option>
							  	
							</select>					
					</div></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<td width="50%"><div class="form-group">
						<label for="foto">Foto:</label>
						<input type="file" name="foto" class="form-control" id="files">
					</div></td>
					
					</tr>
					<tr>
						<td><label>Vista pervia:</label><output id="list"></output></td>
					</tr>
				</table>

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
	<script src="js/materiales.js"></script>
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
                      document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
               };
           })(f);
 
           reader.readAsDataURL(f);
       }
}
             
      document.getElementById('files').addEventListener('change', archivo, false);
</script>
