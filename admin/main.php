<?php
  session_start();
  
  if(!session_is_registered("sUsuId"))
  {
      header("location:logout.php?msg=Sesion Expirada");
  }
  
  include_once("../includes/main.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: INNFA-map ::</title>
</head>
<link href="../estilo/estilos.css" rel="stylesheet" type="text/css">
<SCRIPT LANGUAGE="JavaScript">
function openWindow(vurl,vtitle,vwidth,vheight) 
{
 var cad;
 cad='width=' + vwidth + ',height=' + vheight + ',resizable=1,scrollbars=1,toolbar=0,menubar=0,location=0';
 //alert (vurl);
 //alert (vtitle);
 //alert (cad);
 window.open(vurl,vtitle,cad);
}
function abrirVentana(url)
{
  var cadena;
  var ancho, alto;
	
  ancho = screen.availWidth - 10;
  alto = screen.availHeight - 50;
  cadena = 'left=0,top=0,border=0,status=yes,scrollbars=yes,' + 'width=' + ancho + ',height=' + alto;
	//cadena = 'status=yes,scrollbars=yes,' + 'width=' + ancho + ',height=' + alto;
  window.open(url, "InnfaMap", cadena);
}
</SCRIPT>
<body>
<table width="90%" border="0" align="center">
  <tr>
    <td align="right">
	  Usuario: <?=$_SESSION["sUsuId"]?> 
	  &nbsp;&nbsp;
	  &Uacute;ltima Actualizaci&oacute;n: <?=date("Y-m-d H:i:s")?>
	  &nbsp;&nbsp;
      ::<a href="cambiaclave.php">Cambiar Clave</a>::
	  &nbsp;&nbsp;
      ::<a href="logout.php">Salir</a>::	
	</td>
  </tr>
  <tr>
    <td>
	| <a href="<?=$PHP_SELF?>">Inicio</a>	
	| <a href="<?=$PHP_SELF?>?opcion=usuario">Usuario</a>	
	| <a href="<?=$PHP_SELF?>?opcion=indicador">Indicador</a>	
	| <a href="<?=$PHP_SELF?>?opcion=parametro">Parametro</a>
	| <a href="<?=$PHP_SELF?>?opcion=geografia">Estructura Geografica</a>	
	| <a href="<?=$PHP_SELF?>?opcion=innfa">Estructura INNFA</a>
	| <a href="<?=$PHP_SELF?>?opcion=mapa">Mapa</a> |	
	</td>
  </tr>
  <tr>
    <td>
	  <?php
	    if(isset($opcion))
		{
		  include_once($opcion.".php");
		}
		else
		{
		  echo "<br><br><br>Bienvenido al Administrador de Mapas<br><br>";
		  echo "<br><br><br>Favor utilizar las opciones.<br><br>";
		}
	  ?>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
