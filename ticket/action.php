<?php
 	require_once('../connect_me.php');
    $database_connection = new Database_connection();
    $connect = $database_connection->connect();

if(isset($_POST['type'],$_POST['action'],$_POST['shift']) && $_POST['type']!="" && $_POST['action']=='getassigneuser'){
    
    $type = $_POST['type'];
    $shift = $_POST['shift'];
    $opt_staff = "";

    if($shift=='noshift'){
       $query = mysqli_query($connect, " SELECT id,fullname,type FROM user 
        WHERE department='$type' and status='Active';"
        );
        if(mysqli_num_rows($query) > 0){
            while($row=mysqli_fetch_array($query)){
                // $id=$row['id'];
                // $pagename=$row['pagename'];
                $opt_staff.='<option value="'.$row['id'].'">'.$row['fullname'].'</option>';
                // echo "<pre>";
                //  print_r($row); 
            }
            if($opt_staff){

                echo $opt_staff;
            }
            else{
                echo '<option value="#">No Record</option>';
            }
        }  

    }
    else{

        $query = mysqli_query($connect, " SELECT id,fullname,type FROM user 
    		WHERE department='$type' and shift='$shift' and status='Active';"
        );
        if(mysqli_num_rows($query) > 0){
            while($row=mysqli_fetch_array($query)){
                // $id=$row['id'];
                // $pagename=$row['pagename'];
                $opt_staff.='<option value="'.$row['id'].'">'.$row['fullname'].'</option>';
                // echo "<pre>";
                //  print_r($row); 
            }
            if($opt_staff){

    	        echo $opt_staff;
    	    }
    	    else{
    	        echo '<option value="#">No Record</option>';
    	    }
        }
    }
    
} 








?>