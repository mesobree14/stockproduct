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
          
          $uploadPath = '../../db/slip-finance/'.$new_img_name;
          move_uploaded_file($_FILES[$nameImg]["tmp_name"],$uploadPath);
          $newImage = $new_img_name;
          
      }else{
          $newImage = '';
          
      }
      return $newImage;
  }

  if($_SERVER['REQUEST_METHOD'] === "POST"){
    if($_POST['status_form'] === "capital"){

        $count_capital = $_POST['count_capital'];
        $date_time_capital = $_POST['date_time_capital'];
        $sql = "INSERT INTO capital(count_capital,slip_capital,date_time_ad,adder_id,create_at)
          VALUES('$count_capital','".setImgpath("capital_slip")."','$date_time_capital','$id_user','$day_add')
          ";
        $query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
        if($query){
          echo "<script type=\"text/javascript\">
                    MySetSweetAlert(\"success\",\"เรียบร้อย\",\"เพิ่มทุนเรียบร้อยแล้ว\",\"../finance.php\")
                </script>";
        }else{
           echo "<script type=\"text/javascript\">
                    MySetSweetAlert(\"warning\",\"ล้มเหลว!\",\"เพิ่มทุนล้มเหลว\",\"../finance.php\")
                </script>";
        }
    }elseif($_POST['status_form'] === "withdraw"){
      $count_withdraw = $_POST['count_withdraw'];
      $date_time_withdraw = $_POST['date_time_withdraw'];
      $reason = $_POST['reason'];
      $sql = "INSERT INTO withdraw(count_withdraw,slip_withdraw,date_withdrow,reason,id_adder,create_at)
        VALUES('$count_withdraw','".setImgpath("withdraw_slip")."','$date_time_withdraw','$reason','$id_user','$day_add')
      ";
      $query = mysqli_query($conn,$sql) or die(mysqli_error($conn));
      if($query){
          echo "<script type=\"text/javascript\">
                    MySetSweetAlert(\"success\",\"เรียบร้อย\",\"เพิ่มเบิกถอนเรียบร้อยแล้ว\",\"../finance.php\")
                </script>";
        }else{
           echo "<script type=\"text/javascript\">
                    MySetSweetAlert(\"warning\",\"ล้มเหลว!\",\"เพิ่มเบิกถอนล้มเหลว\",\"../finance.php\")
                </script>";
        }
    }
  }
?>
</body>
</html>