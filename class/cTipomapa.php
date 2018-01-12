<?php
  class cTipomapa
  {
  	var $tipmap_id;
  	var $tipmap_nombre;
  	var $indi_descripcion;
  	
  	var $conDB;
  	
  	var $msg;
  	
  	function __construct($con)
  	{
  		$this->conDB=$con;
  		
  		$this->tipmap_id=0;
  		$this->tipmap_nombre="";
  		$this->indi_descripcion="";
  		
  		$this->msg="";
  	}
  	
  	function info($id)
  	{
  	  $sql=<<<mya
	  	select tipmap_id,tipmap_nombre  
	  	from tipomapa
	  	where tipmap_id=$id
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$this->msg="Error, TipoMapa no encontrado";
			$res="";
		}
		else 
		{
			$this->tipmap_id=$rs->fields[0];
			$this->tipmap_nombre=$rs->fields[1];
			//$this->indi_descripcion=$rs->fields[2];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function existe($id)
  	{
  	  $sql=<<<mya
	  	select tipmap_id
	  	from tipomapa
	  	where tipmap_id=$id
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$res="";
		}
		else 
		{
			$this->tipmap_id=$rs->fields[0];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function rsAdmin($orderby="")
  	{
  	  $sql=<<<mya
	  select tipmap_id,tipmap_nombre 
	  from tipomapa 
mya;
	  if(strlen($orderby)==0)
	    $cadOrderBy=" order by tipmap_nombre ";
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
  	where tipmap_id=$id    
mya;
      $rs=$this->conDB->execute($sql);
      return($id);   
  	}
  	
  	function add()
  	{
  	    $existe=$this->existe($this->tipmap_id);
  	    if($existe=="")//no existe
  	    {
  	        $sql=<<<mya
  	          insert into tipomapa 
  	          (tipmap_id,tipmap_nombre,indi_descripcion) 
  	          values 
  	          ($this->tipmap_id,'$this->tipmap_nombre','$this->indi_descripcion')
mya;
            $rs=$this->conDB->execute($sql);
            $res=$this->tipmap_id;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="tipomapa ya existe";
  	        $res=$this->tipmap_id;
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
  	          set tipmap_nombre='$this->tipmap_nombre',indi_descripcion='$this->indi_descripcion' 
  	          where 
  	          tipmap_id=$id
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
  	
  	function rsSelect($orderby="")
  	{
  		if(strlen($orderby)==0)
  		{
  			$cadOrder=" order by tipmap_nombre ";
  		}
  		else 
  		{
  			$cadOrder=" order by ".$orderby;
  		}
  		
  		$sql=<<<mya
		select tipmap_id,tipmap_nombre 
		from tipomapa
		$orderby
mya;

  		$rs=$this->conDB->execute($sql);
	  return ($rs);
  	}
  }

?>