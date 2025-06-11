<?php
require_once('connect_me.php');

$database_connection = new Database_connection();
$connect = $database_connection->connect();

// Get current time
$current_time = new DateTime();

// Fetch users with active status
$sql = "SELECT id, last_login FROM user WHERE status = 'Active' AND online='Login' AND type <> 'Webmaster' AND type <>'Manager'";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    	// echo "<pre>";
    	// print_r($row);
    	// exit;
        $user_id = $row['id'];
        $last_login = new DateTime($row['last_login']); 

        // Add 10 hours to the last login time
        $last_login->modify('+10 hours');

        // Check if the last login time plus 10 hours is less than the current time
        if ($last_login <= $current_time) {
            // Update the user status to inactive and set online to 'Logout'
            $update_sql = "UPDATE user SET status = 'Deactive', online = 'Logout' WHERE id = ? AND type <> 'Webmaster'";
            $stmt = $connect->prepare($update_sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
        }
    }
}

echo json_encode(["message" => "User statuses updated successfully"]);
$connect->close();
?>
