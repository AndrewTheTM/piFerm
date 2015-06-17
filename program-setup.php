<?
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare("SELECT fermScheduleId, profileName FROM fermSchedules");
$fs->execute();
$fermScheds = $fs->fetchAll();
?>
<html>
<head>
<script>
function getProg(){
	var progName = document.getElementById("fermSched").value;
	alert(progName);
	if(progName != ""){
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				//document.getElementById("id").prop = xmlhttp.responseText;
				alert(xmlhttp.responseText);
				/*
				xmlhttp.responseText = 
					[{"fermScheduleId":"1","0":"1","profileName":"Vienna Lager","1":"Vienna Lager","primaryTemp":"56","2":"56","primaryDays":"14","3":"14","diacetylRestTemp":"60","4":"60","diacetylRestDays":"2","5":"2","lagerTemp":"40","6":"40","lagerDays":"14","7":"14"}]
					*/
			}
		}
		xmlhttp.open("GET","getProgram.php?q="+progName,true);
		xmlhttp.send();
	}
	
}
</script>
</head>
<body onLoad="getProg();">

<form>
	<select id="fermSched" onChange="getProg();">
		<?php 
			foreach($fermScheds as $profile)
				print "<option value=\"".$profile["fermScheduleId"]."\">".$profile["profileName"]."</option>\n";
		?>
	</select>
</form>

</body>
</html>
