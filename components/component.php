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
            <a class=\"item\" data-toggle=\"tootip\" data-placement=\"top\" title=\"จัดสรรทุน\" href=\"getting_a_scholarship.php \">
              <i class=\"fas fa-list-alt\"></i>
            </a>
            <button type=\"button\" id=\"update_order\" data-target=\"#modalFormUpdateOrder\" data-toggle=\"modal\"  
                   class=\"item\" data-id=\"$orderid\" data-ordername=\"$ordername\" data-totalcost=\"$totalcost_order\" 
                   data-priceorder=\"$price_order\" data-slipimage=\"$sliptImg\" data-dateorder=\"$date_time_order\"
            >
                <i class=\"fas fa-pencil-alt text-warning\"></i>
            </button>
            <button type=\"button\" class=\"item\" id=\"falseTrashBtnProject\" data-id=\"$orderid\">
              <i class=\"fas fa-trash-alt text-danger\"></i>
            </button>
          </div>
      </td>
    </tr>
    </form>
  ";
  echo $listOrder;
}

function tablelistStock ($number, $product_name, $total_order, $total_count, $total_price){
  $listStock = "
  <form>
    <tr>
      <td class=\"font-weight-bold\">$number</td>
      <td class=\"font-weight-bold\">$product_name</td>
      <td class=\"font-weight-bold\">$total_count บาท</td> 
      <td class=\"font-weight-bold\">ขาย</td> 
      <td class=\"font-weight-bold\">เหลือ</td> 
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
              <td class='text-center'>
                <div class=\"table-data-feature text-center\" >
                    <button type=\"button\" id=\"update_order\" data-target=\"#modalFormUpdateOrder\" data-toggle=\"modal\"  
                       class=\"item\" data-id=\"$product_id\" data-productname=\"$productname\" data-ordername=\"$ordername\" 
                       data-productprice=\"$productprice\" data-productcount=\"$productcount\"
                    >
                        <i class=\"fas fa-pencil-alt text-warning\"></i>
                    </button>
                    <button type=\"button\" class=\"item\" id=\"falseTrashBtnProject\" data-id=\"$product_id\">
                      <i class=\"fas fa-trash-alt text-danger\"></i>
                    </button>
                </div>
              </td>
            </tr>
        </form>
    ";
    echo $list_stock;
}

function detailStock($productname,$total_count,$total_price,$product_price, $count_sell, $income_price, $total_profit, $number_of_timessold){
    $remaining_products = $total_count - $count_sell;
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
           <p class=\"font-weight-bold res_text\"> $income_price บาท</p>
          </div>
          <div class=\"col-lg-2 col-md-3 col-sm-6 col-12 m-2 p-3 bg-white info-box rounded\">
                <span>ยอดกำไร</span>
                <p class=\"font-weight-bold res_text\"> $total_profit  บาท</p>
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

function listOrderSell($number, $ordersell_id, $ordersell_name,$count_item, $price_total,$customer_name,$date_sell){
  $listorder = "
    
      <tr>
        <td class=\"font-weight-bold\">$number</td>
        <td class=\"font-weight-bold\">$ordersell_name</td>
        <td class=\"font-weight-bold\">$count_item รายการ</td> 
        <td class=\"font-weight-bold\">$price_total บาท</td> 
        <td class=\"font-weight-bold\">$customer_name</td> 
        <td class=\"font-weight-bold\">status</td> 
        <td class=\"font-weight-bold\">$date_sell</td> 
        <td class='text-center'>
            <div class=\"table-data-feature\" >
              <a class=\"item\" data-toggle=\"tootip\" data-placement=\"top\" title=\"จัดสรรทุน\" href=\"details/detail_stock.php?ordersell_id=".$ordersell_id." \">
                <i class=\"fas fa-list-alt\"></i>
              </a>
              <button type=\"button\" id=\"update_order_sell\" data-target=\"#modalFormUpdateOrderSell\" data-toggle=\"modal\"  
                       class=\"item\" data-id=\"$ordersell_id\" data-ordersellname=\"$ordersell_name\" data-pricetotal=\"$price_total\" 
                       data-customername=\"$customer_name\" data-datesell=\"$date_sell\"
                    >
                        <i class=\"fas fa-pencil-alt text-warning\"></i>
                    </button>
                    <button type=\"button\" class=\"item\" id=\"falseTrashBtnProject\" data-id=\"$ordersell_id\">
                      <i class=\"fas fa-trash-alt text-danger\"></i>
                    </button>
            </div>
        </td>
      </tr>

  ";
  echo $listorder;
}

?>