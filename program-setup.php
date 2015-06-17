<?
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare("SELECT profileName FROM fermSchedules");
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
function getProg(progName){
	if(progName != ""){
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				document.getElementById("id").prop = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","getProgram.php?q="+progName,true);
		xmlhttp.send();
	}
}
</script>
</head>
<body>

<!-- <form>
	<select name="fermSched">
		<?php 
			foreach($fermScheds as $profileName)
				print $profileName;
		?>
</form>-->

</body>
</html>
