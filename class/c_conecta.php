<?php
 class c_conecta
 {
    // Variables de la conexión a la BD
 	var $dbtype;
	var $dbserver;
    var $user;
	var	$password;
	var	$dbname;
	var $dbconnection;
	
	var $debug;

	
	//constructor
	function c_conecta($tipo="MySQL",$server="localhost",$user="root",$password="",$db="")
	{
	  $this->dbtype=$tipo;
	  $this->dbserver=$server;
	  $this->user=$user;
	  $this->password=$password;
	  $this->dbname=$db;
	 
	  $this->dbconnection=$this->connect();
	  
	  $this->debug=0;
	} 
	
 	function connect()
	{
		switch ($this->dbtype) 
		{
			case "MySQL":
        			$ebase_datos=mysql_pconnect($this->dbserver, $this->user, $this->password);
        			mysql_select_db($this->dbname);
					//$this->dbconnection=$ebase_datos;
        			return $ebase_datos;
    				break;;
    		case "MSSQL": //SqlServer
        			$ebase_datos=mssql_connect($this->dbserver, $this->user, $this->password);
        			mssql_select_db($this->dbname,$ebase_datos);
					//$this->dbconnection=$ebase_datos;
        			return $ebase_datos;
    				break;;		
   			default:
					$ebase_datos=@mysql_pconnect($this->dbserver, $this->user, $this->password);				
        			mysql_select_db($this->dbname);
					//$this->dbconnection=$ebase_datos;
    	            return $ebase_datos;
    				break;;
        }
    }
    
    function execute($sql)
	{
	  $rs=new recordset($this->dbconnection,$this->dbtype);
	  if($this->debug)
	  {
	    echo "<hr>".$this->dbtype.": ".$sql." <hr>";
	  }
	  $rs->execute($sql);
	  return($rs);
	}
    
    function close() 
	{
	  switch ($this->dbtype)
	  {	
	  	case "MySQL":
	  	  return mysql_close($this->dbconnection);
	  	  break;
	  	case "MSSQL":
	  	  return mssql_close($this->dbconnection);
	  	  break;  
	  	default:
	  	  return mysql_close($this->dbconnection);
	  }
	}
	
 }
 
 class recordset
 {
	var $dbconnection;
 	var $dbres;
 	var $dbtype;
	
	var $EOF;
	var $fields;
	
	function recordset($con,$dbtype)
	{
	  $this->dbconnection=$con;
	  $this->dbtype=$dbtype;
	  $this->EOF=0;
	  $this->dbres=0;	
	}
 	
	function execute($sql)
	{
	  switch ($this->dbtype)
	  {
	  	case "MySQL":
	  	  $rs=@mysql_query($sql, $this->dbconnection) or die(mysql_error());
	  	  break;
	  	case "MSSQL":
	  	  $rs=@mssql_query($sql, $this->dbconnection) or die(mssql_get_last_message());
	  	  break;
	  	default:
	  	  $rs=@mysql_query($sql, $this->dbconnection) or die(mysql_error());
	  }
      $this->dbres=$rs;
      if($this->total_records()==0)
        $this->EOF=1;
      else
      {
        $this->EOF=0;
        $this->fields=$this->retrieve();
      }
	  return($rs);
	}

	
	/**
	 * NO usada
	 *
	 * @param unknown_type $row
	 * @param unknown_type $query_atribute
	 * @return unknown
	 */
	function retrieve_value($row,$query_atribute)
	{
		if($query_atribute != "")
			$res=mysql_result($this->dbres,$row,$query_atribute);
		else
			$res=mysql_result($this->dbres,$row);
		return($res);	
	}
	
	function total_records() 
	{
		switch ($this->dbtype)
		{
			case "MySQL": 
			  $res=@mysql_num_rows($this->dbres);
			  break;
			case "MSSQL":
			  $res=@mssql_num_rows($this->dbres);
			  break;
			default:
			  $res=@mysql_num_rows($this->dbres);  
		}
		return($res);
	}
	
	function retrieve()
	{
	  if(!$this->EOF)
	  {
	    switch ($this->dbtype)
	    {
	      case "MySQL":
	        $row=$this->fields=mysql_fetch_row($this->dbres);
	        if($this->fields==0)
	    	{
	      	  $this->EOF=1;
	      	  mysql_free_result($this->dbres);
	    	}
	        break;
	      case "MSSQL":
	        $row=$this->fields=mssql_fetch_row($this->dbres);
	        if($this->fields==0)
	    	{
	      	  $this->EOF=1;
	      	  mssql_free_result($this->dbres);
	    	}	        
	        break;
	      default:
	        $row=$this->fields=mysql_fetch_row($this->dbres);
	        if($this->fields==0)
	    	{
	      	  $this->EOF=1;
	      	  mysql_free_result($this->dbres);
	    	}	          
	    }	  	
	  }
	  else
	  {
	  	switch ($this->dbtype)
	  	{
	  	  case "MySQL":
	  	    mysql_free_result($this->dbres);
	  	    $row=0;
	  	    break;
	  	  case "MSSQL":
	  	    mssql_free_result($this->dbres);
	  	    $row=0;
	  	    break;
	  	  default:
	  	    mysql_free_result($this->dbres);
	  	    $row=0;
	  	}
	  }
	  return($row);
	}
	
	function next()
	{
	  return($this->retrieve());
	}
}
?>
