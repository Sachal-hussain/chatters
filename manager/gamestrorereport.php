
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Store Game Report | SHJ INTERNATIONAL</title>
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
                                <h4 class="mb-sm-0 font-size-18">Store Recharge Details</h4>

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
                            <!-- <div class="text-center mb-4 mt-4">
                             
                                <i class="bx bxs-user-circle"></i> <h4>All User </h4>
                              
                            </div> -->
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                               

                                <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#userlist" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Paid Redeem Report</button>
                                </li> -->


                                <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link " id="pills-issueslist-tab" data-bs-toggle="pill" data-bs-target="#issueslist" type="button" role="tab" aria-controls="issueslist" aria-selected="false">Issues List</button>
                                </li>   -->   
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="userlist" role="tabpanel" aria-labelledby="pills-home-tab">
	                                <form method="post" action="#" id="searchform">
			                          <div class="row">
			                            <div class="col-md-6">
			                              <div class="mb-4 position-relative" >
			                                <label for="storepage_name" class="form-label">Pages Name</label>
			                                <select class="form-control form-select" name="storepage_name" id="storepage_name">
			                                	<option value="0">--Select Page--</option>
			                                  	<?php echo $html;?>

			                                </select>
			                               
			                              </div>
			                            </div>
			                            <div class="col-md-6">
			                              <div class="mb-4 position-relative" >
			                                <label for="redeemfor" class="form-label">Store Games</label>
			                                <select class="form-control form-select" name="storegameid" id="storegameid">
			                                </select>
			                              </div>
			                            </div>  
			                            <div class="col-md-6">
			                              <div class="mb-4" >
			                                <label for="search_datefrom" class="form-label">Date From</label>
			                                <input type="date" class="form-control" name="search_datefrom" id="search_datefrom">
			                              </div>
			                            </div>
			                            <div class="col-md-6">
			                              <div class="mb-4" >
			                                <label for="search_dateto" class="form-label">Date To</label>
			                                <input type="date" class="form-control" name="search_dateto" id="search_dateto">
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
			                              			<table class="table table-bordered table-responsive table-sm" id="tbl_accountdetails">
								                      	<thead>
									                        <tr>
									                          <th scope="col">#</th>	
									                          <th scope="col">Date</th> 
									                          <th scope="col">Game Name</th> 
									                          <th scope="col">Account</th>   
									                          <th scope="col">Recharged</th>
									                          <th scope="col">Redeem</th>   
									                          <th scope="col">Page Name</th> 
									                          <th scope="col">Client Name</th>  
									                        </tr>
								                      	</thead>
								                      	<tbody id="searchAccountData">
								                        
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
			var table = $('#tbl_accountdetails').DataTable({
		        dom: 'Bfrtip',
		        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
		        "pageLength": 50,
		         "footer": true
		    });
	      	$('#searchresult').click(function () {
	         
		        var selectedPage = $('#storepage_name').val();

		        if (!selectedPage || selectedPage === '0') {
		          alert('Please select a page.');
		           return;
		        }

	        	showPreloader();

	     
	        	var formData = $('#searchform').serialize();

	    
		        $.ajax({
		          type: 'POST',
		          url: 'fetch_games_list.php',
		          data: formData,
		          success: function (response) {
		            // $('#showsearch_data').html(response);
		            // hidePreloader();
		            if (response.trim() === '') {
		              $('#searchAccountData').html('<p>No data found.</p>');
		             
		            } else {
		            	table.destroy();
			            $('#searchAccountData').html(response);
			            table=$('#tbl_accountdetails').DataTable({
			            	dom: 'Bfrtip',
	                      	buttons: [
	                       		'copy', 'csv', 'excel', 'pdf', 'print'
	                        ]
			            });
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
	          $('#searchAccountData').empty(); 
	      	});
	    });

   
	    function showPreloader() {
	      Pace.restart(); 
	    }

	    function hidePreloader() {
	      Pace.stop(); // Hide preloader
	    }
	</script>
</body>
</html>

