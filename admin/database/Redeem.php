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
	private $del;
	private $reply;
	private $paidbyclient;
	private $clientname;
	private $redeemed_date;



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
		$this->record_time = $record_time;
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

	function setRedeemedDate($redeemed_date)
	{
		$this->redeemed_date = $redeemed_date;
	}

	function getRedeemedDate()
	{
		return $this->redeemed_date;
	}

	function createRedeem(){

		$query=" INSERT INTO redeem (user_id,cust_name,date,gid,ctid,pg_id,page_name,amount,contact,tip,addback,record_time,record_by,redeemed_date,status) 
        values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('issssisdsddssss', $this->user_id,$this->cust_name,$this->date,$this->gid,$this->ctid,$this->pg_id,$this->page_name,$this->amount,$this->contact,$this->tip,$this->addback,$this->record_time,$this->record_by,$this->redeemed_date,$this->status);
	
		if($statement->execute()){
		
			return $statement->insert_id;
		}
		else{

			return false;
		}
	}

	function getRedeemById(){
		$query = "
		SELECT * from redeem
		WHERE pg_id=?
		ANd status='Pending'
		AND del='0'		
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
	    $selectQuery = "SELECT amt_paid, amt_refund, amt_addback FROM redeem WHERE id = ?";
	    $selectStatement = $this->connect->prepare($selectQuery);
	    $selectStatement->bind_param('i', $this->id);
	    $selectStatement->execute();
	    $result = $selectStatement->get_result();
	    
	    if ($row = $result->fetch_assoc()) {
	        // Add the new refund and add-back amounts to the existing amounts
	        $newAmtPaid = $row['amt_paid'] + + $this->amt_paid;
	        $newAmtRefund = $row['amt_refund'] + $this->amt_refund;
	        $newAmtAddback = $row['amt_addback'] + $this->amt_addback;

	        // Now, update the record in the database with the new amounts
	        $updateQuery = "
	            UPDATE redeem
	            SET status = ?, 
	                redeem_by = ?, 
	                amt_paid = ?, 
	                amt_refund = ?, 
	                amt_addback = ?,
	                comment=?,
	                paidbyclient=?,
	                clientname=?,
	                redeemed_date=?
	            WHERE id = ?
	        ";
	        
	        $updateStatement = $this->connect->prepare($updateQuery);
	        $updateStatement->bind_param('ssdddssssi', 
	            $this->status, 
	            $this->redeem_by, 
	            $newAmtPaid, 
	            $newAmtRefund, 
	            $newAmtAddback,
	            $this->comment,
	            $this->paidbyclient,
	            $this->clientname, 
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

	function getPaidredeemdetails(){

		$query = "SELECT 
	    redeem.*,cashapptrans.paytype,cashapptrans.amount as total,cashapptrans.createdat as create_at,cashapptrans.comments as redeem_comments,redeem.status as rdm_status,cashapp.name as cpname,cashapp.cashtag as ctag
	    FROM
	    redeem
	    JOIN cashapptrans ON 
	    redeem.id=cashapptrans.red_id
	    JOIN cashapp ON
	    cashapptrans.cappid=cashapp.id
	    WHERE redeem.id=?
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
		SET amount = ?, tip=?, addback=?,reply=? 
		WHERE id = ?
		";

		$statement = $this->connect->prepare($query);

		$statement->bind_param('dddsi', $this->amount,$this->tip,$this->addback,$this->reply,$this->id);

		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}


	}

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

	function searchResults($searchQuery){

		$query = "SELECT * FROM redeem WHERE (LOWER(cust_name) LIKE '%" . $searchQuery . "%' OR LOWER(gid) LIKE '%" . $searchQuery . "%') AND status = 'Pending'";

        $statement = $this->connect->prepare($query);

        try {
			if ($statement->execute()) {
				$result = $statement->get_result();
				$output = $result->fetch_all();
			} else {
				$output = array();
			}
		} catch (Exception $error) {
			echo $error->getMessage();
		}

		return $output;



	}
}
?>