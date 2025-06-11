<?php

//PrivateChat.php

class PrivateChat
{
	private $msg_id;
	private $grpid;
	private $outgoing_msg_id;
	private $incoming_msg_id;
	private $msg;
	private $msg_reply;
	private $record_time;
	private $status;
	private $img_path;
	private $msg_emoji;
	private $is_notify;
	protected $connect;

	public function __construct()
	{
		require_once('connect_me.php');

		$db = new Database_connection();

		$this->connect = $db->connect();
	}

	function setMsgId($msg_id)
	{
		$this->msg_id = $msg_id;
	}

	function getMsgId()
	{
		return $this->msg_id;
	}

	function setGrpid($grpid)
	{
		$this->grpid = $grpid;
	}

	function getGrpid()
	{
		return $this->grpid;
	}

	function setReplyMsg($msg_reply)
	{
		$this->msg_reply = $msg_reply;
	}

	function getReplyMsg()
	{
		return $this->msg_reply;
	}

	function setMsgEmoji($msg_emoji)
	{
		$this->msg_emoji = $msg_emoji;
	}

	function getMsgEmoji()
	{
		return $this->msg_emoji;
	}

	function setOutGoingMsgId($outgoing_msg_id)
	{
		$this->outgoing_msg_id = $outgoing_msg_id;
	}

	function getOutGoingMsgId()
	{
		return $this->outgoing_msg_id;
	}

	function setIncomingMsgId($incoming_msg_id)
	{
		$this->incoming_msg_id = $incoming_msg_id;
	}

	function getIncomingMsgId()
	{
		return $this->incoming_msg_id;
	}

	function setMsg($msg)
	{
		$this->msg = $msg;
	}

	function getMsg()
	{
		return $this->msg;
	}

	function setRecordTime($record_time)
	{
		// $this->record_time = $record_time;
		$this->record_time = date('Y-m-d H:i:s');
	}

	function getRecordTime()
	{
		return $this->record_time;
	}

	function setStatus($status)
	{
		$this->status = $status;
	}

	function getStatus()
	{
		return $this->status;
	}

	function setImgPath($img_path)
	{
		$this->img_path = $img_path;
	}

	function getImgPath()
	{
		return $this->img_path;
	}

	function setIsNotify($is_notify)
	{
		$this->is_notify = $is_notify;
	}

	function getIsNotify()
	{
		return $this->is_notify;
	}

	// get user chat start here 
	// function get_all_chat_data($offset=0,$limit=0)
	// {        
		
    //     $query = "
    //         SELECT  a.fullname as from_user_name, b.fullname as to_user_name, a.avtar as userimg, chat.msg_id,chat.msg, 
	// 		chat.msg_reply, chat.record_time, chat.status,chat.msg_emoji as emoji, outgoing_msg_id, incoming_msg_id, img_path  
    //         FROM chat 
    //         INNER JOIN user a 
    //         ON chat.incoming_msg_id = a.id 
    //         INNER JOIN user b 
    //         ON chat.outgoing_msg_id = b.id 
    //         WHERE (chat.incoming_msg_id = ? AND chat.outgoing_msg_id = ?) 
    //         OR (chat.incoming_msg_id = ? AND chat.outgoing_msg_id = ?)  
    //         ORDER BY chat.msg_id DESC
    //         LIMIT ? OFFSET ?";


    //         $statement = $this->connect->prepare($query);

    //         // Assuming $this->from_user_id and $this->to_user_id contain the relevant values
    //         $statement->bind_param('iiiiii', $this->incoming_msg_id, $this->outgoing_msg_id, $this->outgoing_msg_id, $this->incoming_msg_id,$limit, $offset);

    //         $statement->execute();

    //         $result = $statement->get_result();
            
    //         // Assuming you want to return an associative array with all the fetched rows
    //         $rows = array();
    //         while ($row = $result->fetch_assoc()) {
    //             $rows[] = $row;
    //         }

    //         return $rows;

	// }

	function get_all_chat_data()
	{        
        $query = "
            SELECT  a.fullname as from_user_name, b.fullname as to_user_name, a.avtar as userimg, chat.msg_id,chat.msg, 
			chat.msg_reply, chat.record_time, chat.status,chat.msg_emoji as emoji, outgoing_msg_id, incoming_msg_id, img_path  
            FROM chat 
            INNER JOIN user a 
            ON chat.incoming_msg_id = a.id 
            INNER JOIN user b 
            ON chat.outgoing_msg_id = b.id 
            WHERE (chat.incoming_msg_id = ? AND chat.outgoing_msg_id = ?) 
            OR (chat.incoming_msg_id = ? AND chat.outgoing_msg_id = ?)  
            ORDER BY chat.msg_id ASC";

            $statement = $this->connect->prepare($query);

            // Assuming $this->from_user_id and $this->to_user_id contain the relevant values
            $statement->bind_param('iiii', $this->incoming_msg_id, $this->outgoing_msg_id, $this->outgoing_msg_id, $this->incoming_msg_id);

            $statement->execute();

            $result = $statement->get_result();
            
            // Assuming you want to return an associative array with all the fetched rows
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;

	}
	// save chat function start here
	function save_chat()
	{
		if ($this->msg_reply!="") {
			$query = "
			INSERT INTO chat 
			(outgoing_msg_id, incoming_msg_id, msg, msg_reply, record_time, status) 
			VALUES (?, ?, ?, ?, ?, ?)
			";
		} 
		else 
			{
			if($this->img_path!="" && $this->msg!=""){
				$query = "
				INSERT INTO chat 
				(outgoing_msg_id, incoming_msg_id, msg, record_time, status, img_path) 
				VALUES (?, ?, ?, ?, ?, ?)
				";
			}
			else if($this->img_path!="" && $this->msg==""){
				$query = "
				INSERT INTO chat 
				(outgoing_msg_id, incoming_msg_id, record_time, status, img_path) 
				VALUES (?, ?, ?, ?, ?)
				";
			}
			else{
				$query = "
				INSERT INTO chat 
				(outgoing_msg_id, incoming_msg_id, msg, record_time, status) 
				VALUES (?, ?, ?, ?, ?)
				";
			}
	
		}
		
		

		$statement = $this->connect->prepare($query);
		if ($this->msg_reply!="") {

			$statement->bind_param('iissss', $this->outgoing_msg_id, $this->incoming_msg_id, $this->msg, $this->msg_reply, $this->record_time, $this->status);
		}
		else if($this->img_path!="" && $this->msg!=""){

			$statement->bind_param('iissss', $this->outgoing_msg_id, $this->incoming_msg_id, $this->msg, $this->record_time, $this->status,$this->img_path);
		}
		else if($this->img_path!="" && $this->msg==""){

			$statement->bind_param('iisss', $this->outgoing_msg_id, $this->incoming_msg_id, $this->record_time, $this->status, $this->img_path);
		} 
		else {
			$statement->bind_param('iisss', $this->outgoing_msg_id, $this->incoming_msg_id, $this->msg, $this->record_time, $this->status);
		}
		$statement->execute();

		// return $this->connect->insert_id;
		$insertedData = [
	        'outgoing_msg_id' => $this->outgoing_msg_id,
	        'incoming_msg_id' => $this->incoming_msg_id,
	        'msg' => $this->msg,
	        'msg_reply' => $this->msg_reply,
	        'record_time' => $this->record_time,
	        'status' => $this->status,
	        'img_path' => $this->img_path,
	    ];

    	return $insertedData;
	}

	// update chat status start here
	function update_chat_status()
	{
		$query = "
		UPDATE chat
		SET status = ? 
		WHERE msg_id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('si', $this->status, $this->msg_id);

		$statement->execute();
	}

	// get message reply function start here
	function get_reply_msg_data()
	{
		$query = "
			SELECT msg FROM chat 
			WHERE msg_id = ?
		";

		$statement = $this->connect->prepare($query);

		// Assuming $this->msg_id holds the value of msg_id you want to retrieve.
		$statement->bind_param('i', $this->msg_id);

		$statement->execute();

		// Check for errors
		if ($statement->error) {
			// Handle the error, such as logging or returning an error message.
			// For simplicity, we'll just print the error here.
			die('Error executing query: ' . $statement->error);
		}

		// Get the result
		$result = $statement->get_result();

		// Fetch the row as an associative array
		$row = $result->fetch_assoc();

		// Return the 'msg' column value from the fetched row
		return $row['msg'];
	}
	
	// change chat status start here
	function change_chat_status()
	{
		$query = "
			UPDATE chat 
			SET status = 'No' 
			WHERE incoming_msg_id = ? 
			AND outgoing_msg_id = ? 
			AND status = 'Yes'
		";

		$statement = $this->connect->prepare($query);

		// Assuming $this->from_user_id and $this->to_user_id contain the relevant values
		$statement->bind_param('ii', $this->incoming_msg_id, $this->outgoing_msg_id);

		$statement->execute();
	}

	// add emoji with message start here
	function insertemoji()
	{
		$query = "
		UPDATE chat
		SET msg_emoji = ? 
		WHERE msg_id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('si', $this->msg_emoji, $this->msg_id);

		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}
	}

	function get_notification(){

		$query ="SELECT user.id, user.fullname,user.avtar, chat.* 
		  FROM chat 
		  JOIN user ON user.id = chat.incoming_msg_id
		  WHERE outgoing_msg_id=? 
		  AND chat.status='Yes'
		  AND is_notify<>0
		  AND grpid='0'
		  ORDER BY record_time DESC LIMIT 1
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('i',$this->outgoing_msg_id);

		$statement->execute();

		$result = $statement->get_result();
            
        // Assuming you want to return an associative array with all the fetched rows
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;

	}

	function update_notification(){

		$query="UPDATE chat 
			set is_notify = '0' 
			where msg_id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('i',$this->msg_id);

		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}

	}

	function getGroupNotification(){

		// $query ="SELECT user.id, user.fullname,user.avtar, chat.*
		//   FROM chat 
		//   JOIN user ON user.id = chat.incoming_msg_id
		//   WHERE incoming_msg_id=?
		//   AND grpid=? 
		//   AND is_notify<>0
		//   ORDER BY record_time DESC LIMIT 1
		// ";

		$query ="SELECT user.id, user.fullname,user.avtar, chat.*
		  FROM chat 
		  JOIN user ON user.id = chat.incoming_msg_id
		  WHERE grpid<>0 
		  AND is_notify<>0
		  ORDER BY record_time DESC LIMIT 1
		";

		$statement = $this->connect->prepare($query);

		// $statement->bind_param('ii',$this->incoming_msg_id,$this->grpid);

		$statement->execute();

		$result = $statement->get_result();
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;

	}

}



?>