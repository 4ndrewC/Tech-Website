<?php

	ob_start(); 
	require_once '../app/config.php';
	require_once '../app/init.php'; 

	if (!empty($maintaince)) {
		die($maintaince);
	}

	if (!($user->LoggedIn()) || !($user->notBanned($odb)) || !(isset($_SERVER['HTTP_REFERER']))) {
		die();
	}

	if (!($user->hasMembership($odb)) && $testboots == 0) {
		die();
	}
	
	$username = $_SESSION['username'];

?>
           
                  <!-- <table class="mt-2 table bg-gray-800  table-bordered border-gray"> -->
                    
<div class="table-responsive">
<table class="table mb-0">
	<thead>
        <tr>
            <th style="font-size: 16px;" class="text-center">ID</th>
            <th style="font-size: 16px;" class="text-center">Target</th>
			<th style="font-size: 16px;" class="text-center">Method</th>
			<th style="font-size: 16px;" class="text-center">Expires</th>
			
        </tr>
    </thead>
    <tbody>
									<?php	
									$SQLSelect = $odb->query("SELECT * FROM `logs` WHERE user='{$_SESSION['username']}' AND `stopped` = 0 AND `time` + `date` > UNIX_TIMESTAMP()");
									$plansql = $odb -> prepare("SELECT `plans`.`max` FROM `users`, `plans` WHERE `plans`.`ID` = `users`.`membership` AND `users`.`ID` = :id");
                                         $plansql -> execute(array(":id" => $_SESSION['ID']));
                                         $rowxd = $plansql -> fetch();
                                         
									while ($show = $SQLSelect->fetch(PDO::FETCH_ASSOC)) {
									    
									    

										$id = $show['id'];		
										$name = $show['user'];	
										$time = $show['time'];
										$ip = $show['ip'];
										$mode = $show['mode'];
										$method = $odb->query("SELECT `fullname` FROM `methods` WHERE `name` = '{$show['method']}' LIMIT 1")->fetchColumn(0);
										$cookie = $show['cookie'];
										$postdata = $show['postdata'];
										$rowID = $show['id'];
										$handler = $show['handler'];
										$date = $show['date'];

										$cible = $show['date']+$show['time'];

										$now = time();

										$seconde = $cible - $now;
										
        //$expires = $date + $time - time();
        $expires = $date + $time + intval($rowxd['max']) - time();

        if ($expires < 0 || $show['stopped'] != 0) {
            $countdown = "Expired";
        }
		else {
            $countdown = '<div id="a' . $rowID . '"></div>';
            echo "
				<script id='ajax'>
					var count={$expires};
					var counter=setInterval(a{$rowID}, 1000);
					function a{$rowID}(){
						count=count-1;
						if (count <= 0){
							clearInterval(counter);
							attacks();
							return;

						}
					document.getElementById('a{$rowID}').innerHTML=count;
					}
				</script>
			";
        }

        if ($show['time'] + $show['date'] > time() and $show['stopped'] != 1) {
            $action = '<button type="button" onclick="stop(' . $rowID . ')" id="st" class="btn btn-danger btn-sm"></i> Stop</button>';
        }

										?>
        <tr>
            <th style="font-size: 14px;" class="text-center"><?php echo $rowID ?></th>
            <th style="font-size: 14px;" class="text-center"><?php echo $ip ?></th>
			<th style="font-size: 14px;" class="text-center"><?php echo $method ?></th>
			<th style="font-size: 14px;" class="text-center"><?php echo $countdown ?></th>
			<!-- <th style="font-size: 14px;" class="text-center"><?php echo $action ?></th> -->
        </tr>
    </thead>
										<script>
											var count<?php echo $id; ?>=<?php echo ($seconde < 10 ? "0". $seconde : $seconde); ?>;
											var counter<?php echo $id; ?>=setInterval(stress<?php echo $id; ?>, 1000);
											function stress<?php echo $id; ?>()
											{
												count<?php echo $id; ?>=count<?php echo $id; ?>-1;
												if (count<?php echo $id; ?> <= 0)
												{
													clearInterval(counter<?php echo $id; ?>);
													return;
												}
												document.getElementById("<?php echo $id; ?>").innerHTML=count<?php echo $id; ?>;
											}
										</script>
										<?php

									}
									?> 
								</tbody>
							</table>						
						</div>
					</form>									
				</div>
			</div>