<?
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare("SELECT fermScheduleId, profileName FROM fermSchedules");
$fs->execute();
$fermScheds = $fs->fetchAll();
/*
for($i=0;$i<count($fermScheds);$i++){
	//print_r($fermScheds[$i]);
	echo $fermScheds[$i]["profileName"];
	echo "<br />";
}
*/

?>
<html>
<head>
<script>
function getProg(){
	var progName = document.getElementById(fermSched).value;
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
			}
		}
		xmlhttp.open("GET","getProgram.php?q="+progName,true);
		xmlhttp.send();
	}
	
}
</script>
</head>
<body>

<form>
	<select name="fermSched" onChange="getProg()>
		<?php 
			foreach($fermScheds as $profile)
				print "<option value=\"".$profile["fermScheduleId"]."\">".$profile["profileName"]."</option>";
				//print_r($profile);
		?>
	</select>
</form>

</body>
</html>
