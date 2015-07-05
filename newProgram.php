<?php
$Name = $_POST["ProgName"];
$PriTime = $_POST["PriTime"];
$PriTemp = $_POST["PriTemp"];
$DiaTime = $_POST["DiaTime"];
$DiaTemp = $_POST["DiaTemp"];
$LagerTime = $_POST["LagerTime"];
$LagerTemp = $_POST["LagerTemp"];

$db = new PDO('sqlite:db/fermpi.db');
$sql = "INSERT INTO fermSchedules (profileName, primaryTemp, primaryDays, diacetylRestTemp, diacetylRestDays, lagerTemp, lagerDays)";
$sql .= "VALUES ('".$Name."',".$PriTemp.",".$PriTime.",".$DiaTemp.",".$DiaTime.",".$LagerTemp.",".$LagerTime.")";

echo($sql);

$fs = $db->prepare($sql);
$fs->execute();

?>
