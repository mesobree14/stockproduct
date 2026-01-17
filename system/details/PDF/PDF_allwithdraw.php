<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../../../vendor/autoload.php';
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

if (!class_exists(\Mpdf\Mpdf::class)) {
    die("mPDF ไม่เจอ ลองเช็ค path vendor/autoload.php");
}

$mpdf = new \Mpdf\Mpdf([
  'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/../../../font',
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
    'tempDir' => __DIR__ . '/../../../tmp',
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
$query = $conn->query("SELECT * FROM withdraw");
$resutl_profit = 0;
$capitalData = [];
$sql_capital = $conn->query("SELECT COUNT(*) AS total_capital,product_name, SUM(expenses) / SUM(product_count) AS avg_rate_price FROM stock_product GROUP BY product_name");
$sql_profit = $conn->query("SELECT COUNT(*) AS total_profit,productname, SUM(tatol_product) AS total_product, SUM(price_to_pay) AS price_sell FROM list_productsell GROUP BY productname");
while($row = mysqli_fetch_assoc($sql_capital)){
  $capitalData[$row['product_name']] = [
    'avg_rate_price' => $row['avg_rate_price'],
    'total_capital' => $row['total_capital']
  ];
}
while($row = mysqli_fetch_assoc($sql_profit)){
  $product = $row['productname'];
  $priceSell = $row['price_sell'];
  $totalProduct = $row['total_product'];
  $avgRate = isset($capitalData[$product]) ? $capitalData[$product]['avg_rate_price'] : 0;
  $totalCost = $avgRate * $totalProduct;
  $resutl_profit += ($priceSell - $totalCost);
}
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
      <img src="../../../assets/img/Jbox-logo.jpg" width="40" height="40" />
    </div>
    <div style="float: right; width: 40%;">
      <h3 style="text-align: right;">ประวัติการเบิกถอน</h3>
    </div>
  </div>
  <div class="" style="padding:0px;margin:0px;">
    <div style="float: left; width: 30%; margin-left:5px;padding:0px;margin:0px;">
    </div>
    <div style="float: right; width: 65%; padding:0px;margin:0px;">
      <p style="text-align: right;padding:0px;margin:0px;">ปริ้นเมื่อ '.date('d/m/Y H:i:s').'</p>
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
      <b>จำนวนเงินที่มี (อิงจากกำไร)</b>
    </div>
    <div style="float: right; width: 40%;">
      <b style=" text-align: right;">'.number_format($resutl_profit ?? 0,2,'.',',').' บาท </b>
    </div>
    <div style="float: left; width: 55%; margin-left:5px">
      <b>จำนวนเงินที่เบิกถอนทั้งหมด</b>
    </div>
    <div style="float: right; width: 40%;">
      <b style=" text-align: right;">'.number_format($totalCount ?? 0,2,'.',',').' บาท</b>
    </div>
    <div style="float: left; width: 55%; margin-left:5px">
      <b>จำนวนเงินคงเหลือ</b> 
    </div>
    <div style="float: right; width: 40%;">
      <b style=" text-align: right;">'.number_format(($resutl_profit - $totalCount),2,'.',',').' บาท</b>
    </div>
  </div>
</div>';

$mpdf->WriteHTML($html);
$mpdf->Output();

?>