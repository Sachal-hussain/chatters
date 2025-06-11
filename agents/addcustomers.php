
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Customer Form | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
        <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php include('topheader.php');?>
		<?php

			require('../database/Pages.php');

			$object= new Pages();

			// $pages=$object->get_all_pages();
			$pages=$object->getPagesByIds($uid,$type);
		?>
        <?php
            require_once('../connect_me.php');
            $database_connection = new Database_connection();
            $connect = $database_connection->connect();

           if (isset($_POST['customerAdd'])) {
                $pgid = mysqli_real_escape_string($connect, $_POST['cpg_id']);
                $cust_name = trim($_POST['cust_name']);
                $cust_status = mysqli_real_escape_string($connect, $_POST['cust_status']);
                $uid = mysqli_real_escape_string($connect, $_POST['uid']);
                $uname = mysqli_real_escape_string($connect, $_POST['uname']);
                $created_at = date('Y-m-d H:i:s');
                $date = date('Y-m-d');
                $redeem_limit = 5000;
                $custapproval = 1;

                // Check if customer already exists
                $check_query = "SELECT * FROM addcustomer WHERE name = ? AND pgid = ?";
                $stmt_check = $connect->prepare($check_query);
                if ($stmt_check === false) {
                    die('Prepare failed: ' . htmlspecialchars($connect->error));
                }

                $stmt_check->bind_param('si', $cust_name, $pgid);
                $stmt_check->execute();
                $result = $stmt_check->get_result();

                if ($result->num_rows > 0) {
                    echo '<script>
                            Swal.fire({
                                title: "Warning",
                                text: "Customer with this name already exists.",
                                icon: "warning",
                            }).then(() => {
                                window.location.href = "addcustomers.php";
                              });</script>';
                } else {
                    // Prepare the SQL statement
                    $stmt = $connect->prepare("INSERT INTO addcustomer (`name`, `pgid`, `redeem_limit`, `status`, `approval`, `addedby`, `created_at`) 
                                               VALUES (?, ?, ?, ?, ?, ?, ?)");
                    if ($stmt === false) {
                        die('Prepare failed: ' . htmlspecialchars($connect->error));
                    }

                    // Bind parameters
                    $stmt->bind_param('sississ', $cust_name, $pgid, $redeem_limit, $cust_status, $custapproval, $uname, $created_at);

                    // Execute the statement
                    if ($stmt->execute()) {
                        echo '<script>
                                Swal.fire({
                                    title: "Good job!",
                                    text: "Customer added successfully! Please contact the manager for approval to be sent",
                                    icon: "success",
                                }).then(() => {
                                window.location.href = "addcustomers.php";
                              });</script>';
                        exit();
                    } else {
                        echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Unable to insert data.",
                                    icon: "error",
                                });
                              </script>';
                    }

                    // Close the statement
                    $stmt->close();
                }

                // Close the check statement
                $stmt_check->close();
            }
        ?>
		<!-- ========== Left Sidebar Start ========== -->
		<?php 
			include('../sidebar.php');
 			include('rightsidebar.php');
 			require("viewPendingRedeemImages.html");
 		?>

		<div class="main-content">
			<div class="page-content">
                <div class="container-fluid">
                    <div class="row ">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Customer Form</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Chat Support</a></li>
                                        <li class="breadcrumb-item active">Customer Form</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center" >
                        <h4 class="text-center">Add Customer</h4>
                        <?php foreach ($pages as $key => $page) {
                            $singleid=$page['id'];
                           
                            ?>
                        <div class="col-sm-4">   
                            <div class="card chat-conversation" data-simplebar="init">
                                <div class="card-body p-4">
                                    <div class="p-3">
                                        
                                        <form  method="post" action="#" id="customerDepositfrm">
                                            <div class="mb-3">
                                                <label class="form-label" for="cpg_id">Page Name</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class=" bx bx-box"></i>
                                                    </span>
                                                   <select name="cpg_id" id="cpg_id" class="form-control" required>
                                                        <option value="<?php echo $page['id'];?> "><?php echo $page['pagename'];?></option>
                                                        
                                                   </select>
                                                   <div id="pg_id_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="cust_name">Customer Name</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                        <i class=" bx bx-user"></i>
                                                    </span>
                                                    <input type="text" name="cust_name" id="cust_name" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Customer Name" aria-label="Enter Customer Game Id" aria-describedby="basic-addon3" required>
                                                </div>
                                            </div>
                                           

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary" name="customerAdd" id="customer_save">Save</button>
                                            </div>

                                            <input type="hidden" name="uid" value="<?php echo $uid;?>">
                                            <input type="hidden" name="type" value="<?php echo $type;?>">
                                            <input type="hidden" name="uname" value="<?php echo $uname;?>">
                                            <input type="hidden" name="cust_status" value="Deactive">
                                        </form>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                                
                        </div>
                        <?php }?>  
                        
                    </div>
                </div>
            </div>
            <?php include('footer.html');?>
		</div>

	</div>

	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
    <script>
        $(document).ready(function () {
            $('#customerDepositfrm').submit(function (event) { // Assuming the form's ID is depositForm
                var dpg_id = $('#dpg_id').val();
                
                if (dpg_id === "0") {
                    event.preventDefault(); // Prevent form submission
                    $('#pg_id_error').text("Please select a page.");
                } else {
                    $('#pg_id_error').text(""); // Clear any previous error messages
                }
            });
        });

    </script>
  
</body>
</html>