<?php
    if(isset($_POST['redmid']) && $_POST['redmid']!='' && isset($_POST['paid_redeem_frm'])){
    	
    	// echo "<pre>";
    	// print_r($_POST);
    	// exit;
    	$redmid = $_POST["redmid"];
    	$paid = 0;
        $refund = 0;
        $addback = 0;
        $tip = 0;

    	$hdn_imagedata = $_POST['hdn_imagedata'];
        
         if (!empty($hdn_imagedata)) 
        {
            $pgid 		= $_POST["pgid"];
            $redstatus 	= $_POST["status"];
            $created_by	=date('Y-m-d H:i:s');
            $paidfor 	='Redeem';
            $status 	='active';
            // $comment 	=$_POST["comment"];
            if (!empty($_POST['custom_comment'])) {
                $comment = trim($_POST['custom_comment']);
            } else {
                $comment = $_POST['comment'];
            }
            $cashtag 	= $_POST["cashtag"];
            $actionType = $_POST["action_type"];
            $amount 	= $_POST["amount"];
            $total_type =count($actionType);
            $redeem_by 	=$_POST['uname'];
            $paidbyclient=$_POST['paidbyclient'];
            $redeemfor  =$_POST['redeemfor'];
            $redeemfrom =$_POST['redeemfrom'];
            // $clientname =$_POST['clientname'];
            $clientname = isset($_POST['clientname']) ? $_POST['clientname'] : null;
            $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

            $type='Redeem Attachment';

        // Validate cashtag, action_type, and amount

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
                $object->setPaymentMethod($payment_method);


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
            $redeem_status->setPaymentMethod($payment_method);

        	if($redeem_status->updateRedeemstatus()){

        	   // echo 'success';
        	   echo '<script>alert("Redeemed Successfully!");window.location.replace("allpageslist");</script>';
            }
            else{
                echo '<script>alert("Redemption failed. Please try again later.");window.location.replace("allpageslist");</script>';
            }
        }
        else {
            // Validation failed, show error message
            echo '<script>alert("Invalid cashtag, action type, or amount. Please fill in all required fields correctly.");window.location.replace("allpageslist");</script>';
            exit; // Exit to stop further execution
        }
    }
    else {
        // Invalid or incomplete form submission
        echo '<script>alert("Invalid form submission. Please fill in all required fields.");window.location.replace("allpageslist");</script>';
    }
?>