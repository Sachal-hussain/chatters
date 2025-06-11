
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>User Details | SHJ INTERNATIONAL</title>
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

            $query = mysqli_query($connect, "
                SELECT u.id, u.agentid, u.fullname, u.uname, u.shift, u.department, u.status, u.pgid, u.type, p.id as page_id, p.pagename, emp_schedule.offday
                FROM user u
                LEFT JOIN pages p ON p.id = u.pgid 
                LEFT JOIN emp_schedule ON emp_schedule.uid = u.id
                WHERE u.status = 'Active'
                " . (($type == 'Webmaster') ? "" : "AND u.type IN ('CSR', 'Redeem','Manager')")
            );

            if (!$query) {
                die('Error in SQL query: ' . mysqli_error($connect));
            }

            $agentsByShift = [
                'Morning' => [],
                'Evening' => [],
                'Night' => []
            ];

            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_array($query)) {
                    $pagenameQuery = mysqli_query($connect, "SELECT pagename FROM pages WHERE id IN (" . (empty($row['pgid']) ? 'NULL' : $row['pgid']) . ")");

                    if (!$pagenameQuery) {
                        die('Error in SQL query for pagename: ' . mysqli_error($connect));
                    }

                    $pagenameArray = [];
                    while ($pagenameRow = mysqli_fetch_array($pagenameQuery)) {
                        $pagenameArray[] = $pagenameRow['pagename'];
                    }

                    $pagename = implode(', ', $pagenameArray);
                    $row['pagename'] = $pagename;

                    $offdays = explode(',', $row['offday']); // Split the offday string by commas
                    $formattedOffdays = [];

                    foreach ($offdays as $entry) {
                        $entry = rtrim($entry, ')'); // Remove trailing ')' if it exists
                        $parts = explode(' (', $entry); // Split by ' (' to get day and date

                        if (count($parts) === 2) {
                            // If we have both day and date
                            list($day, $date) = $parts;
                            $dateFormatted = date('d-m-Y', strtotime($date));
                            $formattedOffdays[] = "$day ($dateFormatted)";
                        } else {
                            // If the format is unexpected, just add the original entry
                            $formattedOffdays[] = $entry;
                        }
                    }

                    $row['offday'] = implode(', ', $formattedOffdays);

                    switch ($row['shift']) {
                        case 'Morning':
                            $agentsByShift['Morning'][] = $row;
                            break;
                        case 'Evening':
                            $agentsByShift['Evening'][] = $row;
                            break;
                        case 'Night':
                            $agentsByShift['Night'][] = $row;
                            break;
                    }
                }
            } else {
                echo "No records found.";
            }

            function generateShiftTable($agents, $shiftName, $tableId) {
                $html='';
                $html .= "<table class='table table-bordered' id='$tableId'>";
                $html .= '<thead>
                            <tr>
                              <th scope="col">Agent ID</th>
                              <th scope="col">Full Name</th>
                              <th scope="col">User Name</th>
                              <th scope="col">Shift</th>
                              <th scope="col">Department</th>
                              <th scope="col">Designation</th>
                              <th scope="col">Assigned Page</th>
                              <th scope="col">Off Day</th>
                              <th scope="col">Status</th>
                              <th scope="col">Update Off Day</th>
                              <th scope="col">Action</th>
                              <th scope="col">Issues Action</th>
                            </tr>
                          </thead>
                          <tbody>';
                
                foreach ($agents as $row) {

                    $html .= '<tr>
                                <th scope="row">' . $row['agentid'] . '</th>
                                <td>' . $row['fullname'] . '</td>
                                <td>' . $row['uname'] . '</td>
                                <td>' . $row['shift'] . '</td>
                                <td>' . $row['department'] . '</td>
                                <td>' . $row['type'] . '</td>
                                <td>' . $row['pagename'] . '</td>
                                <td>' . $row['offday'] . '</td>
                                <td><span class="badge rounded-pill bg-success">' . $row['status'] . '</span></td>
                                <td>
                                  <i class="btn btn-primary btn-sm offday_status" data-id="' . $row['id'] . '" data-pg_id="' . $row['page_id'] . '" data-status="' . $row['status'] . '" data-shift="' . $row['shift'] . '" style="cursor:pointer;">Off Day</i>
                                </td>
                                <td>
                                  <i class="btn btn-danger btn-sm edit_user_status" data-id="' . $row['id'] . '" data-pg_id="' . $row['page_id'] . '" data-status="' . $row['status'] . '" data-shift="' . $row['shift'] . '" style="cursor:pointer;">Update</i>
                                </td>
                                <td>
                                  <i class="bx bxs-add-to-queue issuesaction" data-id="' . $row['id'] . '" data-fullname="' . $row['fullname'] . '" data-pgname="' . $row['pagename'] . '" data-status="' . $row['status'] . '" data-shift="' . $row['shift'] . '" style="cursor:pointer;"></i>
                                </td>
                              </tr>';
                }

                $html .= '</tbody></table>';
                return $html;
            }

            $morningTable = generateShiftTable($agentsByShift['Morning'], 'Morning', 'morning_tbl');
            $eveningTable = generateShiftTable($agentsByShift['Evening'], 'Evening', 'evening_tbl');
            $nightTable = generateShiftTable($agentsByShift['Night'], 'Night', 'night_tbl');

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
                    $pages.='<option value="'.$row['id'].'">'.$row['pagename'].'</option>';
                  
                }
            }
            
		?>
        <?php
            if(isset($_POST['updateData'])){
                // echo "<pre>";
                // print_r($_POST);
                // // print_r($pg_id);
                // exit;
                $userid=$_POST['user_id'];
                $shift=$_POST['shift'];
                // $pgid=$_POST['pgid'];
                $pgid = isset($_POST['pgid']) ? $_POST['pgid'] : array();
                $status=$_POST['status'];
                 // Remove "selectAll" from the array if present
                $pgid = array_filter($pgid, function ($value) {
                    return $value !== 'selectAll';
                });

                $pg_id=implode(",",$pgid);
                // $object->setUserId($userid);
                // $object->setShift($shift);
                // $object->updateUserData();
                $query = mysqli_query($connect, "UPDATE user SET status='$status', shift='$shift', pgid='$pg_id' WHERE id='$userid'") or die(mysqli_error($connect));

                if ($query) {
                    echo '
                        <script>
                        Swal.fire({
                            title: "Good job!",
                            text: "Updated Successfully!",
                            icon: "success",
                        }).then(() => {
                            window.location.href = "' . $_SERVER['PHP_SELF'] . '";
                        });</script>'; 
                    exit;
                } else {
                    echo "Error: Unable to insert data.";
                }
                // echo '<script>alert("Record Updated Successfully!");window.location.replace("allusers_list.php");</script>';
            }

        ?>
        <?php 
            // get issues list 
            $html_issues='';

            $query = mysqli_query($connect,"
                SELECT id, agentname, pagename, shift, issues, resolved, created_by, created_at, updated_at 
                FROM issues") or die(mysqli_error($connect));
            if(mysqli_num_rows($query) > 0){
                while($row=mysqli_fetch_array($query)){
                    $createdTimestamp = strtotime($row['created_at']);
                    $updatedTimestamp = strtotime($row['updated_at']);

                    if($updatedTimestamp){
                        $diffInSeconds = $updatedTimestamp - $createdTimestamp;

                        // Convert seconds to days, hours, and minutes
                        $days = floor($diffInSeconds / (60 * 60 * 24));
                        $hours = floor(($diffInSeconds % (60 * 60 * 24)) / (60 * 60));
                        $minutes = floor(($diffInSeconds % (60 * 60)) / 60);
                        $seconds = $diffInSeconds % 60;

                        $difference= $days . 'D ' . $hours . 'H ' . $minutes . 'M ' . $seconds . 'S';
                    }
                    else{
                        $difference='0D 0H 0M 0S';
                    }

                    if ($row['resolved'] == 'Yes') {
                        $action = '<button type="button" class="btn btn-success " disabled>Updated</button>';
                        $class='bg-success text-center text-white'; 
                    } 
                    else {
                       $class='bg-danger-subtle  text-center';
                        if ($type == 'Manager' || $type == 'Webmaster') {
                            $action = '<form class="update-form" method="post" action="#" id="updateissuefrm"><button type="submit" class="btn btn-primary  edit_issues" name="updateissuesbtn" data-id="' . $row['id'] . '">Update</button></form>';
                        } 
                        else {
                            $action = ''; 
                            
                        }
                    }
                    $html_issues.='<tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['agentname'].'</td>
                        <td>'.$row['pagename'].'</td>
                        <td>'.$row['shift'].'</td>
                        <td>'.$row['issues'].'</td>
                        <td class="'.$class.'">'.$row['resolved'].'</td>
                        <td>'.$row['created_by'].'</td>
                        <td>'.$row['created_at'].'</td>
                        <td>'.$row['updated_at'].'</td>
                        <td>'.$difference.'</td>
                        <td>'.$action.'</td> 
                       
                        </tr>'
                    ;
                }
            }

            if(isset($_POST['updateissuesbtn'])){
                $id         =$_POST['id'];
                $resolved   ='Yes';
                $updated_at = date('Y-m-d H:i:s');
                $query = mysqli_query($connect, "UPDATE issues SET resolved='$resolved', updated_at='$updated_at' 
                    WHERE id='$id'") or die(mysqli_error($connect));

                if ($query) {
                    echo '<script>alert("Updated Successfully!");window.location.href = "' . $_SERVER['PHP_SELF'] . '";</script>';
                    // header("Location: {$_SERVER['PHP_SELF']}");
                    exit;
                } else {
                    echo "Error: Unable to insert data.";
                }

            }
            if (isset($_POST['addData'])) {
                $agent_name = $_POST['agent_name'];
                $pagename = $_POST['pagename'];
                $agentshift = $_POST['agentshift'];

                // Check if 'issues' is empty
                if (empty($_POST['issues'])) {
                    echo '<script>alert("Please select at least one issue.");window.location.href = "' . $_SERVER['PHP_SELF'] . '";</script>';
                    exit;
                }

                $issues = implode(',', $_POST['issues']);
                $created_at = date('Y-m-d H:i:s');

                // Assuming $connect is your database connection
                $stmt = $connect->prepare("INSERT INTO issues (agentname, pagename, shift, issues, created_by, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?)")
                ;
                
                $stmt->bind_param("ssssss", $agent_name, $pagename, $agentshift, $issues, $uname, $created_at);

                if ($stmt->execute()) {
                    echo '<script>alert("Added Successfully!");window.location.href = "' . $_SERVER['PHP_SELF'] . '";</script>';
                    exit;
                } else {
                    echo "Error: Unable to insert data.";
                }

                $stmt->close();
            }

            // update offday start here
           if (isset($_POST['updateOffday'])) {
                $uid = $_POST['userid'];
               
                // Check if 'offday' is empty
                if (empty($_POST['offday'])) {
                    echo '<script>alert("Please select at least one off day.");window.location.href = "' . $_SERVER['PHP_SELF'] . '";</script>';
                    exit;
                }

                $off_day_array = $_POST['offday'];
                $off_day_with_dates = [];

                foreach ($off_day_array as $day) {
                    $next_day_date = date('Y-m-d', strtotime("next $day"));
                    $off_day_with_dates[] = "$day ($next_day_date)";
                }

                $off_day = implode(', ', $off_day_with_dates);
                $created_at = date('Y-m-d H:i:s');
                // Assuming $connect is your database connection
                $stmt = $connect->prepare("SELECT uid FROM emp_schedule WHERE uid = ?");
                $stmt->bind_param("i", $uid);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    // Record exists, update it
                    $stmt->close();
                    $stmt = $connect->prepare("UPDATE emp_schedule SET offday = ?, created_at = ? WHERE uid = ?");
                    $stmt->bind_param("ssi", $off_day, $created_at, $uid);
                    
                    if ($stmt->execute()) {
                         echo '
                        <script>
                        Swal.fire({
                            title: "Good job!",
                            text: "Updated Successfully!",
                            icon: "success",
                        }).then(() => {
                            window.location.href = "' . $_SERVER['PHP_SELF'] . '";
                        });</script>';
                        exit;
                    } else {
                        echo "Error: Unable to update data.";
                    }
                } else {
                    // Record doesn't exist, insert it
                    $stmt->close();
                    $stmt = $connect->prepare("INSERT INTO emp_schedule (uid, offday, created_at) VALUES (?, ?, ?)");
                    $stmt->bind_param("iss", $uid, $off_day, $created_at);
                    
                    if ($stmt->execute()) {
                        echo '
                        <script>
                        Swal.fire({
                            title: "Good job!",
                            text: "Added Successfully!",
                            icon: "success",
                        }).then(() => {
                            window.location.href = "' . $_SERVER['PHP_SELF'] . '";
                        });</script>';
                        exit;
                    } else {
                        echo "Error: Unable to insert data.";
                    }
                }

                $stmt->close();
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
                                <h4 class="mb-sm-0 font-size-18">User Details</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                                        <li class="breadcrumb-item active">User Details</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center " >
                        <div class="col-md-8 col-lg-6 col-xl-12 ">
                            <!-- <div class="text-center mb-4 mt-4">
                             
                                <i class="bx bxs-user-circle"></i> <h4>All User </h4>
                              
                            </div> -->
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                               

                                <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#morning_shift" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Morning Shift</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#evening_shift" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Evening Shift</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#night_shift" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Night Shift</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                <button class="nav-link " id="pills-issueslist-tab" data-bs-toggle="pill" data-bs-target="#issueslist" type="button" role="tab" aria-controls="issueslist" aria-selected="false">Issues List</button>
                                </li>     
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="morning_shift" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <?php echo $morningTable; ?>
                                    
                                </div>
                                <div class="tab-pane fade  " id="evening_shift" role="tabpanel" aria-labelledby="pills-home-tab">
                                   
                                    <?php echo $eveningTable; ?>
                                    
                                </div>
                                <div class="tab-pane fade  " id="night_shift" role="tabpanel" aria-labelledby="pills-home-tab">
                                   
                                    <?php echo $nightTable; ?>
                                </div>
                                 <div class="tab-pane fade " id="issueslist" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <div class="card chat-conversation" data-simplebar="init">
                                        <div class="card-body p-4">
                                            <div class="p-3">
                                               <table class="table table-bordered" id="issues_list">
                                                  <thead>
                                                        <tr>
                                                          <th scope="col">ID</th>
                                                          <th scope="col">Agent Name</th>
                                                          <th scope="col">Page Name</th>
                                                          <th scope="col">Shift</th>
                                                          <th scope="col">Issues</th>
                                                          <th scope="col">Resolved</th>                                            
                                                          <th scope="col">Added By</th>
                                                          <th scope="col">Created At</th>
                                                          <th scope="col">Updated At</th>
                                                          <th scope="col">Total Time</th>
                                                          <th scope="col">Action</th>

                                                        </tr>
                                                  </thead>
                                                      <tbody>
                                                        <?php echo $html_issues;?>
                                                      </tbody>
                                                </table>

                                            </div>
                                        </div>
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
    <!-- paid redeem modal -->
    <div class="modal fade" id="updateuserstatusmodal" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post"  id="" action="#">
                    <div class="modal-header">
                        <h5 class="modal-title font-size-16" id="createticketLabel">Update User Record</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <label for="shift" class="form-label">Shift</label>
                        <select class="form-control" name="shift" id="shift">
                            <option value="Morning">Morning</option>
                            <option value="Evening">Evening</option>
                            <option value="Night">Night</option>
                        </select>
                    </div>
                    <div class="modal-body p-4" style="overflow-y: unset !important;">
                        <label for="pgid" class="form-label" >Select Page</label>
                        <select class="form-control" name="pgid[]" id="pgid" multiple>
                            <?php echo $pages;?>
                        </select>
                    </div>
                    <div class="modal-body p-4" >
                        <label for="status" class="form-label">User Status</label>
                        <select class="form-control" name="status" id="statuss">
                            <option value="Active">Active</option>
                            <option value="Deactive">Deactive</option>
                            <option value="Fired">Fired</option>
                            <option value="Resigned">Resigned</option>

                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="updateData">Update</button>
                    </div>
                    <input type="hidden" name="user_id" id="user_id">
                </form>
            </div>
        </div>
    </div>
    <!-- end paid redeem modal -->
    <!-- paid redeem modal -->
    <div class="modal fade" id="issuesactionmdl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-size-16" id="createticketLabel">Add Issue Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body p-4">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#agents" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Agents</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">All</button>
                      </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="agents" role="tabpanel" aria-labelledby="pills-home-tab">
                            <form method="post"  id="" action="#">
                                
                                <div class="mb-4">
                                    <label for="agent_name" class="form-label">Agent Name</label>
                                    <input class="form-control" type="text" name="agent_name" id="agent_name" readonly> 
                                </div>  
                                <div class="mb-4">
                                    <label for="pgid" class="form-label" >Page Name</label>
                                    <input class="form-control" type="text" name="pagename" id="pagename" readonly>
                                </div>
                                <div class="mb-4" >
                                    <label for="agentshift" class="form-label">Shift</label>
                                    <input class="form-control agentshift" type="text" name="agentshift" id="agentshift" readonly>
                                </div>
                                <div class="mb-4" >
                                    <ul class="list-unstyled contact-list" id="member_list">
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input cb_groupadduser" name="issues[]" value="Hardware" style="background-color: #7269ef !important;">
                                                <label class="form-check-label" for="name">Hardware</label>
                                                
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input cb_groupadduser" name="issues[]" value="Internet" style="background-color: #7269ef !important;">
                                                <label class="form-check-label" for="name">Internet</label>
                                                
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input cb_groupadduser" name="issues[]" value="Live Chat" style="background-color: #7269ef !important;">
                                                <label class="form-check-label" for="name">Live Chat</label>
                                                
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input cb_groupadduser" name="issues[]" value="Zoho" style="background-color: #7269ef !important;">
                                                <label class="form-check-label" for="name">Zoho</label>
                                                
                                            </div>
                                        </li>
                                    </ul>
                                       
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="addData">Add</button>
                                </div>  
                            </form>
                        </div>
                        <div class="tab-pane fade " id="all" role="tabpanel" aria-labelledby="pills-home-tab">
                            <form method="post"  id="" action="#">
                                
                                <div class="mb-4">
                                    <label for="agent_name" class="form-label">All Agents</label>
                                    <input class="form-control" type="text" name="agent_name" id="" value="All" readonly> 
                                </div>  
                                <div class="mb-4">
                                    <label for="pgid" class="form-label" >All Pages</label>
                                    <input class="form-control" type="text" name="pagename" id="" value="All" readonly>
                                </div>
                                <div class="mb-4" >
                                    <label for="agentshift" class="form-label">Shift</label>
                                    <input class="form-control agentshift" type="text" name="agentshift" id="agentshift" readonly>
                                </div>
                                <div class="mb-4" >
                                    <ul class="list-unstyled contact-list" id="member_list">
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input cb_groupadduser" name="issues[]" value="Hardware" style="background-color: #7269ef !important;">
                                                <label class="form-check-label" for="name">Hardware</label>
                                                
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input cb_groupadduser" name="issues[]" value="Internet" style="background-color: #7269ef !important;">
                                                <label class="form-check-label" for="name">Internet</label>
                                                
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input cb_groupadduser" name="issues[]" value="Live Chat" style="background-color: #7269ef !important;">
                                                <label class="form-check-label" for="name">Live Chat</label>
                                                
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input cb_groupadduser" name="issues[]" value="Zoho" style="background-color: #7269ef !important;">
                                                <label class="form-check-label" for="name">Zoho</label>
                                                
                                            </div>
                                        </li>
                                    </ul>
                                       
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="addData">Add</button>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- off day modal start here -->
    <div class="modal fade" id="updateoffday_mdl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary-subtle">
                    <h5 class="modal-title font-size-16" id="createticketLabel">Update Off Day</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body p-4">
                    
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="agents" role="tabpanel" aria-labelledby="pills-home-tab">
                            <form method="post"  id="" action="#">
                                
                                <!-- <div class="mb-4">
                                    <label for="agent_name" class="form-label">Agent Name</label>
                                    <input class="form-control" type="text" name="agent_name" id="agent_name" readonly> 
                                </div>  
                                <div class="mb-4">
                                    <label for="pgid" class="form-label" >Page Name</label>
                                    <input class="form-control" type="text" name="pagename" id="pagename" readonly>
                                </div> -->
                                <div class="mb-4" >
                                    <ul class="list-unstyled contact-list font-size-20" id="member_list">
                                        <?php 
                                        $days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                                        foreach ($days as $day): ?>
                                            <li>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input cb_groupadduser" name="offday[]" value="<?php echo $day; ?>" style="background-color: #7269ef !important;">
                                                    <label class="form-check-label" for="name"><?php echo $day; ?></label>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                        
                                    </ul>
                                       
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="updateOffday">Update</button>
                                </div>  
                                <input type="hidden" name="userid" id="userid">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>

</body>
</html>