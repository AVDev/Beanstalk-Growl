<?php

	// Clients
	$clients = array(
		array('192.168.3.50', ''),
		array('leenug.webhop.org', '')		
	);

	// Post or Pre deploy?
	if(empty($_GET['hook'])) 
	{
		die('Hook not specified.'); 
	}
	else
	{
		$hook = $_GET['hook'];
	}
	
	// decode the payload
	$data = json_decode(file_get_contents('php://input'));
		
	// Growl Class
	require_once('inc/class.growl.php'); 

	// Send
	foreach($clients as $client)
	{
		// Set Up
		$growl = new Growl();
		$growl->setAddress($client[0], $client[1]);
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
	}