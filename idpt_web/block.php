<?php

	$servername = "localhost";
        $username = "pacid";
        $pass = "deity";
        $dbname = "pacid";

	$var1 = "iptables";
	$var2 = "-A";
	$var3 = "INPUT";
	$var4 = "OUTPUT";
	$var5 = "-j";
	$var6 = "DROP";
	
        //create connection
        $conn = new mysqli($servername, $username, $pass, $dbname);
        //check connection
        if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
        }
        mysql_query('SET CHARACTER SET utf8');
        /*$sql_topmal = "(SELECT  `src_ip` , COUNT(  `src_ip` ) FROM convo_tbl WHERE  `class` =  'botnet' 
                        GROUP BY  `src_ip` ORDER BY COUNT(  `src_ip` ) DESC LIMIT 5 ) 
                        UNION */
        $sql_topmal = "SELECT src_ip FROM convo_tbl WHERE class = 'botnet' GROUP BY  src_ip ORDER BY COUNT(src_ip) DESC LIMIT 50";
        $result_topmalsql = $conn->query($sql_topmal);
	$cnt = mysql_num_rows($result_topmalsql);
//      $topmal = $result_topmalsql->fetch_assoc();

 //       $data_mal = array();

       if($result_topmalsql->num_rows>0){
                while($row = $result_topmalsql->fetch_assoc()){
		//	for($i=0; $i < $cnt; i++){
	                        $data_mal = $var1 . " ". $var2 . " " . $var3 . " " . $row['src_ip'] . " " . $var5 . " " . $var6	. "";
				echo "$data_mal<br/>";
		//	}
                }
        }
//	echo $data_mal;
//        $json_mal = json_encode($data_mal);

?>






