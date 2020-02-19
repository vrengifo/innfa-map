<?php
  
  $cadClickAdd="mapa_add1.php";
  $cadClickBack="self.location='main.php?opcion=".$principal."'";

  $cadHidden=<<<mya
  <input type="hidden" name="opcion" value="$principal">
mya;

  $tituloTabla="A&ntilde;adir Mapa";
  
  $cadBotonAdd=<<<mya
  <input name="btnAnadir" type="submit" id="btnAnadir" value="A&ntilde;adir" />
mya;

  $cadBotonBack=<<<mya
  <input name="btnRegresar" type="button" id="btnRegresar" value="Regresar" onClick="$cadClickBack" />
mya;

?>
<script language="javascript">
	
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


	function jsTipoMapa()
	{
	  var tipMap;
	  tipMap=document.form1.selTipmap.options[document.form1.selTipmap.selectedIndex].value;
	  
	  //alert(tipMap);
	  switch(tipMap)
	  {
		case "1": 
		  //alert("Geo");		  
		  ajaxGeografia();
		break;
		case "2": 
		  //alert("Inn");
		  ajaxInnfa();
		  break;
		default:
		  ajaxDefault();  
	  }
	}
	
	function ajaxGeografia()
	{
	  _objetus = objetus();
	  
	  var info=new String();
	  var tam;
	  info=document.getElementById("celdaEstructura").innerHTML;
	  tam=info.length;
	  
	  if(tam>0)
	  {
	    vselProv=document.form1.selProv.options[document.form1.selProv.selectedIndex].value;
	    vselCanton=document.form1.selCanton.options[document.form1.selCanton.selectedIndex].value;
	    vselParr=document.form1.selParr.options[document.form1.selParr.selectedIndex].value;
	  }
	  else
	  {
	    vselProv=0;
		vselCanton=0;
		vselParr=0;
	  }
	
	  _valuesSend="&provincia="+vselProv+"&canton="+vselCanton+"&parroquia="+vselParr+"&opcion=geo";
	  
	  //alert(_valuesSend);
	  
	  _url="ajaxMapaAdd.php?";
	  
	  _objetus.open("POST",_url+_valuesSend,true);
	  
	  _objetus.onreadystatechange=function(){
		if(_objetus.readyState==4)
		{
		  //alert(_objetus.responseText);
		  //document.getElementById("tParametro").innerHTML=_objetus.responseText;
		  document.getElementById("celdaEstructura").innerHTML=_objetus.responseText;
		}
	  }
	  _objetus.send(null);
	}
	
	function ajaxInnfa()
	{
	  _objetus = objetus();
	  
	  var info=new String();
	  var tam;
	  info=document.getElementById("celdaEstructura").innerHTML;
	  tam=info.length;
	  
	  if(tam>0)
	  {
	    vselUtd=document.form1.selUtd.options[document.form1.selUtd.selectedIndex].value;
	    vselCoord=document.form1.selCoord.options[document.form1.selCoord.selectedIndex].value;
	  }
	  else
	  {
	    vselUtd=0;
		vselCoord=0;
	  }
	
	  _valuesSend="&utd="+vselUtd+"&coordinacion="+vselCoord+"&opcion=innfa";
	  
	  //alert(_valuesSend);
	  
	  _url="ajaxMapaAdd.php?";
	  
	  _objetus.open("POST",_url+_valuesSend,true);
	  
	  _objetus.onreadystatechange=function(){
		if(_objetus.readyState==4)
		{
		  //alert(_objetus.responseText);
		  //document.getElementById("tParametro").innerHTML=_objetus.responseText;
		  document.getElementById("celdaEstructura").innerHTML=_objetus.responseText;
		}
	  }
	  _objetus.send(null);
	}
	
	function ajaxDefault()
	{
	  _objetus = objetus();
	  
	  var info=new String();
	  var tam;
	  info=document.getElementById("celdaEstructura").innerHTML;
	  tam=info.length;
	  
	  _valuesSend="&opcion=";
	  
	  //alert(_valuesSend);
	  
	  _url="ajaxMapaAdd.php?";
	  
	  _objetus.open("POST",_url+_valuesSend,true);
	  
	  _objetus.onreadystatechange=function(){
		if(_objetus.readyState==4)
		{
		  //alert(_objetus.responseText);
		  //document.getElementById("tParametro").innerHTML=_objetus.responseText;
		  document.getElementById("celdaEstructura").innerHTML=_objetus.responseText;
		}
	  }
	  _objetus.send(null);
	}
	
</script>
<form action="<?=$cadClickAdd?>" method="POST" enctype="multipart/form-data" name="form1">
<?=$cadHidden?>
<table width="80%" border="0">
  <tr>
    <td colspan="3"><div align="center">
      <?=$tituloTabla?>
    </div></td>
    </tr>
  <tr>
    <td width="17%">Tipo de Mapa: </td>
    <td width="24%"><label>
      <select name="selTipmap" id="selTipmap" onchange="document.getElementById('celdaEstructura').innerHTML='';jsTipoMapa();">
	    <option value="0">Escoja...</option>
	  <?php
	    include_once("../class/cTipomapa.php");
		$objTM=new cTipomapa($conn);
		$rs=$objTM->rsSelect();
		$selected="";
		while(!$rs->EOF)
		{
		  $valor=$rs->fields[0];
		  $nombre=$rs->fields[1];
		  
		  if($valor==$selTipmap)
		    $selected=" selected ";		    		  	
	  ?>
	    <option value="<?=$valor?>" <?=$selected?>><?=$nombre?></option>
	  <?php
	      $rs->next();
		}
	  ?>	
	  </select>
    </label></td>
    <td width="59%">&nbsp;</td>
  </tr>
  <tr>
    <td>Nombre: </td>
    <td><label>
      <input name="txtNombre" type="text" id="txtNombre" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Orden: </td>
    <td><label>
      <input name="txtOrden" type="text" id="txtOrden" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Imagen: </td>
    <td><label>
      <input name="fileImagen" type="file" id="fileImagen" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td colspan="3" id="celdaEstructura"></td>
  </tr>
  
  <tr>
    <td colspan="2"><div align="center">
      <?=$cadBotonAdd?>
      <?=$cadBotonBack?>
    </div></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

