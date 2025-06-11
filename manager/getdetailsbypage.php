
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Page Details | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
    <style>
      .apexcharts-legend-text{
        font-size: 20px !important;
      }
    </style>
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
      if(isset($_GET['pageid']) && $_GET['pageid']!=''){
        $pgid=$_GET['pageid'];
        
       $pgname=''; 
       $pages='';
       $i='0';
        $query = mysqli_query($connect, "SELECT 
                pages.*,shift_closing_details.*,
                (shift_closing_details.cashappclosing - shift_closing_details.cashappopening + shift_closing_details.redeemclosing + shift_closing_details.cashout) AS total_deposit,
                (shift_closing_details.cashappclosing - shift_closing_details.cashappopening - shift_closing_details.pending_redeem + shift_closing_details.cashout) AS total_profit
                FROM 
                  pages
                JOIN 
                  shift_closing_details ON pages.id = shift_closing_details.pg_id 
                WHERE 
                  pages.status = 'active'
                AND 
                  shift_closing_details.pg_id=$pgid
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
            $gamedifference     =abs($row['gamedifference']);
            $paidredeem         =$row['redeemclosing'];
            $pending_redeem     =$row['pending_redeem'];
            $redeem_for_other          =$row['redeem_for_other'];
            $cashout            =$row['cashout'];
            $bonus              =$row['bonus'];
            $shift              =$row['shift'];
            $name               =$row['uname'];
            $created_at         =$row['created_at'];
            // $unknowndiff        =$gamedifference-$cashappdifference-$bonus;
            $cashappclosingtotal       = $cashapp_closing+$redeem_for_other;
            $cashapp_diff  = abs($cashappclosingtotal-$cashapp_opening);
            $values = [$gamedifference, $cashapp_diff, $bonus, $cashout, $pending_redeem];
            rsort($values);
            $unknowndiff = array_shift($values); // Initialize unknowndiff with the first value

            foreach ($values as $value) {
              if ($unknowndiff > $value) {
                  $unknowndiff -= $value;
              } else {
                  $unknowndiff = $value - $unknowndiff;
              }
            }
            // $unknowndiff        =$gamedifference-$cashappdifference-$bonus-$cashout-$pending_redeem;
            $pgname             =$row['pagename'];
            $total_deposit      =$row['total_deposit'];
            $total_profit       =$row['total_profit'];

           
            $pages.=
            '<tr>
              <td>'.$i.'</td>
              <td>'.$pagename.'</td>
              <td>'.$cashapp_opening.'</td>
              <td>'.$cashapp_closing.'</td>
              <td>'.$cashapp_diff.'</td>
              <td>'.$gameopening.'</td>
              <td>'.$gameclosing.'</td>
              <td>'.$gamedifference.'</td>
              <td>'.$paidredeem.'</td>
              <td>'.$pending_redeem.'</td>
              <td>'.$cashout.'</td>
              <td>'.$bonus.'</td>
              <td>'.$total_deposit.'</td>
              <td>'.$total_profit.'</td>
              <td>'.$unknowndiff.'</td>
              <td>'.$shift.'</td>
              <td>'.$name.'</td>
              <td>'.$created_at.'</td>
              
              
            </tr>
            ';
           
          }
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
                <h4 class="mb-sm-0 font-size-18"><?php echo $pgname;?></h4>

                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                    <li class="breadcrumb-item active"><?php echo $pgname;?></li>
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
                    
                    
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active show" id="allpagesreports" role="tabpanel">
                      <div class="row">
                        <div class="col-12">
                          <form method="post" action="#" id="singlesearchform">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="mb-4 position-relative" >
                                  <label for="singlepgname" class="form-label">Pages Name</label>
                                  <select class="form-control form-select" name="singlepgname" id="single_dropdown">
                                    <option value="<?php echo $pgid;?>"><?php echo $pgname;?></option>

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
                                <button type="button" class="btn btn-primary" name="singleReport" id="singleReport">Search</button>
                                 <button type="reset" class="btn btn-primary m-2" id="clearfilter">Clear Search Filter</button>
                              </div>
                              
                              
                            </div>
                            </form>
                          <div class="card">
                            
                            <div class="card-body">

                              <table class="table table-sm table-bordered" id="tbl_singlepagesrecord">
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
                                    <th scope="col">Deposit</th>
                                    <th scope="col">Profit</th>
                                    <th scope="col">Unknown Diff</th>
                                    <th scope="col">Shift</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Shift Closed Time</th>
                                    
                                  </tr>
                                </thead>
                                <tbody id="singlePageDetails">
                                   <?php echo $pages;?> 
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
      var table = initializeDataTable();
      
      $('#singleReport').click(function () {
        var selectedPage = $('#single_dropdown').val();
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
        var formData = $('#singlesearchform').serialize();
        fetchData(formData);
      });


      $(document).on('click', '#clearfilter', function () {
        $('#singlesearchform')[0].reset();
        $('#singlePageDetails').empty();
        
      });

      function fetchData(formData) {
        $.ajax({
          type: 'POST',
          url: 'fetch_profitpages_list.php',
          data: formData,
          success: function (response) {
            var data = JSON.parse(response);
              if (data.length === 0) {
                $('#singlePageDetails').html('<p>No data found.</p>');
                
              } else {
                updateTable(data);
                
              }
            hidePreloader();
          },
          error: function () {
              $('#singlePageDetails').html('<p>Error occurred. Please try again.</p>');
              hidePreloader();
          }
        });
      }

      function updateTable(data) {
        table.destroy();
        var html = '';
        var i = 1;
        data.forEach(function (item) {
            html += `<tr>
                    <td>${i++}</td>
                    <td>${item.page_name}</td>
                    <td>${item.cashappopening}</td>
                    <td>${item.cashappclosing}</td>
                    <td>${item.cashappdifference}</td>
                    <td>${item.gameopening}</td>
                    <td>${item.gameclosing}</td>
                    <td>${item.gamedifference}</td>
                    <td>${item.redeemclosing}</td>
                    <td>${item.pending_redeem}</td>
                    <td>${item.cashout}</td>
                    <td>${item.bonus}</td>
                    <td>${item.total_deposit}</td>
                    <td>${item.total_profit}</td> 
                    <td>${item.unknowndiff}</td>
                    <td>${item.shift}</td>
                    <td>${item.uname}</td>
                    <td>${item.created_at}</td>
                </tr>`;
        });
        $('#singlePageDetails').html(html);
        table = initializeDataTable();
      }

      function initializeDataTable() {
        return $('#tbl_singlepagesrecord').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            "pageLength": 10,
            scrollX: true
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
    $("#search_datefrom,#deposit_datefrom,#history_datefrom").datetimepicker({
      dateFormat: 'yy-mm-dd',
      timeFormat: 'HH:mm:ss'
    });
    $("#search_dateto,#deposit_dateto,#history_dateto").datetimepicker({
      dateFormat: 'yy-mm-dd',
      timeFormat: 'HH:mm:ss'
    });

  </script>

</body>
</html>