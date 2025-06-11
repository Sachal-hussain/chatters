
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Shift Closing | SHJ INTERNATIONAL</title>
    <?php require("links.html"); ?>
</head>
<body>
  <div id="layout-wrapper">
    <?php include('topheader.php');?>
    <script src="../assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <?php 
      if ($type == 'CSR' || $type == 'Q&A' || $type == 'Redeem' || $department=='Redeem') {

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

     $pages='';
     $i='0';
     $adddeposit='';
      $query = mysqli_query($connect, "SELECT 
              pages.*,shift_closing.*,pages.id as pageid 
              FROM 
                  pages
              LEFT JOIN 
                  shift_closing ON pages.id = shift_closing.pg_id 
              WHERE 
                  pages.status = 'active'
              GROUP BY 
                  pages.id, pages.pagename
              ORDER BY 
                  pages.pagename ASC");
      if(mysqli_num_rows($query) > 0){
        while($row=mysqli_fetch_array($query)){
          // echo "<pre>";
          // print_r($row);
          // exit;
          $i++;
          $id=$row['pageid'];
          $pagename         =$row['pagename'];
          $cashapp_opening  =$row['cashapp_opening'];
          $game_opening     =$row['game_opening'];
          $redeem_opening   =$row['redeem_opening'];
          $cashapp_closing  =$row['cashapp_closing'];
          $game_closing     =$row['game_closing'];
          $redeem_closing   =$row['redeem_closing'];
          $pending_redeem   =$row['pending_redeem'];
          $cashout          =$row['cashout'];
          $redeem_for_other          =$row['redeem_for_other'];
          $bonus            =$row['bonus'];
          $shift            =$row['shift'];
          $name             =$row['uname'];
          $created_at       =$row['created_at'];
          $updated_at       =$row['updated_at'];

         
          $pages.=
          '<tr>
            <td>'.$i.'</td>
            <td>'.$pagename.'</td>
             <td><a href="gamesscoreimages.php?page_id='.$id.'">View Games Score</a></td>
            <td>'.$cashapp_opening.'</td>
            <td>'.$cashapp_closing.'</td>
            <td>'.$game_opening.'</td>
            <td>'.$game_closing.'</td>
            <td>'.$redeem_closing.'</td>
            <td>'.$pending_redeem.'</td>
            <td>'.$redeem_for_other.'</td>
            <td>'.$cashout.'</td>
            <td>'.$bonus.'</td>
            <td>'.$shift.'</td>
            <td>'.$name.'</td>
            <td>'.$created_at.'</td>
            <td>'.$updated_at.'</td>
            <td>
            <button class="btn btn-outline-success btn-sm btn-sm waves-effect waves-light  pg_action m-1" data-id="'.$id.'" data-cashapp="'.$cashapp_opening.'" data-game="'.$game_closing.'" data-cashout="'.$cashout.'" data-cashappclose="'.$cashapp_closing.'" data-paidredeem="'.$redeem_closing.'" data-pendredeem="'.$pending_redeem.'" data-redeedforother="'.$redeem_for_other.'" style="cursor:pointer;" title="add details" >Add Details</button>
             
            <button class="btn btn-outline-danger btn-sm waves-effect waves-light  m-1 add_gamescore" data-id="'.$id.'" data-pgname="'.$pagename.'" style="cursor:pointer;">Add Deposit</button>
            
            </td>
          </tr>
          ';
         
        }
      }
       // <button class="btn btn-danger btn-sm edit_gamescore m-1" data-id="'.$id.'" data-cashappclose="'.$cashapp_closing.'" data-gameclose="'.$game_closing.'" data-redeemclose="'.$redeem_closing.'" data-pendingredeem="'.$pending_redeem.'" data-cashoutamount="'.$cashout.'" data-bonus="'.$bonus.'"  style="cursor:pointer;" title="edit details">Edit Details</button>      
      // save data start here
      if(isset($_POST['save']))
      {
        // echo "<pre>";
        // print_r($_POST);
        // exit;
        $pg_id          = isset($_POST['pg_id']) ? $_POST['pg_id'] : '';
        $cashapp_open   = isset($_POST['cashapp_open']) ? $_POST['cashapp_open'] : '0';
        $games_open     = isset($_POST['games_open']) ? $_POST['games_open'] : '0';
        $redeem_open    = isset($_POST['redeem_open']) ? $_POST['redeem_open'] : '0';
        $cashapp_close  = isset($_POST['cashapp_close']) ? $_POST['cashapp_close'] : '';
        $games_close    = isset($_POST['games_close']) ? $_POST['games_close'] : '';
        $redeem_close   = isset($_POST['redeem_close']) ? $_POST['redeem_close'] : '';
        $shift          = isset($_POST['shift']) ? $_POST['shift'] : '';
        $end_date       = isset($_POST['ending_date']) ? $_POST['ending_date'] : '';
        $pending_redeem = $_POST['pending_redeem'];
        $cashoutamount  = $_POST['cashoutamount'];
        $bonusamount    = $_POST['bonusamount'];
        $redeemforother = $_POST['redeemforother'];
        $uname          = $_POST['uname'];
        $uid            = $_POST['uid'];
        $updated_at     =date('Y-m-d H:i:s');

        $cashappclosing     = $cashapp_close + $redeemforother;
        $cashapp_diff       = $cashapp_close - $cashapp_open;
        $game_diff          = $games_open   - $games_close;
        $redeem_diff        = $redeem_open  - $redeem_close;
        // echo "<pre>";
        // print_r($game_diff);
        // exit;

        // Check if record exists
        $sql_check = "SELECT COUNT(*) as count FROM shift_closing WHERE pg_id = ?";
        $stmt_check = $connect->prepare($sql_check);
        $stmt_check->bind_param("i", $pg_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();
        $record_exists = $row_check['count'] > 0;

        // Prepare SQL query based on existence of the record
        if ($record_exists) {
          // Update existing record
          $sql_update = "UPDATE shift_closing SET cashapp_opening = ?, cashapp_closing=?, game_opening = ?, game_closing=?, redeem_closing=?, pending_redeem=?, cashout=?, bonus=?, shift = ?, created_at = ?, uname = ?, uid = ?, updated_at = ? WHERE pg_id = ?";
          $stmt_update = $connect->prepare($sql_update);
          $stmt_update->bind_param("sssssssssssisi", $cashapp_open, $cashapp_close, $games_open, $games_close,$redeem_close, $pending_redeem, $cashoutamount, $bonusamount, $shift, $end_date, $uname, $uid, $updated_at, $pg_id);
          $stmt_update->execute();
        } 
        else {
          // Insert new record
          $sql_insert = "INSERT INTO shift_closing (pg_id, cashapp_opening, cashapp_closing, game_opening, game_closing, redeem_closing, pending_redeem, cashout, bonus, shift, created_at, uname, uid, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt_insert = $connect->prepare($sql_insert);
          $stmt_insert->bind_param("isssssssssssis", $pg_id, $cashapp_open, $cashapp_close, $games_open, $games_close, $redeem_close, $pending_redeem, $cashoutamount, $bonusamount, $shift, $end_date, $uname, $uid, $updated_at);
          $stmt_insert->execute();
        }

        $sql_insert_details = "INSERT INTO shift_closing_details (pg_id, cashappopening, cashappclosing, cashappdifference, gameopening, gameclosing, gamedifference,redeemclosing,redeemdifference,pending_redeem,redeem_for_other,cashout,bonus, shift,uid,uname,created_at) VALUES (?,  ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
        $stmt_insert_details = $connect->prepare($sql_insert_details);
        $stmt_insert_details->bind_param("isssssssssssssiss", $pg_id, $cashapp_open, $cashapp_close, $cashapp_diff, $games_open, $games_close, $game_diff,$redeem_close,$redeem_diff,$pending_redeem,$redeemforother,$cashoutamount,$bonusamount, $shift,$uid,$uname, $end_date);
        $stmt_insert_details->execute();

        // Close connections
        $stmt_insert_details->close();
        // Close connections
        // Close connection
        $stmt_check->close();
        $connect->close();

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

      // edit data start here
      if(isset($_POST['updated']))
      {
        // echo "<pre>";
        // print_r($_POST);
        // exit;
        $pg_id          = isset($_POST['editpg_id']) ? $_POST['editpg_id'] : '';
        $cashapp_close  = isset($_POST['edit_cashapp_close']) ? $_POST['edit_cashapp_close'] : '';
        $games_close    = isset($_POST['edit_games_close']) ? $_POST['edit_games_close'] : '';
        $redeem_close   = isset($_POST['edit_redeem_close']) ? $_POST['edit_redeem_close'] : '';
        $pending_redeem = $_POST['edit_pending_redeem'];
        $cashoutamount  = $_POST['editcashoutamount'];
        $bonusamount    = $_POST['editbonusamount'];
       

    
        // Check if record exists
        $sql_check = "SELECT COUNT(*) as count FROM shift_closing WHERE pg_id = ?";
        $stmt_check = $connect->prepare($sql_check);
        $stmt_check->bind_param("i", $pg_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();
        $record_exists = $row_check['count'] > 0;

        // Prepare SQL query based on existence of the record
        if ($record_exists) {
          // Update existing record
          $sql_update = "UPDATE shift_closing SET  cashapp_closing=?, game_closing=?,  redeem_closing=?, pending_redeem=?, cashout=?, bonus=? WHERE pg_id = ?";
          $stmt_update = $connect->prepare($sql_update);
          $stmt_update->bind_param("ssssssi", $cashapp_close, $games_close, $redeem_close, $pending_redeem, $cashoutamount, $bonusamount, $pg_id);
          $stmt_update->execute();
        } 
           
        // SweetAlert success message and redirect
        echo '<script>
                Swal.fire({
                    title: "Good job!",
                    text: "Record Updated Successfully!",
                    icon: "success",
                }).then(() => {
                    window.location.href = "shift_records.php";
                });
              </script>';
        exit();
      }

      if (isset($_POST['update_score'])) {
        $newGamescore = $_POST['addgamescore'];
        $scorepg_id = $_POST['scorepg_id'];

        // Retrieve the existing game_closing value
        $sql_select = "SELECT game_closing FROM shift_closing WHERE pg_id = ?";
        $stmt_select = $connect->prepare($sql_select);
        $stmt_select->bind_param("i", $scorepg_id);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();

        if ($result_select->num_rows > 0) {
          $row = $result_select->fetch_assoc();
          $currentGamescore = $row['game_closing'];

          // Calculate the new game_closing value
          $updatedGamescore = $currentGamescore + $newGamescore;

          // Update the existing record with the new game_closing value
          $sql_update = "UPDATE shift_closing SET game_closing = ? WHERE pg_id = ?";
          $stmt_update = $connect->prepare($sql_update);
          $stmt_update->bind_param("di", $updatedGamescore, $scorepg_id);
          $stmt_update->execute();

          // SweetAlert success message and redirect
          echo '<script>
                  Swal.fire({
                      title: "Good job!",
                      text: "Record Updated Successfully!",
                      icon: "success",
                  }).then(() => {
                      window.location.href = "shift_records.php";
                  });
                </script>';
          exit();
        } else {
          // Handle case where the record does not exist
          echo '<script>
                  Swal.fire({
                      title: "Error!",
                      text: "Record not found!",
                      icon: "error",
                  }).then(() => {
                      window.location.href = "shift_records.php";
                  });
                </script>';
          exit();
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
                                <h4 class="mb-sm-0 font-size-18">Shift Closing</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Manager</a></li>
                                        <li class="breadcrumb-item active">Shift Closing</li>
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
                                       <table class="table table-sm" id="shiftrecords">
                                            <thead>
                                                <tr>
                                                  <th scope="col">#</th>
                                                  <th scope="col">Page Name</th>
                                                  <th scope="col">Games Score</th>
                                                  <th scope="col">Cashapp Opening </th>
                                                  <th scope="col">Cashapp Closing</th>
                                                  <th scope="col">Game Opening  </th>
                                                  <th scope="col">Game Closing </th>
                                                  <th scope="col">Redeem Closing </th>
                                                  <th scope="col">Pending Redeem</th>
                                                  <th scope="col">Redeem Amount (Other Pages)</th>
                                                  <th scope="col">Cashout</th>
                                                  <th scope="col">Bonus</th>
                                                  <th scope="col">Shift</th>
                                                  <th scope="col">Username</th>
                                                  <th scope="col">Shift Closed Time</th>
                                                  <th scope="col">Updated At</th>
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
  <!-- add shift details mdl -->
  <div class="modal fade modal-lg" id="shiftrecord_modl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title font-size-16" id="createticketLabel">Add Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
              </div>
              <div class="modal-body p-4">
              <form method="post" action="#">
                <div class="mb-3">
                  <label class="form-label" for="cashapp_open">CashApp Total Opening</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="cashapp_open" id="cashapp_open" required readonly>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="cashapp_close">CashApp Total Closing</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="cashapp_close" id="cashapp_close" required readonly>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="games_open">Games Total Opening</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="games_open" id="games_open" required >
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="games_close">Games Total Closing</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="games_close" id="games_close" required >
                  </div>
                </div>
                <!-- <div class="mb-3">
                  <label class="form-label" for="redeem_open">Redeem Total Opening</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                      <span class="input-group-text text-muted" id="basic-addon3">
                         <i class=" bx bx-dollar"></i>
                      </span>
                     <input type="number" class="form-control" name="redeem_open" id="redeem_open" >
                  </div>
                </div> -->
                <div class="mb-3">
                  <label class="form-label" for="redeem_close">Redeem Paid Amount</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="redeem_close" id="redeem_close" required readonly>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="pending_redeem">Pending Redeem Amount</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="pending_redeem" id="pending_redeem" required readonly>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="redeemforother">Redeem Amount For Other Page</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="redeemforother" id="redeemforother" required readonly>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="cashoutamount">Cashout Amount</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="cashoutamount" id="cashoutamount" required readonly>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="bonusamount">Bonus Amount</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="bonusamount" id="bonusamount" required>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="shift">Shift</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                      <i class="bx bx-stopwatch"></i>
                    </span>
                    <select name="shift" id="shift" class="form-control" required>
                      <option value="Morning">Morning</option>
                      <option value="Evening">Evening</option>
                      <option value="Night">Night</option>

                   </select>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="ending_date">Select datetime</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class="bx bx-calendar-plus"></i>
                    </span>
                    <input type="text" name="ending_date" id="datetime" class="form-control form-control-lg border-light bg-light-subtle" placeholder="datetime" aria-describedby="basic-addon3" required>
                  </div>
                </div>
                
                <input type="hidden" name="uid" value="<?php echo $uid;?>">
                <input type="hidden" name="type" value="<?php echo $type;?>">
                <input type="hidden" name="uname" value="<?php echo $uname;?>">
                <input type="hidden" name="pg_id" id="pg_id">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" name="save" id="saveclosingdetails">Save</button>
                </div>
              </form>
              </div>
          </div>
      </div>
  </div>
  <!-- add games deposit mdl -->
  <div class="modal fade" id="addgamedeposit_modl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title font-size-16" id="createticketLabel">Add Deposit - <span class="text-danger" id="pgname-mdl"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
              </div>
              <div class="modal-body p-4">
              <form method="post" action="#">
                <div class="mb-3">
                  <label class="form-label" for="addgamescore">Add Game Scores</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="addgamescore" id="addgamescore" required >
                  </div>
                </div>
                
                <input type="hidden" name="uid" value="<?php echo $uid;?>">
                <input type="hidden" name="type" value="<?php echo $type;?>">
                <input type="hidden" name="uname" value="<?php echo $uname;?>">
                <input type="hidden" name="scorepg_id" id="scorepg_id">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" name="update_score" id="">Update</button>
                </div>
              </form>
              </div>
          </div>
      </div>
  </div>
  <!-- edit details mdl -->
  <div class="modal fade modal-lg" id="editshiftrecord_modl" tabindex="-1" role="dialog" aria-labelledby="createticketLabel" aria-hidden="true" data-bs-backdrop="static" style="display:none;">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title font-size-16" id="createticketLabel">Edit Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
              </div>
              <div class="modal-body p-4">
              <form method="post" action="#">
                
                <div class="mb-3">
                  <label class="form-label" for="edit_cashapp_close">CashApp Total Closing</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="edit_cashapp_close" id="edit_cashapp_close" required>
                  </div>
                </div>
                
                <div class="mb-3">
                  <label class="form-label" for="edit_games_close">Games Total Closing</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="edit_games_close" id="edit_games_close" required>
                  </div>
                </div>
                
                <div class="mb-3">
                  <label class="form-label" for="edit_redeem_close">Redeem Total Closing</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="edit_redeem_close" id="edit_redeem_close" required>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="edit_pending_redeem">Pending Redeem Amount</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="edit_pending_redeem" id="edit_pending_redeem" required>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="editcashoutamount">Cashout Amount</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="editcashoutamount" id="editcashoutamount" required>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="editbonusamount">Bonus Amount</label>
                  <div class="input-group mb-3 bg-light-subtle rounded-3">
                    <span class="input-group-text text-muted" id="basic-addon3">
                       <i class=" bx bx-dollar"></i>
                    </span>
                   <input type="number" class="form-control" name="editbonusamount" id="editbonusamount" >
                  </div>
                </div>
                <input type="hidden" name="uid" value="<?php echo $uid;?>">
                <input type="hidden" name="type" value="<?php echo $type;?>">
                <input type="hidden" name="uname" value="<?php echo $uname;?>">
                <input type="hidden" name="editpg_id" id="editpg_id">

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" name="updated" id="">Update</button>
                </div>
              </form>
              </div>
          </div>
      </div>
  </div>
  <div class="rightbar-overlay"></div>

  <?php include('footer_links.html');?>
    <script type="text/javascript">
      $("#datetime").datetimepicker({
      dateFormat: 'yy-mm-dd',
      timeFormat: 'HH:mm:ss'
    });
    </script>
    <script>
      $(document).ready(function () {
        $(document).on('click','#saveclosingdetails',function(){
          $(this).hide();
        });
      });
    </script>
</body>
</html>