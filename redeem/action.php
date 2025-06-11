<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// save redeem action csr
if(isset($_POST['cust_name']) && $_POST['cust_name']!=''){

	$pg_details	  = explode("-",$_POST['pg_id']);
	
	// $email        = $_POST['email'];
	$cust_name = trim($_POST['cust_name']);
	$game_id   = trim($_POST['game_id']);
	// $cust_name    = str_replace(' ', '', $_POST['cust_name']);
	// $game_id      = str_replace(' ', '', $_POST['game_id']);
	$red_amount   = $_POST['red_amount'];
	$cash_tag     = $_POST['cash_tag'];
	$number       = $_POST['number'];
	$tip          = $_POST['tip'];
	$added_back   = $_POST['added_back'];
	// $redeem_by    = $_POST['redeem_by'];
	$uid          = $_POST['uid'];
	$status       = 'Pending';
	$record_by    = $_POST['uname'];
	$pg_id  	  = $pg_details[0];
	$pg_name  	  = $pg_details[1];
	$hdn_imagedata = $_POST['hdn_images'];
	$type='CSR Redeem Attachmen';

	$dt           = date('Y-m-d');
	$record_time  = date('Y-m-d H:i:s');
	// echo "<pre>";
	// print_r($record_time);
	// exit;

	require('../database/Redeem.php');


	$object = new Redeem();

	// $object->setShiftMail($email);
	$object->setCustName($cust_name);
	$object->setGid($game_id);
	$object->setAmount($red_amount);
	$object->setCtid($cash_tag);
	$object->setPgId($pg_id);
	$object->setPageName($pg_name);
	$object->setContact($number);
	$object->setTip($tip);
	$object->setAddback($added_back);
	// $object->setRedeemBy($redeem_by);
	$object->setUserId($uid);
	$object->setDate($dt);
	$object->setRecordTime($record_time);
	$object->setStatus($status);
	$object->setRecordBy($record_by);
	$object->setRedeemedDate($record_time);	

	$save_id=$object->createRedeem();
	
	require('../database/ImageUpload.php');
	
	$image = new ImageUpload();

	if($hdn_imagedata!=''){

		$savedImages=$image->saveRedeemimage($hdn_imagedata);

		if (!empty($savedImages)) {
	        foreach ($savedImages as $key => $value) {
	        	
	        	$image->setCatransid($save_id);
				$image->setType($type);
				$image->setCreatedat($record_time);	
	            $image->setPath($value);
	            $image->saveUploadimages();

	        }
	        if($save_id!=''){

	        	echo "Redeem Request Added Successfully";
	        }

	    }
	    else
	    {
	        echo "No images were saved.<br>";
	    }
		

    }

    
	// if($result){
	// 	echo "Redeem Request Added Successfully";
	// }else{
	// 	echo "Something is wrong!";
	// }
}


// get cashtag start here
if(isset($_POST['action']) && $_POST['action']=='cash_tag' && $_POST['redid']!=''){

	$red_id=$_POST['redid'];
	$pg_id=$_POST['pgid'];

	$output='';
	require('../database/Cashapp.php');


	$object = new Cashapp();
	$object->setPgid($pg_id);
	$cashtags=$object->getCashtagbyid();
	$output.=' <option value="0">Select Cashtag</option>';
	foreach ($cashtags as $key => $value) {
		// echo "<pre>";

		// print_r($value);
		$output.=' <option value="'.$value[0].'-'.$value[1].'">'.$value[1].' --- '.$value[2].'</option>';
		// $output.=' <option value="'.$value[0].'">'.$value[2].'</option>';

	}

	echo $output;

}

// get all cashtag
if(isset($_POST['action']) && $_POST['action']=='all_cash_tag'){

	$output='';
	require('../database/Cashapp.php');


	$object = new Cashapp();
	$cashtags=$object->getAllCashtag();
	$output.=' <option value="0">Select Cashtag</option>';
	foreach ($cashtags as $key => $value) {
		// echo "<pre>";

		// print_r($value);
		$output.=' <option value="'.$value[0].'-'.$value[1].'">'.$value[1].' --- '.$value[2].'</option>';
		// $output.=' <option value="'.$value[0].'">'.$value[2].'</option>';

	}

	echo $output;

}

if(isset($_POST['action']) && $_POST['action']=='paid_redeem_details' && $_POST['rdmid']!=''){

	$rdm_id=$_POST['rdmid'];

	require('../database/Redeem.php');
	
	$object = new Redeem();
	$object->setId($rdm_id);
	$result=$object->getPaidredeemdetails();
	// echo "<pre>";
	// print_r($result);
	// exit;
	$output='';
	$a=1;
	foreach ($result as $key => $value) {
		$total = intval($value['total']);
        if ($value['paytype'] == 'Addback') {
            $total += intval($value['red_addback']);
        }
		$output.=' 
		<tr>
          <th scope="row">'.$a.'</th>
          <td>'.$value['paytype'].'</td>
          <td>'.$total.'</td>
          <td>'.$value['create_at'].'</td>
          <td>'.$value['status'].'</td>
          <td>'.$value['cpname'].'</td>
          <td>'.$value['redeem_comments'].'</td>
          <td>'.$value['redeem_agent'].'</td>


        </tr>';
	$a++;
	}
	echo $output;
}

if(isset($_POST['action']) && $_POST['action']=='view_redeem_images' && $_POST['rdmid']!=''){

	$rdm_id=$_POST['rdmid'];
	$type=$_POST['type'];
	require('../database/ImageUpload.php');
	
	$object = new ImageUpload();
	$object->setCatransid($rdm_id);
	$result=$object->getRedeemImages($type);
	$output='';
	foreach ($result as $key => $value) {
		// echo "<pre>";
		// print_r($value);
		$output.='<li class="list-inline-item message-img-list me-2 ms-0"><div><a class="popup-img d-inline-block m-1" href="../assets/images/uploads/'.$value[2].'" title="" target="_blank"><img src="../assets/images/uploads/'.$value[2].'" alt="" class="rounded border"></a></div></li>';
	}

	echo $output;
}

// get unpaid redeem images 
if(isset($_POST['action'],  $_POST['type']) && $_POST['action']=='view_unpaidredeem_images' && $_POST['rdmid']!=''){
	$type=$_POST['type'];
	$output='';
	$i=1;
	$rdm_id=$_POST['rdmid'];
	
	
	require('../database/ImageUpload.php');
	
	$object = new ImageUpload();
	$object->setCatransid($rdm_id);
	$result=$object->getUnpaidRedeemImages($type);
	foreach ($result as $key => $value) {
		
		$output.='<p>'.$i.'</p><li class="list-inline-item message-img-list me-2 ms-0"><div><a class="popup-img d-inline-block m-1" href="../assets/images/uploads/'.$value[2].'" title="" target="_blank"><img src="../assets/images/uploads/'.$value[2].'" alt="" class="rounded border" style="width: 100%;"></a></div></li>';
	$i++;
	}

	echo $output;
}

// add cashapp details
if(isset($_POST['cashapp_name']) && $_POST['cashapp_name']!='' && $_POST['cashtag']!=''){
	// print_r($_POST);
	// exit;
	$pg_details	  	= explode("-",$_POST['pg_id']);
	$pg_id  	  	= $pg_details[0];
	$pg_name  	  	= $pg_details[1];
	$cashapp_name	= $_POST['cashapp_name'];
	$cashtag	  	= $_POST['cashtag'];
	$uid	  		= $_POST['uid'];
	$status 		='active';
	
	require('../database/Cashapp.php');

	$object= new Cashapp();
	$object->setName($cashapp_name);
	$object->setCashtag($cashtag);
	$object->setUid($uid);
	$object->setPgid($pg_id);
	$object->setStatus($status);
	$result=$object->saveCashtagDetails();

	 if (is_numeric($result)) {
        echo "Cashtag Added Successfully";
    } else {
        echo $result;  // This will print the error message from the function
    }
}

if(isset($_POST['action']) && $_POST['action']=='fetch_redeementry'){

	$redmid = $_POST['redid'];
	require('../database/Redeem.php');
	$object = new Redeem();
	$object->setId($redmid);
	$result=$object->fetchRedeemData();

	$reply 		=$result[0][14];
	$amount 	=$result[0][15];
	$tip 		=$result[0][22];
	$addback 	=$result[0][18];
	$cust_name 	=$result[0][3];
	$gameid 	=$result[0][6];
	$cashtag 	=$result[0][7];
	$pageid 	=$result[0][8];

	echo $reply.'|'.$amount.'|'.$tip.'|'.$addback.'|'.$cust_name.'|'.$gameid.'|'.$cashtag.'|'.$pageid;
	// echo "<pre>";
	// print_r($result);
	// exit;
}

// get client list start here
if(isset($_POST['action']) && $_POST['action']=='client_list'){
	$opt_staff = "";
	require '../database/Redeem.php';

	$object = new Redeem;

	$data=$object->get_clientlist();
	foreach($data as $key => $value){

        // echo "<pre>";
        // print_r($value);
        // exit;
        $opt_staff .= '<option value="'.$value[0].'">'.$value[0].'</option>';

    }
    if($opt_staff){

        echo $opt_staff;
    }
    else{
        echo '<option value="#">No Record</option>';
    }
	
}

if(isset($_POST['action']) && $_POST['action']=='search_redeem' && isset($_POST['searchQuery'])){

	$searchQuery = trim($_POST['searchQuery']);
	require '../database/Redeem.php';
	$object = new Redeem();

	$result=$object->searchResults($searchQuery);

	$output='';
	foreach ($result as $key => $value) {
		$remaining=$value['amount'] - $value['tip'] - $value['addback'] - $value['amt_refund'] - $value['amt_addback'] - $value['amt_bal'];
		$tip=$value['tip'] + $value['amt_bal'];
		$added_back=$value['addback']+$value['amt_addback'];
		// echo "<pre>";
		// print_r($value);
		$output.=' 
		<tr>
          <th scope="row">#red'.$value['id'].'</th>
          <td>'.$value['date'].'</td>
          <td>'.$value['record_by'].'</td>
          <td>'.$value['cust_name'].'</td>
          <td>'.$value['page_name'].'</td>
          <td>'.$value['gid'].'</td>
          <td>'.$value['ctid'].'</td>
          <td>'.$value['comment'].'</td>
          <td>'.$value['amount'].'</td>
          <td>'.$tip.'</td>
          <td>'.intval($value['amt_refund']).'</td>
          <td>'.$added_back.'</td>
          <td>'.$remaining.'</td>
          <td><a href="#" class="view_images_modal" data-id="'.$value['id'].'" data-type="Redeem Attachment">View</a> </td>

          <td>'.$value['status'].'</td>
        </tr>';
	
	}
	echo $output;
}

if(isset($_POST['action']) && $_POST['action']=='redeem_comment'){

	$redmid = $_POST['redid'];
	require('../database/Redeem.php');
	$object = new Redeem();
	$object->setId($redmid);
	$result=$object->getRedeemComments();

	

	echo $result;
	// echo "<pre>";
	// print_r($result);
	// exit;
}
if(isset($_POST['action']) && $_POST['action']=='updatecashtagstatus'){
	// echo "<pre>";
	// print_r($_POST);
	// exit;
	$cashtagid 			= $_POST['cashtag_id'];
	$status 			= $_POST['status'];
	$cashtag_balance 	= $_POST['cashtag_balance'];
	$remarks 			= $_POST['remarks'];
	$pgid 				= $_POST['pgid'];
	
	require('../database/Cashapp.php');

	$object= new Cashapp();
	$object->setId($cashtagid);
	$object->setStatus($status);
	$object->setRemarks($remarks);
	$object->setBalance($cashtag_balance);
	$result=$object->updateCashappStatus();

	if ($result==1) {
        $response = [
	        'status' => 'success',
	        'page_id' => $pgid,
	        'message' => 'CashApp Updated Successfully!!'
    	];
    } else {
        $response = [
        'status' => 'failure',
        'message' => 'Failed to update CashApp status.'
    	];
    }
	echo json_encode($response);
	
	// echo $result;
	// echo "<pre>";
	// print_r($result);
	// exit;
}

if(isset($_POST['add_comment']) && $_POST['add_comment']!=''){
	$redmid 		= $_POST['viewredmid'];
	$add_comment 	= $_POST['add_comment'];
	$hdn_imagedata 	= $_POST['hdn_imagedata'];
	$record_time  = date('Y-m-d H:i:s');
	$type='Redeem Attachment';

	require('../database/Redeem.php');
	$object = new Redeem();
	$object->setId($redmid);
	$object->setComment($add_comment);
	$object->updateComment();
	
	require('../database/ImageUpload.php');
	
	$image = new ImageUpload();

	if($hdn_imagedata!=''){

		$savedImages=$image->saveRedeemimage($hdn_imagedata);

		if (!empty($savedImages)) {
	        foreach ($savedImages as $key => $value) {
	        	
	        	$image->setCatransid($redmid);
				$image->setType($type);
				$image->setCreatedat($record_time);	
	            $image->setPath($value);
	            $image->saveUploadimages();

	        }
	        echo "Record Updated Successfully";

	    }
	    else
	    {
	        echo "No images were saved.<br>";
	    }
		

    }
	// echo "<pre>";
	// print_r($_POST);
	// exit;
}

// if(isset($_POST['limitcheck']) && $_POST['limitcheck']=='limit'){
// 	$customer = trim($_POST['limitcust_name']);
// 	$pgid = trim($_POST['pgid']);

// 	require '../database/Redeem.php';
// 	$object = new Redeem();
// 	$object->setCustName($customer);
// 	$object->setPgId($pgid);
// 	$result=$object->checkDailyLimit();
// 	$output='';
// 	foreach ($result as $key => $value) {
// 		$tip        =$value['tip']+$value['amt_bal'];
// 		$addback 	=$value['amt_addback']+$value['addback'];
		

// 		$output.=' 
// 		<tr>
//           <td>'.$value['page_name'].'</td>
//           <td>'.$value['cust_name'].'</td>
//           <td>'.$value['gid'].'</td>
//           <td>'.intval($value['amount']).'</td>
//           <td>'.intval($tip).'</td>
//           <td>'.intval($addback).'</td>
//           <td>'.$value['total_amount'].'</td>
//           <td>'.$value['record_time'].'</td>


//         </tr>';
		
// 	}
// 	// echo $output;
// 	if($output){

//         echo $output;
//     }
//     else{
//         echo 'tr><td colspan="6">Oops! Record not found</td></tr>';
//     }
// 	// print_r($value);
// 	// exit;

// }

if (isset($_POST['limitcheck']) && $_POST['limitcheck'] == 'limit') {
    $customer = trim($_POST['limitcust_name']);
    $pgid = trim($_POST['pgid']);

    require '../database/Redeem.php';
    $object = new Redeem();
    $object->setCustName($customer);
    $object->setPgId($pgid);
    $result = $object->checkDailyLimit();
    $output = '';
    $totalSum = 0;
    $totaltip =0;
    $totaladdback=0;
    $totalamount=0;
    $totalrefunded=0;
    $totalpaid=0;
    foreach ($result as $key => $value) {
    	// echo "<pre>";
    	// print_r($value);
        $tip = $value['tip'] + $value['amt_bal'];
        $addback = $value['amt_addback'] + $value['addback'];

        // Calculate total amount for each row
        $totalAmount = $value['amount'] - $tip - $addback - $value['amt_refund'] - $value['amt_paid'];

        // Add the total amount to the cumulative total sum
        $totalSum  		+= $value['amount'];
        $totaltip 		+= $tip;
        $totaladdback 	+= $addback;
        $totalamount 	+= $totalAmount;
        $totalrefunded 	+= $value['amt_refund'];
        $totalpaid 		+= $value['amt_paid'];



        $output .= '
        <tr>
            <td>' . $value['page_name'] . '</td>
            <td>' . $value['cust_name'] . '</td>
            <td>' . $value['gid'] . '</td>
            <td>' . intval($value['amount']) . '</td>
            <td>' . intval($tip) . '</td>
            <td>' . intval($addback) . '</td>
            <td>' . intval($value['amt_refund']) . '</td>
            <td>' . intval($value['amt_paid']) . '</td>
            <td>' . $totalAmount . '</td>
            <td>' . $value['record_time'] . '</td>
        </tr>';
    }


    // Output the result
    if (!empty($output)) {

        echo $output;
        echo '<tr>
        <td colspan="3"><strong>Total:</strong></td>
        <td><strong>' . $totalSum . '</strong></td>
        <td><strong>' . $totaltip . '</strong></td>
        <td><strong>' . $totaladdback . '</strong></td>
        <td><strong>' . $totalrefunded . '</strong></td>
        <td><strong>' . $totalpaid . '</strong></td>
        <td><strong>' . $totalamount . '</strong></td>
    	</tr>';
    } else {
        echo '<tr><td colspan="10">Oops! Record not found</td></tr>';
    }
}

if(isset($_POST['action']) && $_POST['action']=='view_redeem_remarks' && $_POST['rdmid']!=''){

	$rdm_id=$_POST['rdmid'];
	$type=$_POST['type'];
	$i=1;
	require('../database/ImageUpload.php');
	
	$object = new ImageUpload();
	$object->setCatransid($rdm_id);
	// $result=$object->getRedeemImages($type);
	$result=$object->getAllImages();

	$output='';
	foreach ($result as $key => $value) {
		// echo "<pre>";
		// print_r($value);
		$output.='<tr><td>'.$i.'</td>
					<td><a class="popup-img d-inline-block m-1" href="../assets/images/uploads/'.$value['path'].'" title="" target="_blank"><img src="../assets/images/uploads/'.$value['path'].'" alt="" class="rounded border" style="width:100px;"></a></td>
					<td>' . ($value['type'] === 'CSR Redeem Attachmen' ? 'CSR Attachment' : $value['type']) . '</td>
					<td>'.$value['createdat'].'</td>';
		$i++;
	}

	echo $output;
}

if(isset($_POST['action']) && $_POST['action']=='view_redeem_remarks_details' && $_POST['rdmid']!=''){

	$rdm_id=$_POST['rdmid'];
	$i=1;
	require('../database/Comments.php');
	
	$object = new Comments();
	$object->setRedId($rdm_id);
	$result=$object->getRedeemRemarks();
	$output='';
	foreach ($result as $key => $value) {
		// echo "<pre>";
		// print_r($value);
		$output.='<tr><td>'.$i.'</td>
					<td>'.$value['remarks'].'</td>
					<td>'.$value['uname'].'</td>
					<td>'.$value['created_at'].'</td>';
		$i++;
	}

	echo $output;
}
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

if(isset($_POST['action']) && $_POST['action']=='customer_list'){
	$p_id=$_POST['pid'];

	$opt_staff = "";

	require '../database/AddCustomer.php';

	$object = new AddCustomer;
	$object->setPgid($p_id);
	$data=$object->getCustomerbyid();
	foreach($data as $key => $value){

        // echo "<pre>";
        // print_r($value);
        // exit;
        $opt_staff .= '<option value="'.$value[0].'">'.$value[0].'</option>';

    }
    if($opt_staff){

        echo $opt_staff;
    }
    else{
        echo '<option value="#">No Record</option>';
    }
	
}

if(isset($_POST['action']) && $_POST['action']=='c2cdetails' && isset($_POST['pgid'])){

	$pgid 	= $_POST['pgid'];
	$rdmid 	= $_POST['rdmid'];
	
	require '../database/C2ctags.php';
	
	$object = new C2ctags();
	
	$object->setRedid($rdmid);
	$object->setPgid($pgid);

	$result=$object->getC2cdetailsbyid();

	$output='';
	$i=0;
	foreach ($result['data'] as $key => $value) {
		$i++;
		// echo "<pre>";
		// print_r($value);
		$output.=' 
		<tr>
          <th scope="row">'.$i.'</th>
          <td>'.$value['amount'].'</td>
          <td>'.$value['addedby'].'</td>
          <td>'.$value['created_at'].'</td>
          <td><a href="#" class="btn btn-danger deleteC2c" data-id="'.$value['id'].'">Delete</a> </td>

        </tr>';
	
	}
	echo $output;
}
if(isset($_POST['action']) && $_POST['action']=='deletec2c' && isset($_POST['id'])){
	$id=$_POST['id'];

	require('../database/C2ctags.php');


	$object = new C2ctags();
	$object->setId($id);
	
	$result=$object->deleteC2cRecord();
	if($result==1){
		echo json_encode('Record Deleted Successfully!');
		exit;
	}

}

if(isset($_POST['action']) && $_POST['action']=='depositPage'){

	$pgid 			= $_POST['depositpgid'];
	$customer_list	='';

	// print_r($_POST);
	// exit;
	require('../database/Redeem.php');

	$object = new Redeem();

	$object->setPgId($pgid);
	
	$result=$object->getPendingRedeemCustomer();
	$customer_list.=' <option value=""></option>'; 
	foreach($result as $key => $value){

        // echo "<pre>";
        // print_r($value);
        // exit;
        $customer_list .= '<option value="'.htmlspecialchars($value[1]).'">' . htmlspecialchars($value[1]) . ' -- '.htmlspecialchars($value[2]).'</option>';

    }

   
   	if($customer_list){
        echo json_encode(['customers' => $customer_list]);
    }
    else{
        echo json_encode(['customers' => '<option value="#">No Record</option>']);
    }

	// echo $result;
	// echo "<pre>";
	// print_r($result);
	// exit;
}

if (isset($_POST['action']) && $_POST['action'] == 'getCustRedeem') {
    $pgid = $_POST['depgid'] ?? '';
    $custName = $_POST['decustname'] ?? '';
    $redid='';

    // Validate inputs
    if (empty($pgid) || empty($custName)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid Page ID or Customer Name provided.'
        ]);
        exit;
    }

    $output = '';

    require('../database/Redeem.php');

    $object = new Redeem();
    $object->setPgId($pgid);
    $object->setCustName($custName);

    $result = $object->getCustomerRedeem();

    if (is_array($result)) {
        if (!empty($result) && !isset($result['message']) && !isset($result['error'])) {
            foreach ($result as $value) {
             	// echo "<pre>";
				// print_r($value);
				// exit;
				$redid 	 = $value['id'];
                $output .= '
                <tr>
                    <td>' . htmlspecialchars($value['cust_name']) . '</td>
                    <td>' . intval($value['amount']) . '</td>
                    <td>' . intval($value['amt_paid']) . '</td>
                    <td>' . intval($value['amount']-$value['amt_paid']) . '</td>
                </tr>';
            }
        } else {
            $output .= '<tr><td colspan="2">' . htmlspecialchars($result['message'] ?? 'No records found.') . '</td></tr>';
        }
    } else {
        $output .= '<tr><td colspan="2">An unexpected error occurred. Please try again later.</td></tr>';
    }

    echo json_encode([
        'status' => 'success',
        'redid' => $redid,
        'table' => $output
    ]);
}