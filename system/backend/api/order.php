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
     }elseif($_SERVER['REQUEST_METHOD'] === "DELETE"){
        $order_id = $_GET['order_id'];
        $arr = [];
        $countsuccess = 0;
        $trashimg = "";
        $sql = mysqli_query($conn, "SELECT * FROM order_box WHERE order_id=$order_id");
        if(mysqli_num_rows($sql) > 0){
          $data = mysqli_fetch_assoc($sql);
          $trash_order = mysqli_query($conn,"DELETE FROM order_box WHERE order_id=$order_id");
          if($trash_order){
            if($data['slip_order'] !== ""){
              if(file_exists(__DIR__ . "/../../../db/slip-orders/" . $data['slip_order'])){
              if(unlink(__DIR__ . "/../../../db/slip-orders/" . $data['slip_order'])){
                  $trashimg = "unlink success";
                };
              }
            }
            $get_stock = mysqli_query($conn, "SELECT id_order,product_name FROM stock_product WHERE id_order=$order_id");
            $rows = mysqli_num_rows($get_stock);
            if($rows > 0){
              foreach($get_stock as $res){
                $trash_stock = mysqli_query($conn, "DELETE FROM stock_product WHERE id_order=$order_id");
                if($trash_stock){
                  $countsuccess++;
                  $arr[] = [
                    'name' => $res['product_name'],
                    'status'=> 'success'
                  ];
                }else{
                  $arr[] = [
                    'name' => $res['product_name'],
                    'status' => 'fail'
                  ];
                }
              }
              print json_encode(array(
                'status'=> 201,
                'order_id'=> $order_id,
                'trashimg' => $trashimg,
                'message' => 'delete finished',
                'success_count' => $countsuccess,
                'result' => $arr
              ));
            }
          }
        }
     }
?>