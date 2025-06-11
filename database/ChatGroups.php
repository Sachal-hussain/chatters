<?php

class ChatGroups{

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
		require_once("connect_me.php");

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

	function createnewgroup() {

		$checkQuery = "SELECT groupname FROM chatgroups WHERE groupname = ?";
	    $checkStatement = $this->connect->prepare($checkQuery);
	    $checkStatement->bind_param('s', $this->groupname);
	    $checkStatement->execute();
	    $checkStatement->store_result();

	    if ($checkStatement->num_rows > 0) {
	        // The groupname already exists, return an error message
	        $checkStatement->close();
	        return "Error";
	        
	    }
		
	    $query = "
	        INSERT INTO chatgroups 
	        (groupname, permission, status, img, changeby, record_time, create_by,admins) 
	        VALUES (?, ?, ?, ?, ?, ?, ?,?)
	    ";

	    $statement = $this->connect->prepare($query);
	    

	    if (!$statement) {
	        // Handle the error, e.g., log it or return an error message
	        return "Error: " . $this->connect->error;
    	}

	    $statement->bind_param('ssssssss', $this->groupname, $this->permission, $this->status,$this->img, $this->changeby, $this->record_time, $this->create_by,$this->admins);

	    if ($statement->execute()) {
	        $insertedId = $this->connect->insert_id; // Get the inserted ID
	        $statement->close();
	        return $insertedId;
	    } else {
	        $statement->close();
	        // return false;
	        return "Execution Error: " . $statement->error;

	    }

	}

	function updategroupdetails() {
		
	    $query = "
	    UPDATE chatgroups 
	    SET groupname = ?, 
	    img = ? 
	    WHERE id = ?
	    ";

	    $statement = $this->connect->prepare($query);

	    if (!$statement) {
	        return false; // Handle error
	    }

	    $statement->bind_param('ssi', $this->groupname, $this->img, $this->id);

	    if ($statement->execute()) {
	        return true;
	    } else {
	        return false;
	    }
	}

	function upload_image($group_profile)
	{
		$extension = explode('.', $group_profile['name']);
		
		$new_name = rand() . '.' . $extension[1];
		$destination = 'assets/images/group/' . $new_name;
		move_uploaded_file($group_profile['tmp_name'], $destination);
		return $new_name;
		
	}

	function create_group_admin($admins){

		$query = "
	    SELECT * FROM chatgroups
	    WHERE id = ?
	    ";

	    $statement = $this->connect->prepare($query);

		$statement->bind_param('i', $this->id);

		$statement->execute();

		$result=$statement->get_result();

		$output=$result->fetch_assoc();
		if($output['admins']){
			$updatedAdmins = $output['admins'] . ',' . $admins;
			$query="
			UPDATE chatgroups
			SET admins=?
			WHERE id=?
			";

			$statement = $this->connect->prepare($query);

			$statement->bind_param('si',$updatedAdmins, $this->id);

			if($statement->execute()){

				return true;
			}
			else{

				return false;
			}
		}
	}





}