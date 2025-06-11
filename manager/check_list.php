<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        
        <title>Check List | SHJ International</title>
        
        <?php require("links.html"); ?>

        <style>
            .remarks-column {
                width: 500px; /* Set the maximum width */
                word-wrap: break-word; /* Enable text wrapping */
            }
        </style>
        
    </head>

    <body>
        <div class="layout-wrapper">
            
           <?php 
            include('topheader.php');
            include('../sidebar.php');
            include('rightsidebar.php');

            ?>
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

                $morning='';

                $query = mysqli_query($connect, " SELECT 
                    user.id AS userid,
                    user.agentid,
                    user.fullname,
                    user.shift AS usershift,
                    user.type,
                    user.status,
                    checklist.id AS checklistid,
                    checklist.user_id,
                    checklist.username,
                    GROUP_CONCAT(pages.pagename) AS page_name,
                    GROUP_CONCAT(redeem_counts.redeem_count) AS redeem_counts,
                    checklist.status AS userstatus,
                    checklist.pending_redeems,
                    checklist.pending_chats,
                    checklist.performance,
                    checklist.anydesk,
                    checklist.cashapp_limits,
                    checklist.customer_issue,
                    checklist.client,
                    checklist.request,
                    checklist.remarks,
                    checklist.shift
                    FROM 
                        user 
                    LEFT JOIN 
                        checklist ON user.id = checklist.user_id 
                    LEFT JOIN 
                        pages ON FIND_IN_SET(pages.id, REPLACE(user.pgid, ' ', '')) > 0
                    LEFT JOIN (
                        SELECT 
                            pages.id AS pg_id,
                            pages.pagename,
                            COUNT(redeem.id) AS redeem_count
                        FROM 
                            pages
                        LEFT JOIN 
                            redeem ON redeem.pg_id = pages.id AND redeem.status = 'Pending' AND redeem.del = '0'
                        GROUP BY 
                            pages.id
                    ) AS redeem_counts ON  redeem_counts.pg_id = pages.id 
                    WHERE user.shift='Morning' 
                    AND user.type='CSR' 
                    AND user.department='Live Chat'
                    AND user.status='Active'
                    GROUP BY 
                        user.id;")
                ; 
                if(mysqli_num_rows($query) > 0){
                    while($rows=mysqli_fetch_array($query)){
                        // echo "<pre>";
                        // print_r($rows);
                        $id             =$rows['userid'];
                        $fullname       =$rows['fullname'];
                        $status         =$rows['userstatus'];
                        $checklistid    =$rows['checklistid'];
                        $username       =$rows['username'];
                        $pending_redeems=$rows['pending_redeems'];
                        $pending_chats  =$rows['pending_chats'];
                        $performance    =$rows['performance'];
                        $anydesk        =$rows['anydesk'];
                        $cashapp_limits =$rows['cashapp_limits'];
                        $customer_issue =$rows['customer_issue'];
                        $client         =$rows['client'];
                        $request        =$rows['request'];
                        $remarks        =$rows['remarks'];
                        $pagename       =$rows['page_name'];
                        $redeem_count   =$rows['redeem_counts'];

                        $morning.='<tr id="'.$id.'">
                            <td>'.$id.'</td>
                            <td>'.$fullname.'</td>
                            <td>'.$pagename.'</td>
                            <td>'.$status.'</td>
                            <td>' . (isset($redeem_count) ? $redeem_count : "-") . '</td>
                            <td>' . (isset($pending_chats) ? $pending_chats : "-") . '</td>
                            <td>' . (isset($performance) ? $performance : "-") . '</td>
                            <td>' . (isset($anydesk) ? $anydesk : "-") . '</td>
                            <td>' . (isset($cashapp_limits) ? $cashapp_limits : "-") . '</td>
                            <td>' . (isset($customer_issue) ? $customer_issue : "-") . '</td>
                            <td>' . (isset($client) ? $client : "-") . '</td>
                            <td>' . (isset($request) ? $request : "-") . '</td>
                            <td class="remarks-column">' . (isset($remarks) ? $remarks : "-") . '</td>
                                    
                        </tr>';
                        
                    }
                    // exit;
                    // echo $output;
                }

                // for evening shift
                $evening='';

               $query = mysqli_query($connect, "
                    SELECT 
                        user.id AS userid,
                        user.agentid,
                        user.fullname,
                        user.shift AS usershift,
                        user.type,
                        user.status,
                        checklist.id AS checklistid,
                        checklist.user_id,
                        checklist.username,
                        GROUP_CONCAT(pages.pagename) AS page_name,
                        GROUP_CONCAT(redeem_counts.redeem_count) AS redeem_counts,
                        checklist.status AS userstatus,
                        checklist.pending_redeems,
                        checklist.pending_chats,
                        checklist.performance,
                        checklist.anydesk,
                        checklist.cashapp_limits,
                        checklist.customer_issue,
                        checklist.client,
                        checklist.request,
                        checklist.remarks,
                        checklist.shift
                    FROM 
                        user 
                    LEFT JOIN 
                        checklist ON user.id = checklist.user_id 
                    LEFT JOIN 
                        pages ON FIND_IN_SET(pages.id, REPLACE(user.pgid, ' ', '')) > 0
                    LEFT JOIN (
                        SELECT 
                            pages.id AS pg_id,
                            pages.pagename,
                            COUNT(redeem.id) AS redeem_count
                        FROM 
                            pages
                        LEFT JOIN 
                            redeem ON redeem.pg_id = pages.id AND redeem.status = 'Pending' AND redeem.del = '0'
                        GROUP BY 
                            pages.id
                    ) AS redeem_counts ON  redeem_counts.pg_id = pages.id
                    WHERE 
                        user.shift = 'Evening' 
                        AND user.type = 'CSR'
                        AND user.department = 'Live Chat' 
                        AND user.status = 'Active'
                    GROUP BY 
                        user.id
                ");
                if (!$query) {
                    die("Error in SQL query: " . mysqli_error($connect));
                }
                if(mysqli_num_rows($query) > 0){
                    while($rows=mysqli_fetch_array($query)){
                        
                        $id             =$rows['userid'];
                        $fullname       =$rows['fullname'];
                        $status         =$rows['userstatus'];
                        $checklistid    =$rows['checklistid'];
                        $username       =$rows['username'];
                        $pending_redeems=$rows['pending_redeems'];
                        $pending_chats  =$rows['pending_chats'];
                        $performance    =$rows['performance'];
                        $anydesk        =$rows['anydesk'];
                        $cashapp_limits =$rows['cashapp_limits'];
                        $customer_issue =$rows['customer_issue'];
                        $client         =$rows['client'];
                        $request        =$rows['request'];
                        $remarks        =$rows['remarks'];
                       
                        $pagename       =$rows['page_name'];
                        $redeem_count   =$rows['redeem_counts'];

                        $evening.='<tr id="'.$id.'">
                            <td>'.$id.'</td>
                            <td>'.$fullname.'</td>
                            <td>'.$pagename.'</td>
                            <td>'.$status.'</td>
                            <td>' . (isset($redeem_count) ? $redeem_count : "-") . '</td>
                            <td>' . (isset($pending_chats) ? $pending_chats : "-") . '</td>
                            <td>' . (isset($performance) ? $performance : "-") . '</td>
                            <td>' . (isset($anydesk) ? $anydesk : "-") . '</td>
                            <td>' . (isset($cashapp_limits) ? $cashapp_limits : "-") . '</td>
                            <td>' . (isset($customer_issue) ? $customer_issue : "-") . '</td>
                            <td>' . (isset($client) ? $client : "-") . '</td>
                            <td>' . (isset($request) ? $request : "-") . '</td>
                            <td class="remarks-column">' . (isset($remarks) ? $remarks : "-") . '</td>
                                     
                        </tr>';
                        
                    }
                    // exit;
                    // echo $output;
                }

                // for night shift
                $night='';

                $query = mysqli_query($connect, " SELECT 
                    user.id AS userid,
                    user.agentid,
                    user.fullname,
                    user.shift AS usershift,
                    user.type,
                    user.status,
                    checklist.id AS checklistid,
                    checklist.user_id,
                    checklist.username,
                    GROUP_CONCAT(pages.pagename) AS page_name,
                    GROUP_CONCAT(redeem_counts.redeem_count) AS redeem_counts,
                    checklist.status AS userstatus,
                    checklist.pending_redeems,
                    checklist.pending_chats,
                    checklist.performance,
                    checklist.anydesk,
                    checklist.cashapp_limits,
                    checklist.customer_issue,
                    checklist.client,
                    checklist.request,
                    checklist.remarks,
                    checklist.shift
                    FROM 
                        user 
                    LEFT JOIN 
                        checklist ON user.id = checklist.user_id 
                    LEFT JOIN 
                        pages ON FIND_IN_SET(pages.id, REPLACE(user.pgid, ' ', '')) > 0
                    LEFT JOIN (
                        SELECT 
                            pages.id AS pg_id,
                            pages.pagename,
                            COUNT(redeem.id) AS redeem_count
                        FROM 
                            pages
                        LEFT JOIN 
                            redeem ON redeem.pg_id = pages.id AND redeem.status = 'Pending' AND redeem.del = '0'
                        GROUP BY 
                            pages.id
                    ) AS redeem_counts ON  redeem_counts.pg_id = pages.id
                    
                    WHERE user.shift='Night' 
                    AND user.type='CSR' 
                    AND user.department='Live Chat'
                    AND user.status='Active'
                    GROUP BY 
                        user.id;")
                ; 
                if(mysqli_num_rows($query) > 0){
                    while($rows=mysqli_fetch_array($query)){
                        // echo "<pre>";
                        // print_r($rows);
                        $id             =$rows['userid'];
                        $fullname       =$rows['fullname'];
                        $status         =$rows['userstatus'];
                        $checklistid    =$rows['checklistid'];
                        $username       =$rows['username'];
                        $pending_redeems=$rows['pending_redeems'];
                        $pending_chats  =$rows['pending_chats'];
                        $performance    =$rows['performance'];
                        $anydesk        =$rows['anydesk'];
                        $cashapp_limits =$rows['cashapp_limits'];
                        $customer_issue =$rows['customer_issue'];
                        $client         =$rows['client'];
                        $request        =$rows['request'];
                        $remarks        =$rows['remarks'];
                        $pagename       =$rows['page_name'];
                        $redeem_count   =$rows['redeem_counts'];

                        $night.='<tr id="'.$id.'">
                            <td>'.$id.'</td>
                            <td>'.$fullname.'</td>
                            <td>'.$pagename.'</td>
                            <td>'.$status.'</td>
                            <td>' . (isset($redeem_count) ? $redeem_count : "-") . '</td>
                            <td>' . (isset($pending_chats) ? $pending_chats : "-") . '</td>
                            <td>' . (isset($performance) ? $performance : "-") . '</td>
                            <td>' . (isset($anydesk) ? $anydesk : "-") . '</td>
                            <td>' . (isset($cashapp_limits) ? $cashapp_limits : "-") . '</td>
                            <td>' . (isset($customer_issue) ? $customer_issue : "-") . '</td>
                            <td>' . (isset($client) ? $client : "-") . '</td>
                            <td>' . (isset($request) ? $request : "-") . '</td>
                            <td class="remarks-column">' . (isset($remarks) ? $remarks : "-") . '</td>
                                   
                        </tr>';
                        
                    }
                    // exit;
                    // echo $output;
                }
            ?>
            
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row justify-content-center " >
                            <div class="col-md-8 col-lg-6 col-xl-12 ">
                                <div class="text-center mb-4 mt-4">
                                 
                                    <i class="ri-file-list-2-fill"></i> <h4>Check List <?php echo date('d/m/Y');?></h4>
                                  
                                </div>

                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <?php if($shift =='Morning' || $checklist==1):?>

                                      <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php if($shift=='Morning') echo'active';?>" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#morning-shift" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Morning Shift</button>
                                      </li>
                                    <?php endif;?>
                                    <?php if($shift =='Evening' || $checklist==1):?>
                                      <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php if($shift=='Evening') echo'active';?>" id="pills-evening-tab" data-bs-toggle="pill" data-bs-target="#evening-shift" type="button" role="tab" aria-controls="evening-shift" aria-selected="false">Evening Shift</button>
                                      </li>
                                    <?php endif;?>
                                     <?php if($shift =='Night' || $checklist==1):?>
                                      <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php if($shift=='Night') echo'active';?>" id="pills-night-tab" data-bs-toggle="pill" data-bs-target="#night-shift" type="button" role="tab" aria-controls="night-shift" aria-selected="false">Night Shift</button>
                                      </li>
                                    <?php endif;?>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <?php if($shift =='Morning' || $checklist==1):?>
                                        <div class="tab-pane fade <?php if($shift=='Morning') echo'show active';?>" id="morning-shift" role="tabpanel" aria-labelledby="pills-home-tab">
                                           <!--  <div class="card chat-conversation" data-simplebar="init">
                                                <div class="card-body p-4"> -->
                                                    <div class="p-3">
                                                       <table class="table table-bordered" id="morning_users_list" style="width: 100%;">
                                                          <thead>
                                                                <tr>
                                                                    <th scope="col">Agent ID</th> 
                                                                    <th scope="col">Full Name</th>
                                                                    <!-- <th scope="col">User Name</th> -->
                                                                    <!-- <th scope="col">Shift</th> -->
                                                                    <th scope="col" style="width: 500px !important;">Pages</th>
                                                                    <th scope="col">Status</th>
                                                                    <th scope="col">Pending Redeems</th>
                                                                    <th scope="col">Pending Chats</th>
                                                                    <th scope="col">System Performance</th>
                                                                    <th scope="col">Anydesk</th>
                                                                    <th scope="col">Cashapp Limits</th>
                                                                    <th scope="col">Customer Issue</th>
                                                                    <th scope="col">Client Availability</th>
                                                                    <th scope="col">Pending Requests</th>
                                                                    <th scope="col">Issues & Updates</th>
                                                                   
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php echo $morning;?>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                               <!--  </div>
                                            </div> -->
                                        </div>
                                    <?php endif;?>
                                    <?php if($shift =='Evening' || $checklist==1):?>
                                        <div class="tab-pane fade <?php if($shift=='Evening') echo'show active';?>" id="evening-shift" role="tabpanel" aria-labelledby="pills-evening-tab">
                                           <!--  <div class="card chat-conversation" data-simplebar="init">
                                                <div class="card-body p-4"> -->
                                                    <div class="p-3">
                                                       <table class="table table-bordered" id="evening_users_list" style="width: 100%;">
                                                          <thead>
                                                                <tr>
                                                                    <th scope="col">Agent ID</th> 
                                                                    <th scope="col">Full Name</th>
                                                                    <!-- <th scope="col">User Name</th> -->
                                                                    <!-- <th scope="col">Shift</th> -->
                                                                    <th scope="col" style="width: 500px !important;">Pages</th>
                                                                    <th scope="col">Status</th>
                                                                    <th scope="col">Pending Redeems</th>
                                                                    <th scope="col">Pending Chats</th>
                                                                    <th scope="col">System Performance</th>
                                                                    <th scope="col">Anydesk</th>
                                                                    <th scope="col">Cashapp Limits</th>
                                                                    <th scope="col">Customer Issue</th>
                                                                    <th scope="col">Client Availability</th>
                                                                    <th scope="col">Pending Requests</th>
                                                                    <th scope="col">Issues & Updates</th>
                                                                   
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php echo $evening;?>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                               <!--  </div>
                                            </div> -->
                                        </div>
                                    <?php endif;?>
                                    <?php if($shift =='Night' || $checklist==1):?>
                                        <div class="tab-pane fade <?php if($shift=='Night') echo'show active';?>" id="night-shift" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <!-- <div class="card chat-conversation" data-simplebar="init">
                                                <div class="card-body p-4"> -->
                                                    <div class="p-3">
                                                       <table class="table table-bordered" id="night_users_list" style="width: 100%;">
                                                          <thead>
                                                                <tr>
                                                                    <th scope="col">Agent ID</th> 
                                                                    <th scope="col">Full Name</th>
                                                                    <!-- <th scope="col">User Name</th> -->
                                                                    <!-- <th scope="col">Shift</th> -->
                                                                    <th scope="col" style="width: 500px !important;">Pages</th>
                                                                    <th scope="col">Status</th>
                                                                    <th scope="col">Pending Redeems</th>
                                                                    <th scope="col">Pending Chats</th>
                                                                    <th scope="col">System Performance</th>
                                                                    <th scope="col">Anydesk</th>
                                                                    <th scope="col">Cashapp Limits</th>
                                                                    <th scope="col">Customer Issue</th>
                                                                    <th scope="col">Client Availability</th>
                                                                    <th scope="col">Pending Requests</th>
                                                                    <th scope="col">Issues & Updates</th>
                                                                   
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php echo $night;?>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                               <!--  </div>
                                            </div> -->
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include('footer.html');?>
            </div>
            
        </div>
        <!-- paid redeem modal -->
       <!--  <div class="modal fade" id="updateuserstatusmodal" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" style="display:none;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <form method="post"  id="" action="#">
                        <div class="modal-header">
                            <h5 class="modal-title font-size-16" id="createticketLabel">Update User Shift</h5>
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="updateData">Update</button>
                        </div>
                        <input type="hidden" name="user_id" id="user_id">
                    </form>
                </div>
            </div>
        </div> -->
        <!-- end paid redeem modal -->
       <?php include('footer_links.html');?>

      
        <script>
            $(document).ready(function () {
                $('#morning_users_list').DataTable({
                    "order": [[1, 'asc']],
                });
                $('#evening_users_list').DataTable({
                    "order": [[1, 'asc']],
                });
                $('#night_users_list').DataTable({
                    "order": [[1, 'asc']],
                });
                
            });
        </script>
       
       
    </body>

</html>