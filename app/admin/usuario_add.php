<?php
  
  $cadClickAdd="usuario_add1.php";
  $cadClickBack="self.location='main.php?opcion=".$principal."'";

  $cadHidden=<<<mya
  <input type="hidden" name="opcion" value="$principal">
mya;

  $tituloTabla="A&ntilde;adir Usuario";
  
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
    <td width="17%">Usuario ID: </td>
    <td width="24%"><label>
      <input name="txtUsuId" type="text" id="txtUsuId">
    </label></td>
    <td width="59%">&nbsp;</td>
  </tr>
  <tr>
    <td>Usuario Clave:</td>
    <td><label>
      <input name="txtUsuClave" type="text" id="txtUsuClave">
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Usuario Nombre:</td>
    <td><label>
      <input name="txtUsuNombre" type="text" id="txtUsuNombre" size="80">
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

