
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
                            <th scope="col">Agent Name</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Page Name</th>
                            <th scope="col">Game ID</th>
                            <th scope="col">Remarks</th>
                            
                            <th scope="col">Status</th>
                            

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
  

  
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
  <script>
    $(document).ready(function () {
      var tableinstant=$('#pending_redeem_agent').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
        "url": "fetchpendingredeemagent.php",  // Corrected URL
        "method": "POST",
        "dataType":"json"
        },
        "columns": [
        { "data": "id","searchable": true },
       
        { "data": "record_time","searchable": true },
        
        { "data": "record_by","searchable": true },
        { "data": "cust_name","searchable": true },
       
        { "data": "page_name","searchable": true },
        { "data": "gid","searchable": true },
       
        { "data": "comment","searchable": true },
      
        { "data": "status" },

                
       
        ],
        "order": [[0, 'desc']], // Initial sorting


      });

    });
  </script>

</body>
</html>