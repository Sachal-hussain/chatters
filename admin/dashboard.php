
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	
	<title>Dashboard | SHJ International</title>
	<?php require("links.html"); ?>
</head>
<body>
	<div class="layout-wrapper">
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
            require('database/User.php');
			require('database/Groups.php');


			$object = new User();
			$total_user  =  $object->getTotalUsers();
			$online_user =  $object->getOnlineUsers();
			$clients     =  $object->getTotalClients();
			$online_clients=$object->getOnlineClients();
			$manager     =$object->getTotalManager();
			$online_manager=$object->getOnlineManager();
			$supervisor  =$object->getTotalSupervisor();
			$online_supervisor=$object->getOnlineSupervisor();
			$morning_shift=$object->getMorningShift();
			$online_morning_shift=$object->getOnlineMorningShift();
			$evening_shift=$object->getEveningShift();
			$online_evening_shift=$object->getOnlineEveningShift();
			$night_shift=$object->getNightShift();
			$online_night_shift=$object->getOnlineNightShift();

			$all_user=$object->allUserdetails();
			$all_client=$object->allClientdetails();

			$total = $total_user + $clients + $manager;
			$user_percentage = ($total_user / $total) * 100;
			$client_percentage = ($clients / $total) * 100;
			$manager_percentage = ($manager / $total) * 100;

			$group=new Groups();
			$total_groups=$group->getTotalGroups();

		?>
	</div>
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
	                        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

	                        <div class="page-title-right">
	                            <ol class="breadcrumb m-0">
	                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
	                                <li class="breadcrumb-item active">Dashboard</li>
	                            </ol>
	                        </div>

	                    </div>
	                </div>
	            </div>
	            <!-- end page title -->

	            <!-- 1st row -->
	            <div class="row">
	                <div class="col-xl-3 col-md-6">
	                    <!-- card -->
	                    <div class="card card-h-100">
	                        <!-- card body -->
	                        <div class="card-body">
	                            <div class="row align-items-center">
	                                <div class="col-6">
	                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Users</span>
	                                    <h4 class="mb-3">
	                                        <span class="counter-value" data-target="<?php echo $total_user;?>">0</span>
	                                    </h4>
	                                </div>

	                                <div class="col-6">
	                                    <div id="mini-chart1" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
	                                </div>
	                            </div>
	                            <div class="text-nowrap">
	                                <span class="badge bg-success-subtle text-success"><?php echo $online_user;?></span>
	                                <span class="ms-1 text-muted font-size-13">Online</span>
	                            </div>
	                        </div><!-- end card body -->
	                    </div><!-- end card -->
	                </div><!-- end col -->

	                <div class="col-xl-3 col-md-6">
	                    <!-- card -->
	                    <div class="card card-h-100">
	                        <!-- card body -->
	                        <div class="card-body">
	                            <div class="row align-items-center">
	                                <div class="col-6">
	                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Clients</span>
	                                    <h4 class="mb-3">
	                                        <span class="counter-value" data-target="<?php echo $clients;?>">0</span>
	                                    </h4>
	                                </div>
	                                <div class="col-6">
	                                    <div id="mini-chart2" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
	                                </div>
	                            </div>
	                            <div class="text-nowrap">
	                                <span class="badge bg-danger-subtle text-danger"><?php echo $online_clients;?></span>
	                                <span class="ms-1 text-muted font-size-13">Online</span>
	                            </div>
	                        </div><!-- end card body -->
	                    </div><!-- end card -->
	                </div><!-- end col-->

	                <div class="col-xl-3 col-md-6">
	                    <!-- card -->
	                    <div class="card card-h-100">
	                        <!-- card body -->
	                        <div class="card-body">
	                            <div class="row align-items-center">
	                                <div class="col-6">
	                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Managers</span>
	                                    <h4 class="mb-3">
	                                        <span class="counter-value" data-target="<?php echo $manager;?>">0</span>
	                                    </h4>
	                                </div>
	                                <div class="col-6">
	                                    <div id="mini-chart3" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
	                                </div>
	                            </div>
	                            <div class="text-nowrap">
	                                <span class="badge bg-success-subtle text-success"><?php echo $online_manager;?></span>
	                                <span class="ms-1 text-muted font-size-13">Online</span>
	                            </div>
	                        </div><!-- end card body -->
	                    </div><!-- end card -->
	                </div><!-- end col -->

	                <div class="col-xl-3 col-md-6">
	                    <!-- card -->
	                    <div class="card card-h-100">
	                        <!-- card body -->
	                        <div class="card-body">
	                            <div class="row align-items-center">
	                                <div class="col-6">
	                                    <span class="text-muted mb-3 lh-1 d-block text-truncate"> Supervisors</span>
	                                    <h4 class="mb-3">
	                                        <span class="counter-value" data-target="<?php echo $supervisor;?>">0</span>
	                                    </h4>
	                                </div>
	                                <div class="col-6">
	                                    <div id="mini-chart4" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
	                                </div>
	                            </div>
	                            <div class="text-nowrap">
	                                <span class="badge bg-danger-subtle text-danger"><?php echo $online_supervisor;?></span>
	                                <span class="ms-1 text-muted font-size-13">Online</span>
	                            </div>
	                        </div><!-- end card body -->
	                    </div><!-- end card -->
	                </div><!-- end col -->    
	            </div><!-- end row-->

	            <div class="row">
	                <div class="col-xl-3 col-md-6">
	                    <!-- card -->
	                    <div class="card card-h-100">
	                        <!-- card body -->
	                        <div class="card-body">
	                            <div class="row align-items-center">
	                                <div class="col-6">
	                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Morning Shift</span>
	                                    <h4 class="mb-3">
	                                        <span class="counter-value" data-target="<?php echo $morning_shift;?>">0</span>
	                                    </h4>
	                                </div>

	                                <div class="col-6">
	                                    <div id="mini-chart5" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
	                                </div>
	                            </div>
	                            <div class="text-nowrap">
	                                <span class="badge bg-primary-subtle text-primary"><?php echo $online_morning_shift;?></span>
	                                <span class="ms-1 text-muted font-size-13">Online</span>
	                            </div>
	                        </div><!-- end card body -->
	                    </div><!-- end card -->
	                </div><!-- end col -->

	                <div class="col-xl-3 col-md-6">
	                    <!-- card -->
	                    <div class="card card-h-100">
	                        <!-- card body -->
	                        <div class="card-body">
	                            <div class="row align-items-center">
	                                <div class="col-6">
	                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Evening Shift</span>
	                                    <h4 class="mb-3">
	                                        <span class="counter-value" data-target="<?php echo $evening_shift;?>">0</span>
	                                    </h4>
	                                </div>
	                                <div class="col-6">
	                                    <div id="mini-chart6" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
	                                </div>
	                            </div>
	                            <div class="text-nowrap">
	                                <span class="badge bg-info-subtle text-info"><?php echo $online_evening_shift;?></span>
	                                <span class="ms-1 text-muted font-size-13">Online</span>
	                            </div>
	                        </div><!-- end card body -->
	                    </div><!-- end card -->
	                </div><!-- end col-->

	                <div class="col-xl-3 col-md-6">
	                    <!-- card -->
	                    <div class="card card-h-100">
	                        <!-- card body -->
	                        <div class="card-body">
	                            <div class="row align-items-center">
	                                <div class="col-6">
	                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Night Shift</span>
	                                    <h4 class="mb-3">
	                                        <span class="counter-value" data-target="<?php echo $night_shift;?>">0</span>
	                                    </h4>
	                                </div>
	                                <div class="col-6">
	                                    <div id="mini-chart7" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
	                                </div>
	                            </div>
	                            <div class="text-nowrap">
	                                <span class="badge bg-dark-subtle text-dark"><?php echo $online_night_shift;?></span>
	                                <span class="ms-1 text-muted font-size-13">Online</span>
	                            </div>
	                        </div><!-- end card body -->
	                    </div><!-- end card -->
	                </div><!-- end col -->

	                <div class="col-xl-3 col-md-6">
	                    <!-- card -->
	                    <div class="card card-h-100">
	                        <!-- card body -->
	                        <div class="card-body">
	                            <div class="row align-items-center">
	                                <div class="col-6">
	                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Number of Groups</span>
	                                    <h4 class="mb-3">
	                                        <span class="counter-value" data-target="<?php echo $total_groups; ?>">0</span>
	                                    </h4>
	                                </div>
	                                <div class="col-6">
	                                    <div id="mini-chart8" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
	                                </div>
	                            </div>
	                            <div class="text-nowrap">
	                                <span class="badge bg-danger-subtle text-danger"><?php echo $total_groups; ?></span>
	                                <span class="ms-1 text-muted font-size-13">Active</span>
	                            </div>
	                        </div><!-- end card body -->
	                    </div><!-- end card -->
	                </div><!-- end col -->    
	            </div><!-- end row-->

	            <div class="row">
	                <div class="col-xl-6">
	                  
	                    <div class="card card-h-100">
	                        
	                        <div class="card-body">
	                            <div class="d-flex flex-wrap align-items-center mb-4">
	                                <h5 class="card-title me-2">All Shifts Overview</h5>
	                             
	                            </div>

	                            <div class="row align-items-center">
	                                <div class="col-sm">
	                                    <div id="wallet-balance" data-colors='["#777aca", "#5156be", "#a8aada"]' class="apex-charts"></div>
	                                </div>
	                                <div class="col-sm align-self-center">
	                                    <div class="mt-4 mt-sm-0">
	                                        <div>
	                                            <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-success"></i> Morning Shift</p>
	                                            <h6>Total: <?php echo $morning_shift;?> :: <span class="text-muted font-size-14 fw-normal">Online: <?php echo $online_morning_shift;?></span></h6>
	                                        </div>

	                                        <div class="mt-4 pt-2">
	                                            <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-primary"></i> Evening Shift</p>
	                                            <h6>Total: <?php echo $evening_shift;?> :: <span class="text-muted font-size-14 fw-normal">Online: <?php echo $online_evening_shift;?></span></h6>
	                                        </div>

	                                        <div class="mt-4 pt-2">
	                                            <p class="mb-2"><i class="mdi mdi-circle align-middle font-size-10 me-2 text-info"></i> Night Shift</p>
	                                            <h6>Total: <?php echo $night_shift;?> :: <span class="text-muted font-size-14 fw-normal">Online: <?php echo $online_night_shift;?></span></h6>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                   
	                </div>
	               
	                <div class="col-xl-6">
	                    <div class="row">
	                        <div class="col-xl-12">
	                          
	                            <div class="card card-h-100">
	                              
	                                <div class="card-body">
	                                    <div class="d-flex flex-wrap align-items-center mb-4">
	                                        <h5 class="card-title me-2">Users Overview</h5>
	                                       
	                                    </div>

	                                    <div class="row align-items-center">
	                                        <div class="col-sm">
	                                            <div id="invested-overview" data-colors='["#5156be", "#34c38f"]' class="apex-charts"></div>
	                                        </div>
	                                        <div class="col-sm align-self-center">
	                                            <div class="mt-4 mt-sm-0">
	                                                <p class="mb-1 text-uppercase">Users</p>
	                                                <h4><?php echo $total_user;?></h4>

	                                                <p class="text-muted mb-4"> <?php echo round($user_percentage);?> % <i class="mdi mdi-arrow-up ms-1 text-success"></i></p>

	                                                <div class="row g-0">
	                                                    <div class="col-6">
	                                                        <div>
	                                                            <p class="mb-2 text-muted text-uppercase font-size-11">Clients</p>
	                                                            <h5 class="fw-medium"><?php echo $clients;?></h5>
	                                                            <p class="text-muted mb-4"> <?php echo round($client_percentage);?> % <i class="mdi mdi-arrow-up ms-1 text-success"></i></p>
	                                                        </div>
	                                                    </div>
	                                                    <div class="col-6">
	                                                        <div>
	                                                            <p class="mb-2 text-muted text-uppercase font-size-11">Managers</p>
	                                                             <h5 class="fw-medium"><?php echo $manager;?></h5>
	                                                            <p class="text-muted mb-4"> <?php echo round($manager_percentage);?> % <i class="mdi mdi-arrow-up ms-1 text-success"></i></p>
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
	                    
	                </div>
	               
	            </div>
	           

	     
	            <div class="row">
	          
	                <div class="col-xl-4">
	                    <div class="card">
	                        <div class="card-header align-items-center d-flex">
	                            <h4 class="card-title mb-0 flex-grow-1">Online Details</h4>
	                            <div class="flex-shrink-0">
	                                <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
	                                    <li class="nav-item">
	                                        <a class="nav-link active" data-bs-toggle="tab" href="#all-tab" role="tab">
	                                            All
	                                        </a>
	                                    </li>
	                                   <!--  <li class="nav-item">
	                                        <a class="nav-link" data-bs-toggle="tab" href="#transactions-buy-tab" role="tab">
	                                            Users 
	                                        </a>
	                                    </li> -->
	                                    <li class="nav-item">
	                                        <a class="nav-link" data-bs-toggle="tab" href="#client-tab" role="tab">
	                                            Clients 
	                                        </a>
	                                    </li>
	                                </ul>
	                               
	                            </div>
	                        </div>

	                        <div class="card-body px-0">
	                            <div class="tab-content">
	                                <div class="tab-pane active" id="all-tab" role="tabpanel">
	                                    <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
	                                        <table class="table align-middle table-nowrap table-borderless">
	                                            <thead>
	                                                <tr class="text-center">
	                                                  <th scope="col">Avatar</th>
	                                                  <th scope="col">Name</th>
	                                                  <th scope="col">Type</th>
	                                                  <th scope="col">Shift</th>
	                                                </tr>
	                                            </thead>
	                                            <tbody>

	                                                <?php
	                                                foreach ($all_user as $key => $value) {?>
	                                                   
	                                                 
	                                                <tr>
	                                                    <td style="width: 50px;">
	                                                        <div class="font-size-22 text-success">
	                                                            <!-- <i class="bx bx-down-arrow-circle d-block"></i> -->
	                                                            <img class="rounded-circle header-profile-user" src="../assets/images/users/noimage.png">
	                                                        </div>
	                                                    </td>

	                                                    <td>
	                                                        <div class="text-center">
	                                                            <h5 class="font-size-14 mb-1"><?php echo $value[3];?></h5>
	                                                            <!-- <p class="text-muted mb-0 font-size-12">14 Mar, 2021</p> -->
	                                                        </div>
	                                                    </td>

	                                                    <td>
	                                                        <div class="text-center">
	                                                            <h5 class="font-size-14 mb-0"><?php echo $value[7]?></h5>
	                                                            <!-- <p class="text-muted mb-0 font-size-12">Coin Value</p> -->
	                                                        </div>
	                                                    </td>

	                                                    <td>
	                                                        <div class="text-center">
	                                                            <h5 class="font-size-14 text-muted mb-0"><?php echo $value[6]?></h5>
	                                                            <!-- <p class="text-muted mb-0 font-size-12">Amount</p> -->
	                                                        </div>
	                                                    </td>
	                                                </tr>
	                                                <?php } 
	                                                ?>
	                                            </tbody>
	                                        </table>
	                                    </div>
	                                </div>
	                              
	                              
	                                <div class="tab-pane" id="client-tab" role="tabpanel">
	                                    <div class="table-responsive px-3" data-simplebar style="max-height: 352px;">
	                                        <table class="table align-middle table-nowrap table-borderless">
	                                            <thead>
	                                                <tr class="text-center">
	                                                  <th scope="col">Avatar</th>
	                                                  <th scope="col">Name</th>
	                                                  <th scope="col">Status</th>
	                                                  <!-- <th scope="col">Shift</th> -->
	                                                </tr>
	                                            </thead>
	                                            <tbody>
	                                                <?php
	                                                foreach ($all_client as $key => $value) {?>
	                                                    
	                                                 
	                                                <tr>
	                                                    <td style="width: 50px;">
	                                                        <div class="font-size-22 text-danger">
	                                                            <!-- <i class="bx bx-up-arrow-circle d-block"></i> -->
	                                                            <img class="rounded-circle header-profile-user" src="../assets/images/users/<?php echo isset($value[12]) ? $value[12]:"noimage.png"?>">
	                                                        </div>
	                                                    </td>

	                                                    <td>
	                                                        <div class="text-center">
	                                                            <h5 class="font-size-14 mb-1"><?php echo $value[3];?></h5>
	                                                            
	                                                        </div>
	                                                    </td>

	                                                    <td>
	                                                        <div class="text-center">
	                                                            <h5 class="font-size-14 mb-0"><?php echo $value[11];?></h5>
	                                                            <!-- <p class="text-muted mb-0 font-size-12">Coin Value</p> -->
	                                                        </div>
	                                                    </td>

	                                                </tr>
	                                                <?php } 
	                                                ?>
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



	   <?php require("footer.html"); ?>
	</div>
	<!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
	
	<?php require("footer_links.html"); ?>

	<script>

		var piechartColors = getChartColorsArray("#wallet-balance"),
			options = {
				series: [<?php echo $morning_shift;?>, <?php echo $evening_shift;?>, <?php echo $night_shift;?>],
				chart: {
					width: 227,
					height: 227,
					type: "pie"
				},
				labels: ["Morning", "Evening", "Night"],
				colors: piechartColors,
				stroke: {
					width: 0
				},
				legend: {
					show: !1
				},
				responsive: [{
					breakpoint: 480,
					options: {
						chart: {
							width: 200
						}
					}
				}]
			};
		(chart = new ApexCharts(document.querySelector("#wallet-balance"), options)).render();

		var radialchartColors = getChartColorsArray("#invested-overview"),
			options = {
				chart: {
					height: 270,
					type: "radialBar",
					offsetY: -10
				},
				plotOptions: {
					radialBar: {
						startAngle: -130,
						endAngle: 130,
						dataLabels: {
							name: {
								show: !1
							},
							value: {
								offsetY: 10,
								fontSize: "18px",
								color: void 0,
								formatter: function(r) {
									return Math.round(r) + "%"
								}
							}
						}
					}
				},
				colors: [radialchartColors[0]],
				fill: {
					type: "gradient",
					gradient: {
						shade: "dark",
						type: "horizontal",
						gradientToColors: [radialchartColors[1]],
						shadeIntensity: .15,
						inverseColors: !1,
						opacityFrom: 1,
						opacityTo: 1,
						stops: [20, 60]
					}
				},
				stroke: {
					dashArray: 4
				},
				legend: {
					show: !1
				},
				series: [<?php echo $user_percentage; ?>, <?php echo $client_percentage; ?>, <?php echo $manager_percentage; ?>],
				labels: ["Users","Clients","Managers"]
			};
		(chart = new ApexCharts(document.querySelector("#invested-overview"), options)).render();

	</script>
</body>
</html>