<?php
  
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
  
  //$_REQUEST["imageName"]=$obj->map_imagenedit;
  
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Image Editor</title>

	<style type="text/css">@import "ImageEditor.css";</style>
	<link href="../estilo/estilos.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="PageInfo.js"></script>
	<script type="text/javascript" src="ImageEditor.js"></script>
	
	<script language="javascript" src="../ejmap/mapa.php_files/domLib.js"></script>
	<script language="javascript" src="../ejmap/mapa.php_files/domTT.js"></script>
	
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
  
  var mapaId="<?=$id?>";
  var mapaImgNombre="<?=$obj->map_imagenedit?>"; 
  var tipmapId="<?=$obj->tipmap_id?>"; 
  var tipId="<?=$obj->tip_id?>"; 
  
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
  //var valordiv=document.getElementById("ImageEditorImage.img");
  //alert(valordiv.getAttribute("usemap"));
  
  var fobj       = nn6 ? e.target : event.srcElement; 
   
	isdrag = false; 
	dobj = fobj;

	tx = parseInt(dobj.style.left+0,10); 
	ty = parseInt(dobj.style.top+0,10); 

	x = nn6 ? PageInfo.getMouseX() : PageInfo.getMouseX(); 
	y = nn6 ? PageInfo.getMouseY() : PageInfo.getMouseY();
	
	//en el mapa
	xMapa=PageInfo.getElementLeft(ImageEditor.editorImage);
	yMapa=PageInfo.getElementTop(ImageEditor.editorImage); 
	
	anchoMapa=PageInfo.getElementWidth(ImageEditor.editorImage);
	altoMapa=PageInfo.getElementHeight(ImageEditor.editorImage); 
	
	
	//posicion de punto en el mapa
	relativaX=x-xMapa;
	relativaY=y-yMapa;
	/*
	alert("x="+x+" --- y="+y);
	alert("xMapa="+xMapa+" --- yMapa="+yMapa);
	alert("relativaX="+relativaX+" --- relativaY="+relativaY);
	alert("anchoMapa="+anchoMapa+" --- altoMapa="+altoMapa);
	*/
	if((relativaX>=0)&&(relativaY>=0)&&(relativaX<=anchoMapa)&&(relativaY<=altoMapa))
	{
	  mostrar=1;
	}
	else
	{
	  mostrar=0;
	}   
	  switch(vimgOpcion)
	  {
	    case "iProvincia":
	      //abrirVentana("index.php?prueba=prueba");
		  ajaxProvincia(relativaX,relativaY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId);
	    break;
	    case "iCanton":
	      
	    break;
	  } 
	  
	  return false;  
}

function objetus()
{
  try
  {
    objeto= new ActiveXObject("Msxml2.XMLHTTP");
  }
  catch (e)
  {
    try
	{
	  objeto= new ActiveXObject("Microsoft.XMLHTTP");
	}
	catch (E)
	{
	  objeto=false;
	}
  }
  if(!objeto && typeof XMLHttpRequest!='undefined')
  {
    objeto=new XMLHttpRequest();
  }
  return(objeto);
}

function ajaxProvincia(puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId)
{
  _objetus = objetus();
  
  _valuesSend="&puntoX="+puntoX+"&puntoY="+puntoY+"&mostrar="+mostrar+"&mapaId="+mapaId+"&mapaImgNombre="+mapaImgNombre+"&tipmapId="+tipmapId+"&tipId="+tipId;
  
  _url="ajaxProvincia.php?";
  
  _objetus.open("POST",_url+_valuesSend,true);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  window.alert(_objetus.responseText);
	  document.getElementById("divValor").innerHTML=_objetus.responseText;
	}
  }
  
  _objetus.send(null);
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
    <td colspan="2" class="workareaAdmin">Mapa: <?=$obj->map_nombre?></td>
  </tr>
  <tr>
    <td>
	  Tipo de Mapa: Geografia <br>
	  Orden: 0 <br>
	  Nivel: Pais <br>
	</td>
	<td align="left">
	  <table width="100%" border="0">
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
    <td width="25%">
	  
	
	  <div id="divValor">&nbsp;</div>
    </td>
    <!-- mapa -->
	<td align="center">
	  <div id="ImageEditorImage" style="display">
	  
	    	  <map name="mapa">
  <area id="__autoId8" shape="circle" coords="250,250,200" href="javascript:mostrar('30');" onMouseOver="return makeTrue(domTT_activate(this, event, 'statusText', 'Illetas', 'caption', 'Playa de Illetas - Juan y Andrea', 'content', '<b>Playa Illetas</b><br>Telf. +34 971 18 71 30', 'trail', true));">
<area shape="circle" coords="" href="javascript:mostrar('30');" onMouseOver="return makeTrue(domTT_activate(this, event, 'statusText', 'Playa de Illetas - Juan y Andrea', 'caption', 'Restaurante JUAN Y ANDREA', 'content', '<b>Playa Illetas</b><br>Telf. +34 971 18 71 30', 'trail', true));">
			  </map>
	  </div>
	</td>
	<!-- fin mapa -->
  </tr>
  
</table>	
	

</body>
</html>