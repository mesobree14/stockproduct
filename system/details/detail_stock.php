<?php
session_start();
include_once("../../backend/config.php");
include_once("../../link/link-2.php");
include_once("../../components/component.php");
$product_name = $_GET['product_name'];
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
    <link rel="stylesheet" href="../../assets/scss/index.u.scss">
    <script src="../../assets/scripts/script-bash.js"></script>
  <title>Document</title>
</head>
<body>
  <div class="page-wrapper chiller-theme toggled">
      <?php  navigationOfiicer("../"); ?>
       <main class="page-content mt-0">
      <?php navbar("รายละเอียด / ".$product_name."", "../"); ?>
      <div class="container-fluid row">
          <div class="col-md-12">
            <?php
              $sql = "SELECT product_name, product_price,
               COUNT(*) total,SUM(product_count * product_price) AS resutl_price, SUM(product_count) AS total_count FROM stock_product WHERE product_name='$product_name' GROUP BY product_name";
               $selectStockProduct = mysqli_query($conn,$sql) or die(mysqli_error($conn));
               $acc_fetch = mysqli_fetch_assoc($selectStockProduct);

              $sql_sell = "SELECT productname,COUNT(*) AS counts, SUM(tatol_product) AS total_products, SUM(price_to_pay) AS prices FROM list_productsell WHERE productname='$product_name' GROUP BY productname";
              $quer_sell = mysqli_query($conn,$sql_sell) or die(mysqli_error($conn));
              $acc_sell = mysqli_fetch_assoc($quer_sell);
 
               detailStock($acc_fetch['product_name'],$acc_fetch['total_count'], $acc_fetch['resutl_price'],$acc_fetch['product_price'], $acc_sell['total_products'] ?? 0,$acc_sell['prices'] ?? 0,$acc_sell['counts'] ?? 0);
            ?>
          </div>
          <div class="col-md-12 mt-4">
                <div class="table-responsive table-responsive-data2 mt-2">
                  <table class="table table-data2 mydataTablePatron">
                    <thead>
                       <tr>
                          <th class="font-weight-bold">ลำดับ</th>
                          <th class="font-weight-bold">ราคา หน้าร้าน</th>
                          <th class="font-weight-bold">ราคา วีไอพี่</th>
                          <th class="font-weight-bold">ราคา ตัวแทนจำหน่าย</th>
                          <th class="font-weight-bold">ราคา จัดส่ง</th>
                          <th class="font-weight-bold">จัดการ</th>
                       </tr>
                    </thead>
                    <tbody>
                      <?php
                        
                          $sql = "SELECT * FROM rate_price WHERE product_name='$product_name'";
                          $query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
                          $rate_acc_fetch = mysqli_fetch_assoc($query);
                          if($rate_acc_fetch){
                            listRatePrice(
                              $rate_acc_fetch['rate_id'],$rate_acc_fetch['price_customer_frontstore'],$rate_acc_fetch['price_custommer_vip'],
                              $rate_acc_fetch['price_customer_dealer'],$rate_acc_fetch['price_customer_deliver'],$product_name,$acc_fetch['product_price']
                            );
                          }else{
                            listRatePrice("","","","","",$product_name,$acc_fetch['product_price']);
                          }
                      ?>
                    </tbody>
                  </table>
                </div>
          </div>
          <div class="col-md-12 mt-4">
            <div class="table-responsive table-responsive-data2 mt-2">
                  <table class="table table-data2 mydataTablePatron">
                      <thead>
                          <tr>
                              <th>ลำดับ</th> 
                              <th>ชื่อ</th>
                              <th>จากคำสั่งซื้อ</th>
                              <th>ราคาต่อชิ้น</th>
                              <th>จำนวน</th>
                              <th>ราคารวม</th>
                              <th>เวลา</th>
                              <th>จัดการ</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                              $get_sql = "SELECT * FROM stock_product LEFT JOIN order_box ON order_box.order_id = stock_product.id_order WHERE stock_product.product_name='$product_name' ORDER BY stock_product.create_at DESC";
                               $get_datastock = mysqli_query($conn, $get_sql) or die(mysqli_error($conn));
                                foreach($get_datastock as $key => $res){
                                    tableDetailStock(
                                        ($key+1), $res['product_id'], $res['product_name'],$res['product_count'],$res['product_price'],
                                        $res['order_name'],$res['date_time_order']
                                      );
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