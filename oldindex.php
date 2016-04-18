<?php
  require 'browser.php';
  date_default_timezone_set('UTC');

  $browser = new Browser();

  $conn=new mysqli("localhost", "pascalsommer_ch", "Nosvctxk", "pascalsommer_ch");
  
  $mybrowser = $browser->getBrowser();
  $myplatform = $browser->getPlatform();
  $ip = $_SERVER['REMOTE_ADDR'];
  $location = json_decode(file_get_contents("http://freegeoip.net/json/$ip"));
  //$location = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
  $mycountry = $location->country_code;
  $mycity = $location->city;
  $varRefer = mysqli_real_escape_string($conn, $_SERVER['HTTP_REFERER']);
  
  //print mysqli_real_escape_string($conn, "asfe<>';");
  //print "referer: " . $varRefer . "<br>";

  //print $ip . ", ". $mycity . ", " . $mycountry;
 
  $query= "insert into counter (browser, platform, city, country, ip, referer) values ('$mybrowser', '$myplatform', '$mycity', '$mycountry', '$ip', '$varRefer')";
  $result = $conn->query($query);
  
  $conn->close();
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Pascal Sommer</title>

  <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="main.css">
  <script src="js/jquery-2.1.4.min.js"></script>
  <script src="js/func.js"></script>
</head>

<body>
<header>
  <div id="title">
    <div id="titleText">
      <span>PASCAL SOMMER</span>
      <p>PHOTOGRAPHY</p>
    </div>
  
  </div>
  <br>
  
  <nav>
    <span id="workLink"><a href="#work">WORK</a></span>
    <span id="aboutLink"><a href="#about">ABOUT ME</a></span>
    <span id="blogLink"><a href="http://pascalsommer.ch/blog#blog">BLOG</a></span>
  </nav>
</header>

<div id="work">
  <span id="workTitle">WORK</span>
  <div id="pview">
    <div id="closebutton">x</div>
    <div class="photonav" id="backbutton"></div>
    <div id="phot"></div>
    <div class="photonav" id="forwardbutton"></div>
  </div>
  <div id="photos">
    <div id="p01"></div>
    <div id="p02"></div>
    <div id="p03"></div>
    <div id="p04"></div>
    <div id="p05"></div>
    <div id="p06"></div>
    <div id="p07"></div>
    <div id="p08"></div>
    <div id="p09"></div>
    <div id="p10"></div>
    <div id="p11"></div>
    <div id="p12"></div>
  </div>
    
  <div id="videos">
    <div id="vid1bt"><iframe id="vid1" src="https://www.youtube.com/embed/gbmKA97eo18" frameborder="0" allowfullscreen></iframe></div>
    <div id="vid2bt"><iframe id="vid2" src="https://www.youtube.com/embed/JeB4hQ0L1Ww" frameborder="0" allowfullscreen></iframe></div>
  </div>
  
  
</div>
<div id="about">
  <span id="aboutTitle">ABOUT ME</span>
  <div id="profilePic"></div>
  <p id="aboutText1">Photography has been an interesting topic for me for at least the past 4 years. After getting my first camera I started learning the craft simply by practising it myself. I mostly shoot portraits and events, as well as landscapes, animals, etc. I am currently using a Sony a7sII and a Canon EOS 600d with four different lenses and a flash:</p>
  <p id="gearList">Sigma 17-70mm f/2.8-4.0 DC OS HSM<br>
Canon EF 70-300mm f/4-5.6 IS USM<br>
Canon EF 50mm f/1.8 II<br>
Canon EF-S 18-55mm f/3.5-5.6 IS II<br>
Canon Speedlite 430EX II</p>
  <p id="aboutText2">All the editing of my pictures is done in Lightroom and Photoshop.</p>
  <p id="contact">Contact me at:</p>
  <a href="mailto:p@pascalsommer.ch" id="maillink">p@pascalsommer.ch</a>
</div>

<div id="footer">
  <div id="overlay">
    <p>copyright</p>
    <span>Pascal Sommer | 2016</span>
  </div>
</div>

</body>
</html>
