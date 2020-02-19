<html xmlns="http://www.w3.org/1999/xhtml"><head>


<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type"/><title>INNFA - Cliente Mapa</title>

<link type="text/css" rel="stylesheet" href="estilo/estilos.css"/>

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
  ajaxCargaMapa(document.form1.hMapa.value);  
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

  _valuesSend="&indicador="+indicador+"&opcion=loadpar";
  
  //alert(_valuesSend);
  
  _url="ajaxClienteParametro.php?";
  
  _objetus.open("POST",_url+_valuesSend,false);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  //alert(_objetus.responseText);
	  document.getElementById("tParametro").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

function ajaxCargaParametro1(mapa,indicador,parametro)
{
  _objetus = objetus();
  
  _valuesSend="&mapa="+mapa+"&indicador="+indicador+"&parametro="+parametro+"&opcion=loaddata";
  
  _url="ajaxClienteParametro.php?";
  
  _objetus.open("POST",_url+_valuesSend,false);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  document.getElementById("contenidoMapa").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

function ajaxCargaMapa(mapa)
{
  _objetus = objetus();
  
  _valuesSend="&mapa="+mapa;
  
  _url="ajaxClienteParametro.php?";
  
  _objetus.open("POST",_url+_valuesSend,true);
  
  _objetus.onreadystatechange=function(){
    if(_objetus.readyState==4)
	{
	  //alert(_objetus.responseText);
	  document.getElementById("contenidoMapa").innerHTML=_objetus.responseText;
	}
  }
  _objetus.send(null);
}

</script><link rel="stylesheet" type="text/css" href="chrome://firebug/content/highlighter.css"/></head><body onload="jsIndicador();">
hMapa=5 --- visualizaPor= <br/>
<script src="js/wz_tooltip.js" type="text/javascript"/><div id="WzTtDiV" style="padding: 0px; overflow: hidden; position: absolute; width: 1279px; visibility: hidden; left: -1280px; top: 346px; z-index: 1010;"/>
<form action="clienteMapa.php" method="post" name="form1" id="form1">
<input type="hidden" value="" name="hIndicador"/>
<input type="hidden" value="" name="hParametro"/>
<input type="hidden" value="" name="hPagina"/>
<input type="hidden" value="" name="hPaginaParametro"/>

<input type="hidden" value="5" name="hMapa"/>
<input type="hidden" value="" name="hClickPunto"/>
  
  <table width="90%" border="1">
    <tbody><tr>
      <td> </td>
      <td> </td>
    </tr>
    <tr>
      <td>		
		  <table width="250" border="0" align="left">
		    <tbody><tr>
			  <td width="31%">Visualizar Por:</td>
			  <td width="69%">
			    <select onchange="submit();" name="visualizaPor">
	        		    <option selected="" value="1">
	        Geografia	        </option>
	        		    <option value="2">
	        Innfa	        </option>
	          
	        </select>
			  </td>
			</tr>
			<!-- inicio indicador parametro -->
			<tr>
			  <td>Indicador: </td>
			  <td>
			    <select onchange="jsIndicador();" id="tIndicador" name="tIndicador">
				  <option value="0">Escoja ...</option>
				  				  <option value="1">Prueba</option>
				  				  <option value="2">Prueba2</option>
				  				  <option value="3">Prueba3</option>
				  				  <option value="4">Prueba4</option>
				  				</select>
			  </td>
			</tr>
			<tr>
			  <td>Parametro: </td>
			  <td>
			    <select onchange="jsParametro();" id="tParametro" name="tParametro">	<option value="0">Escoja...</option>	<option value="1">Parm1</option>	<option value="2">Parm2</option>	<option value="3">Parm3</option></select>
			  </td>
			</tr>
	    </tbody></table>
		  <!-- fin indicador parametro -->
	  </td>
      <td>Opciones:
        <input type="button" value="Mostrar Informacion" name="bMostrar"/>
		 || 
		<input type="button" value="Subir nivel" name="bSubirNivel"/>
		 || 
		<input type="button" onclick="window.close();" value="Cerrar" name="bCerrar"/>
		 ||  
	  </td>
    </tr>
  </tbody></table>
  
  
  <table width="90%" border="1">    
	<tbody><tr>      
      <td align="center" colspan="2">
	    <div id="contenidoMapa">  		<map name="mapa">
  		    	  <area onmouseover="Tip('100.00', WIDTH, 80, FADEIN, 500, FADEOUT, 500, OPACITY,80,SHADOW,true,TITLE,'MANABI')" onclick="hacerSubmit('0');" href="#" coords="98,213,20" shape="circle" id="_1:5:98:213"/>  	  <area onmouseover="Tip('100.00', WIDTH, 80, FADEIN, 500, FADEOUT, 500, OPACITY,80,SHADOW,true,TITLE,'PICHINCHA')" onclick="hacerSubmit('8');" href="#" coords="161,188,20" shape="circle" id="_1:5:161:188"/>  	  <area onmouseover="Tip('100.00', WIDTH, 80, FADEIN, 500, FADEOUT, 500, OPACITY,80,SHADOW,true,TITLE,'QUITO')" onclick="hacerSubmit('');" href="#" coords="213,188,20" shape="circle" id="_1:5:213:188"/>  	  <area onmouseover="Tip('100.00', WIDTH, 80, FADEIN, 500, FADEOUT, 500, OPACITY,80,SHADOW,true,TITLE,'SAN BARTOLO')" onclick="hacerSubmit('');" href="#" coords="229,172,20" shape="circle" id="_1:5:229:172"/>
  		</map>	</div>
	    <img border="0" usemap="#mapa" src="mapaPunto/5_1.jpg"/>
	  </td>
    </tr>
  </tbody></table>
</form>
</body></html>