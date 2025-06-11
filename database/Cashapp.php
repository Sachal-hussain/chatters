<?php

class Cashapp
{
	private $id;
	private $name;
	private $cashtag;
	private $balance;
	private $remarks;
	private $pgid;
	private $uid;
	private $status;
	

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

	function setCashtag($cashtag)
	{
		$this->cashtag = $cashtag;
	}

	function getCashtag()
	{
		return $this->cashtag;
	}

	function setBalance($balance)
	{
		$this->balance = $balance;
	}

	function getBalance()
	{
		return $this->balance;
	}

	function setRemarks($remarks)
	{
		$this->remarks = $remarks;
	}

	function getRemarks()
	{
		return $this->remarks;
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

	function setUid($uid)
	{
		$this->uid = $uid;
	}

	function getUid()
	{
		return $this->uid;
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

	function getAllCashtag(){

		$query = "
		SELECT * from cashapp
		WHERE status='active'	
		ORDER BY id ASC
		";

		$statement = $this->connect->prepare($query);
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
	// function saveCashtagDetails(){

	// 	$query=" INSERT INTO cashapp (name,cashtag,uid,pgid,status) 
    //     values (?,?,?,?,?)
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bind_param('ssiis', $this->name,$this->cashtag,$this->uid,$this->pgid,$this->status);
	
	// 	if($statement->execute()){
		
	// 		return $statement->insert_id;
	// 	}
	// 	else{

	// 		return false;
	// 	}


	// }
	function saveCashtagDetails() {
	    // Check if the cashtag or pgid already exists
	    $checkQuery = "SELECT * FROM cashapp WHERE name = ? AND cashtag = ? AND pgid = ?";
	    $checkStatement = $this->connect->prepare($checkQuery);
	    $checkStatement->bind_param('ssi',$this->name, $this->cashtag, $this->pgid);
	    $checkStatement->execute();
	    $checkStatement->store_result();

	    if ($checkStatement->num_rows > 0) {
	        return "Cashtag already exists!";
	    }

	    // If not exists, insert the new record
	    $query = "INSERT INTO cashapp (name, cashtag, uid, pgid, status) VALUES (?, ?, ?, ?, ?)";
	    $statement = $this->connect->prepare($query);
	    $statement->bind_param('ssiis', $this->name, $this->cashtag, $this->uid, $this->pgid, $this->status);
	    
	    if ($statement->execute()) {
	        return $statement->insert_id;
	    } else {
	        return false;
	    }
	}


	function get_all_cashapp()
	{
		$query = "
		SELECT cashapp.*, pages.id as page_id, pages.pagename
		FROM cashapp 
		INNER JOIN pages
		ON pages.id=cashapp.pgid
		ORDER BY cashapp.id ASC;

		";

		$statement = $this->connect->prepare($query);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $cashapp = $result->fetch_all();
		}
		else
		{
			$cashapp = array();
			
		}

		$statement->close();

		return $cashapp;
	}

	function updateCashappStatus(){

		$query = "
		UPDATE cashapp
		SET status = ?, balance=?, remarks=?
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('sssi',$this->status,$this->balance,$this->remarks,$this->id);

		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}


	}

	function getCashAppPage()
	{
	    $query = "
	    SELECT cashapp.*, pages.id as page_id, pages.pagename
	    FROM cashapp 
	    INNER JOIN pages
	    ON pages.id = cashapp.pgid
	    WHERE cashapp.pgid = ?
	    ORDER BY cashapp.status ASC
	    ";

	    // Prepare the statement
	    if ($statement = $this->connect->prepare($query)) {
	        // Bind the pgid parameter
	        $statement->bind_param("i", $this->pgid);

	        // Execute the query
	        if ($statement->execute()) {
	            // Get the result
	            $result = $statement->get_result();
	            $cashapp = $result->fetch_all(MYSQLI_ASSOC);  // Fetch as associative array
	        } else {
	            // Handle execution error
	            $cashapp = array();
	        }

	        // Close the statement
	        $statement->close();
	    } else {
	        // Handle preparation error
	        $cashapp = array();
	    }

	    return $cashapp;
	}

}
?>