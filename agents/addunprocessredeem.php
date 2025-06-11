
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Unprocess Redeem Form | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
		<?php include('topheader.php');?>
        <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php 
			require_once('../connect_me.php');
            $database_connection = new Database_connection();
            $connect = $database_connection->connect();

            $html='';
            $query = mysqli_query($connect, " SELECT 
                    pages.*, 
                    COUNT(redeem.id) AS pending_redeem_count
                FROM 
                    pages
                LEFT JOIN 
                    redeem ON pages.id = redeem.pg_id AND redeem.status = 'Pending' AND del='0'
                JOIN 
                    user ON FIND_IN_SET(pages.id, user.pgid) AND user.id = $uid
                WHERE 
                    pages.status = 'active'
                GROUP BY 
                    pages.id, pages.pagename
                ORDER BY 
                    pages.pagename ASC;");
            if(mysqli_num_rows($query) > 0){
                while($row=mysqli_fetch_array($query)){
                    $id=$row['id'];
                    $pagename=$row['pagename'];
                    $html.='<option value="'.$row['id'].'">'.$row['pagename'].'</option>';
                   // echo "<pre>";
                   //  print_r($row); 
                }
            }

            // echo "<pre>";
            // print_r($pages);
            if(isset($_POST['redeemstatus']))
            {
                $pgid       =$_POST['pg_id'];
                $cust_name  =$_POST['cust_name'];
                $game_id    =$_POST['game_id'];
                $status     =$_POST['rdmstatus'];
                $issue      =$_POST['issue'];
                $uid        =$_POST['uid'];
                $type       =$_POST['type'];
                $uname      =$_POST['uname'];
                $created_at =date('Y-m-d H:i:s');

                $query = mysqli_query($connect, "INSERT INTO pending_redeem (pageid,customer_name,gameid,status,issue,utype,uid,uname,created_at) 
                    VALUES ('$pgid','$cust_name','$game_id','$status','$issue','$type','$uid','$uname','$created_at')") or die(mysqli_error($connect));

                if ($query) {
                    echo '<script>
                        Swal.fire({
                        title: "Good job!",
                        text: "Added Successfully!",
                        icon: "success",
                    }).then(() => {
                        window.location.href = "' . $_SERVER['PHP_SELF'] . '";
                    });</script>';
                    exit;
                } else {
                    echo "Error: Unable to insert data.";
                }
                // echo "<pre>";
                // print_r($_POST);
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
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Unprocess Redeem Form</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Chat Support</a></li>
                                        <li class="breadcrumb-item active">Unprocess Redeem Form</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                   <div class="row justify-content-center" >
                        <div class="col-lg-6">
                            <div class="text-center mb-4 mt-4">
                               <!--  <a href="index.php" class="auth-logo mb-5 d-block">
                                    <img src="../assets/images/logo-login.png" alt="" height="75" class="logo logo-dark">
                                    <img src="../assets/images/logo-login.png" alt="" height="65" class="logo logo-light">
                                </a> -->
                                <i class="bx bx-money"></i> <h4>Add Unprocess Redeem</h4>
                                <!-- <p class="text-muted mb-4">Sign in to continue to Chatters 2.0.</p>                             -->
                            </div>

                            <div class="card chat-conversation" data-simplebar="init">
                                <div class="card-body p-4">
                                    <div class="p-3">
                                        <form  method="post" action="#">
                                            <div class="mb-3">
                                                <label class="form-label" for="pg_id">Page Name</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class="bx bx-box"></i>
                                                    </span>
                                                   <select name="pg_id" id="pg_id" class="form-control">
                                                       <?php echo $html;?>
                                                   </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="cust_name">Customer Name</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                        <i class="bx bx-user"></i>
                                                    </span>
                                                    <input type="text" name="cust_name" id="cust_name" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Customer Name" aria-label="Enter Customer Name" aria-describedby="basic-addon3" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="game_id">Game ID</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class=" bx bx-duplicate"></i>
                                                    </span>
                                                    <input type="text" name="game_id" id="game_id" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Game ID" aria-label="Enter Game ID" aria-describedby="basic-addon3" required>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="rdmstatus">Status</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class="bx bx-stats"></i>
                                                    </span>
                                                    <select name="rdmstatus" id="rdmstatus" class="form-control">
                                                      
                                                        <option value="Pending">Pending</option>
                                                       
                                                   </select>
                                                </div>
                                            </div>
                                             
                                            <div class="mb-4">
                                               <label for="pasteimages" class="form-label">Issue Due To </label>
                                                <textarea class="form-control" name="issue" placeholder="Type Here..." style="resize: none;" id="issue" required></textarea>
                                               
                                               
                                            </div>
                                            <!-- <div class="form-check mb-4">
                                                <input type="checkbox" class="form-check-input" id="remember-check">
                                                <label class="form-check-label" for="remember-check">Remember me</label>
                                            </div> -->
                                            <input type="hidden" name="uid" value="<?php echo $uid;?>">
                                            <input type="hidden" name="type" value="<?php echo $type;?>">
                                            <input type="hidden" name="uname" value="<?php echo $uname;?>">

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary" name="redeemstatus" id="btn_redeem_status">Create</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <!-- <div class="mt-5 text-center">
                                <p>Don't have an account ? <a href="auth-register.html" class="fw-medium text-primary"> Signup now </a> </p>
                                <p>© <script>document.write(new Date().getFullYear())</script> Chatvia. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                            </div> -->
                        </div>
                       <!--  <div class="col-md-4 col-lg-4 col-xl-4 ">
                            <div class="mb-4 mt-5">
                                
                                <label class="form-label" for="search_keyword">Search Using Game ID Or Customer Name</label>
                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                    <input type="text" name="search_keyword" id="search_keyword" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Customer Name / Customer GID" aria-label="Enter Customer Name" aria-describedby="basic-addon3">
                                </div>
                            </div>

                        </div> -->
                    </div>
                </div>
            </div>
            <?php include('footer.html');?>
		</div>

	</div>

	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
</body>
</html>