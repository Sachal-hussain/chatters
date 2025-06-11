
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Pending Redeem List | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
    <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php include('topheader.php');?>


		<!-- ========== Left Sidebar Start ========== -->
		<?php 
			include('../sidebar.php');
 			include('rightsidebar.php');
    ?>  
 		<?php
    	require_once('../connect_me.php');
     
      $database_connection = new Database_connection();
      $connect = $database_connection->connect();

      if (isset($_POST['c2cadded'])) {

        $created_at     = date('Y-m-d H:i:s');
        $c2camount      = $_POST['c2camount'];
        $uname          = $_POST['uname'];
        $pgid           = $_POST['pgid'];
        $redid          = $_POST['redmid'];
        
        $stmt = $connect->prepare("INSERT INTO c2ctags (`redid`, `pgid`, `amount`, `addedby`, `created_at`) 
                                  VALUES (?, ?, ?, ?, ?)");

        if ($stmt === false) {
          die('Prepare failed: ' . htmlspecialchars($connect->error));
        }

        $stmt->bind_param('iisss', $redid, $pgid, $c2camount, $uname, $created_at);

        if ($stmt->execute()) {
          echo '<script>
                  Swal.fire({
                      title: "Good job!",
                      text: "Added Successfully!",
                      icon: "success",
                  });
                  setTimeout(function(){
                      document.querySelector(".swal2-container").remove();
                  }, 1000);
                  setTimeout(function(){
                      window.location.href = "c2ctags.php";
                  }, 1000);
                </script>';
          exit();
        } 
        else {
          echo '<script>
                  Swal.fire({
                      title: "Error",
                      text: "Unable to insert data.",
                      icon: "error",
                  });
                </script>';
        }

        $stmt->close();
      }
 		?>

		<div class="main-content">
			<div class="page-content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Pending Redeem List</h4>

                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Chat Support</a></li>
                    <li class="breadcrumb-item active">Pending Redeem List</li>
                  </ol>
                </div>

              </div>
            </div>
          </div>
          <div class="row justify-content-center " >
            <div class="col-md-8 col-lg-6 col-xl-12 ">
              <!-- <div class="text-center mb-4 mt-4">
               
                <i class=" bx bx-list-ol"></i> <h4>Paid Redeem List</h4>
                
              </div> -->

              <!-- <div class="card chat-conversation" data-simplebar="init">
                <div class="card-body p-4">
                  <div class="p-3"> -->
                    <div class="table-responsive">
                      <table class="table table-bordered" id="pending_redeem_agent">
                        <thead>
                          <tr>
                            <th scope="col">Redeem ID</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Agent</th>
                            <th scope="col">Page</th>
                            <th scope="col">Customer / Tag</th>
                            <th scope="col">Game ID</th>
                            <th scope="col">Redeem Amount</th>
                            <th scope="col">Paid </th>
                            <th scope="col">Remaining </th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            

                          </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>

                      </table>
                    </div>

                  <!-- </div>
                </div>
              </div> -->

            </div>
          </div>
        </div>
      </div>
      <?php include('footer.html');?>
		</div>

	</div>
  
  <div class="modal fade" id="c2ctags_mdl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true"  data-bs-backdrop="static" style="display:none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-size-16" id="createticketLabel">Update Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body p-4">
          <form method="post" id="">
            <div class="mb-4">
              <label for="c2camount" class="form-label">Amount</label>
              <input type="number" name="c2camount" id="c2camount" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter amount..." aria-label="Enter amount..." aria-describedby="basic-addon3" required> 
            </div>
            <!-- <div class="mb-4">
              <label for="c2ccutomer" class="form-label">Customer Status</label>
              <select name="c2ccutomer" id="c2ccutomer" class="form-control c2ccutomer" required>
                <option value="active">active</option>
                <option value="inactive">inactive</option>
             </select> 
            </div> -->

            <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>">
            <input type="hidden" name="uname" id="uname" value="<?php echo $uname;?>">
            <input type="hidden" name="pgid" id="pgid">
            <input type="hidden" name="redmid" class="redmid">
          
            <div class="modal-footer">
              <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="c2cadded" id="c2cadded">Add</button>
            </div>
          </form>
        </div>
         
      </div>
    </div>
  </div> 

 <div class="modal fade" id="c2cdetails_mdl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-size-16" id="createticketLabel">View Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body p-4">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Amount</th>
                <th scope="col">Added By</th>
                <th scope="col">Date Time</th>
                <th scope="col">Action</th>

              </tr>
            </thead>
            <tbody id="c2c_details">
       
            </tbody>
          </table>
            
        </div> 
      </div>
    </div>
  </div>

  
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
  <script>
    $(document).ready(function () {
      var usertype ='<?php echo $type;?>';

      var tableinstant = $('#pending_redeem_agent').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 50,
        "ajax": {
          "url": "fetchpendingc2c.php",  // Corrected URL
          "method": "POST",
          "dataType": "json"
        },
        "columns": [
          { "data": "redid", "searchable": true },
          { "data": "record_time", "searchable": true },
          { "data": "record_by", "searchable": true },
          { "data": "page_name", "searchable": true },
          {
            "data": null,
            "searchable": true,
            "render": function (data, type, row) {
              return `${row.cust_name} ( ${row.ctid})`;
            }
          },
          { "data": "gid", "searchable": true },
          { "data": "red_amoun", "searchable": true },
          { "data": "c2camount", "searchable": true },
          {
            "data": null,
            "searchable": true,
            "render": function (data, type, row) {
              return (row.red_amoun - row.c2camount).toFixed(2);
            }
          },
          { "data": "red_status" },
          {
            "data": null,
            "searchable": true,
            "render": function (data, type, row) {
              // Calculate the remaining amount
              var remainingAmount = (row.red_amoun - row.c2camount).toFixed(2);
                
              if ((remainingAmount == 0) && (usertype == 'Manager' || usertype == 'Webmaster')) {
                return '<i class="btn btn-danger btn-view" data-id="' + row.redid + '" data-pgid="' + row.pg_id + '" data-c2cid="' + row.c2cid + '" style="cursor:pointer;">View Details</i>';  
              } 
              else if (remainingAmount > 0) {
                return '<i class="btn btn-primary btn-action" data-id="' + row.redid + '" data-pgid="' + row.pg_id + '" data-c2cid="' + row.c2cid + '" style="cursor:pointer;">Action</i>';
              }
              else {
                return '';
              }
            }
          },
        ],
        "order": [[0, 'desc']], // Initial sorting
      });
    });

    $(document).on('click','.btn-action',function(){
      $('#c2ctags_mdl').modal('show');
      var rdmid   = $(this).data('id');
      var pgid    = $(this).data('pgid');
      $('.redmid').val(rdmid);
      $('#pgid').val(pgid);
    })

    $(document).on('click','.btn-view',function(){
      
      $('#c2cdetails_mdl').modal('show');
      
      var rdmid   = $(this).data('id');
      var pgid    = $(this).data('pgid');
      var c2cid   = $(this).data('c2cid');
      $('.redmid').val(rdmid);
      $('#pgid').val(pgid);

     $.ajax({
        url: 'action.php',
        type: 'POST',
        data: { 
          pgid: pgid,
          rdmid:rdmid,
          action: 'c2cdetails'
        },
        success: function(response) {
           
          $('#c2c_details').html(response);
          
        },
        error: function(xhr, status, error) {
          console.error('Error with AJAX request: ', error);
        }
      });
      
    })

    $(document).on('click', '.deleteC2c', function() {
      var c2cid = $(this).data('id');

      // Show confirmation dialog
      var confirmDelete = confirm("Are you sure you want to delete this record?");
      
      if (confirmDelete) {
       
        $.ajax({
            url: 'action.php', // Your server-side script to handle deletion
            type: 'POST',
            data: { 
              id: c2cid,
              action:'deletec2c' 
            },
            success: function(response) {
                
              alert(response);
              // Optionally, refresh the table or remove the row from the DOM
              location.reload(); // Reload the page or implement table refresh logic
                
            },
            error: function(xhr, status, error) {
              alert("An error occurred: " + error);
            }
        });
      }
    });

  </script>

</body>
</html>