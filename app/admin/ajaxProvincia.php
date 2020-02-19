<?php
header("Content-Type: text/plain");
include_once("../includes/main.php");
include_once("../class/cGeografia.php");

extract($_REQUEST);

if($mostrar)
{

$obj=new cGeografia($conn);

$rs=$obj->rsSelectProvincia();
$cadDet="";
while(!$rs->EOF)
{
  $valor=$rs->fields[0];
  $texto=$rs->fields[1];
  
  $aux=<<<vars
  <option value="$valor">$texto</option>
vars;
  $cadDet.=$aux;
  $rs->next();
}

$cad=<<<mya
<form id='form1' name='form1' method='post' action='ajaxProvincia1.php'>
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
	  <select name="provincia">
	    <option value="0">Escoja...</option>
		$cadDet
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
}//fin de mostrar
else // si mostrar = 0
{
  $cad="&nbsp;";
}
//$cadAux=htmlspecialchars($cad);
//echo($cadAux);
echo isset($cad)?$cad:"&nbsp;";

?>