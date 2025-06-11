<?php include('site_url.php');
    require_once('../connect_me.php');
    $database_connection = new Database_connection();
    $connect = $database_connection->connect();

    $app_count='';
    $query = mysqli_query($connect, "SELECT COUNT(*) AS approval_count 
        FROM redeem 
        WHERE approval = 1;

            ");
    if(mysqli_num_rows($query) > 0){
        while($row=mysqli_fetch_array($query)){
            $count1=$row['approval_count'];
          
            $app_count.='<span class="badge bg-danger ms-1">'.$count1.'</span>';
          
        }
    }

    $totalcustcount='';
    $query = mysqli_query($connect, "SELECT COUNT(*) AS approval_count 
        FROM addcustomer 
        WHERE approval = 1;

            ");
    if(mysqli_num_rows($query) > 0){
        while($row=mysqli_fetch_array($query)){
            $custcount=$row['approval_count'];
          
            $totalcustcount.='
                            New Customer <span class="badge bg-danger ms-1">'.$custcount.'</span>
                            ';
          
        }
    }

    $dep_count='';
    $query = mysqli_query($connect, "SELECT COUNT(*) AS dep_count 
        FROM deposit 
        WHERE status = 0
        AND payment_method !='C2C';

            ");
    if(mysqli_num_rows($query) > 0){
        while($row=mysqli_fetch_array($query)){
            $dep_count1=$row['dep_count'];
          
            $dep_count.='<span class="badge bg-danger ms-1">'.$dep_count1.'</span>';
          
        }
    }
?>
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>
                <?php if($type=='Webmaster'):?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Admin</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo admin_dashboard;?>">Dashboard</a></li>
                        <li><a href="<?php echo pendingredeem_list;?>">Pending Redeem List</a></li>
                        <li><a href="<?php echo paidredeem_list;?>">Paid Redeem List</a></li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="">Reports</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?php echo profitreport;?>">Profit Report</a></li>
                                <li><a href="<?php echo depositreport;?>">Deposit Report</a></li>
                                <li><a href="<?php echo deposithistory;?>">Deposit History</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="">Pages</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?php echo addpages;?>">Add Page</a></li>
                                
                            </ul>
                        </li>
                    </ul>
                </li>
                <?php endif;?>
                <?php if($type=='CSR' || $type=='Webmaster'):?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="message-circle"></i>
                        <span data-key="t-chat">Chat Support</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="<?php echo c2ctags;?>">
                                <span data-key="t-calendar">C2C Tags</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo redeemfrom;?>">
                                <span data-key="t-calendar">Redeem Form</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo depositform;?>">
                                <span data-key="t-calendar">Deposit Form</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo add_customer;?>">
                                <span data-key="t-calendar">Add Customer</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo unprocessredeemform;?>">
                                <span data-key="t-chat">Unprocess Redeem Form</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo unprocessredeemlists;?>">
                                <span data-key="t-chat">Unprocess Redeem Details</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo paid_radeem_list_agent;?>">
                                <span data-key="t-chat">Paid Redeem List</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo pending_radeem_list_agent;?>">
                                <span data-key="t-chat">Pending Redeem List</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo allgamess;?>">
                                <span data-key="t-chat">All Games SS</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo agentdeposit_history;?>">
                                <span data-key="t-chat">Deposit History</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif;?>
                <?php if($department=='Redeem' || $type=='Webmaster' || $type=='Manager'):?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="dollar-sign"></i>
                        <span data-key="t-apps">Redeem</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="<?php echo redc2ctags;?>">
                                <span data-key="t-calendar">C2C Tags</span>
                            </a>
                        </li>
                         <li>
                            <a href="<?php echo c2cform;?>">
                                <span data-key="t-calendar">C2C Form</span>
                            </a>
                        </li>
                        <li>
                           <a href="<?php echo pages_list;?>" data-key="t-login">All Pages</a>
                        </li>

                        <li>
                           <a href="<?php echo update_deposit;?>" data-key="t-login">Update Deposit SS <?php echo $dep_count;?></a>
                        </li>

                        <li>
                           <a href="<?php echo pending_redeem_list;?>" data-key="t-register">Pending Redeem List</a>
                        </li>
                        <li>
                           <a href="<?php echo paid_redeem_list;?>" data-key="t-register">Paid Redeem List</a>
                        </li>
                        <li>
                           <a href="<?php echo failed_redeem_list;?>" data-key="t-register">Failed Redeem List</a>
                        </li>
                        <li>
                           <a href="<?php echo addcustomer;?>" data-key="t-register">Add Customers</a>
                        </li>
                       
                        <?php if($type=='Webmaster'):?>
                        <li>
                           <a href="<?php echo deleted_redeem;?>" data-key="t-register">Deleted Redeem List</a>
                        </li>
                        <?php endif;?>
                        <?php if(($type=='Manager' && $department=='Redeem') || $type=='Webmaster'):?>
                        <li>
                           <a href="<?php echo redeem_report;?>" data-key="t-register">Reports</a>
                        </li>
                        <li>
                           <a href="<?php echo EOD;?>" data-key="t-register">EOD</a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="t-email">Cash Tag</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?php echo add_cashtag;?>" data-key="t-inbox">Add Cash Tag</a></li>
                                <li><a href="<?php echo cashapp_details;?>" data-key="t-read-email">Cashapp List</a></li>
                            </ul>
                        </li>
                        <?php endif;?>
                        
                    </ul>
                </li>
                <?php endif;?>
                <?php if(($type=='Manager' && $department=='Live Chat') || $type=='Webmaster'):?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-pages">Manager</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo redeemapproval;?>" data-key="t-timeline">Request Approval <?php echo $app_count;?></a> </li>
                        <li><a href="<?php echo customerapproval;?>" data-key="t-timeline"> <?php echo $totalcustcount;?></a> </li>
                        <li><a href="<?php echo customerhistory;?>" data-key="t-timeline">Customer Profile </a> </li>
                        <li><a href="<?php echo redeemlimit;?>" data-key="t-starter-page">Redeem Limit</a></li>
                        <li><a href="<?php echo manager_reports;?>" data-key="t-starter-page">Paid / Pending Reports</a></li>
                        <li><a href="<?php echo agent_shuff_form;?>" data-key="t-maintenance">Agent Shuffling Form</a></li>
                        <li><a href="<?php echo agent_shuff_list;?>" data-key="t-coming-soon">Agent Shuffling Details</a></li>
                        <li><a href="<?php echo unprocessredeemlist;?>" data-key="t-timeline">Unprocess Redeem Details</a></li>
                        <li><a href="<?php echo hourly_update;?>" data-key="t-timeline">Hourly Update</a></li>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="">Shift Closed</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?php echo shift_record;?>">Closing Record</a></li>
                                <li><a href="<?php echo shift_reports;?>">Shift Reports</a></li>
                                <li><a href="<?php echo pages_report;?>">All Pages Report</a></li>
                            </ul>
                        </li>
                        <?php if($type=='Webmaster'):?>
                        <li>
                            <a href="javascript: void(0);" class="has-arrow">
                                <span data-key="">Add Game Deposits</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="<?php echo add_game_deposits;?>">Add Recharge</a></li>
                                 <li><a href="<?php echo gamestrorereport;?>">Game Recharge Reports</a></li>
                                
                            </ul>
                        </li>
                        <?php endif;?>
                    </ul>
                </li>
                <?php endif;?>


                <!-- <li class="menu-title mt-2" data-key="t-components">Elements</li> -->
                <?php if($type=='Manager' || $type=='Webmaster'):?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="user-check"></i>
                        <span data-key="t-components">Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo alluser_list;?>" data-key="t-alerts">All Users</a></li>
                        <?php if($type=='Webmaster'):?>
                            <li><a href="<?php echo add_users;?>" data-key="t-buttons">Add User</a></li>
                        <?php endif;?>
                        <!-- <li><a href="ui-cards.html" data-key="t-cards">Cards</a></li>
                        <li><a href="ui-carousel.html" data-key="t-carousel">Carousel</a></li>
                        <li><a href="ui-dropdowns.html" data-key="t-dropdowns">Dropdowns</a></li>
                        <li><a href="ui-grid.html" data-key="t-grid">Grid</a></li>
                        <li><a href="ui-images.html" data-key="t-images">Images</a></li>
                        <li><a href="ui-modals.html" data-key="t-modals">Modals</a></li>
                        <li><a href="ui-offcanvas.html" data-key="t-offcanvas">Offcanvas</a></li>
                        <li><a href="ui-progressbars.html" data-key="t-progress-bars">Progress Bars</a></li>
                        <li><a href="ui-placeholders.html" data-key="t-progress-bars">Placeholders</a></li>
                        <li><a href="ui-tabs-accordions.html" data-key="t-tabs-accordions">Tabs & Accordions</a></li>
                        <li><a href="ui-typography.html" data-key="t-typography">Typography</a></li>
                        <li><a href="ui-toasts.html" data-key="t-typography">Toasts</a></li>
                        <li><a href="ui-video.html" data-key="t-video">Video</a></li>
                        <li><a href="ui-general.html" data-key="t-general">General</a></li>
                        <li><a href="ui-colors.html" data-key="t-colors">Colors</a></li>
                        <li><a href="ui-utilities.html" data-key="t-colors">Utilities</a></li> -->
                    </ul>
                </li>
                <?php endif;?>
                <?php if($type=='Q&A' || $type=='Webmaster' || $type=='Verification'):?>
                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="grid"></i>
                        <span data-key="t-apps">Q&A</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <?php if($type !='Verification'):?>
                        <li><a href="<?php echo unprocessredeem;?>" data-key="t-alerts">Unprocess Redeem</a></li>
                        <?php endif;?>
                        <li><a href="<?php echo pendingredeem;?>" data-key="t-buttons">Pending Redeem List</a></li>
                        <li><a href="<?php echo paidredeem;?>" data-key="t-cards">Paid Redeem List</a></li>
                         <li>
                            <a href="<?php echo qac2ctags;?>">
                                <span data-key="t-calendar">C2C Tags</span>
                            </a>
                        </li>
                        <!-- 
                        <li><a href="ui-carousel.html" data-key="t-carousel">Carousel</a></li>
                        <li><a href="ui-dropdowns.html" data-key="t-dropdowns">Dropdowns</a></li>
                        <li><a href="ui-grid.html" data-key="t-grid">Grid</a></li>
                        <li><a href="ui-images.html" data-key="t-images">Images</a></li>
                        <li><a href="ui-modals.html" data-key="t-modals">Modals</a></li>
                        <li><a href="ui-offcanvas.html" data-key="t-offcanvas">Offcanvas</a></li>
                        <li><a href="ui-progressbars.html" data-key="t-progress-bars">Progress Bars</a></li>
                        <li><a href="ui-placeholders.html" data-key="t-progress-bars">Placeholders</a></li>
                        <li><a href="ui-tabs-accordions.html" data-key="t-tabs-accordions">Tabs & Accordions</a></li>
                        <li><a href="ui-typography.html" data-key="t-typography">Typography</a></li>
                        <li><a href="ui-toasts.html" data-key="t-typography">Toasts</a></li>
                        <li><a href="ui-video.html" data-key="t-video">Video</a></li>
                        <li><a href="ui-general.html" data-key="t-general">General</a></li>
                        <li><a href="ui-colors.html" data-key="t-colors">Colors</a></li>
                        <li><a href="ui-utilities.html" data-key="t-colors">Utilities</a></li> -->
                    </ul>
                </li>
                <?php endif;?>
                <li>            
                    <a href="<?php echo tickets;?>">
                        <i class="mdi mdi-ticket"></i>
                        <span data-key="t-horizontal">Ticket</span>
                    </a>
                </li>
                <?php
                // Assuming $doh is in 'Y-m-d' format, e.g., '2022-10-04'
                $current_date = new DateTime();
                $user_doh = new DateTime($doh); // Convert $doh to DateTime object

                // Calculate the difference in days
                $days_difference = $current_date->diff($user_doh)->days;

                // Check if the difference is greater than 90 days
                if ($days_difference > 90):
                ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="share-2"></i>
                            <span data-key="t-multi-level">Leave</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="<?php echo applyleave;?>">Apply Leave</a></li>
                            <li><a href="<?php echo leavehistory;?>">Leave History</a></li>

                        </ul>
                    </li>
                <?php
                endif;
                ?>

            </ul>

           <!--  <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5">
                <div class="card-body">
                    <img src="assets/images/giftbox.png" alt="">
                    <div class="mt-4">
                        <h5 class="alertcard-title font-size-16">Unlimited Access</h5>
                        <p class="font-size-13">Upgrade your plan from a Free trial, to select ‘Business Plan’.</p>
                        <a href="#!" class="btn btn-primary mt-2">Upgrade Now</a>
                    </div>
                </div>
            </div> -->
        </div>
        <!-- Sidebar -->
    </div>
</div>