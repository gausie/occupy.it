<?php

include("config.php");

$mysqli = new mysqli($config['hostname'],$config['username'],$config['password'],$config['database']);
$query = "SELECT COUNT(*) as number FROM occupation WHERE short = '{$_GET['short']}'";
$result = $mysqli->query($query)->fetch_object();
$mysqli->close();

if($result->number=="0"){
	echo "yes";
}else{
	echo "no";
}

?>
