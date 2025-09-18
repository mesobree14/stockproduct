<?php

function navigationOfiicer($path = ""){
    if ($path !== "" && substr($path, -1) !== "/") {
        $path .= "/";
    }
    $list = "
        <nav id=\"sidebar\" class=\"sidebar-wrapper\">
            <div class=\"sidebar-content\">
                <div class=\"sidebar-brand\">
                    <a href=\"#\" class=\"text-primary\">สถานะ admin</a>
                    <div id=\"close-sidebar\">
                        <i class=\"fas fa-times\"></i>
                    </div>
                </div>
                <div class=\"sidebar-menu mt-4\">
                    <ul>
                        <li class=\"header-menu\">
                            <span>Menu</span>
                        </li>
                        <li>
                          <a href=\"{$path}index.php\">
                              <i class=\"fa fa-tachometer-alt\"></i>
                              <span>หน้าแรก</span>
                          </a>
                        </li>
                        <li>
                          <a href=\"{$path}finance.php\">
                              <i class=\"fab fa-bitcoin\"></i>
                              <span>การเงิน</span>
                          </a>
                        </li>
                        <li>
                          <a href=\"{$path}orders.php\">
                              <i class=\"fa-solid fa-truck\"></i>
                              <span>คำสั่งซื้อ</span>
                          </a>
                        </li>
                        <li>
                          <a href=\"{$path}stock.php\">
                              <i class=\"fas fa-store\"></i>
                              <span>คลังสินค้า</span>
                          </a>
                        </li>
                        <li>
                          <a href=\"{$path}ordersell.php\">
                            <i class=\"fa-solid fa-truck-fast\"></i>
                              <span>สินค้าที่ขาย</span>
                          </a>
                        </li>
                        <li>
                          <a href=\"{$path}customer.php\">
                            <i class=\"fa-solid fa-people-group\"></i>
                              <span>ข้อมูลลูกค้า</span>
                          </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    ";
    echo $list;
}

function navbar($logo, $path=""){
    $navList = "
        <nav class=\"navbar navbar-tp navbar-expand-md navbar-dark bg-dark row\">
          <div class=\"container-fluid ml-4\">
              <a id=\"show-sidebar\" class=\"btn btn-primary mt-1\" href=\"#\">
                  <i class=\"fas fa-bars\"></i>
              </a>
              <p class=\"h3 mb-0 text-white text-uppercase d-none d-lg-inline-block font-thi\">$logo</p>
              <div class=\"ml-auto\">
                  <a class=\"nav-link btn btn-outline-success\" href=\"{$path}logout.php\">
                    <i class=\"now-ui-icons ui-1_settings-gear-63\"></i>
                    ออกจากระบบ
                  </a>
              </div>
          </div>
        </nav>
    ";
    echo $navList;

}

function tableCapital($number, $capital_id, $count_capital,$slip, $date_time_ad){
  $list = "
    <tr>
      <td></td>
      <td class=\"font-weight-bold\">$count_capital</td>
      <td class=\"font-weight-bold\">$date_time_ad</td>

      <td>
        <div class=\"table-data-feature\" >
            <button type=\"button\" id=\"update_capital\" data-target=\"#modalFormCapital\" data-toggle=\"modal\"  
                   class=\"item\" data-id=\"$capital_id\" data-count=\"$count_capital\" data-date=\"$date_time_ad\" 
                   data-img=\"$slip\"
            >
                <i class=\"fas fa-pencil-alt text-warning\"></i>
            </button>
            <button type=\"button\" class=\"item\" id=\"confirmTrashCapital\" data-img=\"$slip\" data-name=\"$count_capital\" data-id=\"$capital_id\">
              <i class=\"fas fa-trash-alt text-danger\"></i> 
            </button>
          </div>
      </td>
    </tr>
  ";
  echo $list;
}
function tableWithDraw($number, $withdraw_id, $count_withdraw,$reason,$slip_withdrow, $date_time_ad){
  $list = "
    <tr>
      <td></td>
      <td class=\"font-weight-bold\">$count_withdraw</td>
      <td class=\"font-weight-bold\">$reason</td>
      <td class=\"font-weight-bold\">$date_time_ad</td>
      <td>
        <div class=\"table-data-feature\" >
            <button type=\"button\" id=\"update_withraw\" data-target=\"#modalFormWithdraw\" data-toggle=\"modal\"  
                   class=\"item\" data-id=\"$withdraw_id\" data-count=\"$count_withdraw\" data-date=\"$date_time_ad\"
                   data-img=\"$slip_withdrow\" data-reason=\"$reason\" 
            >
                <i class=\"fas fa-pencil-alt text-warning\"></i>
            </button>
            <button type=\"button\" class=\"item\" id=\"confirmTrashWithroaw\" data-img=\"$slip_withdrow\" data-name=\"$count_withdraw\" data-id=\"$withdraw_id\">
              <i class=\"fas fa-trash-alt text-danger\"></i> 
            </button>
          </div>
      </td>
    </tr>
  ";
  echo $list;
}

function setData($titleText, $number){
    $listData = "
      <div class=\"col-xl-3 col-md-6 mb-4\">
        <div class=\"card border-left-primary shadow  py-2 border\">
            <div class=\"card-body\">
                <div class=\"row no-gutters align-items-center\">
                    <div class=\"col mr-2\">
                        <div class=\"text-xs font-weight-bold text-primary text-uppercase mb-1\">
                            $titleText
                        </div>
                        <div class=\"h5 mb-0 font-weight-bold text-gray-800\">$number บาท</div>
                    </div>
                </div>
            </div>
        </div>
      </div>";
      echo $listData;
  }

  function uiWorking($titleText,$average_cost, $average_sell){
    $list = "
    <div class=\"col-xl-3 col-md-6 mb-4\">
        <div class=\"card border-left-primary shadow  py-2 border\">
            <div class=\"px-3 py-2\">
                <div class=\"row no-gutters align-items-center\">
                    <div class=\"col mr-2\">
                        <div class=\"text-xs font-weight-bold text-primary text-uppercase mb-1\">
                            $titleText
                        </div>
                        <div class=\"small mb-2 font-weight-bold text-danger\">ทุนตกชิ้นละ: $average_cost บาท</div>
                        <div class=\"small mb-0 font-weight-bold text-success\">ขายตกชิ้นละ: $average_sell บาท</div>
                    </div>
                </div>
            </div>
        </div>
      </div>";
    echo $list;
  }

function tablelistsetOrder ($number, $orderid, $ordername, $totalcost_order, $price_order, $sliptImg, $date_time_order){
  $listOrder = "
  <form>
    <tr>
      <td>$number</td>
      <td class=\"font-weight-bold\">$ordername</td>
      <td class=\"font-weight-bold\">$totalcost_order บาท</td>
      <td class=\"font-weight-bold\">$price_order รายการ</td> 
      <td class=\"font-weight-bold\">$date_time_order</td> 
      <td>
          <div class=\"account-item account-item--style2 clearfix js-item-menu\">
              <div class=\"image\">
                  <img src=\"../db/slip-orders/$sliptImg \" alt=\"John Doe\" />
              </div>
          </div>
      </td>
      <td>
          <div class=\"table-data-feature\" >
            <a class=\"item\" data-toggle=\"tootip\" data-placement=\"top\" title=\"จัดสรรทุน\" href=\"details/detail_orderbuy.php?orderbuy_id=$orderid \">
              <i class=\"fas fa-list-alt\"></i>
            </a>
            <button type=\"button\" id=\"update_order\" data-target=\"#modalFormUpdateOrder\" data-toggle=\"modal\"  
                   class=\"item\" data-id=\"$orderid\" data-ordername=\"$ordername\" data-totalcost=\"$totalcost_order\" 
                   data-priceorder=\"$price_order\" data-slipimage=\"$sliptImg\" data-dateorder=\"$date_time_order\"
            >
                <i class=\"fas fa-pencil-alt text-warning\"></i>
            </button>
            <button type=\"button\" class=\"item\" id=\"confirmTrashOrder\" data-id=\"$orderid\" data-ordername=\"$ordername\">
              <i class=\"fas fa-trash-alt text-danger\"></i> 
            </button>
          </div>
      </td>
    </tr>
    </form>
  ";
  echo $listOrder;
}

function tablelistStock ($number, $product_name, $total_order, $total_count, $total_price, $total_sell){
  $remaining_amount = $total_count - $total_sell;
  $listStock = "
  <form>
    <tr>
      <td class=\"font-weight-bold\">$number</td>
      <td class=\"font-weight-bold\">$product_name</td>
      <td class=\"font-weight-bold\">$total_count บาท</td> 
      <td class=\"font-weight-bold\">$total_sell ชิ้น</td> 
      <td class=\"font-weight-bold\">$remaining_amount ชิ้น</td> 
      <td class='text-center'>
          <div class=\"table-data-feature\" >
            <a class=\"item\" data-toggle=\"tootip\" data-placement=\"top\" title=\"จัดสรรทุน\" href=\"details/detail_stock.php?product_name=".urlencode($product_name)." \">
              <i class=\"fas fa-list-alt\"></i>
            </a>
          </div>
      </td>
    </tr>
    </form>
  ";
  echo $listStock;
}

function tableDetailStock($number, $product_id,$productname,$productcount,$productprice, $ordername, $datetime_order){
    $toal_all = $productprice * $productcount;
    $list_stock = "
        <form>
            <tr>
              <td class=\"font-weight-bold\">$number</td>
              <td class=\"font-weight-bold\">$productname</td>
              <td class=\"font-weight-bold\">$ordername</td>
              <td class=\"font-weight-bold\">$productprice บาท</td> 
              <td class=\"font-weight-bold\">$productcount ชิ้น</td> 
              <td class=\"font-weight-bold\">$toal_all</td> 
              <td class=\"font-weight-bold\">$datetime_order</td> 
            </tr>
        </form>
    ";
    echo $list_stock;
}

function typecustomse($type){
    if($type === "price_customer_dealer"){
      return "ตัวแทนจำหน่าย";
    }else if($type === "price_custommer_vip"){
      return "ลูกค้า vip";
    }else if($type === "price_customer_frontstore"){
      return "ลูกค้าหน้าร้าน";
    }else if($type === "price_customer_deliver"){
      return "การจัดส่ง";
    }else{
      return $type;
    }
  }

function tableDetailStockSell($number, $product_id,$productname,$ordername, $productcount,$productprice, $rate_custom, $datetime_order){
    $toal_all = $productprice * $productcount;
    $list_stock = "
        <form>
            <tr>
              <td class=\"font-weight-bold\">$number</td>
              <td class=\"font-weight-bold\">$productname</td>
              <td class=\"font-weight-bold\">$ordername</td>
              <td class=\"font-weight-bold\">". typecustomse($rate_custom) ."</td> 
              <td class=\"font-weight-bold\">$productprice บาท</td> 
              <td class=\"font-weight-bold\">$productcount ชิ้น</td> 
              <td class=\"font-weight-bold\">$toal_all</td> 
              <td class=\"font-weight-bold\">$datetime_order</td> 
            </tr>
        </form>
    ";
    echo $list_stock;
}

function detailStock($productname,$total_count,$total_price,$product_price, $count_sell, $income_price, $number_of_timessold){
    $remaining_products = $total_count - $count_sell;
    $cost_price = $product_price * $count_sell;
    $total_profit = $income_price - $cost_price;
    $detail = "
    
        <div class=\"rounded row mt-4 p-4\">
           <div class=\"col-lg-2 col-md-3 col-sm-6 col-12 m-2 p-3 bg-white info-box rounded info-box rounded\">
            <span>สินค้า ชิ้นละ $product_price บาท</span>
            <p class=\"font-weight-bold res_text\"> $productname </p>
          </div>
          <div class=\"col-lg-3 col-md-4 col-sm-6 col-12 m-2 p-3 bg-white info-box rounded\">
            <span>จำนวนสิ้นค้าทัั้งหมด</span>
                <p class=\"font-weight-bold res_text\"> $total_count ชิ้น</p>
          </div>
          <div class=\"col-lg-3 col-md-4 col-sm-6 col-12 m-2 p-3 bg-white info-box rounded\">
            <span>ต้นทุนทั้งหมด</span>
            <p class=\"font-weight-bold res_text\"> $total_price  บาท</p>
          </div>
          <div class=\"col-lg-3 col-md-4 col-sm-6 col-12 m-2 p-3 bg-white info-box rounded\">
                <span>จำนวนสินค้าที่ขายไปแล้ว</span>
                <p class=\"font-weight-bold res_text\"> $count_sell  ชิ้น</p>
          </div>
          <div class=\"col-lg-3 col-md-4 col-sm-6 col-12 m-2 p-3 bg-white info-box rounded\">
                <span>สินค้าที่เหลือ</span>
                <p class=\"font-weight-bold res_text\"> $remaining_products  ชิ้น</p>
          </div>
          <div class=\"col-lg-3 col-md-4 col-sm-6 col-12 m-2 p-3 bg-white info-box rounded\">
            <span>ราคาที่ขายได้</span>
            <small class=\"text-danger\">ต้นทุน $cost_price บาท</small>
           <p class=\"font-weight-bold res_text\"> $income_price บาท</p>
          </div>
          <div class=\"col-lg-2 col-md-3 col-sm-6 col-12 m-2 p-3 bg-white info-box rounded\">
                <span>ยอดกำไร</span>
                <p class=\"font-weight-bold res_text\">$total_profit  บาท</p>
          </div>
          <div class=\"col-lg-3 col-md-4 col-sm-6 col-12 m-2 p-3 bg-white info-box rounded\">
            <span>จำนวนครั้งที่ขายได้</span>
            <p class=\"font-weight-bold res_text\"> $number_of_timessold ครั้ง</p>
          </div>
        </div>

    ";

    echo $detail;
}

function listRatePrice($rate_id="",$rate_storefront_price="",$rate_vip_price="",$rate_dealer_price="ยังไม่ได้กำหนด",$rate_delivery_price="",$product_name, $price_product){
    function status($id){
        if($id){
            return "<i class=\"fas fa-pencil-alt text-warning\"></i>";
        }else{
            return "<i class=\"fas fa-plus text-success\"></i>";
        }
    }
    $list = "
        <form>
            <tr>
                <td class=\"font-weight-bold\">เรทราคา : </td>
                <td class=\"font-weight-bold\">$rate_storefront_price</td>
                <td class=\"font-weight-bold\">$rate_vip_price</td>
                <td class=\"font-weight-bold\">$rate_dealer_price</td>
                <td class=\"font-weight-bold\">$rate_delivery_price</td>
                <td>
                    <div class=\"table-data-feature\" >
                        <button type=\"button\" id=\"set_rate_price\" data-target=\"#modalFormUpdateRate\" data-toggle=\"modal\"  
                           class=\"item\" data-id=\"$rate_id\" data-product=\"$product_name\" data-storefront=\"$rate_storefront_price\" data-vip=\"$rate_vip_price\" 
                           data-dealers=\"$rate_dealer_price\" data-delivery=\"$rate_delivery_price\" data-productprice=\"$price_product\"
                        >
                            ".status($rate_id)."
                        </button>
                    </div>
                </td>
            </tr>
        </form>
    ";

    echo $list;

}

function listOrderSell($number, $ordersell_id, $ordersell_name,$count_item, $price_total,$customer_name,$date_sell,$list_typepays){

  $listorder = "
      <tr>
        <td class=\"font-weight-bold \"> $number</td>
        <td class=\"font-weight-bold\">$ordersell_name</td>
        <td class=\"font-weight-bold\">$count_item รายการ</td> 
        <td class=\"font-weight-bold\">$price_total บาท</td> 
        <td class=\"font-weight-bold\">$customer_name</td> 
        <td class=\"font-weight-bold\">$list_typepays</td> 
        <td class=\"font-weight-bold\">$date_sell</td> 
        <td class='text-center'>
            <div class=\"table-data-feature\" >
              <a class=\"item\" data-toggle=\"tootip\" data-placement=\"top\" title=\"จัดสรรทุน\" href=\"details/detail_ordersell.php?ordersell_id=".$ordersell_id." \">
                <i class=\"fas fa-list-alt\"></i>
              </a>
              <button type=\"button\" id=\"edit_order_sell\" data-target=\"#modalFormUpdateOrderSell\" data-toggle=\"modal\"  
                       class=\"item\" data-ordersellid=\"$ordersell_id\" data-ordersellname=\"$ordersell_name\" data-pricetotal=\"$price_total\" 
                       data-customername=\"$customer_name\" data-datesell=\"$date_sell\"
                    >
                        <i class=\"fas fa-pencil-alt text-warning\"></i>
                    </button>
                    <button type=\"button\" class=\"item\" id=\"confirmTrashOrderSell\" data-id=\"$ordersell_id\" data-ordersell=\"$ordersell_name\">
                      <i class=\"fas fa-trash-alt text-danger\"></i>
                    </button>
            </div>
        </td>
      </tr>

  ";
  echo $listorder;
}

function status_deliver($shippingnote, $sender, $wages){
  if($wages){
    $lists = "
      <div class=\"col-sm-12 col-lg-8\">
        <h3 class=\"fs-3 font-thi\">สถานะการจัดส่ง </h3>
        <div class=\"col-12 row\">
          <span class=\"font-thi font-bold mx-4\">$shippingnote</span>
          <span class=\"font-thi font-bold mx-4\">$sender</span>
          <span class=\"font-thi font-bold mx-4\">$wages</span>
        </div>
      </div>
    ";
    return $lists;
  }
}
  function set_type($sell_types){
    $list = "<tr>
        <td>ตัวเลือกการจ่าย: </td>
    ";
      
      foreach($sell_types as $type){
        $list .= '<td class=\"font-weight-bold"\">'. htmlspecialchars($type['list_typepay'], ENT_QUOTES) .'</td>';
      }
    $list.="</tr>";
    return $list;
  }
  

  function slip($img_slip){
    if($img_slip !==""){ 
      return "
        <div>
          <span class=\"col-12\">หลักฐานการโอน</span>
        </div>
        <img src=\"http://localhost/stockproduct/db/slip-sellorder/$img_slip \" class=\"img-sell\"/> ";
    }
  }
function status_pays($totalprice,$custompay,$countstuck){
  if($totalprice == $custompay){
    return "<p class=\"text-success font-weight-bold\">[ จ่ายครบถ้วน ]</p>";
  }elseif($totalprice == $countstuck){
    return "<p class=\"text-danger font-weight-bold\">[ ติดค้าง ]</p>";
  }else{
    return "<p class=\"text-danger font-weight-bold\">[ จ่ายแล้วแต่ยังติดค้าง ]</p>";
  }
}
function detailOrderSell($id_ordersell,$ordersell_name,$is_totalprice,$custome_name,$tell_custome,$location_send,$date_time_sell,$total,$totalproduct,$reasons,$sender,$tell_sender,$count_totalpays,$count_stuck,$slip_ordersell,$adder_id,$create_at,$sell_type){
  $list = "
    <div class=\"col-12 p-0 m-0\">
      <div class=\"col-12 row\">
         <a href=\"PDF/PDF_ordersell.php?ordersell_id=$id_ordersell\" target=\"_blank\" class=\"ml-auto px-5 mt-4\">
            <i class=\"fas fa-file-code\"></i>
            Print PDF
          </a>
      </div>
      <div class=\"col-12 row p-0 m-0\">
        <div class=\"col-lg-3 row\">
          รายการ: <p class=\"font-weight-bold\" style=\"color:#cc00ff\">[ $ordersell_name ]</p>
        </div>

        <div class=\"col-lg-3 row\">
          จำนวนรายการ: <p class=\"font-weight-bold\">[ $total ] รายการ</p>
        </div>
        <div class=\"col-lg-3 row\">
          ราคารวม: <p class=\"font-weight-bold\">[ $is_totalprice ]</p> บาท
        </div>
        <div class=\"col-lg-3 p-0 m-0 row\">
          วันที่ชื่อ: <p class=\"font-weight-bold\">[ $date_time_sell ]</p>
        </div>
      </div>
      <div class=\"row p-0 m-0\">
        <div class=\"col-sm-12 col-md-7 col-lg-9 p-0 m-0 row\">
          <div class=\"col-lg-6 col-xl-4 row\">
            ชื่อผู้ซื้อ: <p class=\"font-weight-bold text-primary\">[ $custome_name ]</p>
          </div>
          <div class=\"col-lg-6 col-xl-4 row\">
            เบอร์โทร: <p class=\"font-weight-bold p-0 m-0\">[ $tell_custome ]</p>
          </div>
          
          <div class=\"col-lg-6 col-xl-4 row p-0 m-0\">
            สถานะ: ".status_pays($is_totalprice,$count_totalpays,$count_stuck)."
          </div>
          <div class=\"col-lg-6 col-xl-4 row\">
              จำนวนกล่องทั้งหมด <p class=\"font-weight-bold\">[ $totalproduct ] </p> ชิ้น
          </div>
          <div class=\"col-sm-6 col-lg-5 col-xl-4 row p-0 m-0\">
            จำนวนเงินที่จ่าย: <p class=\"font-weight-bold text-success\">[ $count_totalpays ] </p> บาท
          </div>
          <div class=\"col-sm-6 col-lg-5 col-xl-4 row p-0 m-0\">
            จำนวนเงินที่ค้าง: <p class=\"font-weight-bold text-danger\">[ $count_stuck ] </p> บาท
          </div>
          <div class=\"col-12 row m-0 p-0\">
            
              ที่อยู่ในการจัดส่ง: <p class=\"font-wight-bold text-info\">[ $location_send ] </p>

          </div>
          <div class=\"col-xl-3 row p-0 m-0\">
            ผู้ส่ง: <p class=\"font-weight-bold\">[ $sender ] </p>
          </div>
          <div class=\"col-xl-4 row p-0 m-0\">
            เบอร์โทรผู้ส่ง: <p class=\"font-weight-bold\">[ $tell_sender ] </p>
          </div>
          <div class=\"col-md-12 col-lg-6 col-xl-5 m-0 p-0 \">
            <table class=\"table table-data-pay\">
              <tbody>
                ". set_type($sell_type) ."
              </tbody>
            </table>
          </div>
          <div class=\"col-12\">                         
              <div class=\"col-12 row p-0 m-0\">[ $reasons ]</div>
          </div>
        </div>
        <div class=\"col-sm-12 col-md-5 col-lg-3\">
          <div class=\"div-img\">
            ". slip($slip_ordersell) ."
          </div>
        </div>
      </div>
    </div>
  ";
  echo $list;
}

function detailCustomer($customname){

}
function boxCustom($titleText, $data, $type){
  $listData = "
      <div class=\"col-xl-4 col-md-6 mb-2\">
        <div class=\"card shadow  border\">
            <div class=\"card-body\">
                <div class=\"row no-gutters align-items-center\">
                    <div class=\"col mr-2\">
                        <div class=\"text-xs font-weight-bold text-primary text-uppercase mb-1\">
                            $titleText
                        </div>
                        <div class=\"h5 mb-0 font-weight-bold text-gray-800\">$data $type</div>
                    </div>
                </div>
            </div>
        </div>
      </div>";
    echo $listData;
}

function listProductSell($number,$product_id, $product_anme, $rate_customerprice, $type_custom, $lotal_product, $price_topay){


  $list = "
    <tr>
      <td class=\"font-weight-bold\">$number</td>
      <td class=\"font-weight-bold\">$product_anme</td>
      <td class=\"font-weight-bold\">$rate_customerprice</td>
      <td class=\"font-weight-bold\">$lotal_product</td>
      <td class=\"font-weight-bold\">$price_topay</td>
      <td class=\"font-weight-bold\">". typecustomse($type_custom) ."</td>
      <td class='text-center'>
            <div class=\"table-data-feature\" >
              <button type=\"button\" id=\"update_order_sell\" data-target=\"#modalFormUpdateOrderSell\" data-toggle=\"modal\"  
                 class=\"item\" data-id=\"$product_id\" data-productname=\"$product_anme\" data-customerprice=\"$rate_customerprice\" 
                 data-totalproduct=\"$lotal_product\" data-pricetopay=\"$price_topay\" data-customtype=\"$type_custom\"
              >
                  <i class=\"fas fa-pencil-alt text-warning\"></i>
              </button>
              <button type=\"button\" class=\"item\" id=\"falseTrashBtnProject\" data-id=\"$product_id\">
                <i class=\"fas fa-trash-alt text-danger\"></i>
              </button>
          </div>
        </td>
    </tr>
  ";
  echo $list;
}

function listDetailOrderBuy($order_id, $order_name, $total_cost, $data_time_buy, $order_slipt, $total_product, $count_product){
  $list = "
    <div class=\"col-12 shadow-sm row\">
      <div class=\"col-4 p-2\">
        <span class=\"my-3\">สลิป : </span>
        <img class=\"card-img-top\" src=\"../../db/slip-orders/$order_slipt\"/>
      </div>
      <div class=\"col-7 py-4 mx-auto\">
        <div class=\"col-12 row\">
          <a href=\"PDF/PDF_orderbuy.php?order_id=$order_id\" target=\"_blank\" class=\"border ml-auto  py-2 px-5\">
            <i class=\"fas fa-file-code\"></i>
            Print PDF
          </a>
        </div>
        <h2 class=\"card-title font-bold\">ชื่อรายการ : $order_name</h2>
        <div class=\"col-12 row mx-2\">
          <div class=\"col-4\">ค่าใช้จ่าย $total_cost บาท</div>
          <div class=\"col-4\">สินค้า $total_product รายการ</div>
          <div class=\"col-4\">จำนวน $count_product ชิ้น</div>
        </div>
        <div class=\"col-12 row mx-2 pt-4\">
          <div class=\"border p-3 ml-auto rounded\">
            สั่งซื้อเมื่อ : $data_time_buy
          </div>
        </div>
      </div>
    </div>
  ";
  echo $list;
}

function listProductBuy($number,$product_id, $product_name, $cost_price, $total_product, $prices){
  $list = "
    <tr>
      <td class=\"font-weight-bold \"> $number</td>
      <td class=\"font-weight-bold \"> $product_name</td>
      <td class=\"font-weight-bold \"> $cost_price บาท</td>
      <td class=\"font-weight-bold \"> $total_product ชิ้น</td>
      <td class=\"font-weight-bold \"> $prices บาท</td>
    </tr>
  ";
  echo $list;
}

function listCustomer($number,$custom_name,$count_order,$pricessell,$pricespay,$countstuck){
  $list = "
    <tr>
      <td class=\"font-weight-bold\"></td>
      <td class=\"font-weight-bold\">$number</td>
      <td class=\"font-weight-bold\">$custom_name</td>
      <td class=\"font-weight-bold\">$count_order รายการ</td>
      <td class=\"font-weight-bold\">$pricessell บาท</td>
      <td class=\"font-weight-bold\">$pricespay บาท</td>
      
      <td class=\"font-weight-bold\">$countstuck บาท</td>
      <td class='text-center'>
            <div class=\"table-data-feature\" >
              <a class=\"item\" data-toggle=\"tootip\" data-placement=\"top\" title=\"จัดสรรทุน\" href=\"details/detail_customer.php?custom_name=".urlencode($custom_name)." \">
                <i class=\"fas fa-list-alt\"></i>
              </a>
              <button type=\"button\" class=\"item\" id=\"falseTrashBtnProject\" data-custom=\"$custom_name\">
                <i class=\"fa-solid fa-circle-dollar-to-slot\"></i>
              </button>
          </div>
        </td>
    </tr>
  ";
  echo $list;
}

function listOrderForCustomer($number, $order_id,$order_name,$date_sell,$prices_all,$price_pay,$price_stuck,$count_product,){
  $list = "
    <tr>
      <td></td>
      <td class=\"font-weight-bold\">$number</td>
      <td class=\"font-weight-bold\">$order_name</td>
      <td class=\"font-weight-bold\">$date_sell</td>
      <td class=\"font-weight-bold\">$prices_all</td>
      <td class=\"font-weight-bold\">$price_pay</td>
      <td class=\"font-weight-bold\">$price_stuck</td>
      <td class=\"font-weight-bold\">$count_product</td>
      <td class='text-center'>
          <div class=\"table-data-feature\" >
              <a class=\"item\" data-toggle=\"tootip\" data-placement=\"top\" title=\"จัดสรรทุน\" href=\"../details/detail_ordersell.php?ordersell_id=$order_id \">
                <i class=\"fas fa-list-alt\"></i>
              </a>
          </div>
        </td>
    </tr>
  ";
  echo $list;
}

// function detailCustomer(){

// }

?>