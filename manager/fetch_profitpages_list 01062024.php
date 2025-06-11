
<?php
	include('config.php');
	require_once('../connect_me.php');

	$database_connection = new Database_connection();
	$connect = $database_connection->connect(); 

	if(isset($_POST['clientpage_name']) && $_POST['clientpage_name'] != '') {
	    $pagename 			= $_POST['clientpage_name'];
	    $search_datefrom 	= $_POST['search_datefrom']; 
	    $search_dateto 		= $_POST['search_dateto'];
	    $html = '';

	    if ($pagename == 'all') {
	        $query = "
	            SELECT
	                p.pagename AS page_name,
	                SUM(scd.cashappopening) AS total_cashappopening,
	                SUM(scd.cashappclosing) AS total_cashappclosing,
	                SUM(scd.cashout) AS total_cashout,
	                SUM(scd.redeemclosing) AS total_redeemclosing,
	                SUM(scd.pending_redeem) AS total_pending_redeem,
	                (SUM(scd.cashappclosing) - SUM(scd.cashappopening) + SUM(scd.redeemclosing) + SUM(scd.cashout)) AS total_deposit,
	                (SUM(scd.cashappclosing) - SUM(scd.cashappopening) - SUM(scd.pending_redeem) + SUM(scd.cashout)) AS total_profit
	            FROM
	                shift_closing_details scd
	            JOIN
	                pages p ON scd.pg_id = p.id
	            WHERE
	                scd.created_at >= ?
	                AND scd.created_at <= ?
	            GROUP BY
	                p.pagename";
	        
	        $stmt = $connect->prepare($query);
	        if ($stmt === false) {
	            die('Prepare() failed: ' . htmlspecialchars($connect->error));
	        }
	        $stmt->bind_param("ss", $search_datefrom, $search_dateto);
	    } else {
	        $query = "
	            SELECT
	                p.pagename AS page_name,
	                SUM(scd.cashappopening) AS total_cashappopening,
	                SUM(scd.cashappclosing) AS total_cashappclosing,
	                SUM(scd.cashout) AS total_cashout,
	                SUM(scd.redeemclosing) AS total_redeemclosing,
	                SUM(scd.pending_redeem) AS total_pending_redeem,
	                (SUM(scd.cashappclosing) - SUM(scd.cashappopening) + SUM(scd.redeemclosing) + SUM(scd.cashout)) AS total_deposit,
	                (SUM(scd.cashappclosing) - SUM(scd.cashappopening) - SUM(scd.pending_redeem) + SUM(scd.cashout)) AS total_profit
	            FROM
	                shift_closing_details scd
	            JOIN
	                pages p ON scd.pg_id = p.id
	            WHERE
	                scd.pg_id = ?
	                AND scd.created_at >= ?
	                AND scd.created_at <= ?";
	        
	        $stmt = $connect->prepare($query);
	        if ($stmt === false) {
	            die('Prepare() failed: ' . htmlspecialchars($connect->error));
	        }
	        $stmt->bind_param("iss", $pagename, $search_datefrom, $search_dateto);
	    }

	    // Execute the query
	    $stmt->execute();

	    // Bind result variables
	    $stmt->bind_result($page_name, $total_cashappopening, $total_cashappclosing, $total_cashout, $total_redeemclosing,$total_pending_redeem, $total_deposit,$total_profit);

	    // Fetch the result
	    while ($stmt->fetch()) {
	        $html .= '<tr>
	                    <td>' . htmlspecialchars($page_name) . '</td>
	                    <td>' . htmlspecialchars($total_cashappopening) . '</td>
	                    <td>' . htmlspecialchars($total_cashappclosing) . '</td>
	                    <td>' . htmlspecialchars($total_cashout) . '</td>
	                    <td>' . htmlspecialchars($total_redeemclosing) . '</td>
	                    <td>' . htmlspecialchars($total_pending_redeem) . '</td>
	                    <td>' . htmlspecialchars($total_deposit) . '</td>
	                    <td>' . htmlspecialchars($total_profit) . '</td>
	                  </tr>';
	    }

	    if (empty($html)) {
	        $html = '<tr><td colspan="6">No results found for the given date range and page ID.</td></tr>';
	    }

	    echo $html;

	    // Close the statement and connection
	    $stmt->close();
	    $connect->close();
	}


	if(isset($_POST['depositpage_name']) && $_POST['depositpage_name']!=''){
		$html='';
		$i=0;
		$pg_name 			= $_POST['depositpage_name'];
		$deposit_datefrom 	= $_POST['deposit_datefrom'];
		$deposit_dateto 	= $_POST['deposit_dateto'];

		if ($pg_name == 'all') {
	        $query = "
	            SELECT
	                p.pagename AS page_name,
	                SUM(d.amount) AS total_amount,
	                SUM(d.bonus) AS total_bonus
	                
	            FROM
	                deposit d
	            JOIN
	                pages p ON d.pg_id = p.id
	            WHERE
	                d.created_at >= ?
	                AND d.created_at <= ?
	            GROUP BY
	                p.pagename";
	        
	        $stmt = $connect->prepare($query);
	        if ($stmt === false) {
	            die('Prepare() failed: ' . htmlspecialchars($connect->error));
	        }
	        $stmt->bind_param("ss", $deposit_datefrom, $deposit_dateto);
	    } else {
	        $query = "
	            SELECT
	                p.pagename AS page_name,
	                SUM(d.amount) AS total_amount,
	                SUM(d.bonus) AS total_bonus
	                
	            FROM
	                deposit d
	            JOIN
	                pages p ON d.pg_id = p.id
	            WHERE
	                d.pg_id = ?
	                AND d.created_at >= ?
	                AND d.created_at <= ?";
	        
	        $stmt = $connect->prepare($query);
	        if ($stmt === false) {
	            die('Prepare() failed: ' . htmlspecialchars($connect->error));
	        }
	        $stmt->bind_param("iss", $pg_name, $deposit_datefrom, $deposit_dateto);
	    }

	    // Execute the query
	    $stmt->execute();

	    // Bind result variables
	    $stmt->bind_result($pg_name,$total_amount,$total_bonus );

	    // Fetch the result
	    while ($stmt->fetch()) {
	    	$i++;
	        $html .= '<tr>
	        			<td>' . htmlspecialchars($i) . '</td>
	                    <td>' . htmlspecialchars($pg_name) . '</td>
	                    <td>' . htmlspecialchars($total_amount) . '</td>
	                    <td>' . htmlspecialchars($total_bonus) . '</td>
	                    <td>' . htmlspecialchars($deposit_datefrom. ' "to" ' .$deposit_dateto) . '</td>
	                  </tr>';
	    }

	    if (empty($html)) {
	        $html = '<tr><td colspan="6">No results found for the given date range and page ID.</td></tr>';
	    }

	    echo $html;

	    // Close the statement and connection
	    $stmt->close();
	    $connect->close();
			
	}
?>
