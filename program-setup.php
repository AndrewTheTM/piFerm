<?php
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare("SELECT profileName FROM fermSchedules;");
$fermScheds = $fs->fetchAll();
print_r($fermScheds);

?>
<html>
<head>
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