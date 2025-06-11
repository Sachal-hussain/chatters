
<!DOCTYPE html>
<html>
  <head>
  	<meta charset="utf-8" />
    <title>Customer History | SHJ INTERNATIONAL</title>
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
        $pages=$object->getPagesByIds($uid,$type);

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
                  <h4 class="mb-sm-0 font-size-18">All Pages</h4>

                  <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                      <li class="breadcrumb-item active">All Pages</li>
                    </ol>
                  </div>

                </div>
              </div>
            </div>
            <!-- end page title -->

            <div class="d-lg-flex">
              <div class="chat-leftsidebar card" id="sidebarContent">
                <div class="p-3">
                  
                  <div class="search-box position-relative">
                      <input type="text" id="page_search" class="form-control bg-light" placeholder="Search ....." aria-label="Search ...." aria-describedby="basic-addon1">
                      <i class="bx bx-search search-icon"></i>
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
                                      <a href="#" class="select_page_customer" data-id="'.$page['id'].'" data-name="'.$page['pagename'].'" data-clientpage="'.$page['clientname'].'">
                                          <div class="d-flex">                            
                                             
                      
                                              <div class="flex-grow-1 overflow-hidden">
                                                  <h5 class="text-truncate font-size-15 mb-1">'.$page['pagename'].'</h5>
                                                 <p class="chat-user-message text-truncate mb-0 badge badge-soft-danger rounded-pill">'.$page['status'].'</p> 
                                              </div>
                                              <div class="unread-message">
                                                  <span class="badge badge-soft-info rounded-pill">'.$page['clientname'].'</span>
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
            <!-- End d-lg-flex  -->
          </div>
          
  		  </div>
        <?php include('footer.html');?>
  	 </div>
    </div>
 
    <!-- paid redeem modal -->
   
     <div class="modal fade" id="viewcustomerhistory_modl" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-size-16" id="createticketLabel">Transaction Records - <span class="text-danger" id="showcustomername"></span></h5>
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
                         
                          <th scope="col">Date Time</th> 
                          <th scope="col">Customer Name</th>
                          <th scope="col">Game Name</th>
                          <th scope="col">Game ID</th> 
                          <th scope="col">Cashtag</th> 
                          <th scope="col">Page Name</th>   
                          <th scope="col">Amount</th>
                          <th scope="col">Paid</th>
                          <th scope="col">Refunded</th> 
                          <th scope="col">Added Back</th>   
                          <th scope="col">Tip</th> 
                          <th scope="col">Agent Name</th> 
                          <th scope="col">Redeem By</th> 
                          <th scope="col">Status</th> 


                        </tr>
                      </thead>
                      <tbody id="searchtransData">
                      
                      </tbody>
                      <tfoot>
                        <tr>
                          
                          <th scope="col">-</th> 
                          <th scope="col">-</th> 
                          <th scope="col">-</th>
                          <th scope="col">-</th>
                          <th scope="col">-</th>   
                          <th scope="col">Total</th>
                          <th scope="col"></th>
                          <th scope="col">-</th> 
                          <th scope="col">-</th> 
                          <th scope="col">-</th> 
                          <th scope="col">-</th> 
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
            <input type="hidden" name="cust_pgid" id="cust_pgid">     
            <input type="hidden" name="cust_nametransaction" id="cust_nametransaction">        
            
            <!-- <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="rdmadddeposit" id="">Save</button>
            </div> -->
            
            
          </div>
        </div>
      </div>
    </div>
  	<div class="rightbar-overlay"></div>

  	<?php include('footer_links.html');?>
    
    <script>
      $(document).ready(function() {
        $(document).on('click','.view_customer_transaction',function(){
          // alert();
          $('#viewcustomerhistory_modl').modal('show');
         
          var pgid= $(this).data('pg_id');
          var name= $(this).data('name');
          $('#showcustomername').html(name);
          $('#cust_nametransaction').val(name);
          $('#cust_pgid').val(pgid);

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
          fetchAndDisplayData(pgid,name, $('#datefrom').val(), $('#dateto').val());
        });

        $('#transearch_keyword').on('click', function() {
          var pgid = $('#cust_pgid').val(); 
          var name = $('#cust_nametransaction').val();
          fetchAndDisplayData(pgid,name, $('#datefrom').val(), $('#dateto').val());
        });

        function fetchAndDisplayData(pgid,name, fromDate, toDate) {
          $.ajax({
            url: 'fetchcustomerhistory.php',
            method: 'POST',
            data: {
              pgid: pgid,
              name: name,
              date_from: fromDate,
              date_to: toDate
            },
            success: function(response) {
              try {
                var data = JSON.parse(response);
                if (Array.isArray(data)) {
                   
                  var rows = '';
                  data.forEach(function(item, index) {
                    var record_time = item.record_time;
                    var cust_name = item.cust_name;
                    var g_name = item.g_name;
                    var ctid = item.ctid;
                    var gid = item.gid;
                    var page_name = item.page_name;
                    var amount = parseFloat(item.amount)|| 0;
                    var amt_paid = parseFloat(item.amt_paid);
                    var amt_refund = parseFloat(item.amt_refund);
                    var amt_addback = parseFloat(item.amt_addback);
                    var tip = parseFloat(item.tip);
                    var record_by = item.record_by;
                    var redeem_by = item.redeem_by;
                    var status = item.status;
                    var addback = parseFloat(item.addback);
                    var amt_bal = parseFloat(item.amt_bal);
                    var total_addedback = amt_addback + addback;
                    var total_tip = tip + amt_bal;

                    rows += `<tr>
                      <td>${record_time}</td>
                      <td>${cust_name}</td>
                      <td>${g_name}</td>
                      <td>${gid}</td>
                      <td>${ctid}</td>
                      <td>${page_name}</td>
                      <td class="bg-danger-subtle  text-center">${amount.toFixed(2)}</td>
                      <td class="bg-success text-white text-center">${amt_paid.toFixed(2)}</td>
                      <td class="bg-info text-white text-center">${amt_refund.toFixed(2)}</td>
                      <td>${total_addedback.toFixed(2)}</td>
                      <td>${total_tip.toFixed(2)}</td>
                      <td>${record_by}</td>
                      <td>${redeem_by}</td>
                      <td><span class="badge rounded-pill bg-success font-size-16">${status}</span></td>
                    </tr>`;
                    
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
                      action: function (e, dt, node, config) {
                          dt.page.len(-1).draw();
                      }
                  }
              ],
              "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
              "footerCallback": function (row, data, start, end, display) {
                  var api = this.api(), data;
                  
                  // Remove the formatting to get integer data for summation
                  var intVal = function (i) {
                      return typeof i === 'string' ?
                          i.replace(/[^\d.-]/g, '') * 1 :
                          typeof i === 'number' ?
                              i : 0;
                  };

                  // Total over all pages
                  var totalAmount = api
                      .column(6)
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0);

                  var totalPaid = api
                      .column(7)
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0);

                  var totalRefund = api
                      .column(8)
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0);

                  var totalAddback = api
                      .column(9)
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0);

                  var totalTip = api
                      .column(10)
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0);

                  // Total over this page
                  var pageTotalAmount = api
                      .column(6, { page: 'current' })
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0);

                  var pageTotalPaid = api
                      .column(7, { page: 'current' })
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0);

                  var pageTotalRefund = api
                      .column(8, { page: 'current' })
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0);

                  var pageTotalAddback = api
                      .column(9, { page: 'current' })
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0);

                  var pageTotalTip = api
                      .column(10, { page: 'current' })
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0);

                  // Update footer
                  $(api.column(6).footer()).html(
                      pageTotalAmount.toFixed(2)
                  );
                  $(api.column(7).footer()).html(
                      pageTotalPaid.toFixed(2)
                  );
                  $(api.column(8).footer()).html(
                      pageTotalRefund.toFixed(2)
                  );
                  $(api.column(9).footer()).html(
                      pageTotalAddback.toFixed(2)
                  );
                  $(api.column(10).footer()).html(
                      pageTotalTip.toFixed(2)
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
  </body>
</html>