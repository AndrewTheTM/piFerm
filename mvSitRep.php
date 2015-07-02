<?php
$id = $_POST["id"];
$mt = $_POST["mt"];

if($mt == "P") $dest = "Primary";
if($mt == "S") $dest = "Secondary";
if($mt == "L") $dest = "Lager";
if($mt == "C") $dest = "Carbonating";
if($mt == "B") $dest = "In Bottles";

$sql = "UPDATE sitrep SET statusText = '" . $dest . "' WHERE sitrepId=".$id;

$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare($sql);
$count = $fs->execute() or die(print_r($fs->errorInfo(), true));

?>
