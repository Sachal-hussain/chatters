
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Add Cashtag| SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
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
      require('../database/Pages.php');

      $object= new Pages();

      $pages=$object->get_all_pages();
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
                <h4 class="mb-sm-0 font-size-18">Add CashApp</h4>

                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Redeem</a></li>
                    <li class="breadcrumb-item active">Add CashApp</li>
                  </ol>
                </div>

              </div>
            </div>
          </div>
          <div class="row justify-content-center " >
            <div class="col-md-8 col-lg-6 col-xl-5 ">
              <div class="text-center mb-4 mt-4">
                
                <i class="bx bx-food-tag"></i> <h4>Add CashApp</h4>
                         
              </div>

              <div class="card chat-conversation" data-simplebar="init">
                <div class="card-body p-4">
                  <div class="p-3">
                    <form  method="post" id="cashapp_frm">  
                      <div class="mb-3">
                        <label class="form-label" for="pg_id">Page Name</label>
                        <div class="input-group mb-3 bg-light-subtle rounded-3">
                          <span class="input-group-text text-muted" id="basic-addon3">
                            <i class=" bx bx-box"></i>
                          </span>
                          <select name="pg_id" id="pg_id" class="form-control">
                           <?php foreach ($pages as $key => $page) {?>
                              <option value="<?php echo $page[0];?>-<?php echo $page[1];?> "><?php echo $page[1];?></option>
                           <?php } 
                           ?>
                          </select>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="cashapp_name">CashApp Name</label>
                        <div class="input-group mb-3 bg-light-subtle rounded-3">
                          <span class="input-group-text text-muted" id="basic-addon3">
                          <i class=" bx bx-dollar"></i>
                          </span>
                          <input type="text" name="cashapp_name" id="cashapp_name" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Name" aria-label="Enter Cashapp Name" aria-describedby="basic-addon3">
                        </div>
                      </div>
                      <div class="mb-3">
                        <label class="form-label" for="cashtag">CashApp Cashtag</label>
                        <div class="input-group mb-3 bg-light-subtle rounded-3">
                          <span class="input-group-text text-muted" id="basic-addon3">
                             <i class=" bx bx-dollar"></i>
                          </span>
                          <input type="text" name="cashtag" id="cashtag" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Cashtag" aria-label="Enter Game ID" aria-describedby="basic-addon3">
                        </div>
                      </div>
                      <input type="hidden" name="uid" value="<?php echo $uid;?>">
                      <input type="hidden" name="type" value="<?php echo $type;?>">
                    </form>
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary"  id="btn_cashapp">Add</button>
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


</body>
</html>