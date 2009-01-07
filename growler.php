<?php

$data = stripslashes($_POST['payload']);

if(!isset($_POST['payload'])) { 
  $data = file_get_contents('data.txt');
}

$payload = json_decode($data);

$author = $payload->commits[0]->author->name;
$app = $payload->repository->name;
$message = $payload->commits[0]->message;

$message =  "$author pushed: \n" . "$message \nto $app";
$title = 'codebase';

$ips = Array('10.0.0.1', '10.0.0.2');
foreach($ips as $ip) { 
  system("mumbles-send -g $ip '$title' '$message'");
}

?>
