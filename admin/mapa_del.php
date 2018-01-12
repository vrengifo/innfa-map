<?php
  session_start();
  
  if(!session_is_registered("sUsuId"))
  {
      header("location:logout.php?msg=Sesion Expirada");
  }
  
  include_once("../includes/main.php");
  include_once("../class/cMapa.php");
  
  extract($_REQUEST);
  
  $obj=new cMapa($conn);
  
  for($i=0;$i<$cuanto;$i++)
  {
    if(isset($chk[$i]))
    {
        $obj->del($chk[$i]);
    }
  }
  
  $destino="main.php?opcion=".$opcion;
  header("location:".$destino);
?>