<?php
	include('config.php');
	require_once('../connect_me.php');

	$database_connection = new Database_connection();
	$connect = $database_connection->connect();

	// Retrieve DataTables parameters
	$draw = $_POST['draw'];
	$start = $_POST['start'];
	$length = $_POST['length'];
	$search = $_POST['search']['value'];
	$orderColumn = $_POST['order'][0]['column'];
	$orderDir = $_POST['order'][0]['dir'];

	// Map the order column index to database column names
	$columns = array('id', 'pagename', 'gm_id', 'amount', 'bonus', 'tag', 'uname', 'created_at');
	$orderBy = $columns[$orderColumn];

	// Construct the base SQL query
	$sql = "SELECT pagename, deposit.id, pg_id, gm_id, amount, bonus, tag, uname, created_at
	        FROM deposit
	        JOIN pages ON pages.id = deposit.pg_id";

	// Add search filter if a search term is provided
	if (!empty($search)) {
	    $sql .= " WHERE LOWER(pagename) LIKE '%$search%' 
              OR LOWER(gm_id) LIKE '%$search%' 
              OR LOWER(amount) LIKE '%$search%' 
              OR LOWER(bonus) LIKE '%$search%' 
              OR LOWER(tag) LIKE '%$search%' 
              OR LOWER(uname) LIKE '%$search%' 
              OR LOWER(created_at) LIKE '%$search%'";
	}

	// Add order by clause
	$sql .= " ORDER BY $orderBy $orderDir";

	// Get the total number of records without filtering
	$totalResult = $connect->query($sql);
	$totalData = $totalResult->num_rows;

	// Add pagination clause
	$sql .= " LIMIT $start, $length";

	// Execute the query
	$result = $connect->query($sql);

	$data = array();
	if ($result->num_rows > 0) {
	    while ($row = $result->fetch_assoc()) {
	        $data[] = $row;
	    }
	}

	// Prepare the response in the format DataTables expects
	$response = array(
	    "draw" => intval($draw),
	    "recordsTotal" => intval($totalData),
	    "recordsFiltered" => intval($totalData),
	    "data" => $data
	);

	$connect->close();

	// Return data as JSON
	echo json_encode($response);
?>
