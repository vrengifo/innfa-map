<?php
  include_once("includes/mainClient.php");
  include_once("class/cTipomapa.php");
  include_once("class/cMapa.php");
  include_once("class/cIndicador.php");
  include_once("class/cPuntoestructura.php");
  
  extract($_REQUEST);
  
  $oMapa=new cMapa($conn);
  
  if((isset($hClickPunto))&&($hClickPunto=="1")) //click en un punto del mapa
  {
    $hMapa=$hMapa;
  }
  else
  {
	if(isset($bSubirNivel))
	  $hMapa=$oMapa->subirNivel($hMapa);
	elseif(isset($visualizaPor))
    {
      $hMapa=$oMapa->buscaMapaDefecto($visualizaPor);
    }
    else
    {
      $hMapa=$oMapa->buscaMapaDefecto();
    }
  }
  
  if(isset($hMapa)) //recuperar info del mapa seleccionado
  {
  	$oMapa->info($hMapa);
  }
  else //cargar informacion por defecto 
  {
    $hVisualizaPor=1; //Geografia
    $hMapa=$oMapa->buscaMapaDefecto();
    $oMapa->info($hMapa);
    
  }
  $cadImgMapa="mapaPunto/".$oMapa->map_imagenedit;
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>INNFA - Cliente Mapa</title>
<link href="estilo/estilos.css" rel="stylesheet" type="text/css">

<script language="javascript">

function escribirSeleccion()
{
	document.form1.hIndicador.value=document.form1.tIndicador.options[document.form1.tIndicador.selectedIndex].value;
	document.form1.hParametro.value=document.form1.tIndicador.options[document.form1.tIndicador.selectedIndex].value;
	
	alert(document.form1.hIndicador.value+"-"+document.form1.hParametro.value);
}

function hacerSubmit(hId)
{
	if(hId!=0)
	{
	  document.form1.hMapa.value=hId;
	  document.form1.hClickPunto.value="1";
	  //alert(document.form1.hMapa.value);
	  document.form1.submit();
	}
	else
	{
		alert("Lo sentimos, no existe mapa para su seleccion");
	}
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

function jsIndicador()
{
  var valor;
  
  valor=document.form1.tIndicador.options[document.form1.tIndicador.selectedIndex].value;
  
  //alert("jsIndicador.valor:"+valor);

  ajaxCargaParametro(valor);
  //alert(document.form1.hMapa.value);
  //ajaxCargaMapa(document.form1.hMapa.value);  
}

function jsParametro()
{
  var valor;
  
  valor=document.form1.tParametro.options[document.form1.tParametro.selectedIndex].value;

  if(valor!=0)
  {
    var vIndicador;
	vIndicador=document.form1.tIndicador.options[document.form1.tIndicador.selectedIndex].value;
	
	var vMapa;
	vMapa=document.form1.hMapa.value;
	
	//alert(vMapa+" - "+vIndicador+" - "+valor);
    ajaxCargaParametro1(vMapa,vIndicador,valor);  
  }

}

function ajaxCargaParametro(indicador)
{
  _objetus = objetus();
  
  vMapa=document.form1.hMapa.value;

  _valuesSend="&mapa="+vMapa+"&indicador="+indicador+"&opcion=loadpar";
  
  //alert(_valuesSend);
  
  _url="ajaxClienteParametro.php?";
  
  _objetus.open("POST",_url+_valuesSend,true);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  //alert(_objetus.responseText);
	  //document.getElementById("tParametro").innerHTML=_objetus.responseText;
	  document.getElementById("celdaParametro").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

function ajaxCargaParametro1(mapa,indicador,parametro)
{
  _objetus = objetus();
  
  _valuesSend="&mapa="+mapa+"&indicador="+indicador+"&parametro="+parametro+"&opcion=loaddata";
  
  _url="ajaxClienteParametro.php?";
  
  _objetus.open("POST",_url+_valuesSend,true);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  //document.getElementById("contenidoMapa").innerHTML=_objetus.responseText;
	  document.getElementById("celdaParametro").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

function ajaxCargaMapa(mapa)
{
  _objetus = objetus();
  
  _valuesSend="&mapa="+mapa;
  
  _url="ajaxClienteParametro.php?";
  
  _objetus.open("POST",_url+_valuesSend,false);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  //alert(_objetus.responseText);
	  document.getElementById("contenidoMapa").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

//mostrar informacion
function mostrarInformacion()
{
  var destino;
  
  var pagina;
  var indicador;
  var parametro;
  var tipomapa;
  var tipId;
  var provincia;
  var canton;
  var parroquia;
  var utd;
  var coordinacion;

  parametro=document.form1.tParametro.options[document.form1.tParametro.selectedIndex].value;
  
  if(parametro!=0)
  {
    pagina=document.form1.hPage.value;
    indicador=document.form1.tIndicador.options[document.form1.tIndicador.selectedIndex].value;
    parametro=document.form1.tParametro.options[document.form1.tParametro.selectedIndex].value;
    tipomapa=document.form1.visualizaPor.options[document.form1.visualizaPor.selectedIndex].value;
  
    tipId=document.form1.hTipId.value;
    provincia=document.form1.hProvId.value;
    canton=document.form1.hCanId.value;
    parroquia=document.form1.hParrId.value;
    utd=document.form1.hUtdId.value;  
    coordinacion=document.form1.hCoordId.value;
  
    destino=pagina+"?tipomapa="+tipomapa+"&tipid="+tipId+"&indicador="+indicador+"&parametro="+parametro+"&provincia="+provincia+"&canton="+canton+"&parroquia="+parroquia+"&utd="+utd+"&coordinacion="+coordinacion;
    //alert(destino);  
    openWindow(destino,"Informacion","640","480");
  }
  else
  {
    alert("Favor escoja Parametro.");
  }
}

function openWindow(vurl,vtitle,vwidth,vheight) 
{
 var cad;
 cad='width=' + vwidth + ',height=' + vheight + ',resizable=1,scrollbars=1,toolbar=0,menubar=0,location=0';
 //alert (vurl);
 //alert (vtitle);
 //alert (cad);
 window.open(vurl,vtitle,cad);
}

</script>

</head>

<body onload="jsIndicador();">
<script type="text/javascript" src="js/wz_tooltip.js"></script>
<form id="form1" name="form1" method="post" action="clienteMapa.php">
<input type="hidden" name="hMapa" value="<?=$hMapa?>" />
<input type="hidden" name="hClickPunto" value="" />

<input type="hidden" name="hTipId" value="<?=$oMapa->tip_id?>">
<input type="hidden" name="hProvId" value="<?=$oMapa->prov_id?>">
<input type="hidden" name="hCanId" value="<?=$oMapa->can_id?>">
<input type="hidden" name="hParrId" value="<?=$oMapa->parr_id?>">
<input type="hidden" name="hUtdId" value="<?=$oMapa->utd_id?>">
<input type="hidden" name="hCoordId" value="<?=$oMapa->coord_id?>">
  
  <table width="90%" border="1">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>		
		  <table border="0" width="250" align="left">
		    <tr>
			  <td width="31%">Visualizar Por:</td>
			  <td width="69%">
			    <select name="visualizaPor" onchange="submit();">
	        <?php
		  $oTipoMapa=new cTipomapa($conn);
		  $rsTM=$oTipoMapa->rsSelect();
		  while(!$rsTM->EOF)
		  {
		    $valor=$rsTM->fields[0];
			$texto=$rsTM->fields[1];
			
			$cadSelected="";
			
			if($valor==$oMapa->tipmap_id)
			  $cadSelected=" selected ";
		?>
		    <option value="<?=$valor?>" <?=$cadSelected?>>
	        <?=$texto?>
	        </option>
	        <?php
		    $rsTM->next();
		  }
		?>  
	        </select>
			  </td>
			</tr>
			<!-- inicio indicador parametro -->
			<tr>
			  <td>Indicador: </td>
			  <td>
			    <select name="tIndicador" id="tIndicador" onChange="jsIndicador();">
				  <option value="0">Escoja ...</option>
				  <?php
				    $oInd=new cIndicador($conn);
					$rsInd=$conn->execute($oInd->sqlClienteIndicador());
					
					while(!$rsInd->EOF)
					{
					  $valor=$rsInd->fields[0];
					  $texto=$rsInd->fields[1];  
					  
					  $cadSelected="";
					  
					  if((isset($tIndicador))&&($tIndicador==$valor))
					    $cadSelected=" selected ";
						
				  ?>
				  <option value="<?=$valor?>" <?=$cadSelected?>><?=$texto?></option>
				  <?php
				      $rsInd->next();
					}  
				  ?>
				</select>
			  </td>
			</tr>
			<tr>
			  <td>Parametro: </td>
			  <td id="celdaParametro">
			    
			  </td>
			</tr>
	    </table>
		  <!-- fin indicador parametro -->
	  </td>
      <td>Opciones:
        <input type="button" name="bMostrar" value="Mostrar Informacion" onclick="mostrarInformacion();" />
		&nbsp;||&nbsp;
		<input type="submit" name="bSubirNivel" value="Subir nivel" />
		&nbsp;||&nbsp;
		<input type="button" name="bCerrar" value="Cerrar" onclick="window.close();" />
		&nbsp;||&nbsp; 
	  </td>
    </tr>
  </table>
  
  
  <table width="90%" border="1">    
	<tr>      
      <td colspan="2" align="center">
	    <img src="<?=$cadImgMapa?>" border="0" usemap="#mapa"/>
	  </td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
  $conn->close();
?>