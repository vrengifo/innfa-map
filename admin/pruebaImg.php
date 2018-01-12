<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>



</head>

<body>
<!-- uno --> 
<script type="text/javascript" src="../dragdropdhtml_files/wz_dragdrop.js"></script>

<p>Prueba:</p>
<p><img name="prov" src="../icono/provincia.gif" width="20" height="20" /></p>
<p><img name="canton" src="../icono/canton.gif" width="20" height="20" /></p>
<p>Prueba 2: </p>
<a class="code" href="javascript:void(0)" onClick="if (window.dd && dd.elements) dd.elements.prov.copy();">copy()</a>

<a class="code" href="javascript:void(0)" onClick="if (window.dd && dd.elements) {dd.getPageXY(); alert(dd.x+' '+dd.y);}">dd.x()</a>

<img name="muckl" src="../dragdropdhtml_files/muckl.jpg" alt="Drag Drop Image" align="left" height="130" width="100">
<!-- dos -->
<script type="text/javascript">
<!--
SET_DHTML("prov", "canton");
//-->
</script>
</body>
</html>
