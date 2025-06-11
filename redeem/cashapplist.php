
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>CashApp List | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
    <style>
      .selected-row {

        background-color: rgba(135, 138, 197, 0.29);
      }
    </style>
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
      require('../database/Cashapp.php');

      require('../database/Pages.php');

      $object= new Pages();
      $pages=$object->getPagesByIds($uid,$type);

      $object= new Cashapp();

      $cashapp=$object->get_all_cashapp();
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
                <h4 class="mb-sm-0 font-size-18">CashApp List</h4>

                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Redeem</a></li>
                    <li class="breadcrumb-item active">CashApp List</li>
                  </ol>
                </div>

              </div>
            </div>
          </div>
          <div class="d-lg-flex">
            <div class="chat-leftsidebar card">
              <div class="p-3">
               
                <div class="search-box position-relative">
                  <input type="text" id="cashapp_search" class="form-control bg-light" placeholder="Search ....." aria-label="Search ...." aria-describedby="basic-addon1">
                  <i class="bx bx-search search-icon"></i>
                </div>
              </div>

              <div class="chat-leftsidebar-nav">
                  
                <div class="tab-content">
                  <div class="tab-pane show active" id="chat">
                    <div class="chat-message-list" data-simplebar>
                      <div class="pt-3">
                        <div class="px-3">
                          <h5 class="font-size-14 mb-3">List</h5>

                        </div>
                        <ul class="list-unstyled chat-list" id="sidecashapp_list">
                          <?php
                           
                          if(count($pages) > 0)
                          {
                            foreach($pages as $key => $page)
                            {
                              // if($page[5]=='closed'){
                              //   $class='class="bg-danger-subtle"';  
                              // }
                              // else{
                              //   $class='class=""';
                              // }
                              
                              echo '
                                <li class="unread">
                                    <a href="#" class="select_cashapp" data-id="'.$page['id'].'" data-name="'.$page['pagename'].'">
                                        <div class="d-flex">                            
                                           
                    
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-15 mb-1">'.$page['pagename'].'</h5>
                                               <p class="chat-user-message text-truncate mb-0">'.$page['status'].'</p> 
                                            </div>
                                            <div class="font-size-16">
                                            <span class="badge badge-soft-danger rounded-pill">'.$page['clientname'].'</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>'
                              ;
                            }
                          }
                        ?>
                      </ul>
                      </div>
                    </div>
                  </div>

                   
                </div>
              </div>

            </div>
            <!-- end chat-leftsidebar -->

            <div class="user-chat w-100 overflow-hidden" id="cashapp_area" style="display: none;">
              <div class="card">
                
              
                <div class="d-lg-flex">

                  <div class="w-100 overflow-hidden position-relative">
                    <div class="p-3 p-lg-4 border-bottom user-chat-topbar">
                      <div class="row align-items-center">
                        <div class="col-sm-4 col-8">
                          <div class="d-flex align-items-center">
                            <div class="d-block d-lg-none me-2 ms-0">
                              <a href="javascript: void(0);" class="user-chat-remove text-muted font-size-16 p-2">
                                  <i class="ri-arrow-left-s-line"></i>
                              </a>
                            </div>
                            <div class="me-3 ms-0">
                              <!-- <img src="../assets/images/users/noimage.png" class="rounded-circle avatar-xs user-avtar" alt=""> -->
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                              <h5 class="font-size-16 mb-0 text-truncate">
                                <a href="#" class="text-reset user-profile-show" id="cashapp_name"></a> 
                                <input type="hidden" id="hdn_cashappid" name="hdn_cashappid">
                                <input type="hidden" id="hdn_cashappname" name="hdn_cashappname">
                                  <!-- <input type="hidden" id="hdn_department" name="hdn_department"> -->

                              </h5>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-8 col-4">
                          <ul class="list-inline user-chat-nav text-end mb-0">                                        
                                
                            <li class="list-inline-item">
                              <div class="dropdown">
                                <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="bx bx-dots-horizontal-rounded"></i>
                                </button>
                                <!-- <div class="dropdown-menu dropdown-menu-end">
                                   
                                  <a class="dropdown-item" href="#" id="" data-bs-toggle="modal" data-bs-target="#updatecashtag">Edit <i class="ri-edit-box-line float-end text-muted"></i></a>
                                   
                                </div> -->
                              </div>
                            </li>                                        
                          </ul>                                    
                        </div>
                      </div>
                    </div>
                        
                    <div class="chat-conversation p-3 p-lg-3" data-simplebar="init" id="cashapp_div">
                      <ul class="list-unstyled mb-0" id="cashapp_details_display">
                              

                                
                      </ul>
                                    
                    </div>
                       
                  </div>
                 
                </div>
              </div>
            </div>

            <!-- end user chat -->
          </div>      
        </div>
      </div>
      <?php include('footer.html');?> 
		</div>

	</div>
  <div class="modal fade" id="updatecashtag" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-size-16" id="createticketLabel">Update Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body">
          <form method="post" enctype="multipart/form-data" id="updatecashappfrm">
            <!-- <h5 class="text-truncate">Update Cashtag Status</h5> -->
            <div class="mb-4">
              <label for="pasteimages" class="form-label">Balance </label>
                                
              <input type="number" name="cashtag_balance" id="cashtag_balance" class="form-control" placeholder="Enter Balance..." required>
            </div>
            <div class="mb-4">
              <label for="pasteimages" class="form-label">Remarks </label>
                                
              <select class="form-control" name="cashtag_remarks" id="cashtag_remarks" required>
                <option value="">Select One</option>
                <option value="limit up">Limit Up</option>
                <option value="low balance">Low Balance</option>
                <!-- <option value="verification">Verification</option> -->
              </select>
            </div>
            <div class="mb-4">
              <label for="pasteimages" class="form-label">Status </label>
                                
              <select class="form-control" name="cashtag_status" id="cashtag_status" required>
                <option value="">Select One</option>
                <option value="closed">Closed</option>
                <option value="active">Active</option>
                <option value="verification">Verification</option>
              </select>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="cashtag_id" id="cashtag_id">
              <input type="hidden" name="pgid" id="pg_id">
              <button type="submit" class="btn btn-primary" name="updatecashtapp" id="updatecashtapp">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
  <script>
    
    $(document).ready(function(){
      $(document).on('click', '.cashappupdate-mdl', function(e){
        $('#updatecashtag').modal('show');
        var cashtppid   =$(this).data('id');
        var pgid        =$(this).data('pgid');
        $('#cashtag_id').val( cashtppid);
        $('#pg_id').val( pgid);

      });
      $('#updatecashappfrm').on('submit', function(e) {
        e.preventDefault();

        var cashtag_balance =$('#cashtag_balance').val();
        var cashtag_id      =$('#cashtag_id').val();
        var status          =$('#cashtag_status').val();
        var remarks         =$('#cashtag_remarks').val();
        var pgid            =$('#pg_id').val();

        // Validate required fields
        if(cashtag_balance === '' || status === '' || remarks === '') {
          alert("All fields are required.");
          return;
        }
        // alert(status);
        
        $.ajax({
          url: 'action.php', 
          type: 'POST', 
          data: { 
            cashtag_id: cashtag_id,
            cashtag_balance: cashtag_balance,
            status: status,
            remarks: remarks,
            pgid:pgid,
            action:'updatecashtagstatus'
          }, 
          success: function(response) {
            response = JSON.parse(response);
            // alert(response.status);
            if (response.status === 'success') {
              alert(response.message);
              $('#updatecashtag').modal('hide');
              $('#updatecashappfrm')[0].reset();
              fetchAndUpdateTableData(response.page_id);
            }
            else {
              alert(response.message || 'Failed to update CashApp status.');
            }
            // window.location.reload();
             
          },
          error: function(xhr, status, error) {
            console.log("AJAX error: ", xhr.responseText);
            alert('An error occurred while processing your request.');
          }
        });
      });

      function fetchAndUpdateTableData(pageid) {
        $.ajax({
            url:"fetch_pending_redeem.php",
            method:"POST",
            data:{
                action:'fetch_cashapp_totals',
                pageid:pageid
            },
            success:function(data)
            {

              $('#cashapp_details_display').html(data);
            },
            error: function(xhr, status, error) {
              console.log("AJAX error in fetchAndUpdateTableData: ", xhr.responseText);
            }
        });
      }
    })


  </script>
</body>
</html>