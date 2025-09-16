<?php
session_start();
include_once("../../backend/config.php");
include_once("../../link/link-2.php");
include_once("../../components/component.php");
$ordersell_id = $_GET['ordersell_id'];
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
if(!isset($_SESSION['users_order'])){
  echo "
          <script>
              alert('pless your login');
              window.location = '../index.php';
          </script>
      ";
}

$sql = "SELECT * FROM orders_sell LEFT JOIN sell_typepay ON orders_sell.id_ordersell = sell_typepay.ordersell_id WHERE id_ordersell='$ordersell_id'";
$sql_query = mysqli_query($conn,$sql) or die(mysqli_error($conn));

$count_query = mysqli_query($conn, "SELECT COUNT(*) AS total, SUM(tatol_product) AS total_product FROM list_productsell WHERE ordersell_id='$ordersell_id'");
$count_row = mysqli_fetch_assoc($count_query);

$res_acc = [];
while($row = mysqli_fetch_assoc($sql_query)){

  $res_acc[] = $row;
}
$order = null;
$sell_type = [];



foreach($res_acc as $rows){
  if(!$order){
    $order = [
      'id_ordersell' => $rows['id_ordersell'],
      'ordersell_name' => $rows['ordersell_name'],
      'is_totalprice' => $rows['is_totalprice'],
      'count_totalpays' => $rows['count_totalpays'],
      'count_stuck' => $rows['count_stuck'],
      'custome_name' => $rows['custome_name'],
      'tell_custome' => $rows['tell_custome'],
      'location_send' => $rows['location_send'],
      'date_time_sell' => $rows['date_time_sell'],
      'shipping_note' => $rows['shipping_note'],
      'sender' => $rows['sender'],
      'tell_sender' => $rows['tell_sender'],
      'wages' => $rows['wages'],
      'reason' => $rows['reason'],
      'slip_ordersell' => $rows['slip_ordersell'],
      'adder_id' => $rows['adder_id'],
      'create_at' => $rows['create_at'],
    ];
  }
  $sell_type[] = [
    'typepay_id' => $rows['typepay_id'],
    'ordersell_id' => $rows['ordersell_id'],
    'list_typepay' => $rows['list_typepay'],
  ];
}

  function status_pay($list_typepay){
      if(is_string($list_typepay)){
          $list_typepay = explode(",", str_replace(' ', '', $list_typepay));
      }
      $hasMandatory = in_array("ติดค้าง", $list_typepay);
      $hasOption = !empty(array_intersect(["โอน", "จ่ายสด"], $list_typepay));
      if($hasMandatory && $hasOption){
          return "<span class='text-danger'>จ่ายแล้วแต่ยังติดค้างอยู่</span>";
      } else if(in_array("โอน", $list_typepay)){
          return "<span class='text-success'>โอนจ่ายแล้ว</span>";
      } else if(in_array("จ่ายสด", $list_typepay)){
          return "<span class='text-success'>จ่ายสดแล้ว</span>";
      } else if(in_array("ติดค้าง", $list_typepay)){
          return "<span class='text-danger'>ติดค้าง</span>";
      } else {
          return "<span class='text-secondary'>ไม่มีข้อมูล</span>";
      }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/css/uikit.css">
    <link rel="stylesheet" href="../../assets/scripts/module/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
    <link rel="stylesheet" href="../../assets/scss/navigationTrue-a-j.scss">
    <link rel="stylesheet" href="../../assets/scss/revenue.scss">
    
    <script src="../../assets/scripts/script-bash.js"></script>
  <title>Document</title>
</head>
<body>
  <div class="page-wrapper chiller-theme toggled">
      <?php  navigationOfiicer("../"); ?>
       <main class="page-content mt-0">
      <?php navbar("รายละเอียดคำสั่งขาย / ".$order['ordersell_name']."", "../"); ?>
      <div class="container-fluid row">
          <div class="col-md-12 mt-4 card shadow-lg rounded">
            
              <?php 
                detailOrderSell(
                  $order['id_ordersell'],$order['ordersell_name'],$order['is_totalprice'],$order['custome_name'],$order['tell_custome'],$order['location_send'],
                  $order['date_time_sell'],$count_row['total'],$count_row['total_product'],$order['reason'],$order['sender'],$order['tell_sender'],$order['count_totalpays'],
                  $order['count_stuck'],$order['slip_ordersell'],$order['adder_id'],$order['create_at'],$sell_type,
                );
                
              ?>
          </div>

          <div class="col-md-12 mt-4">
            <div class="table-responsive table-responsive-data2 mt-2">
                  <table class="table table-data2 mydataTablePatron">
                      <thead>
                          <tr>
                              <th>ลำดับ</th> 
                              <th>สินค้า</th>
                              <th>ราคาต่อชิ้น</th>
                              <th>จำนวน</th>
                              <th>ราคารวม</th>
                              <th>ประเภทลูกค้า</th>
                              <th>จัดการ</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                              $query_product = mysqli_query($conn,"SELECT * FROM list_productsell WHERE ordersell_id='$ordersell_id'") or die(mysqli_error($conn));
                              foreach($query_product as $key=>$res){
                                listProductSell(($key+1), $res['list_sellid'], $res['productname'],$res['rate_customertype'],$res['type_custom'],$res['tatol_product'],$res['price_to_pay']);
                              }
                          ?>
                      </tbody>
                  </table> 
            </div>
          </div>
      </div>
      <main-rate-price></main-rate-price>
    </main>
  </div>
  <script src="../../assets/scripts/ui-stock.js"></script>
</body>
</html>