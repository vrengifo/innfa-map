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
  
  include_once("../class/cTipomapa.php");
  $oTipoMapa=new cTipomapa($conn);
  include_once("../class/cTipo.php");
  $oTipo=new cTipo($conn);
  
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Puntos en Mapa</title>

	<style type="text/css">@import "ImageEditor.css";</style>
	<link href="../estilo/estilos.css" rel="stylesheet" type="text/css">
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
  
  var mapaId="<?=$id?>";
  var mapaImgNombre="<?=$obj->map_imagenedit?>"; 
  var tipmapId="<?=$obj->tipmap_id?>"; 
  var tipId=""; 

function cambiarAction(url)
{
  //alert(document.form1.action);
  document.form1.action=url;
  //alert(document.form1.action);
}
  
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
	
	//en el mapa
	xMapa=PageInfo.getElementLeft(ImageEditor.editorImage);
	yMapa=PageInfo.getElementTop(ImageEditor.editorImage); 
	
	anchoMapa=PageInfo.getElementWidth(ImageEditor.editorImage);
	altoMapa=PageInfo.getElementHeight(ImageEditor.editorImage); 
	
	
	//posicion de punto en el mapa
	relativaX=x-xMapa;
	relativaY=y-yMapa;

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
	      ajaxProvincia(relativaX,relativaY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId);
	    break;
	    case "iCanton":
	      ajaxCanton(relativaX,relativaY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId);
	    break;
	    case "iParroquia":
	      ajaxParroquia(relativaX,relativaY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId);
	    break;
	    case "iUTD":
	      ajaxUTD(relativaX,relativaY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId);
	    break;
	    case "iCoordinacion":
	      ajaxCoordinacion(relativaX,relativaY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId);
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
	  document.getElementById("divValor").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

function ajaxCanton(puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId)
{
  _objetus = objetus();
  
  _valuesSend="&puntoX="+puntoX+"&puntoY="+puntoY+"&mostrar="+mostrar+"&mapaId="+mapaId+"&mapaImgNombre="+mapaImgNombre+"&tipmapId="+tipmapId+"&tipId="+tipId;
  
  _url="ajaxCanton.php?";
  
  _objetus.open("POST",_url+_valuesSend,true);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  document.getElementById("divValor").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

// para utilizar con eventos de canton
function pasaVariablesCanton()
{
  var puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId,provId;
  
  puntoX=document.form1.puntoX.value;
  puntoY=document.form1.puntoY.value;
  mostrar="1";  
  mapaId=document.form1.mapaId.value;
  mapaImgNombre=document.form1.mapaImgNombre.value;
  tipmapId=document.form1.tipmapId.value;
  tipId="";
  provId=document.form1.provincia.options[document.form1.provincia.selectedIndex].value;
  
  //alert(puntoX+","+puntoY+","+mostrar+","+mapaId+","+mapaImgNombre+","+tipmapId+","+tipId+","+provId);
  ajaxCanton1(puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId,provId);
}

function ajaxCanton1(puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId,provId)
{
  _objetus = objetus();
  
  _valuesSend="&puntoX="+puntoX+"&puntoY="+puntoY+"&mostrar="+mostrar+"&mapaId="+mapaId+"&mapaImgNombre="+mapaImgNombre+"&tipmapId="+tipmapId+"&tipId="+tipId+"&provId="+provId;
  
  _url="ajaxCanton.php?";
  
  _objetus.open("POST",_url+_valuesSend,true);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  document.getElementById("divValor").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

function ajaxParroquia(puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId)
{
  _objetus = objetus();
  
  _valuesSend="&puntoX="+puntoX+"&puntoY="+puntoY+"&mostrar="+mostrar+"&mapaId="+mapaId+"&mapaImgNombre="+mapaImgNombre+"&tipmapId="+tipmapId+"&tipId="+tipId;
  
  _url="ajaxParroquia.php?";
  
  _objetus.open("POST",_url+_valuesSend,true);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  document.getElementById("divValor").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

// para utilizar con eventos de Parroquia
function pasaVariablesCantonParroquia(desde)
{
  var puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId,provId;
  
  puntoX=document.form1.puntoX.value;
  puntoY=document.form1.puntoY.value;
  mostrar="1";  
  mapaId=document.form1.mapaId.value;
  mapaImgNombre=document.form1.mapaImgNombre.value;
  tipmapId=document.form1.tipmapId.value;
  tipId="";
  
  provId=document.form1.provincia.options[document.form1.provincia.selectedIndex].value;
  canId=document.form1.canton.options[document.form1.canton.selectedIndex].value;
  parrId=document.form1.parroquia.options[document.form1.parroquia.selectedIndex].value;
  
  switch(desde)
  {
    case "pro":
      canId="0";
      parrId="0";
    break;
    case "can":
      parrId="0";
    break;
  }
  //alert(puntoX+","+puntoY+","+mostrar+","+mapaId+","+mapaImgNombre+","+tipmapId+","+tipId+","+provId+","+canId+","+parrId);
  ajaxParroquia1(puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId,provId,canId,parrId);
}

function ajaxParroquia1(puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId,provId,canId,parrId)
{
  _objetus = objetus();
  
  _valuesSend="&puntoX="+puntoX+"&puntoY="+puntoY+"&mostrar="+mostrar+"&mapaId="+mapaId+"&mapaImgNombre="+mapaImgNombre+"&tipmapId="+tipmapId+"&tipId="+tipId+"&provId="+provId+"&canId="+canId+"&parrId="+parrId;
  
  _url="ajaxParroquia.php?";
  
  _objetus.open("POST",_url+_valuesSend,true);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  document.getElementById("divValor").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

function ajaxUTD(puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId)
{
  _objetus = objetus();
  
  _valuesSend="&puntoX="+puntoX+"&puntoY="+puntoY+"&mostrar="+mostrar+"&mapaId="+mapaId+"&mapaImgNombre="+mapaImgNombre+"&tipmapId="+tipmapId+"&tipId="+tipId;
  
  _url="ajaxUtd.php?";
  
  _objetus.open("POST",_url+_valuesSend,true);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  document.getElementById("divValor").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

function ajaxCoordinacion(puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId)
{
  _objetus = objetus();
  
  _valuesSend="&puntoX="+puntoX+"&puntoY="+puntoY+"&mostrar="+mostrar+"&mapaId="+mapaId+"&mapaImgNombre="+mapaImgNombre+"&tipmapId="+tipmapId+"&tipId="+tipId;
  
  _url="ajaxCoordinacion.php?";
  
  _objetus.open("POST",_url+_valuesSend,true);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  //window.alert(_objetus.responseText);
	  document.getElementById("divValor").innerHTML=_objetus.responseText;
	}
  }  
  _objetus.send(null);
}

// para utilizar con eventos de coordinacion
function pasaVariablesCoordinacion()
{
  var puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId,utdId;
  
  puntoX=document.form1.puntoX.value;
  puntoY=document.form1.puntoY.value;
  mostrar="1";  
  mapaId=document.form1.mapaId.value;
  mapaImgNombre=document.form1.mapaImgNombre.value;
  tipmapId=document.form1.tipmapId.value;
  tipId="";
  utdId=document.form1.utd.options[document.form1.utd.selectedIndex].value;
  
  //alert(puntoX+","+puntoY+","+mostrar+","+mapaId+","+mapaImgNombre+","+tipmapId+","+tipId+","+provId);
  ajaxCoordinacion1(puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId,utdId);
}

function ajaxCoordinacion1(puntoX,puntoY,mostrar,mapaId,mapaImgNombre,tipmapId,tipId,utdId)
{
  _objetus = objetus();
  
  _valuesSend="&puntoX="+puntoX+"&puntoY="+puntoY+"&mostrar="+mostrar+"&mapaId="+mapaId+"&mapaImgNombre="+mapaImgNombre+"&tipmapId="+tipmapId+"&tipId="+tipId+"&utdId="+utdId;
  
  _url="ajaxCoordinacion.php?";
  
  _objetus.open("POST",_url+_valuesSend,true);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  document.getElementById("divValor").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

function validarDataParroquia()
{
  var provId,canId,parrId;
  provId=document.form1.provincia.options[document.form1.provincia.selectedIndex].value;
  canId=document.form1.canton.options[document.form1.canton.selectedIndex].value;
  parrId=document.form1.parroquia.options[document.form1.parroquia.selectedIndex].value;
  
  var res=0;
  if(provId==0)
    res=1;
  if(canId==0)
    res=1;
  if(parrId==0)
    res=1;
    
  if(res==1)
    alert("Error: Favor ingrese todos los datos!!!");
  else
  {
    //alert("submit");
    document.form1.submit();
  }
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
<script type="text/javascript" src="../js/wz_tooltip.js"></script>

	
<table width="90%" border="1">
  <tr>
    <td colspan="2" class="workareaAdmin">Mapa: <?=$obj->map_nombre?></td>
  </tr>
  <tr>
  <?php
    $oTipoMapa->info($obj->tipmap_id);
    $oTipo->info($obj->tip_id);
  ?>
    <td>
	  Tipo de Mapa: <?=$oTipoMapa->tipmap_nombre?> <br>
	  Orden: <?=$oTipo->tip_orden?> <br>
	  <br>
	</td>
	<td align="left">
	  <table width="100%" border="0">
        <tr>
          <td colspan="2">
		    <p>Opciones:</p>
            <p>Escoja la imagen y arrastrela hasta el mapa. </p>
		  </td>
        </tr>
        <!--
        <tr>
          <td width="18%" align="center">
		    <img src="../icono/provincia.jpg" name="iProvincia" id="iProvincia" class="dragme"/>
		  </td>
		  <td width="82%">Provincia</td>
        </tr>
        -->
        <?php
          echo($oTipo->opcionImg($obj->tipmap_id));
        ?>
      </table>
	</td>
  </tr>
  <tr>
    <td width="25%">
	  <div id="divValor">&nbsp;</div>
    </td>
    <!-- mapa -->
	<td align="center">
	  <div id="ImageEditorImage"></div>
	  <?=$obj->buildAdminMapa($id)?>
	</td>
	<!-- fin mapa -->
  </tr>
  
</table>	
	

</body>
</html>
