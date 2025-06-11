
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
            if ( $type == 'Q&A') {
      
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
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Chat Support</a></li>
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
                                             
                                              <th scope="col">User Name</th>
                                              <th scope="col">Created At</th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                        </tbody>
                                        
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
                    { "data": "uname" },            // User Name
                    { "data": "created_at" },       // Created At
                   
                    
                ]
            });


         
        });
    
    </script>
</body>
</html>