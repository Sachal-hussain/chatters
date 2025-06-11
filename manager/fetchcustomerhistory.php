<?php
	include('config.php');
  require_once('../connect_me.php');
  $database_connection = new Database_connection();
  $connect = $database_connection->connect(); 

if(isset($_POST['action']) && $_POST['action']=='fetch_pending_redeem' && $_POST['page_id']!=''){
	$data='';
    $delete_tab='';
	$page_id=$_POST['page_id'];

	require('../database/AddCustomer.php');

	$object= new AddCustomer();

	$object->setPgId($page_id);

	$pages=$object->getCustomerbyPage();

	$output='';
  $i=0;
  // <th scope="col">Contact No</th>
	$output.='<table class="table table-striped" id="tab_redeem">
	<thead >
        <tr>
          <th scope="col">#</th>
          <th scope="col">Customer Name</th>         
          <th scope="col">Redeem Limit</th>          
          <th scope="col">View</th>
        </tr>
  </thead>
  <tbody>';

	foreach ($pages as $key => $page) {
    $i++;
		// echo "<pre>";
		// print_r($page);
    // exit;
		
    
		$output.=' 
		<tr>
      <td>'.$i.'</td>
      <td>'.$page['name'].'</td>
      <td>'.$page['redeem_limit'].'</td>
      <td>
          <i class="btn btn-primary view_customer_transaction" data-name="'.$page['name'].'" data-pg_id="'.$page['pgid'].'" style="cursor:pointer;">View</i>
          </td>
    </tr>';
	}
	$output.=' </tbody> </table>';
	echo $output;
}

?>
<?php 
  if (isset($_POST['pgid']) && $_POST['pgid'] != '' && isset($_POST['name']) && isset($_POST['date_from']) && isset($_POST['date_to'])) {
    $pgid = $_POST['pgid'];
    $name = $_POST['name'];
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];

    $query = "SELECT cust_name, ctid, page_name, amount, amt_paid, amt_refund, amt_addback, amt_bal, tip, addback, record_by, redeem_by, redeem.status,record_time,gid, gm_id, gameinfo.g_name
              FROM redeem
              LEFT JOIN gameinfo ON gameinfo.id= redeem.gm_id
              WHERE redeem.pg_id = ? 
              AND redeem.cust_name = ?
              AND redeem.record_time BETWEEN ? AND ? 
              AND redeem.status = 'Paid'";

    $stmt = $connect->prepare($query);
    if ($stmt === false) {
      die('Error preparing the statement: ' . $connect->error);
    }
    $stmt->bind_param('isss', $pgid, $name, $date_from, $date_to);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();
    $connect->close();

    echo json_encode($data);
    exit;
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
            table.order([[0, 'asc']]).draw();
        } else {
            table = $('#tab_redeem').DataTable({
                paging: false
            });
            // Order the first column in descending order after initializing
            table.order([[0, 'asc']]).draw();
        }

       
    });
</script>
