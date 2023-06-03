<?php
require('xwaf.php');
$xWAF = new xWAF();
$xWAF->start();
$xWAF->useCloudflare();
	
	header('Location: ../../errors/404.php');
	exit;
	
?>