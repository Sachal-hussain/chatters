<?php

class Groups{

	private $id;
	private $groupname;
	private $permission;
	private $status;
	private $img;
	private $changeby;
	private $record_time;
	private $create_by;
	private $admins;

	protected $connect;

	public function __construct()
	{
		require_once("../connect_me.php");

		$database_object = new Database_connection;

		$this->connect = $database_object->connect();
	}

	
	function setId($id)
	{
		$this->id = $id;
	}

	function getId()
	{
		return $this->id;
	}

	function setGroupname($groupname)
	{
		$this->groupname = $groupname;
	}

	function getGroupname()
	{
		return $this->groupname;
	}

	function setPermission($permission)
	{
		$this->permission = $permission;
	}

	function getPermission()
	{
		return $this->permission;
	}

	function setStatus($status)
	{
		$this->status = $status;
	}

	function getStatus()
	{
		return $this->status;
	}

	function setImg($img)
	{
		$this->img = $img;
	}

	function getImg()
	{
		return $this->img;
	}

	function setChangeby($changeby)
	{
		$this->changeby = $changeby;
	}

	function getChangeby()
	{
		return $this->changeby;
	}

	function setRecortTime($record_time)
	{
		$this->record_time = date('Y-m-d H:i:s');
	}

	function getRecortTime()
	{
		return $this->record_time;
	}

	function setCreateBy($create_by)
	{
		$this->create_by = $create_by;
	}

	function getCreateBy()
	{
		return $this->create_by;
	}

	function setAdmins($admins)
	{
		$this->admins = $admins;
	}

	function getAdmins()
	{
		return $this->admins;
	}
	
	function getTotalGroups(){
		$query = "SELECT count(*) as total_groups 
			FROM `chatgroups`
			WHERE status='active'
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['total_groups'];
	    } 
	    else {
	        // No rows found, return 0 or handle accordingly
	      return 0;
	    }
	  } 
	  else {
	      // Handle the query execution error, e.g., log or return an error message
	    return false;
	  }
	}
}