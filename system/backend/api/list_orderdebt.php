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
      $customers = $_GET['customers'];
      //echo $customers;
      $sql = "SELECT 
        OS.id_ordersell,OS.ordersell_name,OS.is_totalprice,OS.custome_name,OS.date_time_sell,OS.count_totalpays,OS.count_stuck,
        IFNULL(SUM(OP.amount_paid), 0) AS total_paid,
        (OS.count_stuck - IFNULL(SUM(OP.amount_paid), 0)) AS debt_remaining
        FROM orders_sell OS LEFT JOIN order_was_paid OP ON OS.id_ordersell = OP.ordersell_ids
        WHERE OS.custome_name='$customers' AND OS.count_stuck > 0
        GROUP BY OS.id_ordersell, OS.ordersell_name, OS.is_totalprice,OS.count_stuck,OS.custome_name
        HAVING total_paid < OS.count_stuck";
      $result = mysqli_query($conn,$sql);
      $data = [];
      while($row = mysqli_fetch_assoc($result)){
        $data[] = [
          "id_ordersell"   => $row['id_ordersell'],
          "ordersell_name" => $row['ordersell_name'],
          "custome_name"   => $row['custome_name'],
          "date_time_sell" => $row['date_time_sell'],
          "total_price"    => (float)$row['is_totalprice'],
          "total_paid"     => (float)$row['total_paid'],
          "debt_remaining" => (float)$row['debt_remaining']
        ];
      }
      //  print json_encode([
      //   'status'=> 201,
      //   'message' => 'get api customer is success',
      //   'data' => $data
      // ],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
      print json_encode(array(
        'status'=> 201,
        'message'=> 'get data is success',
        'data'=> $data
      ));
      mysqli_close($conn);
    }
?>