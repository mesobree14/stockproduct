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
      <?php navbar("รายการสินค้า"); ?>
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
                                    <th>ชื่อ สินค้า</th>
                                    <!-- <th>จำนวนครั้งที่ซื้อ</th> -->
                                    <th>จำนวนทั้งหมด ชิ้น</th>
                                    <!-- <th>ต้นทุนทั้งหมด บ.</th> -->
                                    <th>ขายไปแล้ว ชิ้น.</th>
                                    <th>สินค้าคงเหลือ</th>
                                    <th>จัดการ</th>
                                </tr> 
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT product_name, 
                                     COUNT(*) total,SUM(product_count * product_price) AS resutl_price, SUM(product_count) AS total_count FROM stock_product GROUP BY product_name";
                                     $selectStockProduct = mysqli_query($conn,$sql) or die(mysqli_error($conn));
                                     $num_rows = mysqli_num_rows($selectStockProduct);
                                     if($num_rows > 0){
                                      foreach($selectStockProduct as $key => $res){
                                          tablelistStock(
                                              ($key+1), $res['product_name'], $res['total'],$res['total_count'],$res['resutl_price'],
                                            );
                                      }
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