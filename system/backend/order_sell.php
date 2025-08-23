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
        if($_POST['status_form'] === "create"){
                    
          $is_products = $_POST['product'];
          $is_costommerd = $_POST['costommerds'];
          $tatol_products = $_POST['tatol_product'];
          $resutl_prices = $_POST['resutl_price'];
          

          $ordersell_name = $_POST['ordersell_name'];
          $is_totalprice = $_POST['is_totalprice'];
          $custome_name = $_POST['custome_name'];
          $tell_custome = $_POST['tell_custome'];
          $date_time_sell = $_POST['date_time_sell'];
          $shipping_note = $_POST['shipping_note'];
          $sender = $_POST['sender'];
          $wages = $_POST['wages'];

          $payment_options = $_POST['payment_option'];
          $reason = $_POST['reason'];

              //  print json_encode(array(
                // 'status'=> 201,
                // 'message'=> 'get data is success',
                // 'is_product'=> $is_products,
                // 'is_costommerd'=> $is_costommerd,
                // 'tatol_product'=> $tatol_products,
                // 'resutl_price'=> $resutl_prices,
                // 'ordersell_name'=> $is_product,
                // 'is_totalprice'=> $is_totalprice,
                // 'custome_name'=> $custome_name,
                // 'tell_custome'=> $tell_custome,
                // 'date_time_sell'=> $date_time_sell,
                // 'shipping_note'=> $shipping_note,
                // 'sender'=> $sender,
                // 'wages'=> $wages,
                // 'payment_option'=> $payment_option,
                // 'reason'=> $reason
              //));


          $chkstatus = [];
 
          $sql_add = "INSERT INTO orders_sell (ordersell_name,is_totalprice,custome_name,tell_custome,date_time_sell,shipping_note,sender,wages,reason,slip_ordersell,adder_id,create_at)
           VALUES ('$ordersell_name','$is_totalprice','$custome_name','$tell_custome','$date_time_sell','$shipping_note','$sender','$wages','$reason','".setImgpath("sell_slip")."','$id_user','$day_add')";
          $query_add = mysqli_query($conn, $sql_add) or die(mysqli_error($conn));
          if($query_add){
            $id_order_sell = mysqli_insert_id($conn);

            for($s=0; $s < count($payment_options); $s++){
                $payment_option = mysqli_real_escape_string($conn,trim($payment_options[$s]));
                if($payment_option !== ""){
                    $query_payment = mysqli_query($conn,"INSERT INTO sell_typepay (ordersell_id,list_typepay,create_at) VALUES ('$id_order_sell','$payment_option','$day_add')") or die(mysqli_error($conn));
                    if($query_payment){
                        $chkstatus[] = "success";
                    }
                }
            }


            for($i=0; $i < count($is_products); $i++){
              $is_product = mysqli_real_escape_string($conn,trim($is_products[$i]));
              $is_costomer = mysqli_real_escape_string($conn, trim($is_costommerd[$i]));
              $tatol_product = mysqli_real_escape_string($conn, trim($tatol_products[$i]));
              $resutl_price = mysqli_real_escape_string($conn, trim($resutl_prices[$i]));
              if($is_product !== "" || $is_costomer !== "" || $tatol_product !== "" || $resutl_price !== ""){
                $add_sqls = "INSERT INTO list_productsell (ordersell_id,productname,rate_customertype,tatol_product,price_to_pay,create_at)
                VALUES ('$id_order_sell','$is_product','$is_costomer','$tatol_product','$resutl_price','$day_add')";
                $query_addsql = mysqli_query($conn,$add_sqls) or die(mysqli_error($conn));
                if($query_addsql){
                  $chkstatus[] = "success";
                }
              }
            }
            //print_r($chkstatus);
            echo "<script type=\"text/javascript\">
                            MySetSweetAlert(\"success\",\"เรียบร้อย\",\"เพิ่มข้อมูลตามที่เลือกเรียบร้อยแล้ว\",\"../ordersell.php\")
                        </script>";
          }

        }
      }
      // elseif($_SERVER['REQUEST_METHOD'] === "GET"){
       
      // }
    ?>
</body>
</html>