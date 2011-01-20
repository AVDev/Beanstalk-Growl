<?php
	
	// The IP or Hostname of your mac
	$ip = '192.168.3.50';
	$password = '';
	
	// Post or Pre deploy?
	$hook = $_GET['hook'];

	
	$data = json_decode(file_get_contents('php://input'));
		
	// Growl Class
	require_once('inc/class.growl.php'); 

	// Setup
	$growl = new Growl();
	$growl->setAddress($ip, $password);
	$growl->addNotification("Beanstalk-Deploy");
	$growl->register();

	// Send Notification
	if($hook == "pre")
	{
		$title = "'". ucfirst($data->repository) . "' deploying to ". ucfirst($data->environment) . " server.";
		$message = '(Revision: ' . $data->revision . ") ";
		$message .= $data->author . " - " . $data->comment;
	
		$growl->notify("Beanstalk-Deploy", $title, $message);
	}
	
	if($hook == "post")
	{
		$title = "'". ucfirst($data->repository) . "' rev {$data->revision} was deployed to ". ucfirst($data->environment) . " server.";
		$message = $data->author . " - " . $data->comment;
	
		$growl->notify("Beanstalk-Deploy", $title, $message);
	}
	
?>