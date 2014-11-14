<?php 
session_start();
require_once('conex.php');
conectar();

$opcion = $_REQUEST['opcion'];
switch ($opcion) {
	case 1:
		crear_usuario();
		break;

    case 2:
        modificar_usuario();
        break;

    case 3:
        completar_modificar_usuario();
        break;

    case 4:
        eliminar_usuario();
        break;

	default:
		break;
}// fin switch

function crear_usuario() {

	$razon = trim($_POST['razon_social']);
    $direccion = trim($_POST['direccion']);
    $rfc = trim($_POST['rfc']);
    $codigop = trim($_POST['codigo_postal']);
    $correo = trim($_POST['correo']);
    $telefono= trim($_POST['telefono']);

	conectar();
    mysql_query("SET NAMES 'utf8'");
    //CONSULTA REPETIDO
        $usuario_nuevo = mysql_query("SELECT razon_social FROM proveedores WHERE razon_social = '$razon'");

    if(mysql_num_rows($usuario_nuevo) > 0){
        echo json_encode(array('mensaje' => 'El usuario se encuentra repetido.', 'clase' => 'info-error'));
    }else{
        $sql = mysql_query("INSERT INTO proveedores (razon_social, direccion, rfc, codigo_postal, correo, telefono) VALUES ('$razon', '$direccion', '$rfc', '$codigop', '$correo', '$telefono')");
        
        $registro_insertado = mysql_insert_id();
        if ($registro_insertado > 0){
            echo json_encode(array('mensaje' => 'Agregado con Exito.', 'clase' => 'info-insertado'));
        }else{
            echo json_encode(array('mensaje' => 'Ocurrio un error al insertar.', 'clase' => 'info-error'));
        } 
    }
}

function modificar_usuario() {
    $id = $_REQUEST['id'];

    conectar();
    
    mysql_query("SET NAMES 'utf8'");
    $sql = "SELECT id_proveedor, razon_social, direccion, rfc, codigo_postal, correo, telefono FROM proveedores WHERE id_proveedor = '$id' LIMIT 1";
    $lista = mysql_query($sql) or die(mysql_error());

    while($fila = mysql_fetch_object($lista)){
        $datos[] = $fila;
    }
    echo json_encode($datos);
}

function completar_modificar_usuario() {
    $id = trim($_POST['id_proveedor']);
    $razon = trim($_POST['razon_social']);
    $direccion = trim($_POST['direccion']);
    $rfc = trim($_POST['rfc']);
    $codigop = trim($_POST['codigo_postal']);
    $correo = trim($_POST['correo']);
    $telefono= trim($_POST['telefono']);
    conectar();
    mysql_query("SET NAMES 'utf8'");
    //CONSULTA REPETIDO
    $usuario_modificado = mysql_query("SELECT razon_social FROM proveedores WHERE razon_social = '$razon' AND id_proveedor != '$id'");

    if(mysql_num_rows($usuario_modificado) > 0){
        echo json_encode(array('mensaje' => 'El usuario se encuentra repetido.', 'clase' => 'info-error'));
    }else{
        $sql = mysql_query("UPDATE proveedores SET razon_social = '$razon', direccion = '$direccion', rfc = '$rfc', codigo_postal = '$codigop', correo = '$correo', telefono = '$telefono' WHERE id_proveedor = '$id'");
        echo json_encode(array('mensaje' => 'El usuario se ha modificado correctamente.', 'clase' => 'info-insertado'));
    }
}

function eliminar_usuario() {
    
    $id = trim($_POST['id']);
    

    conectar();
    mysql_query("SET NAMES 'utf8'");

    //CONSULTA DE USUARIO ACTIVO && Administrador
    ///$usuario_activo = mysql_query("SELECT usuario FROM Usuarios WHERE id_usuario = '$id_usuario_activo' AND id_usuario = '$id' AND perfil = 1");

    
        $sql = mysql_query("UPDATE proveedores SET activo = 0 WHERE id_proveedor = '$id'");
        echo json_encode(array('mensaje' => ' eliminado correctamente.', 'clase' => 'info-insertado'));
    }




?>