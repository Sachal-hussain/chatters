<?php

class Tickets
{
	private $id;
	private $tkt_id;
	private $content;
	private $tkt_dept;
	private $tkt_emp;
	private $reply_time;
	private $reply_by;
	private $user_id;
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

	function setTktId($tkt_id)
	{
		$this->tkt_id = $tkt_id;
	}

	function getTktId()
	{
		return $this->tkt_id;
	}

	function setContent($content)
	{
		$this->content = $content;
	}

	function getContent()
	{
		return $this->content;
	}

	function setTktDept($tkt_dept)
	{
		$this->tkt_dept = $tkt_dept;
	}

	function getTktDept()
	{
		return $this->tkt_dept;
	}

	function setTktEmp($tkt_emp)
	{
		$this->tkt_emp = $tkt_emp;
	}

	function getTktEmp()
	{
		return $this->tkt_emp;
	}

	function setReplyTime($reply_time)
	{
		$this->reply_time =  date('Y-m-d H:i:s');
	}

	function getReplyTime()
	{
		return $this->reply_time;
	}

	function setReplyBy($reply_by)
	{
		$this->reply_by = $reply_by;
	}

	function getReplyBy()
	{
		return $this->reply_by;
	}

	function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	function getUserId()
	{
		return $this->user_id;
	}

	function setStatus($status)
	{
		$this->status = $status;
	}

	function getStatus()
	{
		return $this->status;
	}

	function getTotalTickets(){
		
	    $query = "SELECT count(*) as total_tickets 
		    FROM `tkt_info`
	    ";
	    $statement = $this->connect->prepare($query);
	    $statement->execute();
	    $result = $statement->get_result();

	    // Check if the query was executed successfully
	    if ($result) {
	      $row = $result->fetch_assoc();
	      if ($row) {
	          return $row['total_tickets'];
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

	function getTotalUrgent(){
		
	    $query = "SELECT count(*) as total_urgent 
		    FROM `tkt_info`
		    WHERE tkt_priority='Urgent'
	    ";
	    $statement = $this->connect->prepare($query);
	    $statement->execute();
	    $result = $statement->get_result();

	    // Check if the query was executed successfully
	    if ($result) {
	      $row = $result->fetch_assoc();
	      if ($row) {
	          return $row['total_urgent'];
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

	function getTotalHigh(){
		
	    $query = "SELECT count(*) as total_high 
		    FROM `tkt_info`
		    WHERE tkt_priority='High'
	    ";
	    $statement = $this->connect->prepare($query);
	    $statement->execute();
	    $result = $statement->get_result();

	    // Check if the query was executed successfully
	    if ($result) {
	      $row = $result->fetch_assoc();
	      if ($row) {
	          return $row['total_high'];
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

	function getTotalMedium(){
		
	    $query = "SELECT count(*) as total_medium 
		    FROM `tkt_info`
		    WHERE tkt_priority='Medium'
	    ";
	    $statement = $this->connect->prepare($query);
	    $statement->execute();
	    $result = $statement->get_result();

	    // Check if the query was executed successfully
	    if ($result) {
	      $row = $result->fetch_assoc();
	      if ($row) {
	          return $row['total_medium'];
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

	function getTotalRoutine(){
		
	    $query = "SELECT count(*) as total_routine 
		    FROM `tkt_info`
		    WHERE tkt_priority='Routine'
	    ";
	    $statement = $this->connect->prepare($query);
	    $statement->execute();
	    $result = $statement->get_result();

	    // Check if the query was executed successfully
	    if ($result) {
	      $row = $result->fetch_assoc();
	      if ($row) {
	          return $row['total_routine'];
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

	function getTotalClosed(){
		
	    $query = "SELECT count(*) as total_closed 
		    FROM `tkt_info`
		    WHERE status='Closed'
	    ";
	    $statement = $this->connect->prepare($query);
	    $statement->execute();
	    $result = $statement->get_result();

	    // Check if the query was executed successfully
	    if ($result) {
	      $row = $result->fetch_assoc();
	      if ($row) {
	          return $row['total_closed'];
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

	function getTotalPending(){
		
	    $query = "SELECT count(*) as total_pending 
		    FROM `tkt_info`
		    WHERE status='Pending'
	    ";
	    $statement = $this->connect->prepare($query);
	    $statement->execute();
	    $result = $statement->get_result();

	    // Check if the query was executed successfully
	    if ($result) {
	      $row = $result->fetch_assoc();
	      if ($row) {
	          return $row['total_pending'];
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

	function getTotalCancelled(){
		
	    $query = "SELECT count(*) as total_cencelled 
		    FROM `tkt_info`
		    WHERE status='Cancelled'
	    ";
	    $statement = $this->connect->prepare($query);
	    $statement->execute();
	    $result = $statement->get_result();

	    // Check if the query was executed successfully
	    if ($result) {
	      $row = $result->fetch_assoc();
	      if ($row) {
	          return $row['total_cencelled'];
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






?>