<?php
	include('config.php');
	require_once('../connect_me.php');
    $database_connection = new Database_connection();
    $connect = $database_connection->connect(); 
	
	if(isset($_POST['page_id']) && $_POST['page_id']!='' && $_POST['action']=='fetch_gameslist'){
		$page_id=$_POST['page_id'];

		$html='';
    $i='0';  
    // $query = mysqli_query($connect, "SELECT 
    //       gi.id,
    //       gi.pg_id,
    //       gi.g_name,
    //       gi.uid,
    //       gi.uname,
    //       gi.created_at,
    //       SUM(srd.store_recharge) AS total_recharge,
    //       SUM(srd.store_redeem) AS total_redeem
    //   FROM 
    //       gameinfo gi
    //   LEFT JOIN 
    //       storerechargedetails srd ON gi.id = srd.gameid
    //   WHERE 
    //       gi.pg_id = '$page_id' 
    //       AND gi.status = 0
    //   GROUP BY 
    //       gi.id, gi.pg_id, gi.g_name, gi.uid, gi.uname, gi.created_at
      
    // 	");
    $query = mysqli_query($connect, "SELECT 
        gi.id,
        gi.pg_id,
        gi.g_name,
        gi.uid,
        gi.uname,
        gi.created_at,
        SUM(srd.store_recharge) AS total_recharge,
        SUM(srd.store_redeem) AS total_redeem
    FROM 
        gameinfo gi
    LEFT JOIN 
        storerechargedetails srd ON gi.id = srd.gameid
    WHERE 
        gi.pg_id = '$page_id' 
        AND gi.status = 0
    GROUP BY 
        gi.id, gi.pg_id, gi.g_name, gi.uid, gi.uname, gi.created_at
    ORDER BY 
        FIELD(gi.g_name, 
            'Orion Star', 
            'Firekirin', 
            'Riversweep', 
            'Pandamaster', 
            'Golden Treasure', 
            'Vblink', 
            'Egame', 
            'Ultra Panda', 
            'Acebook', 
            'Juwa', 
            'Game Vault', 
            'Fire Dragon', 
            'Fire Phoenix', 
            'Blue Dragon', 
            'Payday Sweeps',
            'Quake',
            'Lucky Penny',
            'Golden Dragon'), 
        gi.g_name;
      
      ");
     // $total_redeem    = $row['total_redeem'];
    // <td>'.$total_redeem.'</td>
    if(mysqli_num_rows($query) > 0){
      while($row=mysqli_fetch_array($query)){
      	$i++;
      	$id 		         = $row['id'];
      	$pg_id 		       = $row['pg_id'];
      	$g_name 	       = $row['g_name'];
      	$uname 		       = $row['uname'];
      	$created_at      = $row['created_at'];
        $total_recharge  = $row['total_recharge'];
       

         $html.= '<tr>
         			<td>'.$i.'</td>
         			<td>'.$g_name.'</td>
              <td>'.$total_recharge.'</td>
              
         			<td><button class="btn btn-danger waves-effect waves-light  m-1 add_gamesdeposits" data-id="'.$id.'" data-pg_id="'.$pg_id.'" data-gamename="'.$g_name.'" style="cursor:pointer;">Recharge</button>
              <button class="btn btn-info waves-effect waves-light  m-1 rdm_gamesname" data-rdmgid="'.$id.'" data-rdmpid="'.$pg_id.'" data-rdmgamename="'.$g_name.'" style="cursor:pointer;">Redeem</button>
              <button class="btn btn-success waves-effect waves-light  m-1 delete_gamesname" data-gid="'.$id.'" data-pid="'.$pg_id.'" data-gamename="'.$g_name.'" style="cursor:pointer;">Delete Game</button>
              <button class="btn btn-primary waves-effect waves-light  m-1 btn-transaction" data-gid="'.$id.'" data-pid="'.$pg_id.'" data-gamename="'.$g_name.'" style="cursor:pointer;">Transaction</button></td>


         </tr>';
      }
      echo $html;
    }
	}

  if(isset($_POST['storepage_id']) && $_POST['storepage_id']!=''){
    $gamelist='';
    $page_id=$_POST['storepage_id'];
    $query = mysqli_query($connect, "SELECT id,pg_id,g_name,uid,uname,created_at 
      FROM gameinfo 
      WHERE pg_id='$page_id'
      ORDER BY g_name ASC");
    if(mysqli_num_rows($query) > 0){
      while($row=mysqli_fetch_array($query)){
        
        $id     = $row['id'];
        $pg_id    = $row['pg_id'];
        $g_name   = $row['g_name'];
        $uname    = $row['uname'];
        $created_at = $row['created_at'];

        $gamelist.= '<option value="'.$id.'">'.$g_name.'</option>';
         
      }
      echo $gamelist;
    }
  }

  // Check if the form is submitted
  if (isset($_POST['storepage_name']) && $_POST['storepage_name'] != '') {
    $searchHtml='';
    $i='0';
    $types = "";
    $total_recharge = 0;
    $total_redeem = 0;
    // Get and sanitize input data
    $page_name = mysqli_real_escape_string($connect, $_POST['storepage_name']);
    $storegameid = mysqli_real_escape_string($connect, $_POST['storegameid']);
    $search_datefrom = mysqli_real_escape_string($connect, $_POST['search_datefrom']);
    $search_dateto = mysqli_real_escape_string($connect, $_POST['search_dateto']);

    // Start building the query
    $query = "SELECT storerechargedetails.*, pages.*, gameinfo.*,storerechargedetails.created_at as recharged_date 
              FROM storerechargedetails
              JOIN pages ON pages.id = storerechargedetails.pg_id
              JOIN gameinfo ON gameinfo.id = storerechargedetails.gameid
              WHERE 1=1";
    $params = [];

    if (!empty($search_datefrom)) {
      $search_datefrom .= " 00:00:00";
    }
    if (!empty($search_dateto)) {
      $search_dateto .= " 23:59:59";
    } 
    // Add filters to the query
    if (!empty($page_name)) {
      $query .= " AND storerechargedetails.pg_id = ?";
      $params[] = $page_name;
      $types .= "i";
    }
    if (!empty($storegameid)) {
      $query .= " AND storerechargedetails.gameid = ?";
      $params[] = $storegameid;
      $types .= "i";
    }
    if (!empty($search_datefrom)) {
      $query .= " AND storerechargedetails.created_at >= ?";
      $params[] = $search_datefrom;
      $types .= "s";
    }
    if (!empty($search_dateto)) {
      $query .= " AND storerechargedetails.created_at <= ?";
      $params[] = $search_dateto;
      $types .= "s";
    }

    // Prepare the statement
    $stmt = $connect->prepare($query);

    // Bind parameters
    if (!empty($params)) {
      $stmt->bind_param($types, ...$params);
    }

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch and display the results
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $i++;
        $total_recharge += $row["store_recharge"];
        $total_redeem += $row["store_redeem"];
        $searchHtml.='<tr>
                      <td>'.$i.'</td>
                      <td>'.$row["recharged_date"].'</td>
                      <td>'.$row["g_name"].'</td>
                      <td>'.$row["store_gid"].'</td>
                      <td>'.$row["store_recharge"].'</td>
                      <td>'.$row["store_redeem"].'</td>
                      <td>'.$row["pagename"].'</td>
                      <td>'.$row["clientname"].'</td>
        </tr>';
          
      }
      $searchHtml .= '<tr>
                        <td><strong>Total</strong></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><strong>' . $total_recharge . '</strong></td>
                        <td><strong>' . $total_redeem . '</strong></td>
                        <td>-</td>
                        <td>-</td>
                      </tr>
      ';

      echo $searchHtml;

      
    } else {
        echo "<p>No Results Found.</p> ";
    }

    // Close the statement
    $stmt->close();
  } 

  // get games transaction histoy
  if (isset($_POST['game_id']) && $_POST['game_id'] != '' && isset($_POST['date_from']) && isset($_POST['date_to'])) {
    $game_id = $_POST['game_id'];
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];

    $query = "SELECT storerechargedetails.*, pages.*, gameinfo.*, storerechargedetails.created_at as recharged_date, storerechargedetails.id as store_id
              FROM storerechargedetails
              JOIN pages ON pages.id = storerechargedetails.pg_id
              JOIN gameinfo ON gameinfo.id = storerechargedetails.gameid
              WHERE storerechargedetails.gameid = ? 
              AND storerechargedetails.created_at BETWEEN ? AND ? 
              AND storerechargedetails.status=0";

    $stmt = $connect->prepare($query);
    $stmt->bind_param('iss', $game_id, $date_from, $date_to);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
    $connect->close();

    echo json_encode($data);
  }

  if(isset($_POST['transactionid']) && $_POST['transactionid'] != ''){
    $id = $_POST['transactionid'];

    $query = "UPDATE storerechargedetails SET status=1 WHERE id=?";

    $stmt = $connect->prepare($query);
    if ($stmt) {
      $stmt->bind_param('i', $id);
      if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
          $response = 'Status updated successfully.';
        } 
      $stmt->close();
      } 
    }
    $connect->close();
    echo $response;
    exit;
  }
?>