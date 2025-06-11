<?php

class AddCustomer
{
	private $id;
	private $name;
	private $email;
	private $phone_number;
	private $profile_link;
	private $pgid;
	private $status;
	private $approval;
	private $license;
	private $updatedby;
	private $updated_at;
	

	protected $connect;

	public function __construct()
	{
		require_once('../connect_me.php');

		$db = new Database_connection();

		$this->connect = $db->connect();
	}

	function setId($id)
	{
		$this->id = $id;
	}

	function getId()
	{
		return $this->id;
	}

	function setName($name)
	{
		$this->name = $name;
	}

	function getName()
	{
		return $this->name;
	}

	function setEmail($email)
	{
		$this->email = $email;
	}

	function getEmail()
	{
		return $this->email;
	}
	
	function setPhoneNumber($phone_number)
	{
		$this->phone_number = $phone_number;
	}

	function getPhoneNumber()
	{
		return $this->phone_number;
	}

	function setProfileLink($profile_link)
	{
		$this->profile_link = $profile_link;
	}

	function getProfileLink()
	{
		return $this->profile_link;
	}

	function setPgid($pgid)
	{
		$this->pgid = $pgid;
	}

	function getPgid()
	{
		return $this->pgid;
	}

	function setStatus($status)
	{
		$this->status = $status;
	}

	function getStatus()
	{
		return $this->status;
	}

	function setApproval($approval)
	{
		$this->approval = $approval;
	}

	function getApproval()
	{
		return $this->approval;
	}

	function setLicense($license)
	{
		$this->license = $license;
	}

	function getLicense()
	{
		return $this->license;
	}

	function setUpdatedby($updatedby)
	{
		$this->updatedby = $updatedby;
	}

	function getUpdatedby()
	{
		return $this->updatedby;
	}

	function setUpdatedAt($updated_at)
	{
		$this->updated_at = $updated_at;
	}

	function getUpdatedAt()
	{
		return $this->updated_at;
	}
	function getCashtagbyid(){

		$query = "
		SELECT * from cashapp	
		WHERE pgid=? 
		AND status='active'	
		ORDER BY id ASC
		";

		$statement = $this->connect->prepare($query);
		$statement->bind_param('i', $this->pgid);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $cashtag = $result->fetch_all();
		}
		else
		{
			$cashtag = array();
			
		}

		$statement->close();

		return $cashtag;
	}

	function approvalCustomerEntry(){

		$query = "
		UPDATE addcustomer
		SET status= ?, approval = ?, updatedby= ?, updated_at = ?  
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('sissi',$this->status,$this->approval,$this->updatedby, $this->updated_at,$this->id);

		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}
	}

	function deleteApprovalCustomerEntry() {
	    $query = "DELETE FROM addcustomer WHERE id = ?";

	    $statement = $this->connect->prepare($query);

	    if ($statement === false) {
	        // Log the error or handle it as necessary
	        die('Prepare failed: ' . htmlspecialchars($this->connect->error));
	    }

	    $statement->bind_param('i', $this->id);

	    if ($statement->execute()) {
	        $statement->close();
	        return true;
	    } else {
	        // Log the error or handle it as necessary
	        $statement->close();
	        return false;
	    }
	}

	function getCustomerbyid(){

		$query = "
		SELECT name,id from addcustomer	
		WHERE pgid=? 
		AND status='active'	
		ORDER BY name ASC
		";

		$statement = $this->connect->prepare($query);
		$statement->bind_param('i', $this->pgid);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $customer = $result->fetch_all();
		}
		else
		{
			$customer = array();
			
		}

		$statement->close();

		return $customer;
	}

	function getCustomerbyPage(){

		$query = "
		SELECT name,pgid,redeem_limit from addcustomer	
		WHERE pgid=? 
		AND status='active'	
		ORDER BY name ASC
		";

		$statement = $this->connect->prepare($query);
		$statement->bind_param('i', $this->pgid);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $customer = $result->fetch_all(MYSQLI_ASSOC);
		}
		else
		{
			$customer = array();
			
		}

		$statement->close();

		return $customer;
	}


	function getCustomerbyName($searchTerm = '') {
	    // Start the query with the basic conditions
	    $query = "
	    SELECT name FROM addcustomer 
	    WHERE pgid = ? 
	    AND status = 'active'
	    ";

	    // If a search term is provided, modify the query to search for the name
	    if (!empty($searchTerm)) {
	        $query .= " AND name LIKE ?";
	    }

	    $query .= " ORDER BY name ASC";

	    // Prepare the statement
	    $statement = $this->connect->prepare($query);

	    // If a search term is provided, bind it with wildcards for LIKE search
	    if (!empty($searchTerm)) {
	        $searchTerm = "%" . $searchTerm . "%"; // Add '%' for partial matches
	        $statement->bind_param('is', $this->pgid, $searchTerm); // 'i' for integer pgid, 's' for string searchTerm
	    } else {
	        $statement->bind_param('i', $this->pgid); // No search term, only pgid
	    }

	    // Execute the query
	    if ($statement->execute()) {
	        $result = $statement->get_result();
	        $customer = $result->fetch_all();
	    } else {
	        $customer = array();
	    }

	    $statement->close();

	    return $customer;
	}

	function getCustomerDetails() {
		$query = "
			SELECT 
				addcustomer.id AS customer_id, 
				name, 
				email, 
				phone_number,
				profile_link, 
				GROUP_CONCAT(img_upload.path) AS paths
			FROM addcustomer
			LEFT JOIN img_upload 
				ON addcustomer.id = img_upload.catransid 
				AND img_upload.type = 'Customer Attachment'
			WHERE addcustomer.id = ? 
			AND addcustomer.status = 'active'
			GROUP BY addcustomer.id
		";

		$statement = $this->connect->prepare($query);

		// 🔍 Check for prepare error
		if (!$statement) {
			die("Prepare failed: " . $this->connect->error);
		}

		$statement->bind_param('i', $this->id);

		if ($statement->execute()) {
			$result = $statement->get_result();
			$customer = $result->fetch_all(MYSQLI_ASSOC);
		} else {
			$customer = [];
		}

		$statement->close();
		return $customer;
	}

	function updateCustomerDetails() {
		
		$query = "SELECT id FROM addcustomer WHERE id = ?";
		$stmt = $this->connect->prepare($query);
		$stmt->bind_param("i", $this->id);
		$stmt->execute();
		$stmt->store_result();

		
		if ($stmt->num_rows > 0) {
			$update = "UPDATE addcustomer SET email = ?, profile_link = ?, license = ?, phone_number = ? WHERE id = ?";
			$updateStmt = $this->connect->prepare($update);
			$updateStmt->bind_param("ssisi", $this->email, $this->profile_link, $this->license, $this->phone_number, $this->id);
			$updateStmt->execute();
			$updateStmt->close();
			
		}

		$stmt->close();
	}



}




?>