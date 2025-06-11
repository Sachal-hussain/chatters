
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Profit Report | SHJ INTERNATIONAL</title>
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

     $pages='';
     
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
                        <h4 class="mb-sm-0 font-size-18">Profit Report</h4>

                        <div class="page-title-right">
                          <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Profit Report</li>
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
                      <!-- <li class="nav-item waves-effect waves-light bg-primary-subtle m-1" role="presentation">
                          <a class="nav-link" data-bs-toggle="tab" href="#profit-reports" id="profitreports" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Profit Reports</span> 
                          </a>
                      </li> -->
                      
                    </ul>

                      <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                      
                     
                      <div class="tab-pane active show" id="profit-reports" role="tabpanel">
                          <div class="row">
                            <div class="col-12">
                              <form method="post" action="#" id="searchform">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="mb-4 position-relative" >
                                      <label for="clientpage_name" class="form-label">Pages Name</label>
                                      <select class="form-control form-select" name="clientpage_name[]" id="page_dropdown" multiple>
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
                                        <div id="market-overview" data-colors='["--bs-primary", "--bs-success", "--bs-danger"]' class="apex-charts"></div>
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
    // $(document).ready(function () {
    //   $('#page_dropdown').select2({
    //     placeholder:'Please Employee',
    //     width:'100%'
    //   })
    //   var table = $('#tbl_profitrecords').DataTable({
    //     fixedHeader: {
    //       header: true,
    //       headerOffset: $('#page-topbar').outerHeight()
    //     },
    //     dom: 'Bfrtip',
    //     buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    //     "pageLength": 50,
    //   });
    //   var chart;
    //   $('#searchReport').click(function () {
    //     var selectedPage = $('#page_dropdown').val();
    //     var searchDateFrom = $('#search_datefrom').val();
    //     var searchDateTo = $('#search_dateto').val();

    //     if (!selectedPage || selectedPage === '0') {
    //       alert('Please select a page.');
    //        return;
    //     }

    //     if (!searchDateFrom || !searchDateTo) {
    //       alert('Please select a date range.');
    //       return;
    //     }
    //     showPreloader();
    //     var formData = $('#searchform').serialize();
    //     if (selectedPage === 'all') {
    //       formData += '&clientpage_name=all';
    //     }
    //     fetchData(formData);
    //   });


    //   $(document).on('click', '#clearfilter', function () {
    //     $('#searchform')[0].reset();
    //     $('#showprofitdata').empty();
    //     if (chart) {
    //       chart.destroy();
    //     }
    //   });

    //   function fetchData(formData) {
    //     $.ajax({
    //       type: 'POST',
    //       url: 'fetch_profitpages_list.php',
    //       data: formData,
    //       success: function (response) {
    //         var data = JSON.parse(response);
    //           if (data.length === 0) {
    //             $('#showprofitdata').html('<p>No data found.</p>');
    //             if (chart) {
    //                 chart.destroy();
    //             }
    //           } else {
    //             updateTable(data);
    //             updateChart(data);
    //           }
    //         hidePreloader();
    //       },
    //       error: function () {
    //           $('#showprofitdata').html('<p>Error occurred. Please try again.</p>');
    //           hidePreloader();
    //       }
    //     });
    //   }

    //   function updateTable(data) {
    //     table.destroy();
    //     var html = '';
    //     data.forEach(function (item) {
    //         html += `<tr>
    //                     <td><a href="getdetailsbypage.php?pageid=${item.pageid}" target="_blank">${item.page_name}</a></td>
    //                     <td>${item.total_cashappopening}</td>
    //                     <td>${item.total_cashappclosing}</td>
    //                     <td>${item.total_cashout}</td>
    //                     <td>${item.total_redeemclosing}</td>
    //                     <td>${item.total_pending_redeem}</td>
    //                     <td>${item.total_deposit}</td>
    //                     <td>${item.total_profit}</td>
    //                 </tr>`;
    //     });
    //     $('#showprofitdata').html(html);
    //     table = $('#tbl_profitrecords').DataTable({
    //       fixedHeader: {
    //         header: true,
    //         headerOffset: $('#page-topbar').outerHeight()
    //       },
    //       dom: 'Bfrtip',
    //       buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    //       "pageLength": 50,
    //     });
    //   }

    //   function updateChart(data) {
    //     var labels = data.map(function (item) { return item.page_name; });
    //     var cashappOpening = data.map(function (item) { return item.total_cashappopening; });
    //     var cashappClosing = data.map(function (item) { return item.total_cashappclosing; });
    //     var cashout = data.map(function (item) { return item.total_cashout; });
    //     var redeemClosing = data.map(function (item) { return item.total_redeemclosing; });
    //     var pendingRedeem = data.map(function (item) { return item.total_pending_redeem; });
    //     var totalDeposit = data.map(function (item) { return item.total_deposit; });
    //     var totalProfit = data.map(function (item) { return item.total_profit; });

    //     var barchartColors = getChartColorsArray("#market-overview");

    //     if (chart) {
    //         chart.destroy();
    //     }

    //     var options = {
    //       series: [
    //       {
    //         name: "Total Deposit",
    //         data: totalDeposit
    //       }, {
    //         name: "Total Profit",
    //         data: totalProfit
    //       },
    //       {
    //         name: "Total Paid Redeem",
    //         data: redeemClosing
    //       }
    //       ],
    //       chart: {
    //         type: "bar",
    //         height: 400,
    //         stacked: true,
    //         toolbar: {
    //             show: false
    //         }
    //       },
    //       plotOptions: {
    //         bar: {
    //           columnWidth: "20%"
    //         }
    //       },
    //       colors: barchartColors,
    //       fill: {
    //         opacity: 1
    //       },
    //       dataLabels: {
    //         enabled: false
    //       },
    //       legend: {
    //         show: true,
    //         position: 'top',
    //         horizontalAlign: 'center',
    //         fontWeight: 'bold',
    //         labels: {
    //             colors: undefined,
    //             useSeriesColors: false,
    //             fontSize: '20px'  // Increase the font size
    //         }
    //       },
    //       yaxis: {
    //         labels: {
    //           formatter: function (val) {
    //             return val.toFixed(2);
    //           }
    //         }
    //       },
    //       xaxis: {
    //         categories: labels,
    //         labels: {
    //             rotate: -90
    //         }
    //       }
    //     };

    //     chart = new ApexCharts(document.querySelector("#market-overview"), options);
    //     chart.render();
    //   }

    //   function getChartColorsArray(r) {
    //       r = $(r).attr("data-colors");
    //       return (r = JSON.parse(r)).map(function (r) {
    //           r = r.replace(" ", "");
    //           if (-1 == r.indexOf("--")) return r;
    //           r = getComputedStyle(document.documentElement).getPropertyValue(r);
    //           return r || void 0;
    //       });
    //   }

    //   function showPreloader() {
    //       Pace.restart();
    //   }

    //   function hidePreloader() {
    //       Pace.stop();
    //   }
    // });
    $(document).ready(function () {
      $('#page_dropdown').select2({
        placeholder: 'Please Select Page',
        width: '100%'
      });

      var table = $('#tbl_profitrecords').DataTable({
        fixedHeader: {
          header: true,
          headerOffset: $('#page-topbar').outerHeight()
        },
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        "pageLength": 50,
      });

      var chart;

      $('#searchReport').click(function () {
        var selectedPages = $('#page_dropdown').val();
        var searchDateFrom = $('#search_datefrom').val();
        var searchDateTo = $('#search_dateto').val();

        if (!selectedPages || selectedPages.length === 0 || (selectedPages.length === 1 && selectedPages[0] === '0')) {
          alert('Please select a page.');
          return;
        }

        if (!searchDateFrom || !searchDateTo) {
          alert('Please select a date range.');
          return;
        }

        showPreloader();
        var formData = $('#searchform').serialize();

        fetchData(formData);
      });

      $(document).on('click', '#clearfilter', function () {
        $('#searchform')[0].reset();
        $('#showprofitdata').empty();
        if (chart) {
          chart.destroy();
        }
      });

      function fetchData(formData) {
        $.ajax({
          type: 'POST',
          url: 'fetch_profitpages_list.php',
          data: formData,
          success: function (response) {
            var data = JSON.parse(response);
            if (data.length === 0) {
              $('#showprofitdata').html('<p>No data found.</p>');
              if (chart) {
                chart.destroy();
              }
            } else {
              updateTable(data);
              updateChart(data);
            }
            hidePreloader();
          },
          error: function () {
            $('#showprofitdata').html('<p>Error occurred. Please try again.</p>');
            hidePreloader();
          }
        });
      }

      function updateTable(data) {
        table.destroy();
        var html = '';
        data.forEach(function (item) {
          html += `<tr>
                    <td><a href="getdetailsbypage.php?pageid=${item.pageid}" target="_blank">${item.page_name}</a></td>
                    <td>${item.total_cashappopening}</td>
                    <td>${item.total_cashappclosing}</td>
                    <td>${item.total_cashout}</td>
                    <td>${item.total_redeemclosing}</td>
                    <td>${item.total_pending_redeem}</td>
                    <td>${item.total_deposit}</td>
                    <td>${item.total_profit}</td>
                  </tr>`;
        });
        $('#showprofitdata').html(html);
        table = $('#tbl_profitrecords').DataTable({
          fixedHeader: {
            header: true,
            headerOffset: $('#page-topbar').outerHeight()
          },
          dom: 'Bfrtip',
          buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
          "pageLength": 50,
        });
      }

      function updateChart(data) {
        var labels = data.map(function (item) { return item.page_name; });
        var cashappOpening = data.map(function (item) { return item.total_cashappopening; });
        var cashappClosing = data.map(function (item) { return item.total_cashappclosing; });
        var cashout = data.map(function (item) { return item.total_cashout; });
        var redeemClosing = data.map(function (item) { return item.total_redeemclosing; });
        var pendingRedeem = data.map(function (item) { return item.total_pending_redeem; });
        var totalDeposit = data.map(function (item) { return item.total_deposit; });
        var totalProfit = data.map(function (item) { return item.total_profit; });

        var barchartColors = getChartColorsArray("#market-overview");

        if (chart) {
          chart.destroy();
        }

        var options = {
          series: [
            {
              name: "Total Deposit",
              data: totalDeposit
            }, {
              name: "Total Profit",
              data: totalProfit
            },
            {
              name: "Total Paid Redeem",
              data: redeemClosing
            }
          ],
          chart: {
            type: "bar",
            height: 400,
            stacked: true,
            toolbar: {
              show: false
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
              fontSize: '20px'
            }
          },
          yaxis: {
            labels: {
              formatter: function (val) {
                return val.toFixed(2);
              }
            }
          },
          xaxis: {
            categories: labels,
            labels: {
              rotate: -90
            }
          }
        };

        chart = new ApexCharts(document.querySelector("#market-overview"), options);
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