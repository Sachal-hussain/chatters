
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Customer Approval | SHJ INTERNATIONAL</title>
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
            $query = mysqli_query($connect, "SELECT addcustomer.id AS cust_id,name,pgid,redeem_limit,addcustomer.status,addedby,created_at,pages.pagename 
            FROM addcustomer
            JOIN pages
            ON pages.id=addcustomer.pgid
            WHERE approval=1");
            if(mysqli_num_rows($query) > 0){
                while($row=mysqli_fetch_array($query)){
                  // echo "<pre>";
                  // print_r($row);
                  // exit;
                    $id               =$row['cust_id'];
                    $name             =$row['name'];
                    $redeem_limit     =$row['redeem_limit'];
                    $pagename         =$row['pagename'];
                    $addedby          =$row['addedby'];
                    $status           =$row['status'];
                    $created_at       =$row['created_at'];
                   


                    $html.='<tr>
                            <td>'.$id.'</td>
                            <td>'.$name.'</td>
                            <td>'.$pagename.'</td>
                            <td>'.$redeem_limit.'</td>
                            <td>'.$addedby.'</td>
                            <td>'.$created_at.'</td>
                            <td> <span class="badge rounded-pill bg-success">'.$status.'</span></td>

                            <td>
                              <i class="btn btn-primary cust_approval" data-id="'.$id.'" style="cursor:pointer;">Approve</i>
                              <i class="btn btn-danger del_cust_approval" data-id="'.$id.'" style="cursor:pointer;">Delete</i>
                            </td>
                    </tr>';
                    
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
                    <!-- <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Agent Shuffling Details</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                                        <li class="breadcrumb-item active">Agent Shuffling Details</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div> -->
                    <div class="row justify-content-center " >
                        <div class="col-md-8 col-lg-6 col-xl-12 ">
                            <!-- <div class="text-center mb-4 mt-4">
                             
                                <i class=" bx bx-user"></i> <h4>Agent Shuffling Lists</h4>
                              
                            </div> -->

                            <!-- <div class="card chat-conversation" data-simplebar="init">
                                <div class="card-body p-4"> -->
                                    <div class="alert alert-success" id="alert-approve" style="display:none;">
                               
                                    </div>
                                    <div class="table-responsive">
                                       <table class="table table-bordered" id="shuffling_tble">
                                            <thead>
                                                <tr>
                                                  <th scope="col">ID</th>
                                                  <th scope="col">Customer Name</th>
                                                  <th scope="col">Page Name</th>
                                                  <th scope="col">Redeem Limit</th>
                                                  <th scope="col">Agent Name</th>
                                                  <th scope="col">Created At</th>
                                                  <th scope="col">Status</th>
                                                  
                                                  <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php echo $html;?> 
                                            </tbody>
                                            
                                        </table>

                                    </div>
                              <!--   </div>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer.html');?>
		</div>

	</div>
    <div class="modal fade" id="usershuffling_modl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="#">
                    <div class="modal-header">
                        <h5 class="modal-title font-size-16" id="createticketLabel">Edit Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label" for="agent_name">Agent Name</label>
                            <div class="input-group mb-3 bg-light-subtle rounded-3">
                                <span class="input-group-text text-muted" id="basic-addon3">
                                   <i class="bx bxs-user-circle"></i>
                                </span>
                               <select name="agent_name" id="agent_name" class="form-control">
                                   <?php echo $user_list;?>
                               </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pg_name">Page Name</label>
                            <div class="input-group mb-3 bg-light-subtle rounded-3">
                                <span class="input-group-text text-muted" id="basic-addon3">
                                   <i class="bx bx-box"></i>
                                </span>
                               <select name="pg_name" id="pg_name" class="form-control">
                                   <?php echo $pages;?>
                               </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="shift">Shift</label>
                            <div class="input-group mb-3 bg-light-subtle rounded-3">
                                <span class="input-group-text text-muted" id="basic-addon3">
                                   <i class="bx bx-stopwatch"></i>
                                </span>
                               <select name="shift" id="shift" class="form-control">
                                  <option value="Morning">Morning</option>
                                  <option value="Evening">Evening</option>
                                  <option value="Night">Night</option>

                               </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="working_with">Working With</label>
                            <div class="input-group mb-3 bg-light-subtle rounded-3">
                                <span class="input-group-text text-muted" id="basic-addon3">
                                  <i class="bx bxs-user-detail"></i>
                                </span>
                               <select name="working_with" id="working_with" class="form-control">
                                   <?php echo $user_list;?>
                               </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="joining_date">Joining Date</label>
                            <div class="input-group mb-3 bg-light-subtle rounded-3">
                                <span class="input-group-text text-muted" id="basic-addon3">
                                    <i class="bx bx-calendar-plus"></i>
                                </span>
                                <input type="date" name="joining_date" id="joining_date" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Customer Name" aria-label="Enter Customer Name" aria-describedby="basic-addon3" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="starting_date">Starting Date</label>
                            <div class="input-group mb-3 bg-light-subtle rounded-3">
                                <span class="input-group-text text-muted" id="basic-addon3">
                                    <i class="bx bx-calendar-plus"></i>
                                </span>
                                <input type="date" name="starting_date" id="starting_date" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Customer Name" aria-label="Enter Customer Name" aria-describedby="basic-addon3" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="ending_date">Ending Date</label>
                            <div class="input-group mb-3 bg-light-subtle rounded-3">
                                <span class="input-group-text text-muted" id="basic-addon3">
                                   <i class="bx bx-calendar-plus"></i>
                                </span>
                                <input type="date" name="ending_date" id="ending_date" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Customer Name" aria-label="Enter Customer Name" aria-describedby="basic-addon3" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                           <label for="pasteimages" class="form-label">Remarks </label>
                            <textarea class="form-control" name="remarks" placeholder="Type Here..." style="resize: none;" id="remarks" required></textarea>  
                        </div>
                        <input type="hidden" name="uid" value="<?php echo $uid;?>">
                        <input type="hidden" name="type" value="<?php echo $type;?>">
                        <input type="hidden" name="uname" value="<?php echo $uname;?>">
                        <input type="hidden" name="id" id="id">

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="updated" id="">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
</body>
</html>