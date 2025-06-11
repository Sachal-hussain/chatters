<?php
	include('config.php');

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
  // <th scope="col">Contact No</th>
	$output.='<table class="table table-bordered" id="tab_redeem">
	<thead >
        <tr>
          <th scope="col">Date</th>
          <th scope="col">Agent Name</th>
          <th scope="col">Page Name</th>
          <th scope="col">Customer Name</th>
          
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
          <th scope="col">Images</th>';
          if(($type=='Manager' && $department=='Redeem') || $type=='Webmaster' ){
          $output .= '<th scope="col">Delete</th>';
          }
          $output .= '<th scope="col">Status</th>
          <th scope="col">Action</th>

        </tr>
  </thead>
  <tbody>';

  $total_remaining_amount = 0;
	foreach ($pages as $key => $page) {
		// echo "<pre>";
		// print_r($page);
    $record_time = new DateTime($page['record_time']);
    $record_time = new DateTime($page['record_time']);
    $current_time = new DateTime();
    $time_difference = $current_time->getTimestamp() - $record_time->getTimestamp();
    $hours_difference = $time_difference / 3600; // Convert seconds to hours

    // Determine the class for each <td> based on time difference
    $td_class = '';
    if ($hours_difference > 0.5 && $hours_difference <= 3) {
      $td_class = 'bg-warning-subtle  font-size-16'; // Greater than 1 hour and less than or equal to 3 hours
    } elseif ($hours_difference > 3 && $hours_difference <= 11.9833) {
        $td_class = ' bg-primary-subtle  font-size-16'; // Greater than 3 hours and less than or equal to 24 hours
    } elseif ($hours_difference > 12){
        $td_class = 'bg-danger-subtle  font-size-16'; // Greater than 24 hours
    }

		$redeem_amount=$page['amount']-$page['amt_paid']-$page['amt_refund']-$page['amt_addback']-$page['amt_bal']-$page['tip']-$page['addback'];
    $total_remaining_amount += $redeem_amount;
		if(($type=='Manager' && $department=='Redeem') || $type=='Webmaster' ){
  		
			$data='<i class="btn btn-info mb-1 view_redeem_btn" data-id="'.$page['id'].'" data-pg_id="'.$page['pg_id'].'" data-agent_name="'.$page['record_by'].'" data-amount="'.$redeem_amount.'" data-custname="'.$page['cust_name'].'" data-gameid="'.$page['gid'].'" data-cashtag="'.$page['ctid'].'" style="cursor:pointer;">Update</i>';
      $delete_tab='<i class="btn btn-danger delete_redeem_btn" data-id="'.$page['id'].'" data-pg_id="'.$page['pg_id'].'" data-agent_name="'.$page['record_by'].'" data-amount="'.$redeem_amount.'" style="cursor:pointer;">Delete</i>';
      $action='<i class="btn btn-primary btn-sm edit_redeem_btn" data-id="'.$page['id'].'" data-pg_id="'.$page['pg_id'].'" data-agent_name="'.$page['record_by'].'" data-amount="'.$redeem_amount.'" data-gameid="'.$page['gid'].'" data-castag="'.$page['ctid'].'" data-clientname="'.$page['redeemfor'].'"style="cursor:pointer;">Pay Redeem</i>';
      
  	}
    if($type=='Redeem'){
      
      $action='<i class="btn btn-primary btn-sm edit_redeem_btn" data-id="'.$page['id'].'" data-pg_id="'.$page['pg_id'].'" data-agent_name="'.$page['record_by'].'" data-amount="'.$redeem_amount.'" data-gameid="'.$page['gid'].'" data-castag="'.$page['ctid'].'" data-clientname="'.$page['redeemfor'].'" style="cursor:pointer;">Pay Redeem</i>';      
    }
    // <td>'.$page[21].'</td>
		$output.=' 
		  <tr>
        <td class="' . $td_class . '">' . $page['record_time'] . '</td>
        <td class="' . $td_class . '">' . $page['record_by'] . '</td>
        <td class="' . $td_class . '">' . $page['ref_page'] . '</td>
        <td class="' . $td_class . '">' . $page['cust_name'] . '</td>
        <td class="' . $td_class . '">' . $page['gid'] . '</td>
        <td class="' . $td_class . '">' . $page['ctid'] . '</td>
        <td class="' . $td_class . ' bg-danger-subtle text-center">$' . $page['amount'] . '</td>
        <td class="' . $td_class . '">$' . $page['tip'] . '</td>
        <td class="' . $td_class . '">$' . $page['addback'] . '</td>
        <td class="' . $td_class . '">$' . $page['amt_addback'] . '</td>
        <td class=" bg-success text-white text-center">$' . $page['amt_refund'] . '</td>
        <td class="' . $td_class . '">$' . $page['amt_paid'] . '</td>
        <td class="' . $td_class . '">$' . $page['amt_bal'] . '</td>
        <td class=" bg-info text-white text-center">$' . $redeem_amount . '</td>
        <td class="' . $td_class . ' remarks-text" style="cursor:pointer;" data-id="'.$page['id'].'">' . $page['comment'] . '</td>
        <td class="' . $td_class . '">' . $page['reply'] . '</td>
        <td class="' . $td_class . '"><a href="#" class="view_images_modal badge rounded-pill bg-primary" data-id="' . $page['id'] . '" data-type="Redeem Attachment">View</a></td>
        <td class="' . $td_class . '"><a href="#" class="view_images_modal badge rounded-pill bg-primary" data-id="' . $page['id'] . '" data-type="CSR Redeem Attachmen">View</a></td>';
          if(($type=='Manager' && $department=='Redeem') || $type=='Webmaster' ){ 
          $output.='<td class="font-size-22">'. $delete_tab.'</td> '; 
          }   
          $output.='<td><span class="badge rounded-pill bg-primary">'.$page['status'].'</span></td>
          <td>
            '.$data.'
          	'.$action.'
          </td>

      </tr>';
	}
  $output .= '</tbody>
      <tfoot>
        <tr>
          <td colspan="13" class="text-center font-weight-bold">Total Remaining Redeem Amount:</td>
          <td colspan="8" class="bg-info text-white font-weight-bold">$' . number_format($total_remaining_amount, 2) . '</td>
        </tr>
      </tfoot>
    </table>'
  ;
	echo $output;
}

?>
<?php
if(isset($_POST['action']) && $_POST['action']=='fetch_cashapp_totals' && $_POST['pageid']!=''){
  $pageid=$_POST['pageid'];
  $i=0;
  require('../database/Cashapp.php');

  $object= new Cashapp();

  $object->setPgid($pageid);

  $results=$object->getCashAppPage();
  
  $output='';
  $output.='<table class="table table-bordered" id="tab_cashapp">
  <thead >
      <tr>
        <th scope="col">#</th>
        <th scope="col">Cashapp Name</th>
        <th scope="col">Cash Tag</th>
        <th scope="col">Current Balance</th>
        <th scope="col">Remarks</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>

      </tr>
  </thead>
  <tbody>';
  foreach ($results as $key => $rows) {
    $i++;
    // echo "<pre>";
    // print_r($rows);
    $rowClass = ($rows['status'] === 'closed') ? 'bg-danger-subtle font-size-18' : 'bg-success-subtle font-size-18';
    $output.=' 
    <tr >
      <th scope="row" class="' . $rowClass . '">'.$i.'</th>
      
      <td class="' . $rowClass . '">'.$rows['name'].'</td>
      <td class="' . $rowClass . '">'.$rows['cashtag'].'</td>
      <td class="' . $rowClass . '">'.$rows['balance'].'</td>
      <td class="' . $rowClass . '">'.$rows['remarks'].'</td>
      <td class="' . $rowClass . '">'.$rows['status'].'</td>
      <td><a href="#" class="btn btn-primary cashappupdate-mdl" data-id="' . $rows['id'] . '" data-pgid="'.$rows['pgid'].'" data-bs-toggle="modal" data-bs-target="#updatecashtag">Update</a></td>

     
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
        var table = $('#tab_redeem').DataTable();
        table.order([[0, 'desc']]).draw();
    } else {
        var table = $('#tab_redeem').DataTable({
            paging: false
        });
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