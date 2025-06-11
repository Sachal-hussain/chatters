<?php


if(isset($_POST['viewredmid']) && $_POST['viewredmid']!=''){

	// echo "<pre>";
	// print_r($_POST);
	// exit;
	$cust_name 	= $_POST["cust_name"];
	$gameid 	= $_POST["gameid"];
	$cashtag 	= $_POST["updatecashtag"];
    $redmid 	= $_POST["viewredmid"];
    $amount 	= $_POST["redamount"];
    $tip 		= $_POST["update_tip"];
    $addback 	= $_POST["update_add_back"];
    $comment	=$_POST["update_comment"];
    $status		=$_POST["status"];
    $updated_at	=date('Y-m-d H:i:s');
    $redeem_by 	=$_POST['uname'];
    $pageid 	=$_POST['pageid'];
    $approval 	=1;
    
	require('../database/Redeem.php');

	$object = new Redeem();
	$object->setId($redmid);

	$current_values = $object->getRedeemDetailsById($redmid);
	
	$object->setCustName($cust_name);
	$object->setGid($gameid);
	$object->setCtid($cashtag);
	$object->setAmount($amount);
	$object->setTip($tip);
	$object->setAmtAddback($addback);
	$object->setStatus($status);
	$object->setReply($comment);
	$object->setRedeemBy($redeem_by);
	$object->setApproval($approval);
	$object->setRedeemedDate($updated_at);

	 // Track changes and save the edit history
    $new_values = [
        'cust_name' 	=> $cust_name,
        'gid'       	=> $gameid,
        'ctid'      	=> $cashtag,
        'amount'        => $amount,
        'tip'           => $tip,
        'amt_addback'   => $addback,
        'reply'      	=> $comment,
        'status'        => $status
    ];

    $object->trackAndSaveEditHistory($current_values, $new_values, $redeem_by, $updated_at, $pageid);

	$output=$object->updateRedeemFields();
	if($output){

		$response['status'] = 'success';
		$response['page_id']= $pageid;
	    $response['message']= 'The record has been updated. Please contact the manager to get approval.!';
	}
	else {
	    $response['status'] = 'error';
	    $response['message'] = 'Invalid request parameters.';
    
	}
	echo json_encode($response);
	exit;
	// echo '<script>alert("Record Updated Successfully!");window.location.replace("allpageslist");</script>';
	// exit;
}


?>
<?php
	// header('Content-Type: application/json');
	$response = array();

	try {
	    if (!isset($_POST['redmid']) || empty($_POST['redmid'])) {
	        throw new Exception('Missing or empty redmid.');
	    }

	    $action_type = isset($_POST['frmaction_type']) ? $_POST['frmaction_type'] : 'default_action';
	    $errors = [];
	    $redmid = $_POST['redmid'];
	    $uname = $_POST['uname'];
	    $uid = $_POST['uid'];
	    // $action_type = $_POST['frmaction_type'];
	    $pgid = $_POST['pgid'];
	    $updated_at = date('Y-m-d H:i:s');

	    switch ($action_type) {
	        case 'singlecomment':
	            handleSingleComment($redmid, $uname, $uid, $pgid, $updated_at);
	            break;
	        case 'addback':
	            handleAddBack($redmid, $uname, $pgid, $updated_at);
	            break;
	        case 'c2c':
	            // This case handles when frmaction_type is not provided or is set to a default
	            handleC2c($redmid, $uname, $uid, $pgid, $updated_at);
	            break;    
	       case 'default_action':
	            // This case handles when frmaction_type is not provided or is set to a default
	            handleDefault($redmid, $uname, $uid, $pgid, $updated_at);
	            break;
	        default:
	            throw new Exception('Invalid form action type.');
	    }

	    // Prepare the response data
	    $response['status'] = 'success';
	    $response['message'] = 'Operation completed successfully!';
	    $response['page_id'] = $pgid;

	    echo json_encode($response);

	} catch (Exception $e) {
	    // Prepare the error response
	    $response['status'] = 'error';
	    $response['message'] = $e->getMessage();
	    $response['page_id'] = $pgid;

	    echo json_encode($response);
	    exit;
	}

	function handleSingleComment($redmid, $uname, $uid, $pgid, $updated_at) {
	    global $errors;

	    if (empty($_POST["single-comment"])) {
	        $errors[] = 'Single comment is required.';
	    }

	    $comment = isset($_POST["custom_comment"]) && !empty($_POST["custom_comment"]) 
	               ? trim($_POST["custom_comment"]) : trim($_POST["single-comment"]);
	    $hdn_image = $_POST['hdn_cmntimagedata'];
	    
	    if (empty($hdn_image)) {
	        $errors[] = 'Please add an image.';
	    }

	    if (!empty($errors)) {
	        throw new Exception(implode(' ', $errors));
	    }

	    require('../database/ImageUpload.php');
	    $image = new ImageUpload();
	    $savedImages = $image->saveRedeemimage($hdn_image);

	    if (empty($savedImages)) {
	        throw new Exception('No images were saved.');
	    }

	    foreach ($savedImages as $value) {
	        $image->setCatransid($redmid);
	        $image->setType('Comments Attachment');
	        $image->setCreatedat($updated_at);
	        $image->setPath($value);
	        $image->saveUploadimages();
	    }

	    require('../database/Comments.php');
	    $comments = new Comments();
	    $comments->setRedId($redmid);
	    $comments->setPgId($pgid);
	    $comments->setUid($uid);
	    $comments->setUname($uname);
	    $comments->setRemarks($comment);
	    $comments->setCreatedAt($updated_at);
	    $comments->insertComments();

	    require('../database/Redeem.php');
	    $redeem_status = new Redeem();
	    $redeem_status->setId($redmid);
	    $redeem_status->setComment($comment);
	    $redeem_status->setCommentDatetime($updated_at);  
	    $redeem_status->updateComment();
	}

	function handleAddBack($redmid, $uname, $pgid, $updated_at) {
	    global $errors;
	    $paidfor = 'Redeem';
	    $status = 'active';
	    $cashtag=0;
	    $actionType='Added Back';
	    $comment='Added Back';

	    if (empty($_POST["addedback_redeemamount"])) {
	        $errors[] = 'Addback amount is required.';
	    }

	    $addback = trim($_POST["addedback_redeemamount"]);

	    if (!empty($errors)) {
	        throw new Exception(implode(' ', $errors));
	    }
	    require('../database/CashappTransaction.php');
	    $object = new CashappTransaction();
	    $object->setRedId($redmid);
	    $object->setCappid($cashtag);
	    $object->setPaidfor($paidfor);
	    $object->setPgid($pgid);
	    $object->setPaytype($actionType);
	    $object->setAmount($addback);
	    $object->setComments($comment);
	    $object->setStatus($status);
	    $object->setCreatedat($updated_at);
	    $object->setRedeemBy($uname);

	    $object->saveTransaction();

	    require('../database/Redeem.php');
	    $redeem_status = new Redeem();
	    $redeem_status->setId($redmid);
	    $redeem_status->setAmtAddback($addback);
	    $redeem_status->setRedeemBy($uname);
	    $redeem_status->setRedeemedDate($updated_at);
	    $redeem_status->updateAddbackstatus();
	}

	function handleDefault($redmid, $uname, $uid, $pgid, $updated_at) {
	    global $errors;

	    $hdn_imagedata 	= $_POST['hdn_imagedata'];
	    $redstatus 		= isset($_POST["status"]) ? $_POST["status"] : '';
	    $paidfor 		= 'Redeem';
	    $status 		= 'active';
	    $comment 		= !empty($_POST['custom_comment']) ? trim($_POST['custom_comment']) : $_POST['comment'];
	    $cashtag 		= isset($_POST["cashtag"]) ? $_POST["cashtag"]: '';
	    $actionType 	= isset($_POST["action_type"]) ? $_POST["action_type"] : [];
	    $amount 		= isset($_POST["amount"]) ? $_POST["amount"] : [];
	    $total_type 	= count($actionType);
	    $redeem_by 		= $_POST['uname'];
	    $paidbyclient 	= isset($_POST['paidbyclient']) ? $_POST['paidbyclient'] : '';
	    $redeemfor 		= isset($_POST['redeemfor']) ? $_POST['redeemfor'] : '';
	    $redeemfrom 	= isset($_POST['redeemfrom']) ? $_POST['redeemfrom'] : '';
	    $clientname 	= isset($_POST['clientname']) ? $_POST['clientname'] : null;
	    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

	    if ($redeemfrom === '0') $errors[] = "Redeem From cannot be empty.";
	    if (empty($actionType)) $errors[] = "Action type is required.";
	    if (empty($amount)) $errors[] = "Amount is required.";
	    if ($total_type == 0) $errors[] = "At least one action type is required.";

	    if (!empty($errors)) {
	        throw new Exception(implode(' ', $errors));
	    }

	    require('../database/CashappTransaction.php');
	    $object = new CashappTransaction();

	    require('../database/ImageUpload.php');
	    $image = new ImageUpload();
	    if ($hdn_imagedata != '') {
	        $savedImages = $image->saveRedeemimage($hdn_imagedata);
	        if (!empty($savedImages)) {
	            foreach ($savedImages as $value) {
	                $image->setCatransid($redmid);
	                $image->setType('Redeem Attachment');
	                $image->setCreatedat($updated_at);
	                $image->setPath($value);
	                $image->saveUploadimages();
	            }
	        } else {
	            throw new Exception('No images were saved.');
	        }
	    }

	    $paid = $refund = $addback = $tip = 0;
	    for ($i = 0; $i < $total_type; $i++) {
	        $object->setRedId($redmid);
	        $object->setCappid($cashtag[$i]);
	        $object->setPaidfor($paidfor);
	        $object->setPgid($pgid);
	        $object->setPaytype($actionType[$i]);
	        $object->setAmount($amount[$i]);
	        $object->setComments($comment);
	        $object->setStatus($status);
	        $object->setCreatedat($updated_at);
	        $object->setRedeemBy($redeem_by);
	        $object->setPaymentMethod($payment_method);

	        switch ($actionType[$i]) {
	            case 'Paid':
	                $paid += floatval($amount[$i]);
	                break;
	            case 'Refund':
	                $refund += floatval($amount[$i]);
	                break;
	            case 'Addback':
	                $addback += floatval($amount[$i]);
	                break;
	            case 'Tip':
	                $tip += floatval($amount[$i]);
	                break;
	        }
	        $object->saveTransaction();
	    }

	    require('../database/Comments.php');
	    $comments = new Comments();
	    $comments->setRedId($redmid);
	    $comments->setPgId($pgid);
	    $comments->setUid($uid);
	    $comments->setUname($uname);
	    $comments->setRemarks($comment);
	    $comments->setCreatedAt($updated_at);
	    $comments->insertComments();

	    require('../database/Redeem.php');
	    $redeem_status = new Redeem();
	    $redeem_status->setId($redmid);
		$redeem_status->setStatus($redstatus);
		$redeem_status->setRedeemBy($redeem_by);
		$redeem_status->setAmtPaid($paid);
		$redeem_status->setAmtRefund($refund);
		$redeem_status->setAmtAddback($addback);
		$redeem_status->setAmtBal($tip);
		$redeem_status->setComment($comment);
		$redeem_status->setPaidbyclient($paidbyclient);
		$redeem_status->setClientname($clientname);
		$redeem_status->setRedeemedDate($updated_at);
		$redeem_status->setRedeemfor($redeemfor);
		$redeem_status->setRedeemfrom($redeemfrom);
		$redeem_status->setPaymentMethod($payment_method);
	    $redeem_status->updateRedeemstatus();
	}
	function handleC2c($redmid, $uname, $uid, $pgid, $updated_at) {
	   // echo "<pre>";
	   // print_r($_POST);
	   // exit;
	   	$cashtag_details	  = explode("-",$_POST['cashtag']);
	    $hdn_imagedata 	= $_POST['hdn_c2cimagedata'];
	    $redstatus 		= isset($_POST["status"]) ? $_POST["status"] : '';
	    $paidfor 		= 'Redeem';
	    $status 		= 'active';
	    $comment 		= !empty($_POST['custom_comment']) ? trim($_POST['custom_comment']) : $_POST['comment'];
	    $cashtag 		= $cashtag_details[0];
	    $actionType 	= isset($_POST["action_type"]) ? $_POST["action_type"] : 0;
	    $amount 		= isset($_POST["amount"]) ? $_POST["amount"] : 0;
	    // $total_type 	= count($actionType);
	    $redeem_by 		= $_POST['uname'];
	    $paidbyclient 	= isset($_POST['paidbyclient']) ? $_POST['paidbyclient'] : '';
	    $redeemfor 		= isset($_POST['redeemfor']) ? $_POST['redeemfor'] : '';
	    $redeemfrom 	= isset($_POST['redeemfrom']) ? $_POST['redeemfrom'] : '';
	    $clientname 	= isset($_POST['clientname']) ? $_POST['clientname'] : null;
	    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
	    $from_cust 		= isset($_POST['from_cust']) ? $_POST['from_cust'] : '';
	    $to_cust 		= isset($_POST['to_cust']) ? $_POST['to_cust'] : '';

	   

	    require('../database/CashappTransaction.php');
	    $object = new CashappTransaction();

	    require('../database/ImageUpload.php');
	    $image = new ImageUpload();
	    if ($hdn_imagedata != '') {
	        $savedImages = $image->saveRedeemimage($hdn_imagedata);
	        if (!empty($savedImages)) {
	            foreach ($savedImages as $value) {
	                $image->setCatransid($redmid);
	                $image->setType('Redeem Attachment');
	                $image->setCreatedat($updated_at);
	                $image->setPath($value);
	                $image->saveUploadimages();
	            }
	        } else {
	            throw new Exception('No images were saved.');
	        }
	    }

	   
	    // for ($i = 0; $i < $total_type; $i++) {
	        $object->setRedId($redmid);
	        $object->setCappid($cashtag);
	        $object->setPaidfor($paidfor);
	        $object->setPgid($pgid);
	        $object->setPaytype($actionType);
	        $object->setAmount($amount);
	        $object->setComments($comment);
	        $object->setStatus($status);
	        $object->setCreatedat($updated_at);
	        $object->setRedeemBy($redeem_by);
	        $object->setPaymentMethod($payment_method);

	       
	        $object->saveTransaction();
	    // }

	    require('../database/Comments.php');
	    $comments = new Comments();
	    $comments->setRedId($redmid);
	    $comments->setPgId($pgid);
	    $comments->setUid($uid);
	    $comments->setUname($uname);
	    $comments->setRemarks($comment);
	    $comments->setCreatedAt($updated_at);
	    $comments->insertComments();

	    require('../database/Redeem.php');
	    $redeem_status = new Redeem();
	    $redeem_status->setId($redmid);
		$redeem_status->setStatus($redstatus);
		$redeem_status->setRedeemBy($redeem_by);
		$redeem_status->setAmtPaid($amount);
		$redeem_status->setAmtRefund(0);
		$redeem_status->setAmtAddback(0);
		$redeem_status->setAmtBal(0);
		$redeem_status->setComment($comment);
		$redeem_status->setPaidbyclient($paidbyclient);
		$redeem_status->setClientname($clientname);
		$redeem_status->setRedeemedDate($updated_at);
		$redeem_status->setRedeemfor($redeemfor);
		$redeem_status->setRedeemfrom($redeemfrom);
		$redeem_status->setPaymentMethod($payment_method);
		$redeem_status->setFromCust($from_cust);
		$redeem_status->setToCust($to_cust);
	    $redeem_status->updateRedeemstatus();
	}
	
?>
<?php
	// delete redeem from table
	// if(isset($_POST['action']) && $_POST['action']=='delete_redeem_entry' && isset($_POST['red_id'])){
	// 	$red_id=$_POST['red_id'];
	// 	$del='1';

	// 	require('../database/Redeem.php');


	// 	$object = new Redeem();
	// 	$object->setId($red_id);
	// 	$object->setDel($del);
	// 	$object->setDel($del);
	// 	$result=$object->deleteRedeem();
	// 	if($result==1){
	// 		echo json_encode('Record Deleted Successfully!');
	// 		exit;
	// 	}

	// }

	
?>