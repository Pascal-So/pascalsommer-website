# aletschhalbmarathon-location
Pushes the location of people with emergencies to the SQL database and lets the staff see the location.

Requirements:
jsencrypt.js
jsaes.js
phpseclib


Participant:
visits help.php -> position is encrypted via rs
adata is sent to post.php

Staff:
visits connect.php -> aes key is set up
is redirected to login.php -> username and password entered, encrypted via aes
data is sent to login.php
redirected to watch.php