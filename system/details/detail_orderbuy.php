<?php
session_start();
include_once("../../backend/config.php");
include_once("../../link/link-2.php");
include_once("../../components/component.php");
$ordersell_id = $_GET['orderbuy_id'];
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
$sql = mysqli_query($conn,"SELECT * FROM order_box WHERE order_id=$ordersell_id") or die(mysqli_error($conn));
$row_sql = mysqli_fetch_assoc($sql);
$count = mysqli_query($conn,"SELECT COUNT(*) AS totals, SUM(product_count) AS counts FROM stock_product WHERE id_order=$ordersell_id") or die(mysqli_error($conn));
$row_count = mysqli_fetch_assoc($count);
$total_item = $row_count['totals'];
$total_price = $row_count['counts'];

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
      <?php navbar("รายละเอียดคำสั่งซื้อ / ".$row_sql['order_name']."", "../"); ?>
      <div class="container-fluid row">
          <div class="col-md-12 mt-4 card shadow-lg rounded">
            <?php listDetailOrderBuy(
                  $row_sql['order_id'], $row_sql['order_name'], $row_sql['totalcost_order'],$row_sql['date_time_order'],
                  $row_sql['slip_order'],$row_count['totals'],$row_count['counts'],
                  ) ?>
          </div>

          <div class="col-md-12 mt-4">
            <div class="table-responsive table-responsive-data2 mt-2">
                  <table class="table table-data2 mydataTablePatron">
                      <thead>
                          <tr>
                              <th>ลำดับ</th> 
                              <th>สินค้า</th>
                              <th>ราคาต้นทุนต่อชิ้น</th>
                              <th>จำนวน</th>
                              <th>ราคารวม</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                            $sql_product = mysqli_query($conn,"SELECT * FROM stock_product WHERE id_order=$ordersell_id") or die(mysqli_error($conn));
                            foreach($sql_product as $key => $res){
                              listProductBuy(($key + 1), $res['product_id'],$res['product_name'],$res['product_price'], $res['product_count'],$res['expenses']);
                            }
                          ?>
                      </tbody>
                  </table> 
            </div>
          </div>
      </div>
    </main>
  </div>
</body>
</html>