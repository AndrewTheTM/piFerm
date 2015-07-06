<?php
include("functions.php");


?>
<html>
<head>
  <title>Fermentation Chamber Status</title>
  <link rel="stylesheet" type="text/css" href="piferm.css">
  <script>
  function getStatus(){
    if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

        if(xmlhttp.responseText=="0"){
          document.getElementById("fermStatus").innerHTML="The chamber is idle.";
        }else{
          alert(xmlhttp.responseText);
        }
			}
		}
		xmlhttp.open("GET","getStatus.php",true);
		xmlhttp.send();
	}

  </script>
</head>
<body onload="getStatus();">
  <?php getHeader() ?>
  <div class="fsSpacer"></div>
  <div class="fermStatus" id="fermStatus">
  <!-- start, current step, time remaining in step, time remaining in program -->
  
  </div>
</body>
</html>
