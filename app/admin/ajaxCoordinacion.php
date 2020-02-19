<?php
header("Content-Type: text/plain");
include_once("../includes/main.php");
include_once("../class/cInnfa.php");

extract($_REQUEST);

if($mostrar)
{

  $obj=new cInnfa($conn);
  //utd
  $rs=$obj->rsSelectUtd();
  $cadDet="";
  while(!$rs->EOF)
  {
    $valor=$rs->fields[0];
    $texto=$rs->fields[1];
    
    if((isset($utdId))&&($valor==$utdId))
    {
      $selectedUtd=" selected ";      
    }
    else 
    {
      $selectedUtd="";      
    }
  
    $aux=<<<vars
    <option value="$valor" $selectedUtd>$texto</option>
vars;
    $cadDet.=$aux;
    $rs->next();
  }
  //coordinacion
  if(isset($utdId))
  {
    $rsCoor=$obj->rsSelectCoordinacionxUtd($utdId);
    $cadDetCoor="";
    while(!$rsCoor->EOF)
    {
      $valor=$rsCoor->fields[0];
      $texto=$rsCoor->fields[1];
    
      $aux=<<<vars
    <option value="$valor" >$texto</option>
vars;
      $cadDetCoor.=$aux;
      $rsCoor->next();
    }
  }
  
  if(!isset($utdId))
  {  
  $cad=<<<mya
<form id='form1' name='form1' method='post' action='ajaxCoordinacion1.php'>
<input type="hidden" name="puntoX" value="$puntoX">
<input type="hidden" name="puntoY" value="$puntoY">
<input type="hidden" name="mapaId" value="$mapaId">
<input type="hidden" name="mapaImgNombre" value="$mapaImgNombre">
<input type="hidden" name="tipmapId" value="$tipmapId">
<input type="hidden" name="tipId" value="$tipId">
<input type="hidden" name="mapaNombre" value="$mapaNombre">
<table width='90%' border='1'>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de UTD </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="utd" onChange="pasaVariablesCoordinacion();">
	    <option value="0">Escoja...</option>
		$cadDet
	  </select>
	</td>
  </tr>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de Coordinación </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="coordinacion" disabled>
	    <option value="0">Escoja...</option>
	  </select>
	</td>
  </tr>
  <tr>
    <td colspan='2'><input name='bGuardar' type='submit' id='bGuardar' value='Guardar' disabled />
      <input name='bCancelar' type='button' id='bCancelar' value='Cancelar' onClick='location.reload();' /></td>
    </tr>
</table>
</form>
mya;
  }
  else //se selecciono una UTD 
  {
    
    $cad=<<<mya
<form id='form1' name='form1' method='post' action='ajaxCoordinacion1.php'>
<input type="hidden" name="puntoX" value="$puntoX">
<input type="hidden" name="puntoY" value="$puntoY">
<input type="hidden" name="mapaId" value="$mapaId">
<input type="hidden" name="mapaImgNombre" value="$mapaImgNombre">
<input type="hidden" name="tipmapId" value="$tipmapId">
<input type="hidden" name="tipId" value="$tipId">
<input type="hidden" name="mapaNombre" value="$mapaNombre">
<table width='90%' border='1'>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de UTD </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="utd"  onChange="pasaVariablesCoordinacion();" >
	    <option value="0">Escoja...</option>
		$cadDet
	  </select>
	</td>
  </tr>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de Coordinación </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="coordinacion" >
	    <option value="0">Escoja...</option>
	    $cadDetCoor
	  </select>
	</td>
  </tr>
  <tr>
    <td colspan='2'><input name='bGuardar' type='submit' id='bGuardar' value='Guardar' />
      <input name='bCancelar' type='button' id='bCancelar' value='Cancelar' onClick='location.reload();' /></td>
    </tr>
</table>
</form>
mya;
      
  }
  
  }//fin de mostrar 
  else // si mostrar = 0
  {
    $cad="&nbsp;";
  }
  //$cadAux=htmlspecialchars($cad);
  //echo($cadAux);
  echo isset($cad)?$cad:"&nbsp;";

?>