<?php

$db = new PDO('sqlite:db/fermpi.db');

$sqlCreateSitRep = "CREATE TABLE sitrep(sitrepId INT PRIMARY KEY AUTOINCREMENT, beverageName CHAR(50), statusText CHAR(20));";

$sqlCreateFermSchedules = "CREATE TABLE fermpi.fermSchedules(fermScheduleId INT PRIMARY KEY AUTOINCREMENT, profileName CHAR(35), primaryTemp INT, primaryDays INT, diacetylRestTemp INT, diacetylRestDays INT, lagerTemp INT, lagerDays INT);";

/*
 * Fill:
 * Vienna Lager 56 14 60 2 40 14
 * American Pre-prohibition Lager 50 14 60 2 34 42
 * California Common 60 14 60 0 60 14
 * Bock 50 14 60 2 40 35
 * Oktoberfest 45 14 60 2 35 42
 */

$sqlCreateFermStatus = "CREATE TABLE fermpi.fermStatus(fermStatusId INT PRIMARY KEY AUTOINCREMENT, eventID INT, timeStamp INT);";

$db->exec($sqlCreateSitRep) or die(print_r($db->errorInfo()));

?>