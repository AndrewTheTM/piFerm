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

function newProgram(){
	var newProgName = document.getElementById("newName").value;
	var newPriTime = document.getElementById("newPriTime").value;
	var newPriTemp = document.getElementById("newPriTemp").value;
	var newDiaTime = document.getElementById("newDiaTime").value;
	var newDiaTemp = document.getElementById("newDiaTemp").value;
	var newLagerTime = document.getElementById("newLagerTime").value;
	var newLagerTemp = document.getElementById("newLagerTemp").value;

	if(window.XMLHttpRequest){
		xmlhttp2 = new XMLHttpRequest();
	}else{
		xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.onreadystatechange = function(){
		if(xmlhttp2.readyState == 4 && xmlhttp.status == 200){
			location.reload();
		}
	}
	xmlhttp2.open("POST","newProgram.php",true);
	xmlhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp2.send("ProgName="+newProgName+"&PriTime="+newPriTime+"&PriTemp="+newPriTemp+"&DiaTime="+newDiaTime+"&DiaTemp="+newDiaTemp+"&LagerTime="+newLagerTime+"&LagerTemp="+newLagerTemp);
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

	<form>
		<div class"list-row">
			<p style="height: 20px;"><h1>New Program</h1></p>
			<div class="list-group" id="newN">
				<div class="list-title">Name</div>
				<div class="list-upper"><input type="text" id="newName" style="width: 100px;"></div>
				<div class="list-lower"></div>
			</div>
		</div>

		<div class="list-row">
			<div class="list-group" id="newPrimary">
				<div class="list-title">Primary</div>
				<div class="list-upper"><input type="text" id="newPriTime"> days</div>
				<div class="list-lower"><input type="text" id="newPriTemp"> &deg;F</div>
			</div>

			<div class="list-group" id="newDiacetyl">
				<div class="list-title">Diacetyl Rest</div>
				<div class="list-upper"><input type="text" id="newDiaTime"> days</div>
				<div class="list-lower"><input type="text" id="newDiaTemp"> &deg;F</div>
			</div>

			<div class="list-group" id="newLager">
				<div class="list-title">Lager</div>
				<div class="list-upper"><input type="text" id="newLagerTime"> days</div>
				<div class="list-lower"><input type="text" id="newLagerTemp"> &deg;F</div>
			</div>
			<button type="button" onclick="newProgram();">Add Program</button>
		</div>
	</form>
</body>
</html>
