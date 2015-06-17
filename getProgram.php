<?php
$profId = $_GET["q"];
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare("SELECT profileName FROM fermSchedules WHERE fermScheduleId=".$profId);
$fs->execute();
$fermScheds = $fs->fetchAll();
/*
for($i=0;$i<count($fermScheds);$i++){
	//print_r($fermScheds[$i]);
	echo $fermScheds[$i]["profileName"];
	echo "<br />";
}
*/

//print_r($fermScheds);

print json_encode($fermScheds);
?>