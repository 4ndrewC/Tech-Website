<?php

	ob_start();
	require_once '../../../app/config.php';
	require_once '../../../app/init.php'; 
	if (!($user -> LoggedIn()) || !($user -> notBanned($odb)) || empty($_GET['message']) || empty($_GET['id']) || !isset($_SERVER['HTTP_REFERER']) || !($user -> isStaff($odb)) && !($user -> isAdmin($odb))){
		die(error('There was an error with your session'));
	}

	$updatecontent = $_GET['message'];
	$id = $_GET['id'];
	
	if ($user -> safeString($updatecontent)){
		die(error('Unsafe characters were set'));
	}
	
	$SQLClosed = $odb -> prepare("SELECT `status` FROM `tickets` WHERE `id` = :id ");
	$SQLClosed -> execute(array(':id' => $id));
	if($SQLClosed->fetchColumn(0) == "Closed"){
		die(error('The ticket has been closed'));
	}
	
	$SQLGetMessages = $odb -> prepare("SELECT * FROM `messages` WHERE `ticketid` = :id ORDER BY `messageid` DESC LIMIT 1");
	$SQLGetMessages -> execute(array(':id' => $id));
	
	$SQLinsert = $odb -> prepare("INSERT INTO `messages` VALUES(NULL, :ticketid, :content, :sender, UNIX_TIMESTAMP())");
	$SQLinsert -> execute(array(':sender' => 'Admin', ':content' => $updatecontent, ':ticketid' => $id));
	
	$SQLUpdate = $odb -> prepare("UPDATE `tickets` SET `status` = :status WHERE `id` = :id");
	$SQLUpdate -> execute(array(':status' => 'Waiting for user response', ':id' => $id));
	die(success('Message has been sent'));
	
?>