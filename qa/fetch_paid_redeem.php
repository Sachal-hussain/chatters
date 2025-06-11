
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../connect_me.php');

// // Create a database connection instance
// $database_connection = new Database_connection();
// $connect = $database_connection->connect();
//  print_r($connect);
//  exit;
// DB table to use
$table = 'redeem';
 

$primaryKey = 'id';
 
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'inform_status', 'dt' => 1,),
    array( 'db' => 'record_time', 'dt' => 2 ),
    array( 'db' => 'redeemed_date', 'dt' => 3 ),
    array( 'db' => 'record_by',  'dt' => 4 ),
    array( 'db' => 'cust_name',   'dt' => 5 ),
    array( 'db' => 'redeem_by', 'dt' => 6,),
    array( 'db' => 'page_name', 'dt' => 7,),
    array( 'db' => 'gid', 'dt' => 8,),
    array( 'db' => 'ctid', 'dt' => 9,),
    array( 'db' => 'comment', 'dt' => 10,),
    array( 'db' => 'paidbyclient', 'dt' => 11,),
    array( 'db' => 'clientname', 'dt' => 12,),
    array( 'db' => 'amount', 'dt' => 13,),
    array( 'db' => 'tip', 'dt' => 14,),
    array( 'db' => 'addback', 'dt' => 15,),
    array( 'db' => 'status', 'dt' => 17,),
    array('db' => 'informed_at', 'dt' => 21)
);
 
// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'shj_db',
    'host' => 'localhost'
);
 
$where = "status ='Paid'";

require( '../redeem/vendor/DataTables/server-side/scripts/ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$where)
);