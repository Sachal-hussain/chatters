
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Add User | SHJ International</title>
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

				// add user start here
				if (isset($_POST['btn_save']) && $_POST['agentid']!="" && $_POST['username']!="" && $_POST['password']) {
				    $agentid  	= $_POST['agentid'];
				    $fullname 	= $_POST['fullname'];
				    $username 	= $_POST['username'];
				    $password 	= $_POST['password'];
				    $type 		= $_POST['type'];
				    $department = $_POST['department'];
				    $page 		= 0;
				    $email 		= $_POST['email'];
				    $contact 	= $_POST['contact'];
				    $avatar 	= 'noimage.png';
				    $status 	= $_POST['status'];
				    $shift 		= $_POST['shift'];

				    $dt = date('Y-m-d');
				    $dtt = date('Y-m-d H:i:s');
				    
				    $check_query = "SELECT COUNT(*) AS count FROM user WHERE agentid = '$agentid'";
					$check_result = mysqli_query($connect, $check_query);
				    if ($check_result) {
					    $row = mysqli_fetch_assoc($check_result);
					    $count = $row['count'];
					   
					    if ($count > 0) {
					        // Agent ID already exists, show alert
					        echo '<script>alert("Agent ID already exists.");</script>';
					    } else {
					        // Agent ID does not exist, proceed with insertion
					        $ins_log = mysqli_query($connect, "INSERT INTO user (agentid, pgid, fullname, uname, upass, type, department, email, contact, status, avtar, shift) VALUES ('$agentid', '$page', '$fullname', '$username', '$password', '$type', '$department', '$email', '$contact', '$status', '$avatar', '$shift')");
					        
					        if ($ins_log) {
					            // Insertion successful
					            $ins_activitylog = mysqli_query($connect, "INSERT INTO user_action_log (uid, date, action, page, details, record_time, record_by) VALUES ('$uid', '$dt', 'Create User', 'createuser.php', 'created new user $fullname on createuser.php by userid: $uid', '$dtt', '$uname')");
					            
					            if ($ins_activitylog) {
					                // Activity log insertion successful
					                echo '
					                	<script>
					                    Swal.fire({
					                        title: "Good job!",
					                        text: "Saved Successfully!",
					                        icon: "success",
					                    }).then(() => {
					                        window.location.href = "addusers.php";
					                    });</script>';
					                exit();  
					            } else {
					                // Activity log insertion failed
					                echo '<script>alert("Error saving activity log.");</script>';
					            }
					        } else {
					            // Insertion failed
					            echo '<script>alert("Error saving user.");</script>';
					        }
					    }
					} else {
					    // Error in query
					    echo '<script>alert("Error checking agent ID.");</script>';
					}

				   

				}
				// end here
				// get all users start here
				$tbl_data="";
				$chk = mysqli_query($connect, "SELECT * FROM user WHERE status='Active' ORDER BY id DESC");	
				while($row=mysqli_fetch_array($chk)){
				    $uid = $row['id'];
				    $agentid = $row['agentid'];
				    $fullname = $row['fullname'];
				    $uname = $row['uname'];
				    $utype = $row['type'];
				    $ucontact = $row['shift'];
				    $ustatus = $row['status'];
				    $department = $row['department'];


				    $tbl_data.='<tr>
				                <td>'.$agentid.'</td>
				                <td>'.$fullname.'</td>
				                <td>'.$uname.'</td>
				                <td>'.$department.'</td>
				                <td>'.$utype.'</td>
				                <td>'.$ucontact.'</td>
				                <td>'.$ustatus.'</td>
				                <td><button class="btn btn-success userupdate-btn" data-id="'.$uid.'">Update</button></td>
				               
				            </tr>';

				}
			?>
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
	                                <h4 class="mb-sm-0 font-size-18">User</h4>

	                                <div class="page-title-right">
	                                    <ol class="breadcrumb m-0">
	                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
	                                        <li class="breadcrumb-item active">User</li>
	                                    </ol>
	                                </div>

	                            </div>
	                        </div>
	                    </div>
	                   

	                    <div class="d-lg-flex">
	                        <div class="chat-leftsidebar card">
	                            <div class="p-3 px-4 border-bottom">
	                                <div class="d-flex align-items-start ">
	                                    <div class="flex-grow-1">
	                                        <h5 class="font-size-16 mb-1">Add User Form</h5>
	                                        
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="chat-leftsidebar-nav">
	                               
	                                <div class="tab-content">
	                                   
	                                    <div class="chat-message-list" data-simplebar="init">
	                                        <div class="row text-center">
	                                        	<div class="col-lg-12">
	                                                <div class="mt-4 mt-lg-0">
	                                                    <form name="frmagent" method="post" action="#">
	                                                        <div class="row mb-4">
	                                                            <label for="agentid" class="col-sm-3 col-form-label">Agent ID</label>
	                                                            <div class="col-sm-9">
	                                                              <input type="text" class="form-control"  name="agentid" id="agentid" placeholder="Agent ID" required>
	                                                            </div>
	                                                        </div>
	                                                        <div class="row mb-4">
	                                                            <label for="fullname" class="col-sm-3 col-form-label">Full Name</label>
	                                                            <div class="col-sm-9">
	                                                                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" required>
	                                                            </div>
	                                                        </div>
	                                                        <div class="row mb-4">
	                                                            <label for="username" class="col-sm-3 col-form-label">User Name</label>
	                                                            <div class="col-sm-9">
	                                                              <input type="text" class="form-control" name="username" id="username" placeholder="User Name" required>
	                                                            </div>
	                                                        </div>
	                                                        <div class="row mb-4">
	                                                            <label for="password" class="col-sm-3 col-form-label">Password</label>
	                                                            <div class="col-sm-9">
	                                                              <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
	                                                            </div>
	                                                        </div>
	                                                        <div class="row mb-4">
	                                                            <label for="type" class="col-sm-3 col-form-label">Type</label>
	                                                            <div class="col-sm-9">
	                                                              	<select name="type" class="form-control form-control-sm">
													                    <option value="Manager">Manager</option>
													                    <option value="IT">IT</option>
													                    <option value="HR">HR</option>
													                    <option value="Redeem">Redeem</option>                    
													                    <option value="CSR">CSR</option>
													                    <option value="Q&A">Q&A</option>
													                    <option value="Verification">Verification</option>
													                </select>
	                                                            </div>
	                                                        </div>
	                                                        <div class="row mb-4">
	                                                            <label for="department" class="col-sm-3 col-form-label">Department</label>
	                                                            <div class="col-sm-9">
	                                                              	<select name="department" class="form-control form-control-sm">
													                    <!-- <option value="Management">Management</option> -->
													                    <option value="Live Chat">Live Chat</option>
													                    <option value="Redeem">Redeem</option>
													                    <option value="HR">HR</option>
													                    <option value="IT">IT</option>
													                    <option value="Verification">Verification</option>
													                </select>
	                                                            </div>
	                                                        </div>
	                                                        <div class="row mb-4">
	                                                            <label for="shift" class="col-sm-3 col-form-label">Shift</label>
	                                                            <div class="col-sm-9">
	                                                              	<select name="shift" class="form-control form-control-sm">
													                    <option value="Morning">Morning</option>
													                    <option value="Evening">Evening</option>
													                    <option value="Night">Night</option>
													                </select>
	                                                            </div>
	                                                        </div>
	                                                        <div class="row mb-4">
	                                                            <label for="email" class="col-sm-3 col-form-label">Email</label>
	                                                            <div class="col-sm-9">
	                                                              <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
	                                                            </div>
	                                                        </div>
	                                                        <div class="row mb-4">
	                                                            <label for="contact" class="col-sm-3 col-form-label">Contact</label>
	                                                            <div class="col-sm-9">
	                                                              <input type="text" class="form-control" name="contact" id="contact" placeholder="Contact" required>
	                                                            </div>
	                                                        </div>
	                                                        <div class="row mb-4">
	                                                            <label for="status" class="col-sm-3 col-form-label">Status</label>
	                                                            <div class="col-sm-9">
	                                                              	<select name="status" class="form-control form-control-sm">
													                    <option value="Active">Active</option>
													                    
													                </select>
	                                                            </div>
	                                                        </div>
	            		
	                                                        <div class="row mb-5 justify-content-end">
	                                                            <div class="col-sm-9">
	                                                                <div>
	                                                                    <button type="submit" name="btn_save" class="btn btn-primary w-md">Submit</button>
	                                                                </div>
	                                                            </div>
	                                                        </div>
	                                                    </form>
	                                                </div>
	                                            </div>
	                                            
	                                        </div>
	                                    
	                                    </div>
	                                  
	                                </div>
	                            </div>

	                        </div>
	                        <!-- end chat-leftsidebar -->

	                        <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1">
	                            <div class="card">
	                                <div class="p-3 px-lg-4 border-bottom">
	                                    <div class="row">
	                                        <div class="col-xl-4 col-7">
	                                            <div class="d-flex align-items-center">
	                                                
	                                                <div class="flex-grow-1">
	                                                    <h5>Users List</h5>
	                                                    
	                                                </div>
	                                            </div>
	                                        </div>
	                                       
	                                    </div>
	                                </div>

	                                <div class="chat-conversation p-3 px-2" data-simplebar="init">
	                                	<div class="row">
						                    <div class="col-sm-12">
						                         <div class="table-responsive">
						                            <table id="userlist" class="table table-bordered">
						                                <thead>
						                                    <tr>
						                                        <th class="border-top-0">AgentID</th>
						                                        <th class="border-top-0">Name</th>
						                                        <th class="border-top-0">UserName</th>
						                                        <th class="border-top-0">Department</th>
						                                        <th class="border-top-0">Type</th>
						                                        <th class="border-top-0">Shift</th>
						                                        <th class="border-top-0">Status</th>
						                                        <th class="border-top-0">Action</th>
						                                        
						                                    </tr>
						                                </thead>
						                                <tbody>
						                                    <?php
						                                        echo $tbl_data;
						                                    ?>
						                                </tbody>
						                            </table>
						                        </div>
						                    </div>
						                </div>
	                               	</div>
	                            </div>
	                        </div>
	                        <!-- end user chat -->
	                    </div>
	                   
	                    
	                </div>
			    </div>

			    <?php require("footer.html"); ?>

			</div>

		</div>
		<div class="modal fade modal-lg" id="updateuser_modl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
	      	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
	          	<div class="modal-content">
	              <div class="modal-header">
	                <h5 class="modal-title font-size-16" id="createticketLabel">Update Details</h5>
	                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	                </button>
	              </div>
	              <div class="modal-body p-4">
	              	<form method="post" action="#">
		                <div class="mb-3">
		                  <label class="form-label" for="updatedepartment">Department</label>
		                  	<select name="updatedepartment" class="form-control form-control-sm">
			                    <!-- <option value="Management">Management</option> -->
			                    <option value="Live Chat">Live Chat</option>
			                    <option value="Redeem">Redeem</option>
			                    <option value="HR">HR</option>
			                    <option value="IT">IT</option>
			                    <option value="Verification">Verification</option>
			                </select>
		                </div>
		                <div class="mb-3">
		                  <label class="form-label" for="updatetype">Type</label>
		                  	<select name="type" class="form-control form-control-sm">
			                    <option value="Manager">Manager</option>
			                    <option value="IT">IT</option>
			                    <option value="HR">HR</option>
			                    <option value="Redeem">Redeem</option>                    
			                    <option value="CSR">CSR</option>
			                    <option value="Q&A">Q&A</option>
			                    <option value="Verification">Verification</option>
			                </select>
		                  
		                </div>
		                <input type="hidden" name="uid" value="<?php echo $uid;?>">
		                <input type="hidden" name="type" value="<?php echo $type;?>">
		                <input type="hidden" name="uname" value="<?php echo $uname;?>">
		                <input type="hidden" name="userid" id="userid">

		                <div class="modal-footer">
		                  <button type="submit" class="btn btn-primary" name="save" id="updateuser">Update</button>
		                </div>
	              	</form>
	              </div>
	          </div>
	      	</div>
	  	</div>
		<div class="rightbar-overlay"></div>
	
		<?php require("footer_links.html"); ?>
		
	</body>
	
	<script>
	    $(document).ready(function () {
		    var table = $('#userlist').DataTable({
		        "order": [[0, 'desc']],
		    });

		    $(document).on('click','.userupdate-btn', function(){
		    	// alert();

		    	$('#updateuser_modl').modal('show');
		    })
		});
	</script>
</html>