<?php
	include('config.php');
	require_once('../connect_me.php');
    $database_connection = new Database_connection();
    $connect = $database_connection->connect(); 



	if (isset($_POST['gameid']) && !empty($_POST['gameid'])) {
	    // Get POST data and sanitize it
	    $storegameid  = mysqli_real_escape_string($connect, $_POST['storegame_id']);
	    $game_deposits = mysqli_real_escape_string($connect, $_POST['game_deposits']);
	    $uid = mysqli_real_escape_string($connect, $_POST['uid']);
	    $pageid = mysqli_real_escape_string($connect, $_POST['pageid']);
	    $gameid = mysqli_real_escape_string($connect, $_POST['gameid']);
	    $created_at = date('Y-m-d H:i:s');

	    // Insert into storerechargedetails using a prepared statement
	    $query = $connect->prepare("INSERT INTO storerechargedetails (store_gid, store_recharge, pg_id, gameid, uid, created_at) VALUES (?, ?, ?, ?, ?, ?)");
	    $query->bind_param("sdisis", $storegameid, $game_deposits, $pageid, $gameid, $uid, $created_at);

	    if ($query->execute()) {
	        // Select current game_closing value
	        $sql_select = "SELECT game_closing FROM shift_closing WHERE pg_id = ?";
	        $stmt_select = $connect->prepare($sql_select);
	        $stmt_select->bind_param("i", $pageid);
	        $stmt_select->execute();
	        $result_select = $stmt_select->get_result();

	        if ($result_select->num_rows > 0) {
	            $row = $result_select->fetch_assoc();
	            $currentGamescore = $row['game_closing'];

	            // Calculate the new game_closing value
	            $newGamescore = (float)$game_deposits; // Ensure this matches the correct logic for new game score
	            $updatedGamescore = $currentGamescore + $newGamescore;

	            // Update the game_closing value
	            $sql_update = "UPDATE shift_closing SET game_closing = ? WHERE pg_id = ?";
	            $stmt_update = $connect->prepare($sql_update);
	            $stmt_update->bind_param("di", $updatedGamescore, $pageid);
	            $stmt_update->execute();
	        }

	        // Return success response
	        $response = [
	            'status' => 'success',
	            'page_id' => $pageid,
	            'message' => 'Recharge Successfully!'
	        ];
	    } else {
	        // Return error response for insertion failure
	        $response = [
	            'status' => 'error',
	            'message' => 'Failed to recharge. Please try again.'
	        ];
	    }

	    // Close the statement
	    $query->close();

	    // Echo the JSON response and exit
	    echo json_encode($response);
	    exit;
	} 

	if (isset($_POST['rdmgameid']) && !empty($_POST['rdmgameid'])) {
	    // Get POST data and sanitize it
	    $storegameid  = mysqli_real_escape_string($connect, $_POST['rdmstoregame_id']);
	    $game_deposits = mysqli_real_escape_string($connect, $_POST['rdmgame_deposits']);
	    $uid = mysqli_real_escape_string($connect, $_POST['uid']);
	    $pageid = mysqli_real_escape_string($connect, $_POST['rdmpageid']);
	    $gameid = mysqli_real_escape_string($connect, $_POST['rdmgameid']);
	    $created_at = date('Y-m-d H:i:s');

	    // Insert into storerechargedetails using a prepared statement
	    $query = $connect->prepare("INSERT INTO storerechargedetails (store_gid, store_recharge, pg_id, gameid, uid, created_at) VALUES (?, ?, ?, ?, ?, ?)");
	    $query->bind_param("sdisis", $storegameid, $game_deposits, $pageid, $gameid, $uid, $created_at);

	    if ($query->execute()) {
	        // Select current game_closing value
	        $sql_select = "SELECT game_closing FROM shift_closing WHERE pg_id = ?";
	        $stmt_select = $connect->prepare($sql_select);
	        $stmt_select->bind_param("i", $pageid);
	        $stmt_select->execute();
	        $result_select = $stmt_select->get_result();

	        if ($result_select->num_rows > 0) {
	            $row = $result_select->fetch_assoc();
	            $currentGamescore = $row['game_closing'];

	            // Calculate the new game_closing value
	            $newGamescore = (float)$game_deposits; // Ensure this matches the correct logic for new game score
	            $updatedGamescore = $currentGamescore + $newGamescore;

	            // Update the game_closing value
	            $sql_update = "UPDATE shift_closing SET game_closing = ? WHERE pg_id = ?";
	            $stmt_update = $connect->prepare($sql_update);
	            $stmt_update->bind_param("di", $updatedGamescore, $pageid);
	            $stmt_update->execute();
	        }

	        // Return success response
	        $response = [
	            'status' => 'success',
	            'page_id' => $pageid,
	            'message' => 'Redeemed Successfully!'
	        ];
	    } else {
	        // Return error response for insertion failure
	        $response = [
	            'status' => 'error',
	            'message' => 'Failed to recharge. Please try again.'
	        ];
	    }

	    // Close the statement
	    $query->close();

	    // Echo the JSON response and exit
	    echo json_encode($response);
	    exit;
	} 

	if (isset($_POST['action']) && $_POST['action']=='delete_game' && $_POST['pid']!='') {
		
		$pgid 	= $_POST['pid'];
		$gid 	= $_POST['gid'];

		$sql = "UPDATE gameinfo SET status = 1 WHERE pg_id = ? AND id = ?";
	    $stmt = $connect->prepare($sql);

	    if ($stmt) {
	        // Bind parameters
	        $stmt->bind_param("ii", $pgid, $gid);

	        // Execute the statement
	        if ($stmt->execute()) {
	            $response = [
	                'status' => 'success',
	                'page_id' => $pgid,
	                'message' => 'Deleted Successfully!'
	            ];
	            echo json_encode($response);
	        } else {
	            $response = [
	                'status' => 'error',
	                'message' => 'Error updating record: ' . $stmt->error
	            ];
	            echo json_encode($response);
	        }

	        // Close the statement
	        $stmt->close();
	    } else {
	        $response = [
	            'status' => 'error',
	            'message' => 'Error preparing statement: ' . $connect->error
	        ];
	        echo json_encode($response);
	    }

	    // Close the connection
	    $connect->close();

	}


?>