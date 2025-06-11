
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Redeem Limit | SHJ INTERNATIONAL</title>
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
      
      $query = mysqli_query($connect, "SELECT addcustomer.id AS cust_id,name,pgid,redeem_limit,daily_limit,addcustomer.status,addedby,created_at,pages.pagename 
        FROM addcustomer
        JOIN pages
        ON pages.id=addcustomer.pgid
        WHERE approval=0
        AND pages.status='active'");
        if(mysqli_num_rows($query) > 0){
            while($row=mysqli_fetch_array($query)){
              // echo "<pre>";
              // print_r($row);
              // exit;
                $id               =$row['cust_id'];
                $name             =$row['name'];
                $redeem_limit     =$row['redeem_limit'];
                $redeem_daily_limit      =$row['daily_limit'];
                $pagename         =$row['pagename'];
                $addedby          =$row['addedby'];
                $status           =$row['status'];
                $created_at       =$row['created_at'];
               


                $html.='<tr>
                        <td>'.$id.'</td>
                        <td>'.$name.'</td>
                        <td>'.$pagename.'</td>
                        <td> <span class="badge rounded-pill bg-primary font-size-17">'.$redeem_limit.'</td>
                        <td> <span class="badge rounded-pill bg-danger font-size-17">'.$redeem_daily_limit.'</td>
                        <td>'.$addedby.'</td>
                        <td>'.$created_at.'</td>
                        <td> <span class="badge rounded-pill bg-primary font-size-17">'.$status.'</span></td>

                        <td>
                            <i class="btn btn-success update_redlimit" data-id="'.$id.'" style="cursor:pointer;">Update</i>
                        </td>
                </tr>';
                
            }
        }
             
       // save data start here
      if(isset($_POST['redlimitupdated']))
      {

      
        $id                 =$_POST['limitid'];
        $update_limit       =$_POST['update_limit'];
        $daily_limit        =$_POST['daily_limit'];
        $updated_at         =date('Y-m-d H:i:s');
        $uname              =$_POST['uname'];

        $query = mysqli_query($connect, "UPDATE addcustomer SET redeem_limit='$update_limit', daily_limit='$daily_limit', updated_at='$updated_at', updatedby='$uname'  WHERE id='$id'") or die(mysqli_error($connect));

        if ($query) {
        echo '<script>
              Swal.fire({
                  title: "Good job!",
                  text: "Updated Successfully!",
                  icon: "success",
              });
              setTimeout(function(){
                  document.querySelector(".swal2-container").remove();
              }, 1000);
              setTimeout(function(){
                  window.location.href = "redeem_limit.php";
              }, 1000);
            </script>';
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
                                       <table class="table table-bordered" id="redeemlimit_tbl">
                                            <thead>
                                                <tr>
                                                   <th scope="col">ID</th>
                                                  <th scope="col">Customer Name</th>
                                                  <th scope="col">Page Name</th>
                                                  <th scope="col">Monthly Limit</th>
                                                  <th scope="col">Daily Limit</th>
                                                  <th scope="col">Agent Name</th>
                                                  <th scope="col">Created At</th>
                                                  <th scope="col">Status</th>
                                                  <th scope="col">Updated By</th>
                                                  <th scope="col">Updated At</th>
                                                  <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              
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
    <div class="modal fade" id="updateredeemlimit_modl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form method="post" action="#">
                    <div class="modal-header">
                        <h5 class="modal-title font-size-16" id="createticketLabel">Update Limit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        
                        <div class="mb-3">
                          <label class="form-label" for="update_limit">Update Monthly Redeem Limit</label>
                          <div class="input-group mb-3 bg-light-subtle rounded-3">
                              <span class="input-group-text text-muted" id="basic-addon3">
                                  <i class="bx bx-dollar"></i>
                              </span>
                              <input type="number" name="update_limit" id="update_limit" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Redeem Limit"  required>
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="daily_limit">Update Daily Redeem Limit</label>
                          <div class="input-group mb-3 bg-light-subtle rounded-3">
                              <span class="input-group-text text-muted" id="basic-addon3">
                                  <i class="bx bx-dollar"></i>
                              </span>
                              <input type="number" name="daily_limit" id="daily_limit" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Redeem Limit" value="500" required>
                          </div>
                        </div>
                       
                        <input type="hidden" name="uid" value="<?php echo $uid;?>">
                        <input type="hidden" name="type" value="<?php echo $type;?>">
                        <input type="hidden" name="uname" value="<?php echo $uname;?>">
                        <input type="hidden" name="limitid" id="limitid">

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="redlimitupdated" id="">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
  <script>
    $(document).ready(function() {
      $('#redeemlimit_tbl').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [[0, 'desc']],
        "ajax": {
          "url": "fetch_customer_details.php",  // replace with the path to your PHP script
          "type": "POST",
          "dataSrc": function(json) {
            console.log(json); // Log the response for debugging
            return json.data;
          }
        },
        "columns": [
          { "data": "cust_id" },
          { "data": "name" },
          { "data": "pagename" },
          { "data": "redeem_limit",
            "createdCell": function(td, cellData, rowData, row, col) {
              $(td).html('<span class="badge rounded-pill bg-primary font-size-12">' + cellData + '</span>');
            }
          },
          { "data": "daily_limit",
            "createdCell": function(td, cellData, rowData, row, col) {
              $(td).html('<span class="badge rounded-pill bg-danger font-size-12">' + cellData + '</span>');
            }
          },
          { "data": "addedby" },
          { "data": "created_at" },
          { "data": "status",
            "createdCell": function(td, cellData, rowData, row, col) {
              $(td).html('<span class="badge rounded-pill bg-primary font-size-12">' + cellData + '</span>');
            }
          },
          { "data": "updatedby" },
          { "data": "updated_at" },
         
          {
              "data": "cust_id",
              "render": function(data, type, row, meta) {
                  return '<i class="btn btn-success update_redlimit" data-id="' + data + '" style="cursor:pointer;">Update</i>' +
                   '<i class="btn btn-danger del_cust_approval m-2" data-id="' + data + '" style="cursor:pointer;">Delete</i>';
              }

          }
        ]
      });

     $(document).on('click','.update_redlimit',function(){
        $('#updateredeemlimit_modl').modal('show');
        var id= $(this).data('id');
        $('#limitid').val(id);

      })
  });
    
  </script>
</body>
</html>