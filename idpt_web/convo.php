<!DOCTYPE html>
<html>
<head>
<title> idPt </title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta http-equiv="refresh" content="60" />
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
      <center><h2>Summary Statistics</h2></center>
	
<p>
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
	$sql_benign = "SELECT COUNT(*) from convo_tbl where class = 'benign'";
	$sql_botnet = "SELECT COUNT(*) from convo_tbl where class = 'bot'";
	//$sql_count = "SELECT (SELECT COUNT(*) FROM convo_tbl where class='bot') AS botcount,
   // (SELECT COUNT(*) FROM convo_tbl where class='benign') AS p2pcount";
	$sql_summary = "SELECT COUNT(*), SUM(total_packets), SUM(packets_sent), SUM(packets_recvd), SUM(total_payload), SUM(payload_sent), SUM(payload_recvd) from convo_tbl where duration > 0.0";
	
	$sql_bubble = "SELECT convo_id, src_ip, dst_ip, duration, total_payload, compression_ratio, total_packets, class FROM convo_tbl  WHERE total_payload>5 and duration>1 and total_payload<1000 and total_packets>5 ORDER BY RAND() LIMIT 1000";
// WHERE duration > 10.0 AND total_payload <10 AND total_payload!=0 ORDER BY RAND() LIMIT 2000";
	$sql_fft = "SELECT convo_id, src_ip, dst_ip, compression_ratio, primewave_payload, primewave_iat, class FROM convo_tbl WHERE primewave_payload>2 AND compression_ratio>0.0 AND primewave_iat>2 and primewave_payload<20000 and primewave_iat<20 ORDER BY RAND() LIMIT 50"; 

	$bot_count = $conn->query($sql_botnet);
	$ben_count = $conn->query($sql_benign);
	$row_bot = $bot_count->fetch_assoc();
	$row_ben = $ben_count->fetch_assoc();
	//$json_count = json_encode($row_count); 

	$result_summary = $conn->query($sql_summary);
	$result_bubble = $conn->query($sql_bubble);
	$result_fft = $conn->query($sql_fft);
	
	$data = array();
	
//	echo mysql_num_rows($result_bubble);
	if($result_bubble->num_rows>0){
		while($row = $result_bubble->fetch_assoc()){
			$data[] = array_map('utf8_encode', $row);
			
		}
	}
	
  	  
	$jsondata = json_encode($data); 
//	echo $jsondata;
	//querying for the summary statistics data
	$row_summary = $result_summary->fetch_assoc();
	// queries for fft data	
	$data2 = array();
        if($result_fft->num_rows>0){
//		echo "inside if";
                while($row2 = $result_fft->fetch_assoc()){
//			echo "inside while";
			//echo $data2;
                        $data2[] = array_map('utf8_encode', $row2);

                }
        }
        $jsondata2 = json_encode($data2);
	$conn->close();
?>
</p>
<!--table border="1" style="width:80%">
<tr>
 <td-->
<center><p>
<table border="1" style="width:60%;font-size:13pt;" cellpadding="5" >
	<tbody align="center">
	<tr>
		<td>Total conversations</td>
		<td width="25%"><?php echo"{$row_summary['COUNT(*)']}" ?></td>
	</tr>

	<tr>
		<td>Total packets exchanged</td>
		<td width="25%"><?php echo"{$row_summary['SUM(total_packets)']}" ?></td>
	</tr>

	<tr>
		<td>Total packets sent</td>
		<td width="25%"><?php echo"{$row_summary['SUM(packets_sent)']}" ?></td>
	</tr>

	<tr>
		<td>Total packets received</td>
		<td width="25%"><?php echo"{$row_summary['SUM(packets_recvd)']}" ?></td>
	</tr>	

	<tr>
		<td>Total bytes exchanged</td>
		<td width="25%"><?php echo"{$row_summary['SUM(total_payload)']}" ?></td>
	</tr>	

	<tr>
		<td>Total bytes sent</td>
		<td width="25%"><?php echo"{$row_summary['SUM(payload_sent)']}" ?></td>
	</tr>	

	<tr>
		<td>Total bytes received</td>
		<td width="25%"><?php echo"{$row_summary['SUM(payload_recvd)']}" ?></td>
	</tr>	

</tbody>
</table>
 <!--/td>
 <td-->
<br><br>
<!--h2>Bot v/s Benign P2P conversations</h2-->
<div id ="chartContainer">
          <script type="text/javascript">
            var svg = dimple.newSvg("#chartContainer", 600, 400);
            var data = [{"label":"Benign", "value":<?php echo $row_ben['COUNT(*)']; ?>},
                          {"label":"Bot", "value":<?php echo $row_bot['COUNT(*)']; ?>}
                          ];
              var myChart = new dimple.chart(svg, data);
              myChart.setBounds(40, 40, 460, 360);
              myChart.addMeasureAxis("p", "value");
              myChart.addSeries("label", dimple.plot.pie);
	      myChart.assignColor("Bot","#FFA07A");
	      myChart.assignColor("Benign","#ADD8E6");
              myChart.addLegend(500, 200, 90, 300, "left");
              myChart.draw();

		svg.append("text")
                   .attr("x", myChart._xPixels() + myChart._widthPixels() / 2)
                   .attr("y", myChart._yPixels() - 20)
                   .style("text-anchor", "middle")
                   .style("font-family", "sans-serif")
                   .style("font-size", "16")
                   .style("font-weight", "bold")
                   .text("Benign v/s Bot");

          </script>
</div>

</p></center>
 <!--/td>
</tr>
</table-->

<!--h2>Tracking <i>"Low Volume, High Duration"</i> conversations</h2-->
<div id="chartContainer">
<script type="text/javascript">
 document.write("\n\n\n");

	var svg = dimple.newSvg("#chartContainer", 900, 550),
	s = null,
	x = null,
	y = null;
	var chart = new dimple.chart(svg);
	x = chart.addMeasureAxis("x", "total_payload");
	y = chart.addMeasureAxis("y", "duration");
	z = chart.addMeasureAxis("z", "compression_ratio");
	s = chart.addSeries(["convo_id","src_ip","dst_ip","class"], dimple.plot.bubble, [x, y]);
	chart.assignColor("bot","#FFA07A");
        chart.assignColor("benign","#ADD8E6");
	s.data =  <?php echo $jsondata; ?>;
	chart.draw();
	document.write('<br/>');//does this work?
	
	svg.append("text")
		.attr("x", chart._xPixels() + chart._widthPixels() / 2)
                .attr("y", chart._yPixels() - 20)
                .style("text-anchor", "middle")
                .style("font-family", "sans-serif")
                .style("font-size", "16")
                .style("font-weight", "bold")
                .text("Tracking 'low volume' and 'high duration' conversations");
  </script>
</div>
<!--h2>Charts for compression_ratio(payload), fourier_transform(payload) and fourier_transform(iat)</h2-->

<div id="graphicview">
  <script type="text/javascript">
   var svg = dimple.newSvg("#graphicview", 800, 650);
   var data = <?php echo $jsondata2; ?>;

   var myChart = new dimple.chart(svg, data);
// myChart.setBounds(100, 100, "70%", "80%");
   var x = myChart.addCategoryAxis("x", ["convo_id"]);
   var y1 = myChart.addMeasureAxis("y", ["compression_ratio"]);
   myChart.addSeries("class", dimple.plot.bar);
//   myChart.addLegend(65, 10, 510, 20, "right");
myChart.assignColor("bot","#FFA07A");
myChart.assignColor("benign","#ADD8E6");
   myChart.draw(5000);

	svg.append("text")
                .attr("x", myChart._xPixels() + chart._widthPixels() / 2)
                .attr("y", myChart._yPixels() - 20)
                .style("text-anchor", "middle")
                .style("font-family", "sans-serif")
                .style("font-size", "16")
                .style("font-weight", "bold")
                .text("Compression ratio over Payload length");
  </script>
</div>

<div id="graphicview">
  <script type="text/javascript">
   var svg = dimple.newSvg("#graphicview", 800, 650);
   var data = <?php echo $jsondata2; ?>;

   var myChart = new dimple.chart(svg, data);
// myChart.setBounds(100, 100, "70%", "80%");
   var x = myChart.addCategoryAxis("x", ["convo_id"]);
   var y1 = myChart.addMeasureAxis("y", ["primewave_payload"]);
   myChart.addSeries("class", dimple.plot.bar);
 //  myChart.addLegend(65, 10, 510, 20, "right");
myChart.assignColor("bot","#FFA07A");
myChart.assignColor("benign","#ADD8E6");
   myChart.draw(5000);

 svg.append("text")
                .attr("x", myChart._xPixels() + chart._widthPixels() / 2)
                .attr("y", myChart._yPixels() - 20)
                .style("text-anchor", "middle")
                .style("font-family", "sans-serif")
                .style("font-size", "16")
                .style("font-weight", "bold")
                .text("Fourier transform on Payload length");
  </script>
</div>

<!--div id="graphicview">
  <script type="text/javascript">
   var svg = dimple.newSvg("#graphicview", 800, 500);
   var data = <?php echo $jsondata2; ?>;

   var myChart = new dimple.chart(svg, data);
// myChart.setBounds(100, 100, "70%", "80%");
   var x = myChart.addCategoryAxis("x", ["convo_id"]);
   var y1 = myChart.addMeasureAxis("y", ["primewave_iat"]);
   myChart.addSeries("class", dimple.plot.bar);
   myChart.addLegend(65, 10, 510, 20, "right");
   myChart.draw(5000);
  </script>
</div-->

<div id="chartContainer">
<script type="text/javascript">

        var svg = dimple.newSvg("#chartContainer", 800, 750),
        s = null,
        x = null,
        y = null;
        var chart = new dimple.chart(svg);
        x = chart.addCategoryAxis("x", "primewave_iat");
        y = chart.addCategoryAxis("y", "primewave_payload");
        z = chart.addMeasureAxis("z", "compression_ratio");
        s = chart.addSeries(["src_ip","dst_ip","class"], dimple.plot.bubble, [x, y,z]);
        chart.assignColor("bot","#FFA07A");
        chart.assignColor("benign","#ADD8E6");
        s.data =  <?php echo $jsondata2; ?>;
        chart.draw();
        document.write("\n\n\n");//does this work?
        
        svg.append("text")
                .attr("x", chart._xPixels() + chart._widthPixels() / 2)
                .attr("y", chart._yPixels() - 20)
                .style("text-anchor", "middle")
                .style("font-family", "sans-serif")
                .style("font-size", "16")
                .style("font-weight", "bold")
                .text("Fourier transforms and Compression ratio");
  </script>
<br/>
<br/>
<br/>
<br/>
</div>
</div><!-- Division box ends here-->
</div><!-- Division left ends here-->
		

   
<p><img src="./images/bitslines.png" alt="" width="670" border="0" align="left"></p> 
</div> <!-- Division content ends here-->	 

	

<div id="clear"></div>

  <div id="footer">
    <p>&copy;2015 BITS-Pilani. All rights reserved</p>
  </div>

</body>
</html>

