<?php
  
  $cadClickDel="mapa_del.php";
  $cadClickAdd="self.location='main.php?opcion=mapa_add&principal=".$opcion."'";
  $cadClickReset="mapa_reset.php?opcion=".$opcion;
  $cadClickPuntos="puntoMapa.php";

  $cadHidden=<<<mya
  <input type="hidden" name="opcion" value="$opcion">
mya;

  $tituloTabla="Administrador de Mapas";
  
  $cadBotonAdd=<<<mya
  <input name="btnAnadir" type="button" id="btnAnadir" value="A&ntilde;adir" onclick="$cadClickAdd" />
mya;

  $cadBotonDel=<<<mya
  <input name="btnEliminar" type="submit" id="btnEliminar" value="Eliminar" />
mya;

?>
<form method="POST" action="<?=$cadClickDel?>" name="form1">
<?=$cadHidden?>
<table width="100%" border="1">
  <tr>
    <td colspan="8"><div align="center">
      <p><?=$tituloTabla?></p>
    </div></td>
  </tr>
  <tr>
    <td colspan="8"><div align="center">
      <?=$cadBotonAdd?>
      <?=$cadBotonDel?>
    </div></td>
  </tr>
  <tr>
    <td width="11%">Eliminar</td>
    <td width="16%">Tipo Mapa</td>
    <td width="25%">Mapa </td>
	<td width="5%">Orden </td>
	<td width="10%">Tipo </td>
	<td width="12%">De </td>
	<td width="11%">Ubicar Puntos</td>
    <td width="10%">Resetear Mapa</td>
  </tr>
  <?php
	
	include_once("../class/cMapa.php");
    $obj=new cMapa($conn);
    $rs=$obj->rsAdmin();
    $cont=0;
    while (!$rs->EOF) 
    {
      $uId=$rs->fields[0];
      $uTipmap=$rs->fields[1];
	  $uNombre=$rs->fields[2];
	  $uOrden=$rs->fields[3];
	  $uMapImagen=$rs->fields[4];
	  $uProvid=$rs->fields[5];
	  $uCanid=$rs->fields[6];
	  $uParrid=$rs->fields[7];
	  $uUtdid=$rs->fields[8];
	  $uCoordid=$rs->fields[9];
	  $uTipid=$rs->fields[10];
	  $umapImgEdit=$rs->fields[11];
      
      $cadClickResetUnit=$cadClickReset."&id=".$uId;
	  $cadClickPuntosUnit=$cadClickPuntos."?id=".$uId."&imageName=".$umapImgEdit;
	  
	  $img=$uMapImagen;

  ?>
  <tr>
    <td><input type="checkbox" name="chk[<?=$cont++?>]" value="<?=$uId?>" /></td>
    <td><?=$uTipmap?></td>
    <td>
      <img src="../<?=$img?>" alt="<?=$uNombre?>" width="100" height="100" />
      &nbsp;&nbsp;<?=$uNombre?>
    </td>
	<td><?=$uOrden?></td>
	<td><?=$uTipid?></td>
	<td><?="de";?></td>
	<td><a href="#" onclick='abrirVentana("<?=$cadClickPuntosUnit?>");'>Click aqu&iacute; </a></td>
    <!--
    <td><a href="<?=$cadClickUpdUnit?>">Click aqu&iacute; </a></td>
    -->
    <td><a href="<?=$cadClickResetUnit?>">Click para Resetear</a></td>
  </tr>
  <?php
      $rs->next();
    }
  ?>
    <input type="hidden" name="cuanto" value="<?=$cont?>">
  <tr>
    <td colspan="8"><div align="center">
      <?=$cadBotonAdd?>
      <?=$cadBotonDel?>
    </div></td>
  </tr>
</table>
</form>

