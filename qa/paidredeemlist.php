
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Paid Redeem List | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
		<?php include('topheader.php');?>
		<?php 
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
                <h4 class="mb-sm-0 font-size-18">Paid Redeem List</h4>

                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Redeem</a></li>
                    <li class="breadcrumb-item active">Paid Redeem List</li>
                  </ol>
                </div>

              </div>
            </div>
          </div>
          <div class="row justify-content-center " >
            <div class="col-lg-12">
             <!--  <div class="text-center mb-4 mt-4">
               
                <i class="bx bx-list-ol"></i> <h4>Paid Redeem List</h4>
                
              </div> -->

             <!--  <div class="card chat-conversation" data-simplebar="init">
                <div class="card-body p-4">
                  <div class="p-3"> -->
                  <div class="table-responsive">   
                    <table class="table table-bordered" id="paid_redeem">
                      <thead>
                        <tr>
                          <th scope="col">Redeem ID</th>
                          <th scope="col">Informed Status</th>
                          <th scope="col">Created At</th>
                          <th scope="col">Updated At</th>
                          <th scope="col">Agent Name</th>
                          <th scope="col">Customer Name</th>
                          <th scope="col">Redeem Paid By</th>
                          <th scope="col">Page Name</th>
                          <th scope="col">Game ID</th>
                          <th scope="col">Cash Tag</th>
                          <th scope="col">Remarks</th>
                          <th scope="col">Paid By Client</th>
                          <th scope="col">Client Name</th>
                          <th scope="col">Amount</th>
                          <th scope="col">Tip</th>
                          <th scope="col">Add Back</th>
                          <th scope="col">Redeem Amount</th>
                          <th scope="col">Status</th>
                          <th scope="col">View Images</th>
                          <th scope="col">Agent Images</th>
                          <th scope="col">View Details</th>


                        </tr>
                      </thead>
                      <tbody>
                          <!-- <tfoot>
                            <tr>
                              <th><input type="text" class="column_search" placeholder="Search Date"></th>
                              <th><input type="text" class="column_search" placeholder="Search Agent Name"></th>
                              <th><input type="text" class="column_search" placeholder="Search Customer Name"></th>
                              <th><input type="text" class="column_search" placeholder="Search Contact No"></th>
                              <th><input type="text" class="column_search" placeholder="Search Redeemed By"></th>
                              <th><input type="text" class="column_search" placeholder="Search Page Name"></th>
                              <th><input type="text" class="column_search" placeholder="Search Game ID"></th>
                              <th><input type="text" class="column_search" placeholder="Search Cash Tag"></th>
                              <th><input type="text" class="column_search" placeholder="Search Remarks"></th>
                              <th><input type="text" class="column_search" placeholder="Search Paid By Client"></th>
                              <th><input type="text" class="column_search" placeholder="Search Client Name"></th>
                              <th><input type="text" class="column_search" placeholder="Search Amount"></th>
                              <th><input type="text" class="column_search" placeholder="Search Tip"></th>
                              <th><input type="text" class="column_search" placeholder="Search Add Back"></th>
                              <th><input type="text" class="column_search" placeholder="Search Redeem Amount"></th>
                              <th><input type="text" class="column_search" placeholder="Search Status"></th>
                              <th><input type="text" class="column_search" placeholder="Search View Images"></th>
                              <th><input type="text" class="column_search" placeholder="Search View Details"></th>
                            </tr>
                          </tfoot> -->
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
  <!-- paid redeem modal -->
  <div class="modal fade" id="paidredeemdetails" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-size-16" id="createticketLabel">View Redeem Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body p-4">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Pay Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Time</th>
                <th scope="col">Status</th>
                <th scope="col">Paid From</th>
                <th scope="col">Comments</th>

              </tr>
            </thead>
            <tbody id="rdm_details">
         
            </tbody>
          </table>
            
        </div>
         
      </div>
    </div>
  </div>
  <!-- end paid redeem modal -->

  <!-- paid redeem modal -->
  <div class="modal fade" id="viewredeemimages" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 60%;">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title font-size-16" id="createticketLabel">View Redeem Images</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
        </div>
        <div class="modal-body p-4">
            <ul class="list-unstyled mb-0" id="images_display">
       
        
            </ul>
        </div>  
      </div>
    </div>
  </div>

  <!-- end paid redeem modal -->
  <div class="modal fade" id="updateredeemdatamdl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true"  data-bs-backdrop="static" style="display:none;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-size-16" id="createticketLabel">Update Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body p-4">
          <form method="post"id="update_paidredeemfrm">
            <div class="mb-4" >
              <label for="add_comment" class="form-label">Comments</label>
              <textarea  class="form-control" name="add_comment" id="add_comment" style="resize: none;"></textarea>
            </div>
            <div class="mb-4">
              <label for="pasteimages" class="form-label">Upload Images </label>
              <textarea class="form-control demo demo-textarea" placeholder="Paste your images here" style="resize: none;" id="pasteimages" disabled></textarea>
              <input type="hidden" class="hdn_imagedata" name='hdn_imagedata' id='hdn_imagedata'>
               
            </div>
            <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>">
            <input type="hidden" name="uname" id="uname" value="<?php echo $uname;?>">
            <input type="hidden" name="viewredmid" class="viewredmid">
          
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="update_btn" id="updatepaidredeem_frm">Update</button>
            </div>
          </form>
        </div>
         
      </div>
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
            <!-- <ul class="list-unstyled mb-0" id="remarks_images">
       
        
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
    $(document).ready(function ()
    {
      var role='<?php echo $type;?>';
      // alert(type);
      $('#paid_redeem thead th').each(function () {
          var title = $(this).text();
          $(this).html(title+' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
      });
        
      var table = $('#paid_redeem').DataTable({
        "scrollX": true,
        "pagingType": "numbers",
        "processing": true,
        "serverSide": true,
        dom: '<"top"lfB>rt<"bottom"ip><"clear">',
        "ajax": "fetch_paid_redeem.php",
        order: [[2, 'desc']],
        buttons: ["copy","print", "excel", "pdf", "colvis"],
        columnDefs: [
          {
            "targets": 16,  
            "render": function(data, type, row) {
              
              var amount = parseFloat(row[13] || 0);  
              var tip = parseFloat(row[14] || 0);     
              var addback = parseFloat(row[15] || 0); 
              var redeemAmount = amount - tip - addback;

             
              return '<span>' + redeemAmount.toFixed(2) + '</span>';  
            }
          },
          {
         
            "targets": 18, 
            "render": function(data, type, row) {
              return '<a href="#" class="view_image" data-id="' + row[0] + '" data-pgid="' + row[8] + '" data-type="Redeem Attachment">View Images</a>';
            }
          },
          {
         
            "targets": 19, 
            "render": function(data, type, row) {
              return '<a href="#" class="view_image" data-id="' + row[0] + '" data-pgid="' + row[8] + '" data-type="CSR Redeem Attachmen">View Images</a>';
            }
          },
          {
             
            "targets": 20,
            "render": function(data, type, row) {
              return '<i class="bx bx-show-alt view_rdm_details" data-id="' + row[0] + '" data-pgid="' + row[8] + '" style="cursor:pointer;"></i>';
            }
          },
          {
            "targets": 1,
            "render": function(data, type, row) {
                // if (data == 0) {
                //   return '<p class="btn btn-primary" >Pending</p>';
                // } 
                // else  {
                //   return '<p class="btn btn-success" title="'+ row[21]+'">Informed</p>';
                // } 
                var statusText = '';
                var bgClass = '';

                // Determine the default status text and class
                if (data == 0) {
                  statusText = 'Pending';
                  bgClass = 'bg-primary text-white';  // Default class for Pending
                

                  // Get the record time (assuming it's in column 2) and calculate the time difference
                  var recordTime = new Date(row[3]);  // Adjust the index if record_time is in a different column
                  var currentTime = new Date();
                  var diffInMinutes = Math.floor((currentTime - recordTime) / (1000 * 60)); // Difference in minutes

                  // Apply additional background class based on time difference
                  if (diffInMinutes >= 30 && diffInMinutes <= 180) {
                      bgClass = 'bg-warning text-dark';  // Yellow background
                  } else if (diffInMinutes > 180 && diffInMinutes <= 660) { // 3 to 11 hours
                      bgClass = 'bg-info text-white';  // Blue background with white text
                  } else if (diffInMinutes > 660) { // More than 11 hours
                      bgClass = 'bg-danger text-white';  // Red background with white text
                  }
                }
                else {
                  statusText = 'Informed';
                  bgClass = 'bg-success text-white';  // Default class for Informed
                }

                // Return the status with the applied background class
                return '<p class="btn ' + bgClass + '" title="'+ row[21]+'">' + statusText + '</p>'; 
                  
              
            }
          },
          {
            "targets": 10,
            "render": function(data, type, row) {
              var remarksHtml = '';
              
              if (row[10] && row[10].trim() !== '') {
                  remarksHtml = '<span data-id="' + row[0] + '" class="remarks-text" style="cursor:pointer;">' + row[10] + '</span> / ' +
                                '<a class="btn btn-primary btn-sm view_remarks_log" data-id="' + row[0] + '" data-type="Comments Attachment">View</a>';
              } else {
                  remarksHtml = 'No remarks';
              }


              return remarksHtml ;
            }
          },
          {
            targets: "_all",
            orderable: true
          }
        ]
      });
      table.columns().every(function () {
        var table = this;
        $('input', this.header()).on('keyup change', function () {
            if (table.search() !== this.value) {
                 table.search(this.value).draw();
            }
        });
      });
    });

  </script>
</body>
</html>