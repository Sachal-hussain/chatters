
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Agent Shuffling Form | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
        <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php include('topheader.php');?>
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
                    $html.='<option value="'.$row['pagename'].'">'.$row['pagename'].'</option>';
                   // echo "<pre>";
                   //  print_r($row); 
                }
            }
            $user_list='';
            $query = mysqli_query($connect, "SELECT id,fullname FROM user WHERE type='CSR' AND status='Active' ORDER BY fullname ASC");
            if(mysqli_num_rows($query) > 0){
                while($row=mysqli_fetch_array($query)){
                    $id=$row['id'];
                    $fullname=$row['fullname'];
                    $user_list.='<option value="'.$row['fullname'].'">'.$row['fullname'].'</option>';
                   // echo "<pre>";
                   //  print_r($row); 
                }
            }
            
            
            // save data start here
            if(isset($_POST['created']))
            {
                // echo "<pre>";
                // print_r($_POST);
                $agent_name         =$_POST['agent_name'];
                $pg_name            =$_POST['pg_name'];
                $shift              =$_POST['shift'];
                $working_with       =$_POST['working_with'];
                $joining_date       =$_POST['joining_date'];
                $starting_date      =$_POST['starting_date'];
                $ending_date        =$_POST['ending_date'];
                $remarks            =$_POST['remarks'];
                $uname              =$_POST['uname'];
                $created_at         =date('Y-m-d H:i:s');

                $query = mysqli_query($connect, "INSERT INTO agent_shuffling (agent_name,pg_name,shift,working_with,joining_date,start_date,end_date,remarks,created_by,created_at) 
                    VALUES ('$agent_name','$pg_name','$shift','$working_with','$joining_date','$starting_date','$ending_date','$remarks','$uname','$created_at')") or die(mysqli_error($connect));
                $query = mysqli_query($connect, "INSERT INTO agent_shuffling_copy (agent_name,pg_name,shift,working_with,joining_date,start_date,end_date,remarks,created_by,created_at) 
                    VALUES ('$agent_name','$pg_name','$shift','$working_with','$joining_date','$starting_date','$ending_date','$remarks','$uname','$created_at')") or die(mysqli_error($connect));

                if ($query) {
                    echo '<script>
                    Swal.fire({
                        title: "Good job!",
                        text: "Added Successfully!",
                        icon: "success",
                    }).then(() => {
                        window.location.href = "agentshufflingdetails.php";
                    });</script>';
                    exit();
                    
                } else {
                    echo "Error: Unable to insert data.";
                }
                // echo "<pre>";
                // print_r($_POST);
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
                                <h4 class="mb-sm-0 font-size-18">Agent Shuffling Form</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                                        <li class="breadcrumb-item active">Agent Shuffling Form</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center" >
                        <div class="col-lg-6">
                            <div class="text-center mb-4 mt-4">
                              
                                <i class=" bx bx-user"></i> <h4>Agent Shuffling Form</h4>
                            </div>

                            <div class="card chat-conversation" data-simplebar="init">
                                <div class="card-body p-4">
                                    <div class="p-3">
                                        <form  method="post" action="#">
                                            <div class="mb-3">
                                                <label class="form-label" for="agent_name">Agent Name</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class=" bx bxs-user-circle"></i>
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
                                                       <i class=" bx bx-box"></i>
                                                    </span>
                                                   <select name="pg_name" id="pg_name" class="form-control">
                                                       <?php echo $html;?>
                                                   </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="shift">Shift</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class=" bx bx-stopwatch"></i>
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
                                                        <i class=" bx bx-calendar-plus"></i>
                                                    </span>
                                                    <input type="date" name="joining_date" id="joining_date" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Customer Name" aria-label="Enter Customer Name" aria-describedby="basic-addon3" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="starting_date">Starting Date</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                        <i class=" bx bx-calendar-plus"></i>
                                                    </span>
                                                    <input type="date" name="starting_date" id="starting_date" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Customer Name" aria-label="Enter Customer Name" aria-describedby="basic-addon3" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="ending_date">Ending Date</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class=" bx bx-calendar-plus"></i>
                                                    </span>
                                                    <input type="date" name="ending_date" id="ending_date" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Customer Name" aria-label="Enter Customer Name" aria-describedby="basic-addon3" required>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-4">
                                               <label for="pasteimages" class="form-label">Remarks </label>
                                                <textarea class="form-control" name="remarks" placeholder="Type Here..." style="resize: none;" id="remarks" required></textarea>
                                               
                                               
                                            </div>
                                           
                                            <input type="hidden" name="uid" value="<?php echo $uid;?>">
                                            <input type="hidden" name="type" value="<?php echo $type;?>">
                                            <input type="hidden" name="uname" value="<?php echo $uname;?>">

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary" name="created" id="">Create</button>
                                            </div>
                                        </form>

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

	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
</body>
</html>