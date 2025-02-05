<!doctype html>
<html lang="en">
<head>
<title> idPt </title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="description" content="Chart Title" />
<meta http-equiv="refresh" content="10" />
<link href="default.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="shortcut icon" href="./images/bitslogo.png" />
<script src="./d3/d3.js"></script>
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
		<p>
		<?php
		include ('config.php');
		
			$servername = "localhost";
		        $username = "pacid";
		        $pass = "deity";
		        $dbname = "pacid";
			$tabl_name_1 = "flow_tbl";
			$tabl_name_2 = "flow_ensem";
		        //create connection
		        $conn = new mysqli($servername, $username, $pass, $dbname);
		        //check connection
		        if($conn->connect_error){
                		die("Connection failed: " . $conn->connect_error);
        		}
			$sql_ensem_nonp2p = "SELECT COUNT(*) from $tabl_name_2 where class = 'NONP2P'";
		    $sql_ensem_p2p  = "SELECT COUNT(*) from $tabl_name_2 where class = 'P2P'";
		        
			$sql_single_p2p = "SELECT COUNT(*) FROM $tabl_name_1 WHERE class='P2P'";
			$sql_single_nonp2p = "SELECT COUNT(*) FROM $tabl_name_1 WHERE class='NONP2P'";
			
							
				//$sql_summary = "SELECT COUNT(*), SUM(total_packets), SUM(packets_sent), SUM(packets_recvd), SUM(total_payload), SUM(payload_sent), SUM(payload_recvd) from flow_tbl where duration > 0.0";

		        //$sql_bubble = "SELECT src_ip, dst_ip, duration, total_payload, class FROM convo_tbl WHERE duration > 100.0 AND total_payload <4000 ORDER BY RAND()  LIMIT 2000";
        		$sql_p2p_udp = "SELECT DISTINCT flow_id, src_ip, dst_ip, src_flow_duration, dst_flow_duration, src_pkt_cnt, dst_pkt_cnt, src_pktlen_entro, dst_pktlen_entro, src_total_bytes, proto, class FROM $tabl_name_2 WHERE proto = 17 ORDER BY RAND() LIMIT 500";
				
				$sql_udp_p2p = "SELECT DISTINCT flow_id, src_ip, dst_ip, src_flow_duration, dst_flow_duration, src_pkt_cnt, dst_pkt_cnt, src_pktlen_entro, dst_pktlen_entro, src_total_bytes, proto, class FROM $tabl_name_1 WHERE proto = 17 and class='P2P' ORDER BY RAND() LIMIT 100";
				
				$sql_udp_nonp2p = "SELECT DISTINCT flow_id, src_ip, dst_ip, src_flow_duration, dst_flow_duration, src_pkt_cnt, dst_pkt_cnt, src_pktlen_entro, dst_pktlen_entro, src_total_bytes, proto, class FROM $tabl_name_1 WHERE proto = 17 and class='NONP2P' ORDER BY RAND() LIMIT 100";
				
				
				//$result = mysql_query($sql_p2p_udp);
				//$column_count = mysql_num_fields($result);
	
	    		$sql_p2p_tcp = "SELECT DISTINCT flow_id, src_ip, dst_ip, src_flow_duration, dst_flow_duration, src_pkt_cnt, dst_pkt_cnt, src_total_bytes, proto, class FROM $tabl_name_2 WHERE proto = 6 ORDER BY RAND() LIMIT 500";
				
			///to display in table
			$sql_dis_class = "SELECT DISTINCT src_ip, dst_ip, class FROM $tabl_name_1  ORDER BY RAND() LIMIT 10;";		
			$countCol = mysql_num_fields($sql_dis_class);

			$nonp2p_count_single = $conn->query($sql_single_nonp2p);//For Single classifier
			$p2p_count_single = $conn->query($sql_single_p2p);//For Single classifier
			
			$nonp2p_count_ensem = $conn->query($sql_ensem_nonp2p);//For Ensemble classifier
			$p2p_count_ensem = $conn->query($sql_ensem_p2p);//For Ensemble classifier
			
			$sql_udp_p2p_cnt = $conn->query($sql_udp_p2p);
			$sql_udp_nonp2p_cnt = $conn->query($sql_udp_nonp2p);
			
			$row_nonp2p_single = $nonp2p_count_single->fetch_assoc();
			$row_p2p_single = $p2p_count_single->fetch_assoc();

			$row_nonp2p_ensem = $nonp2p_count_ensem->fetch_assoc();
			$row_p2p_ensem = $p2p_count_ensem->fetch_assoc();
			
			$result_p2p_udp = $conn->query($sql_p2p_udp);
			$result_p2p_tcp = $conn->query($sql_p2p_tcp);

		    $data = array();
			if($result_p2p_udp ->num_rows>0){
               			 while($row = $result_p2p_udp ->fetch_assoc()){
                        		$data[] = array_map('utf8_encode', $row);

                		}
       		 	}	
			$jsondata = json_encode($data);
			
			$data1 = array();
			if($result_p2p_tcp ->num_rows>0){
               			 while($row = $result_p2p_tcp ->fetch_assoc()){
                        		$data1[] = array_map('utf8_encode', $row);

                		}
       		 	}	

			$jsondata1 = json_encode($data1);

			$cnt_p2p = 0;
			$cnt_nonp2p = 0;
			$cls=0;
			while($cntRow = $result_p2p_tcp->fetch_assoc()){
				$cls = $cntRow->class;	
				
				print($cls);

				if($cls == "NONP2P"){
					$cnt_nonp2p = $cnt_nonp2p+1;
				}else{
					$cnt_p2p = $cnt_p2p+1;
				}
			}
						


			$data2 = array();
			if($sql_udp_p2p_cnt->num_rows > 0){
               			 while($row = $sql_udp_p2p_cnt->fetch_assoc()){
                        		$data2[] = array_map('utf8_encode', $row);
                		}
       		 	}	
			$jsondata2 = json_encode($data2);
						
			$data3 = array();
			if($sql_udp_nonp2p_cnt-> num_rows>0){
               			 while($row = $sql_udp_nonp2p_cnt->fetch_assoc()){
                        		$data3[] = array_map('utf8_encode', $row);
						}
       		 	}	
			$jsondata3 = json_encode($data3);
				
				
		$conn->close();		
		?>
		</p>
		<br/>
		<div id ="chartContainer" align="center">
		
		<script type="text/javascript" class="json">
		var svg = dimple.newSvg("#chartContainer", 600, 400);
		var data = [{"label":"P2P", "value":<?php echo $row_p2p_single['COUNT(*)']; ?>},
                          {"label":"NonP2P", "value":<?php echo $row_nonp2p_single['COUNT(*)']; ?>}
                          ];
        	      var myChart = new dimple.chart(svg, data);
	              myChart.setBounds(40, 40, 460, 360);
        	      myChart.addMeasureAxis("p", "value");
	              myChart.addSeries("label", dimple.plot.pie);
		      myChart.assignColor("NonP2P","#336600");
		      myChart.assignColor("P2P","#CC3300");
	              myChart.addLegend(500, 200, 90, 300, "left");
        	      myChart.draw();	

		svg.append("text")
		   .attr("x", myChart._xPixels() + myChart._widthPixels() / 2)
		   .attr("y", myChart._yPixels() - 20)
		   .style("text-anchor", "middle")
		   .style("font-family", "sans-serif")
		   .style("font-size", "20")
		   .style("font-style", "Italic")
		   .style("font-weight", "bold")
		   .text("P2P v/s NONP2P Flows For Bayesian Network Model");

	        </script>
		</div>

			<!--?php
                                print("<table>");
                                print("<tr><td>Src IP</td>");
                                print("<td>Dst IP</td>");
                                print("<td>Class</td></tr>");
                                while($row1 = mysql_fetch_array($sql_dis_class)){
                                        print("<tr>");
                                        for($colnum = 0; $colnum<$countCol; $colnum+++){
                                                print("<td> $row1[$colnum] </td>");
                                        }
                                }
                                print("</table>");
                        ?-->


		<div id ="chartContainer" align="center">
		<script type="text/javascript" class="json">
		var svg = dimple.newSvg("#chartContainer", 600, 400);
		var data = [{"label":"P2P", "value":<?php echo $row_p2p_ensem['COUNT(*)']; ?>},
                          {"label":"NonP2P", "value":<?php echo $row_nonp2p_ensem['COUNT(*)']; ?>}
                          ];
        	      var myChart = new dimple.chart(svg, data);
	              myChart.setBounds(40, 40, 460, 360);
        	      myChart.addMeasureAxis("p", "value");
	              myChart.addSeries("label", dimple.plot.pie);
		      myChart.assignColor("NonP2P","#336600");
		      myChart.assignColor("P2P","#CC3300");
	              myChart.addLegend(500, 200, 90, 300, "left");
        	      myChart.draw();

		svg.append("text")
		   .attr("x", myChart._xPixels() + myChart._widthPixels() / 2)
		   .attr("y", myChart._yPixels() - 20)
		   .style("text-anchor", "middle")
		   .style("font-family", "sans-serif")
		   .style("font-size", "20")
		   .style("font-style", "Italic")
		   .style("font-weight", "bold")
		   .text("P2P v/s NONP2P Flows For Ensemble Model");

	        </script>
		</div>
		
		<div  id ="graphicview" align = "center">
		<script type="text/javascript" >
			var svg = dimple.newSvg("#chartContainer", 900, 450),
			s = null, x = null, y = null, z = null;
			var chart = new dimple.chart(svg);
			x = chart.addMeasureAxis("x", "src_pkt_cnt");
			y = chart.addMeasureAxis("y", "src_flow_duration");
			z = chart.addMeasureAxis("z", "src_flow_duration");
			s = chart.addSeries(["src_ip","dst_ip","proto","class"], dimple.plot.bubble, [x, y, z]);
		 	chart.assignColor("NonP2P","#336600");
			chart.assignColor("P2P","#CC3300");
			s.data =  <?php echo $jsondata; ?>;
			chart.draw();

			svg.append("text")
			   .attr("x", chart._xPixels() + chart._widthPixels() / 2)
			   .attr("y", chart._yPixels() - 20)
			   .style("text-anchor", "middle")
			   .style("font-family", "sans-serif")
			   .style("font-size", "20")
			   .style("font-style", "Italic")
			   .style("font-weight", "bold")
			   .text("Source Packet Count Vs Flow Duration over UDP");

		</script>	
		</div>

		<div  id ="graphicview" align = "center">
		<script type="text/javascript" >
			var svg = dimple.newSvg("#chartContainer", 900, 450),
			s = null, x = null, y = null, z = null;
			var chart = new dimple.chart(svg);
			x = chart.addMeasureAxis("x", "src_pkt_cnt");
			y = chart.addMeasureAxis("y", "src_flow_duration");
			z = chart.addMeasureAxis("z", "src_flow_duration");
			s = chart.addSeries(["src_ip","dst_ip","proto","class"], dimple.plot.bubble, [x, y, z]);
		 	chart.assignColor("NonP2P","#336600");
			chart.assignColor("P2P","#CC3300");
			s.data =  <?php echo $jsondata1; ?>;
			chart.draw();

			svg.append("text")
			   .attr("x", chart._xPixels() + chart._widthPixels() / 2)
			   .attr("y", chart._yPixels() - 20)
			   .style("text-anchor", "middle")
			   .style("font-family", "sans-serif")
			   .style("font-size", "20")
			   .style("font-style", "Italic")
			   .style("font-weight", "bold")
			   .text("Source Packet Count Vs Flow Duration over TCP");

		</script>	
		</div>
			
			<!--div  id ="chartContainer" align = "center">
				<script type="text/javascript" >
					var svg = dimple.newSvg("#chartContainer", 800, 450);
					data1 = <?php echo $jsondata2; ?>;
					
					  var myChart = new dimple.chart(svg, data1);

					  myChart.setBounds(60, 60, 700, 305);
					  var x = myChart.addCategoryAxis("x", "flow_id");
					  x.addOrderRule("Date");
					  myChart.addMeasureAxis("y", "src_pktlen_entro");
					  myChart.addSeries("Source P2P", dimple.plot.line);
					  myChart.assignColor("Source P2P","#CC3300");
					  myChart.addLegend(60, 70, 500, 10, "right");
					  myChart.draw();

			svg.append("text")
			   .attr("x", myChart._xPixels() + myChart._widthPixels() / 2)
			   .attr("y", myChart._yPixels() - 20)
			   .style("text-anchor", "middle")
			   .style("font-family", "sans-serif")
			   .style("font-size", "20")
			   .style("font-style", "Italic")
			   .style("font-weight", "bold")
			   .text("Source Randomness of Payload over UDP for P2P");

				</script>
			</div>
			
			<div  id ="chartContainer" align = "center">
				<script type="text/javascript" >
					var svg = dimple.newSvg("#chartContainer", 800, 450);
					data1 = <?php echo $jsondata3; ?>;
					
					  var myChart = new dimple.chart(svg, data1);

					  myChart.setBounds(60, 60, 700, 305);
					  var x = myChart.addCategoryAxis("x", "flow_id");
					  x.addOrderRule("Date");
					  myChart.addMeasureAxis("y", "src_pktlen_entro");
					  myChart.addSeries("Source NonP2P", dimple.plot.line);
					  myChart.assignColor("Source NonP2P","#336600");
					  myChart.addLegend(60, 70, 500, 10, "right");
					  myChart.draw();

			svg.append("text")
			   .attr("x", myChart._xPixels() + myChart._widthPixels() / 2)
			   .attr("y", myChart._yPixels() - 20)
			   .style("text-anchor", "middle")
			   .style("font-family", "sans-serif")
			   .style("font-size", "20")
			   .style("font-style", "Italic")
			   .style("font-weight", "bold")
			   .text("Source Randomness of Payload over UDP for NonP2P");

				</script>
			</div-->
			
			<!--div  id="graphicview" align = "center">
		
			<script type="text/javascript" >
				var svg = dimple.newSvg("#graphicview", 800, 500);
			   var data = <?php echo $jsondata1; ?>;

			   var myChart = new dimple.chart(svg, data);
			   var x = myChart.addCategoryAxis("x", ["src_pkt_cnt"]);
			   var y1 = myChart.addMeasureAxis("y", ["src_flow_duration"]);
			   myChart.addSeries("class", dimple.plot.bar);
			   myChart.addLegend(65, 10, 510, 20, "right");
			   myChart.draw(5000);
			   chart.draw();
			</script>
			</div>
				
			<div  id="graphicview" align = "center">
		
			<script type="text/javascript" >
				var svg = dimple.newSvg("#graphicview", 800, 500);
			   var data = <?php echo $jsondata1; ?>;
			   var myChart = new dimple.chart(svg, data);
			   var x = myChart.addCategoryAxis("x", ["dst_pkt_cnt"]);
			   var y1 = myChart.addMeasureAxis("y", ["dst_flow_duration"]);
			   myChart.addSeries("class", dimple.plot.bar);
			   myChart.addLegend(65, 10, 510, 20, "right");
			   myChart.draw(5000);
			   chart.draw();
			</script>
			</div-->		
		</div><!--Box Division Ends-->
	</div><!--Left Division Ends-->


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
