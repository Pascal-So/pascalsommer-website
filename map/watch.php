<?php


//===================================================================================
// watch.php - watch the locations. 
// ----------------------------------------------
//
// Display a google maps interface. Location data is requested from path_to_fetch_
// locations. Also accepts encrypted location string from user and inserts this in
// to helpers table.
//===================================================================================
// TABLES REQUIRED
// table helpers(position, accuracy, (username), (time))
// names of tables are adjustable

session_start();

include "phpVars.php";

$path_to_start = "connect.php";
$path_to_user_location_submit = "watch.php";
$path_to_fetch_locations = "fetchLocations.php";


if(!isset($_SESSION["access_granted"]) || !isset($_SESSION["AESKey"])){
	redirectToConnectionStart();
}

if(isset($_POST["userPosition"])){ // accept the users location and store it in helpers table
	$decrypted = aesDecrypt($_POST["userPosition"], $_SESSION["AESKey"]);
	$parts = explode("'", $decrypted);
	if(count($parts)!=3){
		exit();
	}
	$locString = $parts[1];
	$parts = explode(" ", $locString);
	if(count($parts)!=3){
		exit();
	}
	$lat = $parts[0];
	$lng = $parts[1];
	$acc = $parts[2];

	$sql = new mysqli("localhost", $sql_user, $sql_pwd, $sql_db);
	$stm = $sql->prepare("Insert into " . $tableName_helpers . "(position, accuracy, username) values (?, ?, ?)");
	$stm = $sql->bind_param("sss", $lat . " " . $lng, $acc, $_SESSION["username"]);
	$stm->execute();

	exit();
}

?>

<html>
<head>
<title>WATCH LOCATIONS</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script src="jsaes.js"></script>
<script src="commonFunctions.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<style>
body{
	background-color: #444;
	margin: 0;
}
#googleMap{
	width: 100vw;
	height: 100vh;
	margin: 0;
}
input{
	position: fixed;
	top: 10;
	right: 10;
	font-size: 18px;
	background-color: #511;
	color: #fff;
	border: 2px solid white;
}
</style>

<div id="googleMap"></div>

<input type="button" value="UPDATE" id="btUpdate">

<script>

//  SETTINGS VARIABLES DECLARATIONS ######################################################################################
//
var highAccuracyTimeout = 2;
var autoUpdateTime = 30;
var debounceTime = 2;
var myLat = 47;
var myLng = 7.5;
var participantColor = "#f22";
var helperColor = "#2f2";
var myColor = "#22f";
//
//  ######################################################################################################################


var map;
var myPos = new google.maps.LatLng(myLat, myLng);
AESKey = hex2string(sessionStorage.AESKey)
decFun = getDecryptor(AESKey);
encFun = getDecryptor(AESKey);
var positions = [];
var userTracked = false;
var userCircle;
var serverCircles=[];


$(function(){

	initialize(myPos, 11);

	var updateFunc = debounce(update, debounceTime * 1000);

	updateFunc();

	$("#btUpdate").click(function(){
		
		updateFunc();
	});

	setInterval(updateFunc, autoUpdateTime * 1000);

});

function drawAndSendMyPos(){
	getLocation(success, error);
	function success(pos){
		myLat = pos.coords.latitude;
		myLng = pos.coords.longitude;
		sendPos(myLat, myLng, pos.coords.accuracy);
		myPos = new google.maps.LatLng(myLat, myLng);
		userTracked = true;
		userCircle = newPerson(myPos, pos.coords.accuracy, myColor);
		userCircle.setMap(map);
	}
	function error(){
		userTracked = false;
	}

	function sendPos(lat, lng, acc){
		var posString = "'" + lat + " " + lng + " " + acc + "'";
		var cyphertext = encFun(posString);
		$.post("<?php echo $path_to_user_location_submit ?>", {userPosition:cyphertext});
	}
}

function getBounds(array){
	var bounds = new google.maps.LatLngBounds();
	var len = array.length;
	for(var i = 0; i < len; i++){
		bounds.extend(array[i]);
	}
	return bounds;
}

function update(){
	hideCircles();
	drawAndSendMyPos();
	$.post( "<?php echo $path_to_fetch_locations ?>", function( data ) {
		positions = [];
		if(userTracked){
			positions.push(myPos);
		}
		var encryptedArray = JSON.parse(data);
		var decrpytedArray = decryptArray(encryptedArray);
		
		var users = extractUsers(decrpytedArray);
		console.log(users);
		showUsers(users);
		var bounds = getBounds(positions);
		map.fitBounds(bounds);
	});
}

function decryptArray(data){
	var arr = $.map(data, function(item){
		return decFun(item);
	});
	return arr;
}

function extractUsers(array){
	var arr = $.map(array, function(e){
		var parts = e.split("'");
		var data = parts[1].split(" ");
		return {latitude:data[0], longitude:data[1], accuracy:data[2], helper:data[3]};
	});
	return arr;
}

function hideCircles(){
	var len = serverCircles.length;
	for(var i = 0; i<len; i++){
		serverCircles[i].setMap(null);
	}	
	if(userTracked){
		userCircle.setMap(null);
	}
}

function showUsers(array){
	serverCircles = $.map(array, function(e){
		var pos = new google.maps.LatLng(e.latitude, e.longitude);
		positions.push(pos);
		var circleColor = participantColor;
		if(e.helper=="true"){
			circleColor = helperColor;
		}
		var circle = newPerson(pos, parseFloat(e.accuracy), circleColor);
		circle.setMap(map);
		return circle;
	});
}

function newPerson(position, radius, color){
	var circ = new google.maps.Circle({
		center:position,
		radius:radius,
		strokeColor:color,
		strokeOpacity:0.8,
		strokeWeight:2,
		fillColor:color,
		fillOpacity:0.4
	});
	return circ;
}

function initialize(position, zoom) {
  var mapProp = {
    center:position,
    zoom:zoom,
    mapTypeId:google.maps.MapTypeId.HYBRID
  };
  map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
}

function getLocation(successCallback, errorCallback){
	if(navigator.geolocation){ // is geolocation available on this device?
		navigator.geolocation.getCurrentPosition(successCallback, error_highAccuracy, {enableHighAccuracy: true, timeout: highAccuracyTimeout * 1000, maximumAge: 60000});
	}else{
		errorCallback();
	}

	function error_highAccuracy(error){ //if high accuracy failed
		if(error.code==error.TIMEOUT){
			navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {enableHighAccuracy: false, timeout: lowAccuracyTimeout* 1000, maximumAge: 60000});
		}else{
			errorCallback();
		}
	}
}
</script>

</body>
</html>