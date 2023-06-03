<?php

	ob_start(); 
	require_once '../../../app/config.php'; 
	require_once '../../../app/init.php'; 

	if (!($user->LoggedIn()) || !($user->notBanned($odb)) || !($user -> isAdmin($odb)) || !(isset($_SERVER['HTTP_REFERER']))) {
		die();
	}
	
	$stop      = intval($_GET['id']);
	$SQLSelect = $odb->prepare("SELECT * FROM `logs` WHERE `id` = :id ");	$SQLSelect -> execute(array(':id' => $stop));

	while ($show = $SQLSelect->fetch(PDO::FETCH_ASSOC)) {
		$user = $show['user'];
		$host   = $show['ip'];
		$port   = $show['port'];
		$time   = $show['time'];
		$method = $show['method'];
		$handler = $show['handler'];
		$command  = $odb->query("SELECT `command` FROM `methods` WHERE `name` = '$method'")->fetchColumn(0);
	}
	
	$SQL      = $odb->prepare("UPDATE `logs` SET `stopped` = 1 WHERE `id` = :id ");	$SQL -> execute(array(':id' => $stop));
	
	$handlers = explode(",", $handler);

	foreach ($handlers as $handler){			$SQLSelectAPI = $odb->prepare("SELECT `api` FROM `api` WHERE `name` = :handler ORDER BY `id` DESC");	$SQLSelectAPI -> execute(array(':handler' => $handler));			while ($show = $SQLSelectAPI->fetch(PDO::FETCH_ASSOC)) {				$arrayFind 	  = array('[host]','[port]','[time]','[method]');				$arrayReplace = array($host,$port,$time,'stop');				$APILink      = $show['api'];				$APILink      = str_replace($arrayFind, $arrayReplace, $APILink);				$ch           = curl_init();				curl_setopt($ch, CURLOPT_URL, $APILink);				curl_setopt($ch, CURLOPT_HEADER, 0);				curl_setopt($ch, CURLOPT_NOSIGNAL, 1);				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);				curl_setopt($ch, CURLOPT_TIMEOUT, 3);				curl_exec($ch);				curl_close($ch);			}
	}
	die(success('Attack Has Been Stopped!'));
	
?>