<?php
  extract($_REQUEST);
  
  include_once("../includes/main.php");
  include_once("../class/cIndicador.php");
  //$conn->debug=true;
  $oInd=new cIndicador($conn);
  $oInd->info($ind);
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Innfa-map - Parametro x Indicador</title>
</head>
<link href="../estilo/estilos.css" rel="stylesheet" type="text/css">
<?php
  $cadBoton=<<<mya
  <tr>
    <td colspan="2" align="center">
	  <input type="submit" name="bActualizar" value="Actualizar" />
  &nbsp;&nbsp;
	    <input type="button" name="bCerrar" value="Cerrar" onclick="window.close();" />
	</td>
  </tr>  
mya;

?>

<script language="javascript">
  function chequeaBox(objeto,nro)
  {
    var cad=new String();
	
	cad=objeto.value;
	var aux;
	
	aux="par_"+nro;
	
	cadAux="document.form1."+aux+".checked";
	cadAuxChequeado="document.form1."+aux+".checked=true";
	cadAuxNoChequeado="document.form1."+aux+".checked=false";
	estaChequeado=eval(cadAux);
	
	if((cad.length>0) && (!estaChequeado)) //chequear el objeto par_?
	{
	  eval(cadAuxChequeado);
	}
	if(cad.length<=0)
	{
	  eval(cadAuxNoChequeado);
	}
  }
</script>

<body>
<form id="form1" name="form1" method="post" action="parxind1.php">
<input type="hidden" name="ind" value="<?=$ind?>" />
<table width="70%" border="0">
  <tr>
    <td colspan="2" class="empty">Parametro por Indicador </td>
  </tr>
  <tr>
    <td width="17%">Indicador: </td>
    <td width="83%"><?=$oInd->indi_nombre?></td>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr>
<?=$cadBoton?>
  <tr>
    <td colspan="3">
	  <table width="100%" border="1">
      <tr>
        <td colspan="2" class="tableinside">Escoja los parametros: </td>
      </tr>
      <tr>
	    <td>
		<table border="0" width="100%">
		
	  <tr>
        <td width="4%">
          &nbsp;
        </td>
        <td width="48%">Parametro</td>
		<td width="48%">
		  Pagina
		</td>
      </tr>
      <?php
        include_once("../class/cParametro.php");
        $oPar=new cParametro($conn);
        
        include_once("../class/cParametroxIndicador.php");
        $oParxInd=new cParametroxIndicador($conn);
        
        $rs=$oPar->rsAdmin();
        $cont=0;
        while(!$rs->EOF)
        {
          $parId=$rs->fields[0];
          $parNombre=$rs->fields[1];
          
          $parxindId=$oParxInd->id2cad($ind,$parId);
          
          $existe=$oParxInd->info($parxindId);
          if($existe==0)
          {
          	$parxind="";
          	$pagina="";
          	$checked="";
          }
          else 
          {
          	$parxind=$existe;
          	$pagina=$oParxInd->parxind_page;
          	$checked=" checked ";
          }
      ?>
	  <tr>
        <td width="4%">
          <input type="checkbox" name="par_<?=$cont?>" value="<?=$parId?>" <?=$checked?> />
        </td>
        <td width="96%"><?=$parNombre?></td>
		<td width="96%">
		  <input type="hidden" name="parxindId_<?=$cont?>" value="<?=$parxindId?>" />
		  <input type="hidden" name="parxind_<?=$cont?>" value="<?=$parxind?>" />
		  <input type="text" name="pag_<?=$cont?>" value="<?=$pagina?>" onchange="chequeaBox(this,<?=$cont?>);" />
		</td>
      </tr>
      <?php
          $cont++;
          $rs->next();
        }
      ?>      
	  </table>
	  <input type="hidden" name="cuantos" value="<?=$cont?>" />
	  </td>
	  </tr>
      </table>
	</td>
  </tr>
<?=$cadBoton?>
</table>
</form>
</body>
</html>
