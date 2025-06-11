
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Deposit History | SHJ INTERNATIONAL</title>
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
                <h4 class="mb-sm-0 font-size-18">Deposit History</h4>

                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Chat Support</a></li>
                    <li class="breadcrumb-item active">Deposit History</li>
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
                <div class="card-body p-4"> -->
                  <div class="p-3">
                    <table class="table table-bordered table-responsive" id="depositHistory" style="width: 100%">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Page Name</th>
                          <th scope="col">Game ID</th>
                          <th scope="col">Amount</th>
                          <th scope="col">Bonus</th>
                          <th scope="col">User</th>
                          <th scope="col">Created At</th>

                        </tr>
                      </thead>
                      <tbody>
                          
                      </tbody>

                    </table>

                  </div>
               <!--  </div>
              </div> -->

            </div>
          </div>
        </div>
      </div>
      <?php include('footer.html');?>
		</div>

	</div>
   
  <!-- end paid redeem modal -->
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
  <script>
    $(document).ready(function () {
      var tableinstant=$('#depositHistory').DataTable({
        "processing": true,
        "serverSide": true,
        "paging": true, // Disable pagination
        "ordering": true,
        "info": true, // Disable table information
        "searching": true,
        scrollX: true,
        "lengthMenu": [ [10], [10] ],   
        "ajax": {
        "url": "fetch_deposits_details.php",  // Corrected URL
        "method": "POST",
        "dataType":"json"
        },
        "columns": [
          { "data": "id" },
          { "data": "pagename" },
          { "data": "gm_id" },
          { "data": "amount" },
          { "data": "bonus" },
          { "data": "uname" },
          { "data": "created_at" }
            
        ],
        "order": [[0, 'desc']], // Initial sorting


      });

    });
  </script>
</body>
</html>