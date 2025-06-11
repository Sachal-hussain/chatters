
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Agent Shuffling Details | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
		<?php include('topheader.php');?>
        <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php 
            if ($type == 'CSR' || $type == 'Q&A') {
      
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
            $query = mysqli_query($connect, "SELECT id,agent_name,pg_name,shift,working_with,joining_date,start_date,end_date,remarks,created_by,created_at,updated_at FROM agent_shuffling");
            if(mysqli_num_rows($query) > 0){
                while($row=mysqli_fetch_array($query)){
                    $id             =$row['id'];
                    $agent_name     =$row['agent_name'];
                    $pg_name        =$row['pg_name'];
                    $shift          =$row['shift'];
                    $working_with   =$row['working_with'];
                    $joining_date   =$row['joining_date'];
                    $start_date     =$row['start_date'];
                    $end_date       =$row['end_date'];
                    $remarks        =$row['remarks'];
                    $created_by     =$row['created_by'];
                    $created_at     =$row['created_at'];
                    $updated_at     =$row['updated_at'];



                    $html.='<tr>
                            <td>'.$id.'</td>
                            <td>'.$agent_name.'</td>
                            <td>'.$pg_name.'</td>
                            <td>'.$shift.'</td>
                            <td>'.$working_with.'</td>
                            <td>'.$joining_date.'</td>
                            <td>'.$start_date.'</td>
                            <td>'.$end_date.'</td>
                            <td>'.$remarks.'</td>
                            <td>'.$created_by.'</td>
                            <td>'.$created_at.'</td>
                            <td>'.$updated_at.'</td>


                            <td>
                                <i class="bx bx-edit edit_shufflinglist" data-id="'.$id.'" data-agent_name="'.$agent_name.'" data-pg_name="'.$pg_name.'" data-shift="'.$shift.'" data-working_with="'.$working_with.'" data-joining_date="'.$joining_date.'" data-start_date="'.$start_date.'" data-end_date="'.$end_date.'" data-remarks="'.$remarks.'" style="cursor:pointer;"></i>
                            </td>
                    </tr>';
                    
                }
            }
            
           $pages='';
            $query = mysqli_query($connect, "SELECT 
                    pages.*, 
                    COUNT(redeem.id) AS pending_redeem_count
                    FROM 
                        pages
                    LEFT JOIN 
                        redeem ON pages.id = redeem.pg_id AND redeem.status = 'Pending' AND del='0'
                    WHERE 
                        pages.status = 'active'
                    GROUP BY 
                        pages.id, pages.pagename
                    ORDER BY 
                        pages.pagename ASC");
            if(mysqli_num_rows($query) > 0){
                while($row=mysqli_fetch_array($query)){
                    $id=$row['id'];
                    $pagename=$row['pagename'];
                    $pages.='<option value="'.$row['pagename'].'">'.$row['pagename'].'</option>';
                 
                }
            }
            $user_list='';
            $query = mysqli_query($connect, "SELECT id,fullname FROM user WHERE type='CSR' AND status='Active' ORDER BY fullname ASC");
            if(mysqli_num_rows($query) > 0){
                while($row=mysqli_fetch_array($query)){
                    $id=$row['id'];
                    $fullname=$row['fullname'];
                    $user_list.='<option value="'.$row['fullname'].'">'.$row['fullname'].'</option>';
                 
                }
            }
            
            
            // save data start here
            if(isset($_POST['updated']))
            {
                $id                 =$_POST['id'];
                $agent_name         =$_POST['agent_name'];
                $pg_name            =$_POST['pg_name'];
                $shift              =$_POST['shift'];
                $working_with       =$_POST['working_with'];
                $joining_date       =$_POST['joining_date'];
                $starting_date      =$_POST['starting_date'];
                $ending_date        =$_POST['ending_date'];
                $remarks            =$_POST['remarks'];
                $uname              =$_POST['uname'];
                $updated_at         =date('Y-m-d H:i:s');

                $query = mysqli_query($connect, "UPDATE agent_shuffling SET agent_name='$agent_name',pg_name='$pg_name',shift='$shift',working_with='$working_with',joining_date='$joining_date',start_date='$starting_date',end_date='$ending_date',remarks='$remarks',created_by='$uname',updated_at='$updated_at' WHERE id='$id'") or die(mysqli_error($connect));

                $query = mysqli_query($connect, "INSERT INTO agent_shuffling_copy (agent_name,pg_name,shift,working_with,joining_date,start_date,end_date,remarks,created_by,updated_at) 
                    VALUES ('$agent_name','$pg_name','$shift','$working_with','$joining_date','$starting_date','$ending_date','$remarks','$uname','$updated_at')") or die(mysqli_error($connect));
                if ($query) {
                    echo '<script>
                    Swal.fire({
                        title: "Good job!",
                        text: "Record Updated!",
                        icon: "success",   
                    }).then(() => {
                        window.location.href = "agentshufflingdetails.php";
                      });</script>';
                      exit();
                    
                } else {
                    echo "Error: Unable to insert data.";
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
                                <h4 class="mb-sm-0 font-size-18">Agent Shuffling Details</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                                        <li class="breadcrumb-item active">Agent Shuffling Details</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center " >
                        <div class="col-md-8 col-lg-6 col-xl-12 ">
                            <div class="text-center mb-4 mt-4">
                             
                                <i class=" bx bx-user"></i> <h4>Agent Shuffling Lists</h4>
                              
                            </div>

                            <div class="card chat-conversation" data-simplebar="init">
                                <div class="card-body p-4">
                                    <div class="p-3">
                                       <table class="table table-bordered" id="shuffling_tble">
                                            <thead>
                                                <tr>
                                                  <th scope="col">ID</th>
                                                  <th scope="col">Agent Name</th>
                                                  <th scope="col">Page Name</th>
                                                  <th scope="col">Shift</th>
                                                  <th scope="col">Working With</th>
                                                  <th scope="col">Joining Date</th>
                                                  <th scope="col">Starting Date</th>
                                                  <th scope="col">Ending Date</th>
                                                  <th scope="col">Remarks</th>
                                                  <th scope="col">Added By</th>
                                                  <th scope="col">Created At</th>
                                                  <th scope="col">Updated At</th>
                                                  <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php echo $html;?> 
                                            </tbody>
                                           
                                        </table>

                                    </div>
                                </div>
                            </div>

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