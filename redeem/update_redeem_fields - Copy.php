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
	if(isset($_POST['redmid']) && $_POST['redmid']!='' ){
		
		// echo "<pre>";
		// print_r($_POST);
		// exit;
		$errors = [];
		$redmid = $_POST["redmid"];
		$uname 		= $_POST['uname'];
	    $uid 		= $_POST['uid'];
	    $action_type = $_POST['frmaction_type'];
		if ($action_type === 'singlecomment') {
			
			if (isset($_POST["single-comment"]) && !empty($_POST["single-comment"])) {
				$comment = isset($_POST["custom_comment"]) && !empty($_POST["custom_comment"]) 
	               ? trim($_POST["custom_comment"]) : trim($_POST["single-comment"]);
		        // $comment 	= trim($_POST["single-comment"]);
		        $hdn_image 	= $_POST['hdn_cmntimagedata'];
		        $pgid 		= $_POST['pgid'];
		       

		        $type 		='Comments Attachment';
		        $updated_at	=date('Y-m-d H:i:s');
		        
		        // Validation: Check if the image is empty
		        if (empty($hdn_image)) {
		            echo json_encode(['status' => 'error', 'message' => 'Please add an image.']);
		            exit;
		        }
		        // Update the comment field in the redeem table
		        require('../database/ImageUpload.php');
			
				$image = new ImageUpload();

				if($hdn_image!=''){

					$savedImages=$image->saveRedeemimage($hdn_image);

					if (!empty($savedImages)) {
				        foreach ($savedImages as $key => $value) {
				        	
				        	$image->setCatransid($redmid);
							$image->setType($type);
							$image->setCreatedat($updated_at);	
				            $image->setPath($value);
				            $image->saveUploadimages();

				        }

				    }
				    else
				    {
				        echo json_encode(['status' => 'error', 'message' => 'No images were saved.']);
	               		exit;
				    }
					

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

		       	echo json_encode(['status' => 'success', 'message' => 'Comment updated successfully!', 'page_id' => $pgid]);
	        	exit;
	        }
	    }
	    if($action_type == 'addback'){
	    	if($_POST["addedback_redeemamount"]){
	    	
		        $addback 	= trim($_POST["addedback_redeemamount"]);
		        $pgid 		= $_POST['pgid'];
		        $updated_at	=date('Y-m-d H:i:s');

		        require('../database/Redeem.php');
		        $redeem_status = new Redeem();
		        $redeem_status->setId($redmid);
		        $redeem_status-> setAmtAddback($addback);
		        $redeem_status->setRedeemBy($uname);
		        $redeem_status->setRedeemedDate($updated_at);  
		        $redeem_status->updateAddbackstatus();      

		       	echo json_encode(['status' => 'success', 'message' => 'Added Back successfully!', 'page_id' => $pgid]);
	        	exit;
	        }
	    }
		$paid = 0;
	    $refund = 0;
	    $addback = 0;
	    $tip = 0;

		$hdn_imagedata = $_POST['hdn_imagedata'];
	   
	   
	    $pgid 		= $_POST["pgid"];
	    $redstatus 	= isset($_POST["status"]) ? $_POST["status"] : '';
	    $created_by	=date('Y-m-d H:i:s');
	    $paidfor 	='Redeem';
	    $status 	='active';
	    if (!empty($_POST['custom_comment'])) {
	        $comment = trim($_POST['custom_comment']);
	    } else {
	        $comment = $_POST['comment'];
	    }
	    // $comment 	= isset($_POST["comment"]) ? $_POST["comment"] : '';
	    $cashtag 	= isset($_POST["cashtag"]) ? $_POST["cashtag"]:'';
	    $actionType = isset($_POST["action_type"]) ? $_POST["action_type"] : [];
	    $amount 	= isset($_POST["amount"]) ? $_POST["amount"] : [];
	    $total_type =count($actionType);
	    $redeem_by 	=$_POST['uname'];
	    $paidbyclient = isset($_POST['paidbyclient']) ? $_POST['paidbyclient'] : '';
	    $redeemfor 	= isset($_POST['redeemfor']) ? $_POST['redeemfor'] : '';
	    $redeemfrom = isset($_POST['redeemfrom']) ? $_POST['redeemfrom'] : '';
	    // $clientname =$_POST['clientname'];
	    $clientname = isset($_POST['clientname']) ? $_POST['clientname'] : null;

	    $type='Redeem Attachment';

	    if ($redeemfrom === '0') $errors[] = "Redeem From cannot be empty.";
	    if (empty($actionType)) $errors[] = "Action type is required.";
	    if (empty($amount)) $errors[] = "Amount is required.";
	    if ($total_type == 0) $errors[] = "At least one action type is required.";

	    // If there are errors, return them
	    if (!empty($errors)) {
	        $response['status'] = 'error';
	        $response['message'] = implode(' ', $errors);
	        echo json_encode($response);
	        exit;
	    }

	    require('../database/CashappTransaction.php');


		$object = new CashappTransaction();

	    require('../database/ImageUpload.php');
		
		$image = new ImageUpload();

		if($hdn_imagedata!=''){

			$savedImages=$image->saveRedeemimage($hdn_imagedata);

			if (!empty($savedImages)) {
		        foreach ($savedImages as $key => $value) {
		        	
		        	$image->setCatransid($redmid);
					$image->setType($type);
					$image->setCreatedat($created_by);	
		            $image->setPath($value);
		            $image->saveUploadimages();

		        }

		    }
		    else
		    {
		        echo "No images were saved.<br>";
		    }
			

	    }

	    for ($i = 0; $i < $total_type; $i++){
	    	

	    	$object->setRedId($redmid);
	    	$object->setCappid($cashtag[$i]);
	    	$object->setPaidfor($paidfor);
	    	$object->setPgid($pgid);
	    	$object->setPaytype($actionType[$i]);
	    	$object->setAmount($amount[$i]);
	    	$object->setComments($comment);
	    	$object->setStatus($status);
	    	$object->setCreatedat($created_by);
	    	$object->setRedeemBy($redeem_by);

	    	if($actionType[$i] == 'Paid'){
	            $paid = $paid + floatval($amount[$i]);
	        } elseif ($actionType[$i] == 'Refund') {
	            $refund = $refund + floatval($amount[$i]);
	        } elseif ($actionType[$i] == 'Addback') {
	            $addback = $addback + floatval($amount[$i]);
	        }
	        elseif ($actionType[$i] == 'Tip') {
	            $tip = $tip + floatval($amount[$i]);
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
		$comments->setCreatedAt($created_by);
		$comments->insertComments();

		require('../database/Redeem.php');

		$updated_at	=date('Y-m-d H:i:s');
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

		

		$output=$redeem_status->updateRedeemstatus();
		if($output){

			$response['status'] = 'success';
			$response['page_id']= $pgid;
		    $response['message']= 'Redeemed Successfully!';
		}
		else {
		    $response['status'] = 'error';
		    $response['message'] = 'Invalid request parameters.';
	    
		}
		echo json_encode($response);
		exit;
		// $redeem_status->updateRedeemstatus();

		// echo 'success';
		// echo '<script>alert("Redeemed Successfully!");window.location.replace("redeemlist.php");</script>';
	}
?>
<?php
	// delete redeem from table
	if(isset($_POST['action']) && $_POST['action']=='delete_redeem_entry' && isset($_POST['red_id'])){
		$red_id=$_POST['red_id'];
		$del='1';

		require('../database/Redeem.php');


		$object = new Redeem();
		$object->setId($red_id);
		$object->setDel($del);
		$object->setDel($del);
		$result=$object->deleteRedeem();
		if($result==1){
			echo json_encode('Record Deleted Successfully!');
			exit;
		}

	}

	
?>