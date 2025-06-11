
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Approval | SHJ INTERNATIONAL</title>
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
            $query = mysqli_query($connect, "SELECT id,cust_name,date,gid,ctid,page_name,amount,record_by,redeem_by,status FROM redeem WHERE approval=1");
            if(mysqli_num_rows($query) > 0){
                while($row=mysqli_fetch_array($query)){
                    $id            =$row['id'];
                    $cust_name     =$row['cust_name'];
                    $date          =$row['date'];
                    $gid           =$row['gid'];
                    $cid           =$row['ctid'];
                    $page_name     =$row['page_name'];
                    $amount        =$row['amount'];
                    $record_by     =$row['record_by'];
                    $redeem_by     =$row['redeem_by'];
                    $status        =$row['status'];
                   


                    $html.='<tr>
                            <td>'.$id.'</td>
                            <td>'.$cust_name.'</td>
                            <td>'.$date.'</td>
                            <td>'.$gid.'</td>
                            <td>'.$cid.'</td>
                            <td>'.$page_name.'</td>
                            <td>'.$amount.'</td>
                            <td>'.$record_by.'</td>
                            <td>'.$redeem_by.'</td>
                            <td> <span class="badge rounded-pill bg-success">'.$status.'</span></td>
                            <td>
                                <a class="edit_history" data-id="'.$id.'" style="cursor:pointer;">History</a>
                            </td>
                            <td>
                                <i class="btn btn-primary btn-sm red_approval" data-id="'.$id.'" style="cursor:pointer;">Approve</i>
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
                                                  <th scope="col">Date</th>
                                                  <th scope="col">Game ID</th>
                                                  <th scope="col">Cashtag</th>
                                                  <th scope="col">Page Name</th>
                                                  <th scope="col">Amount</th>
                                                  <th scope="col">Agent Name</th>
                                                  <th scope="col">Redeem Agent</th>
                                                  <th scope="col">Status</th>
                                                  <th scope="col">Edit History</th>
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
  <div class="modal fade" id="edithistory_mdl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title font-size-16" id="createticketLabel">View Edit History</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <div class="modal-body p-4">
            <!-- <ul class="list-unstyled mb-0" id="remarks_images">
       
        
            </ul> -->
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Field Name</th>
                  <th scope="col">Old Value</th>
                  <th scope="col">New Value</th>
                  <th scope="col">Edit By</th>
                  <th scope="col">Edit At</th>


                </tr>
              </thead>
              <tbody id="rdm_edit_history">
           
              </tbody>
            </table>
        </div>  
      </div>
    </div>
  </div>
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
</body>
</html>