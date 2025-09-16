<?php
  session_start();
  include_once("../../backend/config.php");
  include_once("../../link/link-2.php");
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  if(!$conn){
      die("not connect". mysqli_connect_error());
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<script type="text/javascript">
  const MySetSweetAlert =(Icons,Titles,Texts,location)=>{
      Swal.fire({
          icon: Icons,
          title: Titles,
          text:Texts,
          confirmButtonText:"OK"
      }).then((result)=>{
           window.location = `${location}`
      })
  }
</script>
    <?php
      date_default_timezone_set("Asia/Bangkok");
      $id_user = $_SESSION['users_order']['id'];
      $day_add = date('Y-m-d H:i:s');

      function setImgpath($nameImg){
        $ext = pathinfo(basename($_FILES[$nameImg]["name"]), PATHINFO_EXTENSION);
          if($ext !=""){
              $new_img_name = "img_".uniqid().".".$ext;
              
              $uploadPath = '../../db/slip-sellorder/'.$new_img_name;
              move_uploaded_file($_FILES[$nameImg]["tmp_name"],$uploadPath);
              $newImage = $new_img_name;
              
          }else{
              $newImage = '';
              
          }
          return $newImage;
      }
      
      if($_SERVER['REQUEST_METHOD'] === "POST"){
          //echo "ordersell_id";
          $ordersell_id = $_POST['ordersell_id'];
          //echo $ordersell_id;
          //echo "<br/> default_img:";
          $default_img = $_POST['default_img'];
          //echo $default_img;
          //echo "<br/> ordersell_name:";
          $ordersell_name = $_POST['ordersell_name'];
          //echo $ordersell_name;

          //echo "<br/> is_totalprice:";
          $is_totalprice = $_POST['is_totalprice'];
          //echo $is_totalprice;

          //echo "<br/> custome_name:";
          $custome_name = $_POST['custome_name'];
          //echo $custome_name;

          //echo "<br/> tell_custome:";
          $tell_custome = $_POST['tell_custome'];
          //echo $tell_custome;

         // echo "<br/> date_time_sell:";
          $date_time_sell = $_POST['date_time_sell'];
          //echo $date_time_sell;

          //echo "<br/> sender:";
          $sender = $_POST['sender'] ?? "";
         // echo $sender;

          //echo "<br/> tell_sender:";
          $tell_sender = $_POST['tell_sender'];
          //echo $tell_sender;

          //echo "<br/> location_send:";
          $location_send = $_POST['location_send'];
          //echo $location_send;

          //echo "<br/> shipping_note:";
          $shipping_note = $_POST['shipping_note'] ?? "";
          //echo $shipping_note;
          //echo "<br/> wages:";
          $wages = $_POST['wages'] ?? null;
          if(empty($wages)){
            $wages = 0;
          }else{
            $wages = preg_replace('/[^\d.]/','',$wages);
            $wages = (float)$wages;
          }
          //echo $wages;
          //echo "<br/><hr/><br/>";
          //echo "<br/> payment_options:";

          $payment_options = $_POST['payment_option'];
          //print_r($payment_options);

          //echo "<br/><hr/><br/>";
          //echo "<br/> reason:";
          $reason = $_POST['reason'] ?? "";
          //echo $reason;
          //echo "<br/> count_totalpays:";
          $count_totalpays = $_POST['count_totalpays'] ?? 0;
          if($count_totalpays === '' || $count_totalpays === null){
            $count_totalpays = 0;
          }
          //echo $count_totalpays;

          //echo "<br/> count_stuck:";
          $count_stuck = $_POST['count_stuck'] ?? 0;
          //echo $count_stuck;
        $coun_update = 0;
        $count_delete = 0;
        $count_insert = 0;
        $all_success = true;
        //echo "<br/><hr/><br/>";

         if(isset($_FILES['eSell_slip'])&& $_FILES['eSell_slip']['error'] == 0 ){
          $update_ordersell = "UPDATE orders_sell SET ordersell_name='$ordersell_name', is_totalprice='$is_totalprice',custome_name='$custome_name',tell_custome='$tell_custome',
            date_time_sell='$date_time_sell',shipping_note='$shipping_note',sender='$sender',tell_sender='$tell_sender',location_send='$location_send',wages='$wages',
            reason='$reason',slip_ordersell='".setImgpath("eSell_slip")."',count_totalpays='$count_totalpays',count_stuck='$count_stuck',adder_id='$id_user',create_at='$day_add' 
            WHERE id_ordersell='$ordersell_id'
          ";
         }else{
          $update_ordersell = "UPDATE orders_sell SET ordersell_name='$ordersell_name', is_totalprice='$is_totalprice',custome_name='$custome_name',tell_custome='$tell_custome',
            date_time_sell='$date_time_sell',shipping_note='$shipping_note',sender='$sender',tell_sender='$tell_sender',location_send='$location_send',wages='$wages',
            reason='$reason',slip_ordersell='$default_img',count_totalpays='$count_totalpays',count_stuck='$count_stuck',adder_id='$id_user',create_at='$day_add' 
            WHERE id_ordersell='$ordersell_id'
          ";
         }
         $query_updatesell = mysqli_query($conn,$update_ordersell) or die(mysqli_error($conn));
         if($query_updatesell){

              $sql_typepay = mysqli_query($conn,"SELECT ordersell_id,list_typepay FROM sell_typepay WHERE ordersell_id=$ordersell_id") or die(mysqli_error($conn));
              $dbTypepay = [];
              while($route = mysqli_fetch_assoc($sql_typepay)){
                $dbTypepay[] = $route['list_typepay'];
              }
              //echo "<br/><hr/><br/>";
              //echo "<br/> dbTypepay:";
              //print_r($dbTypepay);
              //echo "<br/> toIsert:";

              $toIsert = array_diff($payment_options,$dbTypepay);
              $toDelete = array_diff($dbTypepay, $payment_options);
              //print_r($toIsert);
              //echo "<br/> toDelete:";
              //print_r($toDelete);
              //echo "<br/>";
              


              if(!empty($toDelete)){
                foreach( $toDelete as $del){
                  $del = mysqli_real_escape_string($conn, $del);
                  mysqli_query($conn,"DELETE FROM sell_typepay WHERE ordersell_id=$ordersell_id AND list_typepay='$del'");
                }
              }

              if(!empty($toIsert)){
                foreach($toIsert as $ins){
                  $ins = mysqli_real_escape_string($conn, $ins);
                  mysqli_query($conn,"INSERT INTO sell_typepay (ordersell_id,list_typepay,create_at) VALUES ($ordersell_id,'$ins','$day_add')");
                }
              }

              $edit_id = [];
              $add_id = [];
              $trash_id = [];
              $newIds = [];
              if(isset($_FILES['eSell_slip']) && $_FILES['eSell_slip']['error'] == 0){
                 unlink(__DIR__  . '/../../db/slip-sellorder/' . $default_img);
                 //echo "haveimg";
              }
              $old_product = [];
              $sql_productsell = mysqli_query($conn,"SELECT list_sellid,ordersell_id,productname FROM list_productsell WHERE ordersell_id=$ordersell_id") or die(mysqli_error($conn));
              while($row = mysqli_fetch_assoc($sql_productsell)){
                $old_product[] = $row['list_sellid'];
              }
              //echo "<br/><hr/><br/>";
              //echo "<br/> old_product:";
              //print_r($old_product);
              
              //echo "<br/>product_id:";
              $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : [];
              //print_r($product_id);
              //echo "<br/> is_products:";

              $is_products = $_POST['product'];
              //print_r($is_products);
              //echo "<br/> is_costommerd:";
              $is_costommerd = $_POST['costommerds'];
              //print_r($is_costommerd);
              //echo "<br/> tatol_products:";
              $tatol_products = $_POST['tatol_product'];
              //print_r($tatol_products);
              //echo "<br/> resutl_prices:";
              $resutl_prices = $_POST['resutl_price'];
              //print_r($resutl_prices);
              //echo "<br/> type_custom";
              $type_custom = $_POST['type_custom'];
              //print_r($type_custom);

              //echo "<br/><hr/><br/>";

              foreach($is_products as $key => $resdata){
                //echo "<br/> pid:";
                $pid = !empty($product_id[$key]) ? $product_id[$key] : null;
                //echo $pid;
                //echo "<br/> res_productname:";
                
                $res_productname = $is_products[$key];
                //echo $res_productname;
                //echo "<br/> res_costommered:";
                $res_costommered = mysqli_real_escape_string($conn, trim(number_format((float)$is_costommerd[$key], 2, '.','')));
                //echo $res_costommered;
                //echo "<br/> res_total:";
                $res_total = mysqli_real_escape_string($conn, trim($tatol_products[$key]));
                //echo $res_total;
                //echo "<br/> res_prices:";
                $res_prices = mysqli_real_escape_string($conn, trim(number_format((float)$resutl_prices[$key], 2, '.','')));
                //echo $res_prices;
                //echo "<br/> res_custom:";
                $res_custom = mysqli_real_escape_string($conn,trim($type_custom[$key]));
                ///echo $res_custom;
                //echo "<br/>";
                if($pid){
                 // echo "have id:";
                 // echo $pid;
                  $sql_edit = "UPDATE list_productsell SET productname='$res_productname',rate_customertype='$res_costommered',type_custom='$res_custom',tatol_product='$res_total',price_to_pay='$res_prices' WHERE list_sellid='$pid' AND ordersell_id='$ordersell_id'";
                  $query_editproduct = mysqli_query($conn,$sql_edit) or die(mysqli_error($conn));
                  if($query_editproduct){
                    $coun_update++;
                    $edit_id[] = $pid;
                    $newIds[] = $pid;
                  }else{
                    $all_success = false;
                  }
                }else{
                  //echo "not id :";
                  $sql_insert = "INSERT INTO list_productsell (ordersell_id,productname,rate_customertype,type_custom,tatol_product,price_to_pay,create_at) VALUES('$ordersell_id','$res_productname','$res_costommered','$res_custom','$res_total','$res_prices','$day_add')";
                  $query_insert = mysqli_query($conn,$sql_insert) or die(mysqli_error($conn));
                  if($query_insert){
                    $count_insert++;
                    $is_id = mysqli_insert_id($conn);
                    $add_id[] = $is_id;
                    $newIds[] = $is_id;
                  }else{
                    $all_success = false;
                  }
                }
                //echo "<br/><hr/><br/>";
              }
              //echo "<br/><hr/><br/>";
              //echo "<br/> is_id_to_delete:";
              $is_id_to_delete = array_diff($old_product, $newIds);
              print_r($is_id_to_delete);
              //echo "<br/> ids:";
              if(!empty($is_id_to_delete)){
                $ids = implode(",", $is_id_to_delete);
                //echo $ids;
                $query_del = mysqli_query($conn,"DELETE FROM list_productsell WHERE list_sellid IN ($ids)");
                if($query_del){
                  $count_delete++;
                  $trash_id[] = $is_id_to_delete;
                }else{
                  $all_success = false;
                }
              }
            if($all_success){
                echo "<script type=\"text/javascript\">
                        MySetSweetAlert('success', 'เรียบร้อย', 'อัปเดต: $coun_update, เพิ่ม: $count_insert, ลบ: $count_delete รายการ', '../ordersell.php')
                    </script>";
              }else{
                echo "<script type=\"text/javascript\">
                    MySetSweetAlert('error', 'เกิดข้อผิดพลาด', 'ไม่สามารถทำงานบางส่วนได้', '../ordersell.php')
                </script>";
              }
         }

      }
      
    ?>
</body>
</html>