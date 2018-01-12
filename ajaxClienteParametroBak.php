<?php
header("Content-Type: text/plain");
include_once("includes/mainClient.php");
include_once("class/cIndicador.php");
include_once("class/cMapa.php");

extract($_REQUEST);

if((isset($indicador))&&(!isset($parametro)))
{
  if($indicador==0)
  {
  	$cad=<<<mya
<option value="0">Escoja...</option>
mya;
  }
  else 
  {
	  $oInd=new cIndicador($conn);
	  
	  //construir el html de parametro
	  $cad="";
	  //parametro x indicador
	  $rsParxInd=$conn->execute($oInd->sqlClienteParametroxIndicador($indicador));
	  $aux=<<<mya
<option value="0">Escoja...</option>
mya;
	
	  $cad.=$aux;
	
	  while(!$rsParxInd->EOF)
	  {
	  	$parId=$rsParxInd->fields[1];
	  	$parNombre=$rsParxInd->fields[2];
	  	$parPage=$rsParxInd->fields[3];
	  	$parParametro=$rsParxInd->fields[4];
	  	
	  	$aux=<<<mya
<option value="$parId">$parNombre</option>
mya;
		$cad.=$aux;
	  	
	  	$rsParxInd->next();
	  }
  }
}
elseif ((isset($indicador))&&(isset($parametro))&&(isset($mapa))) //cuando tambien tiene valor $parametro
{
	$oMapa=new cMapa($conn);
	//buscar los valores para actualizar en el mapa
	$cad=$oMapa->buildClientMapa($mapa,$indicador,$parametro);
	//$cad = " $mapa - $indicador - $parametro ";
}
elseif (isset($mapa))
{
	$oMapa=new cMapa($conn);
	//buscar los valores para actualizar en el mapa
	$cad=$oMapa->buildClientMapaOriginal($mapa);
}
else // si mostrar = 0
{
  $cad="";
}
  //$cadAux=htmlspecialchars($cad);
  //echo($cadAux);
  echo isset($cad)?$cad:"";

?>