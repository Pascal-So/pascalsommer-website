<?php


//===================================================================================	
// post.php - receive and store the user's location
// 
// --------------------------------------------------
// 
// Receives the position encrypted in RSA in POST variable "encryptedPosition", 
// decrypts it using the RSA key stored in the session variable "private" and stores
// it in the SQL database.
//===================================================================================


session_start();


include "phpCommon.php";

$path_to_senderWebsite = "help.php";


function redirect(){
	global $path_to_senderWebsite;
	session_unset();
	session_destroy();
	header("Location: " . $path_to_senderWebsite);
	exit();
}

if(!isset($_SESSION["private"]) || !isset($_POST["encryptedPosition"])){
	redirect();
}


set_include_path(get_include_path().PATH_SEPARATOR .'phpseclib');
include('Crypt/RSA.php');
$rsa=new Crypt_RSA();
$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
$rsa->loadKey($_SESSION["private"]);

$message = $rsa->decrypt(base64_decode($_POST["encryptedPosition"]));

if($message==""){
	redirect();
}

$parts = explode(" ", $message);
if(sizeof($parts)!=3){
	redirect();
}

$sql = new mysqli("localhost", $sql_user, $sql_pwd, $sql_db);
$stm = $sql->prepare("Insert into map(position, accuracy) values (?, ?)");
$stm->bind_param("ss", $pos, $acc);
$pos = $parts[0]." ".$parts[1];
$acc = $parts[2];
$stm->execute();

?>	