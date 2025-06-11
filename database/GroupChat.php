<?php

//PrivateChat.php

class GroupChat
{
	private $msg_id;
	private $grpid;
	private $incoming_msg_id;
	private $outgoing_msg_id;
	private $msg;
	private $msg_reply;
	private $msg_emoji;
	private $status;
	private $record_time;
	private $img_path;
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

    function setGroupId($grpid)
	{
		$this->grpid = $grpid;
	}

	function getGroupId()
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

    function setEmojiMsg($msg_emoji)
	{
		$this->msg_emoji = $msg_emoji;
	}

	function getEmojiMsg()
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

	function get_group_chat_data()
	{        
        $query = "
            SELECT  chat.*,user.avtar,user.fullname,group_emojis.emoji as grp_emoji
            From chat
            LEFT JOIN user ON
            user.id=chat.incoming_msg_id
            LEFT JOIN group_emojis ON
            chat.msg_id=group_emojis.msg_id
            WHERE chat.grpid = ?
            AND chat.outgoing_msg_id = '0'
            GROUP BY chat.msg_id
            ORDER BY chat.record_time DESC
           
            ";

            $statement = $this->connect->prepare($query);

            // Assuming $this->from_user_id and $this->to_user_id contain the relevant values
            $statement->bind_param('i', $this->grpid);

            $statement->execute();

            $result = $statement->get_result();
            
            // Assuming you want to return an associative array with all the fetched rows
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            return $rows;

	}
	// function get_group_chat_data($offset=0,$limit=0)
	// {        
    //     $query = "
    //         SELECT  chat.*,user.avtar,user.fullname,group_emojis.emoji as grp_emoji
    //         From chat
    //         LEFT JOIN user ON
    //         user.id=chat.incoming_msg_id
    //         LEFT JOIN group_emojis ON
    //         chat.msg_id=group_emojis.msg_id
    //         WHERE chat.grpid = ?
    //         AND chat.outgoing_msg_id = '0'
    //         GROUP BY chat.msg_id
    //         ORDER BY chat.record_time DESC
    //         LIMIT ? OFFSET ?
    //         ";

    //         $statement = $this->connect->prepare($query);

    //         // Assuming $this->from_user_id and $this->to_user_id contain the relevant values
    //         $statement->bind_param('iii', $this->grpid,$limit, $offset);

    //         $statement->execute();

    //         $result = $statement->get_result();
            
    //         // Assuming you want to return an associative array with all the fetched rows
    //         $rows = array();
    //         while ($row = $result->fetch_assoc()) {
    //             $rows[] = $row;
    //         }

    //         return $rows;

	// }

	// function get_group_chat_data()
	// {        
    //     $query = "
    //         SELECT  chat.*,user.avtar,user.fullname,group_emojis.emoji as grp_emoji
    //         From chat
    //         LEFT JOIN user ON
    //         user.id=chat.incoming_msg_id
    //         LEFT JOIN group_emojis ON
    //         chat.msg_id=group_emojis.msg_id
    //         WHERE chat.grpid = ?
    //         AND chat.outgoing_msg_id = '0'
    //         GROUP BY chat.msg_id
    //         ORDER BY chat.record_time ASC";

    //         $statement = $this->connect->prepare($query);

    //         // Assuming $this->from_user_id and $this->to_user_id contain the relevant values
    //         $statement->bind_param('i', $this->grpid);

    //         $statement->execute();

    //         $result = $statement->get_result();
            
    //         // Assuming you want to return an associative array with all the fetched rows
    //         $rows = array();
    //         while ($row = $result->fetch_assoc()) {
    //             $rows[] = $row;
    //         }

    //         return $rows;

	// }

	function save_chat()
	{
		if ($this->msg_reply!="") {
			$query = "
			INSERT INTO chat 
			(grpid, incoming_msg_id, msg, msg_reply, record_time) 
			VALUES (?, ?, ?, ?, ?)
			";
		} 
		else 
			{
			if($this->img_path!="" && $this->msg!=""){
				$query = "
				INSERT INTO chat 
				(grpid, incoming_msg_id, msg, record_time, img_path) 
				VALUES (?, ?, ?, ?, ?)
				";
			}
			else if($this->img_path!="" && $this->msg==""){
				$query = "
				INSERT INTO chat 
				(grpid, incoming_msg_id, record_time, img_path) 
				VALUES (?, ?, ?, ?)
				";
			}
			else{
				$query = "
				INSERT INTO chat 
				(grpid, incoming_msg_id, msg, record_time) 
				VALUES (?, ?, ?, ?)
				";
			}
	
		}
		
		// $query = "
		// 	INSERT INTO chat 
		// 	(grpid, incoming_msg_id, msg, record_time) 
		// 	VALUES (?, ?, ?, ?)
		// 	";
		$statement = $this->connect->prepare($query);
		// $statement->bind_param('iiss', $this->grpid, $this->incoming_msg_id, $this->msg, $this->record_time);
		if ($this->msg_reply!="") {

			$statement->bind_param('iisss', $this->grpid, $this->incoming_msg_id, $this->msg, $this->msg_reply, $this->record_time);
		}
		else if($this->img_path!="" && $this->msg!=""){

			$statement->bind_param('iisss', $this->grpid, $this->incoming_msg_id, $this->msg, $this->record_time,$this->img_path);
		}
		else if($this->img_path!="" && $this->msg==""){

			$statement->bind_param('iiss', $this->grpid, $this->incoming_msg_id, $this->record_time,$this->img_path);
		} 
		else {
			$statement->bind_param('iiss', $this->grpid, $this->incoming_msg_id, $this->msg, $this->record_time);
		}
		$statement->execute();

		$insertedId= $this->connect->insert_id;

		$insertedData = [
	        'grpid' => $this->grpid,
	        'incoming_msg_id' => $this->incoming_msg_id,
	        'msg' => $this->msg,
	        'msg_reply' => $this->msg_reply,
	        'record_time' => $this->record_time,
	        'img_path' => $this->img_path,
	        'inserted_id' => $insertedId,
	    ];

	    return $insertedData;
	}

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

	// function get_reply_msg_data()
	// {
	// 	$query = "
	// 		SELECT msg FROM chat 
	// 		WHERE msg_id = ?
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	// Assuming $this->msg_id holds the value of msg_id you want to retrieve.
	// 	$statement->bind_param('i', $this->msg_id);

	// 	$statement->execute();

	// 	// Check for errors
	// 	if ($statement->error) {
	// 		// Handle the error, such as logging or returning an error message.
	// 		// For simplicity, we'll just print the error here.
	// 		die('Error executing query: ' . $statement->error);
	// 	}

	// 	// Get the result
	// 	$result = $statement->get_result();

	// 	// Fetch the row as an associative array
	// 	$row = $result->fetch_assoc();

	// 	// Return the 'msg' column value from the fetched row
	// 	return $row['msg'];
	// }
	
	function change_chat_status()
	{
		$query = "
			UPDATE chat 
			SET status = 'No' 
			WHERE incoming_msg_id = ? 
			AND grpid = ? 
			AND status = 'Yes'
		";

		$statement = $this->connect->prepare($query);

		// Assuming $this->from_user_id and $this->to_user_id contain the relevant values
		$statement->bind_param('ii', $this->incoming_msg_id, $this->grpid);

		$statement->execute();
	}



}



?>