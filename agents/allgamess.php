
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Games SS | SHJ INTERNATIONAL</title>
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

      $pages='';
      $i='0';
      $query = 
      mysqli_query($connect, " SELECT 
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
          $i++;
          // echo "<pre>";
          // print_r($row);
          // exit;
          $id=$row['id'];
          $pagename=$row['pagename'];
          $pages.='<tr>
            <td>'.$i.'</td>
            <td>'.$pagename.'</td>
            <td>
            <i class="bx bx-edit games_ss" data-id="'.$id.'" style="cursor:pointer;"></i>
            </td>
          </tr>
          ';
        }
      }
      
        
             
      // save data start here
      if(isset($_POST['save']))
      {
       
        // SweetAlert success message and redirect
        echo '<script>
                Swal.fire({
                    title: "Good job!",
                    text: "Record Saved Successfully!",
                    icon: "success",
                }).then(() => {
                    window.location.href = "shift_records.php";
                });
              </script>';
        exit();
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
                                <h4 class="mb-sm-0 font-size-18">Games Score ScreenShots</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">CSR</a></li>
                                        <li class="breadcrumb-item active">Games Score ScreenShots</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center " >
                        <div class="col-md-8 col-lg-6 col-xl-12 ">
                            <!-- <div class="text-center mb-4 mt-4">
                             
                                <i class=" bx bx-user"></i> <h4>Agent Shuffling Lists</h4>
                              
                            </div> -->

                            <!-- <div class="card chat-conversation" data-simplebar="init">
                                <div class="card-body p-4"> -->
                                    <div class="p-3">
                                       <table class="table table-bordered" id="">
                                            <thead>
                                                <tr>
                                                  <th scope="col">#</th>
                                                 <!--  <th scope="col">Agent Name</th> -->
                                                  <th scope="col">Page Name</th>
                                                  
                                                  <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php echo $pages;?> 
                                            </tbody>
                                           
                                        </table>

                                    </div>
                               <!--  </div>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>
            <?php include('footer.html');?>
		</div>

	</div>
    <div class="modal fade" id="gamesscoress" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
            <div class="modal-content">
                
              <div class="modal-header">
                  <h5 class="modal-title font-size-16" id="createticketLabel">Add Images</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  </button>
              </div>
              <div class="modal-body p-4">
              <form method="post" action="#" id="gamesscorefrm">
                <div class="mb-4">
                  <label class="form-label" for="cashapp_open">Paste Images</label>
                    
                  <textarea class="form-control imges_past paste-images" placeholder="Paste your images here" style="resize: none;" id="scoreimages" disabled></textarea>
                  <input type="hidden" name='hdn_gamesscoreimages' id='hdn_images'>
                    
                </div>
                
                <input type="hidden" name="uid" value="<?php echo $uid;?>">
                <input type="hidden" name="type" value="<?php echo $type;?>">
                <input type="hidden" name="uname" value="<?php echo $uname;?>">
                <input type="hidden" name="scorepgid" id="scorepgid">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" name="save" id="btn_gamesscore">Save</button>
                </div>
              </form>
              </div>
            </div>
        </div>
    </div>
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
   
</body>
</html>