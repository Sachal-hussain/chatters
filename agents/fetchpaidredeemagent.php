<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);


    // Include the database connection script
    require_once('../connect_me.php');

    // Create a database connection instance
    $database_connection = new Database_connection();
    $connect = $database_connection->connect();
    // Check if a session is already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Retrieve session data
$uid    = $_SESSION["user_data"]["id"];
$pg_id = $_SESSION["user_data"]["pg_id"];

if (!is_array($pg_id)) {
    $userPageIDs = array($pg_id);
} else {
    $userPageIDs = $pg_id;
}

$pageIDsString = implode(',', $userPageIDs);

$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
$searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
$searchValue = mysqli_real_escape_string($connect, $searchValue);

// Base query to fetch data with redeem_amount calculation
$query = "SELECT * FROM (SELECT *, 
                        (tip + amt_bal) as combined_tip, 
                        (amt_addback + addback) as combined_addback, 
                        (amount - (tip + amt_bal) - (amt_addback + addback)) AS redeem_amount 
                    FROM redeem 
                    WHERE status='Paid') AS subquery 
            WHERE pg_id IN ($pageIDsString)";

// Define columns to search
$searchColumns = [
    "id", 
    "inform_status",
    "record_time",
    "redeemed_date",
    "record_by", 
    "cust_name", 
    "redeem_by", 
    "page_name", 
    "gid", 
    "ctid", 
    "comment", 
    "paidbyclient", 
    "clientname", 
    "amount", 
    "combined_tip", 
    "combined_addback", 
    "(amount - combined_tip - combined_addback)", 
    "status",
    "informed_at"
];

// Apply search conditions if a search value is provided
if (!empty($searchValue)) {
    $searchConditions = [];
    foreach ($searchColumns as $column) {
        $searchConditions[] = (strpos($column, '(') !== false) ? 
            "$column LIKE '%$searchValue%'" : 
            "LOWER($column) LIKE '%" . strtolower($searchValue) . "%'";
    }
    $query .= " AND (" . implode(' OR ', $searchConditions) . ")";
}

// Sorting
$columnIndex = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
$columnDir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'desc';

if (isset($searchColumns[$columnIndex])) {
    $orderColumn = $searchColumns[$columnIndex];
    $query .= " ORDER BY $orderColumn $columnDir";
} else {
    $query .= " ORDER BY id DESC"; // Default sorting if column index is invalid
}

// Log the generated SQL query for debugging
error_log("Generated SQL Query: " . $query);

// Fetch total number of records without any filters
$totalRecordsQuery = mysqli_query($connect, "SELECT COUNT(*) as total FROM redeem WHERE status='Paid' AND pg_id IN ($pageIDsString)");
if (!$totalRecordsQuery) {
    die("Error in SQL: " . mysqli_error($connect));
}

$totalRecordsData = mysqli_fetch_assoc($totalRecordsQuery);
$totalRecords = $totalRecordsData['total'];

// Fetch total number of records with applied filters
$filteredRecordsQuery = mysqli_query($connect, $query);
if (!$filteredRecordsQuery) {
    die("Error in SQL: " . mysqli_error($connect));
}

$totalFiltered = mysqli_num_rows($filteredRecordsQuery);

// Apply pagination to the query
$query .= " LIMIT $start, $length";

$result = [];
$resultSet = mysqli_query($connect, $query);
if (!$resultSet) {
    die("Error in SQL: " . mysqli_error($connect));
}

while ($row = mysqli_fetch_assoc($resultSet)) {
    $result[] = $row;
}

// Prepare the response array
$response = [
    "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalFiltered,
    "data" => $result
];

// Output the JSON-encoded response
echo json_encode($response);
?>
