
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
			require('../database/Pages.php');

			$object= new Pages();

			// $pages=$object->get_all_pages();
			$pages=$object->getPagesByIds($uid,$type);
		?>

		<!-- ========== Left Sidebar Start ========== -->
		<?php 
			include('../sidebar.php');
 			include('rightsidebar.php');
 			require("viewPendingRedeemImages.html");
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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Chat Support</a></li>
                    <li class="breadcrumb-item active">Paid Redeem List</li>
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
                      <table class="table table-bordered" id="paid_redeem_agent">
                        <thead>
                          <tr>
                            <th scope="col">Redeem ID</th>
                            <th scope="col">Informed Status</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Updated At</th>
                            <th scope="col">Agent Name</th>
                            <th scope="col">Customer Name</th>
                        <!--     <th scope="col">Contact No</th> -->
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
                            <th scope="col">View Details</th>

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
    <!-- paid redeem modal -->
    <div class="modal fade" id="paidredeemdetails" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
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
                  <th scope="col">Paid By</th>

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
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
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
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
  <script>
    $(document).ready(function () {
      var tableinstant=$('#paid_redeem_agent').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
        "url": "fetchpaidredeemagent.php",  // Corrected URL
        "method": "POST",
        "dataType":"json"
        },
        "columns": [
        { "data": "id","searchable": true },
       {
          "data": "inform_status",
          "render": function(data, type, row) {

              // if (data == 0) {
              //   return '<a href="#" class="cust_informaed btn btn-primary" data-type="Redeem Attachment" data-id="' + row.id + '">Pending</a>';
              // } 
              // else  {
              //  return '<p class="btn btn-success" title="'+row.informed_at+'">Informed</p>';
              // } 
              if (data == 0) {
                var bgClass = 'bg-primary text-white';  // Default class for Pending

                // Get the record time (assuming it's in column 'record_time')
                var recordTime = new Date(row.redeemed_date);  // Replace 'record_time' with the correct column key
                var currentTime = new Date();
                var diffInMinutes = Math.floor((currentTime - recordTime) / (1000 * 60)); // Difference in minutes
                var diffInHours = diffInMinutes / 60; // Difference in hours

                // Apply additional background class based on time difference
                if (diffInMinutes >= 30 && diffInHours < 3) { // 30 minutes to 2:59 hours
                    bgClass = 'bg-warning text-white';  // Yellow background
                } else if (diffInHours >= 3 && diffInHours < 12) { // 3 to 11:59 hours
                    bgClass = 'bg-info text-white';  // Blue background
                } else if (diffInHours >= 12) { // More than 12 hours
                    bgClass = 'bg-danger text-white';  // Red background
                }

                return '<a href="#" class="cust_informaed btn ' + bgClass + '" data-type="Redeem Attachment" data-id="' + row.id + '">Pending</a>';
              } 
              else {
                var message = "";
                if (row.pg_id == 1) {
                  message = 
                    
                    "Refunded: " + formatCurrency(row.amt_refund) + "\n" +
                    "Paid: " + formatCurrency(row.amt_paid) + "\n" +
                    "Added back: " + formatCurrency(row.combined_addback) + "\n\n" +
                    "𝗥𝗲𝗱𝗲𝗲𝗺 𝗰𝗼𝗺𝗽𝗹𝗲𝘁𝗲𝗱.\n\n" +
                    "If you like our services then kindly leave a comment / review on our page as well. Thank you! <3"
                  ;
                } else {
                  message = 
                    "I am happy to inform you that your redeem has been completed successfully\n" +
                    "Here is your redeem status:\n" +
                    "Refunded: " + formatCurrency(row.amt_refund) + "\n" +
                    "Paid: " + formatCurrency(row.amt_paid) + "\n" +
                    "𝐑𝐞𝐝𝐞𝐞𝐦 𝐂𝐨𝐦𝐩𝐥𝐞𝐭𝐞"
                  ;
                }

                return '<p class="btn btn-success" title="' + row.informed_at + '">Informed</p>' +
                               '<button class="btn btn-light copy_message" data-message="' + encodeURIComponent(message) + '">Copy</button>';

              } 
            }
        },
        { "data": "record_time","searchable": true },
        { "data": "redeemed_date","searchable": true },
        { "data": "record_by","searchable": true },
        { "data": "cust_name","searchable": true },
        { "data": "redeem_by","searchable": true },
        { "data": "page_name","searchable": true },
        { "data": "gid","searchable": true },
        { "data": "ctid","searchable": true },
        { "data": "comment","searchable": true },
        { "data": "paidbyclient","searchable": true },
        { "data": "clientname","searchable": true },
        { "data": "amount","searchable": true },
        { "data": "combined_tip","searchable": true },
        { "data": "combined_addback","searchable": true },
        { "data": "redeem_amount","searchable": true },
        { "data": "status" },

                
        { 
          "data": "view_images",
          "render": function(data, type, row) {
              
            return '<a href="#" class="view_image" data-type="Redeem Attachment" data-id="' + row.id + '">View Images</a>';
          }
        },
        { 
          "data": "view_details",
          "render": function(data, type, row) {
             
            return '<i class="btn btn-primary view_rdm_details" data-id="' + row.id + '" style="cursor:pointer;">View</i>';
          }
        }
        ],
        "order": [[0, 'desc']], // Initial sorting


      });

      // Event listener for the Copy button
      $(document).on('click', '.copy_message', function () {
          var message = decodeURIComponent($(this).data('message'));
          copyToClipboard(message);
          alert('Message copied to clipboard!');
      });

      // Function to format currency
      function formatCurrency(amount) {
          return  parseFloat(amount).toFixed(2);
      }

      // Function to copy text to clipboard
      function copyToClipboard(text) {
        var $temp = $("<textarea>");
        $("body").append($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();
      }

    });
  </script>
  <script>
    $(document).on('click','.cust_informaed',function(){
      var redid=$(this).data('id');
      // alert(redid);
      var status=1;
      $.ajax({
        url:"action.php",
        method:"POST",
        data:{
          action:'update_inform_status',
          redeemid:redid,
          inform_status:status
        },
        success:function(data){ 
          Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: data,
              timer: 20000, // 10 seconds
              showConfirmButton: false
          });
          window.location.reload();
              
        },
        error: function(jqXHR, textStatus, errorThrown) {
        console.error('AJAX Error:', textStatus, errorThrown);
        // Handle error scenario here
      }
      });
    })
  </script>
</body>
</html>