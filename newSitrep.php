<?php
$beer = $_POST["beer"];
$status = $_POST["status"];

$sql = "INSERT INTO sitrep (beverageName, statusText) VALUES ('".$beer."','".$status."')";

$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare($sql);
$count = $fs->execute() or die(print_r($fs->errorInfo(), true));

?>
