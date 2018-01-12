<?php
  session_start();
  
  if(!session_is_registered("sUsuId"))
  {
      header("location:logout.php?msg=Sesion Expirada");
  }
  
  include_once("../includes/main.php");
  include_once("../class/cParametro.php");
  
  extract($_REQUEST);
  
  $obj=new cParametro($conn);
  
  $obj->par_nombre=$txtNombre;
  
  $obj->add();
  
  if(strlen($obj->msg)==0)
  {
      $destino="main.php?opcion=".$opcion;
  }
  else 
  {
      $destino="main.php?opcion=".$opcion;
  }
  
  $destino="main.php?opcion=".$opcion;
  header("location:".$destino);
?>