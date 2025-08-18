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
         $order_id = $_GET['order_id'];
          $sqlList = "SELECT * FROM stock_product WHERE id_order='$order_id'";
          $query = mysqli_query($conn, "SELECT * FROM stock_product WHERE id_order='$order_id'")or die(mysqli_error($conn));
          $num_row = mysqli_num_rows($query);
          
          if($num_row > 0){
             $get_data = array();
             foreach($query as $res_data){
               $get_data[] = $res_data;
             }
             header('Content-Type: application/json');
             //echo json_encode($get_data);
              print json_encode(array(
                'status'=> 201,
                'message'=> 'get data is success',
                'data'=> $get_data
              ));
              mysqli_close($conn);
         }else{
           print json_encode(array(
               'status'=> 201,
               'message'=> 'get data is success',
               'data'=> null
             ));
         }
     }
?>