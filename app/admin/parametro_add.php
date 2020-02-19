<?php
  
  $cadClickAdd="parametro_add1.php";
  $cadClickBack="self.location='main.php?opcion=".$principal."'";

  $cadHidden=<<<mya
  <input type="hidden" name="opcion" value="$principal">
mya;

  $tituloTabla="A&ntilde;adir Par&aacute;metro";
  
  $cadBotonAdd=<<<mya
  <input name="btnAnadir" type="submit" id="btnAnadir" value="A&ntilde;adir" />
mya;

  $cadBotonBack=<<<mya
  <input name="btnRegresar" type="button" id="btnRegresar" value="Regresar" onClick="$cadClickBack" />
mya;

?>
<form method="POST" action="<?=$cadClickAdd?>" name="form1">
<?=$cadHidden?>
<table width="80%" border="0">
  <tr>
    <td colspan="3"><div align="center">
      <?=$tituloTabla?>
    </div></td>
    </tr>
  
  <tr>
    <td>Par&aacute;metro Nombre:</td>
    <td><label>
      <input name="txtNombre" type="text" id="txtNombre">
    </label></td>
    <td>&nbsp;</td>
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

