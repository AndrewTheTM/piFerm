<?php
$sql = $_POST["sql"];
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare($sql);
$count = $fs->execute() or die(print_r($fs->errorInfo(), true));
?>