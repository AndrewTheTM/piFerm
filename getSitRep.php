<?php
$cmd = $_POST["cmd"];

if($cmd=="sitrep"){
  $sql = "SELECT sitrepId, beverageName, statusText FROM sitrep";
}else if($cmd="cats"){
  $sql = "SELECT statusText FROM sitrep GROUP BY statusText";
}
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare($sql);
$count = $fs->execute() or die(print_r($fs->errorInfo(), true));

$sr = $fs->fetchAll();
print json_encode($sr);
?>
