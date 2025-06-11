<?php 
	
class ChatRooms
{
	private $chat_id;
	private $user_id;
	private $message;
	private $created_on;
	protected $connect;


	public function setChatId($chat_id)
	{
		$this->chat_id = $chat_id;
	}

	function getChatId()
	{
		return $this->chat_id;
	}

	function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	function getUserId()
	{
		return $this->user_id;
	}

	function setMessage($message)
	{
		$this->message = $message;
	}

	function getMessage()
	{
		return $this->message;
	}

	function setCreatedOn($created_on)
	{
		$this->created_on = $created_on;
	}

	function getCreatedOn()
	{
		return $this->created_on;
	}

	public function __construct()
	{
		require_once("connect_me.php");

		$database_object = new Database_connection;

		$this->connect = $database_object->connect();
	}

    function save_chat()
    {
        $query = "
        INSERT INTO chatrooms 
            (userid, msg, created_on) 
            VALUES (?, ?, ?)
        ";

        $statement = $this->connect->prepare($query);

        $statement->bind_param('iss', $this->user_id, $this->message, $this->created_on);

        $statement->execute();
    }

	// function save_chat()
	// {
	// 	$query = "
	// 	INSERT INTO chatrooms 
	// 		(userid, msg, created_on) 
	// 		VALUES (:userid, :msg, :created_on)
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bindParam(':userid', $this->user_id);

	// 	$statement->bindParam(':msg', $this->message);

	// 	$statement->bindParam(':created_on', $this->created_on);

	// 	$statement->execute();
	// }

	// function get_all_chat_data()
	// {
	// 	$query = "
	// 	SELECT * FROM chatrooms 
	// 		INNER JOIN chat_user_table 
	// 		ON chat_user_table.user_id = chatrooms.userid 
	// 		ORDER BY chatrooms.id ASC
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->execute();

	// 	return $statement->fetchAll(PDO::FETCH_ASSOC);
	// }


    function get_all_chat_groups($uid, $type)
    {
        // if ($type=='Webmaster' && $type=='Manager') {
        //     $query = "
		//     SELECT * FROM chatgroups WHERE status='active' ORDER BY groupname ASC
		// ";
        // } else {
        //     $query = "
		//     SELECT chatgroups.*, groupusers.grpid, groupusers.userid, groupusers.status
        //     FROM chatgroups
        //     INNER JOIN groupusers ON chatgroups.id = groupusers.grpid
        //     LEFT JOIN (
        //         SELECT grpid, MAX(record_time) AS latest_time
        //         FROM chat
        //         GROUP BY grpid
        //     ) AS latest ON chatgroups.id = latest.grpid
        //     WHERE groupusers.status = 'active' AND groupusers.userid = '$uid'
        //     ORDER BY CASE WHEN latest.latest_time IS NULL THEN 1 ELSE 0 END, COALESCE(latest.latest_time) DESC
		// ";
        // }

        if ($type=='Webmaster' || $type=='Manager') {
            // $query = "
            // SELECT * FROM chatgroups WHERE status='active' ORDER BY groupname ASC";
            $query = "SELECT cg.*, gu.grpid, gu.userid, gu.status,
            IFNULL(last_msg.msg, '') AS last_message_content,
            IFNULL(last_msg.record_time, '') AS last_message_time
            FROM chatgroups cg
            INNER JOIN groupusers gu ON cg.id = gu.grpid
            LEFT JOIN (
                SELECT c.grpid, c.msg, c.record_time
                FROM chat c
                INNER JOIN (
                    SELECT grpid, MAX(record_time) AS max_record_time
                    FROM chat
                    GROUP BY grpid
                ) max_time ON c.grpid = max_time.grpid AND c.record_time = max_time.max_record_time
            ) last_msg ON cg.id = last_msg.grpid
            WHERE gu.status = 'active'   GROUP BY gu.grpid
            ORDER BY last_msg.record_time DESC, cg.groupname ASC";
        }
        else{

            $query = "SELECT cg.*, gu.grpid, gu.userid, gu.status,
            IFNULL(last_msg.msg, '') AS last_message_content,
            IFNULL(last_msg.record_time, '') AS last_message_time
            FROM chatgroups cg
            INNER JOIN groupusers gu ON cg.id = gu.grpid
            LEFT JOIN (
                SELECT c.grpid, c.msg, c.record_time
                FROM chat c
                INNER JOIN (
                    SELECT grpid, MAX(record_time) AS max_record_time
                    FROM chat
                    GROUP BY grpid
                ) max_time ON c.grpid = max_time.grpid AND c.record_time = max_time.max_record_time
            ) last_msg ON cg.id = last_msg.grpid
            WHERE gu.status = 'active' AND gu.userid = '$uid'  
            ORDER BY last_msg.record_time DESC, cg.groupname ASC";
        }
        

		$statement = $this->connect->prepare($query);

		if ($statement->execute()) {
            $result = $statement->get_result();
            $group_data = $result->fetch_all();
            // print_r($user_data);
        } else {
            // Handle query execution error if needed
            // For simplicity, let's return an empty array in case of failure
            $group_data = array();
        }
        
        $statement->close();
        
        return $group_data;
        
    }

    function capitalizeFirstLetter($str) {
        // Get the first character of the string
        $firstLetter = substr($str, 0, 1);
    
        // Convert the first character to uppercase
        $capitalLetter = strtoupper($firstLetter);
    
        return $capitalLetter;
    }

    // function setUser_Id($user_id)
	// {
	// 	$this->user_id = $user_id;
	// }

    function get_online_user()
    {
        $query = "
		    SELECT * FROM `user` WHERE id<> ? AND online='Login' AND status='Active' AND type<>'Client'
             ORDER BY `last_login` ASC LIMIT 5";

		$statement = $this->connect->prepare($query);
        $statement->bind_param('s', $this->user_id);
		if ($statement->execute()) {
            $result = $statement->get_result();
            $online_user = $result->fetch_all();
            // print_r($user_data);
        } else {
            // Handle query execution error if needed
            // For simplicity, let's return an empty array in case of failure
            $online_user = array();
        }
        
        $statement->close();
        
        return $online_user;
        
    }

    function displayAgentsAlphabetically() {
       
        $query = "SELECT fullname FROM user  where type <>'Client' AND status='Active' ORDER BY  fullname ASC";
        $result = $this->connect->query($query);
        // print_r($result);
        if ($result->num_rows > 0) {
            $agents = array();

            // Group names by their first letter
            while ($row = $result->fetch_assoc()) {
                $firstLetter = strtoupper(substr($row['fullname'], 0, 1));
                $agents[$firstLetter][] = $row['fullname'];
            }

            // Sort the names within each group
            foreach ($agents as $letter => $names) {
                sort($agents[$letter]);
            }

            // Display the sorted names under each letter
            foreach ($agents as $letter => $names) {
                echo '<div class="p-3 fw-bold text-primary">'.$letter.'</div>';
                echo '<ul class="list-unstyled contact-list" id="agent_list">';
                foreach ($names as $name) {
                    $user_id = $this->getUserIDByName($name);
                    echo '<li>
                    <div class="d-flex align-items-center select_user" data-id="'.$user_id['id'].'" data-name="'.$user_id['fullname'].'" data-profile="assets/images/users/'.$user_id['avtar'].'">
                        <div class="flex-grow-1">
                            <h5 class="font-size-14 m-0">'.$name.'</h5>
                        </div>
                        <div class="dropdown">
                            <a href="#" class="text-muted dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Share <i class="ri-share-line float-end text-muted"></i></a>
                                <a class="dropdown-item" href="#">Block <i class="ri-forbid-line float-end text-muted"></i></a>
                                <a class="dropdown-item" href="#">Remove <i class="ri-delete-bin-line float-end text-muted"></i></a>
                            </div>
                        </div>
                    </div>
                </li>';
                }
                echo "</ul>";
            }
        } else {
            echo "No agents found.";
        }

        // $this->connect->close();
    }

    public function getUserIDByName($name) {
        $query = "SELECT * FROM user  
        where fullname = '$name'
        AND
        type <>'Client' 
        AND 
        status='Active' 
        ORDER BY  fullname ASC";

        $statement = $this->connect->prepare($query);
            
        // Assuming $this->uname is the parameter value
        // $statement->bind_param('s', $name);

        if ($statement->execute()) {
            $result = $statement->get_result();
            $user_data = $result->fetch_assoc();
            // print_r($user_data);
        } else {
            // Handle query execution error if needed
            // For simplicity, let's return an empty array in case of failure
            $user_data = array();
        }

        $statement->close();

        return $user_data;
    }


    // group chat area to add members in the group contact list
    function getmemberAlphabetically() {
       
        $query = "SELECT fullname FROM user  where type <>'Client' AND status='Active' ORDER BY  fullname ASC";
        $result = $this->connect->query($query);
        // print_r($result);
        if ($result->num_rows > 0) {
            $agents = array();

            // Group names by their first letter
            while ($row = $result->fetch_assoc()) {
                $firstLetter = strtoupper(substr($row['fullname'], 0, 1));
                $agents[$firstLetter][] = $row['fullname'];
            }

            // Sort the names within each group
            foreach ($agents as $letter => $names) {
                sort($agents[$letter]);
            }

            // Display the sorted names under each letter
            foreach ($agents as $letter => $names) {
                echo '<div class="p-3 fw-bold text-primary">'.$letter.'</div>';
                echo '<ul class="list-unstyled contact-list" id="member_list">';
                foreach ($names as $name) {
                    $user_id = $this->getUserID_ByName($name);
                    echo '
                        <li>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input cb_groupadduser" data-name="'.$user_id['fullname'].'" data-id="'.$user_id['id'].'" name="add_members[]" value="'.$user_id['id'].'">
                                <label class="form-check-label" for="name">'.$name.'</label>
                            </div>
                        </li>';
                }
                echo "</ul>";
            }
        } else {
            echo "No agents found.";
        }

        // $this->connect->close();
    }
    
    public function getUserID_ByName($name) {
        $query = "SELECT * FROM user  
        where fullname = '$name'
        AND
        type <>'Client' 
        AND 
        status='Active' 
        ORDER BY  fullname ASC";

        $statement = $this->connect->prepare($query);
            
        // Assuming $this->uname is the parameter value
        // $statement->bind_param('s', $name);

        if ($statement->execute()) {
            $result = $statement->get_result();
            $user_data = $result->fetch_assoc();
            // print_r($user_data);
        } else {
            // Handle query execution error if needed
            // For simplicity, let's return an empty array in case of failure
            $user_data = array();
        }

        $statement->close();

        return $user_data;
    }

    public function group_unseen_message($grpid, $uid)
    {
        $query = "SELECT * FROM groupusers
                  WHERE userid = ? 
                  AND grpid = ?";
        
        $statement = $this->connect->prepare($query);
        $statement->bind_param('ii', $uid, $grpid);
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result->num_rows > 0) {
            $output = '';
            
            while ($row = $result->fetch_assoc()) {

                $last_seen_msg = $row['record_time'];
                
                if ($row['is_seen'] == 1) {
                    $inner_grpid = $grpid; // Use a different variable name
                    $query = "SELECT COUNT(*) as unseen_count FROM chat
                              WHERE grpid = ? AND record_time > ?";
                                  
                    $stmt = $this->connect->prepare($query);
                    $stmt->bind_param('is', $inner_grpid, $last_seen_msg);
                    $stmt->execute();
                    
                    $stmt->bind_result($count_msg);
                    
                    if ($stmt->fetch() && $count_msg > 0) {
                        $output = $count_msg;
                    } else {
                        $output = '';
                    }
                    
                    $stmt->close();
                }
            }
            
            // $result->free();
            
            return $output;
        }
    }


}
	
