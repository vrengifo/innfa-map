<?php
  class cUsuario
  {
  	var $usu_id;
  	var $usu_clave;
  	var $usu_nombre;
  	
  	var $conDB;
  	
  	var $msg;
  	
  	function __construct($con)
  	{
  		$this->conDB=$con;
  		
  		$this->usu_id="";
  		$this->usu_clave="";
  		$this->usu_nombre="";
  		
  		$this->msg="";
  	}
  	
  	function autenticar($usuario,$clave)
  	{
  		$sql=<<<mya
	  	select usu_id,usu_nombre 
	  	from usuario
	  	where usu_id='$usuario' and usu_clave='$clave'	
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$this->msg="Error, usuario no identificado";
			$res=0;
		}
		else 
		{
			$this->usu_id=$rs->fields[0];
			$this->usu_nombre=$rs->fields[1];
			
			$this->msg="";
			$res=1;
		}
		return($res); 
  	}
  	
  	function info($id)
  	{
  	  $sql=<<<mya
	  	select usu_id,usu_clave,usu_nombre 
	  	from usuario
	  	where usu_id='$id'
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$this->msg="Error, usuario no encontrado";
			$res="";
		}
		else 
		{
			$this->usu_id=$rs->fields[0];
			$this->usu_clave=$rs->fields[1];
			$this->usu_nombre=$rs->fields[2];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function existe($id)
  	{
  	  $sql=<<<mya
	  	select usu_id
	  	from usuario
	  	where usu_id='$id'
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$res="";
		}
		else 
		{
			$this->usu_id=$rs->fields[0];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function rsAdmin($orderby="")
  	{
  	  $sql=<<<mya
	  select usu_id,usu_nombre
	  from usuario 
mya;
	  if(strlen($orderby)==0)
	    $cadOrderBy=" order by usu_id ";
	  else 
	    $cadOrderBy=" order by ".$orderby;  
	  
	  $sql.=$cadOrderBy;    
	  
	  $rs=$this->conDB->execute($sql);
	  return($rs); 	
  	}
  	
  	function del($id)
  	{
  	  $sql=<<<mya
  	delete from usuario 
  	where usu_id='$id'    
mya;
      $rs=$this->conDB->execute($sql);
      return($id);   
  	}
  	
  	function add()
  	{
  	    $existe=$this->existe($this->usu_id);
  	    if($existe=="")//no existe
  	    {
  	        $sql=<<<mya
  	          insert into usuario 
  	          (usu_id,usu_clave,usu_nombre) 
  	          values 
  	          ('$this->usu_id','$this->usu_clave','$this->usu_nombre')
mya;
            $rs=$this->conDB->execute($sql);
            $res=$this->usu_id;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="Usuario ya existe";
  	        $res=$this->usu_id;
  	    }
  	    return($res); 
  	}
  	
  	function upd($id)
  	{
  	    $existe=$this->existe($id);
  	    if($existe!="")//no existe
  	    {
  	        $sql=<<<mya
  	          update usuario 
  	          set usu_clave='$this->usu_clave',usu_nombre='$this->usu_nombre' 
  	          where 
  	          usu_id='$id'
mya;
            $rs=$this->conDB->execute($sql);
            $res=$id;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="Usuario no existe y no se puede actualizar";
  	        $res=$id;
  	    }
  	    return($res); 
  	}
  }

?>