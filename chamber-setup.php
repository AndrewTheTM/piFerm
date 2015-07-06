<?php
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare("SELECT fermScheduleId, profileName FROM fermSchedules");
$fs->execute();
$fermScheds = $fs->fetchAll();

include("functions.php");

$cs = $db->prepare("SELECT eventID, timeStamp FROM fermStatus");
$cs->execute();
$status = $cs->fetchAll();

$busy = count($status);
$isBusy = False;
if($busy>0){
  if($status[0]["eventID"]==99){
    $isBusy == False;
    $holding == True;

  }
  $isBusy = True;
  //TODO: There needs to be a special hold code and the program react appropriately

  $currTime = time();
  $busySince = $status[0]["timeStamp"];
  $diffTime = $currTime - $status[0]["timeStamp"];

  $dt = new DateTime("@$busySince");
  $hrd = date_create($dt->format("Y-m-d H:i:s"),new DateTimeZone("UTC"))->setTimeZone(new DateTimeZone("America/New_York"))->format("m-d-Y H:i:s");

  $fermBusyLine = "The fermenter has been busy since " . $hrd . "<br/>";
  $busyDays = intval($diffTime / 24 / 3600);
  $busyHours = intval($diffTime / 3600 - $busyDays * 24 + 0.5);
  $fermBusyLine2 = "The fermenter has been running this program for " . $busyDays . " days and " . $busyHours . " hours.<br />";

  $fsp = $db->prepare("SELECT fermScheduleId, profileName, primaryDays, diacetylRestDays, lagerDays FROM fermSchedules WHERE fermScheduleId=".$status[0]["eventID"]);
  $fsp->execute();
  $fermScheds = $fsp->fetchAll();

  $enlapsedDays = intval(($diffTime / 24 / 3600) * 100) / 100;
  $enlapsedHours = intval(($diffTime / 3600) * 100) / 100;
  if($enlapsedDays <= $fermScheds[0]["primaryDays"]){
    // currently in Primary
    $remainHours = ($fermScheds[0]["primaryDays"] * 24) - $enlapsedHours;
    $totRemainHours = ($fermScheds[0]["primaryDays"] + $fermScheds[0]["diacetylRestDays"] + $fermScheds[0]["lagerDays"]) * 24;

    $enlStepPct = intval(($enlapsedHours/$remainHours) * 100) / 100;
    $enlTotPct = intval(($enlapsedHours/$totRemainHours) * 100) / 100;

    $fermBusyLine3 = "The fermenter is currently in PRIMARY.  It's been there for ".$enlapsedHours." hours and has ".$remainHours." hours remaining in the current portion.</br>";
    $fermBusyLine3 .= "This is ".$enlStepPct."% of the current step and ".$enlTotPct."% of the entire process.";
  }else if($enlapsedDays <= $fermScheds[0]["primaryDays"] + $fermScheds[0]["diacetylRestDays"]){
    // currently in Diacetyl Rest
    $remainHours = (($fermScheds[0]["primaryDays"] + $fermScheds[0]["diacetylRestDays"]) * 24) - $enlapsedHours;
    $totRemainHours = ($fermScheds[0]["primaryDays"] + $fermScheds[0]["diacetylRestDays"] + $fermScheds[0]["lagerDays"]) * 24;

    $enlStepPct = intval(($enlapsedHours/$remainHours) * 100) / 100;
    $enlTotPct = intval(($enlapsedHours/$totRemainHours) * 100) / 100;

    $fermBusyLine3 = "The fermenter is currently in diacetyl rest.  It's been there for ".$enlapsedHours." hours and has ".$remainHours." hours remaining in the current portion.</br>";
    $fermBusyLine3 .= "This is ".$enlStepPct."% of the current step and ".$enlTotPct."% of the entire process.";
  }else if($enlapsedDays <= $fermScheds[0]["primaryDays"] + $fermScheds[0]["diacetylRestDays"] + $fermScheds[0]["lagerDays"]){
    // currently in lager
    $remainHours = (($fermScheds[0]["primaryDays"] + $fermScheds[0]["diacetylRestDays"] + $fermScheds[0]["lagerDays"]) * 24) - $enlapsedHours;
    $totRemainHours = ($fermScheds[0]["primaryDays"] + $fermScheds[0]["diacetylRestDays"] + $fermScheds[0]["lagerDays"]) * 24;

    $enlStepPct = intval(($enlapsedHours/$remainHours) * 100) / 100;
    $enlTotPct = intval(($enlapsedHours/$totRemainHours) * 100) / 100;

    $fermBusyLine3 = "The fermenter is currently lagering.  It's been there for ".$enlapsedHours." hours and has ".$remainHours." hours remaining in the current portion.</br>";
    $fermBusyLine3 .= "This is ".$enlStepPct."% of the current step and ".$enlTotPct."% of the entire process.";
  }else{
    // past lager
    $remainHours = 0;
    $totRemainHours = 0;

    $enlStepPct = 100;
    $enlTotPct = 100;

    $fermBusyLine3 = "The fermenter is lagering, although the lagering phase is complete.  It's been there for ".$enlapsedHours." hours and has ".$remainHours." hours remaining in the current portion.</br>";
    $fermBusyLine3 .= "This is ".$enlStepPct."% of the current step and ".$enlTotPct."% of the entire process.";
  }
}

?>
<html>
<head>
  <title>Fermentation Chamber Setup</title>
  <link rel="stylesheet" type="text/css" href="piferm.css">
  <script>
  function getProg(){
  	var progName = document.getElementById("fermSched").value;
  	if(progName != ""){
  		if(window.XMLHttpRequest){
  			xmlhttp = new XMLHttpRequest();
  		}else{
  			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  		}
  		xmlhttp.onreadystatechange = function(){
  			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
  				var json1 = JSON.parse(xmlhttp.responseText);
  				var json=json1[0];
  				document.getElementById("fermScheduleId").value=json["fermScheduleId"];
  				document.getElementById("priTimeInput").value=json["primaryDays"];
  				document.getElementById("priTempInput").value=json["primaryTemp"];
  				document.getElementById("diaTimeInput").value=json["diacetylRestDays"];
  				document.getElementById("diaTempInput").value=json["diacetylRestTemp"];
  				document.getElementById("lagerTimeInput").value=json["lagerDays"];
  				document.getElementById("lagerTempInput").value=json["lagerTemp"];
  			}
  		}
  		xmlhttp.open("GET","getProgram.php?q="+progName,true);
  		xmlhttp.send();
  	}
  }

  function startFerm(){
    //document.getElementById("dimMe").show;
    //document.getElementById("dimMe").zIndex="100";
    var fsid = document.getElementById("fermSched").value;
    if(window.XMLHttpRequest){
      xmlhttp2 = new XMLHttpRequest();
    }else{
      xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp2.onreadystatechange = function(){
      if(xmlhttp2.readyState == 4 && xmlhttp2.status == 200){
        location.reload();
      }
    }
    xmlhttp2.open("POST","setStart.php",true);
    xmlhttp2.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp2.send("ts="+fsid);
    xmlhttp2.close;

  }

  function removeProgram(){
    //document.getElementById("dimMe").show;

    if (confirm('Are you sure you want kill the current program? THIS CANNOT BE UNDONE')) {
      if(window.XMLHttpRequest){
        xmlhttp3 = new XMLHttpRequest();
      }else{
        xmlhttp3 = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp3.onreadystatechange = function(){
        if(xmlhttp3.readyState == 4 && xmlhttp3.status == 200){
          location.reload();
        }
      }
      xmlhttp3.open("GET","rmFermProg.php",true);
      xmlhttp3.setRequestHeader("Content-type","application/x-www-form-urlencoded");
      xmlhttp3.send();
      xmlhttp3.close;
    }
  }

  function adjustProgram(){
    //TODO: move program forward or backward by adjusting the timestamp
  }
  </script>
</head>
<body>
  <?php getHeader() ?>
  <div id="dimMe"></div>
  <?php if(!$isBusy){ ?>
    <form>
      <select id="fermSched" onChange="getProg();">
    		<?php
    			foreach($fermScheds as $profile)
    				print "<option value=\"".$profile["fermScheduleId"]."\">".$profile["profileName"]."</option>\n";
    		?>
    	</select>
    </form>

  	<form>
      <input type="hidden" id="fermScheduleId">
      <div class="list-row">
    		<div class="list-group" id="primary">
    			<div class="list-title">Primary</div>
    			<div class="list-upper" id="priTime"><input type="text" id="priTimeInput"> days</div>
    			<div class="list-lower" id="priTemp"><input type="text" id="priTempInput"> &deg;F</div>
    		</div>

    		<div class="list-group" id="diacetyl">
    			<div class="list-title">Diacetyl Rest</div>
    			<div class="list-upper" id="diaTime"><input type="text" id="diaTimeInput"> days</div>
    			<div class="list-lower" id="diaTemp"><input type="text" id="diaTempInput"> &deg;F</div>
    		</div>

    		<div class="list-group" id="lager">
    			<div class="list-title">Lager</div>
    			<div class="list-upper" id="lagerTime"><input type="text" id="lagerTimeInput"> days</div>
    			<div class="list-lower" id="lagerTemp"><input type="text" id="lagerTempInput"> &deg;F</div>
    		</div>
      </div>

      <div class="list-row">
        <div class="list-group" id="startbutton">
          <div class="list-title">
            <img src="/images/starticon.png" onclick="startFerm();" />
          </div>
        </div>
      </div>
      <script> getProg(); </script>
      <!-- TODO: hold temperature -->
    </form>
    <?php }else{ ?>
      <p><h1>The fermenter is busy!</h1></p>
      <p><?php
        echo $fermBusyLine;
        echo $fermBusyLine2;
        echo $fermBusyLine3;

       ?></p>
      <form>
        <img src="images/KillButton.png" onclick="removeProgram();" />
      <?php
        //TODO: fermenter program control (other than killing)
        /*
         * Give the user a chance to advance the program (which would adjust
         * the timestamp by the amount necessary)
         */
         ?>
    <?php } ?>

</body>
