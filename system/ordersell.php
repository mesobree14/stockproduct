<?php
session_start();
include_once("../backend/config.php");
include_once("../link/link-2.php");
include_once("../components/component.php");
if(!isset($_SESSION['users_order'])){
  echo "
          <script>
              alert('pless your login');
              window.location = '../index.php';
          </script>
      ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/css/uikit.css">
    <link rel="stylesheet" href="../assets/scripts/module/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
    <link rel="stylesheet" href="../assets/scss/navigationTrue-a-j.scss">
    <link rel="stylesheet" href="../assets/scss/revenue.scss">
    <link rel="stylesheet" href="../assets/scripts/module/test/test.scss">
    <script src="../assets/scripts/module/test/test.js"></script>
    
    <link rel="stylesheet" href="../assets/scripts/module/select-picker/select.scss">

  <title>Document</title>
</head>
<body>
  <div class="page-wrapper chiller-theme toggled">
    <?php  navigationOfiicer(); ?>
    <main class="page-content mt-0">
      <?php navbar("ราการขาย"); ?>
      <div class="container-fluid row">
          <?php  
                          $limit = 10;
                          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                          if($page < 1){
                            $page = 1;
                          }
                          $start = ($page - 1) * $limit;
                          $sql = "SELECT 
                                    O.id_ordersell,
                                    O.ordersell_name,
                                    O.is_totalprice,
                                    O.custome_name,
                                    O.date_time_sell,
                                    O.count_stuck,
                                    O.count_totalpays,
                                    COALESCE(P_SUM.item_count, 0)        AS item_count,
                                    COALESCE(OWP_SUM.count_paydebt, 0)  AS count_paydebt,
                                    COALESCE(OWP_SUM.sum_amount_paid, 0) AS sum_amount_paid,
                                    COALESCE(ST_SUM.list_typepay, '')    AS list_typepay
                                  FROM orders_sell O

                                  -- aggregate products (one per order)
                                  LEFT JOIN (
                                    SELECT ordersell_id, COUNT(DISTINCT list_sellid) AS item_count
                                    FROM list_productsell
                                    GROUP BY ordersell_id
                                  ) P_SUM ON P_SUM.ordersell_id = O.id_ordersell

                                  -- aggregate payments (one per order)
                                  LEFT JOIN (
                                    SELECT ordersell_ids, COUNT(*) AS count_paydebt, SUM(amount_paid) AS sum_amount_paid
                                    FROM order_was_paid
                                    GROUP BY ordersell_ids
                                  ) OWP_SUM ON OWP_SUM.ordersell_ids = O.id_ordersell

                                  -- aggregate payment types
                                  LEFT JOIN (
                                    SELECT ordersell_id, GROUP_CONCAT(DISTINCT list_typepay SEPARATOR ', ') AS list_typepay
                                    FROM sell_typepay
                                    GROUP BY ordersell_id
                                  ) ST_SUM ON ST_SUM.ordersell_id = O.id_ordersell

                                  ORDER BY O.create_at DESC LIMIT $start,$limit
                                ";
                               
                          $query_data = mysqli_query($conn,$sql) or die(mysqli_error($conn));
                          $orders_ass = [];
                          while($rows = mysqli_fetch_assoc($query_data)){
                            $orders_ass[] = $rows;
                          }
                          $sql_totals = mysqli_query($conn,"SELECT COUNT(*) as total FROM orders_sell");
                          $row_total = mysqli_fetch_assoc($sql_totals);
                          $totals = $row_total['total'];
                          $total_pages = ceil($totals / $limit);

                        
                          
                          function status_pay($list_typepay,$count_stuck,$sum_amount_paid,$is_totalpay,$count_paydebt,$count_totalpays ){
                              if(is_string($list_typepay)){
                                  $list_typepay = explode(",", str_replace(' ', '', $list_typepay));
                              }
                              $hasMandatory = in_array("ติดค้าง", $list_typepay);
                              $hasOption = !empty(array_intersect(["โอน", "จ่ายสด"], $list_typepay));
                              if($hasMandatory && $hasOption){
                                if($is_totalpay == ($sum_amount_paid + $count_totalpays)){
                                  return "<span class='text-success'>จ่ายหนี้ครบถ้วน</span>";
                                }else if($sum_amount_paid != 0 && ($sum_amount_paid + $count_totalpays) != $is_totalpay){
                                  return "<span class='text-danger'>จ่ายแล้ว($count_paydebt)ครั้ง แต่ยังติดค้างอยู่</span>";
                                }else{
                                  return "<span class='text-danger'>จ่ายแล้วแต่ยังติดค้างอยู่</span>";
                                }
                              } else if(in_array("โอน", $list_typepay)){
                                  return "<span class='text-success'>โอนจ่ายแล้ว</span>";
                              } else if(in_array("จ่ายสด", $list_typepay)){
                                  return "<span class='text-success'>จ่ายสดแล้ว</span>";
                              } else if(in_array("ติดค้าง", $list_typepay)){

                                if($is_totalpay == ($sum_amount_paid + $count_totalpays)){
                                  return "<span class='text-success'>จ่ายหนี้ครบถ้วน</span>";
                                }else if($sum_amount_paid != 0 && ($sum_amount_paid + $count_totalpays) != $is_totalpay){
                                  return "<span class='text-danger'>จ่ายแล้ว($count_paydebt)ครั้ง แต่ยังติดค้างอยู่</span>";
                                }else{
                                  return "<span class='text-danger'>ติดค้าง</span>";
                                }
                              } else {
                                  return "<span class='text-secondary'>ไม่มีข้อมูล</span>";
                              }
                          }
            ?>
            <div class="ml-auto mx-4 d-flex align-items-center">
                <p class="mb-0 font-bold">ทั้งหมด <?php echo $totals ?> รายการ</p>
            </div>
          <div class="border mx-4">
            <button class="bd-none au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" 
                data-target="#modalFormOrderSell"
            >
                <i class="fas fa-plus"></i>
                  เพิ่มรายการขาย
            </button>
          </div>
          <div class="col-md-12 mt-4">
            <div class="table-responsive table-responsive-data2 mt-2">
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อออเดอร์</th>
                            <th>รายการสินค้า</th>
                            <th>ราคาจ่าย</th>
                            <th>จ่ายไปแล้ว</th>
                            <th>ชื่อผู้ซื้้อ</th>
                            <th>สถานะการจ่าย</th>
                            <th>วันที่-เวลาที่ขาย <i class="fa-solid fa-arrow-up"></i></th>
                            <th>จัดการ</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                      

                      <?php
                          foreach($orders_ass as $key =>$res){
                              listOrderSell(
                                ($key+1), $res['id_ordersell'],$res['ordersell_name'],$res['item_count'],
                                $res['is_totalprice'],$res['custome_name'],$res['date_time_sell'],
                                status_pay($res['list_typepay'],$res['count_stuck'],$res['sum_amount_paid'],$res['is_totalprice'],$res['count_paydebt'],$res['count_totalpays']),
                                ($res['sum_amount_paid'] + $res['count_totalpays'])
                              );
                            }
                      ?>
                    </tbody>
                </table> 

               <nav class="d-flex justify-content-center align-items-center pb-4">
                <ul class="pagination my-4">
                  <?php 
                    if($page > 1){
                      echo '
                        <li class="page-item">
                          <a class="page-link" href="?page='.($page-1).'">Previous</a>
                        </li>
                      ';
                    }
                    if($page > 3){
                        echo '<li class="page-item">
                        <a class="page-link" href="?page=1">1</a>
                        </li>';

                        if($page > 4){
                            echo '<li class="page-item disabled">
                            <span class="page-link">...</span>
                            </li>';
                        }
                    }
                    for($i = $page - 2; $i <= $page + 2; $i++){

                        if($i > 0 && $i <= $total_pages){

                            $active = ($i == $page) ? 'active' : '';

                            echo '<li class="page-item '.$active.'">
                            <a class="page-link" href="?page='.$i.'">'.$i.'</a>
                            </li>';
                        }

                    }
                    if($page < $total_pages - 2){

                        if($page < $total_pages - 3){
                          echo '<li class="page-item disabled">
                          <span class="page-link">...</span>
                          </li>';
                        }

                        echo '<li class="page-item">
                        <a class="page-link" href="?page='.$total_pages.'">'.$total_pages.'</a>
                        </li>';

                    }
                    if($page < $total_pages){
                        echo '<li class="page-item">
                          <a class="page-link" href="?page='.($page+1).'">Next</a>
                        </li>';
                    }
                  ?>
                </ul>
               </nav>
               
            </div>
          </div>
      </div>
      <mian-form-ordersell></mian-form-ordersell>
      <main-update-ordersell></main-update-ordersell>
    </main>
  </div>
  <script src="../assets/scripts/ui-ordersell.js"></script>
  <script src="../assets/scripts/update-ui-ordersell.js"></script>
  <script src="../assets/scripts/script-bash.js"></script>
</body>
</html>