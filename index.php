<?php

$dbh = new PDO('sqlite:db/fermpi.db');

/*
 * TODO: add links for:
	* sitrep
	* fermenter status (with start)
 */

?>
<html>
<head>
<title>FermPi Fermentation Controller</title>
</head>
<body>
<p><a href="sitrep.php">Sitrep</a></p>
<p><a href="chamber-status.php">Fermentation Chamber Status</a></p>
<p><a href="chamber-setup.php">Fermentation Chamber Setup</a></p>
<p><a href="program-setup.php">Fermentation Program Setup</a></p>
</body>
</html>