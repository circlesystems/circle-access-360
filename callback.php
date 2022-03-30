<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include_once ("./ajax/circleauth.php");

$userID = $_REQUEST["userID"];
$sessionID = $_REQUEST["sessionID"];

function hashText($text){
	return hash('sha256', $text);
}
// we first test the session
$checkSession = validateUserSession($sessionID, $userID);

// this would normally come from the DB
$adminEmails = array("geoff@gocircle.ai", "curcio@gocircle.ai", "dave@gocircle.ai","phani@gocircle.ai", "sara@gocircle.ai","robyn@gocircle.ai","richard@gocircle.ai", "gene@gocircle.ai", "nathan@gocircle.ai");

// if valid, we get the user email hashes
if ($checkSession) {
   
   $userSession = getSession($sessionID);
   
   // now lets kill the current session
   // this avoid replay attacks
   expireUserSession($sessionID, $userID);
   
   $data = $userSession["data"];

   $hasValidEmail = false;
   
   if (isset($data["userHashedEmails"])) {
		for($i = 0; $i < count($data["userHashedEmails"]); ++$i){
		  $eachHash = $data["userHashedEmails"][$i];
		  
		  for($z = 0; $z < count($adminEmails); ++$z){
			  
		     $eachHashedAdmin = hashText($adminEmails[$z]);
			 if ($eachHash == $eachHashedAdmin) {
				 $hasValidEmail = true;
				 break;
			 }
		  }
		  
		  if ($hasValidEmail){
			  break;
		  }
	   }

   }
      
   	$_SESSION["userID"] = $userID;
	if ($hasValidEmail){
		$_SESSION["isAdmin"] = "1";
		echo "<script>location.href='./dashboard/';</script>";
	} else {
		echo "<script>location.href='./regular_user/';</script>";
	}
} else {
	echo "<br><br><br><br><center><h2>User not Authorized - Not valid credentials</h2><br><br><a href='/'> Try again</a></center>";
}
?>