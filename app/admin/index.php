<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::Administrador de Mapas::</title>
</head>
<link href="../estilo/estilos.css" rel="stylesheet" type="text/css">
<body>
<form id="form1" name="form1" method="post" action="login.php">
<table width="40%" border="0" align="center" >
  <tr>
    <td colspan="2"><div align="center">
      <p>Administrador de INNFA-MAP </p>
      <p><?=$msg?></p>
    </div></td>
  </tr>
  <tr>
    <td width="50%"><div align="right">Usuario:</div></td>
    <td width="50%">
      <input type="text" name="txtUsuario" value="" />    </td>
  </tr>
  <tr>
    <td><div align="right">Clave:</div></td>
    <td><input type="password" name="txtClave" /></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input name="btnEntrar" type="submit" id="btnEntrar" value="Ingresar" />
    </div></td>
  </tr>
</table>
</form>
</body>
</html>
