<?php

	define('DB_HOST', 'localhost');
	define('DB_NAME', 'ipstresser');
	define('DB_USERNAME', 'ipstresser');
	define('DB_PASSWORD', 'ipstressermade');
	define('ERROR_MESSAGE', '[Error] CyberStress maintenance');

	try {
		$odb = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME.';charset=utf8', DB_USERNAME, DB_PASSWORD);
	} catch( PDOException $Exception ) {
		error_log('ERROR: '.$Exception->getMessage().' - '.$_SERVER['REQUEST_URI'].' at '.date('l jS \of F, Y, h:i:s A')."\n", 3, 'error.log');
		die(ERROR_MESSAGE);
	}
error_reporting(0);
	function error($string){  
		return '<div class="alert alert-danger alert-dismissible bg-danger text-sql border-0 fade show"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>ERROR:</strong> '.$string.'</div>';
	}

	function success($string) {
		return '<div class="alert alert-success alert-dismissible bg-success text-sql border-0 fade show"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>SUCCESS:</strong> '.$string.'</div>';
	}
	session_start();
	ob_start();
	
	require_once 'init.php';
	if(isset($_SESSION['ID']) || isset($_SESSION['username'])){
		$siteinfo = $odb -> query("SELECT * FROM `settings` LIMIT 1");
		$show = $siteinfo -> fetch(PDO::FETCH_ASSOC);
	
			if ($show['cloudflare'] == 1){
		$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}
	else{
		$ip = $user -> realIP();
	}
	
	$usere = $odb -> prepare("SELECT * FROM users WHERE ID = :id ");
	$usere -> execute(array(":id" => $_SESSION['ID']));
	$usere = $usere -> fetch(); 
	
//	$hash=md5(md5($ip.$_SESSION['ID'].$_SERVER["HTTP_USER_AGENT"].$_SESSION['username']));
	$hash2=md5(md5($usere["login_ip"].$usere['ID'].$usere["login_useragent"].$usere['username']));
//	if($_SESSION["hash"]!=$hash || $hash!=$hash2){
	if($_SESSION["hash"]!=$hash2){
		$sbp="由于从两个不同的ip地址同时登录而被封禁";
	$SQLUpdate = $odb -> prepare("UPDATE `users` SET `ban_sbp` = :ban_sbp ,  `status` = :status WHERE `id` = :id");
	$SQLUpdate -> execute(array(':ban_sbp' => $sbp, ':status' => "1", ':id' => $_SESSION['ID']));
		
				unset($_SESSION['username']);
			unset($_SESSION['ID']);
			setcookie("username", "", time() + 720000);
			session_destroy();
		header("Location: /");
		exit;
	}
	
	}
	
	if(@$_POST){
		foreach($_POST as $deg => $val){
		    if(is_array($_POST[$deg])){
		     
		    }
		    else{
			$val=str_replace("'","",$val);
			$val=stripslashes($val);
			$val=str_replace('\\','',$val);
			$_POST[$deg]=str_replace('"',"",$val);
		    }
		}
	}
	
	if(@$_GET){
		foreach($_GET as $deg => $val){
			$val=str_replace("'","",$val);
			$val=stripslashes($val);
			$val=str_replace('\\','',$val);
			$_GET[$deg]=str_replace('"',"",$val);
		}
	}
?>
