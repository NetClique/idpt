<html>
<head>
<title> idPt </title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta http-equiv="refresh" content="30" />
<link href="default.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="shortcut icon" href="./images/bitslogo.png" />
<script src="./d3/d3.js"></script>
<script src="./d3/dimple.v2.1.2.min.js"></script>
<!--script src="http://dimplejs.org/dist/dimple.v2.1.2.min.js"></script-->
</head>



<body> 
<div id="wrap">
	<center>
		<?php include 'menu.php';?>
	</center>

<div id="content">

    <div id="left">
	<div class="box">
	<h2>Top 20 - P2P IPs</h2>
      
	<?php
        $host = "localhost";
        $username = "pacid";
        $pass = "deity";
        $dbname = "pacid";

        // Connect to server and select database.
		mysql_connect($host, $username, $pass)
			or die("cannot connect"); 
		mysql_select_db($dbname)
			or die("cannot select DB");
			
        //mysql_query('SET CHARACTER SET utf8');
        /*$sql_topmal = "(SELECT  `src_ip` , COUNT(  `src_ip` ) FROM convo_tbl WHERE  `class` =  'botnet' 
			GROUP BY  `src_ip` ORDER BY COUNT(  `src_ip` ) DESC LIMIT 5 ) 
			UNION */
			
	$sql_topP2P = "SELECT src_ip,src_port, COUNT(src_ip) FROM flow_tbl WHERE class = 'P2P' GROUP BY  src_ip ORDER BY COUNT(src_ip) DESC LIMIT 20";
	$result_topP2Psql = mysql_query($sql_topP2P) or die("mysql output is zero". mysql_query());
	$column_count = mysql_num_rows($result_topP2Psql);
	
	$data_p2p = array();

        if($column_count>0){
                while($row = mysql_fetch_assoc($result_topP2Psql)){
                        $data_p2p[] = $row;
                }
        }
        $json_p2p = json_encode($data_p2p);
	
?>

<div id="graphicview">
  <script type="text/javascript">
   var svg = dimple.newSvg("#graphicview", 800, 800);
   var data_tmp = <?php echo $json_p2p; ?>;   
   var myChart = new dimple.chart(svg, data_tmp);
  // myChart.setBounds(100, 100, "70%", "80%");
   var x = myChart.addCategoryAxis("x", ["src_ip"]);
   var y = myChart.addMeasureAxis("y", ["COUNT(src_ip)"]);
   var s = myChart.addSeries("src_ip", dimple.plot.bar);
   s.lineMarkers = true;
   myChart.addLegend(80, 10, 600, 30, "right");
   myChart.draw();
  </script>
</div>

</div>
</div>
		

   
 <p><img src="./images/bitslines.png" alt="" width="670" border="0" align="left"></p> 
</div> <!-- Division content ends here-->	 

	

<div id="clear"></div>
  </div>
  <div id="footer">
    <p>&copy;2015 BITS-Pilani. All rights reserved</a></p>
  </div>
</div>
</body>
</html>
