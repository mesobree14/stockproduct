<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../../vendor/autoload.php';
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

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
    'format' => [110, 170],
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
$query = $conn->query("SELECT * FROM withdraw WHERE date_withdrow BETWEEN '$startDateTime' AND '$endDateTime'");

$sql_new = "SELECT
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
 $selectStockProduct = $conn->query($sql_new);

   $i = 0;
  $sum_totalcount = 0;
  $price_total_sell_amount = 0;
  $sum_total_productsell = 0;
  $price_total_productsell = 0;
  $sum_totalremining = 0;
  $profitAll = 0;

 while($rows = $selectStockProduct->fetch_assoc()){
  $price_total_sell_amount += $rows['capital_recovered'];
    $sum_total_productsell += $rows['tatol_sell_qty'];
    $price_total_productsell += $rows['total_sell_price'];
    $profitAll += $rows['profit'];
 }


$dates_st = new DateTime($startDateTime);
$is_startDateTime = $dates_st->format('d/m/Y');

$dates_end = new DateTime($endDateTime);
$is_endDateTime = $dates_end->format('d/m/Y');

$html = '
<style>
  body { font-family: "THSarabunNew"; font-size: 14pt; }
.component {
    width: 100%;
    font-family: "THSarabunNew";
    font-size: 14pt;
    margin-bottom: 1px;
    overflow: hidden; /* เคลียร์ float */
}
.left {
    float: left;
    width: 57%;
    padding: 4px;
    box-sizing: border-box;
}
.right {
    float: right;
    width: 40%;
    box-sizing: border-box;
    
}

.left-qr {
    float: left;
    width: 30%;
    padding-top: 14px;
    box-sizing: border-box;
}
.right-qr {
    float: right;
    width: 70%;
    box-sizing: border-box;
    
}

.left-custom {
    float: left;
    width: 47%;
    padding: 4px;
    box-sizing: border-box;
}
.right-custom {
    float: right;
    width: 50%;
    box-sizing: border-box;
}

.doc {
    width: 100%;
    overflow: hidden;
    margin-left: 10px;
}
.doc span.label {
    float: left;
    font-weight: 900;
}
.doc span.value {
    float: right;
}

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
    width: 45%;
    text-align: left;
  }

  table.slip-table th.price,
  table.slip-table td.price,
  table.slip-table th.qty,
  table.slip-table td.qty,
  table.slip-table th.total,
  table.slip-table td.total {
    width: 15%;
  }
  .footer {
    font-size:20px;
    font-weight: bold;
    margin-top:5px;
  }
</style>';



$html .='
<div>
  <div class="" style="">
    <div style="float: left; width: 55%; margin-left:5px">
      <img src="../../assets/img/Jbox-logo.jpg" width="40" height="40" />
    </div>
    <div style="float: right; width: 40%;">
      <h3 style="text-align: right;">ประวัติการเบิกถอน</h3>
    </div>
  </div>
  <div class="" style="padding:0px;margin:0px;">

    <div style="float: right; width: 100%; padding:0px;margin:0px;">
      <p style="text-align: right;padding:0px;margin:0px;">ข้อมูลระหว่าง '.$is_startDateTime .' ถึง '.$is_endDateTime.'</p>
    </div>
  </div>
  <div style="width:100%; margin-top:10px; margin-bottom:10px;">
    <div style="height: 220px;">
      <table class="slip-table">
        <thead>
          <tr style="background-color:#ffb3ff;">
            <th class="price">วันที่</th>
            <th class="name">รายละเอียด</th>
            <th class="qty">จำนวนเงิน</th>
          </tr>
        </thead>
        <tbody>';
$totalCount = 0;  
$totalRow   = 0;
while ($row = $query->fetch_assoc()) {
  $totalCount += (int)$row['count_withdraw']; // รวมค่า
    $totalRow++;
    $html .='
          <tr>
            <td class="price">'. date('d/m/Y', strtotime($row['date_withdrow'])).'</td>
            <td class="name">'.$row['reason'].'</td>
            <td class="qty">'. number_format($row['count_withdraw'] ?? 0).'</td>
          </tr>';
};

    $html .='
        </tbody>
      </table>
    </div>
  </div>
  <hr/>
  
  <b class="footer">จำนวนรายการเบิกถอนทั้งหมด '. $totalRow.' รายการ</b>
  <div style="">
    <div style="float: left; width: 55%; margin-left:5px">
      <b>ยอดขาย</b>
    </div>
     <div style="float: right; width: 40%;">
      <b style=" text-align: right;color:blue;">'.number_format($price_total_productsell ?? 0,1,'.',',').' บาท </b>
    </div>
    <div style="float: left; width: 55%; margin-left:5px">
      <b>คืนทุน</b>
    </div>
     <div style="float: right; width: 40%;">
      <b style=" text-align: right;color:blue;">'.number_format($price_total_sell_amount ?? 0,1,'.',',').' บาท </b>
    </div>
    
    <div style="float: left; width: 55%; margin-left:5px">
      <b>ยอดกำไร</b>
    </div>
    <div style="float: right; width: 40%;">
    <b style=" text-align: right;color:blue;">'.number_format($profitAll ?? 0,1,'.',',').' บาท </b>
    </div>
    <div style="float: left; width: 55%; margin-left:5px">
      <b>จำนวนเงินที่เบิกถอนท</b>
    </div>
    <div style="float: right; width: 40%;">
      <b style=" text-align: right;color:blue;">'.number_format($totalCount ?? 0,1,'.',',').' บาท</b>
    </div>
    <div style="float: left; width: 55%; margin-left:5px">
      <b>จำนวนเงินคงเหลือ</b> 
    </div>
    <div style="float: right; width: 40%;">
      <b style=" text-align: right;color:blue;">'.number_format(($profitAll - $totalCount),1,'.',',').' บาท</b>
    </div>
  </div>
</div>';

$mpdf->WriteHTML($html);
$mpdf->Output();

?>