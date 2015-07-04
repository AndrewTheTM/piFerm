<?php
$sql = "DELETE FROM fermStatus";
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare($sql);
$count = $fs->execute() or die(print_r($fs->errorInfo(), true));
echo $count;
?>
