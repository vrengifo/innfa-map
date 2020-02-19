<?php
  
  $cadClickDel="parametro_del.php";
  $cadClickAdd="self.location='main.php?opcion=parametro_add&principal=".$opcion."'";
  $cadClickUpd="main.php?opcion=parametro_upd&principal=".$opcion;

  $cadHidden=<<<mya
  <input type="hidden" name="opcion" value="$opcion">
mya;

  $tituloTabla="Administrador de Par&aacute;metros";
  
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
    <td colspan="4"><div align="center">
      <p><?=$tituloTabla?></p>
    </div></td>
  </tr>
  <tr>
    <td colspan="4"><div align="center">
      <?=$cadBotonAdd?>
      <?=$cadBotonDel?>
    </div></td>
  </tr>
  <tr>
    <td>Eliminar</td>
    <td>Par&aacute;metro ID </td>
    <td>Par&aacute;metro Descripci&oacute;n </td>
    <td>Modificar</td>
  </tr>
  <?php
    include_once("../class/cParametro.php");
    $obj=new cParametro($conn);
    $rs=$obj->rsAdmin();
    $cont=0;
    while (!$rs->EOF) 
    {
      $uId=$rs->fields[0];
      $uNombre=$rs->fields[1];
	  
      $cadClickUpdUnit=$cadClickUpd."&id=".$uId;
  ?>
  <tr>
    <td><input type="checkbox" name="chk[<?=$cont++?>]" value="<?=$uId?>" /></td>
    <td><?=$uId?></td>
    <td><?=$uNombre?></td>
    <td><a href="<?=$cadClickUpdUnit?>">Click aqu&iacute; </a></td>
  </tr>
  <?php
      $rs->next();
    }
  ?>
    <input type="hidden" name="cuanto" value="<?=$cont?>">
  <tr>
    <td colspan="4"><div align="center">
      <?=$cadBotonAdd?>
      <?=$cadBotonDel?>
    </div></td>
  </tr>
</table>
</form>

