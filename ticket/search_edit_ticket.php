<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Edit Ticket | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
		<script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php include('topheader.php');

		require_once('../connect_me.php');
      	$database_connection = new Database_connection();
      	$connect = $database_connection->connect();
      	$user_list='';
		if(isset($_GET['tkt_id']) && $_GET['tkt_id']!=''){
			$tkt_id=$_GET['tkt_id'];
			// echo $_GET['tkt_id'];
			// exit;
			$query = mysqli_query($connect,"SELECT tkt_info.*,
				fullname,
				pages.pagename,
				tkt_assign.subscribers
	            FROM tkt_info
	            LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	            LEFT JOIN pages ON tkt_info.pg_id=pages.id 
	            LEFT JOIN user ON tkt_info.assigned_to = user.id
	            WHERE tkt_info.tkt_id ='$tkt_id'
	            GROUP BY tkt_assign.tkt_id; ")
			;
			if(mysqli_num_rows($query) > 0){
		        while($row=mysqli_fetch_array($query)){
		            // echo "<pre>";
		            // print_r($row);
		            // exit;
		            $subject 		=$row['subject'];
		            $departments 	=$row['departments'];
		            $priority 		=$row['priority'];
		            $status 		=$row['status'];
		            $tkt_type 		=$row['type'];
		            $assigned_to 	=$row['fullname'];
		            $ticket_number 	=$row['tkt_id'];
		            $deadline 		=$row['deadline'];
		            $progress 		=$row['progress'];
		            $pagename 		=$row['pagename'];
		            $pg_id 			=$row['pg_id'];

		            $subscribersIds = explode(',', $row['subscribers']);
		            $subscribersNames = array();
		            
		            // Fetch subscriber names based on their IDs
		            foreach ($subscribersIds as $subscriberId) {
		                $subscriberQuery = mysqli_query($connect, "SELECT fullname FROM user WHERE id = '$subscriberId'");
		                if ($subscriberQuery && mysqli_num_rows($subscriberQuery) > 0) {
		                    $subscriber = mysqli_fetch_assoc($subscriberQuery);
		                    $subscribersNames[] = $subscriber['fullname'];
		                    
		                   

		                }
		            }
		            if (!empty($subscribersNames)) {
		                
		                foreach ($subscribersNames as $subscriberName) {
		                    $user_list.='<li>'.$subscriberName.'</li>';
		                }
		            } 
		            else {
		                $user_list='No subscribers assigned.';
		            }


		        }
		    }
		}
		$output='';
		if(isset($_GET['tkt_id']) && $_GET['tkt_id']!=''){
			$tkt_id=$_GET['tkt_id'];
			// echo $_GET['tkt_id'];
			// exit;
			$query_assigned = mysqli_query($connect,"SELECT tkt_info.*,
				assigned_to.fullname as assigned_to_name,
				assigned_from.fullname as assigned_from_name, 
				tkt_assign.tkt_id as ticket_id,
				tkt_assign.subscribers as total_subscriber,
				tkt_assign.assigned_by as assigned_from,
				tkt_assign.assigned_to as assigned_user,
				tkt_assign.description as assigned_description,
				tkt_assign.departments as assigned_department,
				tkt_assign.created_at as assigned_date,
				tkt_assign.id as assigne_tbl_id,

				img_upload.catransid,
				COALESCE(GROUP_CONCAT(CASE WHEN img_upload.type = 'Ticket Attachment' THEN img_upload.path ELSE NULL END), '') AS ticket_images,
				img_upload.type,
				img_upload.createdat
	            FROM tkt_info 
	            LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	            LEFT JOIN user as assigned_to ON tkt_assign.assigned_to = assigned_to.id
	            LEFT JOIN user as assigned_from  ON tkt_assign.assigned_by = assigned_from.id
	            LEFT JOIN  img_upload ON img_upload.catransid=tkt_assign.id
	            WHERE tkt_info.tkt_id ='$tkt_id'
	            GROUP BY tkt_assign.id

				")
			;
			if(mysqli_num_rows($query_assigned) > 0){
		        while($row=mysqli_fetch_array($query_assigned)){
		        	$date = new DateTime($row['assigned_date']);
		        	$formatted_date = $date->format('D, M d ,Y h:i:s A');
		        	$total_subscriber=$row['total_subscriber'];
		            // echo "<pre>";
		            // print_r($row);
		            // exit;
		        	$images_html = '';

		            // If there are images associated with the ticket assignment
		            if (!empty($row['ticket_images'])) {
		                // Split the image paths into an array
		                $image_paths = explode(',', $row['ticket_images']);

		                // Iterate through each image path and create image tags
		                foreach ($image_paths as $image_path) {
		                    $images_html .= '<a href="upload/' . $image_path . '" target="_blank"><img src="upload/' . $image_path . '" alt="Ticket Attachment"  class="avatar-xl rounded"></a>';
		                }
		            }
		            else{
		            	$images_html='';
		            }
		            $output.='
		            	<p><strong>'.$row['assigned_from_name'].' said...</strong>
		            	<small class="text-muted float-end">'.$formatted_date.'</small>
		            	</p>
		            		
                        <div class="text-muted font-size-14">
                           
                            <blockquote class="p-4 border-light border rounded mb-4">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="bx bxs-quote-alt-left text-body font-size-24"></i>
                                    </div>
                                    <div>
                                        '.$row['assigned_description'].' 
                                        <div class="gap-2 hstack flex-wrap px-2">
                                           
                                        '.$images_html.'
                                        </div>
                                    </div>
                                </div>

                            </blockquote>
                            <p><strong>Transferred to: '.$row['assigned_to_name'].' [ '.$row['assigned_department'].' ]</strong> </p>
                        </div><hr>'
                    ;

		        }
		    }
		}

		?>
		<?php
			if(isset($_POST['save_changes'])){

		        
		        $tkt_id           =$_POST['tkt_id']; 
		        $description      =$_POST['description'];
		        $ticketreference  =$_POST['ticketreference'];
		        $page_id          =$_POST['pg_id'];
		        $departments      =$_POST['departments'];
		        $shift            =$_POST['tickettransferusershift'];
		        $assignedto       =$_POST['tickettransferuserid'];
		        $tkt_status 	  =$_POST['ticket_status'];
		        $followup         =$_POST['followup'];
		        $followupnotes    =$_POST['followupnotes'];
		        $uid              =$_POST['uid'];
		        $progress         =$_POST['progress'];
		        $created_at       =date('Y-m-d H:i:s');
		        $img_type         ='Ticket Attachment';
		        $oldsubscriber 	  = isset($_POST['total_subscriber']) && !empty($_POST['total_subscriber']) ? $_POST['total_subscriber'] : null;	
		        // echo "<pre>";
		        // print_r($_POST);
		        // exit;

		        $sql = mysqli_query($connect, "UPDATE tkt_info SET progress='$progress', status='$tkt_status', updated_at='$created_at' WHERE tkt_id='$tkt_id'") or die(mysqli_error($connect));

		        $sql_tkt_assign = mysqli_query($connect, "INSERT INTO tkt_assign (tkt_id, description, reference_tkt, pg_id, departments, shift, assigned_by, assigned_to, status, progress, subscribers, created_at) VALUES ('$tkt_id', '".mysqli_real_escape_string($connect, $description)."', '$ticketreference', '$page_id', '$departments', '$shift','$uid', '$assignedto','$tkt_status', '$progress', '$oldsubscriber', '$created_at')") or die(mysqli_error($connect));
		          if($sql_tkt_assign){
		          	$last_tkt_assign_id = mysqli_insert_id($connect);
            
		            $unique=uniqid();
		            if (!empty($_FILES['files_arry']['name'][0])) {
		              $filesCount = count($_FILES['files_arry']['name']);
		              
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
		                  text: "Saved Change successfully!",
		                  icon: "success",
		                }).then(() => {
		                    window.location.href = "' . $_SERVER['PHP_SELF'] . '?tkt_id='.$tkt_id.'";
		                  });
		              </script>';
		            exit();
		         
		          } 
		          else {
		            echo "Error inserting into tkt_info: " . mysqli_error($connect);
		          }
			        
		    }
		?>
		<?php 
			include('../sidebar.php');
 			include('rightsidebar.php');

 		?>
 		<div class="main-content">

	        <div class="page-content">
	            <div class="container-fluid">

	                <!-- start page title -->
	                <div class="row">
	                    <div class="col-12">
	                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
	                            <h4 class="mb-sm-0 font-size-18">Ticket Details <i class=" fas fa-arrow-alt-circle-right m-1"></i><a href="index.php">Ticket</a><i class=" fas fa-arrow-alt-circle-right m-1"></i> Ticket # <?php echo $ticket_number;?></h4>

	                            <div class="page-title-right">
	                                <ol class="breadcrumb m-0">
	                                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo $type; ?></a></li>
	                                    <li class="breadcrumb-item active">Ticket Details</li>
	                                </ol>
	                            </div>

	                        </div>
	                    </div>
	                </div>
	                <!-- end page title -->

	                <div class="row">
	                    <div class="col-lg-12">
	                        <div class="card">
	                        	<div class="card-header bg-primary font-size-24 text-white p-2">
								    <p><?php echo $subject;?> [ <?php echo $departments;?> ]</p>
								</div>
	                            <div class="card-body">
	                                <div class="">
	                                    <div class="mt-4" >
                                            

                                            <div>
                                                <div class="row p-2" style="border: 1px solid #ccc;">
                                                    <div class="col-lg-6 col-sm-6" >
                                                    	<h5 class="mb-3">Ticket Info: </h5>
                                                        <div>
                                                            <ul class="ps-4">
                                                                <li class="py-1"><strong> Subject:</strong> <?php echo $subject;?></li>
                                                                <li class="py-1"><strong> Priority:</strong> <?php echo $priority;?></li>
                                                                <li class="py-1"><strong> Status:</strong> <?php echo $status;?></li>
                                                                <li class="py-1"><strong> Type:</strong> <?php echo $tkt_type;?></li>
                                                                <li class="py-1"><strong> Assigned To:</strong> <?php echo $assigned_to;?></li>
                                                                <li class="py-1"><strong> Ticket Number:</strong> <?php echo $ticket_number;?></li>
                                                                <li class="py-1"><strong> Ticket Deadline:</strong> <?php echo $deadline;?></li>
                                                                <li class="py-1"><strong> Work Done:</strong> <?php echo $progress;?> %</li>
                                                                <li class="py-1"><strong> Page Name:</strong>
                                                                	<?php echo $pagename;?></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                   	<!--  <div class="col-lg-4 col-sm-6">
                                                        <div>
                                                            <ul class="ps-4">
                                                                
                                                            </ul>
                                                        </div>
                                                    </div> -->
                                                    <div class="col-lg-6 col-sm-6" style="border-left: 1px solid #ccc;height: fit-content;" >
                                                    	 <h5 class="mb-3">Subscribers: </h5>
                                                        <div>
                                                            <ul class="ps-4">
                                                                 
                                                                <?php echo $user_list;?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

	                                    <hr>

	                                    <div class="mt-4">
	                                    	
	                                    	<?php echo $output;?>
	                                       

	                                       
	                                    </div>
	                                </div>
	                            </div>
	                            <!-- end card body -->
	                        </div>
	                        <!-- end card -->
	                    </div>
	                    <!-- end col -->


	                </div> <!-- container-fluid -->
	            </div>
	            <!-- End Page-content -->

	            <?php include('footer.html');?>
	            
	        </div>
	        <!-- end main content-->

	    </div>

	</div>
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
</body>
</html>