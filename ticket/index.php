
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Tickets | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/2.0.0/css/select.dataTables.css">
    


</head>
<body>
	<div id="layout-wrapper">
    <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php include('topheader.php');
      
      require_once('../connect_me.php');
      $database_connection = new Database_connection();
      $connect = $database_connection->connect();
      $html='';
      if ($type === 'Manager' || $type === 'Webmaster' || $type === 'Q&A') {
        // For Manager or Webmaster, show all pages
        $query = mysqli_query($connect, "
          SELECT 
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
              pages.pagename ASC;
          "
        );
      } 
      else{ 
        $query = mysqli_query($connect, " SELECT 
          pages.*, 
          COUNT(redeem.id) AS pending_redeem_count
          FROM 
          pages
          LEFT JOIN 
          redeem ON pages.id = redeem.pg_id AND redeem.status = 'Pending' AND del='0'
          JOIN 
          user ON FIND_IN_SET(pages.id, user.pgid) AND user.id = $uid
          WHERE 
          pages.status = 'active'
          GROUP BY 
          pages.id, pages.pagename
          ORDER BY 
          pages.pagename ASC;"
        );
      }
      if(mysqli_num_rows($query) > 0){
          while($row=mysqli_fetch_array($query)){
              $id=$row['id'];
              $pagename=$row['pagename'];
              $html.='<option value="'.$row['id'].'">'.$row['pagename'].'</option>';
             // echo "<pre>";
             //  print_r($row); 
          }
      }

      if(isset($_POST['create_ticket'])){
        $numeric_part     = sprintf('%03d', rand(0, 999));
        $tkt_id           = date('dmY') . '-' . $numeric_part;
        $subject          =$_POST['subject'];
        $description      =$_POST['description'];
        $deadline         =$_POST['deadline'];
        $priority         =$_POST['priority'];
        $ticketreference  =$_POST['ticketreference'];
        $page_id          =$_POST['page_id'];
        $departments      =$_POST['departments'];
        $shift            =$_POST['tickettransferusershift'];
        $assignedto       =$_POST['tickettransferuserid'];
        $tickettype       =$_POST['tickettype'];
        $followup         =$_POST['followup'];
        $followupnotes    =$_POST['followupnotes'];
        $uid              =$_POST['uid'];
        $progress         ='0';
        $created_at       =date('Y-m-d H:i:s');
        $img_type         ='Ticket Attachment';
        $subscribers      = isset($_POST['subscribers']) && !empty($_POST['subscribers']) ? implode(",", $_POST['subscribers']) : null;
        // $subscribers      =$_POST['subscribers'];
        // $subscriber       =implode(",",$subscribers);
        // echo "<pre>";
        // print_r($_POST);
        // exit;

        $sql = mysqli_query($connect, "INSERT INTO tkt_info (tkt_id, subject, deadline, priority, reference_tkt, pg_id, departments, shift, type,created_by, assigned_to, progress,  followup, note, created_at) VALUES ('$tkt_id', '$subject', '$deadline', '$priority', '$ticketreference', '$page_id', '$departments', '$shift', '$tickettype','$uid', '$assignedto', '$progress', '$followup', '$followupnotes', '$created_at')") or die(mysqli_error($connect));

        

        if ($sql) {
          $sql_tkt_assign = mysqli_query($connect, "INSERT INTO tkt_assign (tkt_id, description, deadline, priority, reference_tkt, pg_id, departments, shift, type, assigned_by, assigned_to, progress, subscribers, created_at) VALUES ('$tkt_id', '". mysqli_real_escape_string($connect, $description) ."', '$deadline', '$priority', '$ticketreference', '$page_id', '$departments', '$shift', '$tickettype','$uid', '$assignedto', '$progress', '$subscribers', '$created_at')") or die(mysqli_error($connect));
          if($sql_tkt_assign){
            $last_tkt_assign_id = mysqli_insert_id($connect);
            
            $unique=uniqid();
            if (!empty($_FILES['files_arry']['name'][0])) {
              // $filesCount = count($_FILES['files_arry']['name']);
              
              foreach ($_FILES['files_arry']['name'] as $key => $fileName) {
                $fileTmpName = $_FILES['files_arry']['tmp_name'][$key];
                $fileType = $_FILES['files_arry']['type'][$key];
                $fileSize = $_FILES['files_arry']['size'][$key];
                $fileError = $_FILES['files_arry']['error'][$key];

                // Check if file was uploaded without errors
                if ($fileError === 0) {
                   
                  $uniqueFilename = uniqid() . '_' . $fileName;
                  // Upload file to server
                  $uploadDir = 'upload/';
                  $filePath = $uploadDir . $uniqueFilename;
                  move_uploaded_file($fileTmpName, $filePath);

                  // Insert file details into img_upload table
                  $sql_img_upload = mysqli_query($connect, "INSERT INTO img_upload (catransid, path, type, createdat) VALUES ('$last_tkt_assign_id', '$uniqueFilename', '$img_type', '$created_at')") or die(mysqli_error($connect));
                }
              }
            }
            echo 
              '<script>
                Swal.fire({
                  title: "Good job!",
                  text: "New ticket created successfully!",
                  icon: "success",
                }).then(() => {
                    window.location.href = "' . $_SERVER['PHP_SELF'] . '";
                  });
              </script>';
            exit();
         
          } 
          else {
            echo "Error inserting into tkt_info: " . mysqli_error($connect);
          }
        }
      }

      // get all user
      $user_details='';
      $query = mysqli_query($connect, " SELECT id, fullname, department 
        FROM user
        WHERE Status='Active' AND type<>'Client'
        ORDER BY fullname ASC"
        );
      if(mysqli_num_rows($query) > 0){
        while($row=mysqli_fetch_array($query)){
          $userid     =$row['id'];
          $fullname   =$row['fullname'];
          $department =$row['department'];
          $user_details.='
            <tr>
              <td><input type="checkbox" name="subscribers[]" class="dt-select-checkbox" value="'.$userid.'"></td>
              <td>'.$fullname.'</td>
              <td>'.$department.'</td>
            </tr>'
          ;
           
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
                <h4 class="mb-sm-0 font-size-18">Tickets</h4>

                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo $type;?></a></li>
                    <li class="breadcrumb-item active">Tickets</li>
                  </ol>
                </div>

              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- <div class="card-header">
                  <h4 class="card-title">Justify Tabs</h4>
                  <p class="card-title-desc">Use the tab JavaScript plugin—include
                    it individually or through the compiled <code class="highlighter-rouge">bootstrap.js</code>
                    file—to extend our navigational tabs and pills to create tabbable panes
                    of local content, even via dropdown menus.</p>
                </div> -->
                  
                  <div class="card-body">
                      
                    <ul class="nav nav-pills" role="tablist">
                      <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#open-tickets" id="opentickets" role="tab" aria-selected="true">
                          <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                          <span class="d-none d-sm-block">Open</span> 
                        </a>
                      </li>
                      <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#my-tickets" id="mytickets" role="tab" aria-selected="false" tabindex="-1">
                          <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                          <span class="d-none d-sm-block">My Activities</span> 
                        </a>
                      </li>
                      <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#closed-tickets" id="closedtickets" role="tab" aria-selected="false" tabindex="-1">
                          <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                          <span class="d-none d-sm-block">Closed</span>   
                        </a>
                      </li>
                      <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#awaiting-for-verification" id="awaitingverification" role="tab" aria-selected="false" tabindex="-1">
                          <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                          <span class="d-none d-sm-block">Awaiting Verification</span>    
                        </a>
                      </li>
                      <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#awaiting-for-acknowledgement" id="awaitingacknowledgment" role="tab" aria-selected="false" tabindex="-1">
                          <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                          <span class="d-none d-sm-block">Awaiting Acknowledgement</span>    
                        </a>
                      </li>
                      <li class="nav-item waves-effect waves-light bg-primary-subtle text-danger m-1" role="presentation">
                        <a class="nav-link text-danger" data-bs-toggle="tab" href="#all-acknowledgement" id="acknowledgment" role="tab" aria-selected="false" tabindex="-1">
                          <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                          <span class="d-none d-sm-block">Acknowledgement</span>    
                        </a>
                      </li>
                      <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#search-tickets" role="tab" aria-selected="false" tabindex="-1">
                          <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                          <span class="d-none d-sm-block">Search</span>    
                        </a>
                      </li>
                    </ul>

                      <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                      <div class="tab-pane active show" id="open-tickets" role="tabpanel">
                        <div class="col-md-6">
                          <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <div>
                                <a href="#" class="btn btn-primary" id="createticketbtn"><i class="bx bx-plus me-1"></i> Create Ticket</a>
                            </div>           
                          </div>

                        </div>
                        <div class="row">
                          <div class="col-12">
                            <div class="card">
                              <!-- <div class="card-header">
                                <h4 class="card-title">Default Datatable</h4>
                                <p class="card-title-desc">DataTables has most features enabled by
                                    default, so all you need to do to use it with your own tables is to call
                                    the construction function: <code>$().DataTable();</code>.
                                </p>
                              </div> -->
                              <div class="card-body">
  
                                <table id="tbl-opentickets" class="table table-bordered dt-responsive  nowrap w-100">
                                  <thead>
                                    <tr>
                                      <th>Subject</th>
                                      <th>Priority</th>
                                      <th>Ticket #</th>
                                      <th>Created By</th>
                                      <th>Departments</th>
                                      <th>Deadline</th>
                                      <th>Status</th>

                                    </tr>
                                    </thead>


                                    <tbody>
                                    
                                  </tbody>
                                </table>
  
                              </div>
                            </div>
                          </div> <!-- end col -->
                        </div>
                      </div>
                      <div class="tab-pane" id="my-tickets" role="tabpanel">
                        <div class="row">
                          <div class="col-12">
                            <div class="card">
                              <!-- <div class="card-header">
                                <h4 class="card-title">Default Datatable</h4>
                                <p class="card-title-desc">DataTables has most features enabled by
                                    default, so all you need to do to use it with your own tables is to call
                                    the construction function: <code>$().DataTable();</code>.
                                </p>
                              </div> -->
                              <div class="card-body">
  
                                <table id="tbl-mytickets" class="table table-bordered dt-responsive  nowrap w-100">
                                  <thead>
                                    <tr>
                                      <th>Subject</th>
                                      <th>Priority</th>
                                      <th>Ticket #</th>
                                      <th>Created By</th>
                                      <th>Departments</th>
                                      <th>Deadline</th>
                                      <th>Status</th>

                                    </tr>
                                    </thead>


                                    <tbody>
                                    
                                  </tbody>
                                </table>
  
                              </div>
                            </div>
                          </div> <!-- end col -->
                        </div>
                      </div>
                      <div class="tab-pane" id="closed-tickets" role="tabpanel">
                        <div class="row">
                          <div class="col-12">
                            <div class="card">
                              <!-- <div class="card-header">
                                <h4 class="card-title">Default Datatable</h4>
                                <p class="card-title-desc">DataTables has most features enabled by
                                    default, so all you need to do to use it with your own tables is to call
                                    the construction function: <code>$().DataTable();</code>.
                                </p>
                              </div> -->
                              <div class="card-body">
  
                                <table id="tbl-closedtickets" class="table table-bordered dt-responsive  nowrap w-100">
                                  <thead>
                                    <tr>
                                      <th>Subject</th>
                                      <th>Priority</th>
                                      <th>Ticket #</th>
                                      <th>Created By</th>
                                      <th>Departments</th>
                                      <th>Deadline</th>
                                      <th>Status</th>

                                    </tr>
                                    </thead>


                                    <tbody>
                                    
                                  </tbody>
                                </table>
  
                              </div>
                            </div>
                          </div> <!-- end col -->
                        </div>
                      </div>
                      <div class="tab-pane" id="awaiting-for-verification" role="tabpanel">
                        <div class="row">
                          <div class="col-12">
                            <div class="card">
                              <!-- <div class="card-header">
                                <h4 class="card-title">Default Datatable</h4>
                                <p class="card-title-desc">DataTables has most features enabled by
                                    default, so all you need to do to use it with your own tables is to call
                                    the construction function: <code>$().DataTable();</code>.
                                </p>
                              </div> -->
                              <div class="card-body">
  
                                <table id="tbl-verificationtickets" class="table table-bordered dt-responsive  nowrap w-100">
                                  <thead>
                                    <tr>
                                      <th>Subject</th>
                                      <th>Priority</th>
                                      <th>Ticket #</th>
                                      <th>Created By</th>
                                      <th>Departments</th>
                                      <th>Deadline</th>
                                      <th>Status</th>

                                    </tr>
                                    </thead>


                                    <tbody>
                                    
                                  </tbody>
                                </table>
  
                              </div>
                            </div>
                          </div> <!-- end col -->
                        </div>
                      </div>
                      <div class="tab-pane" id="awaiting-for-acknowledgement" role="tabpanel">
                        <div class="row">
                          <div class="col-12">
                            <div class="card">
                              <!-- <div class="card-header">
                                <h4 class="card-title">Default Datatable</h4>
                                <p class="card-title-desc">DataTables has most features enabled by
                                    default, so all you need to do to use it with your own tables is to call
                                    the construction function: <code>$().DataTable();</code>.
                                </p>
                              </div> -->
                              <div class="card-body">
  
                                <table id="tbl-acknowledgementtickets" class="table table-bordered dt-responsive  nowrap w-100">
                                  <thead>
                                    <tr>
                                      <th>Subject</th>
                                      <th>Priority</th>
                                      <th>Ticket #</th>
                                      <th>Created By</th>
                                      <th>Departments</th>
                                      <th>Deadline</th>
                                      <th>Status</th>

                                    </tr>
                                    </thead>


                                    <tbody>
                                    
                                  </tbody>
                                </table>
  
                              </div>
                            </div>
                          </div> <!-- end col -->
                        </div>
                      </div>
                      <div class="tab-pane" id="all-acknowledgement" role="tabpanel">
                        <div class="row">
                          <div class="col-12">
                            <div class="card">
                              <!-- <div class="card-header">
                                <h4 class="card-title">Default Datatable</h4>
                                <p class="card-title-desc">DataTables has most features enabled by
                                    default, so all you need to do to use it with your own tables is to call
                                    the construction function: <code>$().DataTable();</code>.
                                </p>
                              </div> -->
                              <div class="card-body">
  
                                <table id="tbl-acknowledgement" class="table table-bordered dt-responsive  nowrap w-100">
                                  <thead>
                                    <tr>
                                      <th>Subject</th>
                                      <th>Priority</th>
                                      <th>Ticket #</th>
                                      <th>Created By</th>
                                      <th>Departments</th>
                                      <th>Deadline</th>
                                      <th>Status</th>

                                    </tr>
                                    </thead>


                                    <tbody>
                                    
                                  </tbody>
                                </table>
  
                              </div>
                            </div>
                          </div> <!-- end col -->
                        </div>
                      </div>
                      <div class="tab-pane" id="search-tickets" role="tabpanel">
                        <form method="post" action="#" id="searchform">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="mb-4 position-relative" >
                                <label for="search_status" class="form-label">Status</label>
                                <select class="form-control form-select" name="search_status" id="search_status">
                                  <option value="0">--Select One--</option>
                                  <option value="Open">Open</option>
                                  <option value="Awaiting Acknowledgement">Awaiting Acknowledgement</option>
                                  <option value="Awaiting Verification">Awaiting Verification</option>
                                  <option value="Closed">Closed</option>
                                  <option value="On Hold">On Hold</option>
                                  <option value="In Progress">In Progress</option>
                                  <option value="Done">Done</option>

                                </select>
                               
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mb-4 position-relative" >
                                <label for="search_priority" class="form-label">Priority</label>

                                <select class="form-control form-select" name="search_priority" id="search_priority" required>
                                  <option value="0">--Select One--</option>
                                  <option value="Critical">Critical</option>
                                  <option value="Fatal">Fatal</option>
                                  <option value="Major">Major</option>
                                  <option value="Medium">Medium</option>
                                  <option value="Minor">Minor</option>
                                  <option value="Urgent">Urgent</option>

                                </select>
                              </div>
                            </div>    
                            <div class="col-md-6">
                              <div class="mb-4" >
                                <label for="search_subject" class="form-label">Ticket Subject</label>
                                <input type="text" class="form-control" name="search_subject" id="search_subject">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mb-4" >
                                <label for="search_ticketnumber" class="form-label">Ticket Number</label>
                                <input type="text" class="form-control" name="search_ticketnumber" id="search_ticketnumber">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mb-4" >
                                <label for="search_datefrom" class="form-label">Date From</label>
                                <input type="date" class="form-control" name="search_datefrom" id="search_datefrom">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="mb-4" >
                                <label for="search_dateto" class="form-label">Date To</label>
                                <input type="date" class="form-control" name="search_dateto" id="search_dateto">
                              </div>
                            </div>
                            
                            <div class="modal-footer">
                              <!-- <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button> -->
                              <button type="button" class="btn btn-primary" name="searchresult" id="searchresult">Search</button>
                               <button type="reset" class="btn btn-primary m-2" id="clearfilter">Clear Search Filter</button>
                            </div>
                            
                            
                          </div>
                        </form>
                        <div class="row mt-4">
                          <div class="col-12">
                            <div class="card">
                              <div class="card-body">
  
                                <table id="tbl-search" class="table table-bordered dt-responsive  nowrap w-100">
                                  <thead>
                                    <tr>
                                      <th>Subject</th>
                                      <th>Priority</th>
                                      <th>Ticket #</th>
                                      <th>Created By</th>
                                      <th>Departments</th>
                                      <th>Deadline</th>
                                      <th>Status</th>

                                    </tr>
                                  </thead>


                                  <tbody id="showsearch_data">
                                    
                                  </tbody>
                                </table>
  
                              </div>
                            </div>
                          </div> <!-- end col -->
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


  <div class="modal fade" id="createticket" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true"  data-bs-backdrop="static" style="display:none;">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title font-size-16 text-white" id="createticketLabel">Create A Ticket</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal">
          </button>
        </div>
        <div class="modal-body p-4">

          <form method="post" id="createticketform" class="needs-validation" novalidate enctype="multipart/form-data">
            <div class="mb-4 position-relative" >
              <label for="subject" class="form-label">Subject</label>
              <input type="text" class="form-control" name="subject" id="subject" required>
              <div class="invalid-tooltip">
                Please enter subject.
              </div>
            </div>
            <div class="mb-4" >
              <label for="description" class="form-label">Description</label>
              <textarea  class="form-control" name="description" id="ckeditor-classic"></textarea>
            </div>
            <div class="mb-4" >
              <label for="files" id="label-file" class="btn btn-primary"><i class="mdi mdi-attachment"></i>Attachment</label>
              <input type="file" id="files" name="files_arry[]" multiple style="display: none;">
              <br><output id="list"></output>

            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-4 position-relative" >
                  <label for="deadline" class="form-label">Deadline</label>
                  <input type="text" class="form-control" name="deadline" id="datepicker-minmax" required>
                  <div class="invalid-tooltip">
                    Please select deadline.
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4 position-relative" >
                  <label for="priority" class="form-label">Priority</label>

                  <select class="form-control form-select" name="priority" id="priority" required>
                    <option value="0" disabled>--Select--</option>
                    <option value="Critical">Critical</option>
                    <option value="Fatal">Fatal</option>
                    <option value="Major">Major</option>
                    <option value="Medium">Medium</option>
                    <option value="Minor">Minor</option>
                    <option value="Urgent">Urgent</option>

                  </select>
                  <div class="invalid-tooltip">
                    Please Priority.
                  </div>
                </div>
              </div>    
              <div class="col-md-6">
                <div class="mb-4" >
                  <label for="ticketreference" class="form-label">Reference Tickets</label>
                  <input type="text" class="form-control" name="ticketreference" id="ticketreference" value="none" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4" >
                  <label for="page_id" class="form-label">Pages</label>
                  <select class="form-control form-select page" name="page_id" id="page_id">
                    <?php echo $html;?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4" >
                  <label for="departments" class="form-label">Departments</label>
                  <select class="form-control form-select dept" name="departments" id="departments">
                    <option value="0">--Select--</option>
                    <option value="Management">Management</option>
                    <option value="Webmaster">Web Master</option>
                    <option value="Live Chat">Live Chat</option>
                    <option value="Redeem">Redeem</option>
                    <option value="HR">HR</option>
                    <option value="IT">IT</option>
                    <option value="Q&A">Q&A</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6" id="shift_col">
                <div class="mb-4" >
                  <label for="tickettransferusershift" class="form-label">Shift</label>
                  <select class="form-control form-select user" name="tickettransferusershift" id="tickettransferusershift">
                    <option value="0">--Select--</option>
                    <option value="Morning">Morning</option>
                    <option value="Evening">Evening</option>
                    <option value="Night">Night</option>
                  </select>
                </div>
               
              </div>
              <div class="col-md-6">
                <div class="mb-4" >
                  <label for="tickettransferuserid" class="form-label">Assigne To User</label>
                  <select class="form-control form-select user" name="tickettransferuserid" id="tickettransferuserid" required>
                    
                  </select>
                </div>
               
              </div>
              <div class="col-md-6">
                <div class="mb-4" >
                  <label for="tickettype" class="form-label">Type</label>
                  <select class="form-control form-select" name="tickettype" id="tickettype">
                    <option value="1">Cash Deposit</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4" >
                  <label for="followupdatetime" class="form-label">Follow-Up</label>
                  <input type="text" class="form-control" name="followup" id="followup" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4" >
                  <label for="followupnotes" class="form-label">Note</label>
                  <input type="text" class="form-control" name="followupnotes" id="followupnotes" maxlength="450" required>
                </div>
              </div>
            </div>
            <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>">
            <input type="hidden" name="uname" id="uname" value="<?php echo $uname;?>">
            
            <div class="row">
            <div class="col-12">
              
                    
              <ul class="nav nav-pills" role="tablist">
                <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                  <a class="nav-link active" data-bs-toggle="tab" href="#subscriber" id="subscriber" role="tab" aria-selected="true">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">Subscribers</span> 
                  </a>
                </li>
              </ul>
              <div class="tab-content p-3 text-muted">
                <div class="tab-pane active show" id="subscriber" role="tabpanel">
                  
                  <div class="row">
                    <div class="col-12">
                     <!--  <div class="card">
                       
                        <div class="card-body"> -->

                      <table id="tbl-subscriber" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                          <tr>
                            <th></th>
                            <th>Full Name</th>
                            <th>Departments</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php echo $user_details;?>
                        </tbody>
                      </table>

                       <!--  </div>
                      </div> -->
                    </div> <!-- end col -->
                  </div>
                </div>
              </div>
                
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-primary" name="create_ticket" id="create_ticket">Save</button>
            </div>
          </form>
        </div>
         
      </div>
    </div>
  </div>  
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>


<script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>

<script src="https://cdn.datatables.net/select/2.0.0/js/dataTables.select.js"></script>
<script src="https://cdn.datatables.net/select/2.0.0/js/select.dataTables.js"></script>
  <script>
    $(document).ready(function () {
      var userid = '<?php echo $uid;?>';
      var usertype = '<?php echo $type;?>';
      loadDataForTab('#open-tickets', userid, usertype);
      $('.nav-link').on('click', function () {
          var tabId = $(this).attr('href'); 
          // alert(tabId);
          showPreloader();

          loadDataForTab(tabId,userid,usertype); 
      });
    });

    function loadDataForTab(tabId,userid,usertype) {
     
      $.ajax({
          url: 'fetchticketdetails.php',
          method: 'POST',
          data: { tabId: tabId,uid:userid,utype:usertype }, 
          dataType: 'json',
          success: function (data) {
            renderDataInTab(tabId, data);

            hidePreloader(); 
          },
          error: function (xhr, status, error) {
              
            console.error(error);
          }
      });
    }

    function renderDataInTab(tabId, data) {

      if(tabId==='#open-tickets'){
        $('#tbl-opentickets').DataTable().clear().destroy();
        $('#tbl-opentickets').DataTable({
          data: data[0].data, // Set the data for the DataTable
          columns: [
          
           
            { 
              data: 'subject',
              render: function(data, type, row) {
                   
                return '<a href="edit_ticket.php?tkt_id=' + row.tkt_id + '">' + data + '</a>';
              }
            },
            { data: 'priority' },
            { data: 'tkt_id' },
            {
              data: null,
              render: function(data, type, row) {
                // Combine fullname and created_at into one column
                return data.fullname + ' - ' + data.created_at;
              }
            },
            { data: 'departments' },
            { data: 'deadline' },
            {
              data: null,
              render: function(data, type, row) {
                // Combine fullname and created_at into one column
                return data.status + '(' + data.progress +'% )';
              }
            }
              // Add more column definitions as needed
          ],
          // You can configure DataTable options here
          // For example:
          "paging": true,
          "searching": true,
          // "info": true,
          "order": [[0, 'asc']],
        });
      }

      if(tabId==='#my-tickets'){
        $('#tbl-mytickets').DataTable().clear().destroy();
        $('#tbl-mytickets').DataTable({
          data: data[0].data, // Set the data for the DataTable
          columns: [
          
           
            { 
              data: 'subject',
              render: function(data, type, row) {
                   
                return '<a href="edit_ticket.php?tkt_id=' + row.tkt_id + '">' + data + '</a>';
              }
            },
            { data: 'priority' },
            { data: 'tkt_id' },
            {
              data: null,
              render: function(data, type, row) {
                // Combine fullname and created_at into one column
                return data.fullname + ' - ' + data.created_at;
              }
            },
            { data: 'departments' },
            { data: 'deadline' },
            {
              data: null,
              render: function(data, type, row) {
                // Combine fullname and created_at into one column
                return data.status + '(' + data.progress +'% )';
              }
            }
              // Add more column definitions as needed
          ],
          // You can configure DataTable options here
          // For example:
          "paging": true,
          "searching": true,
          // "info": true,
          "order": [[0, 'asc']],
        });
      }
      
      if(tabId==='#closed-tickets'){
        $('#tbl-closedtickets').DataTable().clear().destroy();
        $('#tbl-closedtickets').DataTable({
          data: data[0].data, // Set the data for the DataTable
          columns: [
          
           
            { 
              data: 'subject',
              render: function(data, type, row) {
                   
                return '<a href="edit_ticket.php?tkt_id=' + row.tkt_id + '">' + data + '</a>';
              }
            },
            { data: 'priority' },
            { data: 'tkt_id' },
            {
              data: null,
              render: function(data, type, row) {
                // Combine fullname and created_at into one column
                return data.fullname + ' - ' + data.created_at;
              }
            },
            { data: 'departments' },
            { data: 'deadline' },
            {
              data: null,
              render: function(data, type, row) {
                // Combine fullname and created_at into one column
                return data.status + '(' + data.progress +'% )';
              }
            }
              // Add more column definitions as needed
          ],
          // You can configure DataTable options here
          // For example:
          "paging": true,
          "searching": true,
          // "info": true,
          "order": [[0, 'asc']],
        });
      }

      if(tabId==='#awaiting-for-verification'){
        $('#tbl-verificationtickets').DataTable().clear().destroy();
        $('#tbl-verificationtickets').DataTable({
          data: data[0].data, // Set the data for the DataTable
          columns: [
          
           
            { 
              data: 'subject',
              render: function(data, type, row) {
                   
                return '<a href="edit_ticket.php?tkt_id=' + row.tkt_id + '">' + data + '</a>';
              }
            },
            { data: 'priority' },
            { data: 'tkt_id' },
            {
              data: null,
              render: function(data, type, row) {
                // Combine fullname and created_at into one column
                return data.fullname + ' - ' + data.created_at;
              }
            },
            { data: 'departments' },
            { data: 'deadline' },
            {
              data: null,
              render: function(data, type, row) {
                // Combine fullname and created_at into one column
                return data.status + '(' + data.progress +'% )';
              }
            }
              // Add more column definitions as needed
          ],
          // You can configure DataTable options here
          // For example:
          "paging": true,
          "searching": true,
          // "info": true,
          "order": [[0, 'asc']],
        });
      }

      if(tabId==='#awaiting-for-acknowledgement'){
        $('#tbl-acknowledgementtickets').DataTable().clear().destroy();
        $('#tbl-acknowledgementtickets').DataTable({
          data: data[0].data, // Set the data for the DataTable
          columns: [
          
           
            { 
              data: 'subject',
              render: function(data, type, row) {
                   
                return '<a href="edit_ticket.php?tkt_id=' + row.tkt_id + '">' + data + '</a>';
              }
            },
            { data: 'priority' },
            { data: 'tkt_id' },
            {
              data: null,
              render: function(data, type, row) {
                // Combine fullname and created_at into one column
                return data.fullname + ' - ' + data.created_at;
              }
            },
            { data: 'departments' },
            { data: 'deadline' },
            {
              data: null,
              render: function(data, type, row) {
                // Combine fullname and created_at into one column
                return data.status + '(' + data.progress +'% )';
              }
            }
              // Add more column definitions as needed
          ],
          // You can configure DataTable options here
          // For example:
          "paging": true,
          "searching": true,
          // "info": true,
          "order": [[0, 'asc']],
        });
      }

      if(tabId==='#all-acknowledgement'){
        $('#tbl-acknowledgement').DataTable().clear().destroy();
        $('#tbl-acknowledgement').DataTable({
          data: data[0].data, // Set the data for the DataTable
          columns: [
          
           
            { 
              data: 'subject',
              render: function(data, type, row) {
                   
                return '<a href="edit_ticket.php?tkt_id=' + row.tkt_id + '">' + data + '</a>';
              }
            },
            { data: 'priority' },
            { data: 'tkt_id' },
            {
              data: null,
              render: function(data, type, row) {
                // Combine fullname and created_at into one column
                return data.fullname + ' - ' + data.created_at;
              }
            },
            { data: 'departments' },
            { data: 'deadline' },
            {
              data: null,
              render: function(data, type, row) {
                // Combine fullname and created_at into one column
                return data.status + '(' + data.progress +'% )';
              }
            }
              // Add more column definitions as needed
          ],
          // You can configure DataTable options here
          // For example:
          "paging": true,
          "searching": true,
          // "info": true,
          "order": [[0, 'asc']],
        });
      }
    }
    

    // search function start here
    $(document).ready(function () {
      $('#searchresult').click(function () {
         
        var anyFilterEntered = false;
        $('#searchform :input').each(function() {
            if ($(this).val() !== "" && $(this).val() !== "0") {
                anyFilterEntered = true;
                return false; // Exit loop if a filter value is found
            }
        });

     
        if (!anyFilterEntered) {
            alert("Please enter at least one search criteria.");
            return; // Exit the function to prevent further execution
        }

        showPreloader();

     
        var formData = $('#searchform').serialize();

    
        $.ajax({
          type: 'POST',
          url: 'search_ticket.php',
          data: formData,
          success: function (response) {
            // $('#showsearch_data').html(response);
            // hidePreloader();
            if (response.trim() === '') {
              $('#showsearch_data').html('<p>No data found.</p>');
            } else {
              $('#showsearch_data').html(response);
            }  
          },
          error: function () {
            $('#search-results').html('<p>Error occurred. Please try again.</p>');
            hidePreloader();
          }
        });
      });

      $(document).on('click', '#clearfilter', function () {
          $('#searchform')[0].reset(); 
          $('#showsearch_data').empty(); 
      });
    });

   
    function showPreloader() {
      Pace.restart(); 
    }

    function hidePreloader() {
      Pace.stop(); // Hide preloader
    }


    // var tbl_subscriber = $('#tbl-subscriber').DataTable({
    //   "order": [[0, 'desc']]
    // });
    // $(document).ready(function () {
    //   $('#tbl-subscriber').DataTable({
    //     select: {
    //       style: 'multi', // Allow multiple row selection
    //       selector: 'td:first-child' // Enable row selection by clicking on the first cell
    //     },
    //     order: [[1, 'asc']], // Initial sorting
    //     paging: false, // Disable pagination
    //     scrollCollapse: true, // Allow the table to collapse when there's not enough space
    //     scrollX: true, // Enable horizontal scrolling
    //     scrollY: 500 // Fixed height for vertical scrolling
    //   });

    //   // Event listener to handle checkbox selection
    //   $('#tbl-subscriber').on('change', '.dt-select-checkbox', function () {
         
    //     var selectedUserIds = [];
    //     $('.dt-select-checkbox:checked').each(function () {
    //         selectedUserIds.push($(this).val());
    //     });
          
    //   });
    // });
    // $(document).ready(function () {
    //   var table = $('#tbl-subscriber').DataTable({
    //     select: {
    //         style: 'multi', // Allow multiple row selection
    //         selector: 'td:first-child' // Enable row selection by clicking on the first cell
    //     },
    //     order: [[1, 'asc']], // Initial sorting
    //     paging: false, // Disable pagination
    //     scrollCollapse: true, // Allow the table to collapse when there's not enough space
    //     scrollX: true, // Enable horizontal scrolling
    //     scrollY: 500 // Fixed height for vertical scrolling
    //   });

    //   // Event listener to handle checkbox selection
    //   $('#tbl-subscriber').on('change', '.dt-select-checkbox', function () {
    //     // Clear the search input field
    //     table.search('').draw();
    //   });

    //   // Event listener to handle checkbox click in table cell
    //   $('#tbl-subscriber').on('click', 'td', function (e) {
    //     var checkbox = $(this).find('.dt-select-checkbox');
    //       if (checkbox.length) {
    //         checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
    //       }
    //   });
    // });
   $(document).ready(function () {
      var table = $('#tbl-subscriber').DataTable({
        select: {
          style: 'multi'
        },
        order: [[1, 'asc']], // Initial sorting
        paging: false, // Disable pagination
        scrollCollapse: true, // Allow the table to collapse when there's not enough space
        scrollX: true, // Enable horizontal scrolling
        scrollY: 500 // Fixed height for vertical scrolling
      });

      // Variable to hold the timeout reference
      var searchClearTimeout;

      // Event listener to handle checkbox selection
      $('#tbl-subscriber').on('change', '.dt-select-checkbox', function (e) {
        // Prevent event propagation to the parent td
        e.stopPropagation();

        // Clear search input with a delay
        clearTimeout(searchClearTimeout);
        searchClearTimeout = setTimeout(function() {
          table.search('').draw();
        }, 500); // Adjust the delay time here (in milliseconds)
      });
    
      // Event listener to handle checkbox click in table cell
      $('#tbl-subscriber').on('click', 'td.dt-select', function (e) {
        var checkbox = $(this).find('.dt-select-checkbox');
        if (checkbox.length) {
          // Toggle checkbox without triggering row selection
          checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
          // Prevent event propagation to the checkbox
          e.stopPropagation();
        }
      });
    });
  </script>
</body>
</html>