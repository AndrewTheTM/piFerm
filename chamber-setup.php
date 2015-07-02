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
if($busy>0)
  $isBusy=True;


// Should return the time in epoch seconds, which is what Python is looking for

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
    var fsid = document.getElementById("fermSched").value;
    if(window.XMLHttpRequest){
      xmlhttp2 = new XMLHttpRequest();
    }else{
      xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp2.onreadystatechange = function(){
      if(xmlhttp2.readyState == 4 && xmlhttp2.status == 200){
        //TODO: reload page!
      }
    }
    xmlhttp2.open("POST","setStart.php",true);
    xmlhttp2.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp2.send("ts="+fsid);
    xmlhttp2.close;

  }
  </script>
</head>
<body onload="getProg();">
  <?php getHeader() ?>

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
    </form>
    <?php }else{ ?>
      <p>The fermenter is busy!</p>
      <?php
        //TODO: fermenter program status and control
        /*
         * Tell the user that the fermenter is in use, with what, since when
         * and how long in current step and entire program.
         * Then give the user a chance to advance the program (which would adjust
         * the timestamp by the amount necessary) or to drop the program altogether
         * and to set the fermentation chamber to hold a value
         */

         //If you can read this, you don't need glasses.
         ?>
    <?php } ?>

</body>
