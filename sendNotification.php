<?php
/*
Create By : Himanshu Prajapati
Date : 5th May,2017

*/

header("Access-Control-Allow-Origin: *"); 

// API access key from Google API's Console
define( 'API_ACCESS_KEY', 'Your API KEY');

// prep the bundle

$msg = array
(
	'title'		=> 'Push Notification',
	'subtitle'	=> 'Success',
	'message' 	=> 'From HP',
	'tickerText'=> 'Hello',
	'vibrate'	=> 1,
	'sound'		=> 1,
	'largeIcon'	=> 'large_icon',
	'smallIcon'	=> 'small_icon',
	'priority'  =>'high',
);

$fields = array
(
	'registration_ids' => ["array of fcm tokens"],
	'data' => $msg
);

$headers = array
(
	'Authorization: key=' . API_ACCESS_KEY,
	'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
echo $result;


?>