<?php
/**
This Example shows how to ping using the Leadersend class and do some basic error checking.
**/
require_once 'inc/Leadersend.class.php';
require_once 'inc/config.inc.php'; //contains apikey

$api = new Leadersend($apikey);

$request = array(
	'id' => 'message-id', // required
);

$retval = $api->messagesInfo($request);

header("Content-Type: text/plain");
if ($api->errorCode){
	echo "Unable to load messagesInfo()!";
	echo "\tCode=".$api->errorCode."\n";
	echo "\tMsg=".$api->errorMessage."\n";
} else {    
	echo "Success!\n";
	echo "\temail:".$retval['email']."\n";
	echo "\tstatus:".$retval['status']."\n";
	echo "\tid:".$retval['id']."\n";
	echo "\ttimestamp:".$retval['timestamp']."\n";
	echo "\tsender:".$retval['sender']."\n";
	echo "\tsubject:".$retval['subject']."\n";
}