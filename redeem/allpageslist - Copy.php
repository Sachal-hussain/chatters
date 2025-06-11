
<!DOCTYPE html>
<html>
  <head>
  	<meta charset="utf-8" />
    <title>All Pages List | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
    <style>
      
      .arrow-icon {
        cursor: pointer;
        position: absolute;
        top: 50%;
        right: -20px; /* Adjust based on your design */
        transform: translateY(-50%);
        border: 1px solid #ddd;
        border-radius: 50%;
        padding: 5px;
        color: #fff;
        z-index: 10;

      }

      #sidebarContent {
        transition: transform 0.3s ease;
      }

      .hidden-sidebar {
        transform: translateX(-106%);
      }

      .arrow-icon i {
        transition: transform 0.3s ease;
      }

      .arrow-icon .rotate {
        transform: rotate(180deg);
      }

      #rightsidedive {
        transition: transform 0.3s ease;
       
      }

      #rightsidedive.show {
        transform: translateX(-365px); /* Adjust according to the width of the div */
        width: 2000px;
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
  			require('../database/Redeem.php');

        require('../database/Pages.php');


        $object= new Pages();
        $pages=$object->getPagesByIds($uid,$type);
        // $pages=$object->get_all_pages();
        $count=$object->getRemainingRedeemCount();

        require_once('../connect_me.php');
        $database_connection = new Database_connection();
        $connect = $database_connection->connect();
        $day_off='';
        $query = mysqli_query($connect, "SELECT * FROM emp_schedule
            WHERE uid='$uid';
                ");
        if(mysqli_num_rows($query) > 0){
            while($row=mysqli_fetch_array($query)){
                $id=$row['id'];
                $offday=$row['offday'];
                $day_off.='<h3 class="">Name: '.$fname.' - Shift: '.$shift.' - Off day will be on: '.$offday.'</h3>';
              
            }
        }
  		?>
      <?php
      $comments='';
      // $defaultComment = 'Verified / Completed';
        $query = mysqli_query($connect, "SELECT * FROM redeem_comments ORDER BY comments ASC
          ");
          if(mysqli_num_rows($query) > 0){
            while($row=mysqli_fetch_array($query)){
              $id=$row['id'];
              $comment=$row['comments'];
              // $selected = ($comment == $defaultComment) ? 'selected' : '';
              $comments .= '<option value="' . htmlspecialchars($comment) . '">' . htmlspecialchars($comment) . '</option>';
              
            }
          }
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
            <!-- start page title -->
            <div class="row">
              <div class="col-12">
                <marquee scrollamount="5" direction="left">
                    
                  <?php echo $day_off;?>
                        
                </marquee>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                  <h4 class="mb-sm-0 font-size-18">All Pages</h4>

                  <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item"><a href="javascript: void(0);">Redeem</a></li>
                      <li class="breadcrumb-item active">All Pages</li>
                    </ol>
                  </div>

                </div>
              </div>
            </div> -->
            <!-- end page title -->
            <div class="row justify-content-center " >
              <div class="col-md-8 col-lg-6 col-xl-12 ">
                
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                  <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#pageswise_list" id="pageswise" role="tab" aria-selected="false" tabindex="-1">
                      <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                      <span class="d-none d-sm-block">Pages Wise List</span> 
                    </a>
                  </li>
                  <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#allpages_list" id="allpageslist" role="tab" aria-selected="false" tabindex="-1">
                      <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                      <span class="d-none d-sm-block">All Pages List</span> 
                    </a>
                  </li>

                </ul>
                <div class="tab-content p-3 text-muted">
                  <div class="tab-pane active show" id="pageswise_list" role="tabpanel">
                    <div class="d-lg-flex">
                      <div class="chat-leftsidebar card" id="sidebarContent">
                        <div class="p-3">
                          <p class="bg-success text-white">Total Remaining Redeem: <?php echo $count;?></p>
                          <div class="search-box position-relative">
                              <input type="text" id="page_search" class="form-control bg-light" placeholder="Search ....." aria-label="Search ...." aria-describedby="basic-addon1">
                              <i class="bx bx-search search-icon"></i>
                          </div>
                          <div class="arrow-icon bg-success" id="toggleSidebar">
                            <i class="bx bx-chevron-left"></i>
                          </div>
                        </div>

                        <div class="chat-leftsidebar-nav" >
                            
                          <div class="tab-content">
                            <div class="tab-pane show active" id="chat">
                              <div class="chat-message-list" data-simplebar>
                                <div class="pt-3">
                                  <div class="px-3">
                                    <h5 class="font-size-14 mb-3">List</h5>

                                  </div>
                                  <ul class="list-unstyled chat-list" id="sidepage_list">
                                    <?php
                                    
                                      if(count($pages) > 0)
                                      {
                                        foreach($pages as $key => $page)
                                        {

                                        echo '
                                          <li class="unread">
                                              <a href="#" class="select_page" data-id="'.$page['id'].'" data-name="'.$page['pagename'].'" data-clientpage="'.$page['clientname'].'">
                                                  <div class="d-flex">                            
                                                     
                              
                                                      <div class="flex-grow-1 overflow-hidden">
                                                          <h5 class="text-truncate font-size-15 mb-1">'.$page['pagename'].'</h5>
                                                         <p class="chat-user-message text-truncate mb-0">'.$page['status'].'</p> 
                                                      </div>
                                                      <div class="unread-message">
                                                          <span class="badge badge-soft-danger rounded-pill">'.$page['pending_redeem_count'].'</span>
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
                        <!-- end chat-leftsidebar -->

                      <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1 " id="pending_redeem_area" style="display: none;">
                        <div class="alert alert-danger" id="alert-delete" style="display:none;">
                                       
                        </div>
                        <div class="card" id="rightsidedive">
                          <div class="p-3 px-lg-4 border-bottom">
                            <div class="row">
                              <div class="col-xl-4 col-7">
                                <div class="d-flex align-items-center">
                                    
                                  <div class="flex-grow-1">
                                      <h5 class="font-size-14 mb-1 text-truncate">
                                        <a href="#" class="text-dark user-profile-show" id="page_name"></a>
                                        <input type="hidden" id="hdn_pageid" name="hdn_pageid">
                                        <input type="hidden" id="hdn_pagename" name="hdn_pagename">
                                      </h5>
                                      <!-- <p class="text-muted text-truncate mb-0">Online</p> -->
                                  </div>
                                </div>
                              </div>
                              <div class="col-xl-8 col-5">
                                                    
                              </div>
                            </div>
                          </div>

                          <div class="chat-conversation p-3 px-2" id="redeem_div" data-simplebar >
                            <ul class="list-unstyled mb-0" id="redeem_details_display">
                              
                            </ul>
                          </div>
                        </div>
                      </div>
                      <!-- end user chat -->
                    </div>
                  </div>
                  <div class="tab-pane" id="allpages_list" role="tabpanel">
                    <div class="row">
                      <div class="col-12">
                        <div class="card">
                          
                          <div class="card-body table-responsive">

                            <table class="table table-sm table-bordered" id="tbl_allpendingredeem">
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
                                  <th scope="col">Added Back (R)</th>
                                  <th scope="col">Refunded (R)</th>
                                  <th scope="col">Paid (R)</th>
                                  <th scope="col">Tip (R)</th>
                                  <th scope="col">Remaining Redeem Amount</th>
                                  <th scope="col">Remarks</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Action</th>
                                  
                                </tr>
                              </thead>
                              <tbody>
                                
                              </tbody>
                               
                            </table>

                          </div>
                        </div>
                      </div> <!-- end col -->
                    </div>
                  </div>
                </div>
            <!-- End d-lg-flex  -->
          </div>
          
  		  </div>
        <?php include('footer.html');?>
  	 </div>
    </div>
    <div class="modal fade " id="paidredeemform" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" style="display:none;">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-size-16" id="createticketLabel">View Redeem Status</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body p-4">
            <p>Redeem By: <span class="mb-4 agentname" id="agentname"></span> | Remaining Redeem Amount: <span class="mb-4" id="amount"></span> | Game Id: <span class="mb-4 gm_id"></span> | Cashtag: <span class="mb-4 cashtg"></span></p><hr>
            <input type="hidden" name="hidden_redeemed_amount" id="hidden_redeemed_amount">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#page-cashtag" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Page Cashtag</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#all-cashtag" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">All Cashtag</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#comments-section" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Comments</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-addedback-tab" data-bs-toggle="pill" data-bs-target="#addedback-section" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Added Back</button>
              </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="page-cashtag" role="tabpanel" aria-labelledby="pills-home-tab">
                <form method="post" enctype="multipart/form-data" id="redeempaidfrm" action="update_redeem_fields.php">
                  <div class="mb-4">
                    <label for="cashtag" class="form-label">Cash Tag</label>
                    <select class="form-control clientcashtag_dropdown" id="cashtag" name="cashtags">

                    </select>
                  </div>
                  <div class="mb-4">
                    <label for="cashtag" class="form-label">Redeem For (Page Client Name)</label>
                    <input type="text" class="form-control redeemfor" name="redeemfor" id="redeemfor" readonly>
                  </div>
                  <div class="mb-4">
                    <label for="redeemfrom" class="form-label">Redeem From (Other Page Client Name)</label>
                    <!-- <input type="text" class="form-control redeemfrom" name="redeemfrom" id="redeemfrom" placeholder="Enter Name.."> -->

                    <select class="form-control redeemfrom"  name="redeemfrom" id="redeemfrom" required>

                    </select>
                  </div>
                  <div class="mb-4">
                    <label for="paidbyclient" class="form-label">Paid By Client </label>
                    <select class="form-control custom-select" data-action="client_list" name="paidbyclient" id="paidbyclient">
                      <option value="No">No</option>
                      <option value="Yes">Yes</option>
                    </select>
                  </div>

                  <div class="mb-4 clientlist" style="display: none;">
                    <label for="clientname" class="form-label">Client Name </label>
                    <select class="form-control clientname" data-action="another_action" name="clientname" id="clientname">
                    </select>
                  </div>                            
                  <div class="mb-4" id="actions_container">
                  </div>
                  <button type="button" class="btn btn-secondary mb-4" id="add_action" style="display: none;">Add Action</button>
                  <!-- <label for="tkt_content" class="form-label">Content</label>
                 
                   <input type="hidden" name="tkt_content_hidden" id="tkt_content_hidden"> -->
                  <div class="mb-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" name="status" id="statuss" style="display: block !important;">
                      <!-- <option value="Pending">Select Status</option> -->
                      <option value="Pending">Pending</option>
                      <option value="Paid">Paid</option>
                     <!--  <option value="Cancel">Cancel</option>
                      <option value="Verified">Verified</option>
                      <option value="Verified">Unverified</option>
                      <option value="Verified">Held</option> -->
                    </select>
                  </div>

                  <div class="mb-4" id="div_staff">
                   <label for="comment" class="form-label">Comments</label>
                   <!-- <textarea  class="form-control fetch_comment" name="comment" id="comment" style="resize: none;"></textarea> -->
                   <select class="form-control comment-dropdown"  name="comment" id="comment1" required>
                    <option value="">Select a comment</option>
                    <?php echo $comments;?>
                    <option value="custom">Add your own comment</option>
                    </select>
                    <input type="text" class="form-control mt-2 custom-comment-input d-none" name="custom_comment" id="custom_comment1" placeholder="Enter your own comment" />
                  </div>

                  <div class="mb-4">
                    <label for="pasteimages" class="form-label">Upload Images </label>
                    <textarea class="form-control demo demo-textarea" placeholder="Paste your images here" style="resize: none;" id="pasteimages" disabled></textarea>
                    <input type="hidden" class="hdn_imagedata" name='hdn_imagedata' id='hdn_imagedata'>

                  </div>
                   <input type="hidden" id="action_count" name="action_count" value="1">
                   <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>">
                   <input type="hidden" name="uname" id="uname" value="<?php echo $uname;?>">
                   <input type="hidden" name="redmid" id="redmid" class="redmid">
                   <input type="hidden" name="pgid" id="pgid" class="pgid">


                   <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="paid_redeem_frm" id="savepaidredeem">Save</button>
                  </div>

                </form>
              </div>
              <!-- /////// other pages -->
              <div class="tab-pane fade" id="all-cashtag" role="tabpanel" aria-labelledby="pills-profile-tab">
                <form method="post" enctype="multipart/form-data" id="all_redeempaidfrm" action="update_redeem_fields_all.php">
                  <div class="mb-4">
                    <label for="allcashtags" class="form-label">All Cash Tag</label>
                    <select class="form-control" id="allcashtags" name="allcashtags">

                    </select>
                  </div>
                  <div class="mb-4">
                    <label for="redeemfor" class="form-label">Redeem For (Page Client Name)</label>
                    <input type="text" class="form-control redeemfor" name="redeemfor" id="redeemfor" readonly>
                  </div>
                  <div class="mb-4">
                    <label for="redeemfrom" class="form-label">Redeem From (Other Page Client Name)</label>
                    <!-- <input type="text" class="form-control redeemfrom" name="redeemfrom" id="redeemfrom" placeholder="Enter Name.."> -->
                    <select class="form-control redeemfrom"  name="redeemfrom" id="redeemfrom" required>

                    </select>
                  </div>
                  <div class="mb-4">
                    <label for="paidbyclient" class="form-label">Paid By Client </label>
                    <select class="form-control custom-select" data-action="client_list" name="paidbyclient" id="paidbyclient">
                      <option value="No">No</option>
                      <option value="Yes">Yes</option>
                    </select>
                  </div>

                  <div class="mb-4 clientlist" style="display: none;">
                    <label for="clientname" class="form-label">Client Name </label>
                    <select class="form-control clientname" data-action="another_action" name="clientname" id="clientname">
                    </select>
                  </div>

                  <div class="mb-4" id="all_actions_container">
                  </div>
                  <button type="button" class="btn btn-secondary mb-4 " id="all_add_action" style="display:none;">Add Action</button>
                    <!-- <label for="tkt_content" class="form-label">Content</label>
                   
                     <input type="hidden" name="tkt_content_hidden" id="tkt_content_hidden"> -->
                     <div class="mb-4">
                       <label for="status" class="form-label">Status</label>
                       <select class="form-control" name="status" id="statuss" style="display: block !important;">
                        <!-- <option value="Pending">Select Status</option> -->
                        <option value="Pending">Pending</option>
                        <option value="Paid">Paid</option>
                       <!--  <option value="Cancel">Cancel</option>
                        <option value="Verified">Verified</option>
                        <option value="Verified">Unverified</option>
                        <option value="Verified">Held</option> -->


                      </select>
                    </div>

                    <!-- <div class="mb-4" id="div_staff">
                     <label for="comment" class="form-label">Comments</label>
                     <textarea  class="form-control fetch_comment" name="comment" id="comment" style="resize: none;"></textarea>
                   </div> -->
                   <div class="mb-4" id="div_staff">
                   <label for="comment" class="form-label">Comments</label>
                   <!-- <textarea  class="form-control fetch_comment" name="comment" id="comment" style="resize: none;"></textarea> -->
                   <select class="form-control comment-dropdown"  name="comment" id="comment2" required>
                    <option value="">Select a comment</option>
                    <?php echo $comments;?>
                    <option value="custom">Add your own comment</option>
                    </select>
                    <input type="text" class="form-control mt-2 custom-comment-input d-none" name="custom_comment" id="custom_comment2" placeholder="Enter your own comment" />
                    </div>

                   <div class="mb-4">
                     <label for="pasteimages" class="form-label">Upload Images </label>
                     <textarea class="form-control demo demo-textarea" placeholder="Paste your images here" style="resize: none;" id="pasteimages" disabled></textarea>
                     <input type="hidden" class="hdn_imagedata" name='hdn_imagedata' id='hdn_imagedata'>

                   </div>
                   <input type="hidden" id="all_action_count" name="all_action_count" value="1">
                   <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>">
                   <input type="hidden" name="uname" id="uname" value="<?php echo $uname;?>">
                   <input type="hidden" name="redmid" id="redmid" class="redmid">
                   <input type="hidden" name="pgid" id="pgid" class="pgid">


                   <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="paid_redeem_frm" id="savepaidredeem">Save</button>
                  </div>

                </form>
              </div>
              <!-- comments sections -->
              <div class="tab-pane fade" id="comments-section" role="tabpanel" aria-labelledby="pills-profile-tab">
                <form method="post" enctype="multipart/form-data" id="comments_redeempaidfrm" action="update_redeem_fields.php">

                  <!-- <div class="mb-4" id="div_staff">
                   <label for="comment" class="form-label">Comments</label>
                   <textarea  class="form-control fetch_comment" name="single-comment" id="comment" required></textarea>
                  </div> -->
                  <div class="mb-4" id="div_staff">
                   <label for="comment" class="form-label">Comments</label>
                   <!-- <textarea  class="form-control fetch_comment" name="comment" id="comment" style="resize: none;"></textarea> -->
                   <select class="form-control comment-dropdown"  name="single-comment" id="comment3" required>
                    <option value="">Select a comment</option>
                    <?php echo $comments;?>
                    <option value="custom">Add your own comment</option>
                    </select>
                    <input type="text" class="form-control mt-2 custom-comment-input d-none" name="custom_comment" id="custom_comment3" placeholder="Enter your own comment" />
                  </div>
                  <div class="mb-4">
                    <label for="pasteimages" class="form-label">Upload Images </label>
                    <textarea class="form-control cmnt cmnt-textarea" placeholder="Paste your images here" style="resize: none;" id="pasteimages" disabled required></textarea>
                    <input type="hidden" class="hdn_cmntimagedata" name='hdn_cmntimagedata' id='hdn_cmntimagedata'>

                  </div>
                  <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>">
                  <input type="hidden" name="uname" id="uname" value="<?php echo $uname;?>">
                  <input type="hidden" name="redmid" id="redmid" class="redmid">
                  <input type="hidden" name="pgid" id="pgid" class="pgid">
                  <input type="hidden" name="frmaction_type" id="frmaction_type" value="singlecomment">

                  <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submit_comment" id="submit_comment">Save</button>
                  </div>

                </form>
              </div>
              <!-- added back section -->
              <div class="tab-pane fade" id="addedback-section" role="tabpanel" aria-labelledby="pills-profile-tab">
                <form method="post" enctype="multipart/form-data" id="comments_redeempaidfrm" action="update_redeem_fields.php">

                  <!-- <div class="mb-4" id="div_staff">
                   <label for="comment" class="form-label">Comments</label>
                   <textarea  class="form-control fetch_comment" name="single-comment" id="comment" required></textarea>
                  </div> -->
                  <div class="mb-4" id="div_staff">
                   <label for="comment" class="form-label">Add Back</label>
                   <!-- <textarea  class="form-control fetch_comment" name="comment" id="comment" style="resize: none;"></textarea> -->
                   <input type="number" name="addedback_redeemamount" id="addedback_redeemamount" class="form-control" placeholder="Added Back Amount" required>
                   
                  </div>
                  <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>">
                  <input type="hidden" name="uname" id="uname" value="<?php echo $uname;?>">
                  <input type="hidden" name="redmid" id="redmid" class="redmid">
                  <input type="hidden" name="pgid" id="pgid" class="pgid">
                  <input type="hidden" name="frmaction_type" id="frmaction_type" value="addback">


                  <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submit_addback" id="submit_addback">Save</button>
                  </div>

                </form>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>

    <!-- end paid redeem modal -->

    <!-- paid redeem modal -->
    <div class="modal fade" id="viewredeemform" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="createticketLabel" aria-hidden="true" style="display:none;">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-size-16" id="createticketLabel">View Redeem Status</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body p-4">
            <p>Redeem By: <span class="mb-4" id="viewagentname"></span> | Redeem Amount: <span class="mb-4" id="viewamount"></span></p><hr>
            <form method="post" id="update_redeemfrm" action="update_redeem_fields.php">
              <div class="mb-4">
                <label for="cust_name" class="form-label">Customer Name</label>
                <input type="text" name="cust_name" id="cust_name" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Customer Name" aria-describedby="basic-addon3" >
              </div>
              <div class="mb-4">
                <label for="gameid" class="form-label">Game ID</label>
                <input type="text" name="gameid" id="gameid" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Game ID" aria-describedby="basic-addon3" >
              </div>
              <div class="mb-4">
                <label for="updatecashtag" class="form-label">Cash Tag</label>
                <input type="text" name="updatecashtag" id="updatecashtag" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Cash Tag" aria-describedby="basic-addon3" >
              </div>
              <div class="mb-4">
                <label for="redamount" class="form-label">Amount</label>
                <input type="text" name="redamount" id="redamount" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Amount" aria-label="Enter Game ID" aria-describedby="basic-addon3" readonly>
              </div>

              <div class="mb-4">
                <label for="update_add_back" class="form-label">Add Back</label>
                <input type="text" name="update_add_back" id="update_add_back" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Add Back" aria-label="Enter Game ID" aria-describedby="basic-addon3">
              </div>

                <div class="mb-4">
                  <label for="update_tip" class="form-label">Tip </label>
                  <input type="text" name="update_tip" id="update_tip" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Tip" aria-label="Enter Game ID" aria-describedby="basic-addon3">
                   
                </div>
                <div class="mb-4">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-control" name="status" id="statuss" >
                    <!-- <option value="Pending">Select Status</option> -->
                    <option value="Pending">Pending</option>
                    <option value="Paid">Paid</option>
                    <!--  <option value="Cancel">Cancel</option>
                    <option value="Verified">Verified</option>
                    <option value="Verified">Unverified</option>
                    <option value="Verified">Held</option> -->
                  </select>
                </div>
                <div class="mb-4" >
                   <label for="update_comment" class="form-label">Comments</label>
                    <textarea  class="form-control" name="update_comment" id="update_comment" style="resize: none;"></textarea>
                </div>

                <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>">
                <input type="hidden" name="uname" id="uname" value="<?php echo $uname;?>">
                <input type="hidden" name="viewredmid" id="viewredmid">
                <input type="hidden" name="pageid" id="updatepageid">
                <input type="hidden" name="updateredeemvalues" value="updatebysuperuser">
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="update_red_btn" id="updateredeemfields">Update</button>
                </div>
            </form>
          </div>
               
        </div>
      </div>
    </div>

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

  <!-- all pages list modal -->
  <div class="modal fade " id="allpages_paidredeemform" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" style="display:none;" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-size-16" id="createticketLabel">View Redeem Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <div class="modal-body p-4">
          <p>Redeem By: <span class="mb-4 agentname" id="agentname"></span> | Remaining Redeem Amount: <span class="mb-4" id="allpagesamount"></span> | Game Id: <span class="mb-4 gm_id"></span> | Cashtag: <span class="mb-4 cashtg"></span></p><hr>
          <input type="hidden" name="hidden_redeemed_amount" id="hidden_redeemed_amount">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#allpagespage-cashtag" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Page Cashtag</button>
            </li>
            
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-contact" data-bs-toggle="pill" data-bs-target="#allpagescomments-section" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Comments</button>
            </li>
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="allpagespage-cashtag" role="tabpanel" aria-labelledby="pills-home-tab">
              <form method="post" enctype="multipart/form-data" id="allpagesredeempaidfrm" action="update_redeem_fields.php">
                <div class="mb-4">
                  <label for="cashtag" class="form-label">Cash Tag</label>
                  <select class="form-control allpagesclientcashtag_dropdown" id="allpagescashtag" name="cashtags">

                  </select>
                </div>
                <div class="mb-4">
                  <label for="cashtag" class="form-label">Redeem For (Page Client Name)</label>
                  <input type="text" class="form-control redeemfor" name="redeemfor" id="redeemfor" readonly>
                </div>
                <div class="mb-4">
                  <label for="redeemfrom" class="form-label">Redeem From (Other Page Client Name)</label>
                  <!-- <input type="text" class="form-control redeemfrom" name="redeemfrom" id="redeemfrom" placeholder="Enter Name.."> -->

                  <select class="form-control redeemfrom"  name="redeemfrom" id="redeemfrom" required>

                  </select>
                </div>
                <div class="mb-4">
                  <label for="paidbyclient" class="form-label">Paid By Client </label>
                  <select class="form-control custom-select" data-action="client_list" name="paidbyclient" id="paidbyclient">
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                  </select>
                </div>

                <div class="mb-4 clientlist" style="display: none;">
                  <label for="clientname" class="form-label">Client Name </label>
                  <select class="form-control clientname" data-action="another_action" name="clientname" id="clientname">
                  </select>
                </div>                            
                <div class="mb-4" id="allpagesactions_container">
                </div>
                <button type="button" class="btn btn-secondary mb-4" id="allpagesadd_action" style="display: none;">Add Action</button>
                <!-- <label for="tkt_content" class="form-label">Content</label>
               
                 <input type="hidden" name="tkt_content_hidden" id="tkt_content_hidden"> -->
                <div class="mb-4">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-control" name="status" id="statuss" style="display: block !important;">
                    <!-- <option value="Pending">Select Status</option> -->
                    <option value="Pending">Pending</option>
                    <option value="Paid">Paid</option>
                   <!--  <option value="Cancel">Cancel</option>
                    <option value="Verified">Verified</option>
                    <option value="Verified">Unverified</option>
                    <option value="Verified">Held</option> -->
                  </select>
                </div>

                <div class="mb-4" id="div_staff">
                 <label for="comment" class="form-label">Comments</label>
                 <!-- <textarea  class="form-control fetch_comment" name="comment" id="comment" style="resize: none;"></textarea> -->
                 <select class="form-control comment-dropdown"  name="comment" id="comment1" required>
                  <option value="">Select a comment</option>
                  <?php echo $comments;?>
                  <option value="custom">Add your own comment</option>
                  </select>
                  <input type="text" class="form-control mt-2 custom-comment-input d-none" name="custom_comment" id="custom_comment1" placeholder="Enter your own comment" />
                </div>

                <div class="mb-4">
                  <label for="pasteimages" class="form-label">Upload Images </label>
                  <textarea class="form-control demo demo-textarea" placeholder="Paste your images here" style="resize: none;" id="pasteimages" disabled></textarea>
                  <input type="hidden" class="hdn_imagedata" name='hdn_imagedata' id='hdn_imagedata'>

                </div>
                 <input type="hidden" id="action_count" name="action_count" value="1">
                 <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>">
                 <input type="hidden" name="uname" id="uname" value="<?php echo $uname;?>">
                 <input type="hidden" name="redmid" id="redmid" class="redmid">
                 <input type="hidden" name="pgid" id="pgid" class="pgid">


                 <div class="modal-footer">
                  <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="paid_redeem_frm" id="savepaidredeem">Save</button>
                </div>

              </form>
            </div>
           
            <!-- comments sections -->
            <div class="tab-pane " id="allpagescomments-section" role="tabpanel" aria-labelledby="pills-profile-tab">
              <form method="post" enctype="multipart/form-data" id="comments_allpagesredeempaidfrm" action="update_redeem_fields.php">

                <!-- <div class="mb-4" id="div_staff">
                 <label for="comment" class="form-label">Comments</label>
                 <textarea  class="form-control fetch_comment" name="single-comment" id="comment" required></textarea>
                </div> -->
                <div class="mb-4" id="div_staff">
                 <label for="comment" class="form-label">Comments</label>
                 <!-- <textarea  class="form-control fetch_comment" name="comment" id="comment" style="resize: none;"></textarea> -->
                 <select class="form-control comment-dropdown"  name="single-comment" id="comment3" required>
                  <option value="">Select a comment</option>
                  <?php echo $comments;?>
                  <option value="custom">Add your own comment</option>
                  </select>
                  <input type="text" class="form-control mt-2 custom-comment-input d-none" name="custom_comment" id="custom_comment3" placeholder="Enter your own comment" />
                </div>
                <div class="mb-4">
                  <label for="pasteimages" class="form-label">Upload Images </label>
                  <textarea class="form-control cmnt cmnt-textarea" placeholder="Paste your images here" style="resize: none;" id="pasteimages" disabled required></textarea>
                  <input type="hidden" class="hdn_cmntimagedata" name='hdn_cmntimagedata' id='hdn_cmntimagedata'>

                </div>
                <input type="hidden" name="uid" id="uid" value="<?php echo $uid;?>">
                <input type="hidden" name="uname" id="uname" value="<?php echo $uname;?>">
                <input type="hidden" name="redmid" id="redmid" class="redmid">
                <input type="hidden" name="pgid" id="pgid" class="pgid">


                <div class="modal-footer">
                  <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="paid_redeem_frm" id="savepaidredeem">Save</button>
                </div>

              </form>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
  <div class="rightbar-overlay"></div>

  	<?php include('footer_links.html');?>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#redeempaidfrm').on('submit', function(e) {
          e.preventDefault(); // Prevent the default form submission
          $('#savepaidredeem').hide();
          if (!validateForm()) {
            $('#savepaidredeem').show();
            return false;
          }

          $.ajax({
            url: $(this).attr('action'), // Use the form's action attribute as the URL
            type: 'POST', // Request method
            data: $(this).serialize(), // Serialize the form data
            dataType: 'json',
            
            success: function(response) {
              
              if (response.status === 'success') {
                alert('Redeemed Successfully!');
               
                $('#paidredeemform').modal('hide');
                $('#redeempaidfrm')[0].reset();
                $('.hdn_imagedata').val('');
                $('.pasterdmimage').remove();
                $(".action-amount").val('');
                $(".cashtag_add").remove();
                $("#actions_container").empty();
                 $("#add_action").hide();
                totalActionAmount = 0;
                $('.custom-comment-input').val('');
                // Reset the form
                  
                // window.location.replace("redeemlist.php");
                fetchAndUpdateTableData(response.page_id);
              } 
              else {
                alert('Error: ' + response.message);
              }
            },
            error: function(xhr, status, error) {
              if (xhr.responseJSON && xhr.responseJSON.message) {
                alert('Error: ' + xhr.responseJSON.message);
              } 
              else {
                alert('An unexpected error occurred. Please check the console for more details.');
              }
            }
          });
        });
        function fetchAndUpdateTableData(pageid) {
          $.ajax({
              url: 'fetch_pending_redeem.php',  
              type: 'POST',
              data: {
                action:'fetch_pending_redeem',
                page_id:pageid}, 
             
              success: function(data) {
                $('#redeem_details_display').html(data);
              },
              error: function(xhr, status, error) {
                  console.error("Error fetching table data:", error);
              }
          });
        }

        // validate form fields
        function validateForm() {
          // Add your validation logic for each field
          var image = $('#hdn_imagedata').val();
          // var redeemfrom = $('#redeemfrom').val();
          // var amount = $('#amount').val();
          // var clientname = $('#clientname').val();
          // var status = $('#status').val();
          // var comment = $('#comment').val();
          var cashtag = $('.clientcashtag_dropdown').val();
          // alert(cashtag);
          if (cashtag == "0") {
            alert('Cashtag Field is required.');
            return false;
          }
          if (image === '') {
            alert('Image Field is required.');
            return false;
          }
         
          
          // if (amount === '') {
          //   Swal.fire({
          //     title: "Any fool can use a computer",
          //     confirmButtonColor: "#5156be"
          //   });
          //   alert('Amount Field is required.');
          //   return false;
          // }

          return true; 
        }
        
        // disable outside click
        $('#paidredeemform').modal({

          backdrop: 'static',  
          keyboard: false      
        });

      });
    </script>
    <script>
      $(document).ready(function() {
        $('#update_redeemfrm').on('submit', function(e) {
          e.preventDefault(); // Prevent the default form submission
          
          $.ajax({
            url: $(this).attr('action'), // Use the form's action attribute as the URL
            type: 'POST', // Request method
            data: $(this).serialize(), // Serialize the form data
            dataType: 'json',
            
            success: function(response) {
              
              if (response.status === 'success') {
                $('#alert-delete').show();
                $('#alert-delete').html(response.message);

                // setTimeout(function() {
                //     $('#alert-delete').hide();
                // }, 2000);
                // alert('Record Updated! Approval Request Pending!');
               
                $('#viewredeemform').modal('hide');
                $('#update_redeemfrm')[0].reset();
               
                // Reset the form
                  
                // window.location.replace("redeemlist.php");
                UpdateTableData(response.page_id);
              } 
              else {
                alert('Error: ' + response.message);
              }
            },
            error: function(xhr, status, error) {
              if (xhr.responseJSON && xhr.responseJSON.message) {
                alert('Error: ' + xhr.responseJSON.message);
              } 
              else {
                alert('An unexpected error occurred. Please check the console for more details.');
              }
            }
          });
        });
        function UpdateTableData(pageid) {
          $.ajax({
              url: 'fetch_pending_redeem.php',  
              type: 'POST',
              data: {
                action:'fetch_pending_redeem',
                page_id:pageid}, 
             
              success: function(data) {
                $('#redeem_details_display').html(data);
              },
              error: function(xhr, status, error) {
                  console.error("Error fetching table data:", error);
              }
          });
        }
      });
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebarContent = document.getElementById('sidebarContent');
        const pendingRedeemArea = document.getElementById('rightsidedive');
        const arrowIcon = toggleSidebar.querySelector('i');

        toggleSidebar.addEventListener('click', function() {
          sidebarContent.classList.toggle('hidden-sidebar');
          arrowIcon.classList.toggle('rotate');
          pendingRedeemArea.classList.toggle('show');
        });
      });
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
        
        $('#comments_redeempaidfrm').on('submit', function(e) {
          e.preventDefault(); // Prevent the default form submission
          $('#savepaidredeem').hide();
          if (!validateForm()) {
            $('#savepaidredeem').show();
            return false;
          }

          $.ajax({
            url: $(this).attr('action'), // Use the form's action attribute as the URL
            type: 'POST', // Request method
            data: $(this).serialize(), // Serialize the form data
            dataType: 'json',
            
            success: function(response) {
              alert(response);
              if (response.status === 'success') {
                alert(response.message);
               
                $('#paidredeemform').modal('hide');
                $('#redeempaidfrm')[0].reset();
                $('.hdn_cmntimagedata').val('');
                $('.pasterdmimage').remove();
                $('.custom-comment-input').hide();
                $('.custom-comment-input').val('');
                $('#comment3').val('');
               
                fetchAndUpdateTable(response.page_id);
              } 
              else {
                alert('Error: ' + response.message);
              }
            },
            error: function(xhr, status, error) {
              if (xhr.responseJSON && xhr.responseJSON.message) {
                alert('Error: ' + xhr.responseJSON.message);
              } 
              else {
                alert('An unexpected error occurred. Please check the console for more details.');
              }
            }
          });
        });
        function fetchAndUpdateTable(pageid) {
          $.ajax({
              url: 'fetch_pending_redeem.php',  
              type: 'POST',
              data: {
                action:'fetch_pending_redeem',
                page_id:pageid}, 
             
              success: function(data) {
                $('#redeem_details_display').html(data);
              },
              error: function(xhr, status, error) {
                  console.error("Error fetching table data:", error);
              }
          });
        }

        // validate form fields
        function validateForm() {
          // Add your validation logic for each field
          var image = $('#hdn_cmntimagedata').val();
         
          // var cashtag = $('#comment').val();
          // // alert(cashtag);
          // if (cashtag === "") {
          //   alert('Comment Field is required.');
          //   return false;
          // }
          if (image === '') {
            alert('Image Field is required.');
            return false;
          }
         
          return true; 
        }

      });
    </script>
    <!-- comments dropdown -->
    <script>
      $(document).ready(function() {
        // Function to handle comment selection
        function handleCommentSelection() {
          $('.comment-dropdown').on('change', function() {
            var selectedValue = $(this).val();
            var customCommentInput = $(this).closest('.mb-4').find('.custom-comment-input');

            if (selectedValue === 'custom') {
              customCommentInput.removeClass('d-none');
              customCommentInput.attr('required', 'required');
            } else {
              customCommentInput.addClass('d-none');
              customCommentInput.removeAttr('required');
            }
          });
        }

        // Initialize the function
        handleCommentSelection();
      });
    </script>
    <script>
      $(document).ready(function () {
        var isTableInitialized = false; // To track if the table is already initialized

        $(document).on('click','#allpageslist', function () {
          var remainingAmount;
          if (!isTableInitialized) {
            $('#tbl_allpendingredeem').DataTable({
              "processing": true,
              "serverSide": true,
              "pageLength": 50,
              "ajax": {
                "url": "pendingredeemagainstpage.php",
                "method": "POST",
                "dataType": "json"
              },
              "columns": [
                // { "data": "id", "searchable": true },
                { "data": "record_time", "searchable": true },
                { "data": "record_by", "searchable": true },
                { "data": "cust_name", "searchable": true },
                { "data": "page_name", "searchable": true },
                { "data": "gid", "searchable": true },
                { "data": "ctid", "searchable": true },
                { "data": "amount", "searchable": true },
                { "data": "tip", "searchable": true },
                { "data": "addback", "searchable": true },
                { "data": "amt_addback", "searchable": true },
                { "data": "amt_refund", "searchable": true },
                { "data": "amt_paid", "searchable": true },
                { "data": "amt_bal", "searchable": true },
                {
                  "data": null, // You can use `null` when data comes from a calculation
                  "searchable": false, // Not searchable as it's a calculated field
                  "render": function (data, type, row) {
                    remainingAmount = parseFloat(row.amount)-parseFloat(row.amt_paid) - parseFloat(row.amt_refund) - parseFloat(row.amt_addback)- parseFloat(row.amt_bal)- parseFloat(row.tip)- parseFloat(row.addback);
                    return remainingAmount.toFixed(2); // Return the calculated value, rounded to 2 decimal places
                  },
                  "title": "Remaining Amount" // Set column title
                },
                {
                  "target": 14,
                  "render": function (data, type, row) {
                    var remarksHtml = '';
                    
                    
                      remarksHtml = '<span data-id="' + row.id + '" class="remarks-text" style="cursor:pointer;">' + row.comment + '</span> / ' +
                                    '<a class="btn btn-primary btn-sm view_remarks_log" data-id="' + row.id + '" data-type="Comments Attachment">View</a>';
                    
                    return remarksHtml;
                  }
                },
                {
                  "targets": 15,
                  "render": function(data, type, row) {
                      return '<span class="badge rounded-pill bg-primary">'+row.status+'</span></i>';
                  }
                },
                {
                  "targets": 16,
                  "render": function(data, type, row) {
                      return '<i class="btn btn-primary btn-sm allpagesedit_redeem_btn" data-id="'+row.id+'" data-pg_id="'+row.pg_id+'" data-agent_name="'+row.record_by+'" data-amount="'+remainingAmount+'" data-gameid="'+row.gid+'" data-castag="'+row.ctid+'" data-clientname="'+row.redeemfor+'"style="cursor:pointer;">Pay Redeem</i>';
                  }
                },
                // { "data": "comment", "searchable": true },
                // { "data": "status" }
              ],
              "order": [[0, 'desc']]
            });
           
            isTableInitialized = true; // Set flag to true after initializing
          }
        });
      });
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#allpagesredeempaidfrm').on('submit', function(e) {
          e.preventDefault(); // Prevent the default form submission
          $('#savepaidredeem').hide();
          if (!validateAllpagesForm()) {
            $('#savepaidredeem').show();
            return false;
          }

          $.ajax({
            url: $(this).attr('action'), // Use the form's action attribute as the URL
            type: 'POST', // Request method
            data: $(this).serialize(), // Serialize the form data
            dataType: 'json',
            
            success: function(response) {
              
              if (response.status === 'success') {
                alert('Redeemed Successfully!');
               
                $('#allpages_paidredeemform').modal('hide');
                $('#allpagesredeempaidfrm')[0].reset();
                $('.hdn_imagedata').val('');
                $('.pasterdmimage').remove();
                $(".action-amount").val('');
                $(".cashtag_add").remove();
                $("#allpagesactions_container").empty();
                 $("#allpagesadd_action").hide();
                totalActionAmount = 0;
                $('.custom-comment-input').val('');
                // Reset the form
                  
                // window.location.replace("redeemlist.php");
                if ($.fn.dataTable.isDataTable('#tbl_allpendingredeem')) {
                  $('#tbl_allpendingredeem').DataTable().ajax.reload(); // Reload data
                }
              } 
              else {
                alert('Error: ' + response.message);
              }
            },
            error: function(xhr, status, error) {
              if (xhr.responseJSON && xhr.responseJSON.message) {
                alert('Error: ' + xhr.responseJSON.message);
              } 
              else {
                alert('An unexpected error occurred. Please check the console for more details.');
              }
            }
          });
        });
        // validate form fields
        function validateAllpagesForm() {
          // Add your validation logic for each field
          var image = $('#hdn_imagedata').val();
          // var redeemfrom = $('#redeemfrom').val();
          // var amount = $('#amount').val();
          // var clientname = $('#clientname').val();
          // var status = $('#status').val();
          // var comment = $('#comment').val();
          var cashtag = $('.allpagesclientcashtag_dropdown').val();
          // alert(cashtag);
          if (cashtag == "0") {
            alert('Cashtag Field is required.');
            return false;
          }
          if (image === '') {
            alert('Image Field is required.');
            return false;
          }
         
          return true; 
        }
         

      });
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#comments_allpagesredeempaidfrm').on('submit', function(e) {
          e.preventDefault(); // Prevent the default form submission
          $('#savepaidredeem').hide();
          if (!validateForm()) {
            $('#savepaidredeem').show();
            return false;
          }

          $.ajax({
            url: $(this).attr('action'), // Use the form's action attribute as the URL
            type: 'POST', // Request method
            data: $(this).serialize(), // Serialize the form data
            dataType: 'json',
            
            success: function(response) {
              
              if (response.status === 'success') {
                alert(response.message);
               
                $('#allpages_paidredeemform').modal('hide');
                $('#allpagesredeempaidfrm')[0].reset();
                $('.hdn_cmntimagedata').val('');
                $('.pasterdmimage').remove();
                $('.custom-comment-input').val('');
               // window.location.replace("redeemlist.php");
                if ($.fn.dataTable.isDataTable('#tbl_allpendingredeem')) {
                  $('#tbl_allpendingredeem').DataTable().ajax.reload(); // Reload data
                }
                
              } 
              else {
                alert('Error: ' + response.message);
              }
            },
            error: function(xhr, status, error) {
              if (xhr.responseJSON && xhr.responseJSON.message) {
                alert('Error: ' + xhr.responseJSON.message);
              } 
              else {
                alert('An unexpected error occurred. Please check the console for more details.');
              }
            }
          });
        });
        

        // validate form fields
        function validateForm() {
          // Add your validation logic for each field
          var image = $('#hdn_cmntimagedata').val();
         
          // var cashtag = $('#comment').val();
          // // alert(cashtag);
          // if (cashtag === "") {
          //   alert('Comment Field is required.');
          //   return false;
          // }
          if (image === '') {
            alert('Image Field is required.');
            return false;
          }
         
          return true; 
        }

      });
    </script>
  </body>
</html>