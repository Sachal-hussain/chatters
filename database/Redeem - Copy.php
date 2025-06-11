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

	function createRedeem() {
		
	   	$limitQuery = "SELECT red_limit FROM redeem_limit WHERE pg_id = ? LIMIT 1";
	    $limitStatement = $this->connect->prepare($limitQuery);
	    $limitStatement->bind_param('i', $this->pg_id);
	    $limitStatement->execute();
	    $limitResult = $limitStatement->get_result();
	    $limitRow = $limitResult->fetch_assoc();
	    
	    $monthlyLimit = $limitRow['red_limit'] ?? 5000; // Set a default value if not found

	    // Debugging output
	    // echo "Monthly limit: " . $monthlyLimit . "<br>";

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
	    if ($dailyTotalAmount + $this->amount > 500) {
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
	    $query = "INSERT INTO redeem (user_id, cust_name, date, gid, ctid, pg_id, page_name, amount, contact, tip, addback, record_time, record_by, redeemed_date, status, redeemfor) 
	              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	              
	    $statement = $this->connect->prepare($query);
	    $statement->bind_param('issssisdsddsssss', $this->user_id, $this->cust_name, $this->date, $this->gid, $this->ctid, $this->pg_id, $this->page_name, $this->amount, $this->contact, $this->tip, $this->addback, $this->record_time, $this->record_by, $this->redeemed_date, $this->status, $this->redeemfor);

	    if ($statement->execute()) {
	        echo json_encode(['status' => 'success']);
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
		ANd status='Pending'
		AND del='0'
		AND approval='0'		
		ORDER BY id DESC
		";

		$statement = $this->connect->prepare($query);
		$statement->bind_param('i', $this->pg_id);
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
	    $selectQuery = "SELECT amt_paid, amt_refund, amt_addback,amt_bal FROM redeem WHERE id = ?";
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
	                redeemfrom=?
	            WHERE id = ?
	        ";
	        
	        $updateStatement = $this->connect->prepare($updateQuery);
	        $updateStatement->bind_param('ssddddssssssi', 
	            $this->status, 
	            $this->redeem_by, 
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
	                redeem.*,cashapptrans.paytype,cashapptrans.amount as total,cashapptrans.createdat as create_at,cashapptrans.comments as redeem_comments,redeem.status as rdm_status,cashapp.name as cpname,cashapp.cashtag as ctag
	            FROM
	                redeem
	            JOIN cashapptrans ON 
	                redeem.id=cashapptrans.red_id
	            JOIN cashapp ON
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
		SET comment = ?
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('si',$this->comment,$this->id);

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
		AND status='Active'
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
		SET inform_status = ?
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('ii',$this->inform_status,$this->id);

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

}
?>