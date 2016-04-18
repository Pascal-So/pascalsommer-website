<?
require_once("attachmentread.class.php");
$host="{imap.one.com:993}INBOX"; // pop3host
$login="test@pascalsommer.ch"; //pop3 login
$password="Nosvctxk"; //pop3 password
$savedirpath="" ; // attachement will save in same directory where scripts run othrwise give abs path
$jk=new readattachment(); // Creating instance of class####
$jk->getdata($host,$login,$password,$savedirpath); // calling member function
?>