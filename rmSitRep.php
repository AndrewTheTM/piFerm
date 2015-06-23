<?php
$cmd = $_POST["id"];
$sql = "DELETE FROM sitrep WHERE sitrepId=".$cmd;
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare($sql);
$count = $fs->execute() or die(print_r($fs->errorInfo(), true));

?>
