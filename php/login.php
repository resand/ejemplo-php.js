<?php 

require_once('conex.php');

conectar();

mysql_query("SET NAMES 'utf8'");
$sql = "SELECT idperfil,perfil FROM tbl_perfilusuario ORDER BY idperfil ASC";
$lista = mysql_query($sql) or die(mysql_error());

while($fila = mysql_fetch_object($lista)){
	$datos[] = $fila;
}
echo json_encode($datos);

?>