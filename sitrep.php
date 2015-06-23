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
  		if(!(xmlhttp.readyState == 4 && xmlhttp.status == 200)){
  			//alert(xmlhttp.responseText);
        getSitRep(document.getElementById("selStatus").value);
  		}
  	}
  	xmlhttp.open("POST","newSitrep.php",true);
  	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	xmlhttp.send(values);
    xmlhttp.close;
    getSitRep();
  }

  function rmSitRep(id){
    console.log(id);
    if(window.XMLHttpRequest){
      xmlhttp2 = new XMLHttpRequest();
    }else{
      xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp2.onreadystatechange = function(){
      if(xmlhttp2.readyState == 4 && xmlhttp2.status == 200){
        getSitRep();
      }
    }
    xmlhttp2.open("POST","rmSitRep.php",true);
    xmlhttp2.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp2.send("id="+id);
    xmlhttp2.close;
    
  }

  function getSitRep(){
    if(window.XMLHttpRequest){
      xmlhttp1 = new XMLHttpRequest();
    }else{
      xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp1.onreadystatechange = function(){
      if(xmlhttp1.readyState == 4 && xmlhttp1.status == 200){
        document.getElementById("divPrimary").innerHTML="";
        document.getElementById("divSecondary").innerHTML="";
        document.getElementById("divLager").innerHTML="";
        document.getElementById("divCarbonating").innerHTML="";
        document.getElementById("divIn Bottles").innerHTML="";

        var json1 = JSON.parse(xmlhttp1.responseText);
        for(var i=0;i<json1.length;i++){
          document.getElementById("div"+json1[i]["statusText"]).innerHTML += json1[i]["beverageName"] + " <a href=\"#\" onClick=\"rmSitRep(" + json1[i]["sitrepId"] + ")\";><img src=\"/images/IconTrash.jpg\" /></a><br/>";
        }
      }
    }
    xmlhttp1.open("POST","getSitRep.php",true);
    xmlhttp1.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp1.send("cmd=sitrep");
    xmlhttp1.close;
  }
  </script>
</head>
<body onload="getSitRep();">
<?php getHeader() ?>

<?php
foreach($srStatus as $status){
  echo "<h1>".$status."</h1>";
  echo "<div id=\"div".$status."\" class=\"sitrep-item\"></div>";
}
?>
<hr />
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
