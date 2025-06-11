<?php

class Pages
{
	private $id;
	private $pagename;
	private $pageauth;
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

	function setPagename($pagename)
	{
		$this->pagename = $pagename;
	}

	function getPagename()
	{
		return $this->pagename;
	}

	function setPageauth($pageauth)
	{
		$this->pageauth = $pageauth;
	}

	function getPageauth()
	{
		return $this->pageauth;
	}

	function setStatus($status)
	{
		$this->status = $status;
	}

	function getStatus()
	{
		return $this->status;
	}

	function getPagesByIds($uid, $type)
	{
	    if ($type === 'Manager' || $type === 'Webmaster') {
	        // For Manager or Webmaster, show all pages
	        $query = "
	            SELECT 
	                pages.*, 
	                COUNT(redeem.id) AS pending_redeem_count
	            FROM 
	                pages
	            LEFT JOIN 
	                redeem ON pages.id = redeem.pg_id AND redeem.status = 'Pending' AND del='0'
	            WHERE 
	                pages.status = 'active'
	            GROUP BY 
	                pages.id, pages.pagename
	            ORDER BY 
	                pages.pagename ASC;
	        ";
	    } 
	    else {
	        // For other user types, show only assigned pages
	        $query = "
	            SELECT 
	                pages.*, 
	                COUNT(redeem.id) AS pending_redeem_count
	            FROM 
	                pages
	            LEFT JOIN 
	                redeem ON pages.id = redeem.pg_id AND redeem.status = 'Pending' AND del='0'
	            JOIN 
	                user ON FIND_IN_SET(pages.id, user.pgid) AND user.id = $uid
	            WHERE 
	                pages.status = 'active'
	            GROUP BY 
	                pages.id, pages.pagename
	            ORDER BY 
	                pages.pagename ASC;
	        ";
	    }

	    $statement = $this->connect->prepare($query);

	    if (!$statement) {
	        die('Error in SQL query: ' . $this->connect->error);
	    }

	    if ($statement->execute()) {
	        $result = $statement->get_result();
	        $pages = $result->fetch_all(MYSQLI_ASSOC);
	    } else {
	        die('Error in execute: ' . $statement->error);
	    }

	    $statement->close();

	    return $pages;
	}



	function get_all_pages()
	{
		// $query = "
		// SELECT * from pages	
		// WHERE status='active'	
		// ORDER BY pagename ASC
		// ";

		$query="
			SELECT 
	        pages.*, 
	        COUNT(redeem.id) AS pending_redeem_count
		    FROM 
		        pages
		    LEFT JOIN 
		        redeem ON pages.id = redeem.pg_id AND redeem.status = 'Pending' AND del='0'
		    WHERE 
		        pages.status = 'active'
		    GROUP BY 
		        pages.id, pages.pagename
		    ORDER BY 
		        pages.pagename ASC;
		";


		$statement = $this->connect->prepare($query);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $pages = $result->fetch_all();
		}
		else
		{
			$pages = array();
			
		}

		$statement->close();

		return $pages;
	}

	function getPagesReport()
	{
		$query = "
		SELECT * from pages	
		WHERE status='active'	
		ORDER BY pagename ASC
		";

		$statement = $this->connect->prepare($query);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $pages = $result->fetch_all();
		}
		else
		{
			$pages = array();
			
		}

		$statement->close();

		return $pages;
	}

	function getRemainingRedeemCount(){
	    $query = 'SELECT COUNT(*) AS remaining_count
	              FROM redeem
	              WHERE status = ? AND del = ?';

	    $status = 'Pending';
	    $del = 0;

	    $statement = $this->connect->prepare($query);
	    $statement->bind_param('si', $status, $del);

	    $remainingCount = 0; // Initialize the variable

	    if($statement->execute()) {
	        $result = $statement->get_result();
	        $row = $result->fetch_assoc();
	        $remainingCount = $row['remaining_count'];
	    }

	    $statement->close();

	    return $remainingCount;
	}
}
?>