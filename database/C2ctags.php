<?php

class C2ctags
{
	private $id;
	private $redid;
	private $pgid;
	private $amount;
	private $status;
	private $addedby;
	private $customer;
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

	function setRedid($redid)
	{
		$this->redid = $redid;
	}

	function getRedid()
	{
		return $this->redid;
	}

	function setAmount($amount)
	{
		$this->amount = $amount;
	}

	function getAmount()
	{
		return $this->amount;
	}

	function setAddedby($addedby)
	{
		$this->addedby = $addedby;
	}

	function getAddedby()
	{
		return $this->addedby;
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

	function setCustomer($customer)
	{
		$this->customer = $customer;
	}

	function getCustomer()
	{
		return $this->customer;
	}

	function setCreatedAt($created_at)
	{
		$this->created_at = $created_at;
	}

	function getCreatedAt()
	{
		return $this->created_at;
	}

	function getC2cdetailsbyid()
	{
	    $query = "
	        SELECT * FROM c2ctags
	        WHERE pgid=? 
	        AND redid=?	
	        ORDER BY id ASC
	    ";

	    $statement = $this->connect->prepare($query);
	    $statement->bind_param('ii', $this->pgid, $this->redid);

	    if ($statement->execute()) {
	        $result = $statement->get_result();
	        $c2cdetails = $result->fetch_all(MYSQLI_ASSOC); // Fetch as associative array
	        
	        // Get the field names (index names)
	        $field_names = array();
	        foreach ($result->fetch_fields() as $field) {
	            $field_names[] = $field->name;
	        }

	        // Add field names as part of the result, if needed
	        return [
	            'field_names' => $field_names,
	            'data' => $c2cdetails,
	        ];
	    } else {
	        return [
	            'field_names' => [],
	            'data' => [],
	        ];
	    }

	    $statement->close();
	}


	
	function deleteC2cRecord(){

		$query = "
		DELETE FROM C2ctags 
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('i',$this->id);

		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}


	}
	


	

}
?>