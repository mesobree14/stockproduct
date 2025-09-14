<?php

  include_once("../../../backend/config.php");
  if(!$conn){
    die("not conn");
    
  }
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");	
   header("Cache-Control: post-check=0, pre-check=0", false);	
    header("Pragma: no-cache");
    date_default_timezone_set("Asia/Bangkok");
    if($_SERVER['REQUEST_METHOD'] === "GET"){
      $sql = "SELECT custome_name,
      GROUP_CONCAT(DISTINCT tell_custome ORDER BY tell_custome SEPARATOR ',') AS customtell,
      GROUP_CONCAT(DISTINCT location_send ORDER BY location_send SEPARATOR ',') AS customlocation 
      FROM orders_sell GROUP BY custome_name";
      $query_sql = mysqli_query($conn,$sql);
      $result_data = [];
      while($row = mysqli_fetch_assoc($query_sql)){
        $row['customtell'] = explode(",", $row['customtell']);
        $row['customlocation'] = [trim($row['customlocation'])]; //explode(",", $row['customlocation']);
        $result_data[] = $row;
      }

      print json_encode([
        'status'=> 201,
        'message' => 'get api customer is success',
        'data' => $result_data
      ],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
      mysqli_close($conn);
    }
?>