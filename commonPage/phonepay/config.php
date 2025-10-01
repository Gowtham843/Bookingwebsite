<?php

define("BASE_URL", "http://localhost/bookingwebsite/");
define("API_STATUS", "UAT"); //LIVE OR UAT
define("MERCHANTIDLIVE", "");
define("MERCHANTIDUAT", "YOUR_PHONEPE_KEY");  //Sandbox testing
define("SALTKEYLIVE", " ");
define("SALTKEYUAT", "YOUR_PHONEPE_KEY");
define("SALTINDEX", "1");
define("REDIRECTURL", "pay_response.php");
define("SUCCESSURL", "success.php");
define("FAILUREURL", "failure.php");
define("UATURLPAY", "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay");
define("LIVEURLPAY", "https://api.phonepe.com/apis/hermes/pg/v1/pay");
define("STATUSCHECKURL", "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/");
define("LIVESTATUSCHECKURL", "https://api.phonepe.com/apis/hermes/pg/v1/status/");
?>
