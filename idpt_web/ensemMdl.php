<?php
        $host = "localhost";
        $username = "pacid";
        $pass = "deity";
        $dbname = "pacid";

        // Connect to server and select database.
		$connection = mysql_connect($host, $username, $pass)
			or die("cannot connect"); 
		mysql_select_db($dbname)
			or die("cannot select DB");
			
        //mysql_query('SET CHARACTER SET utf8');
        /*$sql_topmal = "(SELECT  `src_ip` , COUNT(  `src_ip` ) FROM convo_tbl WHERE  `class` =  'botnet' 
			GROUP BY  `src_ip` ORDER BY COUNT(  `src_ip` ) DESC LIMIT 5 ) 
			UNION */
			
	$sql_p2pFlow = "SELECT DISTINCT src_ip,dst_ip, class FROM flow_ensem WHERE class = 'P2P' ORDER BY RAND() LIMIT 20";
	$result_p2pFlow = mysql_query($sql_p2pFlow) or die("mysql output is zero". mysql_query());
	$column_cnt = mysql_num_fields($result_p2pFlow);	
	//echo $column_cnt;
        if($column_cnt > 0){
			print("<div align=center><br/><h3><b>Classification From Ensemble Model</p></b></h3><table cellpadding=5 width=50% border=1>");
			print("<tr> <td bgcolor=silver><b>Source IP</b></td> <td bgcolor=silver><b>Destination IP</b></td> <td bgcolor=silver><b>Class</b></td> </tr>");			
                while($row1 = mysql_fetch_row($result_p2pFlow)){
						print("<tr>");
						for($cnt_col = 0; $cnt_col < $column_cnt; $cnt_col++){
							echo "<td>$row1[$cnt_col]</td>";
						}
						print("</tr>");
                }
				print("</table></div>");
        }		
		mysql_close($connection); 
?>

