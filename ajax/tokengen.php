<?php

include_once("constants.php");

function encode($data)
{
   return  base64_encode($data);
}

function sha256($data, $secret)
{
  return encode(hash_hmac('sha256', $data, $secret, true));
}

function getToken()
{
   $date = new DateTime();
   $timeStamp = $date->getTimestamp();
   $urlParameters ="customerId=".CUSTOMERID."&appKey=".APPKEY."&endUserId=".ENDUSERID."&nonce=" . $timeStamp;
   $signature = sha256($urlParameters, SECRET);
   $url = APIURL."?".$urlParameters."&signature=".$signature;

   $context = [
       'http' => [
           'method' => "GET",
           'ignore_errors' => true,
       ],
   ];

   $context = stream_context_create($context);
   $result = file_get_contents($url, false, $context);

   return $result;
}

// if for some reason the above function does not work, try this one
function getTokenWithCurl()
{
   if (!isset($_GET)) {
       return null;
   }

   $date = new DateTime();
   $timeStamp = $date->getTimestamp();
   $urlParameters ="customerId=".CUSTOMERID."&appKey=".APPKEY."&endUserId=".ENDUSERID."&nonce=".$timeStamp;
   $signature = sha256($urlParameters, SECRET);
   $url = APIURL."?".$urlParameters."&signature=".$signature;
   $timeout = 60;

   $ch = curl_init($url);
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  
   $result = curl_exec($ch);
   curl_close($ch);
   
   if ($result != '') {
        return $result ;
   }

   return null;
}

echo getToken();