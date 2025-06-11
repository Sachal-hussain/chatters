<?php

class TicketInfo
{
	private $id;
	private $tkt_id;
	private $tkttype;
	private $tkt_pgname;
	private $tkt_subject;
	private $custid;
	private $tkt_priority;
	private $record_time;
	private $record_by;
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

	function setTkttype($tkttype)
	{
		$this->tkttype = $tkttype;
	}

	function getTkttype()
	{
		return $this->tkttype;
	}

	function setTktPgname($tkt_pgname)
	{
		$this->tkt_pgname = $tkt_pgname;
	}

	function getTktPgname()
	{
		return $this->tkt_pgname;
	}

	function setTktSubject($tkt_subject)
	{
		$this->tkt_subject = $tkt_subject;
	}

	function getTktSubject()
	{
		return $this->tkt_subject;
	}

	function setCustid($custid)
	{
		$this->custid = $custid;
	}

	function getCustid()
	{
		return $this->custid;
	}

	function setTktPriority($tkt_priority)
	{
		$this->tkt_priority = $tkt_priority;
	}

	function getTktPriority()
	{
		return $this->tkt_priority;
	}

	function setRecordTime($record_time)
	{
		$this->record_time =  date('Y-m-d H:i:s');
	}

	function getRecordTime()
	{
		return $this->record_time;
	}

	function setRecordBy($record_by)
	{
		$this->record_by = $record_by;
	}

	function getRecordBy()
	{
		return $this->record_by;
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


	function getTickets(){

		// $query=" SELECT * FROM tkt_info 
		// -- where user_id=?
		// ORDER BY id DESC;
		// ";

		$query="SELECT tkt_info.*, tkt_assign.*, user.fullname as uname , user.avtar as avtar
			FROM tkt_info 
			LEFT JOIN tkt_assign ON
			tkt_info.tkt_id = tkt_assign.tkt_id
			LEFT JOIN user ON
			tkt_assign.tkt_emp = user.id
			WHERE tkt_info.user_id=?
			OR tkt_assign.tkt_emp =?
			GROUP BY tkt_info.tkt_id
			ORDER BY tkt_info.id DESC"
		;

		$statement = $this->connect->prepare($query);

		$statement->bind_param('ss', $this->user_id,$this->user_id);
		
		if ($statement->execute()) {
			$result = $statement->get_result();
			$all_tickets = $result->fetch_all();
			
		} else {
			
			$all_tickets = array();
		}
		
		$statement->close();
		
		return $all_tickets;


	}

	function getticket_by_id(){

		$query=" SELECT tkt_info.*, user.id,user.fullname,user.avtar
			from tkt_info 
			JOIN user ON tkt_info.user_id=user.id
			where tkt_id=?
		
		";	

		$statement = $this->connect->prepare($query);

		$statement->bind_param('s', $this->tkt_id);

		if($statement->execute())
		{
			$result = $statement->get_result();
	        $details = $result->fetch_all();
		}
		else
		{
			$details = array();
			
		}

		$statement->close();

		return $details;
	}

	function create_ticket(){

		$query="INSERT INTO tkt_info (tkt_id,tkt_subject,tkt_priority,record_time,record_by,user_id,status) 
		values (?,?,?,?,?,?,?)";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('sssssis', $this->tkt_id,$this->tkt_subject,$this->tkt_priority,$this->record_time,$this->record_by,$this->user_id,$this->status);
	
		if($statement->execute()){
		
			return true;
		}
		else{

			return false;
		}
	}

	function getuserby_type($type){

		$query="SELECT * FROM user 
			WHERE type=?"
		;

		$statement = $this->connect->prepare($query);

		$statement->bind_param('s', $type);

		if($statement->execute())
		{
			$result = $statement->get_result();
	        $details = $result->fetch_all();
		}
		else
		{
			$details = array();
			
		}

		$statement->close();

		return $details;

	}

	function get_all_tickets($type){

		if($type=='Webmaster'){
			
			$query="SELECT tkt_info.*, tkt_assign.*, user.fullname as uname , user.avtar as avtar
			FROM tkt_info 
			LEFT JOIN tkt_assign ON
			tkt_info.tkt_id = tkt_assign.tkt_id
			LEFT JOIN user ON
			tkt_assign.tkt_emp = user.id
			
			GROUP BY tkt_info.tkt_id
			ORDER BY tkt_info.id DESC"
			;


		$statement = $this->connect->prepare($query);
		if ($statement->execute()) {
			$result = $statement->get_result();
			$all_tickets = $result->fetch_all();
			
		} else {
			
			$all_tickets = array();
		}
		
		$statement->close();
		
		return $all_tickets;
		
		}

	}

	function getLeaveStatus($uid){

		$query="SELECT * FROM leave_form
			WHERE userid='$uid' ORDER BY id DESC 
		";

		$statement = $this->connect->prepare($query);
		if ($statement->execute()) {
			$result = $statement->get_result();
			$leaveStatus = $result->fetch_all();
			
		} else {
			
			$leaveStatus = array();
		}
		
		$statement->close();
		
		return $leaveStatus;
		
		

	}

	function updateStatus(){
		$query="UPDATE tkt_info 
			Set status = ?
			WHERE tkt_id = ?
		";

		$statement = $this->connect->prepare($query);
		$statement->bind_param('ss', $this->status, $this->tkt_id);

		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}


	}

}






?>