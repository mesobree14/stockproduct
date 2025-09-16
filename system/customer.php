<?php
session_start();
include_once("../backend/config.php");
include_once("../link/link-2.php");
include_once("../components/component.php");
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
    <link rel="stylesheet" href="../assets/scripts/module/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
    <link rel="stylesheet" href="../assets/scss/navigationTrue-a-j.scss">
    <link rel="stylesheet" href="../assets/scss/revenue.scss">
    <link rel="stylesheet" href="../assets/scripts/module/test/test.scss">
    <script src="../assets/scripts/module/test/test.js"></script>
    <script src="../assets/scripts/script-bash.js"></script>
  <title>Document</title>
</head>
<body>
  <div class="page-wrapper chiller-theme toggled">
    <?php  navigationOfiicer(); ?>
    <main class="page-content mt-0">
      <?php navbar("ข้อมูลลูกค้า"); ?>
      <div class="container-fluid">
        <div class="col-12 row mt-2">
          <div class="col-md-12 border-right">
            <div class="table-responsive table-responsive-data2 mt-2">
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th style="width:27%">ชื่อลูกค้า</th>
                            <th style="width:15%">รายการที่ซื้อ</th>
                            <th style="width:15%">รวมค่าใช้จ่าย</th>
                            <th style="width:15%">จำนวนเงินที่จ่ายแล้ว</th>
                            <th style="width:15%">จำนวนหนี้ที่ติดค้างอยู่</th>
                            <th style="width:13%">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sql = "SELECT COUNT(*) AS count_order, SUM(is_totalprice) AS prices_sell, custome_name, SUM(count_totalpays) AS prices_pay, SUM(count_stuck) AS count_stuck FROM orders_sell GROUP BY custome_name";
                        $query_sql = mysqli_query($conn,$sql) or die(mysqli_error($conn));
                        $nums = mysqli_num_rows($query_sql);
                        if($nums > 0){
                          foreach($query_sql as $key => $res){
                            listCustomer(($key+1),$res['custome_name'],$res['count_order'],$res['prices_sell'],$res['prices_pay'],$res['count_stuck']);
                          }
                        }
                      ?>
                    </tbody>
                </table>
            </div>
          </div>

        </div>
      </div>
    </main>
  </div>
</body>
</html>