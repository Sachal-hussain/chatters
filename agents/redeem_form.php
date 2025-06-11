
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Redeem Form | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
        <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php include('topheader.php');?>
		<?php

			require('../database/Pages.php');

			$object= new Pages();

			// $pages=$object->get_all_pages();
			$pages=$object->getPagesByIds($uid,$type);
		?>
        <?php
            require_once('../connect_me.php');
            $database_connection = new Database_connection();
            $connect = $database_connection->connect();

            $day_off='';
            $query = mysqli_query($connect, "SELECT * FROM emp_schedule
                WHERE uid='$uid';
                    ");
            if(mysqli_num_rows($query) > 0){
                while($row=mysqli_fetch_array($query)){
                    $id=$row['id'];
                    $offday=$row['offday'];
                    $day_off.='<h3 class="">Name: '.$fname.' - Shift: '.$shift.' - Off day will be on: '.$offday.'</h3>';
                  
                }
            }
        ?>
        <?php
            $custdropdown='';
            $query = mysqli_query($connect, "
                SELECT DISTINCT
                    addcustomer.id,addcustomer.name
                FROM 
                    addcustomer
               
                JOIN 
                    user ON FIND_IN_SET(addcustomer.pgid, user.pgid) AND user.id = $uid
                WHERE 
                    addcustomer.status = 'active'
                AND
                    addcustomer.approval=0
                
                ORDER BY 
                    addcustomer.name ASC;
            ");
            if(mysqli_num_rows($query) > 0){
                while($row=mysqli_fetch_array($query)){
                    $id=$row['id'];
                    $name=$row['name'];
                    $custdropdown.='<option value="'.$name.'">'.$name.'</option>';
                  
                }
            }
        ?>
		<!-- ========== Left Sidebar Start ========== -->
		<?php 
			include('../sidebar.php');
 			include('rightsidebar.php');
 			require("viewPendingRedeemImages.html");
 		?>

		<div class="main-content">
			<div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <marquee scrollamount="5" direction="left">
                                
                                <?php echo $day_off;?>
                                    
                            </marquee>
                        </div>
                    </div>
                    <div class="row justify-content-center" >
                        <div class="col-lg-4">
                            <div class="mb-4 mt-5">
                                
                                <h4>Search Pending redeem Using GID / Customer Name</h4>
                                
                            </div>
                            <div class="card chat-conversation" data-simplebar="init">
                                <div class="card-body p-4">
                                    <div class="p-3">
                                        <div class="search-box chat-search-box">            
                                            <div class="input-group mb-3 rounded-3">
                                                <span class="input-group-text text-muted bg-light pe-1 ps-3" id="basic-addon1">
                                                    <i class="bx bx-search-alt align-middle"></i>
                                                </span>
                                                <input type="text" id="pending_redeem_search" class="form-control bg-light" placeholder="Game ID / Customer Name" aria-label="Search ...." aria-describedby="basic-addon1">
                                                <div class="d-grid">
                                                    <button type="button" class="btn btn-primary" id="search_keyword">Search</button>
                                                </div>
                                            </div> 
                                        </div>   
                                    </div>
                                    <div class="px-2" data-simplebar>
                                        <table class="table table-bordered" >
                                            <thead>
                                                    <tr>
                                                      <th scope="col">Redeem ID</th>
                                                      <th scope="col">Date</th>
                                                      <th scope="col">Agent Name</th>
                                                      <th scope="col">Customer Name</th>
                                                      <th scope="col">Page Name</th>
                                                      <th scope="col">Game ID</th>
                                                      <th scope="col">Cash Tag</th>
                                                      <th scope="col">Comments</th>
                                                      <th scope="col">Amount</th>
                                                      <th scope="col">Tip</th>
                                                      <th scope="col">Refunded</th>
                                                      <th scope="col">Added Back</th>
                                                      <th scope="col">Remaining</th>
                                                      <th scope="col">Images</th>
                                                      <th scope="col">Status</th>

                                                  </tr>
                                            </thead>
                                            <tbody id="pendingredeem_list">

                                            </tbody>
                                        </table>
                                        
                                    </div>
                                
                                </div>
                                   
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-center mb-4 mt-4">
                               <!--  <a href="index.php" class="auth-logo mb-5 d-block">
                                    <img src="../assets/images/logo-login.png" alt="" height="75" class="logo logo-dark">
                                    <img src="../assets/images/logo-login.png" alt="" height="65" class="logo logo-light">
                                </a> -->
                                <i class=" bx bx-dollar"></i> <h4>Redeem Form</h4>
                                <!-- <p class="text-muted mb-4">Sign in to continue to Chatters 2.0.</p>                             -->
                            </div>

                            <div class="card chat-conversation" data-simplebar="init">
                                <div class="card-body p-4">
                                    <div class="p-3">
                                        <form  method="post" id="redeemform" >
        
                                            <div class="mb-3">
                                                <label class="form-label" for="pg_id">Page Name</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class=" bx bx-box"></i>
                                                    </span>
                                                   <select name="pg_id" id="pg_id" class="form-control red_page_dropdown" required>
                                                        <option value="0">-- Select One --</option>
                                                        <?php foreach ($pages as $key => $page) {?>
                                                           <option value="<?php echo $page['id'];?>-<?php echo $page['pagename'];?>-<?php echo $page['clientname'];?> "><?php echo $page['pagename'];?></option>
                                                        <?php } 
                                                       ?>
                                                   </select>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label" for="cust_name">Customer Name</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                   <!--  <span class="input-group-text text-muted" id="basic-addon3">
                                                        <i class=" bx bx-user"></i>
                                                    </span> -->
                                                    <select name="cust_name" id="cust_name" class="form-control form-select customer_dropdown" required>
                                                       <!--  <option value="0">-- Select One --</option>
                                                        <?php echo $custdropdown;?> -->
                                                    </select>
                                                   <!--  <input type="text" name="cust_name" id="cust_name" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Customer Name" aria-label="Enter Customer Name" aria-describedby="basic-addon3"> -->
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="cust_gname">Game Name</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                   
                                                    <select name="cust_gname" id="cust_gname" class="form-control form-select game_dropdown" required>
                                                      
                                                    </select>
                                                  
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="game_id">Game ID</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class=" bx bx-duplicate"></i>
                                                    </span>
                                                    <input type="text" name="game_id" id="game_id" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Game ID" aria-label="Enter Game ID" aria-describedby="basic-addon3">
                                                     
                                                   
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="red_amount">Redeem Amount</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class="bx bx-money"></i>
                                                    </span>
                                                    <input type="text" name="red_amount" id="red_amount" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Redeem Amount" aria-label="Enter Redeem Amount" aria-describedby="basic-addon3">
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <!-- <div class="float-end">
                                                    <a href="auth-recoverpw.html" class="text-muted font-size-13">Forgot password?</a>
                                                </div> -->
                                                <label class="form-label" for="cash_tag">Cash Tag</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon4">
                                                       <i class=" bx bx-dollar"></i>
                                                    </span>
                                                    <input type="text" name="cash_tag" id="cash_tag" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Cash Tag" aria-label="Enter Cash Tag" aria-describedby="basic-addon4">
                                                    
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="cust_email">Email</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class="bx bx-mail-send"></i>
                                                    </span>
                                                    <input type="email" name="cust_email" id="cust_email" class="form-control" placeholder="Enter Email" required >
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="cust_profile">Profile Link</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class=" bx bxl-facebook-circle"></i>
                                                    </span>
                                                    <input type="text" name="cust_profile" id="cust_profile" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Facebook Profile Link" aria-label="Enter Mobile Number" aria-describedby="basic-addon3" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="number">Number</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class="bx bxs-phone-call"></i>
                                                    </span>
                                                    <input type="text" name="number" id="number" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Mobile Number" aria-label="Enter Mobile Number" aria-describedby="basic-addon3" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="tip">Tip</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                      <i class="bx bx-money"></i>
                                                    </span>
                                                    <input type="text" name="tip" id="tip" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Tip" aria-label="Enter Tip" aria-describedby="basic-addon3" value="0">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="added_back">Added Back</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                      <i class="bx bx-reset"></i>
                                                    </span>
                                                    <input type="text" name="added_back" id="added_back" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Added Back" aria-label="Added Back" aria-describedby="basic-addon3" value="0">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="redeem_by">Redeem By</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                      <i class="bx bxs-user-check"></i>
                                                    </span>
                                                    <input type="text" name="redeem_by" id="redeem_by" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Name" aria-label="Enter Name" aria-describedby="basic-addon3">
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                               <label for="pasteimages" class="form-label">Upload Images </label>
                                                <textarea class="form-control img_past paste-textarea" placeholder="Paste your images here" style="resize: none;" id="pasteimages" disabled></textarea>
                                                <input type="hidden" name='hdn_images' id='hdn_images'>
                                               
                                            </div>
                                             <div class="mb-4 d-none " id="cust_paths">
                                               <label for="pasteimages" class="form-label">Upload license </label>
                                                <textarea class="form-control license license-textarea" placeholder="Paste your license here" style="resize: none;" id="cust_license" disabled></textarea>
                                                <input type="hidden" name='license_hdn_images' id='license_hdn_images'>
                                               
                                            </div>
                                            <?php if ($pg_id==2):?>
                                            <div class="mb-3">
                                                <label class="form-label" for="ref_page">Reference</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                   
                                                    <select name="ref_page" id="ref_page" class="form-control form-select">
                                                        <option value="Dannys">Dannys</option>
                                                        <option value="Fishing Room">Fishing Room</option>
                                                        <option value="Gameroom">Gameroom</option>
                                                    </select>
                                                  
                                                </div>
                                            </div>
                                            <?php endif?>
                                            <!-- <div class="form-check mb-4">
                                                <input type="checkbox" class="form-check-input" id="remember-check">
                                                <label class="form-check-label" for="remember-check">Remember me</label>
                                            </div> -->
                                            <input type="hidden" name="uid" value="<?php echo $uid;?>">
                                            <input type="hidden" name="type" value="<?php echo $type;?>">
                                            <input type="hidden" name="uname" value="<?php echo $uname;?>">
                                            <input type="hidden" name="customerid" id="customerid">
                                            <input type="hidden" name="customerlicense" id="customerlicense">

                                        </form>
                                        <div class="d-grid">
                                            <button type="button" class="btn btn-primary"  id="btn_redeem">Create</button>
                                        </div>

                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-4 mt-5">
                                
                                <h4>Check Customer Daily Limit</h4>
                                
                            </div>
                            <div class="card chat-conversation" data-simplebar="init">
                                <div class="card-body p-4">
                                    <div class="p-3">
                                        <form method="post" id="searchlimitform">
                                            <div class="mb-3">
                                                <label class="form-label" for="pgid">Page Name</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class="bx bx-box"></i>
                                                    </span>
                                                   <select name="pgid" id="pgid" class="form-control">
                                                       <?php foreach ($pages as $key => $page) {?>
                                                           <option value="<?php echo $page['id'];?>-<?php echo $page['pagename'];?> "><?php echo $page['pagename'];?></option>
                                                       <?php } 
                                                       ?>
                                                   </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="limitcust_name">Customer Name</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                        <i class="bx bx-user"></i>
                                                    </span>
                                                    <input type="text" name="limitcust_name" id="limitcust_name" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Customer Name" aria-label="Enter Customer Name" aria-describedby="basic-addon3">
                                                </div>
                                            </div>
                                            <input type="hidden" name="limitcheck" value="limit">        
                                            <div class="d-grid">
                                                <button type="button" class="btn btn-primary"  id="searchLimit">Search</button>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="px-2" data-simplebar id="showlimitdetails" style="display: none;">
                                        <table class="table table-bordered" >
                                            <thead>
                                                    <tr>
                                                      <th scope="col">Page Name</th>
                                                      <th scope="col">Customer Name</th>
                                                      <th scope="col">Game ID</th>
                                                      <th scope="col">Amount</th>
                                                      <th scope="col">Tip</th>
                                                      <th scope="col">Added Back</th>
                                                      <th scope="col">Refunded</th>
                                                      <th scope="col">Paid</th>
                                                      <th scope="col">Remaining</th>
                                                      <th scope="col">Time</th>
                                                      
                                                  </tr>
                                            </thead>
                                            <tbody id="showlimittbl">

                                            </tbody>
                                        </table>
                                        
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
   <!--  <script>
        $(document).ready(function () {
          $('#cust_name').select2({
            placeholder: 'Please Select Page',
            width: '100%'
          });
          
        });
    </script> -->
</body>
</html>