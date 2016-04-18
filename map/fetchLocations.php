<?php


//===================================================================================
// fetchLocations.php - gets the location data from the sql database
// 
// ----------------------------------------
//
// Retrieves the position data for the participants first from specified table, then
// helper position data. This is encrypted per person in the format 'lat lng acc hlp'
// and then returned as a json array.
//===================================================================================
//
// TABLES REQUIRED
// table map(position, accuracy, (time))
// table helpers(position, accuracy, (username), (time))
// names of tables are adjustable

session_start();

include "phpCommon.php";

if(!isset($_SESSION["access_granted"]) || !isset($_SESSION["AESKey"])){
	abort();
}

set_include_path(get_include_path().PATH_SEPARATOR .'phpseclib');
include('Crypt/AES.php');
$aes=new Crypt_AES(CRYPT_AES_MODE_ECB);
$aes->setKey(hex2bin($_SESSION["AESKey"]));

function aesEncrypt($plaintext){
	global $aes;
	$encoded = $aes->encrypt($plaintext)."\n";
	return bin2hex($encoded);
}

$outArray = array();

$sql = new mysqli("localhost", $sql_user, $sql_pwd, $sql_db);
$stm = $sql->prepare("Select position, accuracy from " . $tableName_participants);
$stm->execute();
$stm->bind_result($pos, $acc);
while($stm->fetch()){
	$plainPosition = "'" . $pos . " " . $acc . " false'";
	$encryptedPosition = aesEncrypt($plainPosition);
	array_push($outArray, $encryptedPosition);
}

$stm = $sql->prepare("Select position, accuracy, username from ". $tableName_helpers);
$stm->execute();
$stm->bind_result($pos, $acc, $username);
while($stm->fetch()){
	if($username!=$_SESSION["username"]){
		$plainPosition = "'" . $pos . " " . $acc . " true'";
		$encryptedPosition = aesEncrypt($plainPosition);
		array_push($outArray, $encryptedPosition);
	}
}

echo json_encode($outArray);

?>