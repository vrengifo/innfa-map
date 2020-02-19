<?php
header("Content-Type: text/plain");
include_once("../includes/main.php");
include_once("../class/cGeografia.php");

extract($_REQUEST);

if($mostrar)
{

  $obj=new cGeografia($conn);
  //provincia
  $rs=$obj->rsSelectProvincia();
  $cadDet="";
  while(!$rs->EOF)
  {
    $valor=$rs->fields[0];
    $texto=$rs->fields[1];
    
    if((isset($provId))&&($valor==$provId))
    {
      $selectedProv=" selected ";      
    }
    else 
    {
      $selectedProv="";      
    }
  
    $aux=<<<vars
    <option value="$valor" $selectedProv>$texto</option>
vars;
    $cadDet.=$aux;
    $rs->next();
  }
  //canton   
  if(isset($provId))
  {
    $rsCan=$obj->rsSelectCantonxProv($provId);
    $cadDetCan="";
    while(!$rsCan->EOF)
    {
      $valor=$rsCan->fields[0];
      $texto=$rsCan->fields[1];
      
      if((isset($canId))&&($canId==$valor))
      {
        $selected=" selected ";
	  }
	  else 
	  {
	    $selected="";
	  }
    
      $aux=<<<vars
    <option value="$valor" $selected >$texto</option>
vars;
      $cadDetCan.=$aux;
      $rsCan->next();
    }
  }
  
  //parroquia   
  if((isset($provId))&&(isset($canId)))
  {
    $rsParr=$obj->rsSelectParroquiaxCan($canId);
    $cadDetParr="";
    while(!$rsParr->EOF)
    {
      $valor=$rsParr->fields[0];
      $texto=$rsParr->fields[1];
    
      $aux=<<<vars
    <option value="$valor" >$texto</option>
vars;
      $cadDetParr.=$aux;
      $rsParr->next();
    }
  }
  
  if(!isset($provId))
  {  
  $cad=<<<mya
<form id='form1' name='form1' method='post' action='ajaxParroquia1.php'>
<input type="hidden" name="puntoX" value="$puntoX">
<input type="hidden" name="puntoY" value="$puntoY">
<input type="hidden" name="mapaId" value="$mapaId">
<input type="hidden" name="mapaImgNombre" value="$mapaImgNombre">
<input type="hidden" name="tipmapId" value="$tipmapId">
<input type="hidden" name="tipId" value="$tipId">
<input type="hidden" name="mapaNombre" value="$mapaNombre">
<table width='90%' border='1'>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de Provincia </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="provincia" onChange="pasaVariablesCantonParroquia();">
	    <option value="0">Escoja...</option>
		$cadDet
	  </select>
	</td>
  </tr>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de Cantón </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="canton" >
	    <option value="0">Escoja...</option>
	  </select>
	</td>
  </tr>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de Parroquia </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="parroquia" >
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
  elseif((isset($provId))&&(!isset($canId))) //se selecciono una provincia 
  {
    $cad=<<<mya
<form id='form1' name='form1' method='post' action='ajaxParroquia1.php'>
<input type="hidden" name="puntoX" value="$puntoX">
<input type="hidden" name="puntoY" value="$puntoY">
<input type="hidden" name="mapaId" value="$mapaId">
<input type="hidden" name="mapaImgNombre" value="$mapaImgNombre">
<input type="hidden" name="tipmapId" value="$tipmapId">
<input type="hidden" name="tipId" value="$tipId">
<input type="hidden" name="mapaNombre" value="$mapaNombre">
<table width='90%' border='1'>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de Provincia </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="provincia"  onChange="pasaVariablesCantonParroquia('pro');" >
	    <option value="0">Escoja...</option>
		$cadDet
	  </select>
	</td>
  </tr>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de Cantón </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="canton" onChange="pasaVariablesCantonParroquia('can');" >
	    <option value="0">Escoja...</option>
	    $cadDetCan
	  </select>
	</td>
  </tr>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de Parroquia </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="parroquia" >
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
  elseif((isset($canId))) //se selecciono un canton 
  {
    $cad=<<<mya
<form id='form1' name='form1' method='post' action='ajaxParroquia1.php'>
<input type="hidden" name="puntoX" value="$puntoX">
<input type="hidden" name="puntoY" value="$puntoY">
<input type="hidden" name="mapaId" value="$mapaId">
<input type="hidden" name="mapaImgNombre" value="$mapaImgNombre">
<input type="hidden" name="tipmapId" value="$tipmapId">
<input type="hidden" name="tipId" value="$tipId">
<input type="hidden" name="mapaNombre" value="$mapaNombre">
<table width='90%' border='1'>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de Provincia </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="provincia"  onChange="pasaVariablesCantonParroquia('pro');" >
	    <option value="0">Escoja...</option>
		$cadDet
	  </select>
	</td>
  </tr>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de Cantón </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="canton"  onChange="pasaVariablesCantonParroquia('can');" >
	    <option value="0">Escoja...</option>
	    $cadDetCan
	  </select>
	</td>
  </tr>
  <tr>
    <td colspan='2'>Escoja valor para seleccion de Parroquia </td>
  </tr>
  <tr>
    <td colspan='2'>
	  <select name="parroquia" >
	    <option value="0">Escoja...</option>
	    $cadDetParr
	  </select>
	</td>
  </tr>
  <tr>
    <td colspan='2'>
      <input name='bGuardar' type='button' id='bGuardar' value='Guardar' onClick='validarDataParroquia();' />
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