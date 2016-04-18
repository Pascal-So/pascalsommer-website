<?php

$imapstream = imap_open("{imap.one.com:993/imap/ssl}", "test@pascalsommer.ch", "Nosvctxk") or die("error " . imap_last_error());

//echo "Stream open, " . imap_num_msg($imapstream) . " messages here.<br>";

for($i = 0; $i<=imap_num_msg($imapstream); $i++){
       print "asdf<br>";
}

//$folders = imap_listmailbox($imapstream, "{imap.one.com:993}", "*");

//$structure = imap_fetchstructure($imapstream,)

imap_close($imapstream);
?>