<?php
    
    // Get these ones from www.gocircle.ai - create account and get the credentials
    define('CUSTOMERID', '');
    define('APPKEY', '');
    define('ENDUSERID', 'userman'); // anythign, but should be different for every user
    define('SECRET', '');
    define('APIURL', 'https://api.gocircle.ai/api/token');
    
    
    // get these ones from https://console.gocircle.ai/ - create a new application and get the credentials
    // for the FIELD return url - use:
    // https://<yourdomain>/<yourfolder_with_this_project>/callback.php  <--- this file is on the root of the project
    define('ACCESS_APPKEY', '');
    define('ACCESS_LOGIN_URL', '');
    define('ACCESS_READ_KEY', '');
    define('ACCESS_WRITE_KEY', '');
    define('CIRCLEAUTH_DOMAIN', 'https://circleauth.gocircle.ai/');
?>