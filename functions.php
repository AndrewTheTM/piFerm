<?php

function getHeader(){
	$pages=array(
		array(
			"name" => "Main Menu",
			"address" => "index.php"
		),
		array(
			"name" => "Sitrep",
			"address" => "sitrep.php"
		),
		array(
			"name" => "Chamber Status",
			"address" => "chamber-status.php"
		),
		array(
			"name" => "Chamber Setup",
			"address" => "chamber-setup.php"
		),
		array(
			"name" => "Program Setup",
			"address" => "program-setup.php"
		)
	);
	print "<div id=\"navbar\">This is the header</div>";
	print "<div id=\"menubar\">";
	foreach($pages as $p){
		print "<div id=\"menuitem\"><a href=\"".$p["address"]."\">".$p["name"]."</a></div>";
	}
	print "</div>";
}
?>