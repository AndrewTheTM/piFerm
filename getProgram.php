<?php
$profId = $_GET["q"];
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare("SELECT * FROM fermSchedules WHERE fermScheduleId=".$profId);
$fs->execute();
$fermScheds = $fs->fetchAll();
print json_encode($fermScheds);
?>