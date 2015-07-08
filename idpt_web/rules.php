<?php

$var = "iptables";

if(isset($_POST['ipAddress']) && isset($_POST['commands']) && isset($_POST['connection']) && isset($_POST['param']) && 
   isset($_POST['action'])  ) {


    $data = $var . " " . $_POST['commands'] . " " . $_POST['connection'] . " " . $_POST['ipAddress'] . " " . $_POST['param'] . " "             . $_POST['action'] . "\n";
        
        //echo $data;

    $ret = file_put_contents('/home/bits/rules/rules.txt', $data, FILE_APPEND | LOCK_EX);
	//file should already exist, set to permission 777 (risky!!) 

    if($ret == false) {
        die('There was an error writing this file');
    }
    else {
		
		header("Location: firewall.php");
		die();
   }
}
else {

   die('no post data to process');
}

?>
