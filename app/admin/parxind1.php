<?php
  extract($_REQUEST);
  
  include_once("../includes/main.php");
  include_once("../class/cParametroxIndicador.php");
  //$conn->debug=true;
  $oParxInd=new cParametroxIndicador($conn);
  
  //cargar los datos
  for($i=0;$i<$cuantos;$i++)
  {
  	$parxindId="parxindId_".$i;
  	$parxind="parxind_".$i;
  	$par="par_".$i;
  	$pag="pag_".$i;
  	
  	
  	if(isset($$par))
  	{
  		$cadId=$oParxInd->id2cad($ind,$$par);
  		$oParxInd->indi_id=$ind;
  		$oParxInd->par_id=$$par;
  		$oParxInd->parxind_page=$$pag;
  		
  		$oParxInd->create($cadId);
  	}
  	elseif(strlen($$parxind)>0) //verificar si ya esta en base
  	{
  		$oParxInd->del($$parxindId);
  	}
  	
  }
  
  $destino="location:parxind.php?ind=".$ind;
  header($destino);
?>