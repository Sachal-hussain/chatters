<?php

// $array = array(
//     "user_data" => array(
//         1 => array(
//             "id" => 1,
//             "fname" => "",
//             "uname" => "babagee",
//             "avtar" => "avatar-2.jpg",
//             "online" => "Login",
//             "token" => "928f65776ac38c9cd88b366ff465d8eb"
//         )
//     )
// );

// $uid = $array["user_data"][1]["id"];
// $fname = $array["user_data"][1]["fname"];
// $uname = $array["user_data"][1]["uname"];
// $avtar = $array["user_data"][1]["avtar"];
// $online = $array["user_data"][1]["online"];

//ChatUser.php

class ChatUser
{
	private $user_id;
	private $user_name;
	private $user_email;
	private $user_password;
	private $user_profile;
	private $user_status;
	private $user_created_on;
	private $user_verification_code;
	private $user_login_status;
	private $user_token;
	private $user_ip;
	private $contact;
	private $type;
	private $is_type;
	private $last_login;
	private $shift;


	public $connect;

	public function __construct()
	{
		require_once('connect_me.php');

		$database_object = new Database_connection;

		$this->connect = $database_object->connect();
	}

	function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	function getUserId()
	{
		return $this->user_id;
	}

	function setUserName($user_name)
	{
		$this->user_name = $user_name;
	}

	function getUserName()
	{
		return $this->user_name;
	}

	function setUserEmail($user_email)
	{
		$this->user_email = $user_email;
	}

	function getUserEmail()
	{
		return $this->user_email;
	}

	function setUserPassword($user_password)
	{
		$this->user_password = $user_password;
	}

	function getUserPassword()
	{
		return $this->user_password;
	}

	function setUserProfile($user_profile)
	{
		$this->user_profile = $user_profile;
	}

	function getUserProfile()
	{
		return $this->user_profile;
	}

	function setUserStatus($user_status)
	{
		$this->user_status = $user_status;
	}

	function getUserStatus()
	{
		return $this->user_status;
	}

	function setContact($contact)
	{
		$this->contact = $contact;
	}

	function getContact()
	{
		return $this->contact;
	}

	function setUserCreatedOn($user_created_on)
	{
		$this->user_created_on = $user_created_on;
	}

	function getUserCreatedOn()
	{
		return $this->user_created_on;
	}

	function setUserVerificationCode($user_verification_code)
	{
		$this->user_verification_code = $user_verification_code;
	}

	function getUserVerificationCode()
	{
		return $this->user_verification_code;
	}

	function setUserLoginStatus($user_login_status)
	{
		$this->user_login_status = $user_login_status;
	}

	function getUserLoginStatus()
	{
		return $this->user_login_status;
	}

	function setUserToken($user_token)
	{
		$this->user_token = $user_token;
	}

	function getUserToken()
	{
		return $this->user_token;
	}

	function setUserIp($user_ip)
	{
		$this->user_ip = $user_ip;
	}

	function getUserIp()
	{
		return $this->user_ip;
	}

	function setType($type)
	{
		$this->type = $type;
	}

	function getType()
	{
		return $this->type;
	}

	function setIsType($is_type)
	{
		$this->is_type = $is_type;
	}

	function getIsType()
	{
		return $this->is_type;
	}

	function setLastLogin($last_login)
	{
		$this->last_login = date('Y-m-d H:i:s');
	}

	function getLastLogin()
	{
		return $this->last_login;
	}

	function setShift($shift)
	{
		$this->shift = $shift;
	}

	function getShift()
	{
		return $this->shift;
	}

	function upload_profile($user_profile){

		$extension = explode('.', $user_profile['name']);
		
		$new_name = rand() . '.' . $extension[1];
		$destination = 'assets/images/users/' . $new_name;
		move_uploaded_file($user_profile['tmp_name'], $destination);
		return $new_name;

	}

	function get_typing_status($user_id){
		$output='';
		$query="

			SELECT is_type FROM user
			WHERE id = ?
			ORDER BY id DESC
			LIMIT 1
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('i', $user_id);

		
    if ($statement->execute()) {
      $result = $statement->get_result();
        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc(); 
          if($row['is_type']=='yes'){
	          $output ='
	          <div id="typing-indicator" class="typing-indicator">Typing
						<span class="animate-typing">
						<span class="dot"></span>
						<span class="dot"></span>
						<span class="dot"></span>
						</span>
						</div>' ; 
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

		$query = "
		UPDATE user
		SET is_type = ? 
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('si', $this->is_type, $this->user_id);

		$statement->execute();
	}
	// function make_avatar($character)
	// {
	//     $path = "images/". time() . ".png";
	// 	$image = imagecreate(200, 200);
	// 	$red = rand(0, 255);
	// 	$green = rand(0, 255);
	// 	$blue = rand(0, 255);
	//     imagecolorallocate($image, $red, $green, $blue);  
	//     $textcolor = imagecolorallocate($image, 255,255,255);

	//     $font = dirname(__FILE__) . '/font/arial.ttf';

	//     imagettftext($image, 100, 0, 55, 150, $textcolor, $font, $character);
	//     imagepng($image, $path);
	//     imagedestroy($image);
	//     return $path;
	// }

	// function get_user_data_by_email()
	// {
	// 	$query = "
	// 	SELECT * FROM user 
	// 	WHERE uname = :user_email
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bindParam(':user_email', $this->uname);

	// 	if($statement->execute())
	// 	{
	// 		$user_data = $statement->fetch(PDO::FETCH_ASSOC);
	// 	}
	// 	return $user_data;
	// }

    //////////////////////// Replaced above function /////////////////////////////
    function get_user_data_by_email()
	{
	    // Assuming $this->connect is the MySQLi connection object
	    $query = "
	    SELECT * FROM user 
	    WHERE uname = ?
	    ";
	    
	    $statement = $this->connect->prepare($query);
	    
	    // Assuming $this->uname is the parameter value
	    $statement->bind_param('s', $this->user_name);

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










    ////////////////////////////////////////////////////////////////////////////

	// function save_data()
	// {
	// 	$query = "
	// 	INSERT INTO chat_user_table (user_name, user_email, user_password, user_profile, user_status, user_created_on, user_verification_code) 
	// 	VALUES (:user_name, :user_email, :user_password, :user_profile, :user_status, :user_created_on, :user_verification_code)
	// 	";
	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bindParam(':user_name', $this->user_name);

	// 	$statement->bindParam(':user_email', $this->user_email);

	// 	$statement->bindParam(':user_password', $this->user_password);

	// 	$statement->bindParam(':user_profile', $this->user_profile);

	// 	$statement->bindParam(':user_status', $this->user_status);

	// 	$statement->bindParam(':user_created_on', $this->user_created_on);

	// 	$statement->bindParam(':user_verification_code', $this->user_verification_code);

	// 	if($statement->execute())
	// 	{
	// 		return true;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }

	// function is_valid_email_verification_code()
	// {
	// 	$query = "
	// 	SELECT * FROM chat_user_table 
	// 	WHERE user_verification_code = :user_verification_code
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bindParam(':user_verification_code', $this->user_verification_code);

	// 	$statement->execute();

	// 	if($statement->rowCount() > 0)
	// 	{
	// 		return true;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }

	// function enable_user_account()
	// {
	// 	$query = "
	// 	UPDATE chat_user_table 
	// 	SET user_status = :user_status 
	// 	WHERE user_verification_code = :user_verification_code
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bindParam(':user_status', $this->user_status);

	// 	$statement->bindParam(':user_verification_code', $this->user_verification_code);

	// 	if($statement->execute())
	// 	{
	// 		return true;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }

	function update_user_login_data()
	{
		
		$query = "
		UPDATE user 
		SET online = ?, user_token = ?, last_login=?, user_ip=?
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);
        // print_r($query);
       
		$statement->bind_param('ssssi', $this->user_login_status, $this->user_token,$this->last_login, $this->user_ip, $this->user_id);

		if($statement->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function get_user_data_by_id()
	{	
		$query = "
		SELECT * FROM user 
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);
		$statement->bind_param('i', $this->user_id);

		try {
			if ($statement->execute()) {
				$result = $statement->get_result();
				$user_data = $result->fetch_assoc();
			} else {
				$user_data = array();
			}
		} catch (Exception $error) {
			echo $error->getMessage();
		}

		return $user_data;
	}

	// function get_user_data_by_id()
	// {
	// 	$query = "
	// 	SELECT * FROM chat_user_table 
	// 	WHERE user_id = :user_id";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bindParam(':user_id', $this->user_id);

	// 	try
	// 	{
	// 		if($statement->execute())
	// 		{
	// 			$user_data = $statement->fetch(PDO::FETCH_ASSOC);
	// 		}
	// 		else
	// 		{
	// 			$user_data = array();
	// 		}
	// 	}
	// 	catch (Exception $error)
	// 	{
	// 		echo $error->getMessage();
	// 	}
	// 	return $user_data;
	// }

	// function upload_image($user_profile)
	// {
	// 	$extension = explode('.', $user_profile['name']);
	// 	$new_name = rand() . '.' . $extension[1];
	// 	$destination = 'images/' . $new_name;
	// 	move_uploaded_file($user_profile['tmp_name'], $destination);
	// 	return $destination;
	// }

	// function update_data()
	// {
	// 	$query = "
	// 	UPDATE chat_user_table 
	// 	SET user_name = :user_name, 
	// 	user_email = :user_email, 
	// 	user_password = :user_password, 
	// 	user_profile = :user_profile  
	// 	WHERE user_id = :user_id
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bindParam(':user_name', $this->user_name);

	// 	$statement->bindParam(':user_email', $this->user_email);

	// 	$statement->bindParam(':user_password', $this->user_password);

	// 	$statement->bindParam(':user_profile', $this->user_profile);

	// 	$statement->bindParam(':user_id', $this->user_id);

	// 	if($statement->execute())
	// 	{
	// 		return true;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }
	function update_data()
	{
	    $query = "UPDATE user 
            SET fullname = ?, 
              contact = ?,  
              avtar = ?,
              upass = ?  
            WHERE id = ?
        ";

	    $statement = $this->connect->prepare($query);

	    if (!$statement) {
	        return false; // Handle error
	    }

	    $statement->bind_param('ssssi', $this->user_name, $this->contact, $this->user_profile, $this->user_password, $this->user_id);

	    if ($statement->execute()) {
	        // Update was successful; now retrieve the updated data
	        $query = "SELECT * FROM user WHERE id = ?";
	        $selectStatement = $this->connect->prepare($query);
	        $selectStatement->bind_param('i', $this->user_id);
	        $selectStatement->execute();

	        $result = $selectStatement->get_result();
	        $updatedData = $result->fetch_assoc();
	        $selectStatement->close();

	        return $updatedData;
	    } else {
	        return false;
	    }
	}
	// function update_data()
	// {
		
	//     $query = "
	//     UPDATE user 
	//     SET fullname = ?, 
	//     contact = ?,  
	//     avtar = ?,
	//     upass=?  
	//     WHERE id = ?
	//     ";

	//     $statement = $this->connect->prepare($query);

	//     if (!$statement) {
	//         return false; // Handle error
	//     }

	//     $statement->bind_param('ssssi', $this->user_name, $this->contact,$this->user_profile,$this->user_password, $this->user_id);

	//     if ($statement->execute()) {
	//         return true;
	//     } else {
	//         return false;
	//     }
	// }	
	function get_user_all_data($uid)
	{
		$query="SELECT DISTINCT user.id, user.fullname, user.type, user.avtar, user.status, user.online,
		(
			SELECT COUNT(*) 
			FROM chat AS c 
			WHERE 
				(c.incoming_msg_id = user.id AND c.outgoing_msg_id = '$uid') 
				AND c.status = 'Yes'
		) AS unread_count, latest_message, latest_time
		FROM user
		JOIN (
			SELECT
	    latest_chats.latest_time,
	    latest_chats.other_user_id,
	    chat.msg AS latest_message
		FROM (
		    SELECT
		        CASE
		            WHEN incoming_msg_id = '$uid' THEN outgoing_msg_id
		            WHEN outgoing_msg_id = '$uid' THEN incoming_msg_id
		        END AS other_user_id,
		        MAX(record_time) AS latest_time
		    FROM chat
		    WHERE incoming_msg_id = '$uid' OR outgoing_msg_id = '$uid'
		    GROUP BY other_user_id
		) latest_chats
		JOIN chat ON (
		    (chat.incoming_msg_id = '$uid' AND chat.outgoing_msg_id = latest_chats.other_user_id) OR
		    (chat.outgoing_msg_id = '$uid' AND chat.incoming_msg_id = latest_chats.other_user_id)
		) AND chat.record_time = latest_chats.latest_time
		ORDER BY latest_chats.latest_time DESC
				) latest_chats ON user.id = latest_chats.other_user_id
				WHERE user.id != '$uid'
				ORDER BY latest_chats.latest_time DESC";
		
		$statement = $this->connect->prepare($query);
		
		if ($statement->execute()) {
			$result = $statement->get_result();
			$user_data = $result->fetch_all();
			
		} else {
			
			$user_data = array();
		}
		
		$statement->close();
		
		return $user_data;
		
	}
	
	// function get_user_all_data_with_status_count()
	// {
	// 	$query = "
	// 	SELECT user_id, user_name, user_profile, user_login_status, (SELECT COUNT(*) FROM chat_message WHERE to_user_id = :user_id AND from_user_id = chat_user_table.user_id AND status = 'No') AS count_status FROM chat_user_table
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bindParam(':user_id', $this->user_id);

	// 	$statement->execute();

	// 	$data = $statement->fetchAll(PDO::FETCH_ASSOC);

	// 	return $data;
	// }

	// function update_user_connection_id()
	// {
	// 	$query = "
	// 	UPDATE chat_user_table 
	// 	SET user_connection_id = :user_connection_id 
	// 	WHERE user_token = :user_token
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bind_Param(':user_connection_id', $this->user_connection_id);

	// 	$statement->bind_Param(':user_token', $this->user_token);

	// 	$statement->execute();
	// }
	function update_user_connection_id()
	{
		$query = "
		UPDATE user 
		SET user_connection_id = ? 
		WHERE user_token = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('ss', $this->user_connection_id, $this->user_token);

		$statement->execute();
	}
	
	function get_user_id_from_token()
	{
		$query = "
		SELECT id FROM user 
		WHERE user_token = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('s', $this->user_token);

		$statement->execute();

		$result = $statement->get_result();

		$user_id = null;

		if ($result && $result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$user_id = $row['id'];
		}

		return $user_id;
	}

	// function get_user_id_from_token()
	// {
	// 	$query = "
	// 	SELECT user_id FROM chat_user_table 
	// 	WHERE user_token = :user_token
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bindParam(':user_token', $this->user_token);

	// 	$statement->execute();

	// 	$user_id = $statement->fetch(PDO::FETCH_ASSOC);

	// 	return $user_id;
	// }

	function getUserList($department, $shift, $type)
{
    $user_data = array();

    $query = "
    SELECT user.id, agentid, fullname, uname, shift, department, status, user.pgid, pages.id as page_id, pages.pagename
    FROM user
    LEFT JOIN pages ON pages.id = user.pgid 
    WHERE user.status = 'Active' AND user.shift <> ''
    ";

    if ($type != 'Webmaster') {
        // If the logged-in user is not a webmaster, add conditions for department and shift
        $query .= " AND user.department = ? AND user.shift = ?";
    }

    $statement = $this->connect->prepare($query);

    try {
        if ($type != 'Webmaster') {
            // Bind parameters for the non-webmaster query
            $statement->bind_param('ss', $department, $shift);
        }

        if ($statement->execute()) {
            $result = $statement->get_result();

            // Fetch all rows as associative arrays
            while ($row = $result->fetch_assoc()) {
                $user_data[] = $row;
            }
        } else {
            // Print any error messages from the SQL execution
            echo 'Error: ' . $statement->error;
        }
    } catch (Exception $error) {
        // Handle any exceptions
        echo 'Exception: ' . $error->getMessage();
    }

    // Return array of user data
    return $user_data;
}




	function updateUserData() {
		
	    $query = "UPDATE user SET shift = ? WHERE id = ?";
	    $statement = $this->connect->prepare($query);
	    $statement->bind_param('si', $this->shift, $this->user_id);

	    try {
	      if ($statement->execute()) {
	          if ($statement->affected_rows > 0) {
	              return true;  
	          } else {
	              return false; 
	          }
	      } else {
	          return false; 
	      }
	    } 
	    catch (Exception $error) {
	        
	      echo $error->getMessage();
	      return false; 
	    }
	}

	


}



?>

