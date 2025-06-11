<?php

	require_once('../connect_me.php');

    // Create a database connection instance
    $database_connection = new Database_connection();
    $connect = $database_connection->connect();


	if (isset($_POST['tabId'])) {
	   
	    $tabId 	= $_POST['tabId'];
	    $uid 	= $_POST['uid'];
	    $utype 	= $_POST['utype'];

	    // Logic to fetch data based on the tab ID
	    switch ($tabId) {
	        case '#open-tickets':
	            // Fetch data for open tickets
	            $data = fetchDataForOpenTickets($utype,$uid,$connect);
	            break;
	        case '#my-tickets':
	            // Fetch data for user's tickets
	            $data = fetchDataForUserTickets($uid,$connect);
	            break;
	        case '#closed-tickets':
	            // Fetch data for user's tickets
	            $data = fetchDataForClosedTickets($utype,$uid,$connect);
	            break;
	        case '#awaiting-for-verification':
	            // Fetch data for open tickets
	            $data = fetchDataForVerificationTickets($utype,$uid,$connect);
	            break;
	        case '#awaiting-for-acknowledgement':
	            // Fetch data for user's tickets
	            $data = fetchDataForAwaitingTickets($utype,$uid,$connect);
	            break;
	        case '#all-acknowledgement':
	            // Fetch data for user's tickets
	            $data = fetchDataForAcknowledgementTickets($utype,$uid,$connect);
	            break;        
	        // Add cases for other tab IDs as needed
	        default:
	            // Default case if tab ID doesn't match any known tab
	            $data = array(); // Empty data array
	    }

	    // Send JSON response with fetched data
	    header('Content-Type: application/json');
	    echo json_encode($data);
	} else {
	    // If tabId is not set in the POST request
	    echo 'Error: tabId parameter is missing.';
	}

	// Function to fetch data for open tickets
	function fetchDataForOpenTickets($utype,$uid,$connect) {
	   // Extracting parameters from $_POST
	    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
	    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
	    $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';

	    // Base query to fetch data
	    

	    if ($utype == 'Webmaster') {
	        $query = "SELECT tkt_info.*, user.fullname, tkt_assign.tkt_id as ticket_id, tkt_assign.assigned_to as assigned_user
	                    FROM tkt_info 
	                    LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	                    LEFT JOIN user ON tkt_info.created_by = user.id
	                    WHERE tkt_info.status<>'Closed'
	                    GROUP BY tkt_info.tkt_id";
	    }
	    else{
	    	$query = "SELECT tkt_info.*,user.fullname, tkt_assign.tkt_id as ticket_id,tkt_assign.assigned_to as assigned_user
	            FROM tkt_info 
	            LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	            LEFT JOIN user ON tkt_info.created_by = user.id
	            WHERE tkt_info.created_by ='$uid' AND tkt_info.status<>'Closed'
	            GROUP BY tkt_info.tkt_id";
	    }        

	    // Define columns to search
	    $searchColumns = [
	        "id", 
	        "subject",
	        "priority",
	        "tkt_id", 
	        "fullname", 
	        "departments", 
	        "deadline", 
	        "status"
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

	    // Fetch total number of records without any filters
	    $totalRecordsQuery = mysqli_query($connect, "SELECT COUNT(*) as total FROM ($query) as subQuery");
	    if (!$totalRecordsQuery) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }
	    $totalRecordsData = mysqli_fetch_assoc($totalRecordsQuery);
	    $totalRecords = $totalRecordsData['total'];

	    // Fetch total number of records with applied filters
	    $filteredRecordsQuery = mysqli_query($connect, "$query");
	    if (!$filteredRecordsQuery) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }
	    $totalFiltered = mysqli_num_rows($filteredRecordsQuery);

	    // Apply pagination and ordering to the base query
	    $query .= " ORDER BY tkt_info.id DESC LIMIT $start, $length";

	    
	    // Fetch filtered and paginated records
	    $resultSet = mysqli_query($connect, $query);
	    if (!$resultSet) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }

	    // Fetch all rows from the result set
	    $result = mysqli_fetch_all($resultSet, MYSQLI_ASSOC);

	    // Prepare the response array
	    $response = [
	        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
	        "recordsTotal" => $totalRecords,
	        "recordsFiltered" => $totalFiltered,
	        "data" => $result
	    ];

	    // Output the JSON-encoded response
	    return array($response);
	}

	function fetchDataForUserTickets($uid,$connect) {
	    // Extracting parameters from $_POST
	    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
	    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
	    $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';

	    // Base query to fetch data
	    $query = "SELECT tkt_info.*,user.fullname, tkt_assign.tkt_id as ticket_id,tkt_assign.assigned_to as assigned_user
	            FROM tkt_info 
	            LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	            LEFT JOIN user ON tkt_info.created_by = user.id
	            WHERE tkt_info.created_by ='$uid' AND tkt_info.status <>'Closed'
	            GROUP BY tkt_info.tkt_id";

	    // Define columns to search
	    $searchColumns = [
	        "id", 
	        "subject",
	        "priority",
	        "tkt_id", 
	        "fullname", 
	        "departments", 
	        "deadline", 
	        "status"
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

	    // Fetch total number of records without any filters
	    $totalRecordsQuery = mysqli_query($connect, "SELECT COUNT(*) as total FROM ($query) as subQuery");
	    if (!$totalRecordsQuery) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }
	    $totalRecordsData = mysqli_fetch_assoc($totalRecordsQuery);
	    $totalRecords = $totalRecordsData['total'];

	    // Fetch total number of records with applied filters
	    $filteredRecordsQuery = mysqli_query($connect, "$query");
	    if (!$filteredRecordsQuery) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }
	    $totalFiltered = mysqli_num_rows($filteredRecordsQuery);

	    // Apply pagination and ordering to the base query
	    $query .= " ORDER BY tkt_info.id DESC LIMIT $start, $length";

	    // Fetch filtered and paginated records
	    $resultSet = mysqli_query($connect, $query);
	    if (!$resultSet) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }

	    // Fetch all rows from the result set
	    $result = mysqli_fetch_all($resultSet, MYSQLI_ASSOC);

	    // Prepare the response array
	    $response = [
	        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
	        "recordsTotal" => $totalRecords,
	        "recordsFiltered" => $totalFiltered,
	        "data" => $result
	    ];

	    // Output the JSON-encoded response
	    return array($response);
	}

	function fetchDataForClosedTickets($utype, $uid, $connect){
		// Extracting parameters from $_POST
	    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
	    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
	    $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';

	    // Base query to fetch data
	    $query = "SELECT tkt_info.*,user.fullname, tkt_assign.tkt_id as ticket_id,tkt_assign.assigned_to as assigned_user
	            FROM tkt_info 
	            LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	            LEFT JOIN user ON tkt_info.created_by = user.id
	            WHERE tkt_info.created_by ='$uid' AND tkt_info.status='Closed'
	            GROUP BY tkt_info.tkt_id";

	    if ($utype == 'Webmaster') {
	        $query = "SELECT tkt_info.*, user.fullname, tkt_assign.tkt_id as ticket_id, tkt_assign.assigned_to as assigned_user
	                    FROM tkt_info 
	                    LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	                    LEFT JOIN user ON tkt_info.created_by = user.id
	                    WHERE tkt_info.status='Closed'
	                    GROUP BY tkt_info.tkt_id";
	    }        

	    // Define columns to search
	    $searchColumns = [
	        "id", 
	        "subject",
	        "priority",
	        "tkt_id", 
	        "fullname", 
	        "departments", 
	        "deadline", 
	        "status"
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

	    // Fetch total number of records without any filters
	    $totalRecordsQuery = mysqli_query($connect, "SELECT COUNT(*) as total FROM ($query) as subQuery");
	    if (!$totalRecordsQuery) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }
	    $totalRecordsData = mysqli_fetch_assoc($totalRecordsQuery);
	    $totalRecords = $totalRecordsData['total'];

	    // Fetch total number of records with applied filters
	    $filteredRecordsQuery = mysqli_query($connect, "$query");
	    if (!$filteredRecordsQuery) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }
	    $totalFiltered = mysqli_num_rows($filteredRecordsQuery);

	    // Apply pagination and ordering to the base query
	    $query .= " ORDER BY tkt_info.id DESC LIMIT $start, $length";

	    // Fetch filtered and paginated records
	    $resultSet = mysqli_query($connect, $query);
	    if (!$resultSet) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }

	    // Fetch all rows from the result set
	    $result = mysqli_fetch_all($resultSet, MYSQLI_ASSOC);

	    // Prepare the response array
	    $response = [
	        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
	        "recordsTotal" => $totalRecords,
	        "recordsFiltered" => $totalFiltered,
	        "data" => $result
	    ];

	    // Output the JSON-encoded response
	    return array($response);
	}

	function fetchDataForVerificationTickets($utype,$uid,$connect){
		// Extracting parameters from $_POST
	    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
	    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
	    $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';

	    // Base query to fetch data
	    $query = "SELECT tkt_info.*,user.fullname, tkt_assign.tkt_id as ticket_id,tkt_assign.assigned_to as assigned_user
	            FROM tkt_info 
	            LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	            LEFT JOIN user ON tkt_info.created_by = user.id
	            WHERE tkt_assign.assigned_to ='$uid' AND tkt_info.status='Awaiting Verification'
	            GROUP BY tkt_info.tkt_id";

	    if ($utype == 'Webmaster') {
	        $query = "SELECT tkt_info.*, user.fullname, tkt_assign.tkt_id as ticket_id, tkt_assign.assigned_to as assigned_user
	                    FROM tkt_info 
	                    LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	                    LEFT JOIN user ON tkt_info.created_by = user.id
	                    WHERE tkt_info.status='Awaiting Verification'
	                    GROUP BY tkt_info.tkt_id";
	    }        

	    // Define columns to search
	    $searchColumns = [
	        "id", 
	        "subject",
	        "priority",
	        "tkt_id", 
	        "fullname", 
	        "departments", 
	        "deadline", 
	        "status"
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

	    // Fetch total number of records without any filters
	    $totalRecordsQuery = mysqli_query($connect, "SELECT COUNT(*) as total FROM ($query) as subQuery");
	    if (!$totalRecordsQuery) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }
	    $totalRecordsData = mysqli_fetch_assoc($totalRecordsQuery);
	    $totalRecords = $totalRecordsData['total'];

	    // Fetch total number of records with applied filters
	    $filteredRecordsQuery = mysqli_query($connect, "$query");
	    if (!$filteredRecordsQuery) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }
	    $totalFiltered = mysqli_num_rows($filteredRecordsQuery);

	    // Apply pagination and ordering to the base query
	    $query .= " ORDER BY tkt_info.id DESC LIMIT $start, $length";

	    // Fetch filtered and paginated records
	    $resultSet = mysqli_query($connect, $query);
	    if (!$resultSet) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }

	    // Fetch all rows from the result set
	    $result = mysqli_fetch_all($resultSet, MYSQLI_ASSOC);

	    // Prepare the response array
	    $response = [
	        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
	        "recordsTotal" => $totalRecords,
	        "recordsFiltered" => $totalFiltered,
	        "data" => $result
	    ];

	    // Output the JSON-encoded response
	    return array($response);
	}

	function fetchDataForAwaitingTickets($utype,$uid,$connect){
		// Extracting parameters from $_POST
	    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
	    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
	    $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';

	    // Base query to fetch data
	    // $query = "SELECT tkt_info.*,user.fullname, tkt_assign.tkt_id as ticket_id,tkt_assign.assigned_to as assigned_user
	    //         FROM tkt_info 
	    //         LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	    //         LEFT JOIN user ON tkt_info.created_by = user.id
	    //         WHERE tkt_assign.assigned_to ='$uid' AND tkt_info.status='Awaiting Acknowledgement'
	    //         GROUP BY tkt_info.tkt_id";
	    $query = "SELECT tkt_info.*, user.fullname, tkt_assign.tkt_id as ticket_id, tkt_assign.assigned_to as assigned_user
            FROM tkt_info 
            LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
            LEFT JOIN user ON tkt_info.created_by = user.id
            WHERE ((tkt_info.created_by = '$uid' AND tkt_info.status = 'Open') OR (tkt_assign.assigned_to = '$uid' AND tkt_info.status = 'Awaiting Acknowledgement'))
            OR (tkt_info.created_by = '$uid' AND tkt_info.status = 'Awaiting Acknowledgement')
            GROUP BY tkt_info.tkt_id";


	    if ($utype == 'Webmaster') {
	        $query = "SELECT tkt_info.*, user.fullname, tkt_assign.tkt_id as ticket_id, tkt_assign.assigned_to as assigned_user
	                    FROM tkt_info 
	                    LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	                    LEFT JOIN user ON tkt_info.created_by = user.id
	                    WHERE tkt_info.status='Awaiting Acknowledgement'
	                    GROUP BY tkt_info.tkt_id";
	    }        

	    // Define columns to search
	    $searchColumns = [
	        "id", 
	        "subject",
	        "priority",
	        "tkt_id", 
	        "fullname", 
	        "departments", 
	        "deadline", 
	        "status"
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

	    // Fetch total number of records without any filters
	    $totalRecordsQuery = mysqli_query($connect, "SELECT COUNT(*) as total FROM ($query) as subQuery");
	    if (!$totalRecordsQuery) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }
	    $totalRecordsData = mysqli_fetch_assoc($totalRecordsQuery);
	    $totalRecords = $totalRecordsData['total'];

	    // Fetch total number of records with applied filters
	    $filteredRecordsQuery = mysqli_query($connect, "$query");
	    if (!$filteredRecordsQuery) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }
	    $totalFiltered = mysqli_num_rows($filteredRecordsQuery);

	    // Apply pagination and ordering to the base query
	    $query .= " ORDER BY tkt_info.id DESC LIMIT $start, $length";

	    // Fetch filtered and paginated records
	    $resultSet = mysqli_query($connect, $query);
	    if (!$resultSet) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }

	    // Fetch all rows from the result set
	    $result = mysqli_fetch_all($resultSet, MYSQLI_ASSOC);

	    // Prepare the response array
	    $response = [
	        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
	        "recordsTotal" => $totalRecords,
	        "recordsFiltered" => $totalFiltered,
	        "data" => $result
	    ];

	    // Output the JSON-encoded response
	    return array($response);
	}

	function fetchDataForAcknowledgementTickets($utype, $uid, $connect) {
	    // Extracting parameters from $_POST
	    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
	    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
	    $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';

	    // Base query to fetch data
	    $query = "SELECT tkt_info.*, 
				    user.fullname, 
				    tkt_assign.tkt_id as ticket_id, 
				    tkt_assign.assigned_to as assigned_user,
				    tkt_assign.subscribers
	                FROM tkt_info 
	                LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	                LEFT JOIN user ON tkt_info.created_by = user.id
	              	WHERE (tkt_assign.assigned_to = '$uid' OR FIND_IN_SET('$uid', tkt_assign.subscribers) > 0)
	                AND tkt_info.status <>'Closed' 
	                AND tkt_info.status <>'Awaiting Verification' 
	                AND tkt_info.status <>'Awaiting Acknowledgement'
	                GROUP BY tkt_info.tkt_id";

	    // If the user type is 'Webmaster', show all tickets regardless of the assigned user
	    if ($utype == 'Webmaster') {
	        $query = "SELECT tkt_info.*, user.fullname, tkt_assign.tkt_id as ticket_id, tkt_assign.assigned_to as assigned_user
	                    FROM tkt_info 
	                    LEFT JOIN tkt_assign ON tkt_info.tkt_id = tkt_assign.tkt_id
	                    LEFT JOIN user ON tkt_info.created_by = user.id
	                    WHERE tkt_info.status <>'Closed'
	                    GROUP BY tkt_info.tkt_id";
	    }

	    // Define columns to search
	    $searchColumns = [
	        "id", 
	        "subject",
	        "priority",
	        "tkt_id", 
	        "fullname", 
	        "departments", 
	        "deadline", 
	        "status"
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

	    // Fetch total number of records without any filters
	    $totalRecordsQuery = mysqli_query($connect, "SELECT COUNT(*) as total FROM ($query) as subQuery");
	    if (!$totalRecordsQuery) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }
	    $totalRecordsData = mysqli_fetch_assoc($totalRecordsQuery);
	    $totalRecords = $totalRecordsData['total'];

	    // Fetch total number of records with applied filters
	    $filteredRecordsQuery = mysqli_query($connect, "$query");
	    if (!$filteredRecordsQuery) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }
	    $totalFiltered = mysqli_num_rows($filteredRecordsQuery);

	    // Apply pagination and ordering to the base query
	    $query .= " ORDER BY tkt_info.id DESC LIMIT $start, $length";

	    // Fetch filtered and paginated records
	    $resultSet = mysqli_query($connect, $query);
	    if (!$resultSet) {
	        die("Error in SQL: " . mysqli_error($connect));
	    }

	    // Fetch all rows from the result set
	    $result = mysqli_fetch_all($resultSet, MYSQLI_ASSOC);

	    // Prepare the response array
	    $response = [
	        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
	        "recordsTotal" => $totalRecords,
	        "recordsFiltered" => $totalFiltered,
	        "data" => $result
	    ];

	    // Output the JSON-encoded response
	    return array($response);
	}






?>