<?php 
	
	

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Deleted Redeem  | SHJ International</title>
	<?php require("links.html"); ?>
</head>
<body>
	<div class="layout-wrapper">
		<?php include('topheader.php');?>
    	<script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php 
			if ($type == 'CSR' || $type == 'Q&A' || $type == 'Manager') {
  
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
			$output='';
			$query = mysqli_query($connect, "SELECT * FROM redeem WHERE del='1' AND status='Pending' ");	
			if(mysqli_num_rows($query) > 0){
				while($row=mysqli_fetch_array($query)){
					$id=$row['id'];
					$record_by=$row['record_by'];
					$cust_name=$row['cust_name'];
					// $redeem_by=$row['redeem_by'];
					$page_name=$row['page_name'];
					$gid=$row['gid'];
					$ctid=$row['ctid'];
					$amount=$row['amount'];
					$record_time=$row['record_time'];

					$output.='<tr>
								<td>'.$record_time.'</td>
								<td>'.$id.'</td>
								<td>'.$record_by.'</td>
								<td>'.$cust_name.'</td>
								<td>'.$page_name.'</td>
								<td>'.$gid.'</td>
								<td>'.$ctid.'</td>
								<td>'.$amount.'</td>
								<td class="text-success">Deleted</td>
					</tr>';
					
				}
				
				// echo $output;
			}
		?>
		<?php 
			include('../sidebar.php');
	 		include('rightsidebar.php');
		?>
		<div class="main-content">

		    <div class="page-content">
		        <div class="container-fluid">

		            <!-- start page title -->
		            <div class="row">
		                <div class="col-12">
		                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
		                        <h4 class="mb-sm-0 font-size-18">Delete Items</h4>

		                        <div class="page-title-right">
		                            <ol class="breadcrumb m-0">
		                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
		                                <li class="breadcrumb-item active">Delete Items</li>
		                            </ol>
		                        </div>

		                    </div>
		                </div>
		            </div>
		            <!-- end page title -->

		            <!-- 1st row -->
		            <div class="row">
		                <div class="col-12">
		                  	<table class="table table-bordered" id="delete_redeems_list">
	                            <thead>
	                                <tr>
	                                  <th scope="col">Date</th>
	                                  <th scope="col">Redeem ID</th>
	                                  <th scope="col">Agent Name</th>
	                                  <th scope="col">Customer Name</th>
	                                  <th scope="col">Page Name</th>
	                                  <th scope="col">Game ID</th>
	                                  <th scope="col">Cash Tag</th> 
	                                  <th scope="col">Amount</th>
	                                  <th scope="col">Status</th>

	                                </tr>
	                            </thead>
	                            <tbody>
	                            	<?php echo $output;?>
	                            </tbody>
	                        </table>

		                </div>	
		            </div><!-- end row-->

		        
		        </div>

		    </div>


			<?php require("footer.html"); ?>
		</div>
	</div>
	<?php require('rightsidebar.php');?>
	<div class="rightbar-overlay"></div>
	
	<?php require("footer_links.html"); ?>
	<script>
	    $(document).ready(function () {
		    var table = $('#delete_redeems_list').DataTable({
		        "order": [[0, 'desc']],
		    });
		});
	</script>
</body>
</html>