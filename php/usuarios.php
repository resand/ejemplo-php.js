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

	$nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);
    $perfil = trim($_POST['perfil']);

	conectar();
    mysql_query("SET NAMES 'utf8'");
    //CONSULTA REPETIDO
    $usuario_nuevo = mysql_query("SELECT usuario FROM Usuarios WHERE usuario = '$usuario'");

    if(mysql_num_rows($usuario_nuevo) > 0){
        echo json_encode(array('mensaje' => 'El usuario se encuentra repetido.', 'clase' => 'info-error'));
    }else{
        $sql = mysql_query("INSERT INTO Usuarios (nombres, apellidos, usuario, contrasena, perfil) VALUES ('$nombres', '$apellidos', '$usuario', sha1('$contrasena'), '$perfil')");
        
        $registro_insertado = mysql_insert_id();
        if ($registro_insertado > 0){
            echo json_encode(array('mensaje' => 'El usuario se ha creado correctamente.', 'clase' => 'info-insertado'));
        }else{
            echo json_encode(array('mensaje' => 'Ocurrio un error al insertar el usuario.', 'clase' => 'info-error'));
        } 
    }
}

function modificar_usuario() {
    $id = $_REQUEST['id'];

    conectar();
    
    mysql_query("SET NAMES 'utf8'");
    $sql = "SELECT id_usuario, nombres, apellidos, usuario, perfil FROM Usuarios WHERE id_usuario = '$id' LIMIT 1";
    $lista = mysql_query($sql) or die(mysql_error());

    while($fila = mysql_fetch_object($lista)){
        $datos[] = $fila;
    }
    echo json_encode($datos);
}

function completar_modificar_usuario() {
    $id = trim($_POST['id_usuario']);
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $usuario = trim($_POST['usuario']);
    $perfil = trim($_POST['perfil']);

    conectar();
    mysql_query("SET NAMES 'utf8'");
    //CONSULTA REPETIDO
    $usuario_modificado = mysql_query("SELECT usuario FROM Usuarios WHERE usuario = '$usuario' AND id_usuario != '$id'");

    if(mysql_num_rows($usuario_modificado) > 0){
        echo json_encode(array('mensaje' => 'El usuario se encuentra repetido.', 'clase' => 'info-error'));
    }else{
        $sql = mysql_query("UPDATE Usuarios SET nombres = '$nombres', apellidos = '$apellidos', usuario = '$usuario', perfil = '$perfil' WHERE id_usuario = '$id'");
        echo json_encode(array('mensaje' => 'El usuario se ha modificado correctamente.', 'clase' => 'info-insertado'));
    }
}

function eliminar_usuario() {
    
    $id = trim($_POST['id']);
    $id_usuario_activo = $_SESSION['id_usuario'];

    conectar();
    mysql_query("SET NAMES 'utf8'");

    //CONSULTA DE USUARIO ACTIVO && Administrador
    $usuario_activo = mysql_query("SELECT usuario FROM Usuarios WHERE id_usuario = '$id_usuario_activo' AND id_usuario = '$id' AND perfil = 1");

    if (mysql_num_rows($usuario_activo) > 0 ){
        echo json_encode(array('mensaje' => 'No es posible eliminar un usuario con sesión activa y con perfil de administrador', 'clase' => 'info-error'));
    } else {
        $sql = mysql_query("UPDATE Usuarios SET activo = 0 WHERE id_usuario = '$id'");
        echo json_encode(array('mensaje' => 'El usuario se ha eliminado correctamente.', 'clase' => 'info-insertado'));
    }
}



?>