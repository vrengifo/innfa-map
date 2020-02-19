<?php
  
  extract($_REQUEST);

  include_once("../class/cIndicador.php");
  $obj=new cIndicador($conn);
  
  $obj->info($id);

  $cadClickUpd="indicador_upd1.php";
  $cadClickBack="self.location='main.php?opcion=".$principal."'";

  $cadHidden=<<<mya
  <input type="hidden" name="opcion" value="$principal" />
  <input type="hidden" name="id" value="$id" />
mya;

  $tituloTabla="Actualizar Indicador";
  
  $cadBotonUpd=<<<mya
  <input name="btnActualizar" type="submit" id="btnActualizar" value="Actualizar" />
mya;

  $cadBotonBack=<<<mya
  <input name="btnRegresar" type="button" id="btnRegresar" value="Regresar" onClick="$cadClickBack" />
mya;

?>
<form method="POST" action="<?=$cadClickUpd?>" name="form1">
<?=$cadHidden?>
<table width="80%" border="0">
  <tr>
    <td colspan="3"><div align="center">
      <?=$tituloTabla?>
    </div></td>
    </tr>
  <tr>
    <td width="17%">Indicador ID: </td>
    <td width="24%">
      <?=$obj->indi_id?>
    </td>
    <td width="59%">&nbsp;</td>
  </tr>
  <tr>
    <td>Indicador Nombre:</td>
    <td><label>
      <input name="txtNombre" type="text" id="txtNombre" value="<?=$obj->indi_nombre?>" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Indicador Descripci&oacute;n:</td>
    <td><label>
      <input name="txtDescripcion" type="text" id="txtDescripcion" size="80" value="<?=$obj->indi_descripcion?>" />
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <?=$cadBotonUpd?>
      <?=$cadBotonBack?>
    </div></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

