<?php
$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare("SELECT fermStatusId, eventID, timeStamp FROM fermStatus");
$count = $fs->execute();

  $fermScheds = $fs->fetchAll();
if(count($fermScheds)>0){
  print json_encode($fermScheds);
}else{
  print count($fermScheds);
}
