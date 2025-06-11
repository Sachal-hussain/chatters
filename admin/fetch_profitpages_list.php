
<?php
	include('config.php');
	require_once('../connect_me.php');

	$database_connection = new Database_connection();
	$connect = $database_connection->connect(); 

	// profit report start here
	// if(isset($_POST['clientpage_name']) && $_POST['clientpage_name'] != '') {
	//     $pagename 			= $_POST['clientpage_name'];
	//     $search_datefrom 	= $_POST['search_datefrom']; 
	//     $search_dateto 		= $_POST['search_dateto'];
	//     $html = '';
	//     $data = [];

	//     if ($pagename == 'all') {
	//         $query = "
	//             SELECT
	//                 p.id AS pgid,
	//                 p.pagename AS page_name,
	//                 SUM(scd.cashappopening) AS total_cashappopening,
	//                 SUM(scd.cashappclosing) AS total_cashappclosing,
	//                 SUM(scd.cashout) AS total_cashout,
	//                 SUM(scd.redeemclosing) AS total_redeemclosing,
	//                 SUM(scd.pending_redeem) AS total_pending_redeem,
	//                 (SUM(scd.cashappclosing) - SUM(scd.cashappopening) + SUM(scd.redeemclosing) + SUM(scd.cashout)) AS total_deposit,
	//                 (SUM(scd.cashappclosing) - SUM(scd.cashappopening) - SUM(scd.pending_redeem) + SUM(scd.cashout)) AS total_profit
	//             FROM
	//                 shift_closing_details scd
	//             JOIN
	//                 pages p ON scd.pg_id = p.id
	//             WHERE
	//                 scd.created_at >= ?
	//                 AND scd.created_at <= ?
	//             GROUP BY
	//                 p.pagename";
	        
	//         $stmt = $connect->prepare($query);
	//         if ($stmt === false) {
	//             die('Prepare() failed: ' . htmlspecialchars($connect->error));
	//         }
	//         $stmt->bind_param("ss", $search_datefrom, $search_dateto);
	//     } else {
	//         $query = "
	//             SELECT
	//                 p.id AS pgid,
	//                 p.pagename AS page_name,
	//                 SUM(scd.cashappopening) AS total_cashappopening,
	//                 SUM(scd.cashappclosing) AS total_cashappclosing,
	//                 SUM(scd.cashout) AS total_cashout,
	//                 SUM(scd.redeemclosing) AS total_redeemclosing,
	//                 SUM(scd.pending_redeem) AS total_pending_redeem,
	//                 (SUM(scd.cashappclosing) - SUM(scd.cashappopening) + SUM(scd.redeemclosing) + SUM(scd.cashout)) AS total_deposit,
	//                 (SUM(scd.cashappclosing) - SUM(scd.cashappopening) - SUM(scd.pending_redeem) + SUM(scd.cashout)) AS total_profit
	//             FROM
	//                 shift_closing_details scd
	//             JOIN
	//                 pages p ON scd.pg_id = p.id
	//             WHERE
	//                 scd.pg_id = ?
	//                 AND scd.created_at >= ?
	//                 AND scd.created_at <= ?";
	        
	//         $stmt = $connect->prepare($query);
	//         if ($stmt === false) {
	//             die('Prepare() failed: ' . htmlspecialchars($connect->error));
	//         }
	//         $stmt->bind_param("iss", $pagename, $search_datefrom, $search_dateto);
	//     }

	//     // Execute the query
	//     $stmt->execute();

	//     // Bind result variables
	//     $stmt->bind_result($pgid,$page_name, $total_cashappopening, $total_cashappclosing, $total_cashout, $total_redeemclosing,$total_pending_redeem, $total_deposit,$total_profit);

	//     // Fetch the result
	//     while ($stmt->fetch()) {
	//         // $html .= '<tr>
	//         //             <td>' . htmlspecialchars($page_name) . '</td>
	//         //             <td>' . htmlspecialchars($total_cashappopening) . '</td>
	//         //             <td>' . htmlspecialchars($total_cashappclosing) . '</td>
	//         //             <td>' . htmlspecialchars($total_cashout) . '</td>
	//         //             <td>' . htmlspecialchars($total_redeemclosing) . '</td>
	//         //             <td>' . htmlspecialchars($total_pending_redeem) . '</td>
	//         //             <td>' . htmlspecialchars($total_deposit) . '</td>
	//         //             <td>' . htmlspecialchars($total_profit) . '</td>
	//         //           </tr>';
	//         $data[] = [
	//         	'pageid' => $pgid,
	//             'page_name' => $page_name,
	//             'total_cashappopening' => $total_cashappopening,
	//             'total_cashappclosing' => $total_cashappclosing,
	//             'total_cashout' => $total_cashout,
	//             'total_redeemclosing' => $total_redeemclosing,
	//             'total_pending_redeem' => $total_pending_redeem,
	//             'total_deposit' => $total_deposit,
	//             'total_profit' => $total_profit
	//         ];
	//     }

	//     echo json_encode($data);

	//     // Close the statement and connection
	//     $stmt->close();
	//     $connect->close();
	// }
	if (isset($_POST['clientpage_name']) && !empty($_POST['clientpage_name'])) {
		$pagenames = $_POST['clientpage_name'];
		$search_datefrom = $_POST['search_datefrom'];
		$search_dateto = $_POST['search_dateto'];
		$html = '';
		$data = [];

	 	if (in_array('all', $pagenames)) {
		    $query = "
		      SELECT
		        p.id AS pgid,
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
	  	} 
	  	else 
	  	{
		    $placeholders = implode(',', array_fill(0, count($pagenames), '?'));
		    $types = str_repeat('i', count($pagenames)) . 'ss';
		    $query = "
		      SELECT
		        p.id AS pgid,
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
		        scd.pg_id IN ($placeholders)
		        AND scd.created_at >= ?
		        AND scd.created_at <= ?
		      GROUP BY
		        p.pagename";

		    $stmt = $connect->prepare($query);
		    if ($stmt === false) {
		      die('Prepare() failed: ' . htmlspecialchars($connect->error));
		    }
		    $params = array_merge($pagenames, [$search_datefrom, $search_dateto]);
		    $stmt->bind_param($types, ...$params);
	  	}

		// Execute the query
		$stmt->execute();

	  	// Bind result variables
	  	$stmt->bind_result($pgid, $page_name, $total_cashappopening, $total_cashappclosing, $total_cashout, $total_redeemclosing, $total_pending_redeem, $total_deposit, $total_profit);

	  	// Fetch the result
	  	while ($stmt->fetch()) {
		    $data[] = [
		      'pageid' => $pgid,
		      'page_name' => $page_name,
		      'total_cashappopening' => $total_cashappopening,
		      'total_cashappclosing' => $total_cashappclosing,
		      'total_cashout' => $total_cashout,
		      'total_redeemclosing' => $total_redeemclosing,
		      'total_pending_redeem' => $total_pending_redeem,
		      'total_deposit' => $total_deposit,
		      'total_profit' => $total_profit
		    ];
	  	}

		echo json_encode($data);

		  // Close the statement and connection
		$stmt->close();
		$connect->close();
	}


	// deposit history start here
	if(isset($_POST['depositpage_name']) && $_POST['depositpage_name'] != ''){
		$data = [];
		$pg_names = explode(',', $_POST['depositpage_name']);
		$deposit_datefrom = $_POST['deposit_datefrom'];
		$deposit_dateto = $_POST['deposit_dateto'];

		if (in_array('all', $pg_names)) {
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
		    $placeholders = implode(',', array_fill(0, count($pg_names), '?'));
		    $types = str_repeat('i', count($pg_names)) . 'ss';
		    $params = array_merge($pg_names, [$deposit_datefrom, $deposit_dateto]);

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
		            d.pg_id IN ($placeholders)
		            AND d.created_at >= ?
		            AND d.created_at <= ?
		        GROUP BY
		            p.pagename";

		    $stmt = $connect->prepare($query);
		    if ($stmt === false) {
		        die('Prepare() failed: ' . htmlspecialchars($connect->error));
		    }
		    
		    $stmt->bind_param($types, ...$params);
		}

		// Execute the query
		$stmt->execute();

		// Bind result variables
		$stmt->bind_result($pg_name, $total_amount, $total_bonus);

		// Fetch the result
		while ($stmt->fetch()) {
			$percentage_bonus = ($total_amount > 0) ? number_format(($total_bonus / $total_amount) * 100, 2) : '0.00';
		    $data[] = [
		        'page_name' => htmlspecialchars($pg_name),
		        'total_amount' => htmlspecialchars($total_amount),
		        'total_bonus' => htmlspecialchars($total_bonus),
		        'percentage_bonus' => htmlspecialchars($percentage_bonus)
		    ];
		}

		if (empty($data)) {
		    $data[] = [
		        'page_name' => 'No results',
		        'total_amount' => 0,
		        'total_bonus' => 0
		    ];
		}

		echo json_encode($data);

		// Close the statement and connection
		$stmt->close();
		$connect->close();
	}


	// each page deposit history start here
	if(isset($_POST['historypage_name']) && $_POST['historypage_name']!=''){
		// echo "<pre>";
		// print_r($_POST);
		$html='';
		$data = [];
		$i=0;
		$pg_name 			= $_POST['historypage_name'];
		$deposit_datefrom 	= $_POST['history_datefrom'];
		$deposit_dateto 	= $_POST['history_dateto'];

		if ($pg_name == 'all') {
	        $query = "
	            SELECT pagename, 
		            deposit.id, 
		            pg_id, 
		            gm_id, 
		            amount, 
		            bonus,
		            tag, 
		            uname as user, 
		            created_at
		        FROM deposit
		        JOIN pages 
		        ON pages.id = deposit.pg_id
		        WHERE
	                deposit.created_at >= ?
	                AND deposit.created_at <= ?";
	        
	        $stmt = $connect->prepare($query);
	        if ($stmt === false) {
	            die('Prepare() failed: ' . htmlspecialchars($connect->error));
	        }
	        $stmt->bind_param("ss", $deposit_datefrom, $deposit_dateto);
	    } else {
	        $query = "
	            SELECT pagename, 
	            deposit.id, 
	            pg_id, 
	            gm_id, 
	            amount, 
	            bonus, 
	            tag,
	            uname as user, 
	            created_at
		        FROM deposit
		        JOIN pages ON pages.id = deposit.pg_id
	            WHERE
	                deposit.pg_id = ?
	                AND deposit.created_at >= ?
	                AND deposit.created_at <= ?";
	        
	        $stmt = $connect->prepare($query);
	        if ($stmt === false) {
	            die('Prepare() failed: ' . htmlspecialchars($connect->error));
	        }
	        $stmt->bind_param("iss", $pg_name, $deposit_datefrom, $deposit_dateto);
	    }

	    // Execute the query
	    $stmt->execute();

	    // Bind result variables
	    $stmt->bind_result($pagename,$id,$pg_id,$gm_id,$amount,$bonus,$tag,$user,$created_at );

	    // Fetch the result
	    while ($stmt->fetch()) {
	    	$i++;
	    	$data[] = [
	    		'pg_id'			=> htmlspecialchars($pg_id),
	    		'depositid' 	=> htmlspecialchars($id),
	            'page_name' 	=> htmlspecialchars($pagename),
	            'gm_id' 		=> htmlspecialchars($gm_id),
	            'amount' 		=> htmlspecialchars($amount),
	            'bonus' 		=> htmlspecialchars($bonus),
	            'tag' 			=> htmlspecialchars($tag),
	            'user' 			=> htmlspecialchars($user),
	            'created_at' 	=> htmlspecialchars($created_at)
	        ];
	       
	    }

	    if (empty($html)) {
	        $html = '<tr><td colspan="6">No results found for the given date range and page ID.</td></tr>';
	    }

	    echo json_encode($data);

	    // Close the statement and connection
	    $stmt->close();
	    $connect->close();
			
	}

	// get details by pages start here
	if(isset($_POST['singlepgname']) && $_POST['singlepgname'] != '') {
		

	    $pgid 				= $_POST['singlepgname'];
	    $search_datefrom 	= $_POST['search_datefrom']; 
	    $search_dateto 		= $_POST['search_dateto'];
	    $html = '';
	    $data = [];


        $query = "
        	SELECT 
		        pages.*, shift_closing_details.*,
		        (shift_closing_details.cashappclosing - shift_closing_details.cashappopening + shift_closing_details.redeemclosing + shift_closing_details.cashout) AS total_deposit,
		        (shift_closing_details.cashappclosing - shift_closing_details.cashappopening - shift_closing_details.pending_redeem + shift_closing_details.cashout) AS total_profit
		    FROM 
		        pages
		    JOIN 
		        shift_closing_details ON pages.id = shift_closing_details.pg_id 
		    WHERE 
		        pages.status = 'active'
		    AND 
		        shift_closing_details.pg_id = ?
		    AND 
		        shift_closing_details.created_at >= ?
		    AND 
		        shift_closing_details.created_at <= ?
		    ORDER BY 
		        shift_closing_details.id DESC
        ";
        
        $stmt = $connect->prepare($query);
        if ($stmt === false) {
            die('Prepare() failed: ' . htmlspecialchars($connect->error));
        }
        $stmt->bind_param("iss", $pgid, $search_datefrom, $search_dateto);
	   

	    // Execute the query
	    $stmt->execute();

	  $result = $stmt->get_result();

	    // Fetch the result
	    while ($row = $result->fetch_assoc()) {
		    // Calculate the total deposit and total profit
		    $pgid=$row['pg_id'];
            $pagename           =$row['pagename'];
            $cashappopening    =$row['cashappopening'];
            $cashappclosing    =$row['cashappclosing'];
            $cashappdifference  =$row['cashappdifference'];
            $gameopening        =$row['gameopening'];
            $gameclosing        =$row['gameclosing'];
            $gamedifference     =abs($row['gamedifference']);
            $redeemclosing         =$row['redeemclosing'];
            $pending_redeem     =$row['pending_redeem'];
            $redeem_for_other          =$row['redeem_for_other'];
            $cashout            =$row['cashout'];
            $bonus              =$row['bonus'];
            $shift              =$row['shift'];
            $name               =$row['uname'];
            $created_at         =$row['created_at'];
            // $unknowndiff        =$gamedifference-$cashappdifference-$bonus;
            $cashappclosingtotal       = $cashappclosing+$redeem_for_other;
            $cashapp_diff  = abs($cashappclosingtotal-$cashappopening);
            $values = [$gamedifference, $cashapp_diff, $bonus, $cashout, $pending_redeem];
            rsort($values);
            $unknowndiff = array_shift($values); // Initialize unknowndiff with the first value

          	foreach ($values as $value) {
              if ($unknowndiff > $value) {
                  $unknowndiff -= $value;
              } else {
                  $unknowndiff = $value - $unknowndiff;
              }
          	}
            $total_deposit      =$row['total_deposit'];
            $total_profit       =$row['total_profit'];
		   
		    $data[] = [
		        'pageid' => $pgid,
		        'page_name' => $pagename,
		        'cashappopening' => $cashappopening,
		        'cashappclosing' => $cashappclosing,
		        'cashappdifference' => $cashapp_diff,
		        'gameopening' => $gameopening,
		        'gameclosing' => $gameclosing,
		        'gamedifference' => $gamedifference,
		        'redeemclosing' => $redeemclosing,
		        'pending_redeem' => $pending_redeem,
		        'cashout' => $cashout,
		        'bonus' => $bonus,
		        'shift' => $shift,
		        'uname' => $name,
		        'created_at' => $created_at,
		        'unknowndiff' => $unknowndiff,
		        'total_deposit' => $total_deposit, // Add total_deposit
		        'total_profit' => $total_profit, // Add total_profit
		    ];
		}

	    echo json_encode($data);

	    // Close the statement and connection
	    $stmt->close();
	    $connect->close();
	}
?>
