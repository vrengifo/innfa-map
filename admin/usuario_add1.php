<?php
  session_start();
  
  if(!session_is_registered("sUsuId"))
  {
      header("location:logout.php?msg=Sesion Expirada");
  }
  
  include_once("../includes/main.php");
  include_once("../class/cUsuario.php");
  
  extract($_REQUEST);
  
  $obj=new cUsuario($conn);
  
  $obj->usu_id=$txtUsuId;
  $obj->usu_clave=$txtUsuClave;
  $obj->usu_nombre=$txtUsuNombre;
  
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