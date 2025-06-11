
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Unprocess Redeem Details | SHJ INTERNATIONAL</title>
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
            $class='';

            $query = mysqli_query($connect, "SELECT pages.id as page_id,pages.pagename,pending_redeem.id as unprocessid,pending_redeem.pageid,pending_redeem.customer_name,pending_redeem.gameid,pending_redeem.status,pending_redeem.issue,pending_redeem.utype,pending_redeem.uname,pending_redeem.created_at,pending_redeem.updated_at 
                FROM pending_redeem 
                JOIN pages 
                ON pending_redeem.pageid=pages.id");
            if(mysqli_num_rows($query) > 0){
                while($row=mysqli_fetch_array($query)){

                    if ($row['status'] == 'Completed') {
                        $action = '';
                        $class='bg-success text-center text-white'; 
                        $action = '<i class="btn btn-success" >Completed</i>';
                    } 
                    else {
                       $class='bg-danger-subtle  text-center text-white';
                        if ($type == 'Manager' || $type == 'Webmaster') {
                            $action = '<i class="btn btn-primary edit_unprocessstatus" data-id="' . $row['unprocessid'] . '" data-issue="' . $row['issue'] . '" style="cursor:pointer;">Update</i>';
                        } 
                        else {
                            $action = ''; 
                            
                        }
                    }
                   

                    $id             =$row['unprocessid'];
                    $pagename       =$row['pagename'];
                    $customer_name  =$row['customer_name'];
                    $gameid         =$row['gameid'];
                    $status         =$row['status'];
                    $issue          =$row['issue'];
                    $utype          =$row['utype'];
                    $uname          =$row['uname'];
                    $created_at     =$row['created_at'];
                    $updated_At     =$row['updated_at'];

                    $html.='<tr>
                            <td>'.$id.'</td>
                            <td>'.$pagename.'</td>
                            <td>'.$customer_name.'</td>
                            <td>'.$gameid.'</td>
                            <td class="'.$class.'">'.$status.'</td>
                            <td>'.$issue.'</td>
                            <td>'.$utype.'</td>
                            <td>'.$uname.'</td>
                            <td>'.$created_at.'</td>
                            <td>'.$updated_At.'</td>
                            <td>'.$action.'</td>
                    </tr>';
                   // echo "<pre>";
                   //  print_r($row); 
                }
            }
            
            if(isset($_POST['updatestatus']))
            {
                $id         =$_POST['unprocess_id'];
                $issue      =$_POST['issue'];
                $status     =$_POST['rdmstatus'];
                $updated_at =date('Y-m-d H:i:s');

                $query = mysqli_query($connect, "UPDATE pending_redeem SET status='$status', issue='$issue', updated_at='$updated_at' WHERE id='$id'") or die(mysqli_error($connect));

                if ($query) {
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
                                <h4 class="mb-sm-0 font-size-18">Unprocess Redeem List</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                                        <li class="breadcrumb-item active">Unprocess Redeem List</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center " >
                    <div class="col-md-8 col-lg-6 col-xl-12 ">
                        <!-- <div class="text-center mb-4 mt-4">
                         
                            <i class="bx bx-list-ol"></i> <h4>Unprocess Redeem List</h4>
                          
                        </div> -->

                        <!-- <div class="card chat-conversation" data-simplebar="init"> -->
                           <!--  <div class="card-body p-4">
                                <div class="p-3"> -->
                                   <table class="table table-bordered" id="unprocess_tble">
                                        <thead>
                                            <tr>
                                              <th scope="col">ID</th>
                                              <th scope="col">Page Name</th>
                                              <th scope="col">Customer Name</th>
                                              <th scope="col">Game ID</th>
                                              <th scope="col">Status</th>
                                              <th scope="col">Issue</th>
                                              <th scope="col">User Type</th>
                                              <th scope="col">User Name</th>
                                              <th scope="col">Created At</th>
                                              <th scope="col">Updated At</th>
                                              <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Page Name</th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Game ID</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Issue</th>
                                                <th scope="col">User Type</th>
                                                <th scope="col">User Name</th>
                                                <th scope="col">Created At</th>
                                                <th scope="col">Updated At</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                         
                                        </tfoot>
                                    </table>

                               <!--  </div>
                            </div> -->
                        <!-- </div> -->

                    </div>
                </div>
                </div>
            </div>
            <?php include('footer.html');?>
        </div>

    </div>
    <div class="modal fade" id="unprocessredeem_modl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static"  style="display:none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="#">
                    <div class="modal-header">
                        <h5 class="modal-title font-size-16" id="createticketLabel">Edit Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <label class="form-label" for="status">Status</label>
                        <div class="input-group mb-3 bg-light-subtle rounded-3">
                            <span class="input-group-text text-muted" id="basic-addon3">
                               <i class="ri-checkbox-multiple-line"></i>
                            </span>
                            <select name="rdmstatus" id="rdmstatus" class="form-control">
                              
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>

                               
                           </select>
                        </div>
                    </div>
                    <div class="p-4">
                       <label for="pasteimages" class="form-label">Issue Due To </label>
                        <textarea class="form-control" name="issue" placeholder="Type Here..." style="resize: none;" id="issue" required></textarea>  
                    </div>
                    <input type="hidden" name="unprocess_id" id="unprocess_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="updatestatus">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="rightbar-overlay"></div>

    <?php include('footer_links.html');?>
    <script>
        $(document).ready(function() {
            var role='<?php echo $type;?>';
           $('#unprocess_tble').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [[0, 'desc']],
                "ajax": {
                    "url": "fetch_unprocessredeem_details.php",  // Path to your PHP script
                    "type": "POST",
                    "dataSrc": function(json) {
                        console.log(json); // Log the response for debugging
                        return json.data;
                    }
                },
                "columns": [
                    { "data": "unprocessid" },          // Page ID
                    { "data": "pagename" },         // Page Name
                    { "data": "customer_name" },    // Customer Name
                    { "data": "gameid" },           // Game ID
                    { "data": "status",
                        "createdCell": function(td, cellData, rowData, row, col) {
                            // Apply a badge style based on status
                            let badgeClass = cellData === 'Completed' ? 'bg-success' : 'bg-danger-subtle';
                            $(td).html('<span class="badge rounded-pill ' + badgeClass + ' font-size-12">' + cellData + '</span>');
                        }
                    },
                    { "data": "issue" },            // Issue
                    { "data": "utype" },            // User Type
                    { "data": "uname" },            // User Name
                    { "data": "created_at" },       // Created At
                    { "data": "updated_at" },       // Updated At
                    {
                        "data": "unprocessid",     // Unprocessed ID
                        "render": function(data, type, row, meta) {
                            let actionButtons = '';
                            let classNames = '';

                            if (row['status'] === 'Completed') {
                                classNames = 'bg-success text-center text-white';
                                actionButtons = '<i class="btn btn-success">Completed</i>';
                            } else {
                                classNames = 'bg-danger-subtle text-center text-white';
                                if (role === 'Manager' || role === 'Webmaster') {
                                    actionButtons = '<i class="btn btn-primary edit_unprocessstatus" data-id="' + row['unprocessid'] + '" data-issue="' + row['issue'] + '" style="cursor:pointer;">Update</i>';
                                } else {
                                    actionButtons = ''; 
                                }
                            }

                            // Apply classNames to the td element (if needed)
                            $(meta.row).addClass(classNames);

                            return actionButtons;
                        }
                    }
                ]
            });


         
        });
    
    </script>
</body>
</html>