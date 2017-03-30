<?php

require_once "nusoap.php";
$client = new nusoap_client("http://oshiro.zz.mu/wsdl/WSDL.php?wsdl", true);

$result = $client->call("getTest");

echo $result;
