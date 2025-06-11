<?php
include('config.php');
require_once('../connect_me.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$database_connection = new Database_connection();
$connect = $database_connection->connect();

// Retrieve session data
$uid    = $_SESSION["user_data"]["id"];
$pg_id = $_SESSION["user_data"]["pg_id"];

if (!is_array($pg_id)) {
    $userPageIDs = array($pg_id);
} else {
    $userPageIDs = $pg_id;
}

$pageIDsString = implode(',', $userPageIDs);

// Retrieve DataTables parameters
$draw = $_POST['draw'] ?? 0;
$start = $_POST['start'] ?? 0;
$length = $_POST['length'] ?? 10;
$search = $_POST['search']['value'] ?? '';
$orderColumn = $_POST['order'][0]['column'] ?? 0;
$orderDir = $_POST['order'][0]['dir'] ?? 'desc';

// Map the order column index to database column names
$columns = array('unprocessid', 'pagename', 'customer_name', 'gameid', 'status', 'issue', 'utype', 'uname', 'created_at', 'updated_at');
$orderBy = $columns[$orderColumn] ?? 'unprocessid';

// Construct the base SQL query
$sql = "SELECT pages.id as page_id, pages.pagename, pending_redeem.id as unprocessid, pending_redeem.pageid, pending_redeem.customer_name, pending_redeem.gameid, pending_redeem.status, pending_redeem.issue, pending_redeem.utype, pending_redeem.uname, pending_redeem.created_at, pending_redeem.updated_at 
        FROM pending_redeem 
        JOIN pages ON pending_redeem.pageid = pages.id
        WHERE pending_redeem.status = 'Pending' 
        AND pending_redeem.pageid IN ($pageIDsString)"; // This `WHERE 1=1` acts as a placeholder for adding filters later

// Prepare statement for counting total records without filtering
$stmt = $connect->prepare("SELECT COUNT(*) FROM pending_redeem JOIN pages ON pending_redeem.pageid = pages.id WHERE pending_redeem.status = 'Pending' AND pending_redeem.pageid IN ($pageIDsString)");
$stmt->execute();
$stmt->bind_result($totalData);
$stmt->fetch();
$stmt->close();

// Add search filter if a search term is provided
if (!empty($search)) {
    $sql .= " AND (LOWER(pagename) LIKE ? 
              OR LOWER(customer_name) LIKE ? 
              OR LOWER(gameid) LIKE ? 
              OR LOWER(utype) LIKE ? 
              OR LOWER(uname) LIKE ? 
              OR LOWER(created_at) LIKE ?)";
    $searchParam = "%" . strtolower($search) . "%";
}

// Add order by clause
$sql .= " ORDER BY $orderBy $orderDir";

// Add pagination clause
$sql .= " LIMIT ?, ?";

// Prepare the statement for the main query
$stmt = $connect->prepare($sql);

// Check if prepare() failed and log the error
if (!$stmt) {
    die("Prepare failed: (" . $connect->errno . ") " . $connect->error . "\nSQL: " . $sql);
}

if (!empty($search)) {
    $stmt->bind_param('ssssssii', $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $start, $length);
} else {
    $stmt->bind_param('ii', $start, $length);
}

$stmt->execute();
$result = $stmt->get_result();

$data = array();
while ($row = $result->fetch_assoc()) {
   
    $class = '';
    
   
     $class = 'bg-danger-subtle text-center text-white';
       
   

    // Add the action and class to the row data
    
    $row['class'] = $class;
    $data[] = $row;
}

// Prepare the response in the format DataTables expects
$response = array(
    "draw" => intval($draw),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalData), // Placeholder, will be updated below
    "data" => $data
);

// Prepare statement for counting filtered records
$filterCountSql = "SELECT COUNT(*) FROM pending_redeem JOIN pages ON pending_redeem.pageid = pages.id WHERE pending_redeem.status = 'Pending' AND pending_redeem.pageid IN ($pageIDsString)";

if (!empty($search)) {
    $filterCountSql .= " AND (LOWER(pagename) LIKE ? 
                            OR LOWER(customer_name) LIKE ? 
                            OR LOWER(gameid) LIKE ? 
                            OR LOWER(utype) LIKE ? 
                            OR LOWER(uname) LIKE ? 
                            OR LOWER(created_at) LIKE ?)";
}

$filterCountStmt = $connect->prepare($filterCountSql);

if (!$filterCountStmt) {
    die("Prepare failed: (" . $connect->errno . ") " . $connect->error . "\nSQL: " . $filterCountSql);
}

if (!empty($search)) {
    $filterCountStmt->bind_param('ssssss', $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
}

$filterCountStmt->execute();
$filterCountStmt->bind_result($filteredData);
$filterCountStmt->fetch();
$filterCountStmt->close();

// Update the response with the actual filtered count
$response['recordsFiltered'] = intval($filteredData);

$stmt->close();
$connect->close();

// Set header for JSON response and ensure no extra output
header('Content-Type: application/json');
echo json_encode($response);
?>
