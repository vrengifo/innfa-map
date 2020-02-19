<?php
header("Content-Type: text/plain");
include_once("../includes/main.php");
include_once("../class/cIndicador.php");
include_once("../class/cMapa.php");

include_once("../class/cGeografia.php");
include_once("../class/cInnfa.php");

extract($_REQUEST);

switch ($opcion)
{
	case "geo": // enviar informacion para cargar solo geografia
	
	//select Provincia
	if($provincia==0)
	  $selected=" selected ";
	else 
	  $selected="";  
	$cadProvincia='<option value="0" '.$selected.' >Todas</option>';
	$objTM=new cGeografia($conn);
	$rs=$objTM->rsSelectProvincia();
	$selected="";
	while(!$rs->EOF)
	{
	  $valor=$rs->fields[0];
	  $nombre=$rs->fields[1];
	  
	  if($valor==$provincia)
	    $selected=" selected ";
	  else 
	    $selected="";  
	  
	  $cadProvincia.='<option value="'.$valor.'" '.$selected.'>'.$nombre.'</option>';
	  $rs->next();  
	}
	$auxProvincia=<<<mya
  <tr>
    <td> &nbsp;&nbsp;&nbsp; Provincia: </td>
    <td>
	  <select name="selProv" id="selProv" onChange="jsTipoMapa();">
	    $cadProvincia
	  </select>
    </td>
    <td>&nbsp;</td>
  </tr>	
mya;

	//select Canton
	if($canton==0)
	  $selected=" selected ";
	else 
	  $selected="";
	  
	$cadCanton='<option value="0" '.$selected.' >Todas</option>';
	
	if($provincia!=0)
	{
	  $rs=$objTM->rsSelectCantonxProv($provincia);
	  $selected="";
	  while(!$rs->EOF)
	  {
	    $valor=$rs->fields[0];
	    $nombre=$rs->fields[1];
	  
	    if($valor==$canton)
		  $selected=" selected ";		    		  	
		else 
		  $selected="";  
	    
	    $cadCanton.='<option value="'.$valor.'" '.$selected.'>'.$nombre.'</option>';
	    $rs->next();
	  }
	}
	else 
	{
		$cadCanton.='<option value="0" >Escoja Provincia...</option>';
	}
	
	$auxCanton=<<<mya
  <tr>
    <td> &nbsp;&nbsp;&nbsp; Canton: </td>
    <td>
	  <select name="selCanton" id="selCanton" onChange="jsTipoMapa();">
	    $cadCanton
	  </select>
    </td>
    <td>&nbsp;</td>
  </tr>	
mya;

	//select Parroquia
	if($parroquia==0)
	  $selected=" selected ";
	else 
	  $selected="";
	  
	$cadParroquia='<option value="0" '.$selected.' >Todas</option>';
	
	if($canton!=0)
	{
	  $rs=$objTM->rsSelectParroquiaxCan($canton);
	  $selected="";
	  while(!$rs->EOF)
	  {
	    $valor=$rs->fields[0];
	    $nombre=$rs->fields[1];
	  
	    if($valor==$parroquia)
		  $selected=" selected ";		    		  	
		else 
		  $selected="";  
	    
	    $cadParroquia.='<option value="'.$valor.'" '.$selected.'>'.$nombre.'</option>';
	    $rs->next();
	  }
	}
	else 
	{
		$cadCanton.='<option value="0" >Escoja Canton...</option>';
	}
	
	$auxParroquia=<<<mya
  <tr>
    <td> &nbsp;&nbsp;&nbsp; Canton: </td>
    <td>
	  <select name="selParr" id="selParr">
	    $cadParroquia
	  </select>
    </td>
    <td>&nbsp;</td>
  </tr>	
mya;
	
	//cadena de toda la info de geografia
	$cad=<<<mya
  <table width="100%">
  <tr>
    <td colspan="3">Por Geografia: </td>
  </tr>
$auxProvincia	
$auxCanton
$auxParroquia
  </table>
  <input type="hidden" name="selUTD" value="0" />
  <input type="hidden" name="selCoord" value="0" />
mya;

	break;;
	
	case "innfa":
		
	//select UTD
	if($utd==0)
	  $selected=" selected ";
	else 
	  $selected="";  
	$cadUtd='<option value="0" '.$selected.' >Todas</option>';
	$objIn=new cInnfa($conn);
	$rs=$objIn->rsSelectUtd();
	$selected="";
	while(!$rs->EOF)
	{
	  $valor=$rs->fields[0];
	  $nombre=$rs->fields[1];
	  
	  if($valor==$utd)
	    $selected=" selected ";
	  else 
	    $selected="";  
	  
	  $cadUtd.='<option value="'.$valor.'" '.$selected.'>'.$nombre.'</option>';
	  $rs->next();  
	}
	$auxUtd=<<<mya
  <tr>
    <td> &nbsp;&nbsp;&nbsp; UTD: </td>
    <td>
	  <select name="selUtd" id="selUtd" onChange="jsTipoMapa();">
	    $cadUtd
	  </select>
    </td>
    <td>&nbsp;</td>
  </tr>	
mya;

	//select Coordinacion
	if($coordinacion==0)
	  $selected=" selected ";
	else 
	  $selected="";
	  
	$cadCoordinacion='<option value="0" '.$selected.' >Todas</option>';
	
	if($utd!=0)
	{
	  $rs=$objIn->rsSelectCoordinacionxUtd($utd);
	  $selected="";
	  while(!$rs->EOF)
	  {
	    $valor=$rs->fields[0];
	    $nombre=$rs->fields[1];
	  
	    if($valor==$coordinacion)
		  $selected=" selected ";		    		  	
		else 
		  $selected="";  
	    
	    $cadCoordinacion.='<option value="'.$valor.'" '.$selected.'>'.$nombre.'</option>';
	    $rs->next();
	  }
	}
	else 
	{
		$cadCoordinacion.='<option value="0" >Escoja UTD...</option>';
	}
	
	$auxCoordinacion=<<<mya
  <tr>
    <td> &nbsp;&nbsp;&nbsp; Coordinacion: </td>
    <td>
	  <select name="selCoord" id="selCoord" onChange="jsTipoMapa();">
	    $cadCoordinacion
	  </select>
    </td>
    <td>&nbsp;</td>
  </tr>	
mya;

	//cadena de toda la info de Innfa
	$cad=<<<mya
  <table width="100%">
  <tr>
    <td colspan="3">Por Estructura INNFA: </td>
  </tr>
$auxUtd	
$auxCoordinacion
  </table>
  <input type="hidden" name="selProv" value="0" />
  <input type="hidden" name="selCanton" value="0" />
  <input type="hidden" name="selParr" value="0" />
mya;
		
	break;;
	default:
		$cad="";
	break;;	
}
  echo isset($cad)?$cad:"";

?>