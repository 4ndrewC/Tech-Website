<?php

    $page = "Home";
    require_once 'header.php'; 

	$TotalUsers = $odb->query("SELECT COUNT(*) FROM `users`")->fetchColumn(0);
	$TotalPaidUsers = $odb->query("SELECT COUNT(*) FROM `users` WHERE `membership`")->fetchColumn(0);
	$TodayAttacks = $odb->query("SELECT COUNT(*) FROM `logs` WHERE date >= CURDATE()")->fetchColumn(0);
	$MonthAttack = $odb->query("SELECT COUNT(*) FROM `logs` WHERE date >= CURDATE()  - INTERVAL 30 DAY")->fetchColumn(0);
	$TotalAttacks = $odb->query("SELECT COUNT(*) FROM `logs`")->fetchColumn(0);
	$TotalPools = $odb->query("SELECT COUNT(*) FROM `api`")->fetchColumn(0);
	$RunningAttacks = $odb->query("SELECT COUNT(*) FROM `logs` WHERE `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0")->fetchColumn(0);

?>
		<div class="page-wrapper" style="display: block;">
			<div class="page-breadcrumb">
				<div class="d-flex align-items-center">
					<h4 class="page-title text-truncate text-white font-weight-medium mb-0">Dashboard</h4>
					<div class="ml-auto">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb m-0 p-0">
								<li class="breadcrumb-item text-sql" aria-current="page"><?php echo $sitename; ?></li>
								<li class="breadcrumb-item text-muted" aria-current="page">Dashboard</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
      </ul>
	  <div class="container-fluid">
				<div class="card-group">
					<div class="card border-right">
						<div class="card-body">
							<div class="d-flex d-lg-flex d-md-block align-items-center">
								<div>
									<div class="d-inline-flex align-items-center">
										<h2 class="text-white mb-1 font-weight-medium"><?php echo $TotalUsers; ?></h2>
									</div>
									<h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate mb-2">用户总数</h6>
								</div>
							
								<div class="ml-auto mt-md-3 mt-lg-0">
									<span class="opacity-7 text-muted"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></span>
								</div>
							</div> 
							<div class="progress progress-md">
								<div class="progress-bar bg-purple" role="progressbar" style="width: <?php echo $TotalUsers; ?>%"></div>
							</div>
						</div>
					</div>
					<div class="card border-right">
						<div class="card-body">
							<div class="d-flex d-lg-flex d-md-block align-items-center">
								<div>
									<div class="d-inline-flex align-items-center">
										<h2 class="text-white mb-1 font-weight-medium"><?php echo $TotalAttacks; ?></h2>
									</div>
									<h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate mb-2">总攻击</h6>
								</div>
								<div class="ml-auto mt-md-3 mt-lg-0">
									<span class="opacity-7 text-muted"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></span>
								</div>
							</div>
							<div class="progress progress-md">
								<div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $TotalAttacks; ?>%"></div>
							</div>
						</div>
					</div>
					<div class="card border-right">
						<div class="card-body">
							<div class="d-flex d-lg-flex d-md-block align-items-center">
								<div>
									<div class="d-inline-flex align-items-center">
										<h2 class="text-white mb-1 font-weight-medium"><?php echo $RunningAttacks; ?></h2>
									</div>
									<h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate mb-2">正在运行的任务</h6>
								</div>
								<div class="ml-auto mt-md-3 mt-lg-0">
									<span class="opacity-7 text-muted"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg></span>
								</div>
							</div>
							<div class="progress progress-md">
								<div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $RunningAttacks; ?>%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="40"></div>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<div class="d-flex d-lg-flex d-md-block align-items-center">
								<div>
									<h2 class="text-white mb-1 font-weight-medium"><?php echo $TotalPaidUsers; ?></h2>
									<h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate mb-2">活跃用户</h6>
								</div>
								<div class="ml-auto mt-md-3 mt-lg-0">
									<span class="opacity-7 text-muted"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg></span>
								</div>
							</div>
							<div class="progress progress-md">
								<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $TotalPaidUsers; ?>%"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 col-lg-7">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">公告</h4>
								<div class="mt-4 activity">
                                            <div class="col-lg-12">
										
                                                  			<?php 
						                                                        $newssql = $odb -> query("SELECT * FROM `news` ORDER BY `date` DESC LIMIT 5");
					                                                        	while($row = $newssql ->fetch()){
						                                                     	$ID = $row['ID'];
							                                                    $title = $row['title'];
						                                                    	$content = $row['content'];
						                                                    	$date = $row['date'];
						                                                    	
						                                                    	
						                                                    echo 
							'
							<div class="d-flex align-items-start border-left-line pb-3">
													<div>
														<a href="javascript:void(0)" class="btn btn-purple btn-circle mb-2 btn-item">
															<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
														</a>
													</div>
													<div class="ml-3 mt-2">
														<h5 class="text-white font-weight-medium mb-2">'.$title.'</h5>
														<p class="font-14 mb-2 text-muted">'.$content.'</p>
														<span class="font-weight-light font-14 text-muted">Getstress 2022</span>
													</div>
												</div> ' ;
						}
                                                           ?>
                 </div></div></div></div></div>
					<?php
	$plansql = $odb -> prepare("SELECT `users`.`expire`, `plans`.`name`, `plans`.`concurrents`, `plans`.`max`, `plans`.`mbt`  FROM `users`, `plans` WHERE `plans`.`ID` = `users`.`membership` AND `users`.`ID` = :id");
	$plansql -> execute(array(":id" => $_SESSION['ID']));
	$row = $plansql -> fetch(); 
	$date = date("d M Y", $row['expire']);
	if (!$user->hasMembership($odb)){
		$row['mbt'] = 'No membership';
		$row['concurrents'] = 'No membership';
		$row['max'] = 'No membership';
		$row['name'] = 'No membership';
		$date = 'No membership';
		
	}
?>
					<div class="col-md-6 col-lg-5">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">个人信息</h4>
								<div class="mt-4 activity">
									<div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<td>ID</td>
													<td><?php echo $_SESSION['ID']; ?></td>
												</tr>
												<tr>
													<td>账号</td>
													<td><?php echo $_SESSION['username']; ?></td>
												</tr>
												<tr>
													<td>最大攻击时间</td>
													<td><?php echo $row['mbt']; ?>秒</td>
												</tr>
												<tr>
													<td>最大并发</td>
													<td><?php echo $row['concurrents']; ?></td>
												</tr>
												<tr>
												    	<td>冷却时间</td>
													<td><?php echo $row['max']; ?>秒</td>
												</tr>
												<tr>
													<td>到期时间</td>
													<td><?php echo $date; ?></td>
												</tr>
											</tbody>
										</table>	
					
                  </div>
                </div>
              </div>
            </div>
          </div>
          
		  <?php 
															$usereid=$_SESSION["ID"];
	$carkcekim = $odb->query("SELECT `cark` FROM `users` WHERE `ID` = '$usereid'")->fetchColumn(0);
	
								if($carkcekim<date("Y-m-d") || $carkcekim==Null){ ?>
  <link rel="stylesheet" href="wheel/superwheel.css" type="text/css" />
        <script type="text/javascript" src="wheel/superwheel.js"></script>
		  
		  
		  <div class="col-md-12 col-lg-12">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Wheel</h4>
								<div class="mt-4 activity text-center">
								
								
		     <main class="cd-main-content text-center">
		<div class="wheel-with-image"></div>
	</main> 
			<?php
 if(@$_GET["cark"]!="1"){  ?>
                            <a href="?cark=1" class="btn btn-primary btn-lg col-5">Spin The Wheel</a>
 <?php } ?>
                </div>
              </div>
            </div>
          </div>
		  
		  
		
		
		
<script>




// Super Wheel Script
jQuery(document).ready(function($){
	
	
	
	
	$('.wheel-with-image').superWheel({
		slices: [
		<?php 
		   $sans="1";
			   $liste="0";
							$SQLSelect = $odb -> query("SELECT * FROM `cark` ORDER BY `ID` DESC");
							while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
							{  
								$planID=$show["plan"];
								$plan = $odb->query("SELECT `name` FROM `plans` WHERE `ID` = '$planID'")->fetchColumn(0); ?>
		{
			text: '<?php echo htmlentities($plan); ?>',
			value: <?=$liste;?>,
			message: "You win <?php echo htmlentities($plan); ?>",
			background: "rgb(44 55 72)",
			
		},
							<?php  $sans=$sans+$show["sans"]; $liste++;  } ?>

	],
	line: {
		width: 3,
		color: "#cccccc"
	},
	outer: {
		width: 14,
		color: "#cccccc"
	},
	inner: {
		width: 15,
		color: "#cccccc"
	},
	marker: {
		background: "rgba(204, 163, 0, 0.7)",
		animate: 1
	},
				center: {
					width      : 30,
					background : '#FFFFFF00',
					rotate     : true,
					class      : "",
					image      :{
							url   : "wheel/orta.png",
						    width : 40,
					},
					html      : {
						template : '',
						width    : 45,
					}
				},
	selector: "value",
	
	width: 550
	
	});
	
	
	
	var tick = new Audio('wheel/tick.mp3');
		

		
	<?php
 if(@$_GET["cark"]=="1"){ 


			
			$odul=rand(1,$sans);
			
			
			   $sans2="1";
			   $liste="0";
							$SQLSelect = $odb -> query("SELECT * FROM `cark` ORDER BY `ID` DESC");
							while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
							{  
								$planID=$show["plan"];
								$carkID=$show["id"];
								$planodul = $odb->query("SELECT `name` FROM `plans` WHERE `ID` = '$planID'")->fetchColumn(0); 
								$sans2=$sans2+$show["sans"];  
								if($sans2>=$odul){
									break;
									continue;
								}
							
								$liste++;
								}
								
		if($planID!=Null){
			$code = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);
		
			 /// Input to database
			$SQLinsert = $odb -> prepare("INSERT INTO `giftcards` VALUES(NULL, :code, :planID, 0, 0, UNIX_TIMESTAMP(), :user)");
			$SQLinsert -> execute(array(':code' => $code, ':planID' => $planID, ':user' => $_SESSION["ID"]));	
			
$tarih= date("Y-m-d",strtotime('+7 day'));
	$SQLinsert = $odb -> prepare("UPDATE `users` SET `cark` = :plan WHERE `ID` = :id");
			$SQLinsert -> execute(array(':plan' => $tarih, ':id' => $_SESSION["ID"]));
		}
			
		?>


		$('.wheel-with-image').superWheel('start','value',<?php echo $liste; ?>);
		$(this).prop('disabled',true);

<?php		
		


 }
 else{
  ?>
	$(document).on('click','.wheel-with-image-spin-button',function(e){
		
		$('.wheel-with-image').superWheel('start','value',0);
		$(this).prop('disabled',true);
	});
  <?php
 }

 ?>




	
	
	$('.wheel-with-image').superWheel('onStart',function(results){
		
		
		$('.wheel-with-image-spin-button').text('Spinning...');
		
	});
	$('.wheel-with-image').superWheel('onStep',function(results){
		
		if (typeof tick.currentTime !== 'undefined')
			tick.currentTime = 0;
        
		tick.play();
		
	}); 

	

	
	  
	$('.wheel-with-image').superWheel('onComplete',function(results){
		//console.log(results.value);
	
			
	$('#myModaaal').modal('show');
			
		setTimeout(function(){
  window.location = "activate.php";
}, 4000);
		
		
		$('.wheel-with-image-spin-button:disabled').prop('disabled',false).text('Spin');
		
	});
	
	
	
});
</script>

		<?php
 if(@$_GET["cark"]=="1"){ 

?>
<div id="myModaaal" class="modal " role="">
  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">
      <div class="modal-header" style="background-color: #12151d !important;">
        <h4 class="modal-title">Congratulations!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="background-color: #12151d !important;">
                <center>  
                  <p style="font-size:20px;font-weight: bold; margin-top: 20px;color:white;"><?php echo $planodul;?></p>
                </center>
      </div>
      <div class="modal-footer" style="background-color: #12151d !important;">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><?php } ?>
		  
		  
								<?php } ?>
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
        </div>
      </div>
      <!--/.row -->
	  <script>

		alerts();

		function alerts() {
			document.getElementById("alertsdiv").style.display = "none";
			document.getElementById("alerts").style.display = "inline"; 
			var xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			}
			else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("alertsdiv").innerHTML = xmlhttp.responseText;
					document.getElementById("alerts").style.display = "none";
					document.getElementById("alertsdiv").style.display = "inline-block";
					document.getElementById("alertsdiv").style.width = "100%";
					eval(document.getElementById("ajax").innerHTML);
				}
			}
			xmlhttp.open("GET","includes/ajax/user/alerts.php",true);
			xmlhttp.send();
		}
		</script>
		
		
		
		
		
		