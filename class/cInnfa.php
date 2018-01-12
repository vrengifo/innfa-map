<?php
  class cInnfa
  {
  	var $utd_id;
  	var $coord_id;
  	var $prov_id;
  	var $inn_nombre;
  	var $tip_id;
  	
  	var $conDB;
  	
  	var $msg;
  	var $separador;
  	
  	function __construct($con)
  	{
  		$this->conDB=$con;
  		
  		$this->utd_id=0;
  		$this->coord_id=0;
  		$this->prov_id=0;
  		$this->inn_nombre="Pais";
  		$this->tip_id="S";
  		
  		$this->msg="";
  		$this->separador=":";
  	}
  	
  	//actualizar clase
  	
  	function info($id)
  	{
  	  $sql=<<<mya
	  	select utd_id,inn_nombre  
	  	from tipomapa
	  	where utd_id=$id
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$this->msg="Error, TipoMapa no encontrado";
			$res="";
		}
		else 
		{
			$this->utd_id=$rs->fields[0];
			$this->inn_nombre=$rs->fields[1];
			//$this->borrar=$rs->fields[2];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function existe($id)
  	{
  	  $sql=<<<mya
	  	select utd_id
	  	from tipomapa
	  	where utd_id=$id
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$res="";
		}
		else 
		{
			$this->utd_id=$rs->fields[0];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function rsAdmin($orderby="")
  	{
  	  $sql=<<<mya
	  select utd_id,inn_nombre 
	  from tipomapa 
mya;
	  if(strlen($orderby)==0)
	    $cadOrderBy=" order by inn_nombre ";
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
  	where utd_id=$id    
mya;
      $rs=$this->conDB->execute($sql);
      return($id);   
  	}
  	
  	function add()
  	{
  	    $existe=$this->existe($this->utd_id);
  	    if($existe=="")//no existe
  	    {
  	        $sql=<<<mya
  	          insert into tipomapa 
  	          (utd_id,inn_nombre,borrar) 
  	          values 
  	          ($this->utd_id,'$this->inn_nombre','$this->borrar')
mya;
            $rs=$this->conDB->execute($sql);
            $res=$this->utd_id;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="tipomapa ya existe";
  	        $res=$this->utd_id;
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
  	          set inn_nombre='$this->inn_nombre',borrar='$this->borrar' 
  	          where 
  	          utd_id=$id
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
  	
  	//utd
  	function cad2idUtd($cad)
  	{
  	  $this->utd_id=$cad;
  	  return($cad);
  	}
  	
  	function id2cadUtd($utdId)
  	{
  	  $cad=$utdId;
  	  return($cad);
  	}
  	
  	function cadSqlIdUtd()
  	{
  	    if($this->conDB->dbtype=="MySQL")
  	    {
  	        $cad=<<<mya
            utd_id 
mya;
  	    }
  	    
  	    if($this->conDB->dbtype=="MSSQL")
  	    {
  	        $cad=<<<mya
            utd_id 
mya;
  	    }
  	    
  	    return($cad);
  	}
  	
  	//canton
  	function cad2idCoordinacion($cad)
  	{
  	  list($this->utd_id,$this->coord_id)=explode($this->separador,$cad);
  	  return($cad);
  	}
  	
  	function id2cadCoordinacion($utdId,$coorId)
  	{
  	  $cad=$utdId.$this->separador.$coorId;
  	  return($cad);
  	}
  	
  	function cadSqlIdCoordinacion()
  	{
  	    if($this->conDB->dbtype=="MySQL")
  	    {
  	        $cad=<<<mya
            concat(utd_id,'$this->separador',coord_id)
mya;
  	    }
  	    
  	    if($this->conDB->dbtype=="MSSQL")
  	    {
  	        $cad=<<<mya
            ( convert(varchar(2),utd_id)+'$this->separador'+convert(varchar(5),coord_id) )
mya;
  	    }
  	    
  	    return($cad);
  	}
  	
  	//funciones de recordset
  	
  	function rsSelectUtd($orderby="")
  	{
  		if(strlen($orderby)==0)
  		{
  			$cadOrder=" order by inn_nombre ";
  		}
  		else 
  		{
  			$cadOrder=" order by ".$orderby;
  		}
  		
  		$cadId=$this->cadSqlIdUtd();
  		
  		$sql=<<<mya
		select $cadId as utdId,inn_nombre 
		from innfa 
		where tip_id='U' 
		$cadOrder
mya;

  		$rs=$this->conDB->execute($sql);
	  return ($rs);
  	}
  	
  	function rsSelectCoordinacion($orderby="")
  	{
  		if(strlen($orderby)==0)
  		{
  			$cadOrder=" order by inn_nombre ";
  		}
  		else 
  		{
  			$cadOrder=" order by ".$orderby;
  		}
  		
  		$cadId=$this->cadSqlIdCoordinacion();
  		
  		
  		$sql=<<<mya
		select $cadId as coordId ,inn_nombre 
		from innfa 
		where tip_id='O' 
		$cadOrder
mya;

  		$rs=$this->conDB->execute($sql);
	  return ($rs);
  	}
  	
  	function rsSelectCoordinacionxUtd($utd,$orderby="")
  	{
  		if(strlen($orderby)==0)
  		{
  			$cadOrder=" order by inn_nombre ";
  		}
  		else 
  		{
  			$cadOrder=" order by ".$orderby;
  		}
  		
  		$cadId=$this->cadSqlIdCoordinacion();
  		
  		
  		$sql=<<<mya
		select $cadId as coorId ,inn_nombre 
		from innfa 
		where tip_id='O' and utd_id='$utd' 
		$cadOrder
mya;

  		$rs=$this->conDB->execute($sql);
	  return ($rs);
  	}
  	
  	function infoUtd($id)
  	{
  	  $oAux=new cInnfa($this->conDB);
  	  $oAux->cad2idUtd($id);
  		
  	  $sql=<<<mya
		select utd_id,inn_nombre,tip_id
		from innfa
		where utd_id=$oAux->utd_id 
mya;
	  $rs=&$this->conDB->execute($sql);
	  
	  $this->utd_id=$rs->fields[0];
	  $this->inn_nombre=$rs->fields[1];
	  $this->tip_id=$rs->fields[2];
	  
	  return($id);
  	}
  	
  	function infoCoordinacion($id)
  	{
  	  $oAux=new cInnfa($this->conDB);
  	  $oAux->cad2idCoordinacion($id);
  	  
  	  $sql=<<<mya
		select utd_id,coord_id,inn_nombre,tip_id
		from innfa
		where utd_id=$oAux->utd_id 
		and coord_id=$oAux->coord_id 
mya;
	  $rs=&$this->conDB->execute($sql);
	  
	  $this->utd_id=$rs->fields[0];
	  $this->coord_id=$rs->fields[1];
	  $this->inn_nombre=$rs->fields[2];
	  $this->tip_id=$rs->fields[3];
	  
	  return($id);
  	}
  	
  }

?>