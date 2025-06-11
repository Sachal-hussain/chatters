<?php 
	session_start();

	$uid = $_SESSION["user_data"]["id"];
	$fname = $_SESSION["user_data"]["fname"];
	$uname = $_SESSION["user_data"]["uname"];
	$email = $_SESSION["user_data"]["email"];
	$contact = $_SESSION["user_data"]["contact"];
	$type = $_SESSION["user_data"]["type"];
	$avtar = $_SESSION["user_data"]["avtar"];
	$online = $_SESSION["user_data"]["online"];
	$token = $_SESSION["user_data"]["token"];

	if(!isset($_SESSION['user_data']))
	{
		header('location:../index.php');
	}
	if ($type == 'CSR' || $type == 'Q&A' || $type == 'Manager') {
      
        echo '<script>alert("Access denied. You do not have permission to view this page.");window.location.href = "../privatechat.php";</script>';
        exit();
    }  

	require('database/Tickets.php');

	$object = new Tickets();

	$total_tickets	=$object->getTotalTickets();
	$total_urgent	=$object->getTotalUrgent();
	$total_high		=$object->getTotalHigh();
	$total_medium	=$object->getTotalMedium();
	$total_routine	=$object->getTotalRoutine();
	$total_closed	=$object->getTotalClosed();
	$total_pending	=$object->getTotalPending();
	$total_cancelled	=$object->getTotalCancelled();








?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>Tickets | SHJ International</title>
	<?php require("links.html"); ?>
</head>
<body>
	<div class="layout-wrapper">
		<?php 
			require('header.php');
			require('leftsidebar.php');
			require('ticket_content.php');
		?>
	</div>
	<?php require('rightsidebar.php');?>
	<div class="rightbar-overlay"></div>
	<?php require("footer.html"); ?>
</body>
</html>