<?php
  /*
  session_start();
  
  if(!session_is_registered("sUsuId"))
  {
      header("location:logout.php?msg=Sesion Expirada");
  }
  
  extract($_REQUEST);
  include_once("../includes/main.php");
  include_once("../class/cMapa.php");
  $obj=new cMapa($conn);
  $obj->info($id);
  
  $cadImg=$obj->map_imagen;
  //$_REQUEST["imageName"]=$cadImg;
  */
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Image Editor</title>

	<style type="text/css">@import "ImageEditor.css";</style>
	<script type="text/javascript" src="PageInfo.js"></script>
	<script type="text/javascript" src="ImageEditor.js"></script>
	<script type="text/javascript">
	//<![CDATA[
		if (window.opener){
			window.moveTo(0, 0);
			window.resizeTo(screen.width, screen.height - 28);
			window.focus();
		}
		window.onload = function(){
			ImageEditor.init("<?=$_REQUEST["imageName"]?>");
		};
	//]]>
	</script>
	
<style type="text/css"> 
 .dragme{position:relative;} 
</style> 
<script type="text/javascript"> 
  var ie=document.all; 
  var nn6=document.getElementById&&!document.all; 
  var isdrag=false; 
  var x,y; 
  var dobj;
  var vimgOpcion=""; 
  
function movemouse(e)
{ 
  if (isdrag)
  { 
	dobj.style.left = nn6 ? tx + PageInfo.getMouseX() - x : tx + PageInfo.getMouseX() - x; 
	dobj.style.top  = nn6 ? ty + PageInfo.getMouseY() - y : ty + PageInfo.getMouseY() - y; 
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

	tx = parseInt(dobj.style.left+0,10); 
	ty = parseInt(dobj.style.top+0,10); 

	x = nn6 ? PageInfo.getMouseX() : PageInfo.getMouseX(); 
	y = nn6 ? PageInfo.getMouseY() : PageInfo.getMouseY(); 
	
	vimgOpcion=fobj.name;
	
	document.onmousemove=movemouse; 
	return false;  
  }
  else
  {
    vimgOpcion="";
  } 
}

function soltadoEn(e)
{ 
  var fobj       = nn6 ? e.target : event.srcElement; 
   
	isdrag = false; 
	dobj = fobj;

	tx = parseInt(dobj.style.left+0,10); 
	ty = parseInt(dobj.style.top+0,10); 

	x = nn6 ? PageInfo.getMouseX() : PageInfo.getMouseX(); 
	y = nn6 ? PageInfo.getMouseY() : PageInfo.getMouseY(); 
	
	return false;  
}

document.onmousedown=selectmouse; 
document.onmouseup=soltadoEn; 
</script>	
	
</head>
<body>

	<div id="ImageEditorContainer">
		<div id="ImageEditorToolbar">
			<button onClick="ImageEditor.save()">Save As Active</button>
			<button onClick="ImageEditor.viewActive()">View Active</button>
			<button onClick="ImageEditor.viewOriginal()">View Original</button>
			<span class="spacer"> || </span>w:<input id="ImageEditorTxtWidth" type="text" size="3" maxlength="4" />&nbsp;h:<input id="ImageEditorTxtHeight" type="text" size="3" maxlength="4" /><input id="ImageEditorChkConstrain" type="checkbox" checked="checked" />Constrain&nbsp;<button onClick="ImageEditor.resize();">Resize</button>
			<span class="spacer"> || </span>
			<button onClick="ImageEditor.crop()">Crop</button>
			<span class="spacer"> || </span>
			<button onClick="ImageEditor.rotate(90)">90&deg;CCW</button><button onClick="ImageEditor.rotate(270)">90&deg;CW</button>
			<span class="spacer"> || </span>
			<span id="ImageEditorCropSize"></span>
		</div>	
		
	</div>
	
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
	  <div id="ImageEditorImage">&nbsp;</div>
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
		    <img src="../icono/provincia.gif" name="iProvincia" id="iProvincia" class="dragme"/>
		  </td>
		  <td width="82%">Provincia</td>
        </tr>
		<tr>
          <td width="18%" align="center">
		    <img src="../icono/canton.gif" name="iCanton" id="iCanton" class="dragme" />
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