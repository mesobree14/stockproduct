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

      function setImgpath($nameImg){
        $ext = pathinfo(basename($_FILES[$nameImg]["name"]), PATHINFO_EXTENSION);
          if($ext !=""){
              $new_img_name = "img_".uniqid().".".$ext;
              
              $uploadPath = '../../db/slip-orders/'.$new_img_name;
              move_uploaded_file($_FILES[$nameImg]["tmp_name"],$uploadPath);
              $newImage = $new_img_name;
              
          }else{
              $newImage = $new_img_name;
              
          }
          return $newImage;
    }
      
      if($_SERVER['REQUEST_METHOD'] === "POST"){
        if($_POST['status_form'] === "create"){
          $issucess = false;
          $countInsert = 0; 
          $day_add = date('Y-m-d H:i:s');

          $order_name = $_POST['order_name'];
          $totalcost_order = $_POST['totalcost_order'];
          $date_time_order = $_POST['date_time_order'];
          $count_order = count($_POST['product_name']);
          $insertOrder = "INSERT INTO order_box (order_name,slip_order,totalcost_order,count_order,id_adder,date_time_order,create_at) 
          VALUES ('$order_name','".setImgpath("slipt_order")."','$totalcost_order','$count_order','$id_user','$date_time_order','$day_add')";
          $queryOrder = mysqli_query($conn,$insertOrder) or die(mysqli_error($conn));
          if($queryOrder){
            $id_order = mysqli_insert_id($conn);

              $product_name = $_POST['product_name'];
              $count_product = $_POST['count_product'];
              $price_product = $_POST['price_product'];

              for($i=0; $i< count($product_name); $i++){
                $is_product_name = mysqli_real_escape_string($conn,trim($product_name[$i]));
                $is_count_product = mysqli_real_escape_string($conn,trim($count_product[$i]));
                $is_price_product = mysqli_real_escape_string($conn,trim($price_product[$i]));
                if($is_product_name !== "" || $is_count_product !== "" || $is_price_product !== ""){
                  $insertQl = "INSERT INTO stock_product (product_name,product_count,product_price,id_adder,id_order,create_at) VALUES ('$is_product_name','$is_count_product','$is_price_product','$id_user','$id_order','$day_add')";
                  $queryQl = mysqli_query($conn, $insertQl) or die(mysqli_error($conn));
                  echo $queryQl;
                  if($queryQl){
                    $countInsert++;
                    $issucess = true;
                  }
                }
              }
              if($issucess){
                   echo "<script type=\"text/javascript\">
                            MySetSweetAlert(\"success\",\"เรียบร้อย\",\"เพิ่มข้อมูลตามที่เลือกเรียบร้อยแล้ว\",\"../orders.php\")
                        </script>";

              }else{
                echo "<script type=\"text/javascript\">
                        MySetSweetAlert(\"warning\",\"ล้มเหลว!\",\"ไม่มีข้อมูลอะไรให้เพิ่มเลย!\",\"../orders.php\")
                      </script>";
              }
          }
        }
      }elseif($_SERVER['REQUEST_METHOD'] === "GET"){
       
      }
    ?>
</body>
</html>