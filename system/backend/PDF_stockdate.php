<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../../vendor/autoload.php';
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
date_default_timezone_set('Asia/Bangkok');

if (!class_exists(\Mpdf\Mpdf::class)) {
    die("mPDF ไม่เจอ ลองเช็ค path vendor/autoload.php");
}

$mpdf = new \Mpdf\Mpdf([
  'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/../../font',
    ]),
    'fontdata' => $fontData + [
        'thsarabunnew' => [
            'R' => 'THSarabunNew.ttf',
            'B' => 'THSarabunNew-Bold.ttf',
            'I' => 'THSarabunNew-Italic.ttf',
            'BI' => 'THSarabunNew-BoldItalic.ttf',
        ]
    ],
    'default_font' => 'thsarabunnew',
    'tempDir' => __DIR__ . '/../../tmp',
    'mode' => 'utf-8',
    'format' => [130, 190],
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_top' => 5,
]);

$conn = new mysqli("localhost", "root", "", "box_stock_order");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$startDateTime = $start_date . ' 00:00:00';
$endDateTime   = $end_date . ' 23:59:59';

// $startDateTime = '01-10-2025 00:00:00';
// $endDateTime   = '18-01-2026 23:59:59';


// $sql = "SELECT SP.product_name, 
//  SUM(SP.product_count * SP.product_price) AS resutl_price, SUM(SP.product_count) AS total_count,
//  COALESCE(PS.tatol_product, 0) AS total_product, COALESCE(PS.price_to_pay, 0) AS total_pay
//  FROM stock_product SP LEFT JOIN (
//  SELECT productname, SUM(tatol_product) AS tatol_product, SUM(price_to_pay) AS price_to_pay FROM list_productsell GROUP BY productname) PS 
//  ON SP.product_name = PS.productname GROUP BY SP.product_name";
// $sql = "SELECT
//   S.product_name,

//   -- จำนวนขาย
//   COALESCE(P.total_product, 0) AS total_product,

//   -- คืนทุน
//   COALESCE(P.total_product, 0) * S.product_price AS capital_recovered,

//   -- ยอดขาย
//   COALESCE(P.total_pay, 0) AS total_pay,

//   -- กำไร
//   COALESCE(
//     P.total_product * (P.rate_customertype - S.product_price),
//     0
//   ) AS profit

// FROM (
//   SELECT
//     SP.product_name,
//     SP.product_price
//   FROM stock_product SP
//   INNER JOIN order_box OB 
//     ON SP.id_order = OB.order_id
//   WHERE OB.date_time_order BETWEEN '$startDateTime' AND '$endDateTime'
//   GROUP BY SP.product_name, SP.product_price
// ) S

// LEFT JOIN (
//   SELECT
//     LPS.productname,
//     SUM(LPS.tatol_product) AS total_product,
//     SUM(LPS.price_to_pay) AS total_pay,
//     MAX(LPS.rate_customertype) AS rate_customertype
//   FROM list_productsell LPS
//   INNER JOIN orders_sell ODS 
//     ON LPS.ordersell_id = ODS.id_ordersell
//   WHERE ODS.date_time_sell BETWEEN '$startDateTime' AND '$endDateTime'
//   GROUP BY LPS.productname
// ) P ON S.product_name = P.productname;
// ";

$sql = "SELECT
 SPS.productname,
 SPS.tatol_sell_qty,
  SPS.total_sell_price,
  -- ต้นทุนเฉลี่ย (ถ้าเดือนนี้ไม่มีซื้อ → ใช้ต้นทุนล่าสุด)
  COALESCE(C1.avg_cost,C2.avg_cost,0) AS avg_cost_price,
  SPS.tatol_sell_qty * COALESCE(C1.avg_cost,C2.avg_cost,0) AS capital_recovered,
  SPS.total_sell_price - (SPS.tatol_sell_qty * COALESCE(C1.avg_cost,C2.avg_cost,0)) AS profit
FROM (
  SELECT 
    LPS.productname,
    SUM(LPS.tatol_product) AS tatol_sell_qty,
    SUM(LPS.price_to_pay) AS total_sell_price
  FROM list_productsell LPS
  INNER JOIN orders_sell ODS 
    ON LPS.ordersell_id = ODS.id_ordersell
  WHERE ODS.date_time_sell BETWEEN '$startDateTime' AND '$endDateTime'
  GROUP BY LPS.productname
) SPS
LEFT JOIN (
  -- ต้นทุนเฉลี่ยเดือนนี้
  SELECT 
    SP.product_name,
    SUM(SP.expenses) / SUM(SP.product_count) AS avg_cost
  FROM stock_product SP
  INNER JOIN order_box OB 
    ON SP.id_order = OB.order_id
  WHERE OB.date_time_order BETWEEN '$startDateTime' AND '$endDateTime'
  GROUP BY SP.product_name
) C1 ON SPS.productname = C1.product_name
LEFT JOIN (
  -- ต้นทุนเฉลี่ยล่าสุด
  SELECT 
    SP.product_name,
    SUM(SP.expenses) / SUM(SP.product_count) AS avg_cost
  FROM stock_product SP
  INNER JOIN order_box OB 
    ON SP.id_order = OB.order_id
  WHERE OB.date_time_order < '$startDateTime'
  GROUP BY SP.product_name
) C2 ON SPS.productname = C2.product_name
 ";
 $selectStockProduct = $conn->query($sql);

 $dates_st = new DateTime($startDateTime);
$is_startDateTime = $dates_st->format('d/m/Y');

$dates_end = new DateTime($endDateTime);
$is_endDateTime = $dates_end->format('d/m/Y');

$html = '
<style>
  body { font-family: "THSarabunNew"; font-size: 14pt; }
  h1 { text-align: center; font-size: 18pt; }
   table.slip-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
  }
  table.slip-table th,
  table.slip-table td {
    border: 1px solid #000;
    padding: 6px;
    text-align: center;
  }

  table.slip-table th.name,
  table.slip-table td.name {
    width: 40%;
    text-align: left;
  }

  table.slip-table th.price,
  table.slip-table td.price,
  table.slip-table th.qty,
  table.slip-table td.qty,
  table.slip-table th.total,
  table.slip-table td.total {
    width: 20%;
  }
  .footer {
    font-size:20px;
    font-weight: bold;
    margin-top:5px;
  }

</style>
<div>
  <div class="" style="">
    <div style="float: left; width: 35%; margin-left:5px">
      <img src="../../assets/img/Jbox-logo.jpg" width="40" height="40" />
    </div>
    <div style="float: right; width: 60%;">
      <p style="text-align: right;padding:0px;margin:0px;">ปริ้นเมื่อ '.date('d/m/Y H:i:s').'</p>
    </div>
  </div>
</div>
<h2>ยอดขายของวันที่ '.$is_startDateTime.' ถึง '.$is_endDateTime.'</h2>
<table class="slip-table">
  <thead>
      <tr style="background-color:#ffb3ff;">
        <th class="name">สินค้า</th>
        <th class="qty">ต้นทุนเฉลี่ย</th>
        <th class="qty">จำนวนที่ขาย</th>
        <th class="price">คืนทุน</th>
        <th class="qty">ยอดขาย</th>
        <th class="total">กำไร</th>
      </tr>
    </thead>
    <tbody>
  ';
  $i = 0;
  $sum_totalcount = 0;
  $price_total_sell_amount = 0;
  $sum_total_productsell = 0;
  $price_total_productsell = 0;
  $sum_totalremining = 0;
  $profitAll = 0;
  while($rows = $selectStockProduct->fetch_assoc()){
    //$remaining_amount = $rows['total_count'] - $rows['tatol_sell_qty'];
    //$sum_totalcount += $rows['tatol_sell_qty'];
    $price_total_sell_amount += $rows['capital_recovered'];
    $sum_total_productsell += $rows['tatol_sell_qty'];
    $price_total_productsell += $rows['total_sell_price'];
    $profitAll += $rows['profit'];
    

    //$sum_totalremining += $remaining_amount;
    $html .= "
      <tr>
        <td class=\"name\">{$rows['productname']}</td>
        <td class=\"qty\">".number_format($rows['avg_cost_price'])."</td>
        <td class=\"qty\">".number_format($rows['tatol_sell_qty'])."</td>
        <td class=\"price\">".number_format($rows['capital_recovered'])."</td>
        <td class=\"qty\">".number_format($rows['total_sell_price'])."</td>
        <td class=\"total\">". number_format($rows['profit'])."</td>
      </tr>
  ";
  $i++;
  }
  $html .= '
      <tr style="background-color:#a3a3c2;">
          <td class=\"name\">'.number_format($i).' รายการ</td>
          <td class=\"name\"></td>
            <td class=\"price\">'.number_format($sum_total_productsell).'</td>
            <td class=\"qty\">'.number_format($price_total_sell_amount).'</td>
            <td class=\"qty\">'.number_format($price_total_productsell).'</td>
            <td class=\"total\">'.number_format($profitAll).'</td>
          </tr>
    </tbody>
    
</table>
</div>
';

$mpdf->WriteHTML($html);
$mpdf->Output();

?>