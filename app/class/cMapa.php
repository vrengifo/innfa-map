<?php
  
  class cMapa
  {
  	var $tipmap_id;
    var $map_id;
  	var $map_nombre;
  	var $map_orden;
  	var $map_imagen;
  	var $map_imagenedit;
  	var $map_cad;
  	var $prov_id;
  	var $can_id;
  	var $parr_id;
  	var $utd_id;
  	var $coord_id;
  	var $tip_id;
  	
  	var $dirEdit;
  	
  	var $conDB;
  	
  	var $msg;
  	
  	/**
  	 * Constructor
  	 *
  	 * @param conDB $con
  	 */
  	function __construct($con)
  	{
  		$this->conDB=$con;
  		
  		$this->tipmap_id=0;
  		$this->map_id=0;
  		$this->map_nombre="";
  		$this->map_orden=0;
  		$this->map_imagen="";
  		$this->map_cad="";
  		
  		$this->prov_id=0;
  		$this->can_id=0;
  		$this->can_id=0;
  		$this->parr_id=0;
  		$this->utd_id=0;
  		$this->coord_id=0;
  		
  		$this->tip_id="";
  	     
  		
  		$this->msg="";
  		
  		$this->dirEdit="mapaPunto";
  	}
  	
  	function info($id)
  	{
  	  $sql=<<<mya
	  	select tipmap_id,map_id,map_nombre,map_orden,
	  	map_imagen,map_cad,prov_id,can_id,
	  	parr_id,utd_id,coord_id,tip_id,
	  	map_imagenedit  
	  	from mapa
	  	where map_id=$id
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$this->msg="Error, mapa no encontrado";
			$res="";
		}
		else 
		{
			$this->tipmap_id=$rs->fields[0];
			$this->map_id=$rs->fields[1];
			$this->map_nombre=$rs->fields[2];
			$this->map_orden=$rs->fields[3];
			$this->map_imagen=$rs->fields[4];
			$this->map_cad=$rs->fields[5];
			$this->prov_id=$rs->fields[6];
			$this->can_id=$rs->fields[7];
			$this->parr_id=$rs->fields[8];
			$this->utd_id=$rs->fields[9];
			$this->coord_id=$rs->fields[10];
			$this->tip_id=$rs->fields[11];
			$this->map_imagenedit=$rs->fields[12];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function existe()
  	{
  	  $sql=<<<mya
		select map_id 
		from mapa
		where
		tipmap_id = $this->tipmap_id
		and map_nombre = '$this->map_nombre'
		and tip_id = '$this->tip_id'
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$res=0;
		}
		else 
		{
			$id=$this->map_id=$rs->fields[0];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function existeId($id)
  	{
  	  $sql=<<<mya
		select map_id 
		from mapa
		where
		map_id = $id
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$res=0;
		}
		else 
		{
			$this->map_id=$rs->fields[0];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function rsAdmin($orderby="")
  	{
  	  $sql=<<<mya
	  select map_id,tipmap_id,map_nombre,map_orden,
	  map_imagen,prov_id,can_id,
	  parr_id,utd_id,coord_id,tip_id,map_imagenedit 
	  from mapa 
mya;

	  if(strlen($orderby)==0)
	    $cadOrderBy=" order by map_id ";
	  else 
	    $cadOrderBy=" order by ".$orderby;  
	  
	  $sql.=$cadOrderBy;    
	  
	  $rs=$this->conDB->execute($sql);
	  return($rs); 	
  	}
  	
  	function del($id)
  	{
  	  //$this->conDB->debug=true;
  		
  	  $oAux=new cMapa($this->conDB);
  	  $oAux->info($id);

  	  $sqlPunto=<<<mya
  	delete from puntoestructura 
  	where map_id=$id 
mya;
	  $rsPunto=$this->conDB->execute($sqlPunto);
  	   	  
  	  $sql=<<<mya
  	delete from mapa 
  	where map_id=$id    
mya;
      $rs=$this->conDB->execute($sql);
      
      //eliminar archivos
      @unlink("../".$oAux->map_imagen);
  	  @unlink("../".$oAux->dirEdit."/".$oAux->map_imagenedit);
      
      return($id);   
  	}
  	
  	function identificarTipo()
  	{
  		if($this->tipmap_id==1)//geografia
  		{
  			if($this->parr_id!=0)
  			{
  			  $tip_id="Q";
			}
			elseif($this->can_id!=0)
  			{
  			  $tip_id="C";
			}
			elseif($this->prov_id!=0)
  			{
  			  $tip_id="P";
			}
			else
			{
				$tip_id="S";
			}
  		}
  		
  		elseif($this->tipmap_id==2)//innfa
  		{
  			if($this->coord_id!=0)
  			{
  			  $tip_id="O";
			}
			elseif($this->utd_id!=0)
  			{
  			  $tip_id="U";
			}
			else 
			{
				$tip_id="S";
			}
  		}
  		else 
  		{
  			$tip_id="S";
  		}
  		
  		return($tip_id);
  	}
  	
  	/**
  	 * Añade un mapa
  	 *
  	 * @return int
  	 */
  	function add()
  	{
  	    //$this->conDB->debug=true;
  		
  		$this->tip_id=$this->identificarTipo();
  		$existe=$this->existe();
  	    if($existe=="")//no existe
  	    {
/*  	        $sql=<<<mya
  	          insert into mapa 
  	          (
  	          tipmap_id,map_nombre,map_orden,
  	          map_imagen,map_cad,prov_id,parr_id,
  	          utd_id,coord_id,tip_id
  	          ) 
  	          values 
  	          (
  	          $this->tipmap_id,'$this->map_nombre','$this->map_orden',
  	          '$this->map_imagen','$this->map_cad',$this->prov_id,$this->parr_id,
  	          $this->utd_id,$this->coord_id,'$this->tip_id'
  	          )
mya;
*/
		  	$sql=<<<mya
  	          insert into mapa 
  	          (
  	          tipmap_id,map_nombre,map_orden,
  	          map_imagen,prov_id,can_id,parr_id,
  	          utd_id,coord_id,tip_id,map_imagenedit 
  	          ) 
  	          values 
  	          (
  	          $this->tipmap_id,'$this->map_nombre','$this->map_orden',
  	          '$this->map_imagen',$this->prov_id,$this->can_id,$this->parr_id,
  	          $this->utd_id,$this->coord_id,'$this->tip_id','$this->map_imagenedit'
  	          )
mya;
  	        
            $rs=$this->conDB->execute($sql);
            
            $res=$this->existe();
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="Mapa ya existe";
  	        $res=$this->map_id;
  	    }
  	    $this->conDB->debug=false;
  	    return($res); 
  	}
  	
  	function upd($id)
  	{
  	    $existe=$this->existeId($id);
  	    if($existe!="")//no existe
  	    {
  	        $sql=<<<mya
  	          update mapa 
  	          set map_orden='$this->map_orden',
  	          map_imagen='$this->map_imagen',
  	          prov_id=$this->prov_id,
  	          can_id=$this->can_id,
  	          parr_id=$this->parr_id,
  	          utd_id=$this->utd_id 
  	          where 
  	          map_id=$id
mya;
            $rs=$this->conDB->execute($sql);
            $res=$id;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="mapa no existe y no se puede actualizar";
  	        $res=$id;
  	    }
  	    return($res); 
  	}
  	
  	function updImage($id)
  	{
  	    $existe=$this->existeId($id);
  	    if($existe!="")//no existe
  	    {
  	        $sql=<<<mya
  	          update mapa 
  	          set 
  	          map_imagen='$this->map_imagen',
  	          map_imagenedit='$this->map_imagenedit'  
  	          where 
  	          map_id=$id
mya;
            $rs=$this->conDB->execute($sql);
            $res=$id;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="path a imagen de mapa no existe y no se puede actualizar";
  	        $res=$id;
  	    }
  	    return($res); 
  	}
  	
  	/**
  	 * Construye el html necesario de los puntos del mapa en el Administrador
  	 *
  	 * @param mapId $id
  	 * @return string
  	 */
  	function buildAdminMapa($id)
  	{
  		include_once("../class/cPuntoestructura.php");
  		
  		$oAux=new cMapa($this->conDB);
  		$oAux->info($id);
  		
  		$oPunto=new cPuntoestructura($this->conDB);
  		
  		$sql=$oPunto->retrievePunto($oAux->tipmap_id,$oAux->map_id);
  		$rs=&$this->conDB->execute($sql);
  		
  		$cadDet="";
  		
  		while(!$rs->EOF)
  		{
  		  //$cadId as identificador,pun_x,pun_y,pun_radio,pun_nombre
  		  $punId=$rs->fields[0];
  		  $punX=$rs->fields[1];
  		  $punY=$rs->fields[2];
  		  $punRadio=$rs->fields[3];
  		  $punNombre=$rs->fields[4];
  		  
  		  $cadDet.=$oPunto->area($punId,$punX,$punY,$punRadio,$punNombre);
  		  
  		  $rs->next();
  		}
  		$cad=<<<mya
  		<map name="mapa">
  		  $cadDet
  		</map>	
mya;
	  return($cad); 
  	}

  	/**
  	 * Construye el html necesario de los puntos del mapa en el Cliente
  	 *
  	 * @param mapId $id
  	 * @return string
  	 */
  	function buildClientMapaOriginal($id)
  	{
  		include_once("class/cPuntoestructura.php");
  		
  		$oAux=new cMapa($this->conDB);
  		$oAux->info($id);
  		
  		$oPunto=new cPuntoestructura($this->conDB);
  		
  		$sql=$oPunto->retrievePunto($oAux->tipmap_id,$oAux->map_id);
  		
  		//echo "<hr>$sql<hr>";
  		
  		$rs=&$this->conDB->execute($sql);
  		
  		$cadDet="";
  		
  		while(!$rs->EOF)
  		{
  		  //$cadId as identificador,pun_x,pun_y,pun_radio,pun_nombre
  		  $punId=$rs->fields[0];
  		  $punX=$rs->fields[1];
  		  $punY=$rs->fields[2];
  		  $punRadio=$rs->fields[3];
  		  $punNombre=$rs->fields[4];
  		  
  		  $texto="";
  		  
  		  $cadDet.=$oPunto->areaCliente($punId,$punX,$punY,$punRadio,$punNombre,$texto);
  		  
  		  $rs->next();
  		}
  		$cad=<<<mya
  		<map name="mapa">
  		  $cadDet
  		</map>	
mya;
	  return($cad); 
  	}
  	
  	/**
  	 * Construye el html necesario de los puntos del mapa en el Cliente cuando se ha escogido un indicador y un parametro
  	 *
  	 * @param mapId $id
  	 * @return string
  	 */
  	function buildClientMapa($id,$indicador,$parametro)
  	{
  		include_once("class/cPuntoestructura.php");
  		
  		$oAux=new cMapa($this->conDB);
  		$oAux->info($id);
  		
  		$oPunto=new cPuntoestructura($this->conDB);
  		
  		if($oAux->tipmap_id==1)//geografia
  		  $sql=$oPunto->retrievePuntoxIndiParGeo($oAux->tipmap_id,$oAux->map_id,$indicador,$parametro);
  		else 
  		  $sql=$oPunto->retrievePuntoxIndiParInnfa($oAux->tipmap_id,$oAux->map_id,$indicador,$parametro);
  		
  		//echo "<hr>$sql<hr>";
  		
  		$rs=&$this->conDB->execute($sql);
  		
  		$cadDet="";
  		
  		while(!$rs->EOF)
  		{
  		  //$cadId as identificador,pun_x,pun_y,pun_radio,pun_nombre
  		  $punId=$rs->fields[0];
  		  $punX=$rs->fields[1];
  		  $punY=$rs->fields[2];
  		  $punRadio=$rs->fields[3];
  		  $punNombre=$rs->fields[4];
  		  
  		  $texto=$rs->fields[5]." % ";
  		  
  		  $cadDet.=$oPunto->areaCliente($punId,$punX,$punY,$punRadio,$punNombre,$texto);
  		  
  		  $rs->next();
  		}
  		$cad=<<<mya
  		<map name="mapa">
  		  $cadDet
  		</map>	
mya;
	  return($cad); 
  	}
  	
  	/**
  	 * Busca el mapa por defecto dependiendo del tipo de mapa
  	 *
  	 * @param int $tip
  	 * @return int
  	 */
  	function buscaMapaDefecto($tip="1")
  	{
  		$sql=<<<mya
		select map_id 
		from mapa
		where 
		tipmap_id=$tip 
		and map_orden=0 
		and tip_id='S'
mya;
	  $rs=&$this->conDB->execute($sql);
	  if($rs->EOF)
	  {
	  	$mapId=0;
	  }
	  else 
	  {
	  	$mapId=$rs->fields[0];
	  }
	  return($mapId); 
  	}
  	
  	/**
  	 * Busca el mapa correspondiente al nivel superior del mapa seleccionado
  	 *
  	 * @param int $mapId
  	 * @return int
  	 */
  	function subirNivel($mapId)
  	{
  		$oAux=new cMapa($this->conDB);
  		
  		$oAux->info($mapId);
  		
  		switch ($oAux->tipmap_id) 
  		{
  			case 1: //x geografia
  				switch ($oAux->tip_id) 
  				{
  					case "S": //pais
  						$res=$mapId;
  						break;
  					case "P": //provincia
  						$res=$this->buscaMapaDefecto("1");
  						break;
  					case "C": //canton
  						//buscar el mapa q pertenezca a $oAux->prov_id con tip_id='P' y tipmap_id=1
  						$res=$this->buscaMapa($oAux->tipmap_id,"P",$oAux->prov_id,":");
  						break;
  					case "Q": //parroquia
  						//buscar el mapa q pertenezca a $oAux->can_id con tip_id='C' y tipmap_id=1
  						$res=$this->buscaMapa($oAux->tipmap_id,"C",$oAux->prov_id.":".$oAux->can_id,":");
  						break;
  					default:
  						$res=$mapId;
  						break;
  				}
  				break;
  			case 2: //x innfa
  				switch ($oAux->tip_id) 
  				{
  					case "S": //pais
  						$res=$mapId;
  						break;
  					case "U": //utd
  						$res=$this->buscaMapaDefecto("2");
  						break;
  					case "O": //coordinacion
  						//buscar el mapa q pertenezca a $oAux->utd_id con tip_id='U' y tipmap_id=2
  						$res=$this->buscaMapa($oAux->tipmap_id,"U",$oAux->utd_id,":");
  						break;
  					default:
  						$res=$mapId;
  						break;
  				}
  				break;	
  			default:
  				
  				break;
  		}
  		return ($res);
  	}
  	
  	/**
  	 * Busca el mapId correspondiente a los datos recibidos
  	 *
  	 * @param int $tipmap
  	 * @param string $tip
  	 * @param string $cadUbicacion
  	 * @param string $separador
  	 * @return int
  	 */
  	function buscaMapa($tipmap,$tip,$cadUbicacion,$separador)
  	{
  		$arr=explode($separador,$cadUbicacion);
  		
  		switch ($tipmap) {
  			case 1: //geografia
  				
  				switch ($tip) 
  				{
  					case "C":
  						$sql=<<<mya
  	select distinct map_id 
  	from mapa
  	where 
  	tipmap_id=$tipmap 
  	and tip_id='$tip' 
mya;
						$sql.="and prov_id=".$arr[0]." and can_id=".$arr[1];
  						break;
  					case "P":
  						$sql=<<<mya
  	select distinct map_id 
  	from mapa
  	where 
  	tipmap_id=$tipmap 
  	and tip_id='$tip' 
mya;
						$sql.="and prov_id=".$arr[0];
  						break;
  					default:
  						break;
  				}
  				break;
  			case 2: //innfa
  				
  				switch ($tip) 
  				{
  					case "U":
  						$sql=<<<mya
  	select distinct map_id 
  	from mapa
  	where 
  	tipmap_id=$tipmap 
  	and tip_id='$tip' 
mya;
						$sql.="and utd_id=".$arr[0];
  						break;
  					default:
  						break;
  				}
  				break;  				
  			default:
  				break;
  		}
  		$rs=$this->conDB->execute($sql);
  		if($rs->EOF)
  		  $res=0;
  		else 
  		  $res=$rs->fields[0];
  		return($res);     
  	}
  	
  	function resetearMapa($mapId)
  	{
  		$oAux=new cMapa($this->conDB);
  		$oAux->info($mapId);
  		//copiar la imagen del path original a mapaPunto
  		$archivoOrigen="../".$oAux->map_imagen;
  		$archivoDestino="../mapaPunto/".$oAux->map_imagenedit;
  		copy($archivoOrigen,$archivoDestino);
  		//eliminar los puntoestructura del mapa
  		$sqlDel=<<<mya
  		delete from puntoestructura 
  		where map_id=$mapId
mya;
		$rsDel=$this->conDB->execute($sqlDel);
		
		return($mapId);
  	}
  	
  }

?>