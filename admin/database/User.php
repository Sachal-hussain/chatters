<?php

class User
{
	private $user_id;
	private $user_name;
	private $user_email;
	private $user_password;
	private $user_profile;
	private $user_status;
	private $user_created_on;
	private $user_verification_code;
	private $user_login_status;
	private $user_token;
	private $user_connection_id;
	private $contact;
	private $type;
	private $is_type;

	public $connect;

	public function __construct()
	{
		require_once('../connect_me.php');

		$database_object = new Database_connection;

		$this->connect = $database_object->connect();
	}

	function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	function getUserId()
	{
		return $this->user_id;
	}

	function setUserName($user_name)
	{
		$this->user_name = $user_name;
	}

	function getUserName()
	{
		return $this->user_name;
	}

	function setUserEmail($user_email)
	{
		$this->user_email = $user_email;
	}

	function getUserEmail()
	{
		return $this->user_email;
	}

	function setUserPassword($user_password)
	{
		$this->user_password = $user_password;
	}

	function getUserPassword()
	{
		return $this->user_password;
	}

	function setUserProfile($user_profile)
	{
		$this->user_profile = $user_profile;
	}

	function getUserProfile()
	{
		return $this->user_profile;
	}

	function setUserStatus($user_status)
	{
		$this->user_status = $user_status;
	}

	function getUserStatus()
	{
		return $this->user_status;
	}

	function setContact($contact)
	{
		$this->contact = $contact;
	}

	function getContact()
	{
		return $this->contact;
	}

	function setUserCreatedOn($user_created_on)
	{
		$this->user_created_on = $user_created_on;
	}

	function getUserCreatedOn()
	{
		return $this->user_created_on;
	}

	function setUserVerificationCode($user_verification_code)
	{
		$this->user_verification_code = $user_verification_code;
	}

	function getUserVerificationCode()
	{
		return $this->user_verification_code;
	}

	function setUserLoginStatus($user_login_status)
	{
		$this->user_login_status = $user_login_status;
	}

	function getUserLoginStatus()
	{
		return $this->user_login_status;
	}

	function setUserToken($user_token)
	{
		$this->user_token = $user_token;
	}

	function getUserToken()
	{
		return $this->user_token;
	}

	function setUserConnectionId($user_connection_id)
	{
		$this->user_connection_id = $user_connection_id;
	}

	function getUserConnectionId()
	{
		return $this->user_connection_id;
	}

	function setType($type)
	{
		$this->type = $type;
	}

	function getType()
	{
		return $this->type;
	}

	function setIsType($is_type)
	{
		$this->is_type = $is_type;
	}

	function getIsType()
	{
		return $this->is_type;
	}

	

	function getTotalUsers(){
    $query = "SELECT count(*) as total_user 
	    FROM `user`
	    WHERE status='Active'
    ";
    $statement = $this->connect->prepare($query);
    $statement->execute();
    $result = $statement->get_result();

    // Check if the query was executed successfully
    if ($result) {
      $row = $result->fetch_assoc();
      if ($row) {
          return $row['total_user'];
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

	function getOnlineUsers(){
		$query = "SELECT count(*) as online_user 
			FROM `user` 
			WHERE status='Active' 
			AND online='Login'
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['online_user'];
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

	function getTotalClients(){
		$query = "SELECT count(*) as clients 
			FROM `user` 
			WHERE type='Client' AND status='Active';
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['clients'];
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

	function getOnlineClients(){
		$query = "SELECT count(*) as online_clients 
			FROM `user` 
			WHERE type='Client' AND status='Active'
			AND online='Login';
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['online_clients'];
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

	function getTotalManager(){
		$query = "SELECT count(*) as manager 
			FROM `user` 
			WHERE type='Manager' AND status='Active';
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['manager'];
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

	function getOnlineManager(){
		$query = "SELECT count(*) as online_manager 
			FROM `user` 
			WHERE type='Manager' AND status='Active'
			AND online='Login';
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['online_manager'];
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

	function getTotalSupervisor(){
		$query = "SELECT count(*) as supervisor 
			FROM `user` 
			WHERE type='Supervisor' AND status='Active';
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['supervisor'];
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

	function getOnlineSupervisor(){
		$query = "SELECT count(*) as online_supervisor 
			FROM `user` 
			WHERE type='Supervisor' AND status='Active'
			AND online='Login';
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['online_supervisor'];
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

	function getMorningShift(){
		$query = "SELECT count(*) as morning_shift 
			FROM `user` 
			WHERE shift='Morning' AND status='Active'
			
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['morning_shift'];
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

	function getOnlineMorningShift(){
		$query = "SELECT count(*) as online_morning_shift 
			FROM `user` 
			WHERE shift='Morning' AND status='Active'
			AND online='Login'
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['online_morning_shift'];
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

	function getEveningShift(){
		$query = "SELECT count(*) as evening_shift 
			FROM `user` 
			WHERE shift='Evening' AND status='Active'
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['evening_shift'];
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

	function getOnlineEveningShift(){
		$query = "SELECT count(*) as online_evening_shift 
			FROM `user` 
			WHERE shift='Evening' AND status='Active'
			AND online='Login'
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['online_evening_shift'];
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

	function getNightShift(){
		$query = "SELECT count(*) as night_shift 
			FROM `user` 
			WHERE shift='Night' AND status='Active'
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['night_shift'];
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

	function getOnlineNightShift(){
		$query = "SELECT count(*) as online_night_shift 
			FROM `user` 
			WHERE shift='Night' AND status='Active'
			AND online='Login'
		";
	  $statement = $this->connect->prepare($query);
	  $statement->execute();
	  $result = $statement->get_result();

	  // Check if the query was executed successfully
	  if ($result) {
	    $row = $result->fetch_assoc();
	    if ($row) {
	        return $row['online_night_shift'];
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

	function allUserdetails(){


		$query = "
			SELECT * from user		
			WHERE online='Login'
			AND status='Active'
		";

		$statement = $this->connect->prepare($query);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $users = $result->fetch_all();
		}
		else
		{
			$users = array();
			
		}

		$statement->close();

		return $users;

	}

	function allClientdetails(){


		$query = "
			SELECT * from user		
			WHERE online='Login'
			AND status='Active'
			AND type='Client'
		";

		$statement = $this->connect->prepare($query);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $client = $result->fetch_all();
		}
		else
		{
			$client = array();
			
		}

		$statement->close();

		return $client;

	}

	

}



?>

