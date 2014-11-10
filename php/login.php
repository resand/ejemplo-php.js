<?php 

require_once('conex.php');

conectar();

$opcion = $_POST['opcion'];

switch ($opcion) {
	case 1:
		iniciar_sesion();
		break;
	
	default:
		break;
}// fin switch

function iniciar_sesion() {
    
	$usuario = htmlentities(trim($_POST['usuario']));
    $contrasena = htmlentities(trim($_POST['contrasena']));

    conectar();
    session_start();
	mysql_query("SET NAMES 'utf8'");
	$sql = mysql_query("SELECT id_usuario, nombres, apellidos, usuario, perfil FROM Usuarios WHERE usuario = '$usuario' && contrasena = sha1('$contrasena')");
	
	$num_rows = mysql_num_rows($sql);
    if($num_rows <= 0){
        echo 0;
    } else {
        $fetch = mysql_fetch_array($sql);
        $_SESSION['id_usuario'] = $fetch['id_usuario'];
        $_SESSION['usuario'] = $fetch['usuario'];
        $_SESSION['nombres'] = $fetch['nombres'];
        $_SESSION['apellidos'] = $fetch['apellidos'];

        $perfil = $_SESSION['perfil'] = $fetch['perfil'];
        $estado = $_SESSION['estado'] = true;

        echo json_encode(array('perfil' => $perfil, 'estado' => $estado));
    }

}

// mysql_query("SET NAMES 'utf8'");
// $sql = "SELECT idperfil,perfil FROM tbl_perfilusuario ORDER BY idperfil ASC";
// $lista = mysql_query($sql) or die(mysql_error());

// while($fila = mysql_fetch_object($lista)){
// 	$datos[] = $fila;
// }
// echo json_encode($datos);

?>