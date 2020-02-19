<?php
  session_start();
  extract($_REQUEST);
  session_unregister("sUsuId");
  
  header("location:index.php?msg=".$msg);
  
?>