<?php
  class cPuntoestructura
  {
  	var $tipmap_id;
    var $map_id;
    var $pun_x;
    var $pun_y;
    var $pun_radio;
  	var $pun_nombre;
  	var $pun_descripcion;
  	var $prov_id;
  	var $can_id;
  	var $parr_id;
  	var $utd_id;
  	var $coord_id;
  	var $tip_id;
  	
  	var $conDB;
  	
  	var $separador;
  	
  	var $msg;
  	
  	function __construct($con)
  	{
  		$this->conDB=$con;
  		
  		$this->tipmap_id=0;
  		$this->map_id=0;
  		$this->pun_x=0;
  		$this->pun_y=0;
  		$this->pun_radio=0;
  		$this->pun_nombre="";
  		$this->pun_descripcion="";
  		
  		$this->prov_id=0;
  		$this->can_id=0;
  		$this->can_id=0;
  		$this->parr_id=0;
  		$this->utd_id=0;
  		$this->coord_id=0;
  		
  		$this->tip_id="";
  	     
  		
  		$this->msg="";
  		$this->separador=":";
  		
  	}
  	
  	function info($id)
  	{
  	  $oAux=new cPuntoestructura($this->conDB);
  	  $oAux->cad2id($id);
  	    
  	  $sql=<<<mya
	  	select tipmap_id,map_id,pun_x,pun_y,
	  	pun_radio,pun_nombre,pun_descripcion,
	  	prov_id,can_id,parr_id,utd_id,
	  	coord_id,tip_id 
	  	from puntoestructura
	  	where 
	  	tipmap_id='$oAux->tipmap_id' 
	  	and map_id='$oAux->map_id' 
	  	and pun_x='$oAux->pun_x' 
	  	and pun_y='$oAux->pun_y' 
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$this->msg="Error, puntoestructura no encontrado";
			$res="";
		}
		else 
		{
			$this->tipmap_id=$rs->fields[0];
			$this->map_id=$rs->fields[1];
			$this->pun_x=$rs->fields[2];
			$this->pun_y=$rs->fields[3];
			$this->pun_radio=$rs->fields[4];
			$this->pun_nombre=$rs->fields[5];
			$this->pun_descripcion=$rs->fields[6];
			$this->prov_id=$rs->fields[7];
			$this->can_id=$rs->fields[8];
			$this->parr_id=$rs->fields[9];
			$this->utd_id=$rs->fields[10];
			$this->coord_id=$rs->fields[11];
			$this->tip_id=$rs->fields[12];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function cad2id($cad)
  	{
  	  list($this->tipmap_id,$this->map_id,$this->pun_x,$this->pun_y)=explode($this->separador,$cad);
  	  return($cad);
  	}
  	
  	function id2cad($tipmapId,$mapId,$punX,$punY)
  	{
  	  $cad=$tipmapId.$this->separador.$mapId.$this->separador.$punX.$this->separador.$punY;
  	  return($cad);
  	}
  	
  	function cadSqlId()
  	{
  	    if($this->conDB->dbtype=="MySQL")
  	    {
  	        $cad=<<<mya
            concat(tipmap_id,'$this->separador',map_id,'$this->separador',pun_x,'$this->separador',pun_y)
mya;
  	    }
  	    
  	    if($this->conDB->dbtype=="MSSQL")
  	    {
  	        $cad=<<<mya
            rtrim(convert(char,tipmap_id))+'$this->separador'+rtrim(convert(char,map_id))+'$this->separador'+rtrim(convert(char,pun_x))+'$this->separador'+rtrim(convert(char,pun_y))
mya;
  	    }
  	    
  	    return($cad);
  	}
  	
  	function cadSqlIdPrefijo($prefijo)
  	{
  	    if($this->conDB->dbtype=="MySQL")
  	    {
/*  	        $cad=<<<mya
            concat(tipmap_id,'$this->separador',map_id,'$this->separador',pun_x,'$this->separador',pun_y)
mya;*/
			$cad="concat(".$prefijo."tipmap_id,'$this->separador',".$prefijo."map_id,'$this->separador',".$prefijo."pun_x,'$this->separador',".$prefijo."pun_y)";
  	    }
  	    
  	    if($this->conDB->dbtype=="MSSQL")
  	    {
  	        /*$cad=<<<mya
            rtrim(convert(char,tipmap_id))+'$this->separador'+rtrim(convert(char,map_id))+'$this->separador'+rtrim(convert(char,pun_x))+'$this->separador'+rtrim(convert(char,pun_y))
mya;*/

  	        $cad="rtrim(convert(char,".$prefijo."tipmap_id))+'$this->separador'+rtrim(convert(char,".$prefijo."map_id))+'$this->separador'+rtrim(convert(char,".$prefijo."pun_x))+'$this->separador'+rtrim(convert(char,".$prefijo."pun_y))";
  	        
  	    }
  	    
  	    return($cad);
  	}
  	
  	
  	function existe()
  	{
  	  $cadId=$this->cadSqlId();
  	  $sql=<<<mya
		select $cadId as identificador  
		from puntoestructura
		where
		tipmap_id = '$this->tipmap_id'
		and map_id= '$this->map_id' 
		and pun_x = '$this->pun_x'
		and pun_y = '$this->pun_y'
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$res="";
		}
		else 
		{
			$id=$this->id2cad($this->tipmap_id,$this->map_id,$this->pun_x,$this->pun_y);
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function rsAdmin($orderby="")
  	{
  	  $sql=<<<mya
	  select map_id,tipmap_id,pun_nombre,pun_x,
	  pun_descripcion,prov_id,can_id,
	  parr_id,utd_id,coord_id,tip_id,borrar 
	  from puntoestructura 
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
  	  $oAux=new cPuntoestructura($this->conDB);
  	  $oAux->cad2id($id);
  		
  	  $sql=<<<mya
  	delete from puntoestructura 
  	where tipmap_id='$oAux->tipmap_id' 
  	and map_id='$oAux->map_id' 
  	and pun_x='$oAux->pun_x' 
  	and pun_y='$oAux->pun_y' 
mya;
      $rs=$this->conDB->execute($sql);
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
  			  $tip_id="Q";
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
  	
  	function add()
  	{
  		$existe=$this->existe();
  	    if($existe=="")//no existe
  	    {
		  	$sql=<<<mya
  	          insert into puntoestructura 
  	          (
  	          tipmap_id,map_id,pun_x,pun_y,
  	          pun_radio,pun_nombre,pun_descripcion,
  	          prov_id,can_id,parr_id,
  	          utd_id,coord_id,tip_id 
  	          ) 
  	          values 
  	          (
  	          '$this->tipmap_id','$this->map_id','$this->pun_x','$this->pun_y',
  	          '$this->pun_radio','$this->pun_nombre','$this->pun_descripcion',
  	          $this->prov_id,$this->can_id,$this->parr_id,
  	          $this->utd_id,$this->coord_id,'$this->tip_id'
  	          )
mya;
  	        
            $rs=$this->conDB->execute($sql);
            
            $res=$this->existe();
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="puntoestructura ya existe";
  	        $res=$existe;
  	    }
  	    return($res); 
  	}
  	
  	function upd($id)
  	{
  	    $existe=$this->existeId($id);
  	    if($existe!="")//no existe
  	    {
  	        $sql=<<<mya
  	          update puntoestructura 
  	          set pun_x='$this->pun_x',
  	          pun_descripcion='$this->pun_descripcion',
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
  	        $this->msg="puntoestructura no existe y no se puede actualizar";
  	        $res=$id;
  	    }
  	    return($res); 
  	}
  	
  	function retrievePunto($tipmapId,$mapId)
  	{
  		$cadId=$this->cadSqlId();
  		$sql=<<<mya
  		select $cadId as identificador,pun_x,pun_y,pun_radio,pun_nombre 
  		from puntoestructura 
  		where 
  		tipmap_id=$tipmapId and map_id=$mapId
mya;
		return($sql);
  	}
  	
  	function retrievePuntoxIndiParGeo($tipmapId,$mapId,$indiId,$parId)
  	{
  		$cadId=$this->cadSqlIdPrefijo("pe.");
  		$sql=<<<mya
  		select $cadId as identificador,
  		pe.pun_x,pe.pun_y,pe.pun_radio,pe.pun_nombre,
  		gv.valor 
		from puntoestructura pe, geografiavalor gv 
		where 
		pe.tipmap_id=$tipmapId and pe.map_id=$mapId 
		and gv.indi_id=$indiId and gv.par_id=$parId
		and gv.tip_id=pe.tip_id and gv.prov_id=pe.prov_id
		and gv.can_id=pe.can_id 
		and gv.parr_id=pe.parr_id 
mya;
		return($sql);
  	}
  	
  	function retrievePuntoxIndiParInnfa($tipmapId,$mapId,$indiId,$parId)
  	{
  		$cadId=$this->cadSqlIdPrefijo("pe.");
  		$sql=<<<mya
  		select $cadId as identificador,
  		pe.pun_x,pe.pun_y,pe.pun_radio,pe.pun_nombre,
  		gv.valor 
		from puntoestructura pe, innfavalor gv 
		where 
		pe.tipmap_id=$tipmapId and pe.map_id=$mapId 
		and gv.indi_id=$indiId and gv.par_id=$parId
		and gv.tip_id=pe.tip_id and gv.utd_id=pe.utd_id
		and gv.coord_id=pe.coord_id 
mya;
		return($sql);
  	}
  	
  	function area($id,$x,$y,$radio,$texto)
  	{
  	  $tip="Tip('', WIDTH, 80, FADEIN, 500, FADEOUT, 500, OPACITY,80,SHADOW,true,TITLE,'$texto' )";	
  	  $cad=<<<mya
  	  <area id="_$id" shape="circle" coords="$x,$y,$radio" href="#" onClick="" onMouseOver="$tip" >
mya;
	  return($cad);
    }
    
    function areaCliente($id,$x,$y,$radio,$titulo,$texto)
  	{
  	  $oAux=new cPuntoestructura($this->conDB);
  	  $idMapa=$oAux->buscarMapa($id);
  		
      //$tip="Tip('$texto', WIDTH, 80, FADEIN, 500, FADEOUT, 500, OPACITY,80,SHADOW,true,TITLE,'$titulo')";	
      $tip="Tip('$texto', WIDTH, 80, FADEIN, 500, FADEOUT, 500, OPACITY,80,SHADOW,true,TITLE,'$titulo')";
  	  $cad=<<<mya
  	  <area id="_$id" shape="circle" coords="$x,$y,$radio" href="#" onClick="hacerSubmit('$idMapa');" onMouseOver="$tip" >
mya;
	  return($cad);
    }
    
    function buscarMapa($punId)
    {
      $oAux=new cPuntoestructura($this->conDB);
  	  $oAux->info($punId);
  	  
  	  switch ($oAux->tip_id)
  	  {
  	  	case "P": 
  	  	  $provId=$oAux->prov_id;
  	  	  //nivel inferior
  	  	  $sql=<<<mya
		  select map_id 
		  from mapa
		  where 
		  prov_id=$provId and tip_id='P'	
mya;
  	  	  $rs=&$this->conDB->execute($sql);
  	  	  if($rs->EOF)
  	  	    $res=0;
  	  	  else 
  	  	    $res=$rs->fields[0];  
  	  	break;
  	  	case "C": 
  	  	  $provId=$oAux->prov_id;
  	  	  $canId=$oAux->can_id;
  	  	  //nivel inferior
  	  	  $sql=<<<mya
		  select map_id 
		  from mapa
		  where 
		  prov_id=$provId and can_id=$canId and tip_id='C'	
mya;
  	  	  $rs=&$this->conDB->execute($sql);
  	  	  if($rs->EOF)
  	  	    $res=0;
  	  	  else 
  	  	    $res=$rs->fields[0];  
  	  	break;
  	  	case "Q": 
  	  	  $provId=$oAux->prov_id;
  	  	  $canId=$oAux->can_id;
  	  	  $parrId=$oAux->parr_id;
  	  	  //nivel inferior
  	  	  $sql=<<<mya
		  select map_id 
		  from mapa
		  where 
		  prov_id=$provId and can_id=$canId and parr_id=$parrId and tip_id='Q'	
mya;
  	  	  $rs=&$this->conDB->execute($sql);
  	  	  if($rs->EOF)
  	  	    $res=0;
  	  	  else 
  	  	    $res=$rs->fields[0];  
  	  	break;
  	  	case "U": 
  	  	  $utdId=$oAux->utd_id;
  	  	  //nivel inferior
  	  	  $sql=<<<mya
		  select map_id 
		  from mapa
		  where 
		  utd_id=$utdId and tip_id='U'	
mya;
  	  	  $rs=&$this->conDB->execute($sql);
  	  	  if($rs->EOF)
  	  	    $res=0;
  	  	  else 
  	  	    $res=$rs->fields[0];  
  	  	break;
  	  	case "O": 
  	  	  $utdId=$oAux->utd_id;
  	  	  $coordId=$oAux->coord_id;
  	  	  //nivel inferior
  	  	  $sql=<<<mya
		  select map_id 
		  from mapa
		  where 
		  utd_id=$utdId and coord_id=$coordId and tip_id='O'	
mya;
  	  	  $rs=&$this->conDB->execute($sql);
  	  	  if($rs->EOF)
  	  	    $res=0;
  	  	  else 
  	  	    $res=$rs->fields[0];  
  	  	break;
  	  }
  	  return($res);
  	  
    }
  	
  }

?>