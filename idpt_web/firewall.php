<html>
<head>
<title> idPt </title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="default.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="shortcut icon" href="./images/bitslogo.png" />
<script src="./d3/d3.v3.min.js"></script>
  <script src="./d3/dimple.v2.1.2.min.js"></script>
</head>



<body> 
<div id="wrap">
 	 <center>
		<?php include 'menu.php';?>
	</center>

<div id="content">

    <div id="left">
	<div class="box">
	<h2>Number of conversations of top malicious IPs</h2>
      
	<?php
        $servername = "localhost";
        $username = "pacid";
        $pass = "deity";
        $dbname = "pacid";

        //create connection
        $conn = new mysqli($servername, $username, $pass, $dbname);
        //check connection
        if($conn->connect_error){
                die("Connection failed: " . $conn->connect_error);
        }
        mysql_query('SET CHARACTER SET utf8');
        /*$sql_topmal = "(SELECT  `src_ip` , COUNT(  `src_ip` ) FROM convo_tbl WHERE  `class` =  'bo' 
			GROUP BY  `src_ip` ORDER BY COUNT(  `src_ip` ) DESC LIMIT 5 ) 
			UNION */
	$sql_topmal = "SELECT src_ip , COUNT(src_ip) FROM convo_tbl WHERE class = 'bot' AND src_ip NOT LIKE '172.16.%' GROUP BY  src_ip ORDER BY COUNT(src_ip) DESC LIMIT 50";
	$result_topmalsql = $conn->query($sql_topmal);
//	$topmal = $result_topmalsql->fetch_assoc();

	$data_mal = array();

        if($result_topmalsql->num_rows>0){
                while($row = $result_topmalsql->fetch_assoc()){
                        $data_mal[] = array_map('utf8_encode', $row);
                }
        }
        $json_mal = json_encode($data_mal);
	
?>

<div id="graphicview">
  <script type="text/javascript">
   var svg = dimple.newSvg("#graphicview", 800, 700);
   var data = <?php echo $json_mal; ?>;

   var myChart = new dimple.chart(svg, data);
// myChart.setBounds(100, 100, "70%", "80%");
   var x = myChart.addCategoryAxis("x", ["src_ip"]);
   var y1 = myChart.addMeasureAxis("y", ["COUNT(src_ip)"]);
   myChart.addSeries("src_ip", dimple.plot.bar);
   myChart.addLegend(10, 10, 700, 40, "right");
   myChart.draw(5000);
  </script>
</div>
<br/><br/>
<p>
Firewall rules for top malicious IPs: block or drop all outgoing/incoming traffic. <br>
<!--font face="Courier"> iptables -A OUTPUT -o eth0 -d [IP address] -j DROP</font-->
</p>

<p>
Sample rules:<br>
<font face="Courier"> iptables -A OUTPUT -d 111.111.111.111 -j DROP</font><br>
<font face="Courier"> iptables -A INPUT -s 111.111.111.111 -j DROP</font><br>
<font face="Courier"> iptables -A OUTPUT -s 172.16.90.23 -j BLOCK</font><br>
<font face="Courier"> iptables -A OUTPUT -s 172.16.2.138 -j BLOCK</font><br>
<font face="Courier"> iptables -A OUTPUT -s 172.16.90.8 -j BLOCK</font><br>
</p>

<!--
http://www.cyberciti.biz/faq/linux-iptables-drop/
Block Outgoing Request From LAN IP xyz
iptables -A OUTPUT -s xyz -j DROP
So - OUTPUT blocks outgoing request. INPUT blocks incoming request
-->

<!--form action="rules.php" method="POST">
	<table border="1" align="center" cellpadding="10">
		<tr><td colspan="5" align="center"style="font-weight:bold" >Iptables Rule Generator</td></tr>
		<tr>
			<td align="center"><b>IP Address</b></td>
			<td align="center"><b>Commands</b></td>
			<td align="center"><b>Connection</b></td>
			<td align="center"><b>Parameters</b></td>
			<td align="center"><b>Action</b></td>
		</tr>
			
		<tr>
			<td width="10%" align="center"><input title="enter IP address" required  pattern="^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$" height="50%" style="font-size:15px;font-weight:bold;" type="text" name="ipAddress" /></td>
			<td width="20%" align="center">
			<select style="font-size:17px;font-weight:bold;" name="commands" ><option value="-A">Append</option>
							<option value="-D">Delete</option>
							<option value="-I">Insert</option>
			</select></td>
			<td align="center"><select style="font-size:17px;font-weight:bold;" name="connection"><option value="INPUT">Input</option>
							<option value="OUTPUT">Output</option>
			</select></td>
			<td align="center"><select style="font-size:17px;font-weight:bold;" name="param">
							<option value="-j">Jump</option>
							<option value="-p">Protocol</option>
							<option value="-s">Source</option>
							<option value="-d">Destination</option>
			</select></td>
			<td align="center"><select style="font-size:17px;font-weight:bold;" name="action">
							<option value="DROP">Drop</option>
							<option value="BLOCK">Block</option>
			</select></td>
		</tr>
		<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
		<tr><td  colspan="5" align="center"><input height="50%" style="font-size:20px;font-weight:bold;" type="submit" name="Submit" value="Submit"/></td></tr>
	</table><br/><br/>
</form>

<form action="block.php" method="POST">
<p>To generate automatic rules for top malicious IPs (as above), use the automatic rule generator below:<br/><br/>
<input height="50%" style="font-size:20px;font-weight:bold;" type="submit" name="Submit" value="Generate Automatic Rules"/>

</form-->


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
