<?php

class GameInfo
{
	private $id;
	private $pg_id;
	private $g_name;
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
	
	function setPgId($pg_id)
	{
		$this->pg_id = $pg_id;
	}

	function getPgId()
	{
		return $this->pg_id;
	}

	function setStatus($status)
	{
		$this->status = $status;
	}

	function getStatus()
	{
		return $this->status;
	}

	function setGName($g_name)
	{
		$this->g_name = $g_name;
	}

	function getGName()
	{
		return $this->g_name;
	}

	
	function getGamesByPgid() {
	    $query = "
	    SELECT * FROM gameinfo
	    WHERE pg_id = ? 
	    AND status = 0 
	    ORDER BY g_name ASC
	    ";

	    $statement = $this->connect->prepare($query);
	    $statement->bind_param('i', $this->pg_id);

	    $games = [];

	    if ($statement->execute()) {
	        $result = $statement->get_result();
	        $games = $result->fetch_all(MYSQLI_ASSOC);  // Fetch as associative array
	    }

	    $statement->close();

	    return $games;  // Return the array of games
	}


	

}
?>