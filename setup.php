<?php

/* @Author Andrew Rohne
 * @Date 6/2/2015
 * @website www.runningonbeer.net
 *
 * This is a setup routine for the fermpi Raspberry Pi Fermentation Controller
 *
 * TODO: 
	* add some error checking (the normal "or die("something")" does not work with these)
	* add a delete/reset, with a warning
 */

unlink('db/fermpi.db');
$db = new PDO('sqlite:db/fermpi.db');

$sqlCreateSitRep = "CREATE TABLE sitrep(sitrepId INTEGER PRIMARY KEY AUTOINCREMENT, beverageName CHAR(50), statusText CHAR(20));";

$sqlCreateFermSchedules = "CREATE TABLE fermSchedules(fermScheduleId INTEGER PRIMARY KEY AUTOINCREMENT, profileName CHAR(35), primaryTemp INTEGER, primaryDays INTEGER, diacetylRestTemp INTEGER, diacetylRestDays INTEGER, lagerTemp INTEGER, lagerDays INTEGER);";

// Vienna Lager 56 14 60 2 40 14
$fermSched1=array(
	"profileName" => "Vienna Lager",
	"primaryTemp" => 56,
	"primaryDays" => 14,
	"diaRestTemp" => 60,
	"diaRestDays" => 2,
	"lagerTemp" => 40,
	"lagerDays" => 14);
	
// American Pre-prohibition Lager 50 14 60 2 34 42
$fermSched2=array(
	"profileName" => "American Pre-prohibition Lager",
	"primaryTemp" => 50,
	"primaryDays" => 14,
	"diaRestTemp" => 60,
	"diaRestDays" => 2,
	"lagerTemp" => 34,
	"lagerDays" => 42);

// California Common 60 14 60 0 60 14
$fermSched3=array(
	"profileName" => "California Common",
	"primaryTemp" => 60,
	"primaryDays" => 14,
	"diaRestTemp" => 60,
	"diaRestDays" => 0,
	"lagerTemp" => 60,
	"lagerDays" => 14);

// Bock 50 14 60 2 40 35
$fermSched4=array(
	"profileName" => "Bock",
	"primaryTemp" => 50,
	"primaryDays" => 14,
	"diaRestTemp" => 60,
	"diaRestDays" => 2,
	"lagerTemp" => 40,
	"lagerDays" => 35);

// Oktoberfest 45 14 60 2 35 42
$fermSched5=array(
	"profileName" => "Oktoberfest",
	"primaryTemp" => 45,
	"primaryDays" => 14,
	"diaRestTemp" => 60,
	"diaRestDays" => 2,
	"lagerTemp" => 35,
	"lagerDays" => 42);
	
$fermSched=array(
	$fermSched1,
	$fermSched2,
	$fermSched3,
	$fermSched4,
	$fermSched5);

$sqlCreateFermStatus = "CREATE TABLE fermStatus(fermStatusId INTEGER PRIMARY KEY AUTOINCREMENT, eventID INTEGER, timeStamp INTEGER);";

echo 'creating sitrep\n';
$db->exec($sqlCreateSitRep);

echo 'creating fermsched\n';
$db->exec($sqlCreateFermSchedules);

echo 'filling fermsched\n';
for($i = 0; $i < count($fermSched); $i++){
	$sqlFermSchedule = "INSERT INTO fermSchedules (profileName, primaryTemp, primaryDays, diacetylRestTemp, diacetylRestDays, lagerTemp, lagerDays) VALUES ('".$fermSched[$i]["profileName"]."',".$fermSched[$i]["primaryTemp"].",".$fermSched[$i]["primaryDays"].",".$fermSched[$i]["diaRestTemp"].",".$fermSched[$i]["diaRestDays"].",".$fermSched[$i]["lagerTemp"].",".$fermSched[$i]["lagerDays"].");";
	$db->exec($sqlFermSchedule);
}

echo 'creating fermstat\n';
$db->exec($sqlCreateFermStatus);
?>