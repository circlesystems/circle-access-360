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
   if (!isset($_GET)) {
       return null;
   }

   $date = new DateTime();
   $timeStamp = $date->getTimestamp();
   $urlParameters ="customerId=".CUSTOMERID."&appKey=".APPKEY."&endUserId=".ENDUSERID."&nonce=123";
   $signature = sha256($urlParameters, SECRET);
   $url = APIURL."?".$urlParameters."&signature=".$signature;

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