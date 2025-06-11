
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Pending Redeem List | SHJ INTERNATIONAL</title>
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
      require('../database/Redeem.php');
      $object= new Redeem();
      $result=$object->getPendingredeem();
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
                <h4 class="mb-sm-0 font-size-18">Pending Redeem List</h4>

                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Redeem</a></li>
                    <li class="breadcrumb-item active">Pending Redeem List</li>
                  </ol>
                </div>

              </div>
            </div>
          </div>
          <div class="row justify-content-center " >
            <div class="col-md-8 col-lg-6 col-xl-12 ">
              <!-- <div class="text-center mb-4 mt-4">
               
                <i class="bx bx-list-ol"></i> <h4>Pending Redeem List</h4>
                
              </div> -->

             <!--  <div class="card chat-conversation" data-simplebar="init">
                <div class="card-body p-4">
                  <div class="p-3"> -->
                    <table class="table table-bordered" id="pending_redeem">
                      <thead>
                        <tr>
                          <th scope="col">Date</th>
                          <th scope="col">Agent Name</th>
                          <th scope="col">Customer Name</th>
                          <!-- <th scope="col">Contact No</th> -->
                          <th scope="col">Page Name</th>
                          <th scope="col">Game ID</th>
                          <th scope="col">Cash Tag</th>
                          <th scope="col">Amount</th>
                          <th scope="col">Tip</th>
                          <th scope="col">Add Back</th>
                          <th scope="col">Redeem Amount</th>
                          <th scope="col">Remarks</th>
                          <th scope="col">Status</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($result as $key => $value){ 
                            $redeem_amount=$value[15]-$value[22]-$value[23];
                            // echo "<pre>";
                            // print_r($value);
                            ?>
                            <tr>
                              <th scope="row"><?php echo $value[24];?></th>
                              <td><?php echo $value[25];?></td>
                              <td><?php echo $value[3];?></td>
                              <!-- <td><?php echo $value[21];?></td> -->
                              <td><?php echo $value[9];?></td>
                              <td><?php echo $value[6];?></td>
                              <td><?php echo $value[7];?></td>
                              <td><?php echo $value[15];?></td>
                              <td><?php echo $value[22];?></td>
                              <td><?php echo $value[23];?></td>
                              <td><?php echo $redeem_amount;?></td>
                              <td>
                                <?php if (!empty($value[13])): ?>
                                  <span data-id="<?php echo $value[0];?>" class="remarks-text" style="cursor:pointer;"><?php echo $value[13];?></span> / 
                                  <a class="btn btn-primary btn-sm view_remarks_log" data-id="<?php echo $value[0];?>" data-type="Comments Attachment">View</a>
                                  <?php else: ?>
                                  No remarks
                                <?php endif; ?>
                              </td>
                              <td><span class="text-success"><?php echo $value[27];?></span></td> 
                              

                            </tr>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="10" style="text-align:right">Total (All):</th>
                          <th></th> <!-- This will be populated by the footerCallback function -->
                        </tr>
                       
                      </tfoot>
                    </table>

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
   
  <!-- view remarks images modal start here   -->
  <div class="modal fade" id="viewremarks_mdl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 60%;">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title font-size-16" id="createticketLabel">View Remarks Images</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <div class="modal-body p-4">
           <!--  <ul class="list-unstyled mb-0" id="remarks_images">
       
        
            </ul> -->
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Images</th>
                  <th scope="col">Attachments</th>
                  <th scope="col">Date Time</th>
                </tr>
              </thead>
              <tbody id="rdm_remark_images">
           
              </tbody>
            </table>
        </div>  
      </div>
    </div>
  </div>
  <!-- end here -->
  <!-- view remarks details here -->
  <div class="modal fade" id="viewremarksdetails_mdl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-size-16" id="createticketLabel">View Remarks Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body p-4">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Remarks</th>
                <th scope="col">uname</th>
                <th scope="col">Date Time</th>
              </tr>
            </thead>
            <tbody id="rdm_remark_details">
         
            </tbody>
          </table>
            
        </div>
         
      </div>
    </div>
  </div>
  <!-- end here -->
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
  <script>
    $(document).ready(function () {
      var table = $('#pending_redeem').DataTable({
        "order": [[0, 'desc']],
        "footerCallback": function(row, data, start, end, display) {
          var api = this.api(), data;

          // Calculate total redeem amount of all records
          var totalRedeemAmountAll = api.column(9).data().reduce(function(a, b) {
              return parseFloat(a) + parseFloat(b);
          }, 0);

          // Calculate total redeem amount of filtered records
          var totalRedeemAmountFiltered = api.column(9, {page: 'current'}).data().reduce(function(a, b) {
              return parseFloat(a) + parseFloat(b);
          }, 0);

          // Update the footer
          $(api.column(0).footer()).html('Total Redeem Amount (All): ' + totalRedeemAmountAll.toFixed(2));
          $(api.column(9).footer()).html('Total Redeem Amount (Filtered): ' + totalRedeemAmountFiltered.toFixed(2));
        }
      });
      
      // Handle search event
      $('#search_keyword').on('click', function() {
          table.draw();
      });
    });

  </script>
</body>
</html>