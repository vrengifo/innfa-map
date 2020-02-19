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
  
  //$conn->debug=true;
  
  $obj->tipmap_id=$selTipmap;
  
  $obj->map_nombre=$txtNombre;
  $obj->map_orden=$txtOrden;
  
  $obj->map_imagen=" ";
  
  if($obj->tipmap_id==1)//Geografia
  {
  	include_once("../class/cGeografia.php");
  	$oGeo=new cGeografia($conn);
  	/*//parroquia
  	if($selParr!=0)
  	  list($obj->prov_id,$obj->can_id,$obj->parr_id)=$oGeo->cad2idParr($selParr);
  	else 
  	  $obj->parr_id=0;
  	//canton
  	if($selCanton!=0)
  	  list($obj->prov_id,$obj->can_id)=$oGeo->cad2idCanton($selCanton);
  	else 
  	  $obj->can_id=0;
  	//provincia  
  	$obj->prov_id=$selProv;*/
  	
  	if($selParr!=0)
  	{
  	  $oGeo->cad2idParr($selParr);
  	  $obj->prov_id=$oGeo->prov_id;
  	  $obj->can_id=$oGeo->can_id;
  	  $obj->parr_id=$oGeo->parr_id;
  	}
  	elseif($selCanton!=0)
  	{ 
  	  $obj->parr_id=0;
  	  $oGeo->cad2idCanton($selCanton);
  	  $obj->prov_id=$oGeo->prov_id;
  	  $obj->can_id=$oGeo->can_id;
  	}
  	elseif($selProv!=0)
  	{
  	  $obj->parr_id=0;
  	  $obj->can_id=0;
  	  $obj->prov_id=$selProv;
  	}
  	$obj->utd_id=0;
  	$obj->coord_id=0;
  }
  if($obj->tipmap_id==2)//Innfa
  {
  	include_once("../class/cInnfa.php");
  	$oInn=new cInnfa($conn);
  	//coordinacion
  	if($selCoord!=0)
  	  list($obj->utd_id,$obj->coord_id)=$oInn->cad2idCoordinacion($selCoord);
  	else 
  	  $obj->coord_id=0;
  	//utd
  	$obj->utd_id=$selUtd;    
  	
  	$obj->prov_id=0;
  	$obj->can_id=0;
  	$obj->parr_id=0;
  }
  
  /*$obj->prov_id=$selProv;
  //tratar cadena de canton prov:can
  $obj->can_id=$selCanton;
  //tratar cadena de parroquia prov:can:parr
  $obj->parr_id=$selParr;
  
  $obj->utd_id=$selUtd;
  $obj->coord_id=$selCoord;
  */
  
  
  $resId=$obj->add();
  if($conn->debug==true)
  {
  	echo "<hr /> $resId <hr />";
  }
  
  //upload imagen
  include_once("../class/c_snapshot.php");
  $directorio="mapa/";
  $abpath="../".$pathUpload.$directorio;
  if(strlen($_FILES['fileImagen']['name'])>0)
  {  
    $cImg = new c_snapshot();
	$cImg->ImageField = $_FILES['fileImagen'];
	$cImg->Width = '640';
	$cImg->Height =  '480';
	$cImg->Resize = "true"; //if false, snapshot takes a portion from the unsized image.
	$cImg->ResizeScale = '100';
	$cImg->Position = 'custom';
	$cImg->Compression = 80;
	$cad="_1";
  	$namenewfile=$resId.$cad.".jpg";
  	$upfile=$abpath.$namenewfile;//win
	if ($cImg->SaveImageAs($upfile)) 
	{
		//copiar en directorio mapaPunto
		$cImg->SaveImageAs("../mapaPunto/".$namenewfile);
		
		$obj->map_imagen=$directorio.$namenewfile;
		$obj->map_imagenedit=$namenewfile;
	}
	$obj->updImage($resId);
  }
  
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