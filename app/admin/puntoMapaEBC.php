<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<script src="../js/PageInfo.js" type="text/javascript"></script>

<style>
<!--
.dragme{position:relative;}
-->
</style>
<script language="JavaScript1.2">
<!--

var ie=document.all;
var nn6=document.getElementById&&!document.all;

var isdrag=false;
var x,y;
var dobj;

function movemouse(e)
{
  if (isdrag)
  {
    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x;
    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y;
    return false;
  }
}

function selectmouse(e) 
{
  var fobj       = nn6 ? e.target : event.srcElement;
  var topelement = nn6 ? "HTML" : "BODY";

  while (fobj.tagName != topelement && fobj.className != "dragme")
  {
    fobj = nn6 ? fobj.parentNode : fobj.parentElement;
  }

  if (fobj.className=="dragme")
  {
    isdrag = true;
    dobj = fobj;
    tx = parseInt(dobj.style.left+0);
    ty = parseInt(dobj.style.top+0);
    x = nn6 ? e.clientX : event.clientX;
    y = nn6 ? e.clientY : event.clientY;
    document.onmousemove=movemouse;
    return false;
  }
}

document.onmousedown=selectmouse;
document.onmouseup=new Function("isdrag=false");

//-->
</script>




</head>
<!--
<link href="../estilo/estilos.css" rel="stylesheet" type="text/css">
-->
<body>
<table width="90%" border="1">
  <tr>
    <td colspan="3">Titulo</td>
  </tr>
  <tr>
    <td colspan="3">Tipo de Mapa: Geografia || Nombre: Ecuador || Orden: 0 || Nivel: Pais </td>
  </tr>
  <tr>
    <td width="25%"><p>Indicadores: </p>
    </td>
    <!-- mapa -->
	<td width="50%">
	  <img src="../mapa/elpilar.jpg" />
	</td>
	<!-- fin mapa -->
    <td width="25%" align="center" valign="middle">
	  <table width="88%" border="1">
        <tr>
          <td colspan="2">
		    <p>Opciones:</p>
            <p>Escoja la imagen y arrastrela hasta el mapa. </p>
		  </td>
        </tr>
        <tr>
          <td width="18%" align="center">
		    <img src="../icono/provincia.gif" class="dragme"/>
		  </td>
		  <td width="82%">Provincia</td>
        </tr>
		<tr>
          <td width="18%" align="center">
		    <img src="../icono/canton.gif" id="iCanton" class="dragme" />
		  </td>
		  <td width="82%">Canton</td>
        </tr>
      </table>
	</td>
  </tr>
  <tr>
    <td colspan="3">Opciones:</td>
  </tr>
</table>
</body>
</html>
