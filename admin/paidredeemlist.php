
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
            <div class="col-md-8 col-lg-6 col-xl-12 ">
             <!--  <div class="text-center mb-4 mt-4">
               
                <i class="bx bx-list-ol"></i> <h4>Paid Redeem List</h4>
                
              </div> -->

              <!-- <div class="card chat-conversation" data-simplebar="init">
                <div class="card-body p-4">
                  <div class="p-3"> -->
                    <table class="table table-bordered" id="paid_redeem">
                      <thead>
                        <tr>
                          <th scope="col">Redeem ID</th>   <!-- 0 -->
                          <th scope="col">Created At</th>  <!-- 1 -->
                          <th scope="col">Updated At</th>   <!-- 2 -->
                          <th scope="col">Agent Name</th>   <!-- 3 -->
                          <th scope="col">Customer Name</th>  <!-- 4 -->
                          <th scope="col">Contact No</th>     <!-- 5 -->
                          <th scope="col">Redeem Paid By</th> <!-- 6 -->
                          <th scope="col">Page Name</th>      <!-- 7 -->
                          <th scope="col">Redeem For</th>     <!-- 8 -->
                          <th scope="col">Redeem From</th>    <!-- 9 -->
                          <th scope="col">Game ID</th>        <!-- 10 -->
                          <th scope="col">Cash Tag</th>     <!-- 11 -->
                          <th scope="col">Remarks</th>      <!-- 12 -->
                          <th scope="col">Paid By Client</th> <!-- 13 -->
                          <th scope="col">Client Name</th>  <!-- 14-->
                          <th scope="col">Amount</th>     <!-- 15-->
                          <th scope="col">Refunded</th> <!-- 16-->
                          <th scope="col">Paid</th>     <!-- 17-->
                          <th scope="col">Tip</th>      <!-- 18 -->
                          <th scope="col">Add Back</th>   <!-- 19 -->
                          <th scope="col">Redeem Amount</th> <!-- 20-->
                          <th scope="col">Status</th>  <!-- 21-->
                          <th scope="col">View Images</th>  <!-- 22 -->
                          <th scope="col">Agent Images</th> <!-- 23 -->
                          <th scope="col">View Details</th> <!-- 24 -->
                          <th scope="col">Action</th>       <!-- 25 -->


                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                      <tfoot>
                       <tr>
                          <th scope="col">Redeem ID</th>   <!-- 0 -->
                          <th scope="col">Created At</th>  <!-- 1 -->
                          <th scope="col">Updated At</th>   <!-- 2 -->
                          <th scope="col">Agent Name</th>   <!-- 3 -->
                          <th scope="col">Customer Name</th>  <!-- 4 -->
                          <th scope="col">Contact No</th>     <!--  -->
                          <th scope="col">Redeem Paid By</th> <!-- 5 -->
                          <th scope="col">Page Name</th>      <!-- 6 -->
                          <th scope="col">Redeem For</th>     <!-- 7 -->
                          <th scope="col">Redeem From</th>    <!-- 8 -->
                          <th scope="col">Game ID</th>        <!-- 9 -->
                          <th scope="col">Cash Tag</th>     <!-- 10 -->
                          <th scope="col">Remarks</th>      <!-- 11 -->
                          <th scope="col">Paid By Client</th> <!-- 12 -->
                          <th scope="col">Client Name</th>  <!-- 13-->
                          <th scope="col">Amount</th>     <!-- 14-->
                          <th scope="col">Refunded</th> <!-- 15-->
                          <th scope="col">Paid</th>     <!-- 16-->
                          <th scope="col">Tip</th>      <!-- 17 -->
                          <th scope="col">Add Back</th>   <!-- 18 -->
                          <th scope="col">Redeem Amount</th> <!-- 19-->
                          <th scope="col">Status</th>  <!-- 20-->
                          <th scope="col">View Images</th>  <!-- 21 -->
                          <th scope="col">Agent Images</th> <!-- 22 -->
                          <th scope="col">View Details</th> <!-- 23 -->
                          <th scope="col">Action</th>       <!-- 24 -->


                        </tr>
                      </tfoot>

                    </table>
                  <!-- 
                  </div>
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
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
  <script>
    $(document).ready(function ()
    {
      var role='<?php echo $type;?>';
      var department='<?php echo $department;?>';
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
        // lengthChange: !1,
        // dom: 'Bfrtip',
        "ajax": "fetch_paid_redeem.php",
        order: [[1, 'desc']],
        // buttons: ["copy", "excel", "pdf", "colvis"],

        columnDefs: [
          {
            "targets": 20,  
            "render": function(data, type, row) {
              
              var amount = parseFloat(row[15] || 0);  
              var tip = parseFloat(row[18] || 0);     
              var addback = parseFloat(row[19] || 0); 
              var redeemAmount = amount - tip - addback;

             
              return '<span>' + redeemAmount.toFixed(2) + '</span>';  
            }
          },
          {
       
            "targets": 22, 
            "render": function(data, type, row) {
                return '<a href="#" class="view_image" data-id="' + row[0] + '" data-pgid="' + row[8] + '" data-type="Redeem Attachment">View Images</a>';
            }
          },
            {
       
                "targets": 23, 
                "render": function(data, type, row) {
                    return '<a href="#" class="view_image" data-id="' + row[0] + '" data-pgid="' + row[8] + '" data-type="CSR Redeem Attachmen">View Images</a>';
                }
            },
          {
           
            "targets": 24,
            "render": function(data, type, row) {
                return '<i class="bx bx-show-alt view_rdm_details" data-id="' + row[0] + '" data-pgid="' + row[8] + '" style="cursor:pointer;"></i>';
            }
          },
             {
               
                "targets": 25,
                "render": function(data, type, row) {
                    if(role =='Manager' || role =='Webmaster'){

                        return '<i class="bx bx-edit update_data" data-id="' + row[0] + '" data-pgid="' + row[8] + '" style="cursor:pointer;"></i>';
                    }
                    else{
                        return '';
                    }

                }
            },
          {
              targets: "_all",
              orderable: true
          }
        ],
        // Add footer callback function
        footerCallback: function(row, data, start, end, display) {
          var api = this.api();
          // Total each column
          var amounts = api.column(15, {page: 'current'}).data().reduce(function(a, b) {
              return parseFloat(a) + parseFloat(b);
          }, 0);

          var refunds = api.column(16, {page: 'current'}).data().reduce(function(a, b) {
              return parseFloat(a) + parseFloat(b);
          }, 0);

          var paids = api.column(17, {page: 'current'}).data().reduce(function(a, b) {
              return parseFloat(a) + parseFloat(b);
          }, 0);

          var tips = api.column(18, {page: 'current'}).data().reduce(function(a, b) {
              return parseFloat(a) + parseFloat(b);
          }, 0);

          var addedbacks = api.column(19, {page: 'current'}).data().reduce(function(a, b) {
              return parseFloat(a) + parseFloat(b);
          }, 0);

          // Update the footer HTML with totals
          $(api.column(15).footer()).html('Total: ' + amounts.toFixed(2));
          $(api.column(16).footer()).html('Total: ' + refunds.toFixed(2));
          $(api.column(17).footer()).html('Total: ' + paids.toFixed(2));
          $(api.column(18).footer()).html('Total: ' + tips.toFixed(2));
          $(api.column(19).footer()).html('Total: ' + addedbacks.toFixed(2));
           
        }
      });
      // Add buttons and style select element
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