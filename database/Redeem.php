<?php

class Redeem
{
	private $id;
	private $user_id;
	private $shift_mail;
	private $cust_name;
	private $date;
	private $gid;
	private $ctid;
	private $pg_id;
	private $page_name;
	private $amount;
	private $contact;
	private $tip;
	private $addback;
	private $record_time;
	private $record_by;
	private $redeem_by;
	private $status;
	private $comment;
	private $amt_paid;
	private $amt_refund;
	private $amt_addback;
	private $amt_bal;
	private $del;
	private $reply;
	private $paidbyclient;
	private $clientname;
	private $redeemed_date;
	private $redeemfor;
	private $redeemfrom;
	private $inform_status;
	private $approval;
	private $informed_at;
	private $gm_id;
	private $comment_datetime;
	private $ref_page;
	private $payment_method;
	private $from_cust;
	private $to_cust;


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

	function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	function getUserId()
	{
		return $this->user_id;
	}

	function setShiftMail($shift_mail)
	{
		$this->shift_mail = $shift_mail;
	}

	function getShiftMail()
	{
		return $this->shift_mail;
	}

	function setCustName($cust_name)
	{
		$this->cust_name = $cust_name;
	}

	function getCustName()
	{
		return $this->cust_name;
	}

	function setDate($date)
	{
		$this->date = $date;
	}

	function getDate()
	{
		return $this->date;
	}

	function setGid($gid)
	{
		$this->gid = $gid;
	}

	function getGid()
	{
		return $this->gid;
	}

	function setCtid($ctid)
	{
		$this->ctid = $ctid;
	}

	function getCtid()
	{
		return $this->ctid;
	}

	function setPgId($pg_id)
	{
		$this->pg_id = $pg_id;
	}

	function getPgId()
	{
		return $this->pg_id;
	}

	function setPageName($page_name)
	{
		$this->page_name = $page_name;
	}

	function getPageName()
	{
		return $this->page_name;
	}

	function setAmount($amount)
	{
		$this->amount = $amount;
	}

	function getAmount()
	{
		return $this->amount;
	}

	function setContact($contact)
	{
		$this->contact = $contact;
	}

	function getContact()
	{
		return $this->contact;
	}

	function setTip($tip)
	{
		$this->tip = $tip;
	}

	function getTip()
	{
		return $this->tip;
	}

	function setAddback($addback)
	{
		$this->addback = $addback;
	}

	function getAddback()
	{
		return $this->addback;
	}

	function setRecordTime($record_time)
	{
		$this->record_time = date('Y-m-d H:i:s');
	}

	function getRecordTime()
	{
		return $this->record_time;
	}

	function setRecordBy($record_by)
	{
		$this->record_by = $record_by;
	}

	function getRecordBy()
	{
		return $this->record_by;
	}

	function setRedeemBy($redeem_by)
	{
		$this->redeem_by = $redeem_by;
	}

	function getRedeemBy()
	{
		return $this->redeem_by;
	}

	function setStatus($status)
	{
		$this->status = $status;
	}

	function getStatus()
	{
		return $this->status;
	}

	function setComment($comment)
	{
		$this->comment = $comment;
	}

	function getComment()
	{
		return $this->comment;
	}

	function setReply($reply)
	{
		$this->reply = $reply;
	}

	function getReply()
	{
		return $this->reply;
	}

	function setAmtPaid($amt_paid)
	{
		$this->amt_paid = $amt_paid;
	}

	function getAmtPaid()
	{
		return $this->amt_paid;
	}

	function setAmtRefund($amt_refund)
	{
		$this->amt_refund = $amt_refund;
	}

	function getAmtRefund()
	{
		return $this->amt_refund;
	}

	function setAmtAddback($amt_addback)
	{
		$this->amt_addback = $amt_addback;
	}

	function getAmtAddback()
	{
		return $this->amt_addback;
	}

	function setAmtBal($amt_bal)
	{
		$this->amt_bal = $amt_bal;
	}

	function getAmtBal()
	{
		return $this->amt_bal;
	}

	function setDel($del)
	{
		$this->del = $del;
	}

	function getDel()
	{
		return $this->del;
	}
	function setPaidbyclient($paidbyclient)
	{
		$this->paidbyclient = $paidbyclient;
	}

	function getPaidbyclient()
	{
		return $this->paidbyclient;
	}
	function setClientname($clientname)
	{
		$this->clientname = $clientname;
	}

	function getClientname()
	{
		return $this->clientname;
	}

	function setRedeemfor($redeemfor)
	{
		$this->redeemfor = $redeemfor;
	}

	function getRedeemfor()
	{
		return $this->redeemfor;
	}

	function setRedeemfrom($redeemfrom)
	{
		$this->redeemfrom = $redeemfrom;
	}

	function getRedeemfrom()
	{
		return $this->redeemfrom;
	}

	function setRedeemedDate($redeemed_date)
	{
		$this->redeemed_date = date('Y-m-d H:i:s');
	}

	function getRedeemedDate()
	{
		return $this->redeemed_date;
	}

	function setInformstatus($inform_status)
	{
		$this->inform_status = $inform_status;
	}

	function getInformstatus()
	{
		return $this->inform_status;
	}

	function setApproval($approval)
	{
		$this->approval = $approval;
	}

	function getApproval()
	{
		return $this->approval;
	}

	function setInformedAt($informed_at)
	{
		$this->informed_at = date('Y-m-d H:i:s');
	}

	function getInformedAt()
	{
		return $this->informed_at;
	}

	function setGmId($gm_id)
	{
		$this->gm_id = $gm_id;
	}

	function getGmId()
	{
		return $this->gm_id;
	}

	function setCommentDatetime($comment_datetime)
	{
		$this->comment_datetime = date('Y-m-d H:i:s');
	}

	function getCommentDatetime()
	{
		return $this->comment_datetime;
	}

	function setRefPage($ref_page)
	{
		$this->ref_page = $ref_page;
	}

	function getRefPage()
	{
		return $this->ref_page;
	}

	function setPaymentMethod($payment_method)
	{
		$this->payment_method = $payment_method;
	}

	function getPaymentMethod()
	{
		return $this->payment_method;
	}

	function setFromCust($from_cust)
	{
		$this->from_cust = $from_cust;
	}

	function getFromCust()
	{
		return $this->from_cust;
	}

	function setToCust($to_cust)
	{
		$this->to_cust = $to_cust;
	}

	function getToCust()
	{
		return $this->to_cust;
	}
	function createRedeem() {
		
	   	
	    $limitQuery = "SELECT redeem_limit, daily_limit FROM addcustomer WHERE pgid = ? AND name = ? LIMIT 1";
		$limitStatement = $this->connect->prepare($limitQuery);

		// Check if the preparation was successful
		if ($limitStatement === false) {
		    die('Prepare failed: ' . htmlspecialchars($this->connect->error));
		}
		$limitStatement->bind_param('is', $this->pg_id, $this->cust_name);

		$limitStatement->execute();
		$limitResult = $limitStatement->get_result();
		$limitRow = $limitResult->fetch_assoc();

		if ($limitRow) {

		    $monthlyLimit = $limitRow['redeem_limit'];
		    $daily_limit = $limitRow['daily_limit'];

		} else {
		    $monthlyLimit = 0; // Set a default value if not found
		    $daily_limit = 0;
		}

		// // Debug: Print the results
		// echo 'pg_id: ' . $this->pg_id . ' cust_name: ' . $this->cust_name . ' monthlyLimit: ' . $monthlyLimit;
		// exit;
	    // Debugging output
	    // echo "Monthly limit: " . $monthlyLimit . "<br>";

		// SELECT SUM(amount - (amt_addback+addback)) as total_amount 
		// FROM redeem 
		// WHERE cust_name = 'Trust Htoo' AND pg_id = 51 AND del='0' AND record_time >= NOW() - INTERVAL 1 DAY;
	    // Calculate the total amount redeemed by the customer within the last 24 hours
	    $dailyCheckQuery = "SELECT SUM(amount) as total_amount 
	                        FROM redeem 
	                        WHERE cust_name = ? AND pg_id = ? AND del='0' AND record_time >= NOW() - INTERVAL 1 DAY";
	                   
	    $dailyCheckStatement = $this->connect->prepare($dailyCheckQuery);
	    $dailyCheckStatement->bind_param('si', $this->cust_name, $this->pg_id);
	    $dailyCheckStatement->execute();
	    $dailyResult = $dailyCheckStatement->get_result();
	    $dailyRow = $dailyResult->fetch_assoc();
	    
	    $dailyTotalAmount = $dailyRow['total_amount'] ?? 0; // Get the total amount redeemed in the last 24 hours

	    // Debugging output
	    // echo "Total amount within the last 24 hours: " . $dailyTotalAmount . "<br>";
	    // echo "Current amount: " . $this->amount . "<br>";

	    // Check if the total amount within the last 24 hours exceeds the limit
	    if ($dailyTotalAmount + $this->amount > $daily_limit) {
	        echo json_encode(['status' => 'error', 'message' => 'Total amount within the last 24 hours exceeds 500.']);
        	return;
	    }

	    // Calculate the total amount redeemed by the customer within the last 30 days
	    // $monthlyCheckQuery = "SELECT SUM(amount) as total_amount 
	    //                       FROM redeem 
	    //                       WHERE cust_name = ? AND pg_id = ? AND del='0' AND record_time >= NOW() - INTERVAL 30 DAY";
	    $monthlyCheckQuery = "SELECT SUM(amount) as total_amount 
                          FROM redeem 
                          WHERE cust_name = ? AND pg_id = ? AND del='0' 
                          AND record_time >= DATE_FORMAT(NOW() ,'%Y-%m-01') 
                          AND record_time <= LAST_DAY(NOW())";
	                          
	    $monthlyCheckStatement = $this->connect->prepare($monthlyCheckQuery);
	    $monthlyCheckStatement->bind_param('si', $this->cust_name, $this->pg_id);
	    $monthlyCheckStatement->execute();
	    $monthlyResult = $monthlyCheckStatement->get_result();
	    $monthlyRow = $monthlyResult->fetch_assoc();
	    
	    $monthlyTotalAmount = $monthlyRow['total_amount'] ?? 0; // Get the total amount redeemed in the last 30 days
	    
	    // Debugging output
	    // echo "Total amount within the last 30 days: " . $monthlyTotalAmount . "<br>";
	    // echo "Current amount: " . $this->amount . "<br>";

	    // Check if the total amount within the last 30 days exceeds the monthly limit
	    if ($monthlyTotalAmount + $this->amount > $monthlyLimit) {
	        echo json_encode(['status' => 'error', 'message' => "Total amount within the last 30 days exceeds the monthly limit of $monthlyLimit."]);
        	return;
	    }
	    // Proceed to insert the new redemption record if the total amount is within the limit
	    $query = "INSERT INTO redeem (user_id, cust_name, date, gid, ctid, pg_id, page_name, amount, contact, tip, addback, record_time, record_by, redeemed_date, status, redeemfor, gm_id, ref_page) 
	              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	              
	    $statement = $this->connect->prepare($query);
	    $statement->bind_param('issssisdsddsssssis', $this->user_id, $this->cust_name, $this->date, $this->gid, $this->ctid, $this->pg_id, $this->page_name, $this->amount, $this->contact, $this->tip, $this->addback, $this->record_time, $this->record_by, $this->redeemed_date, $this->status, $this->redeemfor, $this->gm_id, $this->ref_page);

	    if ($statement->execute()) {
	    	$lastInsertId = $this->connect->insert_id;
	       	return $lastInsertId;
	    } else {
	        echo json_encode(['status' => 'error', 'message' => 'Failed to add redeem entry.']);
	    }
	}
	
	// function createRedeem(){

	// 	$query=" INSERT INTO redeem (user_id,cust_name,date,gid,ctid,pg_id,page_name,amount,contact,tip,addback,record_time,record_by,redeemed_date,status) 
 //        values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bind_param('issssisdsddssss', $this->user_id,$this->cust_name,$this->date,$this->gid,$this->ctid,$this->pg_id,$this->page_name,$this->amount,$this->contact,$this->tip,$this->addback,$this->record_time,$this->record_by,$this->redeemed_date,$this->status);
	
	// 	if($statement->execute()){
		
	// 		return $statement->insert_id;
	// 	}
	// 	else{

	// 		return false;
	// 	}
	// }

	function getRedeemById(){
	    $query = "
	    SELECT * from redeem
	    WHERE pg_id=?
	    AND status='Pending'
	    AND del='0'
	    AND approval='0'        
	    ORDER BY id DESC
	    ";

	    $statement = $this->connect->prepare($query);
	    $statement->bind_param('i', $this->pg_id);

	    if($statement->execute())
	    {
	        $result = $statement->get_result();
	        $pages = $result->fetch_all(MYSQLI_ASSOC); // Fetch as associative array
	    }
	    else
	    {
	        $pages = array();
	    }

	    $statement->close();

	    return $pages;
	}


	// function updateRedeemstatus(){

	// 	$query = "
	// 	UPDATE redeem
	// 	SET status = ? , 
	// 	redeem_by=? ,
	// 	amt_paid=? ,
	// 	amt_refund=? ,
	// 	amt_addback=?
	// 	WHERE id = ?
	// 	";

	// 	$statement = $this->connect->prepare($query);

	// 	$statement->bind_param('ssdddi', $this->status,$this->redeem_by,$this->amt_paid,$this->amt_refund,$this->amt_addback, $this->id);

	// 	if($statement->execute()){

	// 		return true;
	// 	}
	// 	else{

	// 		return false;
	// 	}


	// }

	function updateRedeemstatus() {

	    // First, fetch the existing amounts from the database
	    $selectQuery = "SELECT amt_paid, amt_refund, amt_addback,amt_bal,redeem_by,redeem_manager FROM redeem WHERE id = ?";
	    $selectStatement = $this->connect->prepare($selectQuery);
	    $selectStatement->bind_param('i', $this->id);
	    $selectStatement->execute();
	    $result = $selectStatement->get_result();
	    
	    if ($row = $result->fetch_assoc()) {
	        // Add the new refund and add-back amounts to the existing amounts
	        $newAmtPaid = $row['amt_paid'] +  $this->amt_paid;
	        $newAmtRefund = $row['amt_refund'] + $this->amt_refund;
	        $newAmtAddback = $row['amt_addback'] + $this->amt_addback;
	        $newAmttip = $row['amt_bal'] + $this->amt_bal;

	        // Update the redeem_by field to include the new agent name if not already present
	        $existingRedeemBy = $row['redeem_by'];
	        $currentUser = $this->redeem_by;

	        if (empty($existingRedeemBy)) {
	            $updatedRedeemBy = $currentUser;
	        } else {
	            $redeemByArray = explode(',', $existingRedeemBy);
	            
	            if (!in_array($currentUser, $redeemByArray)) {
	                $redeemByArray[] = $currentUser;
	            }
	            $updatedRedeemBy = implode(',', $redeemByArray);
	        }

	        // Fetch the manager from the user table
	        $managerQuery = "SELECT uname FROM `user` WHERE department='Redeem' AND type='Manager' AND online='Login' LIMIT 1";
	        $managerStatement = $this->connect->prepare($managerQuery);
	        $managerStatement->execute();
	        $managerResult = $managerStatement->get_result();
	        
	        if ($managerRow = $managerResult->fetch_assoc()) {
	            $managerName = $managerRow['uname'];
	        } else {
	            $managerName = null; // Set to null or handle as needed
	        }

	        // Update the redeem_manager field to include the new manager's name if not already present
	        $existingManager = $row['redeem_manager'];
	        if (empty($existingManager)) {
	            $updatedManager = $managerName;
	        } else {
	            $managerArray = explode(',', $existingManager);
	            if ($managerName && !in_array($managerName, $managerArray)) {
	                $managerArray[] = $managerName;
	            }
	            $updatedManager = implode(',', $managerArray);
	        }

	        // Now, update the record in the database with the new amounts
	        $updateQuery = "
	            UPDATE redeem
	            SET status = ?, 
	                redeem_by = ?, 
	                amt_paid = ?, 
	                amt_refund = ?, 
	                amt_addback = ?,
	                amt_bal = ?,
	                comment=?,
	                paidbyclient=?,
	                clientname=?,
	                redeemed_date=?,
	                redeemfor=?,
	                redeemfrom=?,
	                payment_method=?,
	                redeem_manager=?,
	                from_cust=?,
	                to_cust=?
	            WHERE id = ?
	        ";
	        
	        $updateStatement = $this->connect->prepare($updateQuery);
	        $updateStatement->bind_param('ssddddssssssssssi', 
	            $this->status, 
	            $updatedRedeemBy, 
	            $newAmtPaid, 
	            $newAmtRefund, 
	            $newAmtAddback,
	            $newAmttip,
	            $this->comment,
	            $this->paidbyclient,
	            $this->clientname, 
	            $this->redeemed_date,
	            $this->redeemfor,
	            $this->redeemfrom,
	            $updatedManager, 
	            $this->payment_method,
	            $this->from_cust,
	            $this->to_cust,
	            $this->id
	        );

	        if ($updateStatement->execute()) {
	            return true;
	        } else {
	            return false;
	        }
	    } else {
	        return false; // Record with the given ID not found
	    }
	}


	function getPaidredeem(){
		$query = "
		SELECT * from redeem
		WHERE status='Paid'		
		ORDER BY id DESC
		";

		$statement = $this->connect->prepare($query);
		
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $redeem = $result->fetch_all();
		}
		else
		{
			$redeem = array();
			
		}

		$statement->close();

		return $redeem;
	}

	// function getPaidredeemdetails(){

	// 	$query = "SELECT 
	//     redeem.*,cashapptrans.paytype,cashapptrans.amount as total,cashapptrans.createdat as create_at,cashapptrans.comments as redeem_comments,redeem.status as rdm_status,cashapp.name as cpname,cashapp.cashtag as ctag
	//     FROM
	//     redeem
	//     JOIN cashapptrans ON 
	//     redeem.id=cashapptrans.red_id
	//     JOIN cashapp ON
	//     cashapptrans.cappid=cashapp.id
	//     WHERE redeem.id=?
	// 	";

	// 	$statement = $this->connect->prepare($query);
	// 	$statement->bind_param('i', $this->id);
 //        // print_r($query);

	// 	if($statement->execute())
	// 	{
	// 		$result = $statement->get_result();
 //            $redeem = $result->fetch_all();
	// 	}
	// 	else
	// 	{
	// 		$redeem = array();
			
	// 	}

	// 	$statement->close();

	// 	return $redeem;
	// }
	function getPaidredeemdetails() {
	    $query = "SELECT 
	                redeem.*,cashapptrans.paytype,cashapptrans.amount as total,cashapptrans.createdat as create_at,cashapptrans.comments as redeem_comments,cashapptrans.redeem_by as redeem_agent,redeem.status as rdm_status,redeem.addback as red_addback,cashapp.name as cpname,cashapp.cashtag as ctag
	            FROM
	                redeem
	            JOIN cashapptrans ON 
	                redeem.id=cashapptrans.red_id
	            LEFT JOIN cashapp ON
	                cashapptrans.cappid=cashapp.id
	            WHERE redeem.id=?";
	    $statement = $this->connect->prepare($query);
	    $statement->bind_param('i', $this->id);

	    if ($statement->execute()) {
	        $result = $statement->get_result();
	        
	        // Fetch all rows as associative arrays
	        $redeems = array();
	        while ($row = $result->fetch_assoc()) {
	            $redeems[] = $row;
	        }
	    } else {
	        $redeems = array();
	    }
	    $statement->close();

	    return $redeems;
	}

	function getPendingredeem(){
		$query = "
		SELECT * from redeem
		WHERE status='Pending' 
		AND del='0'		
		ORDER BY id DESC
		";

		$statement = $this->connect->prepare($query);
		
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $redeem = $result->fetch_all();
		}
		else
		{
			$redeem = array();
			
		}

		$statement->close();

		return $redeem;
	}
	// get redeem details to show in modal
	function fetchRedeemData(){

		$query = "
		SELECT * from redeem
		WHERE id=?
		";

		$statement = $this->connect->prepare($query);
		$statement->bind_param('i', $this->id);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $redeem = $result->fetch_all();
		}
		else
		{
			$redeem = array();
			
		}

		$statement->close();

		return $redeem;


	}

	function updateRedeemFields(){

		$query = "
		UPDATE redeem
		SET amount = ?, tip=?, amt_addback=?,status=?,reply=?,redeem_by=?,redeemed_date=?,cust_name=?,gid=?,ctid=?,approval=?	 
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('dddsssssssii', $this->amount,$this->tip,$this->amt_addback,$this->status,$this->reply,$this->redeem_by,$this->redeemed_date,$this->cust_name,$this->gid,$this->ctid,$this->approval,$this->id);

		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}


	}

	// function updateRedeemFields(){

	//     // Fetch the previous tip and addback amount
	//     $previousData = $this->getPreviousTipAndAddback($this->id);

	//     // Calculate new values based on the fetched data and the provided values
	//     $newTip = $previousData['tip'] + $this->tip;
	//     $newAmtAddback = $previousData['amt_addback'] + $this->amt_addback;

	//     // Now, update the redeem table with the new values
	//     $query = "
	//     UPDATE redeem
	//     SET amount = ?, tip = ?, amt_addback = ?, reply = ?
	//     WHERE id = ?
	//     ";

	//     $statement = $this->connect->prepare($query);

	//     $statement->bind_param('dddsi', $this->amount, $newTip, $newAmtAddback, $this->reply, $this->id);

	//     if($statement->execute()){
	//         return true;
	//     } else {
	//         return false;
	//     }
	// }

	// // Function to get previous tip and addback amount
	// function getPreviousTipAndAddback($redeemId){
	//     $query = "
	//     SELECT tip, amt_addback
	//     FROM redeem
	//     WHERE id = ?
	//     ";

	//     $statement = $this->connect->prepare($query);
	//     $statement->bind_param('i', $redeemId);
	//     $statement->execute();

	//     $result = $statement->get_result();
	//     $row = $result->fetch_assoc();

	//     return $row;
	// }


	function deleteRedeem(){

		$query = "
		UPDATE redeem
		SET del = ? 
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('ii', $this->del,$this->id);

		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}


	}

	function updateComment(){

		$query = "
		UPDATE redeem
		SET comment = ?,
		comment_datetime= ?
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('ssi',$this->comment,$this->comment_datetime,$this->id);

		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}


	}
	function get_clientlist()
	{	
		$query = "
		SELECT fullname FROM user 
		WHERE type ='Client' 
		-- AND status='Active'
		";

		$statement = $this->connect->prepare($query);

		try {
			if ($statement->execute()) {
				$result = $statement->get_result();
				$user_data = $result->fetch_all();
			} else {
				$user_data = array();
			}
		} catch (Exception $error) {
			echo $error->getMessage();
		}

		return $user_data;
	}

	function getRedeemComments() {

	    $query = "
	    SELECT comment from redeem
	    WHERE id=?
	    ";

	    $statement = $this->connect->prepare($query);
	    $statement->bind_param('i', $this->id);

	    if ($statement->execute()) {
	        $result = $statement->get_result();
	        $row = $result->fetch_assoc();  
	        $comment = $row['comment'];      
	    } else {
	        $comment = null;  
	    }

	    $statement->close();

	    return $comment;
	}


	// function searchResults($searchQuery){

	// 	// $query = "SELECT * FROM redeem WHERE (LOWER(cust_name) LIKE '%" . $searchQuery . "%' OR LOWER(gid) LIKE '%" . $searchQuery . "%') AND status = 'Pending'";
	// 	$query = "SELECT * FROM redeem WHERE (LOWER(cust_name) = ? OR LOWER(gid) = ?) AND status = 'Pending'";

 //        $statement = $this->connect->prepare($query);

 //        try {
	// 		if ($statement->execute()) {
	// 			$result = $statement->get_result();
	// 			$output = $result->fetch_all();
	// 		} else {
	// 			$output = array();
	// 		}
	// 	} catch (Exception $error) {
	// 		echo $error->getMessage();
	// 	}

	// 	return $output;



	// }
	function searchResults($searchQuery){

	    // Adjusted SQL query to search for exact matches
	    $query = "SELECT * FROM redeem WHERE (LOWER(cust_name) = ? OR LOWER(gid) = ?) AND status = 'Pending' AND del='0'";

	    $statement = $this->connect->prepare($query);

	    try {
	        // Bind parameters and execute the query
	        $searchQuery = strtolower($searchQuery); // Convert search query to lowercase
	        $statement->bind_param("ss", $searchQuery, $searchQuery); // Bind parameters

	        if ($statement->execute()) {
	            $result = $statement->get_result();
	            $output = $result->fetch_all(MYSQLI_ASSOC); // Fetch results as associative array
	        } else {
	            $output = array();
	        }
	    } catch (Exception $error) {
	        echo $error->getMessage();
	        $output = array(); // Set output to empty array in case of error
	    }

	    return $output;
	}

	function checkDailyLimit(){

	    // Query to get all transaction details
	    $historyQuery = "SELECT amount, tip, amt_bal, amt_addback, addback, record_time, page_name,cust_name,gid,amt_refund,amt_paid
	                     FROM redeem 
	                     WHERE pg_id = ? AND cust_name = ? AND del='0' AND record_time >= NOW() - INTERVAL 1 DAY";

	    $historyStatement = $this->connect->prepare($historyQuery);
	    $historyStatement->bind_param('is', $this->pg_id, $this->cust_name);
	    $historyStatement->execute();
	    $historyResult = $historyStatement->get_result();

	    // Fetch all transaction details
	    $transactionHistory = array();
	    while ($row = $historyResult->fetch_assoc()) {
	        // Calculate total redeem amount for each row
	        $totalAmount = $row['amount'] - ($row['tip'] + $row['amt_bal']) - ($row['amt_addback'] + $row['addback']) - $row['amt_refund'] - $row['amt_paid'];
	        $row['total_amount'] = $totalAmount;

	        // Add the row to the transaction history array
	        $transactionHistory[] = $row;
	    }

	    return $transactionHistory;
	}


	function updateInformStatus(){

		$query = "
		UPDATE redeem
		SET inform_status = ?, informed_at = ?
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('isi',$this->inform_status,$this->informed_at,$this->id);

		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}


	}

	function approvalRedeemEntry(){

		$query = "
		UPDATE redeem
		SET approval = ? 
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('ii', $this->approval,$this->id);

		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}
	}

	function updateAddbackstatus() {

	    // First, fetch the existing amounts from the database
	    $selectQuery = "SELECT amt_addback FROM redeem WHERE id = ?";
	    $selectStatement = $this->connect->prepare($selectQuery);
	    $selectStatement->bind_param('i', $this->id);
	    $selectStatement->execute();
	    $result = $selectStatement->get_result();
	    
	    if ($row = $result->fetch_assoc()) {
	        // Add the new refund and add-back amounts to the existing amounts
	        
	        $newAmtAddback = $row['amt_addback'] + $this->amt_addback;
	      
	        // Now, update the record in the database with the new amounts
	        $updateQuery = "
	            UPDATE redeem
	            SET  
	                redeem_by = ?, 
	                amt_addback = ?,
	                redeemed_date=?
	            WHERE id = ?
	        ";
	        
	        $updateStatement = $this->connect->prepare($updateQuery);
	        $updateStatement->bind_param('sdsi', 
	            $this->redeem_by, 
	            $newAmtAddback,
	            $this->redeemed_date,
	            $this->id
	        );

	        if ($updateStatement->execute()) {
	            return true;
	        } else {
	            return false;
	        }
	    } else {
	        return false; // Record with the given ID not found
	    }
	}

 	function getRedeemDetailsById($redmid) {
	  

	    if ($stmt = $this->connect->prepare("SELECT cust_name, gid, ctid, amount, tip, amt_addback,reply, status FROM redeem WHERE id = ?")) {
	        $stmt->bind_param("i", $redmid);
	        $stmt->execute();
	        $stmt->bind_result($cust_name, $gid, $ctid, $amount, $tip, $amt_addback,$reply, $status);
	        if ($stmt->fetch()) {
	            $result = [
	                'cust_name' => $cust_name,
	                'gid' => $gid,
	                'ctid' => $ctid,
	                'amount' => $amount,
	                'tip' => $tip,
	                'amt_addback' => $amt_addback,
	                'reply'      	=> $reply,
	                'status' => $status
	            ];
	        } else {
	            $result = false;
	        }
	        $stmt->close();
	        return $result;
	    } else {
	        error_log('Error preparing SQL statement: ' . $mysqli->error);
	        return false;
	    }
	}

	function trackAndSaveEditHistory($old_values, $new_values, $redeem_by, $updated_at, $pageid) {
	    

	    // Loop through each field to compare old and new values
	    foreach ($old_values as $field => $old_value) {
	        if (isset($new_values[$field]) && $new_values[$field] != $old_value) {
	            $new_value = $new_values[$field];
	            
	            // Prepare the SQL statement
	            if ($stmt = $this->connect->prepare("
	                INSERT INTO edit_history (redmid, field_name, old_value, new_value, edited_by, edited_at, pageid)
	                VALUES (?, ?, ?, ?, ?, ?, ?)
	            ")) {
	                
	                // Bind parameters
	                $stmt->bind_param("isssssi", 
	                    $this->id, $field, $old_value, $new_value, $redeem_by, $updated_at, $pageid
	                );

	                // Execute the statement
	                if (!$stmt->execute()) {
	                    error_log('Error executing SQL statement: ' . $stmt->error);
	                }
	                $stmt->close();
	            } else {
	                error_log('Error preparing SQL statement: ' . $mysqli->error);
	            }
	        }
	    }
	}

	function getRedeemEditHistory() {
	    $query = "SELECT field_name,old_value,new_value,edited_by,edited_at FROM `edit_history` WHERE redmid = ? ORDER BY id desc";

	    // Prepare the SQL statement
	    $statement = $this->connect->prepare($query);

	    if ($statement === false) {
	        // Handle preparation error
	        return array('error' => 'Failed to prepare the SQL statement.');
	    }

	    // Bind the red_id parameter
	    $statement->bind_param('i', $this->id);

	    // Execute the statement
	    if ($statement->execute()) {
	        $result = $statement->get_result();
	        // Fetch all results as an associative array
	        $history = $result->fetch_all(MYSQLI_ASSOC);
	    } else {
	        // Handle execution error
	        $history = array('error' => 'Failed to execute the SQL statement.');
	    }

	    // Close the statement
	    $statement->close();

	    return $history;
	}

	public function getCustomerRedeem() {
	    $query = "SELECT 
            id, 
            cust_name, 
            amount, 
            amt_paid, 
            amt_refund, 
            amt_addback, 
            amt_bal,
            (amount - (amt_addback + amt_refund + amt_paid + amt_bal)) AS remaining_balance
          FROM `redeem` 
          WHERE pg_id = ? AND cust_name = ? AND status = 'Pending' AND del = '0'
          ORDER BY id ASC 
          LIMIT 1
	   	";

	    $statement = $this->connect->prepare($query);

	    if ($statement === false) {
	        return ['error' => 'Failed to prepare the SQL statement.'];
	    }

	    $statement->bind_param('is', $this->pg_id, $this->cust_name);

	    if ($statement->execute()) {
	        $result = $statement->get_result();
	        if ($result && $result->num_rows > 0) {
	            return $result->fetch_all(MYSQLI_ASSOC);
	        } else {
	            return ['message' => 'No records found for the given customer and page.'];
	        }
	    } else {
	        return ['error' => 'Failed to execute the SQL statement.'];
	    }

	    $statement->close();
	    return [];
	}


	function getPendingRedeemCustomer(){

		$query = "
		SELECT 
            id, 
            cust_name, 
            amount, 
            amt_paid, 
            amt_refund, 
            amt_addback, 
            amt_bal,
            (amount - (amt_addback + amt_refund + amt_paid + amt_bal)) AS remaining_balance
          	FROM `redeem` 
          	WHERE pg_id = ? AND status = 'Pending' AND del = '0' 	
			ORDER BY cust_name ASC
		";

		$statement = $this->connect->prepare($query);
		$statement->bind_param('i', $this->pg_id);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $customer = $result->fetch_all();
		}
		else
		{
			$customer = array();
			
		}

		$statement->close();

		return $customer;
	}

}
?>