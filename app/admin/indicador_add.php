<?php
  
  $cadClickAdd="indicador_add1.php";
  $cadClickBack="self.location='main.php?opcion=".$principal."'";

  $cadHidden=<<<mya
  <input type="hidden" name="opcion" value="$principal">
mya;

  $tituloTabla="A&ntilde;adir Indicador";
  
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
    <td>Indicador Nombre:</td>
    <td><label>
      <input name="txtNombre" type="text" id="txtNombre">
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Indicador Descripci&oacute;n:</td>
    <td><label>
      <input name="txtDescripcion" type="text" id="txtDescripcion" size="80">
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

