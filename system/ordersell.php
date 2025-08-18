<?php
session_start();
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
    <link rel="stylesheet" href="../assets/scripts/module/select-picker/select.scss">
    
  <title>Document</title>
</head>
<body>
  <div class="page-wrapper chiller-theme toggled">
    <?php  navigationOfiicer(); ?>
    <main class="page-content mt-0">
      <?php navbar("ราการขาย"); ?>
      <div class="container-fluid row">
        <div class="ml-auto border">
            <button class="bd-none au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" 
                data-target="#modalFormOrderSell"
            >
                <i class="fas fa-plus"></i>
                  เพิ่มรายการขาย
            </button>
          </div>
          <div class="col-md-12 mt-4">
            <div class="table-responsive table-responsive-data2 mt-2">
                <table class="table table-data2 mydataTablePatron">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อสินค้า</th>
                            <th>จำนวนที่ขาย</th>
                            <th>ราคาที่ขาย</th>
                            <th>ประเภทลูกค้า</th>
                            <th>ราคาที่ขายแต่ละชิ้น</th>
                            <th>วันที่-เวลาที่ขาย</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table> 
            </div>
          </div>
      </div>
      <mian-form-ordersell></mian-form-ordersell>
    </main>
  </div>
  <script src="../assets/scripts/ui-ordersell.js"></script>
</body>
</html>