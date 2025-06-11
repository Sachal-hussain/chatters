
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Redeem Report | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
		<?php include('topheader.php');

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
        <?php
        	$clients='';
	        $query = mysqli_query($connect, "
	          SELECT fullname FROM user WHERE type='Client'
	          ORDER BY 
	              fullname ASC;
	          "
	        );
	    
	     
	      	if(mysqli_num_rows($query) > 0){
	          while($row=mysqli_fetch_array($query)){
	              // $id=$row['id'];
	              // $pagename=$row['uname'];
	              $clients.='<option value="'.$row['fullname'].'">'.$row['fullname'].'</option>';
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
                                <h4 class="mb-sm-0 font-size-18">Paid Redeem Report</h4>

                                <!-- <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                                        <li class="breadcrumb-item active">User Details</li>
                                    </ol>
                                </div> -->

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center " >
                        <div class="col-md-8 col-lg-6 col-xl-12 ">
                            
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="userlist" role="tabpanel" aria-labelledby="pills-home-tab">
	                                <form method="post" action="#" id="searchform">
			                          <div class="row">
			                            <div class="col-md-6">
			                              <div class="mb-4 position-relative" >
			                                <label for="page_name" class="form-label">Page Name</label>
			                                <select class="form-control form-select" name="page_name" id="page_name">
			                                	<option value="0">--Select Page--</option>
			                                  <?php echo $html;?>

			                                </select>
			                               
			                              </div>
			                            </div>
			                            <div class="col-md-6">
			                              <div class="mb-4 position-relative" >
			                                <label for="redeemfor" class="form-label">Redeem For</label>

			                                <!-- <input type="text" name="redeemfor" id="redeemfor" class="form-control"> -->
			                                <select class="form-control" name="redeemfor" id="redeemfor">
			                                	<option value="">--Select Redeem For --</option>
			                                  <?php echo $clients;?>

			                                </select>
			                              </div>
			                            </div>    
			                            <div class="col-md-6">
			                              <div class="mb-4" >
			                                <label for="redeemfrom" class="form-label">Redeem From</label>
			                                <!-- <input type="text" class="form-control" name="redeemfrom" id="redeemfrom"> -->
			                                <select class="form-control" name="redeemfrom" id="redeemfrom">
			                                	<option value="">--Select Redeem From --</option>
			                                  <?php echo $clients;?>

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
			                              <button type="button" class="btn btn-primary" name="searchresult" id="searchresult">Search</button>
			                               <button type="reset" class="btn btn-primary m-2" id="clearfilter">Clear Search Filter</button>
			                            </div>
			                            
			                            
			                          </div>
			                        </form>
			                        <div class="row mt-4">
			                          	<div class="col-12">
			                            	<div class="card">
			                              		<div class="card-body">
			                              			<table class="table table-bordered table-responsive table-sm" id="tbl_paidredeem">
								                      	<thead>
									                        <tr>
									                          <th scope="col">ID</th>	
									                          <th scope="col">Created At</th>  
									                          <th scope="col">Updated At</th>   
									                          <th scope="col">Agent Name</th>   
									                          <th scope="col">Customer Name</th> 
									                          <th scope="col">Redeem Paid By</th> 
									                          <th scope="col">Page Name</th>      
									                          <th scope="col">Redeem For</th>     
									                          <th scope="col">Redeem From</th>    
									                          <th scope="col">Game ID</th>        
									                          <th scope="col">Cash Tag</th>   
									                          <th scope="col">Amount</th>     
									                          <th scope="col">Refunded</th> 
									                          <th scope="col">Paid</th>     
									                          <th scope="col">Tip</th>      
									                          <th scope="col">Add Back</th>  
									                          <th scope="col">Status</th> 
									                        </tr>
								                      	</thead>
								                      	<tbody id="searchRedeemData">
								                        
								                      	</tbody>
								                    </table>
			                              		</div>
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
		$(document).ready(function () {
	      	$('#searchresult').click(function () {
	         
		        var anyFilterEntered = false;
		        // $('#searchform :input').each(function() {
		        //     if ($(this).val() !== "" && $(this).val() !== "0") {
		        //         anyFilterEntered = true;
		        //         return false; // Exit loop if a filter value is found
		        //     }
		        // });

	     
		        // if (!anyFilterEntered) {
		        //     alert("Please enter at least one search criteria.");
		        //     return; // Exit the function to prevent further execution
		        // }
		        var selectedPage = $('#page_name').val();
		        var redeemfor = $('#redeemfor').val();
		        var redeemfrom = $('#redeemfrom').val();
		        var searchDateFrom = $('#search_datefrom').val();
		        var searchDateTo = $('#search_dateto').val();

		        if (!selectedPage || selectedPage === '0') {
		            alert('Please select a page.');
		            return;
		        }
		        if (!redeemfor || redeemfor === '') {
		            alert('Please select a redeem for.');
		            return;
		        }
		        if (!redeemfrom || redeemfrom === '') {
		            alert('Please select a redeem from.');
		            return;
		        }

		        // if (!searchDateFrom || !searchDateTo) {
		        //     alert('Please select a date range.');
		        //     return;
		        // }
	        	showPreloader();

	     
	        	var formData = $('#searchform').serialize();

	    
		        $.ajax({
		          type: 'POST',
		          url: 'searchPaidRedeem.php',
		          data: formData,
		          success: function (response) {
		            // $('#showsearch_data').html(response);
		            // hidePreloader();
		            if (response.trim() === '') {
		              $('#searchRedeemData').html('<p>No data found.</p>');
		              $('#tbl_paidredeem').DataTable().destroy();
		            } else {
		              $('#searchRedeemData').html(response);
		              $('#tbl_paidredeem').DataTable();
		            }  
		          },
		          error: function () {
		            $('#search-results').html('<p>Error occurred. Please try again.</p>');
		            hidePreloader();
		          }
		        });
	      	});

	      	$(document).on('click', '#clearfilter', function () {
	          $('#searchform')[0].reset(); 
	          $('#searchRedeemData').empty(); 
	      	});
	    });

   
	    function showPreloader() {
	      Pace.restart(); 
	    }

	    function hidePreloader() {
	      Pace.stop(); // Hide preloader
	    }
	</script>
	
	<script type="text/javascript">
	    $("#search_datefrom").datetimepicker({
	      dateFormat: 'yy-mm-dd',
	      timeFormat: 'HH:mm:ss'
	    });
	    $("#search_dateto").datetimepicker({
	      dateFormat: 'yy-mm-dd',
	      timeFormat: 'HH:mm:ss'
	    });

	</script>
</body>
</html>

