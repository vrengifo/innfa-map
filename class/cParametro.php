<?php
  class cParametro
  {
  	var $par_id;
  	var $par_nombre;
  	
  	var $conDB;
  	
  	var $msg;
  	
  	function __construct($con)
  	{
  		$this->conDB=$con;
  		
  		$this->par_id=0;
  		$this->par_nombre="";
  		
  		$this->msg="";
  	}
  	
  	function info($id)
  	{
  	  $sql=<<<mya
	  	select par_id,par_nombre 
	  	from parametro
	  	where par_id=$id
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$this->msg="Error, parametro no encontrado";
			$res=0;
		}
		else 
		{
			$this->par_id=$rs->fields[0];
			$this->par_nombre=$rs->fields[1];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function existe($nombre)
  	{
  	  $sql=<<<mya
	  	select par_id
	  	from parametro
	  	where par_nombre='$nombre'
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$res=0;
		}
		else 
		{
			$res=$rs->fields[0];
			$this->msg="";
		}
		return($res);
  	}
  	
  	function rsAdmin($orderby="")
  	{
  	  $sql=<<<mya
	  select par_id,par_nombre 
	  from parametro 
mya;
	  if(strlen($orderby)==0)
	    $cadOrderBy=" order by par_nombre ";
	  else 
	    $cadOrderBy=" order by ".$orderby;  
	  
	  $sql.=$cadOrderBy;    
	  
	  $rs=$this->conDB->execute($sql);
	  return($rs); 	
  	}
  	
  	function del($id)
  	{
  	  $sql=<<<mya
  	delete from parametro 
  	where par_id=$id    
mya;
      $rs=$this->conDB->execute($sql);
      return($id);   
  	}
  	
  	function add()
  	{
  	    $existe=$this->existe($this->par_nombre);
  	    if($existe==0)//no existe
  	    {
  	        $sql=<<<mya
  	          insert into parametro 
  	          (par_nombre) 
  	          values 
  	          ('$this->par_nombre')
mya;
            $rs=$this->conDB->execute($sql);
            $res=$this->existe($this->par_nombre);
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="Parametro ya existe";
  	        $res=$existe;
  	    }
  	    return($res); 
  	}
  	
  	function upd($id)
  	{
  	    $oAux=new cParametro($this->conDB);
  	    $existe=$oAux->info($id);
  		
  	    if($existe!=0)//no existe
  	    {
  	        $sql=<<<mya
  	          update parametro 
  	          set par_nombre='$this->par_nombre'  
  	          where 
  	          par_id=$id
mya;
            $rs=$this->conDB->execute($sql);
            $res=$id;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="Parametro no existe y no se puede actualizar";
  	        $res=$id;
  	    }
  	    return($res); 
  	}
  }

?>