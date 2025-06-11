
<!DOCTYPE html>
<html>
  <head>
  	<meta charset="utf-8" />
    <title>Reports| SHJ INTERNATIONAL</title>
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

        require('../database/Pages.php');


        $object= new Pages();

        $pages=$object->getPagesReport();
  		?>

  		<!-- ========== Left Sidebar Start ========== -->
  		<?php 
  			include('../sidebar.php');
   			include('rightsidebar.php');
   		?>

  		<div class="main-content">
  			<div class="page-content">
          <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
              <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                  <h4 class="mb-sm-0 font-size-18">Reports</h4>

                  <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                      <li class="breadcrumb-item active">Reports</li>
                    </ol>
                  </div>

                </div>
              </div>
            </div>
            <!-- end page title -->

            <div class="d-lg-flex">
              <div class="chat-leftsidebar card">
                <div class="p-3">
                  <div class="search-box position-relative">
                      <input type="text" id="page_search_report" class="form-control bg-light" placeholder="Search ....." aria-label="Search ...." aria-describedby="basic-addon1">
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
                          <ul class="list-unstyled chat-list" id="sidepages_list">
                            <?php
                        
                              if(count($pages) > 0)
                              {
                                foreach($pages as $key => $page)
                                {
                                echo '
                                  <li class="unread">
                                    <a href="#" class="select_page_report" data-id="'.$page[0].'" data-name="'.$page[1].'">
                                      <div class="d-flex">      
                                        <div class="flex-grow-1 overflow-hidden">
                                          <h5 class="text-truncate font-size-15 mb-1">'.$page[1].'</h5>
                                          <p class="chat-user-message text-truncate mb-0">'.$page[3].'</p> 
                                        </div>
                                        <div class="unread-message">
                                          <span class="badge badge-soft-danger rounded-pill"></span>
                                        </div>
                                      </div>
                                    </a>
                                  </li>';
                          
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
              <div class="user-chat w-100 overflow-hidden" id="paid_redeem_area_report" style="display: none;">
                <div class="d-lg-flex">
                 

                  <!-- start redeem section -->
                  <div class="w-100 overflow-hidden position-relative">
                    <!-- <div class="alert alert-danger" id="alert-delete" style="display:none;"> -->
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
                                <a href="#" class="text-reset user-profile-show" id="page_name_report"></a> 
                                <input type="hidden" id="hdn_pageid_report" name="hdn_pageid_report">
                                <input type="hidden" id="hdn_pagename_report" name="hdn_pagename_report">
                                <!-- <input type="hidden" id="hdn_department" name="hdn_department"> -->

                              </h5>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end redeem head -->
                    <label for="start_datetime">Start Date Time:</label>
                    <input type="text" id="start_datetime" placeholder="Select Start Date Time">

                    <label for="end_datetime">End Date Time:</label>
                    <input type="text" id="end_datetime" placeholder="Select End Date Time">
                    <label for="status">Select Status:</label>
                    <select id="rdmstatus">
                      <option value="Paid">Paid</option>
                      <option value="Pending">Pending</option>
                    </select>
                    <button id="downloadCSV" class="btn btn-primary">Download as CSV</button>
                    <!-- start pending redeem list -->
                    <div class="chat-conversation p-3 p-lg-3" data-simplebar="init" id="paid_redeem_report_div">
                      <ul class="list-unstyled mb-0" id="redeem_details_display_report">
                        <table class="table table-striped" id="rdm_table">
                          <thead >
                            <tr>
                              <th scope="col">Date Time</th>
                              <th scope="col">Agent Name</th>
                              <th scope="col">Page Name</th>
                              <th scope="col">Page Reference</th>
                              <th scope="col">Payment Method</th>
                              <th scope="col">Game ID</th>
                              <!-- <th scope="col">Cash Tag</th> -->
                              <th scope="col">Amount</th>
                              <th scope="col">Status</th>
                             <!--  <th scope="col">Add Back</th>
                              <th scope="col">Added Back (R)</th>
                              <th scope="col">Refunded (R)</th>
                              <th scope="col">Paid (R)</th>
                              <th scope="col">Tip (R)</th>
                              <th scope="col">Remaining Redeem Amount</th> -->
                              <!-- <th scope="col">Comments</th>
                              <th scope="col">Manager Comments</th> -->
                             
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="6" style="text-align:right"></th>
                              <th></th>
                            </tr>
                          </tfoot>
                        </table>  
                      </ul>    
                    </div>
                
                  </div>
                    
                </div>
              </div>
            </div>
            
          </div>
          
  		  </div>
        <?php include('footer.html');?>
  	 </div>
    </div>
   
   
  	<div class="rightbar-overlay"></div>

  	<?php include('footer_links.html');?>
 
  </body>
</html>