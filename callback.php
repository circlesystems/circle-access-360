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
// For the demo only, we hardcoded. 
// You can use the same logic as in the DB or just add you emails here while testing
$adminEmails = array("curcio@gocircle.ai");

// if valid, we get the user email hashes
if ($checkSession) {
   
  // we get the session details
   $userSession = getSession($sessionID);
   
   // now lets kill the current session
   // this avoid replay attacks
   expireUserSession($sessionID, $userID);
   
   $data = $userSession["data"];

   $hasValidEmail = false;
   
   // we check if the user has valid emails in his profile
   if (isset($data["userHashedEmails"])) {

    // if so, we loop through the email hashes
		for($i = 0; $i < count($data["userHashedEmails"]); ++$i){

		  $eachHash = $data["userHashedEmails"][$i];
		  
      // now we loop the admin email hashes until we have a match
		  for($z = 0; $z < count($adminEmails); ++$z){
			  
		    $eachHashedAdmin = hashText($adminEmails[$z]);

        // once we find a match, we leave the inner loop
        if ($eachHash == $eachHashedAdmin) {
          $hasValidEmail = true;
          break;
        }
		  }
		  
      // then we leave the outer loop
		  if ($hasValidEmail){
			  break;
		  }
	   }

   }
      
   // we create a php session for the user
   	$_SESSION["userID"] = $userID;


	if ($hasValidEmail){
    // if he uses is an admin, we redirect him to the admin page after setting the session
		$_SESSION["isAdmin"] = "1";
		echo "<script>location.href='./dashboard/';</script>";
	} else {
    // otherwise we redirect him to the user page
		echo "<script>location.href='./regular_user/';</script>";
	}
} else {
	echo "<br><br><br><br><center><h2>User not Authorized - Not valid credentials</h2><br><br><a href='/'> Try again</a></center>";
}
?>