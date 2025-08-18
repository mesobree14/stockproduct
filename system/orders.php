<?php
session_start();
include_once("../backend/config.php");
include_once("../link/link-2.php");
include_once("../components/component.php");
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
      <?php navbar("คำสั่งซื้อ"); ?>
      <div class="container-fluid row">
          <div class="ml-auto border">
            <button class="bd-none au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" 
                data-target="#modalFormCreateOrder"
            >
                <i class="fas fa-plus"></i>
                  เพิ่มข้อมูล
            </button>
          </div>
          <div class="col-md-12 mt-4">
            <div class="table-responsive table-responsive-data2 mt-2">
                        <table class="table table-data2 mydataTablePatron">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>คำสั่งซื้อ</th>
                                    <th>ค่าใช้จ่าย</th>
                                    <th>รายการสินค้า</th>
                                    <th>เวลา</th>
                                    <th>สลิปเงินทุน</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $get_order = mysqli_query($conn, "SELECT * FROM order_box ORDER BY create_at DESC")or die(mysqli_error());
                                      foreach($get_order as $key => $res){
                                          tablelistsetOrder(
                                              ($key+1), $res['order_id'], $res['order_name'],$res['totalcost_order'],$res['count_order'],
                                              $res['slip_order'],$res['date_time_order']
                                            );
                                      }
                                ?>
                            </tbody>
                        </table> 
                    </div>
          </div>
      </div>
      <main-create-order></main-create-order>
      <main-update-order></main-update-order>
    </main>
  </div>
  <script src="../assets/scripts/ui-order.js"></script>
</body>
</html>