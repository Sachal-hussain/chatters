<?php

//action.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// get private chat between users start action here
if(isset($_POST["action"]) && $_POST["action"] == 'fetch_chat')
{
	require 'database/PrivateChat.php';

	$private_chat_object = new PrivateChat;

	$private_chat_object->setIncomingMsgId($_POST["to_user_id"]);

	$private_chat_object->setOutGoingMsgId($_POST["from_user_id"]);

	$private_chat_object->change_chat_status();

	// $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

	// $limit = isset($_POST['limit']) ? intval($_POST['limit']) : 0;
	
	// echo json_encode($private_chat_object->get_all_chat_data($offset,$limit));	
	echo json_encode($private_chat_object->get_all_chat_data());	

}

// get message reply message start action here
if(isset($_POST['action']) && $_POST['action'] == 'get_replymsg')
{
	require 'database/PrivateChat.php';

	$private_chat_object = new PrivateChat;

	$private_chat_object->setMsgId($_POST["msg_id"]);

	echo json_encode($private_chat_object->get_reply_msg_data());
	// echo '<pre>'; 
    // print_r($private_chat_object->get_reply_msg_data());
    // exit();
}


// get group chat start action here
if(isset($_POST["action"]) && $_POST["action"] == 'fetch_groupchat')
{
	
	require 'database/GroupChat.php';
	require 'database/GroupUsers.php';

	

	$grp_users = new GroupUsers;

	// $grp_users->setUserid($_POST["from_user_id"]);

	// $grp_users->setGrpid($_POST["group_id"]);

	// $grp_users->setRecordTime($record_time);


	$grp_users->update_is_seen_status($_POST["from_user_id"],$_POST["group_id"]);


	$group_chat_object = new GroupChat;

	//group_id : from_user_id

	$group_chat_object->setGroupId($_POST["group_id"]);

	$group_chat_object->setIncomingMsgId($_POST["from_user_id"]);

	$group_chat_object->change_chat_status(); //Change it later once chat retrieved
	
	
	echo json_encode($group_chat_object->get_group_chat_data());	

	// echo '<pre>';
	// print_r($group_chat_object->get_group_chat_data());
	// exit();
}


// get group users start action here
if(isset($_POST['action']) && $_POST['action'] == 'group_users' ){

	$output='';
	$output1='';
	require 'database/GroupUsers.php';

	$group_users = new GroupUsers;

	$group_users->setGrpid($_POST['grpid']);

	$groups_data=$group_users->get_group_users();
	// echo "<pre>";
	// print_r($groups_data[0][0]);
	// // exit;
	$group_admin=$group_users->get_group_admin($groups_data[0][1]);
	// echo "<pre>";
	// print_r($group_admin);
	// exit;
	$admin_names = [];

	foreach ($group_admin as $key => $admin) {
	// $admin_names=explode(",", $admin[8]);
		$admin_names = array_merge($admin_names, explode(",", $admin[8]));
	
	}
	

	

	foreach($groups_data as $data){
		
		$user_name=$data[9];
		if(in_array($user_name, $admin_names)){

			$admin_status='Group Admin';
			$output.='<div class="mt-4">
                <h5 class="font-size-14" data-id="'.$data[7].'" data-uname="'.$data[9].'">'.$data[8].' 
                <span class="grp_user float-end" data-id="'.$data[7].'" style="cursor: pointer;"><i class="ri-close-line"></i></span><span class="float-end" style="color:#7269ef;">'.$admin_status.'</span></h5>
            </div>';
		}else{
			$output.='<div class="mt-4">
                <h5 class="font-size-14" data-id="'.$data[7].'">'.$data[8].'
                <span class="grp_user" data-id="'.$data[7].'" style="float: right;cursor: pointer;"><i class="ri-close-line"></i></span><i data-id="'.$data[1].'" data-uname="'.$data[9].'" style="cursor: pointer;" class="ri-user-2-line me-2 ms-0 align-middle d-inline-block float-end add_admins" title="Create Admin"></i></h5>

            </div>';
		}
	}


	$output1.='<form method="post"><ul class="list-unstyled contact-list">';

	$all_users=$group_users->get_all_users();
	
	if(isset($_SESSION["user_data"]["type"]) && $_SESSION["user_data"]["type"]=='Webmaster'){
		foreach($all_users as $users){
			
			$output1.='<li>
	                        <div class="form-check">
	                            <input type="checkbox" class="form-check-input cb_adduser" value="'.$users[0].'" name="cb_adduser[]">
	                            <label class="form-check-label" for="memberCheck1">'.$users[1].'</label>
	                        </div>
	                    </li>';
		}

		$output1.='</ul><button type="button" class="btn btn-primary" id="btn_adduser_togroup">Add</button></form>';
	}else{

		$output1='No Members Found !';
	}
	
	echo $output.'|'.$output1;
	// print_r($data);

	// echo '<pre>';
	// exit();

}

// remove user from group start action here
if(isset($_POST['action']) && $_POST['action'] == 'remove_users' ){

	require 'database/GroupUsers.php';

	$remove_users = new GroupUsers;

	// $remove_users->setUserid($_POST['user_id']);

	$type= $_SESSION["user_data"]["type"];

	$result=$remove_users->remove_users($_POST['user_id'],$type);

	if($result=='success'){

		echo "User has been deleted successfully!";
	}
	else{
		echo "Admin can delete the user !";
	}
}

// add users into group start action here
if (isset($_POST['insert']) && $_POST['insert']!="" && $_POST['grpid']!="") {

	require 'database/GroupUsers.php';

	$object = new GroupUsers;

    $insert = $_POST['insert'];
    $grpid  = $_POST['grpid']; 
 

    $result=$object->add_usertogroup($insert,$grpid);
    
    if($result=='success'){

		echo "User has been added successfully!";
	}
	else{
		echo "something is wrong!";
	}
      
} 

// create new group start action here
if (isset($_POST['addgroup_name'])  && $_POST['addgroup_name']!="") {

	// echo "here";
	// print_r($_POST['add_members']);
	// exit;
	require 'database/ChatGroups.php';

	$object = new ChatGroups;

	$group_profile='noimage.png';

	if($_FILES['group_profile']['name'] != '')
    {
        $group_profile = $object->upload_image($_FILES['group_profile']);
       
    }

	$name=$_POST['addgroup_name'];
	

	$created_by=$_SESSION["user_data"]["uname"];

	$permission='general';

	$status='active';

	$record_time  = date('Y-m-d H:i:s');

	$object->setGroupname($name);

	$object->setPermission($permission);

	$object->setStatus($status);

	$object->setImg($group_profile);

	$object->setCreateBy($created_by);
	
	$object->setChangeby($created_by);

	$object->setAdmins($created_by);

	$object->setRecortTime($record_time);

	$grpid=$object->createnewgroup();

	if($grpid=='Error'){
		echo "Group name already exists.";
		exit;
	}
	else{
		require 'database/GroupUsers.php';

		$object = new GroupUsers;

		if(isset($_POST['add_members'])){

			$insert = $_POST['add_members'];


			$output=$object->addusertogroupaftercreating($insert,$grpid);
			// print_r($output);
			// exit;
			if($output=='success'){

			echo "Group has been Created successfully!";
			
			}
		}
		
	}
}

// edit group details start action here
if(isset($_POST['editaddgroup_name']) && $_POST['editaddgroup_name']!='' ){

	require 'database/ChatGroups.php';

	$object = new ChatGroups;

	$group_profile=$_POST['oldgroupprofile'];

	if($_FILES['editgroup_profile']['name'] != '')
    {
        $group_profile = $object->upload_image($_FILES['editgroup_profile']);
       
    }

    $created_by=$_SESSION["user_data"]["uname"];

    $object->setId($_POST['groupid']);

	$object->setGroupname($_POST['editaddgroup_name']);

	$object->setImg($group_profile);

	$object->setCreateBy($created_by);
	
	$object->setChangeby($created_by);

	$grpid=$object->updategroupdetails();

	if($grpid){


		echo $group_profile.'|'.$_POST['editaddgroup_name'];
	}
	else{

		echo "Something is wrong !";
	}
}

// tag to user and get group users start action here
if(isset($_POST['type']) && $_POST['input']!='' && $_POST['type']=="tag_user"){

	$uid= $_SESSION["user_data"]["id"];

	$user_list='';

	require 'database/GroupUsers.php';

	$object = new GroupUsers;

	// $object->setGrpid($_POST['grpid']);

	$result=$object->gettagusers($_POST['grpid'],$_POST['input'],$uid);

	foreach ($result as $key => $value) {
		
	$user_list.='<li class="userlistarea" id="userlistarea" style="list-style:none;cursor:pointer;" data-id="'.$value[7].'">'.$value[8].'</li>';
	}

	echo $user_list;
	// echo $result;

	// echo "<pre>";
	// print_r($result);
	// exit;
}

// insert emoji with message start action here
if(isset($_POST['emoji']) && $_POST['msgid']!=''){

	
	require 'database/PrivateChat.php';

	$object = new PrivateChat;

	$object->setMsgId($_POST['msgid']);

	$object->setMsgEmoji($_POST['emoji']);

	$result=$object->insertemoji();

	if($result=='success'){

		echo  $_POST['emoji'].'|'.$_POST['msgid'];
	}
	else{

		echo "Something is wrong !";
	}
	// echo "<pre>";
	// print_r($result);
	// exit;
}

// insert emoji with message in group chat
if(isset($_POST['action'])  && $_POST['action']=='group_emoji' && $_POST['msg_id']){
	
	require 'database/GroupEmojis.php';

	$object = new GroupEmojis;

	$object->setMsgId($_POST['msg_id']);

	$object->setUserId($_POST['user_id']);

	$object->setGroupId($_POST['grp_id']);

	$object->setEmoji($_POST['grp_emoji']);

	$result= $object->insertgroupemojis();

	if($result='success'){

		echo $_POST['grp_emoji'].'|'.$_POST['msg_id'];
	}
	else{

		echo "Something is wrong !";
	}
}

// get group emoji count start here
if(isset($_POST['action']) && $_POST['action']=='emoji_count'){

	$html='';

	require 'database/GroupEmojis.php';

	$object = new GroupEmojis;

	$object->setMsgId($_POST['msg_id']);

	$result=$object->getgroupemojiaccount();

	foreach($result as $key => $value ){

		$html.='<span id="'.$value[0].'" style="font-size:10px;"> '.$value[2].' '.$value[1].' </span>';

	}

	echo $html;
	// print_r($result);
	// exit;
}

// make user to group admin start here 
if(isset($_POST['action']) && $_POST['action']=='create_admin'){

	$groupid=$_POST['group_id'];
	$admins=$_POST['username'];

	require 'database/ChatGroups.php';

	$object = new ChatGroups;

	$object->setId($groupid);

	// $object->setAdmins($admins);

	$result=$object->create_group_admin($admins);

	if($result){

		echo "Admin has been created Successfully !";
	}

}

// private chate update type status start here
if(isset($_POST['action']) && $_POST['action']=='update_type_status'){

	$user_id=$_POST['userid'];

	$is_type=$_POST['is_type'];

	require 'database/ChatUser.php';

	$object = new ChatUser;

	$object->setUserId($user_id);

	$object->setIsType($is_type);

	$object->update_typing_status();
}

// group chat update type status here
if(isset($_POST['action']) && $_POST['action']=='group_type_status'){

	$user_id=$_POST['userid'];

	$is_type=$_POST['is_type'];

	$grpid=$_POST['grpid'];


	require 'database/GroupUsers.php';

	$object = new GroupUsers;

	$object->setUserid($user_id);

	$object->setIsType($is_type);

	$object->setGrpid($grpid);

	$object->update_typing_status();
}

// get is typing status start here
// if(isset($_POST['action']) && $_POST['action']=='get_typing_status'){

// 	$user_id=$_POST['user_id'];

// 	require 'database/ChatUser.php';

// 	$object = new ChatUser;

// 	$object->setUserId($user_id);

// 	$result=$object->get_typing_status();
// 	$html='';
// 	if($result=='yes'){

// 		$html.='<div id="typing-indicator" class="typing-indicator">Typing
// 		<span class="animate-typing">
// 		<span class="dot"></span>
// 		<span class="dot"></span>
// 		<span class="dot"></span>
// 		</span>
// 		</div>';
// 	}
// 	echo $html;
// }

if(isset($_POST['action']) && $_POST['action']=='approve_redeem_entry' && isset($_POST['red_id'])){
	$red_id=$_POST['red_id'];
	$del=0;

	require('../database/Redeem.php');


	$object = new Redeem();
	$object->setId($red_id);
	$object->setApproval($del);
	
	$result=$object->approvalRedeemEntry();
	if($result==1){
		echo json_encode('Redeem Approval Successfully!');
		exit;
	}

}

if(isset($_POST['action']) && $_POST['action']=='approve_cust_entry' && isset($_POST['custentry_id'])){
	$custentry_id=$_POST['custentry_id'];
	$approval=0;
	$updatedby=$_SESSION["user_data"]["uname"];
	$updated_at  = date('Y-m-d H:i:s');
	$status='Active';
	require('../database/AddCustomer.php');


	$object = new AddCustomer();
	$object->setId($custentry_id);
	$object->setApproval($approval);
	$object->setStatus($status);
	$object->setUpdatedby($updatedby);
	$object->setUpdatedAt($updated_at);
	
	$result=$object->approvalCustomerEntry();
	if($result==1){
		echo json_encode('Customer Approval Successfully!');
		exit;
	}

}

if(isset($_POST['action']) && $_POST['action']=='delete_approve_cust_entry'){
	$custentry_id=$_POST['custentry_id'];
	
	require('../database/AddCustomer.php');


	$object = new AddCustomer();
	$object->setId($custentry_id);
	
	
	$result=$object->deleteApprovalCustomerEntry();
	if($result==1){
		echo json_encode('Deleted Successfully!');
		exit;
	}

}

if(isset($_POST['action']) && $_POST['action']=='redeem_edit_details' && $_POST['rdmid']!=''){

	$rdm_id=$_POST['rdmid'];
	$i=1;
	require('../database/Redeem.php');
	
	$object = new Redeem();
	$object->setId($rdm_id);
	$result=$object->getRedeemEditHistory();
	$output='';
	foreach ($result as $key => $value) {
		// echo "<pre>";
		// print_r($value);
		$output.='<tr><td>'.$i.'</td>
					<td>'.$value['field_name'].'</td>
					<td>'.$value['old_value'].'</td>
					<td>'.$value['new_value'].'</td>
					<td>'.$value['edited_by'].'</td>
					<td>'.$value['edited_at'].'</td>';
		$i++;
	}

	echo $output;
}
?>
