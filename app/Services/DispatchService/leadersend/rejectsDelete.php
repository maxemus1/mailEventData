<?php
/**
This Example shows how to ping using the Leadersend class and do some basic error checking.
**/
require_once 'inc/Leadersend.class.php';
require_once 'inc/config.inc.php'; //contains apikey

$api = new Leadersend($apikey);

$request = array(
	'email' => 'example@example.com', // required
);

$retval = $api->rejectsDelete($request);

header("Content-Type: text/plain");
if ($api->errorCode){
	echo "Unable to load rejectsDelete()!";
	echo "\tCode=".$api->errorCode."\n";
	echo "\tMsg=".$api->errorMessage."\n";
} else {    
	echo $retval ? "Success!\n" : "Failed!\n";
}