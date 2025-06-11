<?php 
	
class GroupEmojis
{

	private $id;
	private $msg_id;
	private $user_id;
	private $group_id;
	private $emoji;
	private $record_time;

	protected $connect;


	public function __construct()
	{
		require_once('connect_me.php');

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

	function setMsgId($msg_id)
	{
		$this->msg_id = $msg_id;
	}

	function getMsgId()
	{
		return $this->msg_id;
	}

	function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	function getUserId()
	{
		return $this->user_id;
	}

	function setGroupId($group_id)
	{
		$this->group_id = $group_id;
	}

	function getGroupId()
	{
		return $this->group_id;
	}

	function setEmoji($emoji)
	{
		$this->emoji = $emoji;
	}

	function getEmoji()
	{
		return $this->emoji;
	}

	function setRecordTime($record_time)
	{
		$this->record_time = date('Y-m-d H:i:s');
	}

	function getRecordTime()
	{
		return $this->record_time;
	}


	// add emoji with message start here
	function insertgroupemojis()
	{
		
		$record_time = date('Y-m-d H:i:s');
		$query="
		SELECT * FROM group_emojis 
		where user_id=? AND msg_id=? 
		LIMIT 1";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('ii', $this->user_id, $this->msg_id);

		$statement->execute();

		$result=$statement->get_result();

		if($result->num_rows >0){
			
			$query="UPDATE group_emojis 
				SET emoji=?,record_time=? 
				WHERE msg_id=? 
				AND group_id=?
				AND user_id=?
			";

			$statement = $this->connect->prepare($query);

			$statement->bind_param('ssiii', $this->emoji, $record_time, $this->msg_id, $this->group_id, $this->user_id);

			$statement->execute();	
		}	
		else
		{
		
			$query = "
				INSERT INTO group_emojis 
				(msg_id, user_id, group_id, emoji,record_time) 
				VALUES (?, ?, ?, ?, ?)
			";

			$statement = $this->connect->prepare($query);

			$statement->bind_param('iiiss', $this->msg_id, $this->user_id, $this->group_id, $this->emoji, $record_time);

			if($statement->execute()){

				return true;
			}
			else{

				return false;
			}
		}
	}

	// get group emojis count start here
	function getgroupemojiaccount(){

		$query="
			SELECT msg_id, COUNT(*) AS msg_id_count, emoji, 
			COUNT(*) AS emoji_count 
			FROM group_emojis 
			WHERE msg_id=? 
			GROUP BY msg_id, emoji
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('i', $this->msg_id);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $emoji_details = $result->fetch_all();
		}
		else
		{
			$emoji_details = array();
			
		}

		$statement->close();

		return $emoji_details;
	}
}