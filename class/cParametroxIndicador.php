<?php
  class cParametroxIndicador
  {
  	var $indi_id;
  	var $par_id;
  	var $parxind_page;
  	var $parxind_parametro;
  	
  	var $conDB;
  	
  	var $msg;
  	var $separador;
  	
  	function __construct($con)
  	{
  		$this->conDB=$con;
  		
  		$this->indi_id=0;
  		$this->par_id=0;
  		$this->parxind_page="";
  		$this->parxind_parametro="";
  		
  		$this->msg="";
  		$this->separador=":";
  	}
  	
  	function cad2id($cad)
  	{
  		list($this->indi_id,$this->par_id)=explode($this->separador,$cad);
  		return($cad);
  	}
  	
  	function id2cad($indId,$parId)
  	{
  		$cad=$indId.$this->separador.$parId;
  		return($cad); 
  	}
  	
  	function info($id)
  	{
  	  $oAux=new cParametroxIndicador($this->conDB);
  	  $oAux->cad2id($id);
  	  $sql=<<<mya
	  	select indi_id,par_id,parxind_page,parxind_parametro  
	  	from parametroxindicador 
	  	where indi_id=$oAux->indi_id and par_id=$oAux->par_id
mya;
		$rs=$this->conDB->execute($sql);
		if($rs->EOF)
		{
			$this->msg="Error, valor $id no encontrado";
			$res=0;
		}
		else 
		{
			$this->indi_id=$rs->fields[0];
			$this->par_id=$rs->fields[1];
			$this->parxind_page=$rs->fields[2];
			$this->parxind_parametro=$rs->fields[3];
			
			$this->msg="";
			$res=$id;
		}
		return($res);
  	}
  	
  	function existe($id)
  	{
  	  $oAux=new cParametroxIndicador($this->conDB);
  	  $oAux->cad2id($id);
      $sql=<<<mya
	  	select indi_id,par_id
	  	from parametroxindicador
	  	where indi_id=$oAux->indi_id and par_id=$oAux->par_id 
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
  	
  	function cadSqlId()
  	{
  	    if($this->conDB->dbtype=="MySQL")
  	    {
  	        $cad=<<<mya
            concat(indi_id,'$this->separador',par_id)
mya;
  	    }
  	    
  	    if($this->conDB->dbtype=="MSSQL")
  	    {
  	        $cad=<<<mya
            rtrim(convert(char,indi_id))+'$this->separador'+rtrim(convert(char,par_id)))
mya;
  	    }
  	    
  	    return($cad);
  	}
  	
  	function cadSqlIdPrefijo($prefijo)
  	{
  	    if($this->conDB->dbtype=="MySQL")
  	    {
  	    	$cad="concat(".$prefijo."indi_id,'$this->separador',".$prefijo."par_id)";
  	    }
  	    
  	    if($this->conDB->dbtype=="MSSQL")
  	    {
  	        $cad="rtrim(convert(char,".$prefijo."indi_id))+'$this->separador'+rtrim(convert(char,".$prefijo."par_id)))";
  	    }
  	    
  	    return($cad);
  	}
  	
  	/*function rsAdmin($indiId,$orderby="")
  	{
  	  $cadId=$this->cadSqlIdPrefijo("pxi.");
  		
  	  $sql=<<<mya
	  select $cadId as identificador,p.par_nombre  
	  from parametroxindicador pxi, parametro p 
	  where pxi.indi_id=$indiId  
	  and 
mya;
	  if(strlen($orderby)==0)
	    $cadOrderBy=" order by parxind_page ";
	  else 
	    $cadOrderBy=" order by ".$orderby;  
	  
	  $sql.=$cadOrderBy;    
	  
	  $rs=$this->conDB->execute($sql);
	  return($rs); 	
  	}*/
  	
  	function del($id)
  	{
  	  $oAux=new cParametroxIndicador($this->conDB);
  	  $oAux->cad2id($id);
  	  $sql=<<<mya
  	delete from parametroxindicador 
  	where indi_id=$oAux->indi_id and par_id=$oAux->par_id    
mya;
      $rs=$this->conDB->execute($sql);
      return($id);   
  	}
  	
  	function create($cadId)
  	{
  		$oAux=new cParametroxIndicador($this->conDB);
  		
  		$existe=$oAux->existe($cadId);
  		
  		if($existe==0)
  		{
  		  //add	
  		  $res=$this->add();
		}
		else 
		{
		  //upd
		  $res=$this->upd($cadId);	
		}
		return ($res);
  	}
  	
  	function add()
  	{
  	    $oAux=new cParametroxIndicador($this->conDB);
  		$cadId=$oAux->id2cad($this->indi_id,$this->par_id);
  		
  		$existe=$this->existe($cadId);
  	    if($existe==0)//no existe
  	    {
  	        $sql=<<<mya
  	          insert into parametroxindicador 
  	          (indi_id,par_id,parxind_page) 
  	          values 
  	          ($this->indi_id,$this->par_id,'$this->parxind_page')
mya;
            $rs=$this->conDB->execute($sql);
            $res=$cadId;
            $this->msg="";
  	    }
  	    else 
  	    {
  	        $this->msg="Parametro x Indicador ya existe";
  	        $res=$existe;
  	    }
  	    return($res); 
  	}
  	
  	function upd($id)
  	{
  	    $oAux=new cParametroxIndicador($this->conDB);
  	    $existe=$oAux->info($id);
  		
  	    if($existe!=0)//no existe
  	    {
  	        $sql=<<<mya
  	          update parametroxindicador 
  	          set parxind_page='$this->parxind_page'  
  	          where 
  	          indi_id=$oAux->indi_id and par_id=$oAux->par_id 
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