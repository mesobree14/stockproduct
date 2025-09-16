<?php
session_start();
include_once("../../backend/config.php");
include_once("../../link/link-2.php");
include_once("../../components/component.php");
$custom_name = $_GET['custom_name'];
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
      <?php navbar("รายละเอียดลูกค้า / ".$custom_name."", "../"); ?>
      <div class="container-fluid row">
          <div class="col-md-12">
            <?php
              $sql = "SELECT COUNT(*) AS count_order, SUM(is_totalprice) AS prices_sell, custome_name, SUM(count_totalpays) AS prices_pay, SUM(count_stuck) AS count_stuck FROM orders_sell WHERE custome_name='$custom_name' GROUP BY custome_name";
              $query_sqli = mysqli_query($conn,$sql) or die(mysqli_error($conn));
              $rows = mysqli_fetch_assoc($query_sqli);

              $sql_tell = mysqli_query($conn,"SELECT tell_custome FROM orders_sell WHERE custome_name='$custom_name' GROUP BY tell_custome");
              $sql_location = mysqli_query($conn,"SELECT location_send FROM orders_sell WHERE custome_name='$custom_name' GROUP BY location_send");
            ?>
          </div>
          
            <div id="tab02" class="tab-contents">
                <div class="table-responsive table-responsive-data2 mt-2">
                  <span>ประวัติการสั่งซื้อ</span>
                  <table class="table table-data2 mydataTablePatron">
                    <thead>
                        <tr>
                            <th>ลำดับ</th> 
                            <th>รหัสรายการขาย</th>
                            <th>วันที่สั่งซื้อ</th>
                            <th>ราคา</th>
                            <th>ราคาที่จ่าย</th>
                            <th>ราคาที่ติดค้าง</th>
                            <th>รายการสินค้า</th>
                            <th>จำนวนชิ้น</th>
                        </tr>
                    </thead>
                    <tbody>
                
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
      </div>
      <main-rate-price></main-rate-price>
    </main>
  </div>
  <script src="../../assets/scripts/ui-stock.js"></script>
</body>
</html>