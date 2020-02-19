<?php
require('conexion.php');

function ElementosEnBlanco(){
	mysql_query("DELETE FROM contratado");
	mysql_query("DELETE FROM despedido");
}

$cadena=$_POST['cadena'];
$cadenas=explode('/',$cadena);
$nro_cadenas=count($cadenas);
$i=0;
ElementosEnBlanco();

while($i<$nro_cadenas){
	$elementos=explode(',',$cadenas[$i]);
	$nro_elementos=count($elementos);
	$j=0;
	while($j<$nro_elementos){
		if($elementos[$j]!=""){
			switch($i){
				case 0:
				mysql_query("INSERT INTO contratado(nombre_contratado) VALUES ('$elementos[$j]')",$con);
				break;
				case 1:
				mysql_query("INSERT INTO despedido(nombre_despedido) VALUES ('$elementos[$j]')",$con);
				break;
			}
		}
		$j++;
	}
	$i++;
}

echo "Cambios guardados";
?>