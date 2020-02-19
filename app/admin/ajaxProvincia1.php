<?php
  extract($_REQUEST);
  include_once("../includes/main.php");
  include_once("../class/cMapa.php");
  include_once("../class/cPuntoestructura.php");
  include_once("../class/cTipo.php");
  include_once("../class/cGeografia.php");
  
  $objTipo=new cTipo($conn);
  $tipId="P";
  $objTipo->info($tipId);
  
  $objGeo=new cGeografia($conn);
  $objGeo->infoProv($provincia);
  
  $objPun=new cPuntoestructura($conn);
  
  $objPun->pun_x=$puntoX;
  $objPun->pun_y=$puntoY;
  $objPun->map_id=$mapaId;
  $objPun->tipmap_id=$tipmapId;
  $objPun->tip_id=$tipId;
  $objPun->prov_id=$provincia;
  
  $objPun->pun_nombre=$objGeo->geo_nombre;
  $objPun->pun_descripcion="Provincia de ".$objGeo->geo_nombre;
  //setear el resto de variables de geografia e innfa
  $objPun->can_id=0;
  $objPun->parr_id=0;
  $objPun->utd_id=0;
  $objPun->coord_id=0;
  
  //modificar la imagen aumentando la p en el punto correspondiente
  $pathImg="../mapaPunto/".$mapaImgNombre;
  //crear imagen a partir de un archivo existente
  $myImage=imagecreatefromjpeg($pathImg);
  
  //imagen de Icono: Provincia
  //$imgIcono=imagecreatefromjpeg("../".$objTipo->tip_icono);
  $imgIcono=imagecreatefrompng("../".$objTipo->tip_icono);
  
  $anchoimgIcono=imagesx($imgIcono);
  $altoimgIcono=imagesy($imgIcono);
  //el puntoX y puntoY apuntan al centro de la imagen de provincia
  $puntoXimgIcono=$puntoX-$anchoimgIcono/2;
  $puntoYimgIcono=$puntoY-$altoimgIcono/2;
  
  $objPun->pun_radio=$anchoimgIcono/2;
  //insertar el punto en la tabla puntoestructura
  $puntoId=$objPun->add();
  if(strlen($objPun->msg)==0)//se creo el punto
  {
  
  //copiar la imagen
  imagecopy($myImage,$imgIcono,$puntoXimgIcono,$puntoYimgIcono,0,0,$anchoimgIcono,$altoimgIcono);
  
  //crear la imagen
  
  //imagejpeg($myImage);//muestra la imagen
  imagejpeg($myImage,$pathImg);//crea el archivo resultante
  //destruir la imagen en memoria
  imagedestroy($myImage);
  imagedestroy($imgIcono);
  
    //redireccionar la pagina
    $destino="puntoMapa.php?id=".$mapaId."&imageName=".$mapaImgNombre;
    header("location:".$destino);
    
  }
  else //no se creo el punto
  {
  	echo "No se pudo crear el punto, chequee la informacion";
  }

?>