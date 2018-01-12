<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Drag Drop con script.aculo.us, PHP y MySQL (Parte 2) - RibosoMatic.com</title>
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>
<script src="js/ajax.js" type="text/javascript"></script>
<style>
#contratados{
	background-color:#FFFFCC;
	margin:5px;
}
#despedidos{
	background-color:#E4ECF3;
	margin:5px;
}
#contratados div, #despedidos div{
	margin:4px;
	cursor:move;
	border:1px solid red;
}
h3{
	margin:4px;
	background-color:#4B6186;
	color:#FFFFFF;
	cursor:move;
}
#pagina{
	width:350px;
	margin:auto;
	padding-left:50px;
	padding-right:50px;
	height:200px;
}
</style>
<script type="text/javascript">
	function obtenerElementos() {
		var secciones = document.getElementsByClassName('seccion');
		var alerttext = '';
		var separador = '';
		secciones.each(function(seccion) {
			alerttext += separador + Sortable.sequence(seccion);
			separador = "/";
		});
		EnviarDatos(alerttext);
		return false;
	}
</script>
</head>

<body>
<h2 align="center">Arrastra los empleados de un bloque a otro y presiona Guardar</h2>
<p align="center">
<?php
	//include('../../pub/adsgoogle_fullart_tit.tpl');
?>
</p>
<div id="pagina">
<div id="contratados" class="seccion" style="float:left;width:150px;">
	<h3 class="arrastrar">Contratados</h3>
	<?php 
	 require('conexion.php');
	 $Resultado=mysql_query("SELECT * FROM contratado",$con);
	 while($MostrarFila=mysql_fetch_array($Resultado)){
		 echo "<div id='empleados_".$MostrarFila['nombre_contratado']."'>".$MostrarFila['nombre_contratado']."</div> \n";
	 }
	?>
</div>
<div id="despedidos" class="seccion" style="float:left;width:150px;">
	<h3 class="arrastrar">Despedidos</h3>
	<?php 
	 $Resultado=mysql_query("SELECT * FROM despedido",$con);
	 while($MostrarFila=mysql_fetch_array($Resultado)){
		 echo "<div id='despedidos_".$MostrarFila['nombre_despedido']."'>".$MostrarFila['nombre_despedido']."</div>";
	 }
	?>
</div>
</div>
<script type="text/javascript">
 // <![CDATA[
	Sortable.create('contratados',{
		tag:'div',
		dropOnEmpty: true, 
		containment:["contratados","despedidos"],
		constraint:false});
	Sortable.create('despedidos',{
		tag:'div',
		dropOnEmpty: true, 
		containment:["contratados","despedidos"],
		constraint:false});
	Sortable.create('pagina',{
		tag:'div',
		only:'seccion',
		handle:'arrastrar'});
 // ]]>
</script>
<p align="center">
  <input type="button" name="Button" value="Guardar en la base de datos" onclick="obtenerElementos()" />
</p>
<p align="center">Para comprobar que es as&iacute;, recargue la p&aacute;gina y ver&aacute; los elementos como los dej&oacute;!!! </p>
<p align="center">(<a href="http://www.ribosomatic.com/articulos/drag-drop-con-scriptaculous-php-y-mysql-parte-1/">Ver art&iacute;culo relacionado</a>)</p>
</body>
</html>
