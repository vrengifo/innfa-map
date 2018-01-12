<?php
  session_start();
  
  if(!session_is_registered("sUsuId"))
  {
      header("location:logout.php?msg=Sesion Expirada");
  }
  
  include_once("../includes/main.php");
  include_once("../class/cMapa.php");
  
  //$conn->debug=true;
  extract($_REQUEST);
  $obj=new cMapa($conn);
  $obj->resetearMapa($id);  

  $destino="main.php?opcion=".$opcion;
  header("location:".$destino);
?>