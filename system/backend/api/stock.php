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
          $sql_stock = "SELECT stock_product.product_name, rate_price.price_custommer_vip, 
                rate_price.price_customer_frontstore,rate_price.price_customer_deliver, rate_price.price_customer_dealer,
                COUNT(*) total,SUM(product_count * product_price) AS resutl_price, SUM(product_count) AS total_count
                
                FROM stock_product LEFT JOIN rate_price ON stock_product.product_name = rate_price.product_name GROUP BY stock_product.product_name";
          $query = mysqli_query($conn, $sql_stock)or die(mysqli_error($conn));
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