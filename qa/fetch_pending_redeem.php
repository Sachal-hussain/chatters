<?php
	session_start();
  if (!isset($_SESSION["user_data"]) || empty($_SESSION["user_data"])) {
    // Redirect to the login page
    header("Location: ../login.php"); // Adjust the URL to your login page
    exit; // Stop further execution
  }

  $uid = $_SESSION["user_data"]["id"];
  $fname = $_SESSION["user_data"]["fname"];
  $uname = $_SESSION["user_data"]["uname"];
  $email = $_SESSION["user_data"]["email"];
  $contact = $_SESSION["user_data"]["contact"];
  $type = $_SESSION["user_data"]["type"];
  $avtar = $_SESSION["user_data"]["avtar"];
  $online = $_SESSION["user_data"]["online"];
  $token = $_SESSION["user_data"]["token"];

if(isset($_POST['action']) && $_POST['action']=='fetch_pending_redeem' && $_POST['page_id']!=''){
	$data='';
    $delete_tab='';
	$page_id=$_POST['page_id'];

	require('../database/Redeem.php');

	$object= new Redeem();

	$object->setPgId($page_id);

	$pages=$object->getRedeemById();

	$output='';
  $action='';

	$output.='<table class="table table-striped" id="tab_redeem">
	<thead >
        <tr>
          <th scope="col">Date</th>
          <th scope="col">Agent Name</th>
          <th scope="col">Page Name</th>
          <th scope="col">Customer Name</th>
          <th scope="col">Contact No</th>
          <th scope="col">Game ID</th>
          <th scope="col">Cash Tag</th>
          <th scope="col">Amount</th>
          <th scope="col">Tip</th>
          <th scope="col">Add Back</th>
          <th scope="col">Added Back (R)</th>
          <th scope="col">Refunded (R)</th>
          <th scope="col">Paid (R)</th>
          <th scope="col">Tip (R)</th>
          <th scope="col">Remaining Redeem Amount</th>
          <th scope="col">Comments</th>
          <th scope="col">Manager Comments</th>
          <th scope="col">Images (R)</th>          
          <th scope="col">Images</th>
          <th scope="col">Delete</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>

        </tr>
  </thead>
  <tbody>';

	foreach ($pages as $key => $page) {
		// echo "<pre>";
		// print_r($page);
		$redeem_amount=$page[15]-$page[16]-$page[17]-$page[18]-$page[19]-$page[22]-$page[23];
		if($type=='Manager' || $type=='Webmaster' ){
  		
			$data='<i class="bx bx-show-alt view_redeem_btn" data-id="'.$page[0].'" data-pg_id="'.$page[8].'" data-agent_name="'.$page[25].'" data-amount="'.$redeem_amount.'" style="cursor:pointer;"></i>';
      $delete_tab='<i class="bx bx-x delete_redeem_btn" data-id="'.$page[0].'" data-pg_id="'.$page[8].'" data-agent_name="'.$page[25].'" data-amount="'.$redeem_amount.'" style="cursor:pointer;"></i>';
      $action='<i class=" bx bx-edit edit_redeem_btn" data-id="'.$page[0].'" data-pg_id="'.$page[8].'" data-agent_name="'.$page[25].'" data-amount="'.$redeem_amount.'" data-gameid="'.$page[6].'" data-castag="'.$page[7].'" style="cursor:pointer;"></i>';
      
  	}
    if($type=='Redeem'){

      $action='<i class=" bx bx-edit edit_redeem_btn" data-id="'.$page[0].'" data-pg_id="'.$page[8].'" data-agent_name="'.$page[25].'" data-amount="'.$redeem_amount.'" data-gameid="'.$page[6].'" data-castag="'.$page[7].'" style="cursor:pointer;"></i>';      
    }
		$output.=' 
		<tr>
          <th scope="row">'.$page[24].'</th>
          <td>'.$page[25].'</td>
          <td>'.$page[9].'</td>
          <td>'.$page[3].'</td>
          <td>'.$page[21].'</td>
          <td>'.$page[6].'</td>
          <td>'.$page[7].'</td>
          <td class="bg-danger-subtle  text-center">$'.$page[15].'</td>
          <td>$'.$page[22].'</td>
          <td>$'.$page[23].'</td>
          <td>$'.$page[18].'</td>
          <td class="bg-success text-white text-center">$'.$page[17].'</td>
          <td>$'.$page[16].'</td>
          <td>$'.$page[19].'</td>
          <td class="bg-info text-white text-center">$'.$redeem_amount.'</td>
          <td>'.$page[13].'</td>
          <td>'.$page[14].'</td>
          <td><a href="#" class="view_images_modal" data-id="'.$page[0].'" data-type="Redeem Attachment">View</a> </td>   
          <td><a href="#" class="view_images_modal" data-id="'.$page[0].'" data-type="CSR Redeem Attachmen">View</a> </td>  
          <td class="font-size-22">'. $delete_tab.'</td>     
          <td><span class="text-primary">'.$page[27].'</span></td>
          <td>
            '.$data.'
          	'.$action.'
          </td>

        </tr>';
	}
	$output.=' </tbody> </table>';
	echo $output;
}

?>
<?php
if(isset($_POST['action']) && $_POST['action']=='fetch_cashapp_totals' && $_POST['cashapp_id']!=''){
    $cashapp_id=$_POST['cashapp_id'];

    require('../database/CashappTransaction.php');

    $object= new CashappTransaction();

    $object->setCappid($cashapp_id);

    $results=$object->getCashappTransactionById();
    
    $output='';
    $output.='<table class="table table-striped" id="tab_cashapp">
    <thead >
        <tr>
          <th scope="col">Date</th>
          <th scope="col">Total Amount</th>
          <!--<th scope="col">Page Name</th>
          <th scope="col">Game ID</th>
          <th scope="col">Cash Tag</th>
          <th scope="col">Amount</th>
          <th scope="col">Tip</th>
          <th scope="col">Add Back</th>
          <th scope="col">Redeem Amount</th>
          <th scope="col">View Images</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th> -->

        </tr>
    </thead>
    <tbody>';
    foreach ($results as $key => $rows) {
        // echo "<pre>";
        // print_r($page);
        $output.=' 
        <tr>
          <th scope="row">'.$rows[0].'</th>
          <td>'.intval($rows[1]).'</td>
         
        </tr>';
    }
    $output.=' </tbody> </table>';

    echo $output;
}
?>

<script>
    $(document).ready(function () {
        // $('#tab_redeem').DataTable({
        //     "order": [[0, 'desc']],
        // });
	   if ($.fn.dataTable.isDataTable('#tab_redeem')) {
            table = $('#tab_redeem').DataTable();
            // Order the first column in descending order after initializing
            table.order([[0, 'desc']]).draw();
        } else {
            table = $('#tab_redeem').DataTable({
                paging: false
            });
            // Order the first column in descending order after initializing
            table.order([[0, 'desc']]).draw();
        }

        if ( $.fn.dataTable.isDataTable( '#tab_cashapp' ) ) {
            table = $('#tab_cashapp').DataTable();
        }
        else {
            table = $('#tab_cashapp').DataTable( {
                paging: false
            } );
        }
    });
</script>
<!-- <td>'.$data.'
            <i class="ri-edit-box-line edit_redeem_btn" data-id="'.$page[0].'" data-pg_id="'.$page[8].'" data-agent_name="'.$page[26].'" data-amount="'.$redeem_amount.'" style="cursor:pointer;"></i>
          </td> -->