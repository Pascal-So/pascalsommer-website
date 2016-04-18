<?php


//===================================================================================
// connect.php - exchange an AES Key and redirect.
//
// ----------------------------------------------
//
// This sets up a connection by first giving the user a public rsa key, then letting
// him generate an AES key and send this to the server using the rsa encryption to
// the POST variable "AESKey". The script then accepts the POST variable, decrypts
// it and stores the key in the session variable "AESKey" and then redirects the
// user to $path_to_next_website. The script also stores the unencrypted key in the
// local sessionStorage variable "AESKey".
//===================================================================================
// does not work on:
// IE 7 or older
// Safari 3.2 or older
// Opera mini
// Opera 10.1 or older


session_start();

$path_to_next_website = "login.php";
$this_website = "connect.php";

set_include_path(get_include_path().PATH_SEPARATOR .'phpseclib');
include('Crypt/RSA.php');
$rsa=new Crypt_RSA();
$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);


function setup(){  //generate key if needed, then send it to user

	if(!isset($_SESSION["private"])){
		global $rsa;
		extract($rsa->createKey());
		$_SESSION["private"] = $privatekey;
		$_SESSION["public"] = $publickey;
		
	}
	print("<textarea id='public' style='display:none'>".$_SESSION["public"]."</textarea>");
}


if(isset($_SESSION["private"]) && isset($_POST["AESKey"])){  //receiving the encrypted AES key
	$rsa->loadKey($_SESSION["private"]);
	$aeskey = $rsa->decrypt(base64_decode($_POST["AESKey"]));

	if($aeskey==""){
		setup();
	}
	$_SESSION["AESKey"] = $aeskey;
	header("Location: " . $path_to_next_website);
	exit();
}else{

	setup();
}


?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="jsencrypt.js"></script>
<script src="commonFunctions.js"></script>

<script>

var browser_not_supported_alert = "ERROR! YOUR BROWSER IS NOT SUPPORTED!";



function generateAESKey(){
	var key = [];
	for(var i = 0; i < 16; i++){
		key[i]=Math.floor(Math.random()*256);
	}
	return key;
}

$(function(){
	var publickey = $('#public').val();
	
	var aeskey = convertToHex(list2string(generateAESKey()));

	if(typeof(Storage) !== "undefined") {
	   	sessionStorage.AESKey = aeskey;   // store the AES key locally in sessionStorage (requires HTML5)
	} else {
	    throw new Error(browser_not_supported_alert);
	}

	var encrypt = new JSEncrypt();
	encrypt.setPublicKey(publickey);
	var cypher = encrypt.encrypt(aeskey);

	

	post("<?php print($this_website) ?>", {AESKey: cypher});

});

</script>

<?php
/*


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo '<pre>';
var_dump($_SESSION);
echo '</pre>';


*/
?>