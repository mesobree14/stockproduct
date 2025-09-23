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
            

            $used_capital = mysqli_query($conn,"SELECT SUM(totalcost_order) as costordercount FROM order_box");
            $acc_usecapital = mysqli_fetch_assoc($used_capital);

            $quall = "SELECT SUM(is_totalprice) as is_prices, SUM(count_totalpays) as custom_pay, SUM(count_stuck) as countstuck FROM orders_sell";
            $is_quall = mysqli_query($conn,$quall);
            $is_accquall = mysqli_fetch_assoc($is_quall);

            $costordercount = $acc_usecapital['costordercount'] ?? 0;
            
            $countcapital = $acc_capintal['countcapital'] ?? 0;
            $countstuck = $is_accquall['countstuck'] ?? 0;
            $sql_useprofit = mysqli_query($conn,"SELECT SUM(count_withdraw) as use_prefit FROM withdraw");
            $acc_useprofit = mysqli_fetch_assoc($sql_useprofit);
            
            $sql_capital = mysqli_query($conn,"SELECT COUNT(*) AS total_capital,product_name, SUM(expenses) / SUM(product_count) AS avg_rate_price FROM stock_product GROUP BY product_name");
            $sql_profit = mysqli_query($conn,"SELECT COUNT(*) AS total_profit,productname, SUM(tatol_product) AS total_product, SUM(price_to_pay) AS price_sell FROM list_productsell GROUP BY productname");
            $capitalData = [];

            $sum_totalsell = 0;
            $sum_pricesell = 0;
            $sun_pricebuy = 0;
            $average_pay = 0;
            $resutl_profit = 0;
            while($row = mysqli_fetch_assoc($sql_capital)){
              $capitalData[$row['product_name']] = [
                'avg_rate_price' => $row['avg_rate_price'],
                'total_capital' => $row['total_capital']
              ];
            }
          
            while($row = mysqli_fetch_assoc($sql_profit)){
              $product = $row['productname'];
              $totalProduct = $row['total_product'];
              $totalSell = $row['total_profit'];
              $priceSell = $row['price_sell'];
              $avgRate = isset($capitalData[$product]) ? $capitalData[$product]['avg_rate_price'] : 0;
              $totalPay = isset($capitalData[$product]) ? $capitalData[$product]['total_capital'] : 0;
              $totalCost = $avgRate * $totalProduct;
            
              $sum_totalsell += $totalProduct;
              $sum_pricesell += $priceSell;
              $sun_pricebuy += $totalCost; //ต้นทุนที่ได้กลับมา

              $resutl_profit += ($priceSell - $totalCost);
              //echo "สินค้า: $product จำนวนครั้งซื้อ $totalPay |จำนวนครั้งขาย $totalSell | ขาย: $totalProduct | ขายรวม: $priceSell | ทุนเฉลี่ย: $avgRate | ต้นทุนรวม: $totalCost <br>";
            }
            $sql_debt = mysqli_query($conn,"SELECT SUM(count_debtpaid) AS count_debtpaid FROM custom_debtpaid");
            $acc_debt = mysqli_fetch_assoc($sql_debt);
            $pay_debt = $acc_debt['count_debtpaid'] ?? 0;
        
            $res_pricecapital = ($costordercount - $sun_pricebuy);
            $res_pricedebt = ($countstuck - $pay_debt);
            $res_circulating =$countcapital - ($res_pricecapital + $res_pricedebt);



            setData("ทุนทั้งหมด",number_format($countcapital,2,'.',','));
            setData("ทุนที่กำลังใช้(<small class='text-danger font-weight-bold'>".number_format($sun_pricebuy ?? 0,2,'.',',').".บ</small>)",number_format($res_pricecapital ?? 0,2,'.',','));
            setData("จำนวนค้างชำระ",number_format($res_pricedebt ?? 0,2,'.',','));
            setData("ทุนที่ยังใช้ได้",number_format($res_circulating ?? 0 ,2,'.',','));
            setData("กำไร(<small class='text-success font-weight-bold'>ขายได้ : ".number_format($sum_pricesell ?? 0,2,'.',',').".บ</small>)",number_format($resutl_profit ?? 0,2,'.',','));
            
            setData("เบิกถอนไปแล้ว",number_format($acc_useprofit['use_prefit'] ?? 0,2,'.',','));
            setData("สามารถใช้ได้",number_format($resutl_profit - $acc_useprofit['use_prefit'],2,'.',','));
            uiWorking("ค่าเฉลี่ยขาย ".number_format($sum_totalsell) ." ชิ้น",number_format($sun_pricebuy / $sum_totalsell ?? 0 ,2,'.',','),number_format($sum_pricesell / $sum_totalsell ?? 0,2,'.',','))
          ?>
        </div>
      
        <div class="col-12 row mt-2 bg-white">
          <div class="col-md-12 col-lg-5 border-right">
            <div class="col-12 row">
            <div class="ml-auto mt-3">
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
                            <th>เวลาเพิ่มทุน <i class="fa-solid fa-arrow-up"></i></th>
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
              <div class="ml-auto mt-3">
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
                            <th>เวลาเบิกถอน <i class="fa-solid fa-arrow-up"></i></th>
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
    <main-create-capital availablecapital="<?php echo number_format($res_circulating ?? 0 ,2,'.',',') ?>"></main-create-capital>
    <main-create-withdraw usableprofit="<?php echo number_format($resutl_profit - $acc_useprofit['use_prefit'],2,'.',','); ?>"></main-create-withdraw>
  </div>
</body>
</html>

<script src="../assets/scripts/ui-finance.js"></script>