
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>All Pages Report | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
		<?php include('topheader.php');?>
    <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php 
      if ($type == 'CSR' || $type == 'Q&A' || $type == 'Redeem' || $department=='Redeem') {

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

     $pages='';
     $i='0';
      $query = mysqli_query($connect, "SELECT 
              pages.*,shift_closing_details.*
              FROM 
                pages
              JOIN 
                shift_closing_details ON pages.id = shift_closing_details.pg_id 
              WHERE 
                pages.status = 'active'
              AND 
                shift_closing_details.created_at >= NOW() - INTERVAL 1 DAY
              ORDER BY 
                shift_closing_details.id DESC");
      if(mysqli_num_rows($query) > 0){
        while($row=mysqli_fetch_array($query)){
          // echo "<pre>";
          // print_r($row);
          // exit;
          $i++;
          $id=$row['pg_id'];
          $pagename           =$row['pagename'];
          $cashapp_opening    =$row['cashappopening'];
          $cashapp_closing    =$row['cashappclosing'];
          $cashappdifference  =$row['cashappdifference'];
          $gameopening        =$row['gameopening'];
          $gameclosing        =$row['gameclosing'];
          $gamedifference     =$row['gamedifference'];
          $paidredeem         =$row['redeemclosing'];
          $pending_redeem     =$row['pending_redeem'];
          $cashout            =$row['cashout'];
          $bonus              =$row['bonus'];
          $shift              =$row['shift'];
          $name               =$row['uname'];
          $created_at         =$row['created_at'];

         
          $pages.=
          '<tr>
            <td>'.$i.'</td>
            <td>'.$pagename.'</td>
            <td>'.$cashapp_opening.'</td>
            <td>'.$cashapp_closing.'</td>
            <td>'.$cashappdifference.'</td>
            <td>'.$gameopening.'</td>
            <td>'.$gameclosing.'</td>
            <td>'.$gamedifference.'</td>
            <td>'.$paidredeem.'</td>
            <td>'.$pending_redeem.'</td>
            <td>'.$cashout.'</td>
            <td>'.$bonus.'</td>
            <td>'.$shift.'</td>
            <td>'.$name.'</td>
            <td>'.$created_at.'</td>
            
            
          </tr>
          ';
         
        }
      }
      $html='';
      $query = mysqli_query($connect, "
        SELECT 
            pages.*, 
            COUNT(redeem.id) AS pending_redeem_count
        FROM 
            pages
        LEFT JOIN 
            redeem ON pages.id = redeem.pg_id AND redeem.status = 'Pending' AND del='0'
        WHERE 
            pages.status = 'active'
        GROUP BY 
            pages.id, pages.pagename
        ORDER BY 
            pages.pagename ASC;
        "
      );


      if(mysqli_num_rows($query) > 0){
          while($row=mysqli_fetch_array($query)){
            $id=$row['id'];
            $pagename=$row['pagename'];
            $html.='<option value="'.$row['id'].'">'.$row['pagename'].'</option>';
            // echo "<pre>";
            //  print_r($row); 
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
                  <div class="row">
                    <div class="col-12">
                      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">All Pages Reports</h4>

                        <div class="page-title-right">
                          <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                            <li class="breadcrumb-item active">All Pages Reports</li>
                          </ol>
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="row">
            <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      
                    <ul class="nav nav-pills" role="tablist">
                      <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#allpagesreports" id="opentickets" role="tab" aria-selected="true">
                          <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                          <span class="d-none d-sm-block">Pages Reports</span> 
                        </a>
                      </li>
                      <?php if($profitreport==1 || $type=='Webmaster'):?>
                        <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                          <a class="nav-link" data-bs-toggle="tab" href="#profit-reports" id="profitreports" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Profit Reports</span> 
                          </a>
                        </li>
                      <?php endif;?>
                      <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#deposit-reports" id="depositreports" role="tab" aria-selected="false" tabindex="-1">
                          <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                          <span class="d-none d-sm-block">Deposit Reports</span> 
                        </a>
                      </li>
                      <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#deposit-history" id="deposithistory" role="tab" aria-selected="false" tabindex="-1">
                          <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                          <span class="d-none d-sm-block">Deposit History</span> 
                        </a>
                      </li>
                      
                    </ul>

                      <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                      <div class="tab-pane active show" id="allpagesreports" role="tabpanel">
                        <div class="row">
                          <div class="col-12">
                            <div class="card">
                              
                              <div class="card-body">
  
                                <table class="table table-sm table-bordered" id="tbl_pagesrecords">
                                  <thead>
                                    <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">Page Name</th>
                                      <th scope="col">Cashapp Opening </th>
                                      <th scope="col">Cashapp Closing</th>
                                      <th scope="col">Cashapp Diff</th>
                                      <th scope="col">Game Opening  </th>
                                      <th scope="col">Game Closing </th>
                                      <th scope="col">Game Diff</th>
                                      <th scope="col">Redeem Paid </th>
                                      <th scope="col">Pending Redeem</th>
                                      <th scope="col">Cashout</th>
                                      <th scope="col">Bonus</th>
                                      <th scope="col">Shift</th>
                                      <th scope="col">Username</th>
                                      <th scope="col">Shift Closed Time</th>
                                      
                                    </tr>
                                  </thead>
                                  <tbody>
                                     <?php echo $pages;?> 
                                  </tbody>
                                   
                                </table>
  
                              </div>
                            </div>
                          </div> <!-- end col -->
                        </div>
                      </div>
                      <?php if($profitreport==1 || $type=='Webmaster'):?>
                        <div class="tab-pane" id="profit-reports" role="tabpanel">
                          <div class="row">
                            <div class="col-12">
                              <form method="post" action="#" id="searchform">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="mb-4 position-relative" >
                                      <label for="clientpage_name" class="form-label">Pages Name</label>
                                      <select class="form-control form-select" name="clientpage_name" id="page_dropdown">
                                        <option value="0">--Select Page--</option>
                                        <option value="all">All</option>
                                          <?php echo $html;?>

                                      </select>
                                     
                                    </div>
                                  </div>
                                    
                                  <div class="col-md-6">
                                    <div class="mb-4" >
                                      <label for="search_datefrom" class="form-label">Date From</label>
                                      <input type="text" class="form-control" name="search_datefrom" id="search_datefrom">
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="mb-4" >
                                      <label for="search_dateto" class="form-label">Date To</label>
                                      <input type="text" class="form-control" name="search_dateto" id="search_dateto">
                                    </div>
                                  </div>
                                  
                                  <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button> -->
                                    <button type="button" class="btn btn-primary" name="searchReport" id="searchReport">Search</button>
                                     <button type="reset" class="btn btn-primary m-2" id="clearfilter">Clear Search Filter</button>
                                  </div>
                                  
                                  
                                </div>
                              </form>
                              <div class="row align-items-center" id="graphical_report">
                                <div class="col-xl-12">
                                    <div>
                                        <div id="market-overview" data-colors='["#5156be", "#34c38f"]' class="apex-charts"></div>
                                    </div>
                                </div>
                              </div>
                              <div class="card">
                                <div class="card-body">
    
                                  <table class="table table-sm table-bordered" id="tbl_profitrecords">
                                    <thead>
                                      <tr>
                                        
                                        <th scope="col">Page Name</th>
                                        <th scope="col">Cashapp Opening </th>
                                        <th scope="col">Cashapp Closing</th>
                                        <th scope="col">Cashout Amount</th>
                                        <th scope="col">Paid Redeem Amount</th>
                                        <th scope="col">Pending Redeem Amount</th>
                                        <th scope="col">Total Deposits</th>
                                        <th scope="col">Total Profit</th>

                                        
                                        
                                      </tr>
                                    </thead>
                                    <tbody id="showprofitdata">
                                       
                                    </tbody>
                                     
                                  </table>
    
                                </div>
                              </div>
                            </div> <!-- end col -->
                          </div>
                        </div>
                      <?php endif;?>
                      <div class="tab-pane" id="deposit-reports" role="tabpanel">
                        <div class="row">
                          <div class="col-12">
                            <form method="post" action="#" id="searchDepositForm">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="mb-4 position-relative" >
                                    <label for="depositpage_name" class="form-label">Pages Name</label>
                                    <select class="form-control form-select" name="depositpage_name" id="deposit-dropdown">
                                      <option value="0">--Select Page--</option>
                                      <option value="all">All</option>
                                        <?php echo $html;?>

                                    </select>
                                   
                                  </div>
                                </div>
                                  
                                <div class="col-md-6">
                                  <div class="mb-4" >
                                    <label for="deposit_datefrom" class="form-label">Date From</label>
                                    <input type="text" class="form-control" name="deposit_datefrom" id="deposit_datefrom">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="mb-4" >
                                    <label for="deposit_dateto" class="form-label">Date To</label>
                                    <input type="text" class="form-control" name="deposit_dateto" id="deposit_dateto">
                                  </div>
                                </div>
                                
                                <div class="modal-footer">
                                  <!-- <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button> -->
                                  <button type="button" class="btn btn-primary" name="searchDepositReport" id="searchDepositReport">Search</button>
                                   <button type="reset" class="btn btn-primary m-2" id="clearfilter">Clear Search Filter</button>
                                </div>
                                
                                
                              </div>
                            </form>
                            <div class="card">
                              <div class="card-body">
  
                                <table class="table table-sm table-bordered" id="tbl_Depositrecords">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th scope="col">Page Name</th>
                                      <th scope="col">Deposits Amount </th>
                                      <th scope="col">Bonus Amount</th>
                                      <th scope="col">Created At</th>

                                    </tr>
                                  </thead>
                                  <tbody id="showDepositData">
                                     
                                  </tbody>
                                   
                                </table>
  
                              </div>
                            </div>
                          </div> <!-- end col -->
                        </div>
                      </div>
                      <div class="tab-pane" id="deposit-history" role="tabpanel">
                        <div class="row">
                          <div class="col-12">
                            <div class="card">
                              <div class="card-body">
  
                                <table class="table table-bordered" id="tbl_DepositHistory" style="width: 100%">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th scope="col">Page Name</th>
                                      <th scope="col">Game ID </th>
                                      <th scope="col">Amount</th>
                                      <th scope="col">Bonus</th>
                                      <th scope="col">User</th>
                                      <th scope="col">Created At</th>
                                      <th scope="col">Action</th>

                                    </tr>
                                  </thead>
                                  <tbody id="showDepositHistory">
                                     
                                  </tbody>
                                   
                                </table>
  
                              </div>
                            </div>
                          </div> <!-- end col -->
                        </div>
                      </div>
                      
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
  <script>
    // get profit document
    $(document).ready(function () {
      var table = $('#tbl_profitrecords').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        "pageLength": 50,
      });

      $('#searchReport').click(function () {
        var selectedPage = $('#page_dropdown').val();
        var searchDateFrom = $('#search_datefrom').val();
        var searchDateTo = $('#search_dateto').val();

        if (!selectedPage || selectedPage === '0') {
          alert('Please select a page.');
           return;
        }

        if (!searchDateFrom || !searchDateTo) {
          alert('Please select a date range.');
          return;
        }
        showPreloader();
        var formData = $('#searchform').serialize();
        if (selectedPage === 'all') {
          formData += '&clientpage_name=all';
        }
        fetchData(formData);
      });


      $(document).on('click', '#clearfilter', function () {
        $('#searchform')[0].reset();
        $('#showprofitdata').empty();
      });

      function fetchData(formData) {
        $.ajax({
          type: 'POST',
          url: 'fetch_profitpages_list.php',
          data: formData,
          success: function (response) {
              if (response.trim() === '') {
                  $('#showprofitdata').html('<p>No data found.</p>');
              } else {
                  table.destroy();
                  $('#showprofitdata').html(response);
                  table = $('#tbl_profitrecords').DataTable({
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                      "pageLength": 50,
                  });
              }
              hidePreloader();
          },
          error: function () {
              $('#showprofitdata').html('<p>Error occurred. Please try again.</p>');
              hidePreloader();
          }
        });
      }

      function showPreloader() {
          Pace.restart();
      }

      function hidePreloader() {
          Pace.stop();
      }
    });
    // get deposits document
    $(document).ready(function () {
      var table = $('#tbl_Depositrecords').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        "pageLength": 50,
      });

      $('#searchDepositReport').click(function () {
        var selectedPage = $('#deposit-dropdown').val();
        var searchDateFrom = $('#deposit_datefrom').val();
        var searchDateTo = $('#deposit_dateto').val();

        if (!selectedPage || selectedPage === '0') {
          alert('Please select a page.');
           return;
        }

        if (!searchDateFrom || !searchDateTo) {
          alert('Please select a date range.');
          return;
        }
        showPreloader();
        var formData = $('#searchDepositForm').serialize();
        if (selectedPage === 'all') {
          formData += '&depositpage_name=all';
        }
        fetchData(formData);
      });


      $(document).on('click', '#clearfilter', function () {
        $('#searchDepositForm')[0].reset();
        $('#showDepositData').empty();
      });

      function fetchData(formData) {
        $.ajax({
          type: 'POST',
          url: 'fetch_profitpages_list.php',
          data: formData,
          success: function (response) {
              if (response.trim() === '') {
                  $('#showDepositData').html('<p>No data found.</p>');
              } else {
                  table.destroy();
                  $('#showDepositData').html(response);
                  table = $('#tbl_Depositrecords').DataTable({
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                      "pageLength": 50,
                  });
              }
              hidePreloader();
          },
          error: function () {
              $('#showDepositData').html('<p>Error occurred. Please try again.</p>');
              hidePreloader();
          }
        });
      }

      function showPreloader() {
          Pace.restart();
      }

      function hidePreloader() {
          Pace.stop();
      }
    });
  </script>
  <script type="text/javascript">
    $("#search_datefrom,#deposit_datefrom").datetimepicker({
      dateFormat: 'yy-mm-dd',
      timeFormat: 'HH:mm:ss'
    });
    $("#search_dateto,#deposit_dateto").datetimepicker({
      dateFormat: 'yy-mm-dd',
      timeFormat: 'HH:mm:ss'
    });
  </script>
  <script>
    $(document).ready(function() {
      var storeright  ='<?php echo $storeright?>';
      var role   ='<?php echo $type?>';
      
      var table =$('#tbl_DepositHistory').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url": "fetch_deposits_details.php", 
          "type": "POST"
             
        },
        "columns": [
            { "data": "id" },
            { "data": "pagename" },
            { "data": "gm_id" },
            { "data": "amount" },
            { "data": "bonus" },
            { "data": "uname" },
            { "data": "created_at" },
            {
              "data": null,
              "render": function(data, type, row) {
                if (storeright == '1' || role == "Webmaster") {
                  return '<button class="btn btn-danger delete-btn" data-id="' + row.id + '">Delete</button>';
                }else{
                  return '-';
                }
              }
            }
        ]
      });
      $('#tbl_DepositHistory').on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        var clickedButton = $(this); // Reference to the clicked button
        if (confirm('Are you sure you want to delete this record?')) {
          $.ajax({
              url: 'delete_deposit.php',
              type: 'POST',
              data: { id: id },
              success: function(response) {
                var result = JSON.parse(response);
                if (result.status === 'success') {
                  alert(result.message);
                  // Remove the row from the DataTable
                  table.row(clickedButton.closest('tr')).remove();
                  // Redraw the table to reflect the changes
                  table.draw(false);
                } else {
                    alert(result.message);
                }
              },
              error: function(xhr, status, error) {
                  alert('An error occurred: ' + xhr.responseText);
              }
          });
        }
      });
    });
  </script>
  <script>
    function getChartColorsArray(r) {
      r = $(r).attr("data-colors");
      return (r = JSON.parse(r)).map(function(r) {
        r = r.replace(" ", "");
        if (-1 == r.indexOf("--")) return r;
        r = getComputedStyle(document.documentElement).getPropertyValue(r);
        return r || void 0
      })
    }
    var barchartColors = getChartColorsArray("#market-overview"),
  options = {
    series: [{
      name: "Profit",
      data: [12.45, 16.2, 8.9, 11.42, 12.6, 18.1, 18.2, 14.16, 11.1, 8.09, 16.34, 12.88]
    }, {
      name: "Loss",
      data: [-11.45, -15.42, -7.9, -12.42, -12.6, -18.1, -18.2, -14.16, -11.1, -7.09, -15.34, -11.88]
    }],
    chart: {
      type: "bar",
      height: 400,
      stacked: !0,
      toolbar: {
        show: !1
      }
    },
    plotOptions: {
      bar: {
        columnWidth: "20%"
      }
    },
    colors: barchartColors,
    fill: {
      opacity: 1
    },
    dataLabels: {
      enabled: !1
    },
    legend: {
      show: !1
    },
    yaxis: {
      labels: {
        formatter: function(r) {
          return r.toFixed(0) + "%"
        }
      }
    },
    xaxis: {
      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      labels: {
        rotate: -90
      }
    }
  };
(chart = new ApexCharts(document.querySelector("#market-overview"), options)).render();
  </script>  
</body>
</html>