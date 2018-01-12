<?php
  include_once("class/c_conecta.php");
  include_once("includes/data.php");
  
  $vTipo=$cTipo;
  $vServidor=$cServidor;
  
  $vUsuario=$cUsuario;
  $vClave=$cClave;
  
  $vBase=$cBase;
  
  $conn=new c_conecta($vTipo,$vServidor,$vUsuario,$vClave,$vBase);
  
  //$pathUpload="/var/www/html/classifieds/images_ad/";//linux
  $pathUpload="";//win
  $fotoNA="mapa/n_a.jpg";
?>