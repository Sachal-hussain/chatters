<?php
    require_once('../connect_me.php');

    $database_connection = new Database_connection();
    $connect = $database_connection->connect();

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
    $report = $_SESSION["user_data"]["reports"];
    $department = $_SESSION["user_data"]["department"];
    $shift = $_SESSION["user_data"]["shift"];
    $pg_id = $_SESSION["user_data"]["pg_id"];
    if (!is_array($pg_id)) {
        $userPageIDs = array($pg_id);
    } else {
        $userPageIDs = $pg_id;
    }

    $pageIDsString = implode(',', $userPageIDs);

    $draw = $_POST['draw'];
    $search = $_POST['search']['value'];
    $orderColumn = $_POST['order'][0]['column'];
    $orderDir = $_POST['order'][0]['dir'];

    $columns = array('id', 'pagename', 'gm_id', 'amount', 'bonus', 'uname', 'created_at');
    $orderBy = $columns[$orderColumn];

    // Get the last 10 records first
    $lastTenSql = "SELECT 
                    pages.pagename, 
                    deposit.id, 
                    deposit.pg_id, 
                    deposit.gm_id, 
                    deposit.amount, 
                    deposit.bonus, 
                    deposit.uname, 
                    deposit.created_at
                FROM 
                    deposit
                JOIN 
                    pages ON pages.id = deposit.pg_id
                WHERE 
                    deposit.pg_id IN ($pageIDsString)
                ORDER BY deposit.created_at DESC 
                LIMIT 10";

    // Execute query to get last 10 records
    $lastTenResult = $connect->query($lastTenSql);
    $data = array();
    if ($lastTenResult->num_rows > 0) {
        while ($row = $lastTenResult->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Filter the last 10 records based on the search term
    if (!empty($search)) {
        $data = array_filter($data, function($row) use ($search) {
            return (stripos($row['pagename'], $search) !== false ||
                    stripos($row['gm_id'], $search) !== false ||
                    stripos($row['amount'], $search) !== false ||
                    stripos($row['bonus'], $search) !== false ||
                    stripos($row['uname'], $search) !== false ||
                    stripos($row['created_at'], $search) !== false);
        });
    }

    $filteredDataCount = count($data);

    // Apply sorting to the filtered data
    if ($filteredDataCount > 1) {
        usort($data, function($a, $b) use ($orderBy, $orderDir) {
            if ($orderDir == 'asc') {
                return strcmp($a[$orderBy], $b[$orderBy]);
            } else {
                return strcmp($b[$orderBy], $a[$orderBy]);
            }
        });
    }

    $response = array(
        "draw" => intval($draw),
        "recordsTotal" => 10, // Total number of records in the last 10 records
        "recordsFiltered" => $filteredDataCount, // Total number of filtered records in the last 10 records
        "data" => array_values($data) // Make sure the data is re-indexed
    );

    $connect->close();

    echo json_encode($response);
?>
