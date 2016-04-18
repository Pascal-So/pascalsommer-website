<?php


//===================================================================================
// login.php - login to the position watching service
//
// -----------------------------------------------
// 
// Asks the user to enter his credentials, then sends them to the server encrypted
// using the AES key from the local sessionStorage variable "AESKey". The server
// decrypts the encrypted key using the AES key from the session variable "AESKey".
// The username is sent to the MySQL database to get the passwordHash. If login is
// successful, the session variable "access_granted" is set to true and the user is
// redirected to the next page.
//===================================================================================
// does not work on:
// IE 7 or older
// Safari 3.2 or older
// Opera mini
// Opera 10.1 or older

session_start();

include "phpCommon.php";


$path_to_current = "login.php"; //follow if validiation failed and needs to submit login again
$path_to_next = "watch.php"; //follow this path if login successful



function validiation_failed(){
	header("Location: " . $path_to_current);
	exit();
}

if(!isset($_SESSION["AESKey"])){ //AESKey should have been in a SESSION variable
	redirectToConnectionStart();
}

if(isset($_POST["login"])){ // encrypted login data is attached in POST variable. decrypt here.

	$_SESSION["access_granted"] = false;
	
	$decoded = aesDecrypt($_POST["login"], $_SESSION["AESKey"]);

	$parts = explode(".", $decoded);


	if(count($parts)!=2){
		validiation_failed();
	}

	$usrArray = explode("\"", $parts[0]);
	$pwdArray = explode("\"", $parts[1]);

	if(count($usrArray)!=3 || count($pwdArray)!=3){
		validiation_failed();
	}

	$username = $usrArray[1];
	$password = $pwdArray[1];

	$_SESSION["username"] = $username;


	$sql = new mysqli("localhost", $sql_user, $sql_pwd, $sql_db);
	$stm = $sql->prepare("Select passwordHash from users where username=? or username='zzzLastUser' order by username limit 1");
	$stm->bind_param("s", $username);
	$stm->execute();
	$stm->bind_result($passwordHash);
	while($stm->fetch()){
		if(password_verify($password, $passwordHash)){
			$_SESSION["access_granted"] = true;
			header("Location: ". $path_to_next);
		}else{
			validiation_failed();
		}
	}

	exit();
}

?>

<html>
<head>
<title>LOGIN</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="jsencrypt.js"></script>
<script src="jsaes.js"></script>
<script src="commonFunctions.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<style>
body{
	background: #444;
	text-align: center;
	margin-top: 50px;
}
input{
	background: #222;
	border: none;
	margin-bottom: 10px;
}
.error{
	background: #622;
}
</style>

<script>
$(function(){
	$('form').submit(function(event){
		event.preventDefault();
		var filledIn = true;
		$(".required").each(function(){
			var jThis = $(this);
			if(jThis.val()==""){
				filledIn = false;
				jThis.addClass("error");
			}
		});

		if(filledIn){
			var username = $("input[name=username]").val().replace(/"/g, ""); // do not allow quotes
			var password = $("input[name=password]").val().replace(/"/g, ""); // do not allow quotes

			var plaintext = "\"" + username + "\".\"" + password + "\"";

			var encFun = getEncryptor(hex2string(sessionStorage.AESKey)); //get the encrypting function.
																		//  the AES key is stored in hex format
			var out = encFun(plaintext);

			post("<?php $path_to_current ?>", {login: out});

		}
	});

	$(".required").each(function(){
		var jThis = $(this);
		jThis.keyup(function(){
			jThis.removeClass("error");
		});
	});
});

</script>

<form>
	User name:<br>
	<input class="required" type = "text" name="username"><br>
	Password:<br>
	<input class="required" type = "password" name = "password"><br>
	<input type="submit" value="OK">
</form>

</body>
</html>