
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Deposit Report | SHJ INTERNATIONAL</title>
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
                <h4 class="mb-sm-0 font-size-18">Deposit Report</h4>

                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                    <li class="breadcrumb-item active">Deposit Report</li>
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
                    
                    <div class="tab-pane show active" id="deposit-reports" role="tabpanel">
                      <div class="row">
                        <div class="col-12">
                          <form method="post" action="#" id="searchDepositForm">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="mb-4 position-relative" >
                                  <label for="depositpage_name" class="form-label">Pages Name</label>
                                  <select class="form-control form-select" name="depositpage_name" id="deposit-dropdown" multiple>
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
                          <div class="row align-items-center" id="depositgraphical_report">
                              <div class="col-xl-12">
                                  <div>
                                      <div id="deposit-overview" data-colors='["--bs-primary", "--bs-success"]' class="apex-charts"></div>
                                  </div>
                              </div>
                            </div>
                          <div class="card">
                            <div class="card-body">

                              <table class="table table-sm table-bordered" id="tbl_Depositrecords">
                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th scope="col">Date Time</th>
                                    <th scope="col">Page Name</th>
                                    <th scope="col">Deposits Amount </th>
                                    <th scope="col">Bonus Amount</th>
                                    <th scope="col">%</th>

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
   
    // get deposits document
    $(document).ready(function () {
      $('#deposit-dropdown').select2({
          placeholder: 'Please Select Page',
          width: '100%',
          multiple: true  // Allow multiple selections
      });

      var table = $('#tbl_Depositrecords').DataTable({
          fixedHeader: {
              header: true,
              headerOffset: $('#page-topbar').outerHeight()
          },
          dom: 'Bfrtip',
          buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
          "pageLength": 50,
      });

      var chart;

      $('#searchDepositReport').click(function () {
          var selectedPages = $('#deposit-dropdown').val();
          var searchDateFrom = $('#deposit_datefrom').val();
          var searchDateTo = $('#deposit_dateto').val();

          if (!selectedPages || selectedPages.length === 0) {
              alert('Please select at least one page.');
              return;
          }

          if (!searchDateFrom || !searchDateTo) {
              alert('Please select a date range.');
              return;
          }

          showPreloader();
          var formData = $('#searchDepositForm').serialize();
          formData += '&depositpage_name=' + selectedPages.join(',');  // Send selected pages as comma-separated values
          fetchData(formData);
      });

      $(document).on('click', '#clearfilter', function () {
          $('#searchDepositForm')[0].reset();
          $('#deposit-dropdown').val(null).trigger('change');  // Reset the select2 dropdown
          $('#showDepositData').empty();
          if (chart) {
              chart.destroy();  // Clear the chart data
          }
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
                    $('#showDepositData').html('<p>Error parsing data. Please try again.</p>');
                    hidePreloader();
                    return;
                }

                if (data.length === 0) {
                    $('#showDepositData').html('<p>No data found.</p>');
                    renderChart([]);  // Render an empty chart
                } else {
                    table.destroy();
                    let html = data.map((item, index) =>
                        `<tr>
                            <td>${index + 1}</td>
                            <td>${$('#deposit_datefrom').val()} to ${$('#deposit_dateto').val()}</td>
                            <td>${item.page_name}</td>
                            <td>${item.total_amount}</td>
                            <td>${item.total_bonus}</td>
                            <td>${item.percentage_bonus} %</td>
                        </tr>`
                    ).join('');
                    $('#showDepositData').html(html);
                    table = $('#tbl_Depositrecords').DataTable({
                        fixedHeader: {
                            header: true,
                            headerOffset: $('#page-topbar').outerHeight()
                        },
                        dom: 'Bfrtip',
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                        "pageLength": 50,
                    });
                    renderChart(data);  // Render the chart with new data
                }
                hidePreloader();
            },
            error: function () {
                $('#showDepositData').html('<p>Error occurred. Please try again.</p>');
                hidePreloader();
            }
        });
      }

      function renderChart(data) {
        if (chart) {
          chart.destroy();  // Destroy the previous chart instance if it exists
        }

          // Process the data to extract necessary information for the chart
        var depositAmounts = [];
        var bonusAmounts = [];
        var pageNames = [];

        data.forEach(function (item) {
            depositAmounts.push(parseFloat(item.total_amount));
            bonusAmounts.push(parseFloat(item.total_bonus));
            pageNames.push(item.page_name);
        });

        var options = {
          series: [{
              name: 'Deposits',
              data: depositAmounts
          }, {
              name: 'Bonus',
              data: bonusAmounts
          }],
          chart: {
              type: 'bar',
              height: 400,
              stacked: true,
              toolbar: {
                  show: false
              }
          },
          plotOptions: {
              bar: {
                  columnWidth: '20%'
              }
          },
          colors: getChartColorsArray("#deposit-overview"),
          fill: {
              opacity: 1
          },
          dataLabels: {
              enabled: false
          },
          legend: {
              show: true,
              position: 'top',
              horizontalAlign: 'center',
              fontWeight: 'bold',
              labels: {
                  colors: undefined,
                  useSeriesColors: false,
                  fontSize: '20px !important'  // Increase the font size
              }
          },
          xaxis: {
              categories: pageNames,
              labels: {
                  rotate: -90
              }
          },
          yaxis: {
              labels: {
                  formatter: function (val) {
                      return val.toFixed(0);
                  }
              }
          }
        };

        chart = new ApexCharts(document.querySelector("#deposit-overview"), options);
        chart.render();
      }

      function getChartColorsArray(r) {
        r = $(r).attr("data-colors");
        return (r = JSON.parse(r)).map(function (r) {
            r = r.replace(" ", "");
            if (-1 == r.indexOf("--")) return r;
            r = getComputedStyle(document.documentElement).getPropertyValue(r);
            return r || void 0;
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

</body>
</html>