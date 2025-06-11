<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Tickets</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Tickets</li>
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Total</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value badge bg-success-subtle text-success" data-target="<?php echo $total_tickets?>">0</span>
                                    </h4>
                                </div>

                                <div class="col-6">
                                    <div id="mini-chart1" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                          <!--   <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success"></span>
                                <span class="ms-1 text-muted font-size-13">Online</span>
                            </div> -->
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Urgent</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value badge bg-danger-subtle text-danger" data-target="<?php echo $total_urgent?>">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart2" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                           <!--  <div class="text-nowrap">
                                <span class="badge bg-danger-subtle text-danger"></span>
                                <span class="ms-1 text-muted font-size-13">Online</span>
                            </div> -->
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">High</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value badge bg-success-subtle text-success" data-target="<?php echo $total_high;?>">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart3" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                          <!--   <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success"></span>
                                <span class="ms-1 text-muted font-size-13">Online</span>
                            </div> -->
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Medium</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value badge bg-danger-subtle text-danger" data-target="<?php echo $total_medium;?>">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart4" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <!-- <div class="text-nowrap">
                                <span class="badge bg-danger-subtle text-danger"></span>
                                <span class="ms-1 text-muted font-size-13">Online</span>
                            </div> -->
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Routine</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value badge bg-primary-subtle text-primary" data-target="<?php echo $total_routine;?>">0</span>
                                    </h4>
                                </div>

                                <div class="col-6">
                                    <div id="mini-chart5" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                          <!--   <div class="text-nowrap">
                                <span class="badge bg-primary-subtle text-primary"></span>
                                <span class="ms-1 text-muted font-size-13">Online</span>
                            </div> -->
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Closed</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value badge bg-info-subtle text-info" data-target="<?php echo $total_closed;?>">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart6" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <!-- <div class="text-nowrap">
                                <span class="badge bg-info-subtle text-info"></span>
                                <span class="ms-1 text-muted font-size-13">Online</span>
                            </div> -->
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
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Pending</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value badge bg-dark-subtle text-dark" data-target="<?php echo $total_pending;?>">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart7" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                           <!--  <div class="text-nowrap">
                                <span class="badge bg-dark-subtle text-dark"></span>
                                <span class="ms-1 text-muted font-size-13">Online</span>
                            </div> -->
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <div class="col-xl-3 col-md-6">
                 
                    <div class="card card-h-100">
                       
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Cancelled</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value badge bg-danger-subtle text-danger" data-target="<?php echo $total_cancelled;?>">0</span>
                                    </h4>
                                </div>
                                <div class="col-6">
                                    <div id="mini-chart8" data-colors='["#5156be"]' class="apex-charts mb-2"></div>
                                </div>
                            </div>
                            <div class="text-nowrap">
                               <!--  <span class="badge bg-danger-subtle text-danger"></span>
                                <span class="ms-1 text-muted font-size-13">Active</span> -->
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>

    </div>



    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © SHJ International All Rights Reserved.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Design & Develop by <a href="#!" class="text-decoration-underline">SHJ International</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- end main content-->