<?
// //Variables para conectarse al servidor
// $HOSTNAME = "localhost"; 		//SERVIDOR   
// $USERNAME = "root";	     		//USUARIO
// $PASSWORD = "root";	     		//CONTRASENIA
// $DATABASE = "inventarios";		//BASE DE DATOS


// function conectar(){
//   global $HOSTNAME, $USERNAME, $PASSWORD, $DATABASE;
//   $idcnx = mysql_connect($HOSTNAME, $USERNAME, $PASSWORD) or
// 	DIE(mysql_error());
//   mysql_select_db ($DATABASE, $idcnx);
//   return $idcnx;
//  }

function conectar(){
 	$con = mysql_connect("localhost","root","root");
 	if (!$con){
  		die('Could not connect: ' . mysql_error());
 }
 mysql_select_db("inventarios", $con);
 return $con;
}
?>
