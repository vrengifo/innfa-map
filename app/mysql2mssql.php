<?php
  include_once("class/c_conecta.php");
  
  //conMysql
  $conMysql=new c_conecta("MySQL","localhost","uinnfamap","uinnfamap","innfamap");
  
  //conMssql
  $conMssql=new c_conecta("MSSQL","VARS2000","uinnfamap","uinnfamap","innfamap");
  
  /*//tipomapa
  $sql=<<<mya
  select tipmap_id,tipmap_nombre from tipomapa
mya;
  $rsMysql=&$conMysql->execute($sql);
  
  while(!$rsMysql->EOF)
  {
  	$tipmapId=$rsMysql->fields[0];
  	$tipmapNombre=$rsMysql->fields[1];
  	
  	$sqlI=<<<mya
  insert into tipomapa values
  ('$tipmapId','$tipmapNombre')
mya;
  $rsI=&$conMssql->execute($sqlI);
  	
  	$rsMysql->next();
  }*/
  
  /*//tipo
  $sql=<<<mya
  select tip_id,tipmap_id,tip_nombre,tip_icono,tip_orden 
  from tipo
mya;
  $rsMysql=&$conMysql->execute($sql);
  
  while(!$rsMysql->EOF)
  {
  	$tipId=$rsMysql->fields[0];
  	$tipmapId=$rsMysql->fields[1];
  	$tipNombre=$rsMysql->fields[2];
  	$tipIcono=$rsMysql->fields[3];
  	$tipOrden=$rsMysql->fields[4];
  	
  	$sqlI=<<<mya
  insert into tipo values
  ('$tipId',$tipmapId,'$tipNombre','$tipIcono',$tipOrden)
mya;
  $rsI=&$conMssql->execute($sqlI);
  	
  	$rsMysql->next();
  }*/
  
  //geografia
  $sql=<<<mya
  select tip_id,prov_id,can_id,parr_id,geo_nombre  
  from geografia
mya;
  $rsMysql=&$conMysql->execute($sql);
  
  while(!$rsMysql->EOF)
  {
  	$tipId=$rsMysql->fields[0];
  	$provId=$rsMysql->fields[1];
  	$canId=$rsMysql->fields[2];
  	$parrId=$rsMysql->fields[3];
  	$geoNombre=$rsMysql->fields[4];
  	
  	$sqlI=<<<mya
  insert into geografia values
  ('$tipId','$provId','$canId','$parrId','$geoNombre')
mya;
  $rsI=&$conMssql->execute($sqlI);
  	
  	$rsMysql->next();
  }
  
  //innfa
  $sql=<<<mya
  select tip_id,utd_id,coord_id,prov_id,inn_nombre 
  from innfa
mya;
  $rsMysql=&$conMysql->execute($sql);
  
  while(!$rsMysql->EOF)
  {
  	$tipId=$rsMysql->fields[0];
  	$utdId=$rsMysql->fields[1];
  	$coorId=$rsMysql->fields[2];
  	$provId=$rsMysql->fields[3];
  	$innNombre=$rsMysql->fields[4];
  	
  	$sqlI=<<<mya
  insert into innfa values
  ('$tipId',$utdId,$coorId,$provId,'$innNombre')
mya;
  $rsI=&$conMssql->execute($sqlI);
  	
  	$rsMysql->next();
  }
  
  //indicador
  $sql=<<<mya
  select indi_id,indi_nombre,indi_descripcion 
  from indicador
mya;
  $rsMysql=&$conMysql->execute($sql);
  
  while(!$rsMysql->EOF)
  {
  	$indiId=$rsMysql->fields[0];
  	$indiNombre=$rsMysql->fields[1];
  	$indiDescripcion=$rsMysql->fields[2];
  	
  	$sqlI=<<<mya
  insert into indicador values
  ($indiId,'$indiNombre','$indiDescripcion')
mya;
  $rsI=&$conMssql->execute($sqlI);
  	
  	$rsMysql->next();
  }
  
  //parametro
  $sql=<<<mya
  select par_id,par_nombre 
  from parametro
mya;
  $rsMysql=&$conMysql->execute($sql);
  
  while(!$rsMysql->EOF)
  {
  	$parId=$rsMysql->fields[0];
  	$parNombre=$rsMysql->fields[1];
  	
  	$sqlI=<<<mya
  insert into parametro values
  ($parId,'$parNombre')
mya;
  $rsI=&$conMssql->execute($sqlI);
  	
  	$rsMysql->next();
  }
  
  //parametroxindicador
  $sql=<<<mya
  select indi_id,par_id,parxind_page,parxind_parametro 
  from parametroxindicador
mya;
  $rsMysql=&$conMysql->execute($sql);
  
  while(!$rsMysql->EOF)
  {
  	$indiId=$rsMysql->fields[0];
  	$parId=$rsMysql->fields[1];
  	$parxindPage=$rsMysql->fields[2];
  	$parxindParametro=$rsMysql->fields[3];
  	
  	$sqlI=<<<mya
  insert into parametroxindicador values
  ($indiId,$parId,'$parxindPage','$parxindParametro')
mya;
  $rsI=&$conMssql->execute($sqlI);
  	
  	$rsMysql->next();
  }
  
  //usuario
  $sql=<<<mya
  select usu_id,usu_clave,usu_nombre 
  from usuario
mya;
  $rsMysql=&$conMysql->execute($sql);
  
  while(!$rsMysql->EOF)
  {
  	$usuId=$rsMysql->fields[0];
  	$usuClave=$rsMysql->fields[1];
  	$usuNombre=$rsMysql->fields[2];
  	
  	$sqlI=<<<mya
  insert into usuario values
  ('$usuId','$usuClave','$usuNombre')
mya;
  $rsI=&$conMssql->execute($sqlI);
  	
  	$rsMysql->next();
  }
  
  $conMssql->close();
  $conMysql->close();
  
?>