<?php
/*
 * Growler Post-Receive Hook
 * 
 * Dependency: mumbles - http://www.mumbles-project.org
 * 
 * - Install this script onto a web server and setup a post-receive hook within
 *   codebase/github to call the script - http://myinternalserver.domain.com/growler.php.
 *
 * - Assign the IP addresses of the machines which should receive your growl whenever
 *   a push is received by codebase into the $ips array below.
 * 
*/

$ips = Array('10.0.0.1', '10.0.0.2');

$data = stripslashes($_POST['payload']);
$payload = json_decode($data);

if($payload->repository->project == '') {
  $app = $payload->repository->name;
} else {
  $app = $payload->repository->project;
}

foreach($payload->commits as $commit) {

  $author = $commit->author->name;
  $commit_message = $commit->message;

  $title = "$author committed";
  $message =  "to $app\n\n$commit_message";

  foreach($ips as $ip) {
    system("mumbles-send -g $ip '$title' '$message'");
  }

}

?>