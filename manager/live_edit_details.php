<?php
	require_once('../connect_me.php');
	session_start();

    $uid = $_SESSION["user_data"]["id"];
    $fname = $_SESSION["user_data"]["fname"];
    $uname = $_SESSION["user_data"]["uname"];
    $type = $_SESSION["user_data"]["type"];


	$database_connection = new Database_connection();
	$connect = $database_connection->connect();
	$input = filter_input_array(INPUT_POST);
	$dtt = date('Y-m-d H:i:s');
	

	if (isset($input['action']) && $input['action'] == 'edit') {
	    $update_user_fields = [];
	    $id = $input['id'];

	    
	    // Check if a record exists in the checklist table for the given user_id
        $sql_check = "SELECT * FROM checklist WHERE user_id='$id'";
    	$result_check = mysqli_query($connect, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            // Update the existing record in checklist table
            $update_checklist_fields = [];
           	if (isset($input['fullname'])) {
	        $update_checklist_fields[] = "username='" . $input['fullname'] . "'";
		    }
		   	if (isset($input['pages'])) {
	        $update_checklist_fields[] = "pagename='" . $input['pages'] . "'";
		    }
			if(isset($input['status'])) {
				$update_checklist_fields[]= "status='".$input['status']."'";
			} 
			if(isset($input['pending_redeem'])) {
				$update_checklist_fields[]= "pending_redeems='".$input['pending_redeem']."'";
			}
			if(isset($input['pending_chats'])) {
				$update_checklist_fields[]= "pending_chats='".$input['pending_chats']."'";
			}
			if(isset($input['performance'])) {
				$update_checklist_fields[]= "performance='".$input['performance']."'";
			}
			if(isset($input['anydesk'])) {
				$update_checklist_fields[]= "anydesk='".$input['anydesk']."'";
			}
			if(isset($input['cashapp'])) {
				$update_checklist_fields[]= "cashapp_limits='".$input['cashapp']."'";
			}
			if(isset($input['cust_issues'])) {
				$update_checklist_fields[]= "customer_issue='".$input['cust_issues']."'";
			}
			if(isset($input['client'])) {
				$update_checklist_fields[]= "client='".$input['client']."'";
			}
			if(isset($input['requests'])) {
				$update_checklist_fields[]= "request='".$input['requests']."'";
			}
			if(isset($input['remarks'])) {
				$escaped_remarks = mysqli_real_escape_string($connect, $input['remarks']);

			    // Add escaped remarks to the update checklist fields array
			    $update_checklist_fields[] = "remarks='".$escaped_remarks."'";
			}
			if(isset($input['shift'])) {
				$update_checklist_fields[]= "shift='".$input['shift']."'";
			}
			
			$update_checklist_fields[]= "updated_at='".$dtt."'";
			
			
			$update_checklist_fields[]= "updated_by='".$fname."'";
			
            $update_checklist_fields_str = implode(',', $update_checklist_fields);

            $sql_update_checklist = "UPDATE checklist SET $update_checklist_fields_str WHERE user_id='$id'";
            mysqli_query($connect, $sql_update_checklist) or die("database error:". mysqli_error($connect));

            if (mysqli_affected_rows($connect) > 0) {
                echo "Checklist record updated successfully!";
            } 
            else {
                echo "Error updating checklist record: " . mysqli_error($connect);
            }

        } 
        else {
           $sql_insert_checklist = "INSERT INTO checklist (user_id, status, pending_redeems, pending_chats, performance, anydesk, cashapp_limits, customer_issue, client, request, shift, updated_at, updated_by) VALUES ('$id', '" . $input['status'] . "', '" . $input['pending_redeem'] . "', '" . $input['pending_chats'] . "', '" . $input['performance'] . "', '" . $input['anydesk'] . "', '" . $input['cashapp'] . "', '" . $input['cust_issues'] . "', '" . $input['client'] . "', '" . $input['requests'] . "', '" . $input['shift'] . "', '$dtt', '$fname')";
            mysqli_query($connect, $sql_insert_checklist) or die("database error:". mysqli_error($connect));

            if (mysqli_affected_rows($connect) > 0) {
                echo "Checklist record inserted successfully!";
            } else {
                echo "Error inserting checklist record: " . mysqli_error($connect);
            }
        }

	      
	    // }
	}

	// else if (isset($_POST['selectedPageId']) && $_POST['selectedPageId'] != '') {
	// 	// echo "<pre>";
	// 	// print_r($_POST);
	// 	// exit;
	//     $pageid = $_POST['selectedPageId'];
	//     $userid = $_POST['userId'];

	//     // Update the user table
	//     $sql_update_user = "UPDATE user SET pgid = ? WHERE id = ?";
	//     $stmt_update_user = mysqli_prepare($connect, $sql_update_user);
	//     mysqli_stmt_bind_param($stmt_update_user, "ss", $pageid, $userid);
	//     mysqli_stmt_execute($stmt_update_user);

	//     if (mysqli_stmt_affected_rows($stmt_update_user) > 0) {
	//         echo "User record updated successfully!";
	//     } else {
	//         echo "Error updating user record: " . mysqli_error($connect);
	//     }

	//     mysqli_stmt_close($stmt_update_user);

	//     // Check if a record exists in the checklist table for the given user_id
	//     $sql_check = "SELECT * FROM checklist WHERE user_id = ?";
	//     $stmt_check = mysqli_prepare($connect, $sql_check);
	//     mysqli_stmt_bind_param($stmt_check, "s", $userid);
	//     mysqli_stmt_execute($stmt_check);
	//     $result_check = mysqli_stmt_get_result($stmt_check);

	//     if (mysqli_num_rows($result_check) > 0) {
	//         // Update the existing record in checklist table
	//         $sql_update_checklist = "UPDATE checklist SET page_id = ? WHERE user_id = ?";
	//         $stmt_update_checklist = mysqli_prepare($connect, $sql_update_checklist);
	//         mysqli_stmt_bind_param($stmt_update_checklist, "ss", $pageid, $userid);
	//         mysqli_stmt_execute($stmt_update_checklist);

	//         if (mysqli_stmt_affected_rows($stmt_update_checklist) > 0) {
	//             echo "Checklist record updated successfully!";
	//         } else {
	//             echo "Error updating checklist record: " . mysqli_error($connect);
	//         }

	//         mysqli_stmt_close($stmt_update_checklist);
	//     } 
	//     else {
	//         // Insert a new record in checklist table
	//         $sql_insert_checklist = "INSERT INTO checklist (user_id, page_id) VALUES (?, ?)";
	//         $stmt_insert_checklist = mysqli_prepare($connect, $sql_insert_checklist);
	        
	//         // Bind parameters for inserting into checklist table
	//         mysqli_stmt_bind_param($stmt_insert_checklist, "ss", $userid, $pageid);
	        
	//         mysqli_stmt_execute($stmt_insert_checklist);

	//         if (mysqli_stmt_affected_rows($stmt_insert_checklist) > 0) {
	//             echo "Checklist record inserted successfully!";
	//         } else {
	//             echo "Error inserting checklist record: " . mysqli_error($connect);
	//         }

	//         mysqli_stmt_close($stmt_insert_checklist);
	//     }

	//     mysqli_stmt_close($stmt_check);
	// }


	// if (isset($input['action']) && $input['action'] == 'edit') {	
	// 	$update_field='';
	// 	if(isset($input['fullname'])) {
	// 		$update_field.= "fullname='".$input['fullname']."'";
	// 	} 
	// 	// else if(isset($input['shift'])) {
	// 	// 	$update_field.= "shift='".$input['shift']."'";
	// 	// } 
	// 	else if(isset($input['status'])) {
	// 		$update_field.= "status='".$input['status']."'";
	// 	} 
	// 	else if(isset($input['pending_redeem'])) {
	// 		$update_field.= "pending_redeems='".$input['pending_redeem']."'";
	// 	}
	// 	else if(isset($input['pending_chats'])) {
	// 		$update_field.= "pending_chats='".$input['pending_chats']."'";
	// 	}
	// 	else if(isset($input['performance'])) {
	// 		$update_field.= "performance='".$input['performance']."'";
	// 	}
	// 	else if(isset($input['anydesk'])) {
	// 		$update_field.= "anydesk='".$input['anydesk']."'";
	// 	}
	// 	else if(isset($input['cashapp'])) {
	// 		$update_field.= "cashapp_limits='".$input['cashapp']."'";
	// 	}
	// 	else if(isset($input['cust_issues'])) {
	// 		$update_field.= "customer_issue='".$input['cust_issues']."'";
	// 	}
	// 	else if(isset($input['client'])) {
	// 		$update_field.= "client='".$input['client']."'";
	// 	}
	// 	else if(isset($input['requests'])) {
	// 		$update_field.= "request='".$input['requests']."'";
	// 	}
	// 	else if(isset($input['remarks'])) {
	// 		$update_field.= "remarks='".$input['remarks']."'";
	// 	}
	// 	else if(isset($input['shift'])) {
	// 		$update_field.= "shift='".$input['shift']."'";
	// 	}
	// 	else if(isset($input['pending_redeem'])) {
	// 		$update_field.= "updated_at='".$input['pending_redeem']."'";
	// 	}
	// 	else if(isset($input['pending_redeem'])) {
	// 		$update_field.= "updated_by='".$input['pending_redeem']."'";
	// 	}	
	// 	if($update_field && $input['id']) {
	// 		$sql_query = "UPDATE user SET $update_field WHERE id='" . $input['id'] . "'";	
	// 		mysqli_query($connect, $sql_query) or die("database error:". mysqli_error($connect));	

	// 		// qyert for checklis table
	// 		$sql_query = "INSERT INTO checklist ('user_id','status','pending_redeems','pending_chats','performance','anydesk','cashapp_limits','customer_issue','client','request','shift','updated_at','updated_by') VALUES ()";	
	// 		mysqli_query($connect, $sql_query) or die("database error:". mysqli_error($connect));		
	// 	}
		
	// }

	// if(isset($_POST['selectedPageId']) && $_POST['selectedPageId']!=''){
	// 	// echo "<pre>";
	// 	// print_r($_POST);
	// 	// exit;
	// 	$pageid=$_POST['selectedPageId'];
	// 	$userid=$_POST['userId'];

	// 	$sql_query = "UPDATE user SET pgid='$pageid' WHERE id='$userid'";	
	// 	mysqli_query($connect, $sql_query) or die("database error:". mysqli_error($connect));

	// 	$sql_query = "UPDATE checklist SET page_id='$pageid' WHERE user_id='$userid'";	
	// 	mysqli_query($connect, $sql_query) or die("database error:". mysqli_error($connect));

	// }


