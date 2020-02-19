<?php
header("Content-Type: text/plain");
include_once("includes/mainClient.php");
include_once("class/cIndicador.php");
include_once("class/cMapa.php");

extract($_REQUEST);

switch ($opcion)
{
	case "loadpar": // recibe indicador
	  if($indicador==0)
	  {
	  	$cad=<<<mya
<select name="tParametro" id="tParametro" onChange="jsParametro();">
<option value="0">Escoja...</option>
</select>
mya;
	  }
	  else 
	  {
		  //$conn->debug=true;
	  	  $oInd=new cIndicador($conn);
		  
		  //construir el html de parametro
		  $cad="";
		  //parametro x indicador
		  $rsParxInd=$conn->execute($oInd->sqlClienteParametroxIndicador($indicador));
		  $aux=<<<mya
<select name="tParametro" id="tParametro" onChange="jsParametro();">
<option value="0">Escoja...</option>
mya;
		
		  $cad.=$aux;
		
		  //$cadPage="";
		  
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
			//$cadPage.=$parPage.":";
			
		  	$rsParxInd->next();
		  }
		  $cad.="</select>";
		  
		  /*$cadPage=substr($cadPage,0,(strlen($cadPage)-1));
		  $ocultoPage=<<<mya
	<input type="hidden" name="hPage" value="$cadPage" />		  
mya;
		  $cad.=$ocultoPage;*/
	  }
	  $oMapa=new cMapa($conn);
	  //buscar los valores para actualizar en el mapa
	  $cadMapa=$oMapa->buildClientMapaOriginal($mapa);	
	  $cad.=$cadMapa;
	break;;
	case "loaddata":
		
		$oInd=new cIndicador($conn);
		  
		  //construir el html de parametro
		  $cad="";
		  //parametro x indicador
		  $rsParxInd=$conn->execute($oInd->sqlClienteParametroxIndicador($indicador));
		  $aux=<<<mya
<select name="tParametro" id="tParametro" onChange="jsParametro();">
<option value="0">Escoja...</option>
mya;
		
		  $cad.=$aux;
		
		  while(!$rsParxInd->EOF)
		  {
		  	$parId=$rsParxInd->fields[1];
		  	$parNombre=$rsParxInd->fields[2];
		  	$parPage=$rsParxInd->fields[3];
		  	$parParametro=$rsParxInd->fields[4];
		  	
		  	if($parId==$parametro)
		  	{
		  	  $cadSelected=" selected ";
		  	  $cadPage=<<<mya
	<input type="hidden" name="hPage" value="$parPage" />	  	  
mya;
		  	}
		  	else 
		  	  $cadSelected="";  
		  	
		  	$aux=<<<mya
<option value="$parId" $cadSelected>$parNombre</option>
mya;
			$cad.=$aux;
			
		  	$rsParxInd->next();
		  }
		  $cad.="</select>";
		  $cad.=$cadPage;
		
		
		$oMapa=new cMapa($conn);
		//buscar los valores para actualizar en el mapa
		$cad.=$oMapa->buildClientMapa($mapa,$indicador,$parametro);
	break;;
	/*default:
		$oMapa=new cMapa($conn);
		//buscar los valores para actualizar en el mapa
		$cad=$oMapa->buildClientMapaOriginal($mapa);
	break;;	*/
}
  echo isset($cad)?$cad:"";

?>