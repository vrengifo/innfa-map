<?php
  class cIndicador
  {
  	var $indi_id;
  	var $indi_nombre;
  	var $indi_descripcion;
  	
  	var $conDB;
  	
  	var $msg;
  	
  	function __construct($con)
  	{
  		$this->conDB=$con;
  		
  		$this->indi_id=0;
  		$this->indi_nombre="";
  		$this->indi_descripcion="";
  		
  		$this->msg="";
  	}
  	
  	function info($id)
  	{
  	  $sql=<<<mya
	  	select indi_id,indi_nombre,indi_descripcion 
	  	from indicador
	  	where indi_id=$id
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$this->msg="Error, indicador no encontrado";
			$res=0;
		}
		else 
		{
			$this->indi_id=$rs->fields[0];
			$this->indi_nombre=$rs->fields[1];
			$this->indi_descripcion=$rs->fields[2];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function existe($nombre)
  	{
  	  $sql=<<<mya
	  	select indi_id
	  	from indicador
	  	where indi_nombre='$nombre'
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$res=0;
		}
		else 
		{
			$this->msg="";
			$res=$rs->fields[0];
		}
		return($res);
  	}
  	
  	function rsAdmin($orderby="")
  	{
  	  $sql=<<<mya
	  select indi_id,indi_nombre,indi_descripcion
	  from indicador 
mya;
	  if(strlen($orderby)==0)
	    $cadOrderBy=" order by indi_nombre ";
	  else 
	    $cadOrderBy=" order by ".$orderby;  
	  
	  $sql.=$cadOrderBy;    
	  
	  $rs=$this->conDB->execute($sql);
	  return($rs); 	
  	}
  	
  	function del($id)
  	{
  	  $sql=<<<mya
  	delete from indicador 
  	where indi_id=$id    
mya;
      $rs=$this->conDB->execute($sql);
      return($id);   
  	}
  	
  	function add()
  	{
  	    $existe=$this->existe($this->indi_nombre);
  	    if($existe==0)//no existe
  	    {
  	        $sql=<<<mya
  	          insert into indicador 
  	          (indi_nombre,indi_descripcion) 
  	          values 
  	          ('$this->indi_nombre','$this->indi_descripcion')
mya;
            $rs=$this->conDB->execute($sql);
            $res=$this->existe($this->indi_nombre);
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="Indicador ya existe";
  	        $res=$existe;
  	    }
  	    return($res); 
  	}
  	
  	function upd($id)
  	{
  	    $oAux=new cIndicador($this->conDB);
  	    $existe=$oAux->info($id);
  	    if($existe!=0)//no existe
  	    {
  	        $sql=<<<mya
  	          update indicador 
  	          set indi_nombre='$this->indi_nombre',indi_descripcion='$this->indi_descripcion' 
  	          where 
  	          indi_id=$id
mya;
            $rs=$this->conDB->execute($sql);
            $res=$id;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="indicador no existe y no se puede actualizar";
  	        $res=$id;
  	    }
  	    return($res);
  	}
  	
  	function sqlClienteIndicador()
  	{
  	  $sql=<<<mya
  	  select indi_id,indi_nombre
  	  from indicador
  	  order by indi_nombre
mya;
	  return($sql);
    }
    
    function sqlClienteParametroxIndicador($indiId)
  	{
  	  $sql=<<<mya
  	  select pxi.indi_id,pxi.par_id,p.par_nombre,pxi.parxind_page,pxi.parxind_parametro
  	  from parametroxindicador pxi, parametro p 
  	  where p.par_id=pxi.par_id 
  	  and pxi.indi_id=$indiId
  	  order by p.par_nombre
mya;
	  return($sql);
    }
  }

?>