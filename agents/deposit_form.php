
<!DOCTYPE html>
<html>
<head>
  	<meta charset="utf-8" />
    <title>Deposit Form | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
	<div id="layout-wrapper">
        <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
		<?php include('topheader.php');?>
		<?php
            require('../database/Redeem.php');
            require('../database/ImageUpload.php');
            require('../database/CashappTransaction.php');
			require('../database/Pages.php');

			$object= new Pages();

			// $pages=$object->get_all_pages();
			$pages=$object->getPagesByIds($uid,$type);
		?>
        <?php
            require_once('../connect_me.php');
            $database_connection = new Database_connection();
            $connect = $database_connection->connect();



            if (isset($_POST['depositAdd'])) {
               // $hdn_imagedata  = $_POST['hdn_images'];
                // echo "<pre>";
                // print_r($_POST);
                // exit;
                $image = new ImageUpload();
                $object = new CashappTransaction();
                $redeem_status = new Redeem();

                $hdn_imagedata  = $_POST['hdn_images'];
                $redid          = $_POST['depredeemid'];
                $from_cust      = mysqli_real_escape_string($connect, $_POST['from_cust']);
                $pgid           = mysqli_real_escape_string($connect, $_POST['dpg_id']);
                $cust_game_id   = mysqli_real_escape_string($connect, $_POST['cust_game_id']);
                $decust_name    = mysqli_real_escape_string($connect, $_POST['decust_name']);
                $cust_deposit   = mysqli_real_escape_string($connect, $_POST['cust_deposit']);
                $cust_bonus     = mysqli_real_escape_string($connect, $_POST['cust_bonus']);
                $payment        = explode("-", $_POST['payment_method']);
                $payment_method = $payment[0];
                $uid            = mysqli_real_escape_string($connect, $_POST['uid']);
                $uname          = mysqli_real_escape_string($connect, $_POST['uname']);
                $gid            = mysqli_real_escape_string($connect, $_POST['g_id']);
                $created_at     = date('Y-m-d H:i:s');
                $date           = date('Y-m-d');

                if (empty($decust_name) || empty($hdn_imagedata) || empty($cust_deposit) || empty($payment_method) || empty($cust_game_id)) {
                    echo '<script>
                            Swal.fire({
                                title: "Validation Error",
                                text: "Please fill in all required fields.",
                                icon: "warning",
                            }).then(() => {
                                window.location.href = "deposit_form.php";
                            });
                          </script>';
                    exit();
                }
                // Validate C2C method
                if ($payment_method === 'C2C' && $from_cust == '') {
                    echo '<script>
                            Swal.fire({
                                title: "Validation Error",
                                text: "For C2C method, From Customer or Image must not be empty.",
                                icon: "warning",
                            }).then(() => {
                                window.location.href = "deposit_form.php";
                              });
                          </script>';
                    exit();
                }

                // If C2C, process additional queries
                if ($payment_method === 'C2C') {

                    try {
                        // Save images if available
                        if ($hdn_imagedata != '') {
                            $savedImages = $image->saveRedeemimage($hdn_imagedata);
                            if (!empty($savedImages)) {
                                foreach ($savedImages as $value) {
                                    $image->setCatransid($redid);
                                    $image->setType('Redeem Attachment');
                                    $image->setCreatedat($created_at);
                                    $image->setPath($value);
                                    $image->saveUploadimages();
                                }
                            } else {
                                throw new Exception('No images were saved.');
                            }
                        }

                        // Save transaction
                        $object->setRedId($redid);
                        $object->setCappid(0);
                        $object->setPaidfor('C2C');
                        $object->setPgid($pgid);
                        $object->setPaytype('Paid');
                        $object->setAmount($cust_deposit);
                        $object->setComments('C2C');
                        $object->setStatus('active');
                        $object->setCreatedat($created_at);
                        $object->setRedeemBy($uname);
                        $object->setPaymentMethod($payment_method);
                        $object->setFromCust($from_cust);
                        $object->saveTransaction();

                        // Update redeem status
                        $redeem_status->setId($redid);
                        $redeem_status->setStatus('Pending');
                        $redeem_status->setRedeemBy($uname);
                        $redeem_status->setAmtPaid($cust_deposit);
                        $redeem_status->setAmtRefund(0);
                        $redeem_status->setAmtAddback(0);
                        $redeem_status->setAmtBal(0);
                        $redeem_status->setComment('C2C');
                        $redeem_status->setPaidbyclient('NO');
                        $redeem_status->setClientname('');
                        $redeem_status->setRedeemedDate($created_at);
                        $redeem_status->setRedeemfor('');
                        $redeem_status->setRedeemfrom('');
                        $redeem_status->setPaymentMethod($payment_method);
                        $redeem_status->setFromCust($from_cust);
                        $redeem_status->setToCust($decust_name);
                        $redeem_status->updateRedeemstatus();
                    } catch (Exception $e) {
                        echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "' . $e->getMessage() . '",
                                    icon: "error",
                                }).then(() => {
                                    window.location.href = "deposit_form.php";
                                });
                              </script>';
                        exit();
                    }
                }

                // Process deposit values
                $tag = ($cust_deposit >= 1 && $cust_deposit <= 50) ? 'Low' : (($cust_deposit > 50 && $cust_deposit <= 100) ? 'Medium' : (($cust_deposit > 100) ? 'High' : 'Bonus'));

                $stmt = $connect->prepare("INSERT INTO deposit (`date`, `pg_id`, `cust_name`, `gm_id`, `amount`, `bonus`, `tag`, `gid`, `payment_method`, `uname`, `from_cust`,`uid`,`created_at`) 
                                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if ($stmt === false) {
                    die('Prepare failed: ' . htmlspecialchars($connect->error));
                }

                $stmt->bind_param('sissddsisssis', $date, $pgid, $decust_name, $cust_game_id, $cust_deposit, $cust_bonus, $tag, $gid, $payment_method, $uname, $from_cust, $uid, $created_at);

                if ($stmt->execute()) {
                    $deposit_id = $connect->insert_id;
                    if ($hdn_imagedata != '') {
                        try {
                            $savedImages = $image->saveRedeemimage($hdn_imagedata);
                            if (!empty($savedImages)) {
                                foreach ($savedImages as $value) {
                                    // Save image with the deposit ID
                                    $image->setCatransid($deposit_id);  // Use the deposit ID here
                                    $image->setType('Deposit Attachment');
                                    $image->setCreatedat($created_at);
                                    $image->setPath($value);
                                    $image->saveUploadimages();
                                }
                            } else {
                                throw new Exception('No images were saved.');
                            }
                        } catch (Exception $e) {
                            echo '<script>
                                    Swal.fire({
                                        title: "Error",
                                        text: "' . $e->getMessage() . '",
                                        icon: "error",
                                    }).then(() => {
                                        window.location.href = "deposit_form.php";
                                    });
                                  </script>';
                            exit();
                        }
                    }
                    echo '<script>
                            Swal.fire({
                                title: "Good job!",
                                text: "Added Successfully!",
                                icon: "success",
                            });
                            setTimeout(function(){
                                document.querySelector(".swal2-container").remove();
                            }, 1000);
                            setTimeout(function(){
                                window.location.href = "deposit_form.php";
                            }, 1000);
                          </script>';
                    exit();
                } else {
                    echo '<script>
                            Swal.fire({
                                title: "Error",
                                text: "Unable to insert data.",
                                icon: "error",
                            });
                          </script>';
                }

                $stmt->close();
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
                    <div class="row ">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Deposit Form</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Chat Support</a></li>
                                        <li class="breadcrumb-item active">Deposit Form</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center" >
                        <h4>Add Game Deposits And Bonus</h4>
                        <?php foreach ($pages as $key => $page) {
                            $singleid=$page['id'];
                            $res='';

                            $gameinfo_stmt = mysqli_query($connect, "SELECT id, g_name FROM gameinfo WHERE pg_id = $singleid ORDER BY g_name ASC");
                            $games_options = '';
                            while ($gameinfo_row = mysqli_fetch_assoc($gameinfo_stmt)) {
                                $games_options .= '<option value="' . $gameinfo_row['id'] . '">' . $gameinfo_row['g_name'] . '</option>';
                            }

                            $stmt = mysqli_query($connect, "SELECT gm_id,amount,bonus,created_at 
                                FROM deposit
                                WHERE pg_id=$singleid
                                ORDER BY deposit.created_at DESC 
                                LIMIT 1");
                            if(mysqli_num_rows($stmt) > 0){
                                while ($row = mysqli_fetch_assoc($stmt)) {
                                    $lastamount=$row['amount'];
                                    $lastbonus=$row['bonus'];
                                    $lastgid=$row['gm_id'];
                                    $lastdate=$row['created_at'];
                                    $res.='<tr>
                                    <td>'.$lastgid.'</td>
                                    <td class="bg-success-subtle">'.$lastamount.'</td>
                                    <td class="bg-danger-subtle">'.$lastbonus.'</td>
                                    <td>'.$lastdate.'</td>

                                    </tr>';


                                }

                            }
                            ?>
                        <div class="col-sm-6">   
                           <!--  <div class="card chat-conversation" >
                                <div class="card-body p-4"> -->
                                    <div class="p-3">
                                        
                                        <form  method="post" action="#" id="customerDepositfrm">
                                            <div class="mb-3">
                                                <label class="form-label" for="dpg_id">Page Name</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class=" bx bx-box"></i>
                                                    </span>
                                                   <select name="dpg_id" id="dpg_id" class="form-control dep_page_dropdown" required>
                                                        <!-- <option value="" disabled selected>-- Select One --</option> -->
                                                        <option value="<?php echo $page['id'];?> "><?php echo $page['pagename'];?></option>
                                                        
                                                   </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="cust_name">Customer</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                   
                                                    <select name="decust_name" id="decust_name-<?php echo $page['id'];?>" class="form-control form-select depcustomer_dropdown-<?php echo $page['id'];?>">
                                                       
                                                    </select>
                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label" for="payment_method">Payment Method</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class=" bx bx-dollar"></i>
                                                    </span>
                                                   <select name="payment_method" id="payment_method" class="form-control payment_method" required>
                                                        <option value="Cashapp-<?php echo $page['id'];?>">Cashapp</option>
                                                        <option value="Zelle-<?php echo $page['id'];?>">Zelle</option>
                                                        <option value="BTC-<?php echo $page['id'];?>">BTC</option>
                                                        <option value="Apple Pay-<?php echo $page['id'];?>">Apple Pay</option>
                                                        <option value="CoinBase-<?php echo $page['id'];?>">CoinBase</option>
                                                        <option value="Binance-<?php echo $page['id'];?>">Binance</option>
                                                        <option value="C2C-<?php echo $page['id'];?>">C2C</option>
                                                        
                                                   </select>
                                                   
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="g_id">Game Name</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                       <i class=" bx bx-box"></i>
                                                    </span>
                                                   <select name="g_id" id="g_id" class="form-control" required>
                                                        <option></option>
                                                       <?php echo $games_options;?>
                                                        
                                                   </select>
                                                   
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label" for="cust_game_id">Game ID</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                        <i class=" bx bx-user"></i>
                                                    </span>
                                                    <input type="text" name="cust_game_id" id="cust_game_id" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Customer Game Id" aria-label="Enter Customer Game Id" aria-describedby="basic-addon3" required>
                                                </div>
                                            </div>
                                            <div class="mb-3 d-none" id="input_from_cust-<?php echo $page['id'];?>">
                                                <label class="form-label" for="from_cust">Deposit From Customer</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                        <i class=" bx bx-user"></i>
                                                    </span>
                                                   <!--  <input type="text" name="from_cust" id="from_cust" class="form-control form-control-lg border-light bg-light-subtle" placeholder="From Customer" aria-label="Enter Customer Game Id" aria-describedby="basic-addon3"> -->
                                                   <select name="from_cust" id="fromcust_name-<?php echo $page['id'];?>" class="form-control form-select depcustomer_dropdown-<?php echo $page['id'];?>">
                                                       
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="cust_deposit">Deposit Amount</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                        <i class=" bx bx-dollar"></i>
                                                    </span>
                                                    <input type="number" name="cust_deposit" id="cust_deposit" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Deposit..." aria-label="Enter Deposit..." aria-describedby="basic-addon3">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="cust_bonus">Bonus Amount</label>
                                                <div class="input-group mb-3 bg-light-subtle rounded-3">
                                                    <span class="input-group-text text-muted" id="basic-addon3">
                                                        <i class=" bx bx-dollar"></i>
                                                    </span>
                                                    <input type="number" name="cust_bonus" id="cust_bonus" class="form-control form-control-lg border-light bg-light-subtle" placeholder="Enter Bonus..." aria-label="Enter Bonus..." aria-describedby="basic-addon3" value="0" required>
                                                    
                                                </div>
                                            </div>
                                            <div class="mb-4" id="dep_image-<?php echo $page['id'];?>">
                                               <label for="pasteimages" class="form-label">Upload Images </label>
                                                <textarea class="form-control demod demo-textaread" placeholder="Paste your images here" style="resize: none;" id="pasteimages" data-page-id="<?php echo $page['id']; ?>" disabled></textarea>
                                                <input type="hidden" name='hdn_images' class="hdn_images-<?php echo $page['id'];?>" id='hdn_images'>
                                               
                                            </div>

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary" name="depositAdd" id="deposit_save">Save</button>
                                            </div>

                                            <input type="hidden" name="uid" value="<?php echo $uid;?>">
                                            <input type="hidden" name="type" value="<?php echo $type;?>">
                                            <input type="hidden" name="uname" value="<?php echo $uname;?>">
                                            <input type="hidden" name="depositSelectPage" id="depositSelectPage-<?php echo $page['id'];?>" value="<?php echo $page['id'];?>">
                                            <input type="hidden" name="depositCustomerName" id="depositCustomerName-<?php echo $page['id'];?>" value="">
                                            <input type="hidden" name="depredeemid" id="depredeemid-<?php echo $page['id'];?>" value="">
                                        </form>
                                        
                                    </div>
                                    <table class="table table-bordered table-sm d-none" id="pendingRedeem_tbl-<?php echo $page['id'];?>" >
                                      <thead>
                                        <h4 class="d-none" id="heading-<?php echo $page['id'];?>">Pending Redeem</h4>
                                        <tr>
                                          <th scope="col">Customer</th>
                                          <th scope="col" class="bg-success-subtle">Redeem Amount</th>
                                          <!-- <th scope="col" class="bg-danger-subtle">Paid</th> -->
                                          <th scope="col" class="bg-danger-subtle">Remaining</th>

                                        </tr>
                                      </thead>
                                      <tbody id="redeemDetail_tbl-<?php echo $page['id'];?>">
                                         
                                      </tbody>

                                    </table>
                                    <table class="table table-bordered table-sm" >
                                      <thead>
                                        <h4>Last Deposit</h4>
                                        <tr>
                                          <th scope="col">ID</th>
                                          <th scope="col" class="bg-success-subtle">Amount</th>
                                          <th scope="col" class="bg-primary-subtle">Bonus</th>
                                          <th scope="col">Created At</th>

                                        </tr>
                                      </thead>
                                      <tbody>
                                         <?php echo $res;?> 
                                      </tbody>

                                    </table>
                               <!--  </div>
                            </div> -->
                                
                        </div>
                        <?php }?>  
                        
                    </div>
                </div>
            </div>
            <?php include('footer.html');?>
		</div>

	</div>

	<div class="rightbar-overlay"></div>

	<?php include('footer_links.html');?>
    
    <!-- <script>
        $(document).ready(function() {
            // Loop through all the dropdowns with the class 'dep_page_dropdown'
            $('.dep_page_dropdown').each(function() {
                var pgid = $(this).val(); // Get the page ID for each dropdown

                if (pgid) { // Ensure pgid exists
                    $.ajax({
                        url: 'action.php',
                        type: 'POST',
                        data: { 
                            depositpgid: pgid, 
                            action: 'depositPage'
                        },
                        success: function(response) {
                            // Check if the response is a valid JSON and contains the customers data
                            try {
                                var data = JSON.parse(response);
                                if (data.customers) {
                                    // Populate the corresponding customer dropdown with the options
                                    $('.depcustomer_dropdown-' + pgid).html(data.customers);

                                    // Reinitialize Select2 for this dropdown
                                    $('.depcustomer_dropdown-' + pgid).select2({
                                        placeholder: 'Please Select Customer',
                                        width: '100%'
                                    });

                                    // Automatically open the dropdown after initialization
                                    // $('.depcustomer_dropdown-' + pgid).select2('open');

                                    // Handle the change event when a customer is selected
                                    $('.depcustomer_dropdown-' + pgid).on('change', function() {
                                        var customerName = $(this).find('option:selected').val(); // Get selected customer name
                                        if (customerName) {
                                            // Update hidden fields or other necessary fields based on the selection
                                            $('#depositSelectPage' + '-' + pgid).val(pgid);
                                            $('#depositCustomerName' + '-' + pgid).val(customerName);
                                        }
                                    });
                                } else {
                                    console.error('No customers found for page ID: ' + pgid);
                                }
                            } catch (error) {
                                console.error('Error parsing response: ', error);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error with AJAX request: ', error);
                        }
                    });
                }
            });

            // Initialize Select2 for any dynamically generated or existing selects
            $('.depcustomer_dropdown').each(function() {
                if (!$(this).data('select2')) {
                    $(this).select2({
                        placeholder: 'Please Select Customer',
                        width: '100%'
                    });
                }
            });
        });
    </script> -->
   <!--  <script>
          $(document).ready(function() {
            // Loop through all the dropdowns with the class 'dep_page_dropdown'
            $('.dep_page_dropdown').each(function() {
                var pgid = $(this).val(); // Get the page ID for each dropdown

                if (pgid) {
                    $('.depcustomer_dropdown-' + pgid).select2({
                        placeholder: 'Please Select Customer',
                        width: '100%',
                        ajax: {
                            url: 'action.php', // PHP endpoint
                            type: 'POST',
                            dataType: 'html',  // We expect HTML response, not JSON
                            data: function(params) {
                                return {
                                    depositpgid: pgid,  // Pass the page ID to the server
                                    action: 'depositPage', // Action to fetch customers by page ID
                                    searchTerm: params.term || '' // Send the search term (empty if no search)
                                };
                            },
                            processResults: function(response) {
                                var $dropdown = $('.depcustomer_dropdown-' + pgid);
                                $dropdown.html(response);  // Replace the dropdown options with the response

                                // Reinitialize Select2 after updating the dropdown with new options
                                $dropdown.trigger('change'); // Trigger the change event to refresh the dropdown
                                $dropdown.select2({
                                    placeholder: 'Please Select Customer',
                                    width: '100%'
                                });

                                return { results: [] }; // Return an empty results array as we're handling the HTML manually
                            },
                            error: function(xhr, status, error) {
                                console.error('Error with AJAX request:', error);
                            }
                        }
                    });

                    // Handle the change event when a customer is selected
                    $('.depcustomer_dropdown-' + pgid).on('change', function() {
                        var customerName = $(this).find('option:selected').val(); // Get selected customer ID
                        if (customerName) {
                            // Update hidden fields or other necessary fields based on the selection
                            $('#depositSelectPage' + '-' + pgid).val(pgid);
                            $('#depositCustomerName' + '-' + pgid).val(customerName);
                        }
                    });
                }
            });
        });
    </script> -->
    <script>
    $(document).ready(function() {
    // Loop through all the dropdowns with the class 'dep_page_dropdown'
    $('.dep_page_dropdown').each(function() {
        var pgid = $(this).val(); // Get the page ID for each dropdown

        if (pgid) {
            $('.depcustomer_dropdown-' + pgid).select2({
                placeholder: 'Please Select Customer',
                width: '100%',
                allowClear: true, // Allow clearing the selection
                minimumInputLength: 1, // Start searching after 1 character
                ajax: {
                    url: 'action.php', // PHP endpoint
                    type: 'POST',
                    dataType: 'json',  // Expect JSON response
                    data: function(params) {
                        return {
                            depositpgid: pgid,  // Pass the page ID to the server
                            action: 'depositPage', // Action to fetch customers by page ID
                            searchTerm: params.term || '' // Send the search term (empty if no search)
                        };
                    },
                    processResults: function(data) {
                        // Process the result and return formatted data for select2
                        return {
                            results: data.results // 'results' is an array returned from the server
                        };
                    },
                    error: function(xhr, status, error) {
                        console.error('Error with AJAX request:', error);
                    }
                }
            });

            // Handle the change event when a customer is selected
            $('.depcustomer_dropdown-' + pgid).on('change', function() {
                var customerName = $(this).find('option:selected').val(); // Get selected customer ID
                if (customerName) {
                    // Update hidden fields or other necessary fields based on the selection
                    $('#depositSelectPage' + '-' + pgid).val(pgid);
                    $('#depositCustomerName' + '-' + pgid).val(customerName);
                }
            });
        }
    });
});

</script>
</body>
</html>