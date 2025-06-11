
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Recharge Transactions</title>
    <?php require("links.html"); ?>
    
  </head>
  <body>
    <div id="layout-wrapper">
      <?php include('topheader.php');?>
      <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
      <?php
        if ($type == 'CSR' || $type == 'Q&A' || $type =='Redeem' || $department=='Redeem') {
      
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
        require_once('../connect_me.php');
        $database_connection = new Database_connection();
        $connect = $database_connection->connect(); 
        require('../database/Redeem.php');

        require('../database/Pages.php');


        $object= new Pages();
        $pages=$object->getPagesByIds($uid,$type);
        // $pages=$object->get_all_pages();
        
      ?>
      <?php 
        if(isset($_POST['savegame'])){
          $pageid   =$_POST['pageid'];
          $gamename =$_POST['game_name'];
          $uid     =$_POST['uid'];
          $type     =$_POST['type'];
          $uname    =$_POST['uname'];
          $created_at     =date('Y-m-d H:i:s');

          $query = mysqli_query($connect, "INSERT INTO gameinfo (pg_id,g_name,uid,uname,type,created_at) 
          VALUES ('$pageid','$gamename','$uid','$type','$uname','$created_at')") or die(mysqli_error($connect));
          if ($query) {
            echo '<script>
            Swal.fire({
                title: "Good job!",
                text: "Game Added Successfully!",
                icon: "success",   
            }).then(() => {
                window.location.href = "add_game_deposits.php";
              });</script>';
            exit();
              
          } else {
              echo "Error: Unable to insert data.";
          }
        }
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
                  <h4 class="mb-sm-0 font-size-18">All Pages List</h4>

                  <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                      <li class="breadcrumb-item active">All Pages List</li>
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
                      <input type="text" id="page_search" class="form-control bg-light" placeholder="Search ....." aria-label="Search ...." aria-describedby="basic-addon1">
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
                          <ul class="list-unstyled chat-list" id="sidepage_list">
                            <?php
                            
                              if(count($pages) > 0)
                              {
                                foreach($pages as $key => $page)
                                {
                                  // echo "<pre>";
                                  // print_r($page);

                                echo '
                                  <li class="unread">
                                      <a href="#" class="page_games" data-id="'.$page['id'].'" data-name="'.$page['pagename'].'" data-clientpage="'.$page['clientname'].'">
                                          <div class="d-flex">                            
                                             
                      
                                              <div class="flex-grow-1 overflow-hidden">
                                                  <h5 class="text-truncate font-size-15 mb-1">'.$page['pagename'].'</h5>
                                                 <p class="chat-user-message text-truncate mb-0">'.$page['status'].'</p> 
                                              </div>
                                              <div class="unread-message">
                                                  <span class="badge badge-soft-danger rounded-pill">'.$page['clientname'].'</span>
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

              <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1" id="games_list_area" style="display: none;">
                <div class="alert alert-danger" id="alert-delete" style="display:none;">
                </div>
                <div class="alert alert-success" id="alert-success" style="display:none;">               
                </div>
                <div class="card">
                  <div class="p-3 px-lg-4 border-bottom">
                    <div class="row">
                      <div class="col-xl-4 col-7">
                        <div class="d-flex align-items-center">
                            
                          <div class="flex-grow-1">
                              <h5 class="font-size-14 mb-1 text-truncate">
                                <a href="#" class="text-dark user-profile-show" id="page_name"></a>
                                <input type="hidden" id="hdn_pageid" class="hdn_pageid" name="hdn_pageid">
                                <input type="hidden" id="hdn_pagename" name="hdn_pagename">
                              </h5>
                              <!-- <p class="text-muted text-truncate mb-0">Online</p> -->
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-8 col-5">
                        <ul class="list-inline user-chat-nav text-end mb-0">     
                          <li class="list-inline-item">
                            <div class="dropdown">
                              <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-horizontal-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end">
                                 
                                <a class="dropdown-item" href="#" id="" data-bs-toggle="modal" data-bs-target="#addgames">Add Game <i class="ri-edit-box-line float-end text-muted"></i></a>
                                 
                              </div>
                            </div>
                          </li>                                        
                        </ul>                     
                      </div>
                    </div>
                  </div>

                  <div class="chat-conversation p-3 px-2" id="games_div" data-simplebar >
                    <ul class="list-unstyled mb-0" id="">
                      <table class="table table-bordered table-sm table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Game Name</th>
                            <th>Total Recharged</th>
                            <!-- <th>Total Redeemed</th> -->
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="games_detail_display">
                          
                        </tbody>
                      </table>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- end user chat -->
            </div>
            <!-- End d-lg-flex  -->
          </div>
          
        </div>
        <?php include('footer.html');?>
     </div>
    </div>
   

    <!-- add game modal -->
    <div class="modal fade" id="addgames" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-size-16" id="createticketLabel">Add Games</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            
            <form method="post" action="#">
              <div class="mb-3">
                <label class="form-label" for="cashapp_open">Game Name</label>
                <div class="input-group mb-3 bg-light-subtle rounded-3">
                  <span class="input-group-text text-muted" id="basic-addon3">
                     <i class="bx bx-duplicate"></i>
                  </span>
                 <input type="text" class="form-control" name="game_name" id="game_name" required >
                </div>
              </div>

              <input type="hidden" name="uid" value="<?php echo $uid;?>">
              <input type="hidden" name="type" value="<?php echo $type;?>">
              <input type="hidden" name="uname" value="<?php echo $uname;?>">              
              <input type="hidden" name="pageid" id="" class="hdn_pageid">
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="savegame" id="">Save</button>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
    <!-- end game modal -->
    <!-- adddeposit game modal -->
    <div class="modal fade" id="adddeposit_mdl" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-size-16" id="createticketLabel">Add Deposits - <span class="text-danger" id="showgamename"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            
            <form method="post" action="addstore_deposits.php" id="deposits_frm">
              <div class="mb-3">
                <label class="form-label" for="cashapp_open">Store Game ID</label>
                <div class="input-group mb-3 bg-light-subtle rounded-3">
                  <span class="input-group-text text-muted" id="basic-addon3">
                     <i class="bx bx-duplicate"></i>
                  </span>
                 <input type="text" class="form-control" name="storegame_id" id="storegame_id" required >
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label" for="cashapp_open">Deposits</label>
                <div class="input-group mb-3 bg-light-subtle rounded-3">
                  <span class="input-group-text text-muted" id="basic-addon3">
                     <i class="bx bx-dollar"></i>
                  </span>
                 <input type="text" class="form-control" name="game_deposits" id="game_deposits" required >
                </div>
              </div>

              <input type="hidden" name="uid" value="<?php echo $uid;?>">
              <input type="hidden" name="type" value="<?php echo $type;?>">
              <input type="hidden" name="uname" value="<?php echo $uname;?>">              
              <input type="hidden" name="pageid" id="" class="hdn_pageid">
              <input type="hidden" name="gameid" id="" class="hdn_gameid">
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="adddeposit" id="">Add</button>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
    <!-- end deposit game modal -->

    <!-- redeemdeposit game modal -->
    <div class="modal fade" id="redeemdeposit_mdl" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-size-16" id="createticketLabel">Redeem - <span class="text-warning" id="showrdmgamename"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            
            <form method="post" action="addstore_deposits.php" id="rdmdeposits_frm">
              <div class="mb-3">
                <label class="form-label" for="rdmstoregame_id">Store Game ID</label>
                <div class="input-group mb-3 bg-light-subtle rounded-3">
                  <span class="input-group-text text-muted" id="basic-addon3">
                     <i class="bx bx-duplicate"></i>
                  </span>
                 <input type="text" class="form-control" name="rdmstoregame_id" id="rdmstoregame_id" required >
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label" for="rdmgame_deposits">Redeem Amount</label>
                <div class="input-group mb-3 bg-light-subtle rounded-3">
                  <span class="input-group-text text-muted" id="basic-addon3">
                     <i class="bx bx-dollar"></i>
                  </span>
                 <input type="text" class="form-control" name="rdmgame_deposits" id="rdmgame_deposits" required >
                </div>
              </div>

              <input type="hidden" name="uid" value="<?php echo $uid;?>">
              <input type="hidden" name="type" value="<?php echo $type;?>">
              <input type="hidden" name="uname" value="<?php echo $uname;?>">              
              <input type="hidden" name="rdmpageid" id="" class="hdn_rdmpageid">
              <input type="hidden" name="rdmgameid" id="" class="hdn_rdmgameid">
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="rdmadddeposit" id="">Save</button>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
    <!-- end deposit game modal -->
    <!-- transactoin game modal -->
    <div class="modal fade" id="transaction_mdl" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-size-16" id="createticketLabel">Transaction Records - <span class="text-danger" id="showtrangamename"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              
              <div class="col-5">
                <div class="mb-3">
                  <label class="form-label" for="rdmstoregame_id">From</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class="bx bx-calendar-plus"></i>
                    </span>
                   <input type="text" class="form-control" name="rdmstoregame_id" id="datefrom" required >
                  </div>
                </div>
              </div>  
              <div class="col-5">
                <div class="mb-3">
                  <label class="form-label" for="rdmstoregame_id">To</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class="bx bx-calendar-plus"></i>
                    </span>
                   <input type="text" class="form-control" name="rdmstoregame_id" id="dateto" required >
                    <div class="d-grid">
                      <button type="button" class="btn btn-primary" id="transearch_keyword">Search</button>
                    </div>
                  </div>

                </div>
              </div> 
             
            </div>
            <div class="row mt-4">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <table class="table table-bordered table-responsive table-sm" id="tbl_transdetails">
                      <thead>
                        <tr>
                         
                          <th scope="col">Date</th> 
                          <th scope="col">Game Name</th> 
                          <th scope="col">Account</th>   
                          <th scope="col">Before</th>
                          <th scope="col">Recharged</th>
                          <th scope="col">After</th> 
                          <!-- <th scope="col">Redeem</th>    -->
                          <!-- <th scope="col">Page Name</th>  -->
                          <th scope="col">Client Name</th> 
                          <th scope="col">Action</th> 

                        </tr>
                      </thead>
                      <tbody id="searchtransData">
                      
                      </tbody>
                      <tfoot>
                        <tr>
                          
                          <th scope="col">-</th> 
                          <th scope="col">-</th> 
                          <th scope="col">-</th>   
                          <th scope="col">Total</th>
                          <th scope="col"></th>
                          <th scope="col">-</th> 
                          <th scope="col">-</th> 
                          <th scope="col">-</th>   
                         
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            

            <input type="hidden" name="uid" value="<?php echo $uid;?>">
            <input type="hidden" name="type" value="<?php echo $type;?>">
            <input type="hidden" name="uname" value="<?php echo $uname;?>">  
            <input type="hidden" name="tgameid" id="tgameid">             
            
            <!-- <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="rdmadddeposit" id="">Save</button>
            </div> -->
            
            
          </div>
        </div>
      </div>
    </div>
    <!-- end transactoin game modal -->
    <div class="rightbar-overlay"></div>

    <?php include('footer_links.html');?>
    <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#deposits_frm').on('submit', function(e) {
          e.preventDefault(); // Prevent the default form submission
          
          if (!validateForm()) {
            return false;
          }

          $.ajax({
            url: $(this).attr('action'), // Use the form's action attribute as the URL

            type: 'POST', // Request method
            data: $(this).serialize(), // Serialize the form data
            dataType: 'json',
            
            success: function(response) {
              
              if (response.status === 'success') {
            
                // Swal.fire({
                //   title: "Good job!",
                //   text: "Deposits Added Successfully!",
                //   icon: "success",   
                // });
                $('#alert-success').show();
                $('#alert-success').html(response.message);
                setTimeout(function() {
                  $('#alert-success').hide();
                }, 2000);

                // alert('Deposits Added Successfully!');
               
                $('#adddeposit_mdl').modal('hide');
                $('#deposits_frm')[0].reset(); 
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
              url: 'fetch_games_list.php',  
              type: 'POST',
              data: {
                action:'fetch_gameslist',
                page_id:pageid}, 
             
              success: function(data) {
                $('#games_detail_display').html(data);
              },
              error: function(xhr, status, error) {
                  console.error("Error fetching table data:", error);
              }
          });
        }

        // validate form fields
        function validateForm() {
          // Add your validation logic for each field
          var storegame_id = $('#storegame_id').val();
          var game_deposits = $('#game_deposits').val();
          

          if (storegame_id === '') {
            alert('Store Game ID Field is required.');
            return false;
          }
          if (game_deposits === '') {
            alert('Deposit Field is required.');
            return false;
          }
          

          return true; 
        }
        
        $('#rdmdeposits_frm').on('submit', function(e) {
          e.preventDefault(); // Prevent the default form submission
          
          if (!validateRedeemForm()) {
            return false;
          }

          $.ajax({
            url: $(this).attr('action'), // Use the form's action attribute as the URL

            type: 'POST', // Request method
            data: $(this).serialize(), // Serialize the form data
            dataType: 'json',
            
            success: function(response) {
              
              if (response.status === 'success') {
            
                Swal.fire({
                  title: "Good job!",
                  text: "Redeemed Successfully!",
                  icon: "success",   
                });
                // alert('Deposits Added Successfully!');
               
                $('#redeemdeposit_mdl').modal('hide');
                $('#rdmdeposits_frm')[0].reset(); 
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

        // validate form fields
        function validateRedeemForm() {
          // Add your validation logic for each field
          var rdmstoregame_id = $('#rdmstoregame_id').val();
          var rdmgame_deposits = $('#rdmgame_deposits').val();
          

          if (rdmstoregame_id === '') {
            alert('Store Game ID Field is required.');
            return false;
          }
          if (rdmgame_deposits === '') {
            alert('Redeem Field is required.');
            return false;
          }
          
          // Convert the deposit value to a number and check if it is negative
          var depositValue = parseFloat(rdmgame_deposits);
          if (isNaN(depositValue) || depositValue >= 0) {
            alert('Redeem Amount Field must be a negative number.');
            return false;
          }

          return true; 
        }

        $(document).on('click', '.delete_gamesname', function(){
          var gid = $(this).data('gid');
          var pid = $(this).data('pid');

          $.ajax({
            url: 'addstore_deposits.php',
            type: 'POST',
            data: {
                action: 'delete_game',
                pid: pid,
                gid: gid
            },
            success: function(response) {
                try {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.status === 'success') {
                        $('#alert-delete').show();
                        $('#alert-delete').html(jsonResponse.message);
                        fetchAndUpdateTableData(jsonResponse.page_id);
                        setTimeout(function() {
                          $('#alert-delete').hide();
                        }, 2000);
                    } else {
                        $('#alert-delete').show();
                        $('#alert-delete').html('An error occurred: ' + jsonResponse.message);
                    }
                } catch (e) {
                    console.error("Parsing error:", e);
                    $('#alert-delete').show();
                    $('#alert-delete').html('An unexpected error occurred.');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching table data:", error);
                $('#alert-delete').show();
                $('#alert-delete').html('An error occurred while processing your request.');
            }
          });
        });

        // get transaction history
        $(document).on('click', '.btn-transaction', function() {
          $('#transaction_mdl').modal('show');
          var gid   = $(this).data('gid');
          var pid   = $(this).data('pid');
          $('#tgameid').val(gid);
          
          var gname = $(this).data('gamename');

          $('#showtrangamename').text(gname);

          // Get the current date
          var currentDate = new Date();

          // Get the first day of the current month
          var firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
          var lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);

          // Format the date to YYYY/MM/DD HH:mm
          var formatDate = function(date) {
            var year = date.getFullYear();
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var day = ('0' + date.getDate()).slice(-2);
            var hours = ('0' + date.getHours()).slice(-2);
            var minutes = ('0' + date.getMinutes()).slice(-2);
            return year + '/' + month + '/' + day + ' ' + hours + ':' + minutes;
          }

          // Set the formatted dates to the input fields
          $('#datefrom').val(formatDate(new Date(firstDay.setHours(0, 0, 0, 0))));
          $('#dateto').val(formatDate(new Date(lastDay.setHours(23, 59, 59, 999))));

          // Fetch and display data
          fetchAndDisplayData(gid, $('#datefrom').val(), $('#dateto').val());
        });

        $('#transearch_keyword').on('click', function() {
          var gid = $('#tgameid').val(); 
          
          fetchAndDisplayData(gid, $('#datefrom').val(), $('#dateto').val());
        });

        function fetchAndDisplayData(gid, fromDate, toDate) {
          $.ajax({
              url: 'fetch_games_list.php', // Replace with your actual endpoint
              method: 'POST',
              data: {
                  game_id: gid,
                  date_from: fromDate,
                  date_to: toDate
              },
              success: function(response) {
            try {
                var data = JSON.parse(response);
                if (Array.isArray(data)) {
                    var currentBalance = 0;
                    var rows = '';
                    data.forEach(function(item, index) {
                      var id=item.store_id;
                      var rechargedDate = item.recharged_date;
                      var gameName = item.g_name;
                      var storeGid = item.store_gid;
                      var storeRecharge = parseFloat(item.store_recharge);
                      var storeRedeem = item.store_redeem;
                      var pagename = item.pagename;
                      var clientname = item.clientname;
                      var beforeRecharge = currentBalance;
                      var afterBalance = (currentBalance + storeRecharge);
                      rows += `<tr>
                       
                        <td>${rechargedDate}</td>
                        <td>${gameName}</td>
                        <td>${storeGid}</td>
                        <td>${beforeRecharge.toFixed(2)}</td>
                        <td>${storeRecharge.toFixed(2)}</td>
                        <td>${afterBalance.toFixed(2)}</td>
                        
                        <td>${clientname}</td>
                        <td><button class="btn btn-danger waves-effect waves-light  m-1 delete_gamesdeposits" data-id="${id}" style="cursor:pointer;">Delete</button></td>
                      </tr>`;
                      currentBalance = afterBalance;
                    });
                    if ($.fn.DataTable.isDataTable('#tbl_transdetails')) {
                        $('#tbl_transdetails').DataTable().clear().destroy();
                    }
                    $('#searchtransData').html(rows);

                    
                    initializeDataTable();
                } else {
                    console.error('Error: Response is not an array', response);
                }
            } catch (e) {
                console.error('Error parsing JSON response', e);
            }
        },
              error: function(error) {
                  console.error('Error fetching data', error);
              }
          });
        }

        function initializeDataTable() {
          $('#tbl_transdetails').DataTable({
            "order": [[0, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print',
                {
                    text: 'Show All',
                    action: function ( e, dt, node, config ) {
                        dt.page.len(-1).draw();
                    }
                }
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api(), data;
              
              // Remove the formatting to get integer data for summation
              var intVal = function ( i ) {
                  return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                          i : 0;
              };

              // Total over all pages
              var total = api
                  .column( 4 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );

              // Total over this page
              var pageTotal = api
                  .column( 4, { page: 'current'} )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );

              // Update footer
              $( api.column( 4 ).footer() ).html(
                  pageTotal.toFixed(2)
              );
            }
          });
        }

      });
    </script>
    <script type="text/javascript">
      $("#datefrom").datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss'
      });
      $("#dateto").datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH:mm:ss'
      });
    </script>
    <script>
      $(document).on('click', '.delete_gamesdeposits', function() {
        var id = $(this).data('id');
        var confirmation = confirm("Are you sure you want to delete this item?");
        
        if (confirmation) {
          $.ajax({
            url: 'fetch_games_list.php',
            method: 'POST',
            data: { transactionid: id },
            success: function(response) {
              
              alert(response);
              window.location.reload();
            },
            error: function(xhr, status, error) {
              alert("An error occurred: " + error);
            }
          });
        } 
        else {
          alert("Deletion canceled");
        }
      });
    </script>

  </body>
</html>