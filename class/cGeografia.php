<?php
  class cGeografia
  {
  	var $prov_id;
  	var $can_id;
  	var $parr_id;
  	var $geo_nombre;
  	var $tip_id;
  	
  	var $conDB;
  	
  	var $msg;
  	var $separador;
  	
  	function __construct($con)
  	{
  		$this->conDB=$con;
  		
  		$this->prov_id=0;
  		$this->can_id=0;
  		$this->parr_id=0;
  		$this->geo_nombre="Pais";
  		$this->tip_id="S";
  		
  		$this->msg="";
  		$this->separador=":";
  	}
  	
  	//actualizar clase
  	
  	function info($id)
  	{
  	  $sql=<<<mya
	  	select prov_id,geo_nombre  
	  	from tipomapa
	  	where prov_id=$id
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$this->msg="Error, TipoMapa no encontrado";
			$res="";
		}
		else 
		{
			$this->prov_id=$rs->fields[0];
			$this->geo_nombre=$rs->fields[1];
			//$this->borrar=$rs->fields[2];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function existe($id)
  	{
  	  $sql=<<<mya
	  	select prov_id
	  	from tipomapa
	  	where prov_id=$id
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$res="";
		}
		else 
		{
			$this->prov_id=$rs->fields[0];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function rsAdmin($orderby="")
  	{
  	  $sql=<<<mya
	  select prov_id,geo_nombre 
	  from tipomapa 
mya;
	  if(strlen($orderby)==0)
	    $cadOrderBy=" order by geo_nombre ";
	  else 
	    $cadOrderBy=" order by ".$orderby;  
	  
	  $sql.=$cadOrderBy;    
	  
	  $rs=$this->conDB->execute($sql);
	  return($rs); 	
  	}
  	
  	function del($id)
  	{
  	  $sql=<<<mya
  	delete from tipomapa 
  	where prov_id=$id    
mya;
      $rs=$this->conDB->execute($sql);
      return($id);   
  	}
  	
  	function add()
  	{
  	    $existe=$this->existe($this->prov_id);
  	    if($existe=="")//no existe
  	    {
  	        $sql=<<<mya
  	          insert into tipomapa 
  	          (prov_id,geo_nombre,borrar) 
  	          values 
  	          ($this->prov_id,'$this->geo_nombre','$this->borrar')
mya;
            $rs=$this->conDB->execute($sql);
            $res=$this->prov_id;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="tipomapa ya existe";
  	        $res=$this->prov_id;
  	    }
  	    return($res); 
  	}
  	
  	function upd($id)
  	{
  	    $existe=$this->existe($id);
  	    if($existe!="")//no existe
  	    {
  	        $sql=<<<mya
  	          update tipomapa 
  	          set geo_nombre='$this->geo_nombre',borrar='$this->borrar' 
  	          where 
  	          prov_id=$id
mya;
            $rs=$this->conDB->execute($sql);
            $res=$id;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="tipomapa no existe y no se puede actualizar";
  	        $res=$id;
  	    }
  	    return($res); 
  	}
  	
  	// fin actualizar clase
  	
  	//provincia
  	function cad2idProv($cad)
  	{
  	  $this->prov_id=$cad;
  	  return($cad);
  	}
  	
  	function id2cadProv($provId)
  	{
  	  $cad=$provId;
  	  return($cad);
  	}
  	
  	function cadSqlIdProv()
  	{
  	    if($this->conDB->dbtype=="MySQL")
  	    {
  	        $cad=<<<mya
            prov_id 
mya;
  	    }
  	    
  	    if($this->conDB->dbtype=="MSSQL")
  	    {
  	        $cad=<<<mya
            prov_id 
mya;
  	    }
  	    
  	    return($cad);
  	}
  	
  	//canton
  	function cad2idCanton($cad)
  	{
  	  list($this->prov_id,$this->can_id)=explode($this->separador,$cad);
  	  return($cad);
  	}
  	
  	function id2cadCanton($provId,$canId)
  	{
  	  $cad=$provId.$this->separador.$canId;
  	  return($cad);
  	}
  	
  	function cadSqlIdCanton()
  	{
  	    if($this->conDB->dbtype=="MySQL")
  	    {
  	        $cad=<<<mya
            concat(prov_id,'$this->separador',can_id)
mya;
  	    }
  	    
  	    if($this->conDB->dbtype=="MSSQL")
  	    {
  	        $cad=<<<mya
            ( convert(varchar(2),prov_id)+'$this->separador'+convert(varchar(5),can_id) )
mya;
  	    }
  	    
  	    return($cad);
  	}
  	
  	//parroquia
  	function cad2idParr($cad)
  	{
  	  list($this->prov_id,$this->can_id,$this->parr_id)=explode($this->separador,$cad);
  	  return($cad);
  	}
  	
  	function id2cadParr($provId,$canId,$parrId)
  	{
  	  $cad=$provId.$this->separador.$canId.$this->separador.$parrId;
  	  return($cad);
  	}
  	
  	function cadSqlIdParr()
  	{
  	    if($this->conDB->dbtype=="MySQL")
  	    {
  	        $cad=<<<mya
            concat(prov_id,'$this->separador',can_id,'$this->separador',parr_id)
mya;
  	    }
  	    
  	    if($this->conDB->dbtype=="MSSQL")
  	    {
  	        $cad=<<<mya
            ( convert(varchar(2),prov_id)+'$this->separador'+convert(varchar(5),can_id)+'$this->separador'+convert(varchar(8),parr_id) )
mya;
  	    }
  	    
  	    return($cad);
  	}
  	
  	//funciones de recordset
  	
  	function rsSelectProvincia($orderby="")
  	{
  		if(strlen($orderby)==0)
  		{
  			$cadOrder=" order by geo_nombre ";
  		}
  		else 
  		{
  			$cadOrder=" order by ".$orderby;
  		}
  		
  		$cadId=$this->cadSqlIdProv();
  		
  		$sql=<<<mya
		select $cadId as provId,geo_nombre 
		from geografia 
		where tip_id='P' 
		$cadOrder
mya;

  		$rs=$this->conDB->execute($sql);
	  return ($rs);
  	}
  	
  	function rsSelectCanton($orderby="")
  	{
  		if(strlen($orderby)==0)
  		{
  			$cadOrder=" order by geo_nombre ";
  		}
  		else 
  		{
  			$cadOrder=" order by ".$orderby;
  		}
  		
  		$cadId=$this->cadSqlIdCanton();
  		
  		
  		$sql=<<<mya
		select $cadId as canId ,geo_nombre 
		from geografia 
		where tip_id='C' 
		$cadOrder
mya;

  		$rs=$this->conDB->execute($sql);
	  return ($rs);
  	}
  	
  	function rsSelectCantonxProv($prov,$orderby="")
  	{
  		if(strlen($orderby)==0)
  		{
  			$cadOrder=" order by geo_nombre ";
  		}
  		else 
  		{
  			$cadOrder=" order by ".$orderby;
  		}
  		
  		$cadId=$this->cadSqlIdCanton();
  		
  		
  		$sql=<<<mya
		select $cadId as canId ,geo_nombre 
		from geografia 
		where tip_id='C' and prov_id='$prov' 
		$cadOrder
mya;

  		$rs=$this->conDB->execute($sql);
	  return ($rs);
  	}
  	
  	function rsSelectParroquia($orderby="")
  	{
  		if(strlen($orderby)==0)
  		{
  			$cadOrder=" order by geo_nombre ";
  		}
  		else 
  		{
  			$cadOrder=" order by ".$orderby;
  		}
  		
  		$cadId=$this->cadSqlIdParr();
  		
  		$sql=<<<mya
		select $cadId as parrId ,geo_nombre 
		from geografia 
		where tip_id='Q' 
		$cadOrder
mya;

  		$rs=$this->conDB->execute($sql);
	  return ($rs);
  	}
  	
  	function rsSelectParroquiaxCan($can,$orderby="")
  	{
  		if(strlen($orderby)==0)
  		{
  			$cadOrder=" order by geo_nombre ";
  		}
  		else 
  		{
  			$cadOrder=" order by ".$orderby;
  		}
  		
  		$cadId=$this->cadSqlIdParr();
  		
  		$oAux=new cGeografia($this->conDB);
  		$oAux->cad2idCanton($can);
  		
  		$sql=<<<mya
		select $cadId as parrId ,geo_nombre 
		from geografia 
		where tip_id='Q' and prov_id='$oAux->prov_id' and can_id='$oAux->can_id' 
		$cadOrder
mya;

  		$rs=$this->conDB->execute($sql);
	  return ($rs);
  	}
  	
  	function infoProv($id)
  	{
  	  $oAux=new cGeografia($this->conDB);
  	  $oAux->cad2idProv($id);
  		
  	  $sql=<<<mya
		select prov_id,geo_nombre,tip_id
		from geografia
		where prov_id=$oAux->prov_id 
mya;
	  $rs=&$this->conDB->execute($sql);
	  
	  $this->prov_id=$rs->fields[0];
	  $this->geo_nombre=$rs->fields[1];
	  $this->tip_id=$rs->fields[2];
	  
	  return($id);
  	}
  	
  	function infoCanton($id)
  	{
  	  $oAux=new cGeografia($this->conDB);
  	  $oAux->cad2idCanton($id);
  	  
  	  $sql=<<<mya
		select prov_id,can_id,geo_nombre,tip_id
		from geografia
		where prov_id=$oAux->prov_id 
		and can_id=$oAux->can_id 
mya;
	  $rs=&$this->conDB->execute($sql);
	  
	  $this->prov_id=$rs->fields[0];
	  $this->can_id=$rs->fields[1];
	  $this->geo_nombre=$rs->fields[2];
	  $this->tip_id=$rs->fields[3];
	  
	  return($id);
  	}
  	
  	function infoParroquia($id)
  	{
  	  $oAux=new cGeografia($this->conDB);
  	  $oAux->cad2idParr($id);
  	  
  	  $sql=<<<mya
		select prov_id,can_id,parr_id,geo_nombre,tip_id
		from geografia
		where prov_id=$oAux->prov_id 
		and can_id=$oAux->can_id 
		and parr_id=$oAux->parr_id 
mya;
	  $rs=&$this->conDB->execute($sql);
	  
	  $this->prov_id=$rs->fields[0];
	  $this->can_id=$rs->fields[1];
	  $this->parr_id=$rs->fields[2];
	  $this->geo_nombre=$rs->fields[3];
	  $this->tip_id=$rs->fields[4];
	  
	  return($id);
  	}
  	
  }

?>