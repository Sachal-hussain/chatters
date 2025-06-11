<?php
	require_once(dirname(__DIR__) . '/connect_me.php'); // Ensure the path to connect_me.php is correct
	$database_connection = new Database_connection();
	$connect = $database_connection->connect();

	use PHPMailer\PHPMailer\PHPMailer;

	header('Content-Type: application/json');

	$response = [];

	// Get the current time
	$currentTime = date('Y-m-d H:i:s');
	$i=0;
	// Query to fetch unpaid redeem requests where record_time is more than 12 hours ago
	$query = "
	    SELECT * FROM redeem
	    WHERE status='Pending'
	    AND del='0'
	    AND approval='0'
	    AND mailed=0
	    AND TIMESTAMPDIFF(HOUR, record_time, '$currentTime') > 12
	    ORDER BY page_name ASC
	";

	$result = $connect->query($query);

	if ($result->num_rows > 0) {
	    // Create an HTML table to include in the email
	    $htmlTable = '<table class="table table-bordered" style="border-collapse: collapse; width: 100%;">';
	    $htmlTable .= '<thead style="background-color: #f8f9fa;">
	                    <tr>
	                        <th scope="col" style="border: 1px solid #dee2e6;">#</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Date</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Page Name</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Agent Name</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Customer Name</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Game ID</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Cash Tag</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Amount</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Tip</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Add Back</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Added Back (R)</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Refunded (R)</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Paid (R)</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Tip (R)</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Remaining Redeem Amount</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Comments</th>
	                        <th scope="col" style="border: 1px solid #dee2e6;">Manager Comments</th>
	                    </tr>
	                  </thead>';
	    $htmlTable .= '<tbody>';
	    while ($row = $result->fetch_assoc()) {
	    	// echo "<pre>";
	    	// print_r($row);
	    	$i++;
	    	$redeem_amount=$row['amount']-$row['amt_paid']-$row['amt_refund']-$row['amt_addback']-$row['amt_bal']-$row['tip']-$row['addback'];
	        $htmlTable .= '<tr>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $i . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['record_time'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['page_name'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['record_by'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['cust_name'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['gid'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['ctid'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['amount'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['tip'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['addback'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['amt_addback'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['amt_refund'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['amt_paid'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['amt_bal'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $redeem_amount . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['comment'] . '</td>';
	        $htmlTable .= '<td style="border: 1px solid #dee2e6;">' . $row['reply'] . '</td>';
	        $htmlTable .= '</tr>';
	    }

	    $htmlTable .= '</tbody>';
	    $htmlTable .= '</table>';

	    // Initialize PHPMailer
	    require_once "PHPMailer/PHPMailer.php";
	    require_once "PHPMailer/SMTP.php";
	    require_once "PHPMailer/Exception.php";

	    // Prepare email settings
	    $mail = new PHPMailer();

	    // SMTP Settings
	    $mail->isSMTP();
	    $mail->Host = "mail.itschatters.com"; // Adjust to your SMTP server
	    $mail->SMTPAuth = true;
	    $mail->Username = "webmaster@itschatters.com"; // Your SMTP username
	    $mail->Password = 'Webmaster@itschatter'; // Your SMTP password
	    $mail->Port = 465; // Port for SSL
	    $mail->SMTPSecure = "ssl"; // Secure SSL/TLS settings

	    // Email Settings
	    $mail->isHTML(true);
	    $mail->setFrom('webmaster@itschatters.com'); // Set the sender email

	    $mail->addAddress('naeem.shjint@gmail.com'); // Replace with recipient's email
	    // $mail->addCC("mainredeem@gmail.com");
	    // $mail->addCC("naeem.shjint@gmail.com");
	    // $mail->addCC("morningmanagement@shjinternational.com");
	    // $mail->addCC("eveningmanagement@shjinternational.com");
	    // $mail->addCC("nightmanagement@shjinternational.com");

	    $mail->Subject = 'Unpaid Redeem Details';
	    $mail->Body = '<h3>Updated List of Unpaid Redeem Details (older than 12 hours):</h3>' . $htmlTable;

	    // Send the email and update the database
	    if ($mail->send()) {
	        $response['status'] = 'success';
	        $response['message'] = 'Email has been sent successfully.';
	    } else {
	        $response['status'] = 'error';
	        $response['message'] = 'Mailer Error: ' . $mail->ErrorInfo;
	    }
	} else {
	    $response['status'] = 'error';
	    $response['message'] = 'No unpaid redeem requests older than 12 hours found.';
	}

	$connect->close();

	// Send the JSON response
	echo json_encode($response);
?>
