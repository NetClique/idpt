<!DOCTYPE html>
<html>
<head>
<title> PACID </title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<link href="default.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="shortcut icon" href="./images/bitslogo.png" />
<script src="./d3/d3.v3.min.js"></script>
<script src="./d3/dimple.v2.1.2.min.js"></script>
</head>



<body>
<div id="wrap">
  <div id="top">
        <h1> <center>P.A.C.I.D. </center></h1><br>
        <h2> <center>P2P Aware Classifier & Intrusion Detector</center></h2>
        <br>
  </div> <!-- division top ends here -->
 <div id="h_nav_bar"> <center>
                <?php include 'menu.php';?>
        </center>
</div>
<div id="content">

    <div id="left">
        <div class="box">
      <center><h2>Web Attack Statistics</h2></center>

<div id="chartContainer">
 <script type="text/javascript">
	var svg = dimple.newSvg("#chartContainer", 700, 400);
      	d3.csv("output.csv", function (data) {
	data.forEach(function(d) { 
   	 console.log(d);
		});
        var myChart = new dimple.chart(svg, data);
        myChart.setBounds(100, 30, 550, 330);
        myChart.addCategoryAxis("x", "Country");
        myChart.addMeasureAxis("y","IAT");
//        myChart.addMeasureAxis("z", "");
	//myChart.assignColor("Lvel-2", "#336600");
        myChart.addSeries(["IP","Level"], dimple.plot.bubble);
        myChart.addLegend(200, 10, 360, 20, "right");
        myChart.draw();
      });
 </script>
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
