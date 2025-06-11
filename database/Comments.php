<?php

class Comments
{
	private $id;
	private $red_id;
	private $pg_id;
	private $uid;
	private $uname;
	private $remarks;
	private $created_at;
	

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

	function setRedId($red_id)
	{
		$this->red_id = $red_id;
	}

	function getRedId()
	{
		return $this->red_id;
	}

	
	function setPgId($pg_id)
	{
		$this->pg_id = $pg_id;
	}

	function getPgId()
	{
		return $this->pg_id;
	}

	function setUid($uid)
	{
		$this->uid = $uid;
	}

	function getUid()
	{
		return $this->uid;
	}

	function setUname($uname)
	{
		$this->uname = $uname;
	}

	function getUname()
	{
		return $this->uname;
	}

	function setRemarks($remarks)
	{
		$this->remarks = $remarks;
	}

	function getRemarks()
	{
		return $this->remarks;
	}

	function setCreatedAt($created_at)
	{
		$this->created_at = date('Y-m-d H:i:s');
	}

	function getCreatedAt()
	{
		return $this->created_at;
	}
	

	function insertComments(){

		$query=" INSERT INTO comments (red_id,pg_id,uid,uname,remarks,created_at) 
        values (?,?,?,?,?,?)
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('iiisss', $this->red_id,$this->pg_id,$this->uid,$this->uname,$this->remarks,$this->created_at);
	
		if($statement->execute()){
		
			return $statement->insert_id;
		}
		else{

			return false;
		}
	}

	function getRedeemRemarks() {
	    $query = "SELECT * FROM `comments` WHERE red_id = ? ORDER BY created_at desc";

	    // Prepare the SQL statement
	    $statement = $this->connect->prepare($query);

	    if ($statement === false) {
	        // Handle preparation error
	        return array('error' => 'Failed to prepare the SQL statement.');
	    }

	    // Bind the red_id parameter
	    $statement->bind_param('i', $this->red_id);

	    // Execute the statement
	    if ($statement->execute()) {
	        $result = $statement->get_result();
	        // Fetch all results as an associative array
	        $comments = $result->fetch_all(MYSQLI_ASSOC);
	    } else {
	        // Handle execution error
	        $comments = array('error' => 'Failed to execute the SQL statement.');
	    }

	    // Close the statement
	    $statement->close();

	    return $comments;
	}

}
?>