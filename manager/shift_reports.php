
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Shift Closing | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
		<?php include('topheader.php');?>
    <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php 
      if ($type == 'CSR' || $type == 'Q&A' || $type == 'Redeem' || $department=='Redeem') {

        echo '
        <script>
        Swal.fire({
            title: "Access Denied",
            text: "You do not have permission to view this page.",
            icon: "error",
            confirmButtonColor: "#5156be"
        }).then(() => {
          window.location.href = "../index.php";
        });</script>';
        exit();
      }
			require_once('../connect_me.php');
      $database_connection = new Database_connection();
      $connect = $database_connection->connect();

      $html='';
      $i='0';
      $query = mysqli_query($connect, "SELECT 
        DATE(created_at) AS date,
        shift,
        SUM(CAST(cashappopening AS DECIMAL(65,0))) AS cashappopening_sum,
        SUM(CAST(cashappclosing AS DECIMAL(65,0))) AS cashappclosing_sum,
        SUM(CAST(cashappdifference AS DECIMAL(65,0))) AS cashappdifference_sum,
        SUM(CAST(gameopening AS DECIMAL(65,0))) AS gameopening_sum,
        SUM(CAST(gameclosing AS DECIMAL(65,0))) AS gameclosing_sum,
        SUM(CAST(gamedifference AS DECIMAL(65,0))) AS gamedifference_sum,
        SUM(CAST(redeemopening AS DECIMAL(65,0))) AS redeemopening_sum,
        SUM(CAST(redeemclosing AS DECIMAL(65,0))) AS redeemclosing_sum,
        SUM(CAST(redeemdifference AS DECIMAL(65,0))) AS redeemdifference_sum,
        SUM(CAST(pending_redeem AS DECIMAL(65,0))) AS pending_redeem_sum,
        SUM(CAST(cashout AS DECIMAL(65,0))) AS cashout_sum,
        SUM(CAST(bonus AS DECIMAL(65,0))) AS bonus_sum
        FROM (
          SELECT 
              id, pg_id, cashappopening, cashappclosing, cashappdifference,
              gameopening, gameclosing, gamedifference, redeemopening,
              redeemclosing, redeemdifference, pending_redeem, cashout, bonus,
              created_at,
              CASE
                  WHEN TIME(created_at) BETWEEN '08:00:00' AND '15:59:59' THEN 'Morning'
                  WHEN TIME(created_at) BETWEEN '16:00:00' AND '23:59:59' THEN 'Evening'
                  ELSE 'Night'
              END AS shift
          FROM shift_closing_details
        ) AS shifts
        GROUP BY date, shift
        ORDER BY date DESC, FIELD(shift, 'Morning', 'Evening', 'Night') DESC;
        ");
      if(mysqli_num_rows($query) > 0){
        while($row=mysqli_fetch_array($query)){
          // echo "<pre>";
          // print_r($row);
          // exit;
          $i++;
          $created_at     =$row['date'];
          $shift          =$row['shift'];
          $cashappopen    =$row['cashappopening_sum'];
          $cashappclose   =$row['cashappclosing_sum'];
          $cashappdiff    =$row['cashappdifference_sum'];
          $gameopen       =$row['gameopening_sum'];
          $gameclose      =$row['gameclosing_sum'];
          $gamediff       =$row['gamedifference_sum'];
          $redeemopen     =$row['redeemopening_sum'];
          $redeemclose    =$row['redeemclosing_sum'];
          $redeemdiff     =$row['redeemdifference_sum'];
          $pending_redeem =$row['pending_redeem_sum'];
          $cashout        =$row['cashout_sum'];
          $bonus          =$row['bonus_sum'];
          // $uname          =$row['uname'];

          $html.=
          '<tr>
            <td>'.$i.'</td>
            <td>'.$cashappopen.'</td>
            <td>'.$cashappclose.'</td>
            <td>'.$cashappdiff.'</td>
            <td>'.$gameopen.'</td>
            <td>'.$gameclose.'</td>
            <td>'.$gamediff.'</td>
            <td>'.$redeemopen.'</td>
            <td>'.$redeemclose.'</td>
            <td>'.$pending_redeem.'</td>
            <td>'.$cashout.'</td>
            <td>'.$bonus.'</td>
            <td>'.$shift.'</td>
            <td>'.$created_at.'</td>
          </tr>
          ';
         
        }
      }
             
		?>

		<!-- ========== Left Sidebar Start ========== -->
		<?php 
			include('../sidebar.php');
 			include('rightsidebar.php');

 		?>

		<div class="main-content">
			<div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Shift Reports</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                                        <li class="breadcrumb-item active">Reports</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center " >
                        <div class="col-md-8 col-lg-6 col-xl-12 ">
                            <!-- <div class="text-center mb-4 mt-4">
                             
                                <i class=" bx bx-user"></i> <h4>Agent Shuffling Lists</h4>
                              
                            </div> -->

                            <!-- <div class="card chat-conversation" data-simplebar="init">
                                <div class="card-body p-4"> -->
                                    <div class="p-3">
                                       <table class="table table-bordered" id="tbl-reports">
                                            <thead>
                                                <tr>
                                                  <th scope="col">#</th>
                                                 <!--  <th scope="col">Agent Name</th> -->
                                                  <th scope="col">Cashapp Opening</th>
                                                  <th scope="col">Cashapp Closing</th>
                                                  <th scope="col">Cashapp Difference</th>
                                                  <th scope="col">Games Opening</th>
                                                  <th scope="col">Games Closing</th>
                                                  <th scope="col">Games Difference</th>
                                                  <th scope="col">Redeem Opening</th>
                                                  <th scope="col">Redeem Closing</th>
                                                  <th scope="col">Pending Redeem</th>
                                                  <th scope="col">Cashout Total</th>
                                                  <th scope="col">Bonus Amount</th>
                                                  <th scope="col">Shift</th>
                                                  <!-- <th scope="col">User</th> -->
                                                  <th scope="col">Date</th>
                                                  <!-- <th scope="col">Updated At</th>
                                                  <th scope="col">Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php echo $html;?> 
                                            </tbody>
                                           
                                        </table>

                                    </div>
                               <!--  </div>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer.html');?>
		</div>

	</div>
  
	<div class="rightbar-overlay"></div>
  <?php include('footer_links.html');?>

</body>
</html>