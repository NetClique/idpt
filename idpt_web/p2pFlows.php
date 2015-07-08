<html>
<head>
<title> idPt </title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta http-equiv="refresh" content="30" />
<link href="default.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="shortcut icon" href="./images/bitslogo.png" />
<script src="./d3/d3.js"></script>
<script src="./dimple/dist/dimple.latest.js"></script>

<SCRIPT LANGUAGE="JavaScript">
function resizeIframeToFitContent(iframe) {
    // This function resizes an IFrame object
    // to fit its content.
    // The IFrame tag must have a unique ID attribute.
	var newHeight;
	var newWidth;
	if(documnet.getElementById){
		newHeight = document.getElementById(iframe).contentWindow.document.body.scrollHeight;	
	}
	document.getElementById(iframe).height = (newHeight) + "px";
}
</SCRIPT>

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
		<h2>Random Sample of P2P Flows</h2>
      
		<!--iframe  width="50%" height="1000px" marginheight="0" src="singleMdl.php" align="left" frameborder="0" id="myFrame" onLoad="resizeIframeToFitContent('myFrame');"></iframe-->
		<iframe  width="100%" height="1000px" marginheight="0" src="ensemMdl.php" align="center" frameborder="0" id="myiFrame" onLoad="resizeIframeToFitContent('myiFrame');"></iframe>

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
