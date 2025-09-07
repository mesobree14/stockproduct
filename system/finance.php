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
      <?php navbar("การเงิน"); ?>
      <div class="container-fluid row">
        <div class="col-12 row">
          <div class="col-md-12 col-lg-6 border-right">
            <div class="col-12 row">
            <div class="ml-auto">
              <button class="bd-none au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" 
                  data-target="#modalFormCapital"
              >
                  <i class="fa-solid fa-sack-dollar"></i>
                    เพิ่มข้อมูลทุน
              </button>
            </div>
            </div>
            <div class="table-responsive table-responsive-data2 mt-2">
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>จำนวนทุน</th>
                            <th>เวลาเพิ่มทุน</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $query_capital = mysqli_query($conn,"SELECT * FROM capital ORDER BY create_at DESC") or die(mysqli_error($conn));
                        foreach($query_capital as $key => $rows){
                          tableCapital(($key+1),$rows['capital_id'],$rows['count_capital'],$rows['slip_capital'],$rows['date_time_ad']);
                        }
                      ?>
                    </tbody>
                </table>
            </div>
          </div>

          <div class="col-md-12 col-lg-6">
            <div class="col-12 row">
              <div class="ml-auto">
                <button class="bd-none au-btn au-btn-icon au-btn-orange au-btn--small mx-4" data-toggle="modal" 
                    data-target="#modalFormWithdraw"
                >
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                      เพิ่มข้อมูลเบิกถอน
                </button>
              </div>
            </div>
            <div class="table-responsive table-responsive-data2 mt-2">
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>จำนวนเบิกถอน</th>

                            <th>เวลาเบิกถอน</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $query_withdraw = mysqli_query($conn,"SELECT * FROM withdraw ORDER BY create_at DESC") or die(mysqli_error($conn));
                        foreach($query_withdraw as $key=>$rows){
                          tableWithDraw(($key+1),$rows['withdraw_id'],$rows['count_withdraw'],$rows['reason'],$rows['slip_withdraw'],$rows['date_withdrow']);
                        }
                      ?>
                    </tbody>
                </table>
            </div>
          </div>

        </div>
      </div>
    </main>
    <main-create-capital></main-create-capital>
    <main-create-withdraw></main-create-withdraw>
  </div>
</body>
</html>

<script src="../assets/scripts/ui-finance.js"></script>