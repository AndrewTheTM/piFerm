<?php

//$sqlCreateFermStatus = "CREATE TABLE fermStatus(fermStatusId INTEGER PRIMARY KEY AUTOINCREMENT, eventID INTEGER, timeStamp INTEGER);";

/*
 * $ts is the eventID, which is the ID of the fermentation program being run
 */

$ts = $_POST["ts"];

$currTime = time();
$sql = "INSERT INTO fermStatus(eventID,timeStamp) VALUES(".$ts.",".$currTime.")";
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare($sql);
$count = $fs->execute() or die(print_r($fs->errorInfo(), true));


?>
