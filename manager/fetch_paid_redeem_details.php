<?php
    // fetch_paid_redeem_details.php
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
    $reports = $_SESSION["user_data"]["reports"];

    if(!isset($_SESSION['user_data']))
    {
        header('location:index.php');
    } 

    require_once('../connect_me.php');
    $database_connection = new Database_connection();
    $mysqli = $database_connection->connect();

  
    if ($_POST['action'] == 'fetchpaidredeem') {
        $page_id = $_POST['page_id'];
        $limit = $_POST['length'];
        $start = $_POST['start'];
        $searchQuery = $_POST['searchQuery'];
        $startDateTime = isset($_POST['startDateTime']) ? $_POST['startDateTime'] : '';
        $endDateTime = isset($_POST['endDateTime']) ? $_POST['endDateTime'] : '';
        $status = $_POST['status'];

        // Base SQL query to fetch records
        $sql = "SELECT id, redeemed_date, record_by, page_name, gid, amount, ref_page,payment_method, status FROM redeem WHERE pg_id = '$page_id' AND status='$status' AND del='0'";

        // Applying date-time filter if provided
        if (!empty($startDateTime) && !empty($endDateTime)) {
            $sql .= " AND redeemed_date BETWEEN '$startDateTime' AND '$endDateTime'";
        }

        // Applying search query if provided
        if (!empty($searchQuery)) {
            $sql .= " AND (id LIKE '%$searchQuery%' OR redeemed_date LIKE '%$searchQuery%' OR record_by LIKE '%$searchQuery%' OR page_name LIKE '%$searchQuery%' OR gid LIKE '%$searchQuery%' OR amount LIKE '%$searchQuery%' OR status LIKE '%$searchQuery%')";
        }

        // Ordering and Limiting
        $sql .= " ORDER BY redeemed_date DESC";
        if ($limit != -1) {
            $sql .= " LIMIT $start, $limit";
        }

        // Execute the main SQL query to fetch data
        $result = $mysqli->query($sql);

        // Counting total records without filters
        $totalSql = "SELECT COUNT(*) as total_count FROM redeem WHERE pg_id = '$page_id' AND status='$status' AND del='0'";
        $totalResult = $mysqli->query($totalSql);
        $totalRecords = $totalResult->fetch_assoc()['total_count'];

        // Counting filtered records with applied filters
        $filteredRecordsSql = "SELECT COUNT(*) as filtered_count FROM redeem WHERE pg_id = '$page_id' AND status='$status' AND del='0'";
        if (!empty($startDateTime) && !empty($endDateTime)) {
            $filteredRecordsSql .= " AND redeemed_date BETWEEN '$startDateTime' AND '$endDateTime'";
        }
        $filteredResult = $mysqli->query($filteredRecordsSql);
        $filteredRecords = $filteredResult->fetch_assoc()['filtered_count'];

         // Compute the sum of 'amount' based on filters
        $sumSql = "SELECT SUM(amount) as total_amount FROM redeem WHERE pg_id = '$page_id' AND status='$status' AND del='0'";
        if (!empty($startDateTime) && !empty($endDateTime)) {
            $sumSql .= " AND redeemed_date BETWEEN '$startDateTime' AND '$endDateTime'";
        }
        $sumResult = $mysqli->query($sumSql);
        $totalAmount = $sumResult->fetch_assoc()['total_amount'] ?? 0;

        // Constructing the response
        if ($result) {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $output = [
                "draw" => intval($_POST['draw']),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $filteredRecords,
                "data" => $data
            ];

            echo json_encode($output);
        } else {
            echo "Error executing SQL query: " . $mysqli->error;
        }

        $mysqli->close();
    }


?>
