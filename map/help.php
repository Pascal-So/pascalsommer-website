<?php


//===================================================================================
// help.php - let the user send his location
// 
// ----------------------------------------
//
// Generates an RSA key pair, stores the keys in the session variables "private" and
// "public" respectively, gets the user position via JS and sends it RSA encrypted
// to server in the POST variable "encryptedPosition".
//===================================================================================


session_start();

?>

<html>
<head>
<title>SEND LOCATION</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="jsencrypt.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<?php

	if(!isset($_SESSION["private"])){ // need to generate a new RSA key pair
		set_include_path(get_include_path().PATH_SEPARATOR .'phpseclib');
		include('Crypt/RSA.php');
		$rsa=new Crypt_RSA();
		extract($rsa->createKey());
		$_SESSION["private"] = $privatekey;
		$_SESSION["public"] = $publickey;
	}
	print("<textarea id='public' style='display:none'>".$_SESSION["public"]."</textarea>");

?>

<script>


	//  SETTINGS VARIABLES DECLARATIONS ######################################################################################

	var defaultButtonText = "SEND LOCATION";
	var aquiringPositionText = "Aquiring position...";

	var alertGeoLocNotAvailable = "Please enable GPS on your device.";
	var alertLocationFailed = "Please enable GPS and allow the website to access your location.";
	var alertServerConnectionFailed = "The server could not be reached, please check your internet connection, refresh the page, and try again.";

	var messageSuccess = "Successfuly transmitted your position "
	
	var highAccuracyTimeout = 10; // in seconds
	var lowAccuracyTimeout = 10; // in seconds
	
	var receivingScript = "post.php";

	//  ######################################################################################################################


	$(function(){
		$('#locButton').prop("value",defaultButtonText);

		$('#locButton').click(function(){

			// ===============================================================
			// first attempt high accuracy location, if this fails, switch to
			// low accuracy.
			// ===============================================================


			if(navigator.geolocation){ // is geolocation available on this device?
				$('#locButton').prop("value",aquiringPositionText);
				navigator.geolocation.getCurrentPosition(send, error_highAccuracy, {enableHighAccuracy: true, timeout: highAccuracyTimeout * 1000, maximumAge: 60000});
			}else{
				alert(alertGeoLocNotAvailable); // geolocation not available.
			}

			function error_highAccuracy(error){ //if high accuracy failed
				if(error.code==error.TIMEOUT){
					navigator.geolocation.getCurrentPosition(send, fail, {enableHighAccuracy: false, timeout: lowAccuracyTimeout* 1000, maximumAge: 60000});
				}else{
					fail();
				}
			}

			function fail(){  //if low accuracy failed as well.
				$('#locButton').prop("value", defaultButtonText);
				alert(alertGeoLocNotAvailable);
			}
			

			
			function send(pos){
				$('#locButton').prop("value", defaultButtonText);
				var posString = pos.coords.latitude + " " + pos.coords.longitude + " " + pos.coords.accuracy;
				//var posString = "46.980 7.477 20";
				$('#message').html(posString);
				var encrypt = new JSEncrypt();
				encrypt.setPublicKey($('#public').val());
				var cypher = encrypt.encrypt(posString);
				console.log(cypher);
				$.post(receivingScript, { encryptedPosition:cypher } )
					.done(function(){
						$('#message').html(messageSuccess + posString);
					})
					.fail(function(jqXHR, textStatus, errorThrown){
						alert(alertServerConnectionFailed + " " + jqXHR.responseText);
					});
					
			}
		});
	});
</script>
<style>
body{
	background: #444;
	text-align: center;
	margin-top: 50px;
}
#locButton{
	cursor: pointer;
	background: #111;
	color: white;
	border: none;
	padding: 20px;
}
</style>

	<div id='message'></div>
	<input id="locButton" type="button" value="SEND LOCATION">

</body>
</html>