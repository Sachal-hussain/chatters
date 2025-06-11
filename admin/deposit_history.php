
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Deposit History | SHJ INTERNATIONAL</title>
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
      if ($type == 'CSR' || $type == 'Q&A' || $type == 'Redeem' || $type=='Manager') {

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
                <h4 class="mb-sm-0 font-size-18">Deposit History</h4>

                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item active">Deposit History</li>
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
                   
                    <div class="tab-pane active show" id="deposit-history" role="tabpanel">
                      <div class="row">
                        <div class="col-12">
                          <form method="post" action="#" id="pagehistoryform">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="mb-4 position-relative" >
                                  <label for="historypage_name" class="form-label">Pages Name</label>
                                  <select class="form-control form-select" name="historypage_name" id="history_dropdown">
                                    <option value="0">--Select Page--</option>
                                    <option value="all">All</option>
                                      <?php echo $html;?>

                                  </select>
                                 
                                </div>
                              </div>
                                
                              <div class="col-md-6">
                                <div class="mb-4" >
                                  <label for="history_datefrom" class="form-label">Date From</label>
                                  <input type="text" class="form-control" name="history_datefrom" id="history_datefrom">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="mb-4" >
                                  <label for="history_dateto" class="form-label">Date To</label>
                                  <input type="text" class="form-control" name="history_dateto" id="history_dateto">
                                </div>
                              </div>
                              
                              <div class="modal-footer">
                                <!-- <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button> -->
                                <button type="button" class="btn btn-primary" name="historyReport" id="historyReport">Search</button>
                                 <button type="reset" class="btn btn-primary m-2" id="clearfilter">Clear Search Filter</button>
                              </div>
                              
                              
                            </div>
                          </form>
                          <div class="card">
                            <div class="card-body">

                              <table class="table table-bordered" id="tbl_DepositHistory" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th scope="col">Date Time</th>
                                    <th scope="col">Page Name</th>
                                    <th scope="col">Game ID </th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Bonus</th>
                                    <th scope="col"  class="bg-danger-subtle  text-center">Tag</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Action</th>

                                  </tr>
                                </thead>
                                <tbody id="pageHistorydetails">
                                   
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th colspan="3" style="text-align:center;">Total:</th>
                                    <th id="total_amount"></th>
                                    <th id="total_bonus"></th>
                                    <th colspan="3"></th>
                                  </tr>
                                </tfoot>
                                 
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
  <script>
    $(document).ready(function() {
      var storeright  ='<?php echo $storeright?>';
      var role   ='<?php echo $type?>';
      
      var table =$('#tbl_DepositHistory').DataTable({
        fixedHeader: {
          header: true,
          headerOffset: $('#page-topbar').outerHeight()
        },
         "order": [[0, 'desc']],
        "processing": true,
        "serverSide": true,
        "ajax": {
          "url": "fetch_deposits_details.php", 
          "type": "POST"
             
        },
        "columns": [
          { "data": "id" },
          { "data": "created_at" },
          { "data": "pagename" },
          { "data": "gm_id" },
          { "data": "amount" },
          { "data": "bonus" },
          { 
            "data": "tag",
            "createdCell": function(td, cellData, rowData, row, col) {
              $(td).addClass('bg-danger-subtle text-center');
            } 
          },
          { "data": "uname" },
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
        ],
        "footerCallback": function(row, data, start, end, display) {
          var api = this.api();

          // Calculate total for the current page
          var totalAmount = api
            .column(4, { page: 'current' })
            .data()
            .reduce(function(a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0);

          var totalBonus = api
            .column(5, { page: 'current' })
            .data()
            .reduce(function(a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0);

          // Update the footer
          $(api.column(4).footer()).html(totalAmount.toFixed(2));
          $(api.column(5).footer()).html(totalBonus.toFixed(2));
        },
        "dom": 'Bfrtip',
        "buttons": [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pageLength": 10
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

      $('#historyReport').click(function () {
        var selectedPage = $('#history_dropdown').val();
        var searchDateFrom = $('#history_datefrom').val();
        var searchDateTo = $('#history_dateto').val();

        if (!selectedPage || selectedPage === '0') {
          alert('Please select a page.');
          return;
        }

        if (!searchDateFrom || !searchDateTo) {
          alert('Please select a date range.');
          return;
        }

        showPreloader();
        var formData = $('#pagehistoryform').serialize();
        if (selectedPage === 'all') {
          formData += '&historypage_name=all';
        }
        fetchData(formData);
      });

      $(document).on('click', '#clearfilter', function () {
        $('#pagehistoryform')[0].reset();
        $('#pageHistorydetails').empty();
        
      });

      function fetchData(formData) {
        $.ajax({
          type: 'POST',
          url: 'fetch_profitpages_list.php',
          data: formData,
          success: function (response) {
            let data;
            try {
              data = JSON.parse(response);
            } catch (e) {
              console.error('Parsing error:', e);
              $('#pageHistorydetails').html('<p>Error parsing data. Please try again.</p>');
              hidePreloader();
              return;
            }

            if (data.length === 0) {
              $('#pageHistorydetails').html('<p>No data found.</p>');
               
            } 
            else {
              table.destroy();
              let html = data.map((item, index) => 
                  `<tr>
                      <td>${item.depositid}</td>
                      <td>${item.created_at}</td>
                      <td>${item.page_name}</td>
                      <td>${item.gm_id}</td>
                      <td>${item.amount}</td>
                      <td>${item.bonus}</td>
                      <td class="bg-danger-subtle  text-center">${item.tag}</td>
                      <td>${item.user}</td>
                     <td>${
                          (storeright == '1' || role == "Webmaster") 
                          ? '<button class="btn btn-danger delete-btn" data-id="' + item.depositid + '">Delete</button>'
                          : '-'
                      }</td>
                      
                  </tr>`
              ).join('');
              $('#pageHistorydetails').html(html);
              table = $('#tbl_DepositHistory').DataTable({
                fixedHeader: {
                  header: true,
                  headerOffset: $('#page-topbar').outerHeight()
                },
                dom: 'Bfrtip',
                buttons: [
                  'copy', 'csv', 'excel', 'pdf', 'print',
                  {
                    text: 'Show All',
                    action: function ( e, dt, node, config ) {
                      dt.page.len(-1).draw();
                    }
                  },
                  {
                    text: 'Show 10',
                    action: function ( e, dt, node, config ) {
                      dt.page.len(10).draw();
                    }
                  }
                ],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "pageLength": 10,
                "footerCallback": function(row, data, start, end, display) {
                  var api = this.api();

                  // Calculate total for the current page
                  var totalAmount = api
                  .column(4, { page: 'current' })
                  .data()
                  .reduce(function(a, b) {
                      return parseFloat(a) + parseFloat(b);
                  }, 0);

                  var totalBonus = api
                  .column(5, { page: 'current' })
                  .data()
                  .reduce(function(a, b) {
                      return parseFloat(a) + parseFloat(b);
                  }, 0);

                  // Update the footer
                  $(api.column(4).footer()).html(totalAmount.toFixed(2));
                  $(api.column(5).footer()).html(totalBonus.toFixed(2));
                }
              });
            }
            hidePreloader();
          },
          error: function () {
            $('#pageHistorydetails').html('<p>Error occurred. Please try again.</p>');
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

</body>
</html>