<?php

  include_once("../../../backend/config.php");
  if(!$conn){
    die("not conn");
    
  }
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");	
   header("Cache-Control: post-check=0, pre-check=0", false);	
    header("Pragma: no-cache");
    date_default_timezone_set("Asia/Bangkok");
  if($_SERVER['REQUEST_METHOD'] === "DELETE"){
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'] ?? null;
    $tablename = $data['table_name'] ?? null;

    $status_del = "";
    
    
    if($tablename == "withdraw"){
        $sql_withdraw = mysqli_query($conn,"DELETE FROM withdraw WHERE withdraw_id=$id");
        if($sql_withdraw){
          if($data['image'] !== ""){
            if(file_exists(__DIR__ . "/../../../db/slip-finance/" . $data['image'])){
              if(unlink(__DIR__ . "/../../../db/slip-finance/" . $data['image'])){
                 $status_del = "del img withdraw";
              };
            }
          }
          print json_encode(array(
            "status"=>201,
            "message"=>"ลบข้อมูลเบิกถอนเรียบร้อย",
            "del_img" => $status_del
          ));
        }else{
          print json_encode(array(
            "status"=>404,
            "message"=>"delete data in table withdraw is error"
          ));
        }
    }elseif($tablename == "capital"){
      $sql_capital = mysqli_query($conn,"DELETE FROM capital WHERE capital_id=$id");
      if($sql_capital){

          if($data['image'] !== ""){
            if(file_exists(__DIR__ . "/../../../db/slip-finance/" . $data['image'])){
              if(unlink(__DIR__ . "/../../../db/slip-finance/" . $data['image'])){
                $status_del = "del img capital";
              };
            }
          }
          print json_encode(array(
            "status"=>201,
            "message"=>"ลบข้อมูลทุนเรียบร้อย",
            "del_img" => $status_del
          ));
        }else{
          print json_encode(array(
            "status"=>404,
            "message"=>"delete data in table capital is error"
          ));
        }
    }else{
      print json_encode(array(
         "status" => 404,
         "message" => "Missing id or type"
        ));
    }

  }

?>