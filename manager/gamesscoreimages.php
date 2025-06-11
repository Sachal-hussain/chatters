
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Game Scores Images | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
    <style>
		body {
		    font-family: Arial, sans-serif;
		}

		.slider {
		    display: none;
		    position: fixed;
		    top: 0;
		    left: 0;
		    width: 100%;
		    height: 100%;
		    background-color: rgba(0, 0, 0, 0.8);
		    justify-content: center;
		    align-items: center;
		    z-index: 9999;
		}

		.slider-content {
		    display: flex;
		    align-items: center;
		    justify-content: center;
		    height: 100%;
		    overflow: hidden;
		}

		.slider-content img {
		    display: none;
		    max-width: 90%;
		    max-height: 90%;
		}

		.slider-content img.active {
		    display: block;
		}

		.close {
		    position: absolute;
		    top: 20px;
		    right: 30px;
		    font-size: 30px;
		    cursor: pointer;
		    color: white;
		}

		.prev, .next1 {
		    cursor: pointer;
		    position: absolute;
		    top: 50%;
		    width: auto;
		    padding: 16px;
		    margin-top: -22px;
		    color: white;
		    font-weight: bold;
		    font-size: 20px;
		    transition: 0.3s;
		    user-select: none;
		}

		.prev {
		    left: 0;
		}

		.next1 {
		    right: 0;
		}

		.prev:hover, .next1:hover {
		    background-color: rgba(0, 0, 0, 0.8);
		}
	</style>

</head>
<body>
	<div id="layout-wrapper">
		<?php include('topheader.php');?>
    <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php 
      		if ($type == 'CSR' || $type == 'Q&A' || $type == 'Redeem') {

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
	      	if(isset($_GET['page_id']) && $_GET['page_id']!=''){
	      		$pageid=$_GET['page_id'];

			    $html='';
			    $i='0';
			    $query = mysqli_query($connect, "SELECT * FROM img_upload
			    WHERE catransid=$pageid
			    AND type='Score Attachment' ");
		      	if(mysqli_num_rows($query) > 0){
			        while($row=mysqli_fetch_array($query)){
			          // echo "<pre>";
			          // print_r($row);
			          // exit;
			          $i++;
			          // $id=$row['pageid'];
			          $img     =$row['path'];
			          $created_at   =$row['createdat'];
			          
			          $html.=
			          '<tr>
			            <td>'.$i.'</td>
			             <td><img src="../assets/images/gamesscore/' . $img . '" style="width:100px; cursor:pointer;" onclick="openSlider(' . ($i - 1) . ')"></td>
			            <td>'.$created_at.'</td>
			            </td>
			          </tr>
			          ';
			         
			        }
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
                                <h4 class="mb-sm-0 font-size-18"><a href="<?php echo shift_record;?>">Shift Closing</a> >> Score Images</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                                        <li class="breadcrumb-item active">Score Images</li>
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
                                       <table class="table table-bordered" id="tb_images">
                                            <thead>
                                                <tr>
                                                  <th scope="col">#</th>
                                                  <th scope="col">Images</th>
                                                  <th scope="col">Created At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php echo $html;?> 
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
    
	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
	<div id="slider" class="slider">
        <span class="close" onclick="closeSlider()">&times;</span>
        <div class="slider-content">
            <?php
                $query = mysqli_query($connect, "SELECT * FROM img_upload WHERE catransid=$pageid AND type='Score Attachment' ");
                while ($row = mysqli_fetch_array($query)) {
                    $img = $row['path'];
                    echo '<img src="../assets/images/gamesscore/' . $img . '" class="slider-img">';
                }
            ?>
        </div>
        <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
        <a class="next1" onclick="changeSlide(1)">&#10095;</a>
    </div>

    <script>
    	document.addEventListener('keydown', function(event) {
	        if (event.key === "ArrowLeft") {
	            changeSlide(-1); // Move to previous slide when left arrow key is pressed
	        } else if (event.key === "ArrowRight") {
	            changeSlide(1); // Move to next slide when right arrow key is pressed
	        }
	    });
	    $(document).ready(function () {
	        $('#tb_images').DataTable({
	            "order": [[0, 'desc']],
	        });

	    });
	</script>
	<script>
		let currentSlide = 0;

		function openSlider(index) {
		    document.getElementById('slider').style.display = 'flex';
		    showSlide(index);
		}

		function closeSlider() {
		    document.getElementById('slider').style.display = 'none';
		}

		function changeSlide(n) {
		    showSlide(currentSlide + n);
		}

		function showSlide(index) {
		    const slides = document.querySelectorAll('.slider-content img');
		    if (index >= slides.length) {
		        currentSlide = 0;
		    } else if (index < 0) {
		        currentSlide = slides.length - 1;
		    } else {
		        currentSlide = index;
		    }

		    slides.forEach((slide, i) => {
		        slide.classList.remove('active');
		        if (i === currentSlide) {
		            slide.classList.add('active');
		        }
		    });
		}
	</script>

</body>
</html>