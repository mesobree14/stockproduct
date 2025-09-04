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
                          <a href=\"{$path}orders.php\">
                              <i class=\"fas fa-users\"></i>
                              <span>คำสั่งซื้อ</span>
                          </a>
                        </li>
                        <li>
                          <a href=\"{$path}stock.php\">
                              <i class=\"fas fa-users\"></i>
                              <span>คลังสินค้า</span>
                          </a>
                        </li>
                        <li>
                          <a href=\"{$path}ordersell.php\">
                            <i class=\"fas fa-user\"></i>
                              <span>สินค้าที่ขาย</span>
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
            <a class=\"item\" data-toggle=\"tootip\" data-placement=\"top\" title=\"จัดสรรทุน\" href=\"details/detail_stock.php?product_name=".$product_name." \">
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
              <td class=\"font-weight-bold\">$productcount</td> 
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
    $list = "<tr>";
      foreach($sell_types as $type){
        $list .= '<td>'. htmlspecialchars($type['list_typepay'], ENT_QUOTES) .'</td>';
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
function detailOrderSell($ordersell_name,$is_totalprice,$custome_name,$tell_custome,$date_time_sell,$total,$shipping_note,$sender,$wages,$reason,$slip_ordersell,$adder_id,$create_at,$sell_type){

  $list_detail = "
      <div class=\"col-12\">
        <div class=\"col-12 row\">
          <button class=\"ml-auto px-5 mt-4\">
            <i class=\"fas fa-file-code\"></i>
            Print PDF
          </button>
        </div>
        <div class=\"col-12 row\">
          <div class=\"row \">
            <h3 class=\"fs-3 font-thi\">รายการ : </h3>
              <h3 class=\"fs-3 font-thi\">$ordersell_name</h3>
          </div>
          <div class=\"ml-auto row\">
            <h3 class=\"fs-3 font-thi\"></h3>
            <h3 class=\"fs-3 font-thi\">ราคาที่ต้องจ่าย $is_totalprice บาท</h3>
          </div>
          <div class=\"ml-auto row\">
            <h3 class=\"fs-3 font-thi\"></h3>
            <h3 class=\"fs-3 font-thi\">วันที่ขาย $date_time_sell</h3>
          </div>
        </div>
        <div class=\"col-12 row\">
          <div class=\"\">
              <h3 class=\"fs-3 font-thi\">จำนวนสินค้า $total รายการ</h3>
          </div>
          <div class=\"ml-auto \">
            <h3 class=\"fs-3 font-thi\">ผู้ซื้อ $custome_name</h3>
          </div>
          <div class=\"ml-auto \">
            
            <h3 class=\"fs-3 font-thi\">เบอรืโทร $tell_custome</h3>
          </div>
        </div>
        <div class=\"col-12 row pb-4\">
          <div class=\"col-5\">
            <span>ตัวเลือกการจ่าย</span>
            <table class=\"table table-data2 mydataTablePatron\">
              <tbody>
                ". set_type($sell_type) ."
              </tbody>
            </table>
          </div>
          <div class=\"col-7\">
            <label for=\"exampleFormControlTextarea1\">เหตุผล</label>
            <textarea class=\"form-control\" id=\"exampleFormControlTextarea1\" rows=\"2\">$reason</textarea>
          </div>
        </div>
        <div class=\"col-12 row mb-4\">
            ". status_deliver($shipping_note,$sender,$wages) ."
            <div class=\"col-sm-12 col-lg-4 div-img\">
            ". slip($slip_ordersell) ."
            </div>
        </div>
      </div>
  ";
  echo $list_detail;
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
          <button class=\"ml-auto px-5\">
            <i class=\"fas fa-file-code\"></i>
            Print PDF
          </button>
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

?>