<?php

if(!isset($_POST["start"]) || !isset($_POST["end"])){
	exit();
}

$mysql_username = "root";//"pascalsommer_ch";
$mysql_password = "";//"Nosvctxk";
$mysql_database = "pascalsommer_ch";


$entries = scandir("entries", 1);
$month = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");


$conn = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);





?>