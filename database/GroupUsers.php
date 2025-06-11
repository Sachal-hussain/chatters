<?php 
	
class GroupUsers
{

	private $grpid;
	private $userid;
	private $status;
	private $is_seen;
	private $is_type;
	private $record_time;

	protected $connect;

	public function __construct()
	{
		require_once("connect_me.php");

		$database_object = new Database_connection;

		$this->connect = $database_object->connect();
	}

	public function setGrpid($grpid)
	{
		$this->grpid = $grpid;
	}

	function getGrpid()
	{
		return $this->grpid;
	}

	public function setUserid($userid)
	{
		$this->userid = $userid;
	}

	function getUserid()
	{
		return $this->userid;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	function getStatus()
	{
		return $this->status;
	}

	public function setIsSeen($is_seen)
	{
		$this->is_seen = $is_seen;
	}

	function getIsSeen()
	{
		return $this->is_seen;
	}

	public function setIsType($is_type)
	{
		$this->is_type = $is_type;
	}

	function getIsType()
	{
		return $this->is_type;
	}

	public function setRecordTime($record_time)
	{
		$this->record_time = date('Y-m-d H:i:s');
	}

	function getRecordTime()
	{
		return $this->record_time;
	}

	function get_group_users()
	{
		$query = "
		SELECT groupusers.* ,user.id as user_id, user.fullname as user_name , user.uname 
		from groupusers
		INNER JOIN user ON
		groupusers.userid=user.id
		WHERE grpid=?
		AND user.status='Active'
		ORDER BY user.fullname ASC
		";

		$statement = $this->connect->prepare($query);
        // print_r($query);
       
		$statement->bind_param('s', $this->grpid);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $group_users = $result->fetch_all();
		}
		else
		{
			$group_users = array();
			
		}

		$statement->close();

		return $group_users;
	}

	function get_group_admin($id){
		 // print_r($id);
		 // exit;
		$query = "
		SELECT * FROM chatgroups WHERE id=?
		";

		$statement = $this->connect->prepare($query);
       
       
		$statement->bind_param('i',$id); 

		if($statement->execute())
		{
			$result = $statement->get_result();
            $group_admin = $result->fetch_all();
		}
		else
		{
			$group_admin = array();
			
		}

		$statement->close();

		return $group_admin;

	}

	function get_all_users()
	{
		$query = "
		SELECT id, fullname
		FROM user
		WHERE id NOT IN (
		    SELECT userid
		    FROM groupusers
		    WHERE grpid = ?
		) 
		AND status='Active'
		ORDER BY fullname ASC
		";

		$statement = $this->connect->prepare($query);
        // print_r($query);
       
		$statement->bind_param('s', $this->grpid);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $group_users = $result->fetch_all();
		}
		else
		{
			$group_users = array();
			
		}

		$statement->close();

		return $group_users;
	}

	function remove_users($userid,$type){
		
		if($type=='Webmaster' || $type=='Manager'){
		
			$query="
				DELETE FROM `groupusers` 
				where userid=$userid
			";

			$statement = $this->connect->prepare($query);

			$statement->execute();

			return true;

		}
		else
		{

			return false;
		}
	}

	function add_usertogroup($insert,$grpid){

		$cb = explode(",", $insert);
	       
	    foreach ($cb as $key => $val) {
	        $query = "INSERT INTO groupusers (grpid, userid, record_time, status) VALUES (?, ?, ?, 'active')";
	        $statement = $this->connect->prepare($query);

	        $record_time = date('Y-m-d H:i:s'); // Set the record time here
	        $statement->bind_param('iis', $grpid, $val, $record_time);

	        if (!$statement->execute()) {
	            // Insert failed
	            $statement->close(); // Close the prepared statement
	            return false;
	        }

	        $statement->close(); // Close the prepared statement after each successful insert
	    }

	    return true;
	}

	function addusertogroupaftercreating($insert, $grpid) {

		// print_r($insert);
		// exit;

	    // $cb = explode(",", $insert);
	       
	    foreach ($insert as $key => $val) {
	        $query = "INSERT INTO groupusers (grpid, userid, record_time, status) VALUES (?, ?, ?, 'active')";
	        $statement = $this->connect->prepare($query);

	        $record_time = date('Y-m-d H:i:s'); // Set the record time here
	        $statement->bind_param('iis', $grpid, $val, $record_time);

	        if (!$statement->execute()) {
	            // Insert failed
	            $statement->close(); // Close the prepared statement
	            return false;
	        }

	        $statement->close(); // Close the prepared statement after each successful insert
	    }

	    return true;
	}

	function gettagusers($grpid,$text,$uid){

		$query="SELECT groupusers.*, user.id AS user_id, user.fullname AS user_name
		FROM groupusers
		INNER JOIN user ON groupusers.userid = user.id
		WHERE grpid = '$grpid'
		AND LOWER(user.fullname) LIKE '%$text%'
		AND user.id!=$uid
		ORDER BY user.fullname ASC";

		$statement = $this->connect->prepare($query);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $group_users = $result->fetch_all();
		}
		else
		{
			$group_users = array();
			
		}

		$statement->close();

		return $group_users;
	}

	function get_group_typing_status($grp_id,$uid){
		// SELECT is_type FROM groupusers
		// 	WHERE userid = ?
		// 	ORDER BY id DESC
		// 	LIMIT 1
		$output='';
		
		// $query="
		// 	SELECT groupusers.is_type,user.fullname 
        //     FROM groupusers
        //     JOIN user 
		// 	on user.id=groupusers.userid
		// 	WHERE grpid = ?
		// 	ORDER BY groupusers.id DESC
		// 	LIMIT 1;
		// ";

		$query="
			SELECT groupusers.is_type,user.fullname 
			from groupusers
			INNER JOIN user ON
			groupusers.userid=user.id
			WHERE grpid=?
			AND groupusers.is_type='yes'
			AND user.id<>'$uid'
			ORDER BY groupusers.id DESC
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('i', $grp_id);

		
	    if ($statement->execute()) {
	      $result = $statement->get_result();
	        if ($result->num_rows > 0) {
	          $row = $result->fetch_assoc(); 
	          if($row['is_type']=='yes'){
		        $output ='
		          	<div id="typing-indicator" class="typing-indicator">'.$row['fullname'].' Typing
						<span class="animate-typing">
						<span class="dot"></span>
						<span class="dot"></span>
						<span class="dot"></span>
						</span>
					</div>' 
				; 
	          }
	        } 
	        else {
	          $output = null; // No rows found
	        }
	    }
	    else {
	        $output = null; // Execution failed
	    }


	    $statement->close();

	    return $output;
	}

	function update_typing_status(){
		// print_r($this->is_type.$this->userid.$this->grpid);
		// exit;
		$query = "
		UPDATE groupusers
		SET is_type = ? 
		WHERE userid = ?
		AND grpid= ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('sii', $this->is_type, $this->userid, $this->grpid);

		$statement->execute();
	}

	function update_is_seen(){

		$query = "
		UPDATE groupusers
		SET is_seen ='1' 
		WHERE grpid = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('i', $this->grpid);

		$statement->execute();
	}

	function update_is_seen_status($userid,$grpid){
		// print_r($grpid.''.$userid);
		// exit;
		$record_time  = date('Y-m-d H:i:s');
		$query = "
		UPDATE groupusers
		SET is_seen ='0', 
		record_time= '$record_time'
		WHERE grpid = ?
		AND userid = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('ii',$grpid, $userid);

		if($statement->execute()){

			return true;
		}
		else{
			return false;
		}

	}
}
