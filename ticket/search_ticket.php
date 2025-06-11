<?php
	require_once('../connect_me.php');
	$database_connection = new Database_connection();
	$connect = $database_connection->connect();

	// Get form data
	$search_status = $_POST['search_status'] ?? null;
	$search_priority = $_POST['search_priority'] ?? null;
	$search_subject = $_POST['search_subject'] ?? null;
	$search_ticketnumber = $_POST['search_ticketnumber'] ?? null;
	$search_datefrom = $_POST['search_datefrom'] ?? null;
	$search_dateto = $_POST['search_dateto'] ?? null;
	$output='';
	// Initialize WHERE clause
	$whereClause = [];

	// Add conditions based on form inputs
	if ($search_status !== '0') {
	    $whereClause[] = "tkt_info.status = '$search_status'";
	}
	if ($search_priority !== '0') {
	    $whereClause[] = "tkt_info.priority = '$search_priority'";
	}
	if (!empty($search_subject)) {
    	// Convert search subject to lowercase and remove extra spaces
	    $search_subject = trim(strtolower($search_subject));
	    $whereClause[] = "LOWER(tkt_info.subject) LIKE '%$search_subject%'";
	}

	if (!empty($search_ticketnumber)) {
	    // Remove spaces from the ticket number
	    $search_ticketnumber = str_replace(' ', '', $search_ticketnumber);
	    $whereClause[] = "tkt_info.tkt_id = '$search_ticketnumber'";
	}
	// if (!empty($search_subject)) {
	//     $whereClause[] = "tkt_info.subject LIKE '%$search_subject%'";
	// }
	// if (!empty($search_ticketnumber)) {
	//     $whereClause[] = "tkt_info.tkt_id = '$search_ticketnumber'";
	// }
	// if (!empty($search_datefrom)) {
	//     $whereClause[] = "tkt_info.created_at >= '$search_datefrom'";
	// }
	// if (!empty($search_dateto)) {
	//     $whereClause[] = "tkt_info.created_at <= '$search_dateto'";
	// }
	if (!empty($search_datefrom)) {
	    $search_datefrom = date('Y-m-d H:i:s', strtotime($search_datefrom)); // Convert to 'Y-m-d H:i:s' format
	    $whereClause[] = "tkt_info.created_at >= '$search_datefrom'";
	}
	if (!empty($search_dateto)) {
	    $search_dateto = date('Y-m-d H:i:s', strtotime($search_dateto)); // Convert to 'Y-m-d H:i:s' format
	    // Increment by 1 day to include the end date
	    $search_dateto = date('Y-m-d H:i:s', strtotime($search_dateto . ' +1 day'));
	    $whereClause[] = "tkt_info.created_at <= '$search_dateto'";
	}

	// Construct the WHERE clause
	$where = '';
	if (!empty($whereClause)) {
	    $where = 'WHERE ' . implode(' AND ', $whereClause);
	}

	// Construct the SQL query
	$query = "SELECT tkt_info.*, user.fullname, tkt_assign.tkt_id AS ticket_id, tkt_assign.assigned_to AS assigned_user
	          FROM tkt_info 
	          LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	          LEFT JOIN user ON tkt_info.created_by = user.id
	          $where
	          GROUP BY tkt_info.tkt_id";

	// Execute the query


	$result = mysqli_query($connect, $query);

	// Output the search results
	if ($result) {
	    // Loop through the results and display them as desired
	    while ($row = mysqli_fetch_assoc($result)) {
	        $tkt_id 	=$row['tkt_id'];
	        $subject 	=$row['subject'];
	        $priority 	=$row['priority'];
	        $created_by =$row['fullname'];
	        $department =$row['departments'];
	        $deadline 	=$row['deadline'];
	        $status 	=$row['status'];

	       	$output.='<tr>
	       				<td><a href="search_edit_ticket.php?tkt_id='.$tkt_id.'">'.$subject.'</a></td>
	       				<td>'.$priority.'</td>
	       				<td>'.$tkt_id.'</td>
	       				<td>'.$created_by.'</td>
	       				<td>'.$department.'</td>
	       				<td>'.$deadline.'</td>
	       				<td>'.$status.'</td>
	       			</tr>

	       	';
	    }
	    echo $output;
	} else {
	    // Handle error
	    echo "Error executing the query: " . mysqli_error($connect);
	}

	// Close the connection
	mysqli_close($connect);
?>
