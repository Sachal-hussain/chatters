<?php

class ManagerRedeem
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


	function approvalRedeemEntry(){

		$query = "
		UPDATE redeem
		SET approval = ? 
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

}
?>