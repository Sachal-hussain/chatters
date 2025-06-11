<?php
	include('config.php');
	require_once('../connect_me.php');

	$database_connection = new Database_connection();
	$connect = $database_connection->connect();

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	    $id = intval($_POST['id']);
	    
	    if ($id > 0) {
	        $sql = "DELETE FROM deposit WHERE id = ?";
	        $stmt = $connect->prepare($sql);
	        $stmt->bind_param("i", $id);
	        
	        if ($stmt->execute()) {
	            echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully']);
	        } else {
	            echo json_encode(['status' => 'error', 'message' => 'Failed to delete record']);
	        }
	        
	        $stmt->close();
	    } else {
	        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
	    }
	}

	$connect->close();



?>