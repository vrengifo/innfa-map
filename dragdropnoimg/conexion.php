<?php
//Configuracion de la conexion a base de datos
$bd_host = "localhost"; 
$bd_usuario = "root"; 
$bd_password = ""; 
$bd_base = "test"; 
$con = mysql_connect($bd_host, $bd_usuario, $bd_password); 
mysql_select_db($bd_base, $con); 
?>