<?php
    require_once('../connect_me.php');
    $database_connection = new Database_connection();
    $connect = $database_connection->connect();

    // Retrieve search criteria from POST request
    $page_name = $_POST['page_name'] ?? '';
    $redeemfor = $_POST['redeemfor'] ?? '';
    $redeemfrom = $_POST['redeemfrom'] ?? '';
    $search_datefrom = $_POST['search_datefrom'] ?? '';
    $search_dateto = $_POST['search_dateto'] ?? '';
    $output='';
    // Prepare the SQL query
    $sql = "SELECT * FROM redeem WHERE status='Paid'"; // Start with 1=1 to easily append conditions

    // Add conditions based on the provided search criteria
    if (!empty($page_name)) {
        $sql .= " AND pg_id = '$page_name'";
    }
    if (!empty($redeemfor)) {
    	$redeemfor = trim($redeemfor);
        $sql .= " AND LOWER(redeemfor) = LOWER('$redeemfor')";
    }
    if (!empty($redeemfrom)) {
    	$redeemfrom = trim($redeemfrom);
        $sql .= " AND LOWER(redeemfrom) = LOWER('$redeemfrom')";
    }
    if (!empty($search_datefrom)) {
        $sql .= " AND record_time >= '$search_datefrom'";
    }
    if (!empty($search_dateto)) {
        $sql .= " AND record_time <= '$search_dateto'";
    }

    // Execute the query
    $result = mysqli_query($connect, $sql);

    // Check if query was successful
    if ($result) {
    	$totalAmount = 0;
	    $totalPaid = 0;
	    $totalRefunded = 0;
	    $totalTip = 0;
	    $totalAddback = 0;
        // Fetch and display results
        while ($row = mysqli_fetch_assoc($result)) {
            // Output your data here, for example:
            $id 			=$row['id'];
            $record_time 	=$row['record_time'];
	        $redeemed_date 	=$row['redeemed_date'];
	        $record_by 		=$row['record_by'];
	        $cust_name 		=$row['cust_name'];
	        $redeem_by 		=$row['redeem_by'];
	        $page_name 		=$row['page_name'];
	        $redeemfor 		=$row['redeemfor'];
	        $redeemfrom 	=$row['redeemfrom'];
	        $gid 			=$row['gid'];
	        $ctid 			=$row['ctid'];
	        $amount 		=$row['amount'];
	        $amt_refund 	=$row['amt_refund'];
	        $amt_paid 		=$row['amt_paid'];
	        $amt_bal 		=$row['amt_bal'];
	        $tip 			=$row['tip'];
	        $addback 		=$row['addback'];
	        $amt_addback 	=$row['amt_addback'];
	        $status 		=$row['status'];
	        $total_tip 		=$tip+$amt_bal;
	        $total_added 	=$addback+$amt_addback;

	        $totalAmount 	+= $row['amount'];
	        $totalPaid 		+= $row['amt_paid'];
	        $totalRefunded 	+= $row['amt_refund'];
	        $totalTip 		+= $total_tip;
	        $totalAddback 	+= $total_added;


	       	$output.='<tr>
	       				<td>'.$id.'</td>
	       				<td>'.$record_time.'</td>
	       				<td>'.$redeemed_date.'</td>
	       				<td>'.$record_by.'</td>
	       				<td>'.$cust_name.'</td>
	       				<td>'.$redeem_by.'</td>
	       				<td>'.$page_name.'</td>
	       				<td>'.$redeemfor.'</td>
	       				<td>'.$redeemfrom.'</td>
	       				<td>'.$gid.'</td>
	       				<td>'.$ctid.'</td>
	       				<td>'.$amount.'</td>
	       				<td>'.$amt_refund.'</td>
	       				<td>'.$amt_paid.'</td>
	       				<td>'.$total_tip.'</td>
	       				<td>'.$total_added.'</td>
	       				<td>'.$status.'</td>
	       				

	       			</tr>

	       	';

        }
        $output .= '<tr>';
	    $output .= '<td>ID</td>'; 
	    $output .= '<td>Created At</td>';
	    $output .= '<td>Updated At</td>'; 
	    $output .= '<td>Agent Name</td>'; 
	    $output .= '<td>Customer Name</td>'; 
	    $output .= '<td>Redeem Paid By</td>'; 
	    $output .= '<td>Page Name</td>'; 
	    $output .= '<td>Redeem For</td>'; 
	    $output .= '<td>Redeem From</td>'; 
	    $output .= '<td>Game ID	</td>';
	    $output .= '<td>Cash Tag</td>';  
	    $output .= '<td>Total Amount: <b>' . $totalAmount . '</b></td>'; 
	    $output .= '<td>Total Refunded: <b>' . $totalRefunded . '</b></td>'; 
	    $output .= '<td>Total Paid: <b>' . $totalPaid . '</b></td>'; 
	    $output .= '<td>Total Tip: <b>' . $totalTip . '</b></td>'; 
	    $output .= '<td>Total AddedBack: <b>' . $totalAddback . '</b></td>'; 
	    $output .= '<td>Status</td>'; 
	    $output .= '</tr>';
        echo $output;
    } else {
        // Handle query error
        echo "Error: " . mysqli_error($connect);
    }

    // Close the database connection
    mysqli_close($connect);
?>
