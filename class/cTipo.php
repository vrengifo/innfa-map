<?php
  class cTipo
  {
  	var $tip_id;
  	var $tip_nombre;
  	var $tip_icono;
  	var $tipmap_id;
  	var $tip_orden;
  	
  	var $conDB;
  	
  	var $msg;
  	
  	function __construct($con)
  	{
  		$this->conDB=$con;
  		
  		$this->tip_id="";
  		$this->tip_nombre="";
  		$this->tip_icono="";
  		$this->tipmap_id="";
  		$this->tip_orden=0;
  		
  		$this->msg="";
  	}
  	
  	function info($id)
  	{
  	  $sql=<<<mya
	  	select tip_id,tip_nombre,tip_icono,tipmap_id,tip_orden 
	  	from tipo
	  	where tip_id='$id'
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$this->msg="Error, Tipo no encontrado";
			$res="";
		}
		else 
		{
			$this->tip_id=$rs->fields[0];
			$this->tip_nombre=$rs->fields[1];
			$this->tip_icono=$rs->fields[2];
			$this->tipmap_id=$rs->fields[3];
			$this->tip_orden=$rs->fields[4];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function existe($id)
  	{
  	  $sql=<<<mya
	  	select tip_id
	  	from tipo
	  	where tip_id=$id
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$res="";
		}
		else 
		{
			$this->tip_id=$rs->fields[0];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function rsAdmin($orderby="")
  	{
  	  $sql=<<<mya
	  select tip_id,tip_nombre 
	  from tipo 
mya;
	  if(strlen($orderby)==0)
	    $cadOrderBy=" order by tip_nombre ";
	  else 
	    $cadOrderBy=" order by ".$orderby;  
	  
	  $sql.=$cadOrderBy;    
	  
	  $rs=$this->conDB->execute($sql);
	  return($rs); 	
  	}
  	
  	function del($id)
  	{
  	  $sql=<<<mya
  	delete from tipo 
  	where tip_id=$id    
mya;
      $rs=$this->conDB->execute($sql);
      return($id);   
  	}
  	
  	function add()
  	{
  	    $existe=$this->existe($this->tip_id);
  	    if($existe=="")//no existe
  	    {
  	        $sql=<<<mya
  	          insert into tipo 
  	          (tip_id,tip_nombre,tip_icono,tip_orden) 
  	          values 
  	          ($this->tip_id,'$this->tip_nombre','$this->tip_icono','$this->tip_orden')
mya;
            $rs=$this->conDB->execute($sql);
            $res=$this->tip_id;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="tipo ya existe";
  	        $res=$this->tip_id;
  	    }
  	    return($res); 
  	}
  	
  	function upd($id)
  	{
  	    $existe=$this->existe($id);
  	    if($existe!="")//no existe
  	    {
  	        $sql=<<<mya
  	          update tipo 
  	          set tip_nombre='$this->tip_nombre',tip_icono='$this->tip_icono',tip_orden='$this->tip_orden' 
  	          where 
  	          tip_id=$id
mya;
            $rs=$this->conDB->execute($sql);
            $res=$id;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="tipo no existe y no se puede actualizar";
  	        $res=$id;
  	    }
  	    return($res); 
  	}
  	
  	function rsSelect($orderby="")
  	{
  		if(strlen($orderby)==0)
  		{
  			$cadOrder=" order by tip_nombre ";
  		}
  		else 
  		{
  			$cadOrder=" order by ".$orderby;
  		}
  		
  		$sql=<<<mya
		select tip_id,tip_nombre,tip_orden 
		from tipo
		$orderby
mya;

  		$rs=$this->conDB->execute($sql);
	  return ($rs);
  	}
  	
  	function opcionImg($tipmapId)
  	{
  		$sql=<<<mya
  		select tip_nombre,tip_icono,tip_orden 
  		from tipo
  		where tipmap_id=$tipmapId 
  		order by tip_orden asc
mya;
  		$rs=&$this->conDB->execute($sql);
  		$cad="";
  		while(!$rs->EOF)
  		{
  		  $tipNombre=$rs->fields[0];
  		  $tipIcono=$rs->fields[1];
  		  $tipOrden=$rs->fields[2];
  		  
  		  $cadAux=<<<mya
  		<tr>
          <td width="18%" align="center">
		    <img src="../$tipIcono" name="i$tipNombre" id="i$tipNombre" class="dragme"/>
		  </td>
		  <td width="82%">$tipNombre</td>
        </tr>
mya;
		  $cad.=$cadAux;
		  $rs->next();
  		}
  		return($cad); 
  	}
  	
  }

?>