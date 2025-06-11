<?php

class CashappTransaction
{
	private $id;
	private $red_id;
	private $cappid;
	private $paidfor;
	private $pgid;
	private $paytype;
	private $amount;
	private $withdraw;
	private $comments;
	private $redeem_by;
	private $status;
	private $createdat;
	private $payment_method;
	private $from_cust;

	

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

	function setRedId($red_id)
	{
		$this->red_id = $red_id;
	}

	function getRedId()
	{
		return $this->red_id;
	}

	function setCappid($cappid)
	{
		$this->cappid = $cappid;
	}

	function getCappid()
	{
		return $this->cappid;
	}

	function setPaidfor($paidfor)
	{
		$this->paidfor = $paidfor;
	}

	function getPaidfor()
	{
		return $this->paidfor;
	}

	function setPgid($pgid)
	{
		$this->pgid = $pgid;
	}

	function getPgid()
	{
		return $this->pgid;
	}

	function setPaytype($paytype)
	{
		$this->paytype = $paytype;
	}

	function getPaytype()
	{
		return $this->paytype;
	}

	function setAmount($amount)
	{
		$this->amount = $amount;
	}

	function getAmount()
	{
		return $this->amount;
	}

	function setWithdraw($withdraw)
	{
		$this->withdraw = $withdraw;
	}

	function getWithdraw()
	{
		return $this->withdraw;
	}

	function setComments($comments)
	{
		$this->comments = $comments;
	}

	function getComments()
	{
		return $this->comments;
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

	function setCreatedat($createdat)
	{
		$this->createdat = date('Y-m-d H:i:s');
	}

	function getCreatedat()
	{
		return $this->createdat;
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

	function saveTransaction(){
		
		$query = "INSERT INTO cashapptrans (red_id,cappid,paidfor,pgid,paytype,amount,comments,status,createdat,redeem_by,payment_method) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?)
        ";

        $statement = $this->connect->prepare($query);

        $statement->bind_param('iisisdsssss', $this->red_id,$this->cappid,$this->paidfor,$this->pgid,$this->paytype,$this->amount,$this->comments,$this->status,$this->createdat,$this->redeem_by,$this->payment_method);
	
		if($statement->execute()){
		
			return true;
		}
		else{

			return false;
		}
	}

	function getCashappTransactionById(){
		$query = "
		SELECT DATE(createdat) AS transaction_day, SUM(amount) AS total_amount
		FROM `cashapptrans`
		WHERE cappid=?
		GROUP BY DATE(createdat)
		ORDER BY transaction_day;
		";

		$statement = $this->connect->prepare($query);
		$statement->bind_param('i', $this->cappid);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $details = $result->fetch_all();
		}
		else
		{
			$details = array();
			
		}

		$statement->close();

		return $details;
	}

}

?>