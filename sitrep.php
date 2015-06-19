<?php
include("functions.php");

$db = new PDO('sqlite:db/fermpi.db');
$fs = $db->prepare("SELECT beverageName, statusText FROM sitrep");
$fs->execute();
$fermScheds = $fs->fetchAll();

$srStatus = array("Primary", "Secondary", "Lager", "Carbonating","In Bottles");

?>

<html>
<head>
  <title>Sitrep</title>
  <link rel="stylesheet" type="text/css" href="/piferm.css">

  <script>
  function insertSitrep(){
  	var values="beer="+document.getElementById("frmBeerName").value;
    values +="&status="+document.getElementById("selStatus").value;
  	if(window.XMLHttpRequest){
  		xmlhttp = new XMLHttpRequest();
  	}else{
  		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  	}
  	xmlhttp.onreadystatechange = function(){
  		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
  			alert(xmlhttp.responseText);
  		}
  	}
  	xmlhttp.open("POST","newSitrep.php",true);
  	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xmlhttp.send(values);
  }
  </script>
</head>
<body>
<?php getHeader() ?>

<?php
foreach($srStatus as $status){
  echo "<h1>".$status."</h1>";
  echo "<div class=\"sitrep-item\"></div>";

}
?>

<form>
  <input id="frmBeerName" type="text">
  <select id="selStatus">
  <?php
    foreach($srStatus as $status){
      echo "<option>".$status."</option>";
    }
  ?>
  </select>
  <button type="button" onClick="insertSitrep();">Add</button>
</form>

<!--



-->
</body>
</html>
