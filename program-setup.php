<?php
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare("SELECT fermScheduleId, profileName FROM fermSchedules");
$fs->execute();
$fermScheds = $fs->fetchAll();

include("functions.php");
?>
<html>
<head>
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

function changeTimesTemps(){
	var sql="sql=UPDATE fermSchedules SET primaryTemp="+document.getElementById("priTempInput").value+",";
	sql+="primaryDays="+document.getElementById("priTimeInput").value+",";
	sql+="diacetylRestTemp="+document.getElementById("diaTempInput").value+",";
	sql+="diacetylRestDays="+document.getElementById("diaTimeInput").value+",";
	sql+="lagerTemp="+document.getElementById("lagerTempInput").value+",";
	sql+="lagerDays="+document.getElementById("lagerTimeInput").value;
	sql+=" WHERE fermScheduleId="+document.getElementById("fermScheduleId").value;
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			alert(xmlhttp.responseText);
		}
	}
	xmlhttp.open("POST","updateProgram.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(sql);
}
</script>
</head>
<body onLoad="getProg();">
<?php getHeader() ?>
<form>
	<select id="fermSched" onChange="getProg();">
		<?php 
			foreach($fermScheds as $profile)
				print "<option value=\"".$profile["fermScheduleId"]."\">".$profile["profileName"]."</option>\n";
		?>
	</select>
</form>

<div class="list-row">
	<form><input type="hidden" id="fermScheduleId">
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
		<button type="button" onClick="changeTimesTemps();">Update</button>
	</form>
</div>
	
</body>
</html>
