<?php

class TicketAssign
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


	// function getTickets(){

	// 	$query=" SELECT * FROM tkt_info 
	// 	-- where user_id=?
	// 	ORDER BY id DESC;
	// 	";

	// 	$statement = $this->connect->prepare($query);
		
	// 	if ($statement->execute()) {
	// 		$result = $statement->get_result();
	// 		$all_tickets = $result->fetch_all();
			
	// 	} else {
			
	// 		$all_tickets = array();
	// 	}
		
	// 	$statement->close();
		
	// 	return $all_tickets;

	// }

	function getticket_assign_details(){

		$query=" SELECT tkt_assign.*, user.id,user.fullname,user.avtar
			from tkt_assign 
			JOIN user ON tkt_assign.user_id=user.id
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

	function create_ticket_assign(){

		$query="INSERT INTO tkt_assign (tkt_id,content,tkt_emp,tkt_dept,reply_time,reply_by,user_id,status) 
		values (?,?,?,?,?,?,?,?)";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('ssssssis', $this->tkt_id,$this->content,$this->tkt_emp,$this->tkt_dept,$this->reply_time,$this->reply_by,$this->user_id,$this->status);
	
		if($statement->execute()){
		
			return true;
		}
		else{

			return false;
		}
	}

	function create_ticket_reply(){

		$query="INSERT INTO tkt_assign (tkt_id,content,tkt_emp,tkt_dept,reply_time,reply_by,user_id,status) 
		values (?,?,?,?,?,?,?,?)";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('ssssssis', $this->tkt_id,$this->content,$this->tkt_emp,$this->tkt_dept,$this->reply_time,$this->reply_by,$this->user_id,$this->status);
	
		if($statement->execute()){
		
			return true;
		}
		else{

			return false;
		}






	}



}






?>