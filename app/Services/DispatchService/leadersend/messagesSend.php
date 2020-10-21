<?php
/**
This Example shows how to ping using the Leadersend class and do some basic error checking.
**/
require_once 'inc/Leadersend.class.php';
require_once 'inc/config.inc.php'; //contains apikey

$api = new Leadersend($apikey);

// generate HTML part of dynamic email message
$htmlPart = <<<HTML
<p>Hi, #[FNAME]# #[LNAME]#!</p>
<p>Thanks for registering in our system.</p>
<p>Please click <a href="http://company.com/your_confirm_link_here/">here</a> to confirm your registration.</p>
#[IF:EMAIL=test@company.com]# <p>dynamic content specially for Alex</p> #[/IF]#
HTML;

$request = array(
	'subject' => 'Test transactional email', // required
	'from'    => array( // required. A sender’s information
		'name'  => 'John Doe',
		'email' => 'john@doe.com'
	),
	'to' => array( // required. A list of recipients
		// recipient #1 with name and email
		array(
			'name'  => 'Alex',
			'email' => 'test@company.com'
		),
		// recipinet #2 with just email
		'test@example.com'
	),
	'html'       => $htmlPart, // email's HTML content
	'auto_plain' => true, // automatically generate a text part for the messages of HTML part
	'merge_vars' => array( // define merge variables for each recipient
		'test@company.com' => array(
			array(
				'name'  => 'FNAME',
				'value' => 'Alex'
			),
			array(
				'name'  => 'LNAME',
				'value' => 'Doubt'
			)
			),
		'email@example.com' => array(
			array(
				'name'  => 'FNAME',
				'value' => 'Jennifer'
			),
			array(
				'name'  => 'LNAME',
				'value' => 'McQuin'
			)
		)
	)
);

$retval = $api->messagesSend($request);

header("Content-Type: text/plain");
if ($api->errorCode){
	echo "Unable to load messagesSend()!";
	echo "\tCode=".$api->errorCode."\n";
	echo "\tMsg=".$api->errorMessage."\n";
} else {    
	echo "Success!\n";
	foreach($retval as $val){
		echo $val['email']. " ".$val['status']."\n";
		echo "\tmessage-id:".$val['id']."\n";
	}
}