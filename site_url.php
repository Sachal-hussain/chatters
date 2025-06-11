<?php
	// $url='http://shjchatters.com/chatterworking/';
	$url='http://192.168.100.9/chatterworking/';
	
	// main folder
	define("site_url", $url);
	define("manager_checklist", $url."check_list");
	define("manager_previousdata", $url."googlesheet");
	
	
	
	
	// admin folder
	define("admin_dashboard", $url."admin/dashboard");
	define("add_users", $url."admin/addusers");
	define("deleted_redeem", $url."admin/deletedredeem");
	define("paidredeem_list", $url."admin/paidredeemlist");
	define("pendingredeem_list", $url."admin/pendingredeemlist");
	define("profitreport", $url."admin/profit_report");
	define("depositreport", $url."admin/deposit_report");
	define("deposithistory", $url."admin/deposit_history");
	define("addpages", $url."admin/addpages.php");


	
	// redeem folder

	define("pages_list", $url."redeem/allpageslist");
	define("paid_redeem_list", $url."redeem/paidredeemlist");
	define("failed_redeem_list", $url."redeem/failedredeemlist");
	define("pending_redeem_list", $url."redeem/pendingredeemlist");
	define("add_cashtag", $url."redeem/addcashtag");
	define("cashapp_details", $url."redeem/cashapplist");
	define("redeem_report", $url."redeem/redeem_report");
	define("EOD", $url."redeem/shift_end");
	define("addcustomer", $url."redeem/addcustomers");
	define("redc2ctags", $url."redeem/c2ctags");
	define("update_deposit", $url."redeem/update_deposit");
	define("c2cform", $url."redeem/c2cform");

	

	// manager folder
	define("manager_reports", $url."manager/reports");
	define("agent_shuff_form", $url."manager/agentshufflingform");
	define("agent_shuff_list", $url."manager/agentshufflingdetails");
	define("unprocessredeemlist", $url."manager/unprocessredeemdetails");
	define("alluser_list", $url."manager/alluserdetails");
	define("hourly_update", $url."manager/check_list");
	define("shift_record", $url."manager/shift_records");
	define("shift_reports", $url."manager/shift_reports");
	define("pages_report", $url."manager/pages_report");
	define("add_game_deposits", $url."manager/add_game_deposits");
	define("gamestrorereport", $url."manager/gamestrorereport");
	define("redeemapproval", $url."manager/redeemapproval");
	define("redeemlimit", $url."manager/redeem_limit");
	define("customerapproval", $url."manager/customerapproval");
	define("customerhistory", $url."manager/customerhistory");

	// ticket folder
	define("tickets", $url."ticket/index");
	
	
	// agents folder
	define("redeemfrom", $url."agents/redeem_form");
	define("unprocessredeemform", $url."agents/addunprocessredeem");
	define("paid_radeem_list_agent", $url."agents/agentpaidredeemlist");
	define("allgamess", $url."agents/allgamess");
	define("depositform", $url."agents/deposit_form");
	define("agentdeposit_history", $url."agents/deposithistory");
	define("add_customer", $url."agents/addcustomers");
	define("pending_radeem_list_agent", $url."agents/agentpendingredeemlist");
	define("unprocessredeemlists", $url."agents/unprocessredeemdetails");
	define("applyleave", $url."agents/applyleave");
	define("leavehistory", $url."agents/leavehistory");
	define("c2ctags", $url."agents/c2ctags");


	// q&a folder
	define("unprocessredeem", $url."qa/unprocessredeemdetails");
	define("pendingredeem", $url."qa/pendingredeemlist");
	define("paidredeem", $url."qa/paidredeemlist");
	define("qac2ctags", $url."qa/c2ctags");






?>