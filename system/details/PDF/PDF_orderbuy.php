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
    'format' => [140, 190],
    'margin_left' => 5,
    'margin_right' => 5,
    'margin_top' => 5,
]);

$html = '
<style>
  body { font-family: "THSarabunNew"; font-size: 14pt; }
  h1 { text-align: center; font-size: 18pt; }
  table { width: 100%; border-collapse: collapse; }
  td { border-bottom: 1px dashed #000; padding: 5px; }
</style>

<h2>นี่คือใบเสร็จ</h2>
<table>
  <tr><td>สินค้า A</td><td align="right">100 บาท</td></tr>
  <tr><td>สินค้า B</td><td align="right">50 บาท</td></tr>
  <tr><td><b>รวม</b></td><td align="right"><b>150 บาท</b></td></tr>
</table>
';

$mpdf->WriteHTML($html);
$mpdf->Output();

?>