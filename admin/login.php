<?php
  include_once("../includes/main.php");
  
  include_once("../class/cUsuario.php");
  
  extract($_REQUEST);
  
  $obj=new cUsuario($conn);
  
  $res=$obj->autenticar($txtUsuario,$txtClave);
  
  if($res)
  {
  	session_start();
  	
  	$sUsuId=$obj->usu_id;
  	
  	session_register("sUsuId");
  	
  	$destino="main.php";
  }
  else 
  {
  	$destino="index.php?msg=".$obj->msg;
  }
  header("location:".$destino);
?>