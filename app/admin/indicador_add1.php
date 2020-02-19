<?php
  session_start();
  
  if(!session_is_registered("sUsuId"))
  {
      header("location:logout.php?msg=Sesion Expirada");
  }
  
  include_once("../includes/main.php");
  include_once("../class/cIndicador.php");
  
  extract($_REQUEST);
  
  $obj=new cIndicador($conn);
  
  $obj->indi_nombre=$txtNombre;
  $obj->indi_descripcion=$txtDescripcion;
  
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