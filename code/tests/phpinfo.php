<?php
require_once('FindSSEnvironment.php');


define('ADMIN_USERNAME',SS_DEFAULT_ADMIN_USERNAME); 			// Admin Username
define('ADMIN_PASSWORD',SS_DEFAULT_ADMIN_PASSWORD);  	// Admin Password - CHANGE THIS TO ENABLE!!!

///////////////// Password protect ////////////////////////////////////////////////////////////////
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
           $_SERVER['PHP_AUTH_USER'] != ADMIN_USERNAME ||$_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD) {
            Header("WWW-Authenticate: Basic realm=\"Memcache Login\"");
            Header("HTTP/1.0 401 Unauthorized");

            echo <<<EOB
                <html><body>
                <h1>Rejected!</h1>
                <big>Wrong Username or Password!</big>
                </body></html>
EOB;


phpinfo();
