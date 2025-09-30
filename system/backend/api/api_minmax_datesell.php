<?php

  include_once("../../../backend/config.php");
  if(!$conn){
    die("not conn");
    
  }
   header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");	
   header("Cache-Control: post-check=0, pre-check=0", false);	
    header("Pragma: no-cache");
    date_default_timezone_set("Asia/Bangkok");
?>