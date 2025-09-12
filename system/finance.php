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
      <?php navbar("การเงิน"); ?>
      <div class="container-fluid row">
        <div class="col-12 row">
          <?php
            $capitals = mysqli_query($conn,"SELECT SUM(count_capital) as countcapital FROM capital");
            $acc_capintal = mysqli_fetch_assoc($capitals);
            

            $res_total = mysqli_query($conn,"SELECT SUM(product_count) as totalproduct FROM stock_product");
            $acc_totals = mysqli_fetch_assoc($res_total);

            $used_capital = mysqli_query($conn,"SELECT SUM(totalcost_order) as costordercount FROM order_box");
            $acc_usecapital = mysqli_fetch_assoc($used_capital);

            $profit = mysqli_query($conn,"SELECT SUM(is_totalprice) as totalpices, SUM(count_totalpays) as custom_pay, SUM(count_stuck) as countstuck FROM orders_sell");
            $acc_qlprofits = mysqli_fetch_assoc($profit);

            $total_psell = mysqli_query($conn,"SELECT SUM(tatol_product) as totalproductsell FROM list_productsell");
            $acc_total_psell = mysqli_fetch_assoc($total_psell);

            $quall = "SELECT SUM(is_totalprice) as is_prices, SUM(count_totalpays) as custom_pay, SUM(count_stuck) as countstuck FROM orders_sell";
            $is_quall = mysqli_query($conn,$quall);
            $is_accquall = mysqli_fetch_assoc($is_quall);

            $average_cost = $acc_usecapital['costordercount'] / $acc_totals['totalproduct'];
            $average_sell = $acc_qlprofits['totalpices'] / $acc_total_psell['totalproductsell'];

            $total_capitals = $average_cost * $acc_total_psell['totalproductsell'];
            $total_profit = $acc_qlprofits['totalpices'] - $total_capitals;

            setData("ทุนทั้งหมด",number_format($acc_capintal['countcapital'] ?? 0,2,'.',','));
            $costorder = $acc_usecapital['costordercount'] - $total_capitals;
            setData("ทุนที่กำลังใช้",number_format($costorder ?? 0,2,'.',','));

            setData("หนี้ลูกค้ายังไม่จ่าย",number_format($is_accquall['countstuck'] ?? 0,2,'.',','));

            $available = $acc_capintal['countcapital'] - $costorder;
            $remain_capital =bcsub($acc_capintal['countcapital'],bcadd($costorder,$is_accquall['countstuck'], 2), 2);
            setData("ทุนที่ยังใช้ได้",number_format($remain_capital ?? 0 ,2,'.',','));
            
          ?>
        </div>
        <div class="col-12 row">
          <?php


            $sql_useprofit = mysqli_query($conn,"SELECT SUM(count_withdraw) as use_prefit FROM withdraw");
            $acc_useprofit = mysqli_fetch_assoc($sql_useprofit);
            setData("กำไรทั้งหมด",number_format($total_profit ?? 0,2,'.',','));
            
            setData("เบิกถอนไปแล้ว",number_format($acc_useprofit['use_prefit'] ?? 0,2,'.',','));
            setData("สามารถใช้ได้",number_format($total_profit - $acc_useprofit['use_prefit'],2,'.',','));
            uiWorking("ค่าเฉลี่ย ".$acc_total_psell['totalproductsell']." ชิ้น",number_format($average_cost ?? 0 ,2,'.',','),number_format($average_sell ?? 0,2,'.',','))
          ?>
        </div>
        <div class="col-12 row mt-2">
          <div class="col-md-12 col-lg-5 border-right">
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
                            <th></th>
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

          <div class="col-md-12 col-lg-7">
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
                            <th></th>
                            <th>จำนวน</th>
                            <th>สาเหุต</th>
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
    <main-create-capital availablecapital="<?php echo number_format($remain_capital ?? 0 ,2,'.',',') ?>"></main-create-capital>
    <main-create-withdraw usableprofit="<?php echo number_format($total_profit - $acc_useprofit['use_prefit'],2,'.',','); ?>"></main-create-withdraw>
  </div>
</body>
</html>

<script src="../assets/scripts/ui-finance.js"></script>