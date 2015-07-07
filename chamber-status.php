<?php
include("functions.php");

$db = new PDO('sqlite:db/fermpi.db');
$cs = $db->prepare("SELECT eventID, timeStamp FROM fermStatus");
$cs->execute();
$currStat = $cs->fetchAll();


$profId = $currStat[0]["eventID"];

$fs = $db->prepare("SELECT * FROM fermSchedules WHERE fermScheduleId=".$profId);
$fs->execute();
$fermScheds = $fs->fetchAll();

$currTime = time();
$dur = $currTime - $currStat[0]["timeStamp"];

$durDay = $dur / 3600 / 24;
$currSetTemp = 50;

if($durDay<=$fermScheds[0]["primaryDays"]){
  //echo "In primary";
  $currSetTemp = $fermScheds[0]["primaryTemp"];
}elseif($durDay<=($fermScheds[0]["primaryDays"]+$fermScheds[0]["diacetylRestDays"])){
  echo "In diacetyl rest";
  $currSetTemp = $fermScheds[0]["diacetylRestTemp"];
}elseif($durDay<=($fermScheds[0]["primaryDays"]+$fermScheds[0]["diacetylRestDays"]+$fermScheds[0]["lagerDays"])){
  echo "in Lager";
  $currSetTemp = $fermScheds[0]["lagerTemp"];
}else{
  echo "past lager";
  $currSetTemp = $fermScheds[0]["lagerTemp"];
}

$currTempFile = fopen("current_temperature", "r");
$currTemp = fread($currTempFile,filesize("current_temperature"));

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
<body>
  <?php getHeader() ?>
  <div class="fsSpacer"></div>
  <div class="fermStatus" id="fermStatus">
    <p>Currently running the <?php echo $fermScheds[0]["profileName"]; ?> program</p>
    <p>Chamber is currently at <?php echo $currTemp; ?>&deg;F and set at <?php echo $currSetTemp; ?>&deg;F</p>


  <!-- start, current step, time remaining in step, time remaining in program -->

  </div>
</body>
</html>
