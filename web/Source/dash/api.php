<?php
    $page = "API";
	include 'header.php';

	if (!($user->hasMembership($odb)) && $testboots == 0) {
		header('location: store.php');
		exit;
	}
?>

<?php

	/// Require the header that already contains the sidebar and top of the website and head body tags
	require_once 'header.php'; 
	
	/// Querys for the stats below
	$TodayAttacks = $odb->query("SELECT COUNT(id) FROM `logs` WHERE `date` BETWEEN DATE_SUB(CURDATE(), INTERVAL '-1' DAY) AND UNIX_TIMESTAMP()")->fetchColumn(0);
	$MonthAttack = $odb->query("SELECT COUNT(id) FROM `logs` WHERE `date` BETWEEN DATE_SUB(CURDATE(), INTERVAL '-30' DAY) AND UNIX_TIMESTAMP()")->fetchColumn(0);
	$TotalAttacks = $odb->query("SELECT COUNT(*) FROM `logs`")->fetchColumn(0);
	$RunningAttacks = $odb->query("SELECT COUNT(*) FROM `logs` WHERE `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0")->fetchColumn(0);
	
	$testattacks = $odb->query("SELECT COUNT(*) FROM `logs` WHERE `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0")->fetchColumn(0);
	$load    = round($testattacks / $maxattacks * 100, 2);
?>

<?php
	$plansql = $odb -> prepare("SELECT `users`.`expire`, `users`.`api`, `plans`.`name`, `plans`.`concurrents`, `plans`.`mbt` FROM `users`, `plans` WHERE `plans`.`ID` = `users`.`membership` AND `users`.`ID` = :id");
	$plansql -> execute(array(":id" => $_SESSION['ID']));
	$row = $plansql -> fetch(); 
	$date = date("d/m/Y", $row['expire']);
	if (!$user->hasMembership($odb)){
		$row['mbt'] = 'No membership';
		$row['concurrents'] = 'No membership';
		$row['name'] = 'No membership';
		$date = 'No membership';
	}
	
	
?>


<html>
		<div class="page-wrapper" style="display: block;">
			<div class="page-breadcrumb">
			<script src="assets/js/modal.js"></script>
				<div class="d-flex align-items-center">
					<h4 class="page-title text-truncate text-white font-weight-medium mb-0">API Manager</h4>
					<div class="ml-auto">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb m-0 p-0">
								<li class="breadcrumb-item text-sql" aria-current="page"><?php echo $sitename; ?></li>
								<li class="breadcrumb-item text-muted" aria-current="page">API Manager</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
      </ul>
      <div class="container-fluid">
                <div class="row">
				
				
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12  layout-spacing">
				<div class="widget widget-table-three">
					


					<div class="widget-content">
					
						<?php
						if (isset($_POST["keyy"])) {
							$randomKey = md5(time().rand());
							
$SQLUpdate = $odb -> prepare("UPDATE `users` SET `api` = :password WHERE `username` = :username AND `ID` = :id");
$SQLUpdate -> execute(array(':password' => $randomKey,':username' => $_SESSION['username'], ':id' => $_SESSION['ID']));
						
							header("Location: api.php");
							exit;
					
						}
						?>

						<div class="form-row mb-4">
							<div class="col-12"><br>
								<form action="" method="POST">
									<label>API Key</label>
									<input type="text" readonly class="form-control" value="<?= ($row["api"] ? $row["api"] : "-") ?>" disabled><br>
							</div>
							<input type="submit" name="keyy" value="Create" class="btn btn-primary">
							</form>

						</div>



					</div>
				</div>

			</div>

<?php 

$url="https://".$_SERVER["SERVER_NAME"];

?>

			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
				<div class="widget widget-table-three">
					<div class="widget-content">
						<div class="table-responsive">
							<label>Start Attack</label>
							<input type="text" class="form-control" value="http://ipstresser.ddos.win/api.php?key=<?= ($row["api"] ? $row["api"] : "-") ?>&action=start&host=[host]&port=[port]&method=[method]&time=[time]" readonly  />
							</br>
							<label>Stop Attack</label>
							<input type="text" class="form-control" value="http://ipstresser.ddos.win/api.php?key=<?= ($row["api"] ? $row["api"] : "-") ?>&action=stop&id=attackID" readonly  />
							</br>

							<label>Methods</label><br />		
							
							<!-- <span class="badge badge-info" value="ssdp">ssdp</span> -->
							<?php
															$SQLGetLogs = $odb->query("SELECT * FROM `methods` WHERE `type` = 'layer4' ORDER BY `id` ASC");
															while ($getInfo = $SQLGetLogs->fetch(PDO::FETCH_ASSOC)) {
																$name     = $getInfo['name'];
																$fullname = $getInfo['fullname'];
																echo '<span class="badge badge-info" value="">' . $name . '</span>';
															}
														?>	
							
								<?php
															$SQLGetLogs = $odb->query("SELECT * FROM `methods` WHERE `type` = 'layer7' ORDER BY `id` ASC");
															while ($getInfo = $SQLGetLogs->fetch(PDO::FETCH_ASSOC)) {
																$name     = $getInfo['name'];
																$fullname = $getInfo['fullname'];
																echo '<span class="badge badge-info" value="">' . $name . '</span>';
															}
														?>	
						
						</div>
					</div>
				</div>
			</div>
				
				
         
   	 <script>
		function negri1(val)
		{
			updateTime();
		document.getElementById('current_attacktime').textContent=val;
		}
											
		function updateTime()
		{
		var time=$('#time').val();
		const finish = (time)
		document.getElementById('current_time').textContent=finish;
		}
      </script>
				<script>
					attacks();
			
					function attacks() {
						document.getElementById("attacksdiv").style.display = "none";
						document.getElementById("manage").style.display = "inline"; 
						var xmlhttp;
						if (window.XMLHttpRequest) {
							xmlhttp = new XMLHttpRequest();
						}
						else {
							xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange=function() {
							if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
								document.getElementById("attacksdiv").innerHTML = xmlhttp.responseText;
								document.getElementById("manage").style.display = "none";
								document.getElementById("attacksdiv").style.display = "inline-block";
								document.getElementById("attacksdiv").style.width = "100%";
								if (document.getElementById("ajax") != null)
									eval(document.getElementById("ajax").innerHTML);

								var elements = document.getElementsByName("ststst");
								if (document.getElementById("stopallbtn") != null) {
									if(elements.length > 1){
										document.getElementById("stopallbtn").style.display = "none";
									}else{
										document.getElementById("stopallbtn").style.display = "block";
									}
								}
							}
						}
						xmlhttp.open("GET","includes/ajax/attacks.php",true);
						xmlhttp.send();
					}
		
		            function start() {
			            const host=encodeURIComponent($('#host').val());
						const port=encodeURIComponent($('#port').val());
						const target=encodeURIComponent($('#target').val());
			            const time=$('#time').val();
			            const postdata=encodeURIComponent($('#postdata').val()) || "/";
			            const cookie=encodeURIComponent($('#cookie').val()) || "https://google.com/";
			            const referer=encodeURIComponent($('#referer').val()) || "false";
			            const mode=encodeURIComponent($('#mode').val());
						const emulation=encodeURIComponent($('#emulation').val());
			            const method=$('#method').val();
						const startt = encodeURIComponent($('#method option[value="'+method+'"]').parent().data("tag"));
			            const rmethod=$('#rmethod').val() || "GET";
			            document.getElementById("div").style.display="none";			
			
			               var xmlhttp;
			               if (window.XMLHttpRequest) {
			        	   xmlhttp = new XMLHttpRequest();
			               }
			                else {
				           xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			                     }
			               xmlhttp.onreadystatechange=function() {
				           if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				           document.getElementById("div").innerHTML=xmlhttp.responseText;
					       document.getElementById("div").style.display="inline";
					       if (xmlhttp.responseText.search("success") != -1) {
						     attacks();
						     window.setInterval(ping(host),10000);
					          }
				           }
			           }
			           xmlhttp.open("GET",`includes/ajax/hub_api.php?type=startl7&host=${startt == "startl7" ? host : target}&port=${port}&time=${time}&method=${method}&rmethod=${rmethod}&postdata=${postdata}&cookie=${cookie}&referer=${referer}&mode=${mode}&emulation=${emulation}`,true);
			           xmlhttp.send();
						
		            }
		
					function stop(id) {
						document.getElementById("manage").style.display="inline"; 
						document.getElementById("div").style.display="none"; 
						var xmlhttp;
						if (window.XMLHttpRequest) {
							xmlhttp=new XMLHttpRequest();
						}
						else {
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange=function() {
							if (xmlhttp.readyState==4 && xmlhttp.status==200) {
								document.getElementById("div").innerHTML=xmlhttp.responseText;
								document.getElementById("div").style.display="inline";
								document.getElementById("manage").style.display="none";
								if (xmlhttp.responseText.search("success") != -1) {
									attacks();
								}
							}
						}
						xmlhttp.open("GET",`includes/ajax/hub_api.php?type=stop&id=${id}`,true);
						xmlhttp.send();
					}

					function stopall(id) {
						document.getElementById("manage").style.display="inline"; 
						document.getElementById("div").style.display="none"; 
						var xmlhttp;
						if (window.XMLHttpRequest) {
							xmlhttp=new XMLHttpRequest();
						}
						else {
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange=function() {
							if (xmlhttp.readyState==4 && xmlhttp.status==200) {
								document.getElementById("div").innerHTML=xmlhttp.responseText;
								document.getElementById("div").style.display="inline";
								document.getElementById("manage").style.display="none";
								if (xmlhttp.responseText.search("success") != -1) {
									attacks();
								}
							}
						}
						xmlhttp.open("GET",`includes/ajax/hub_api.php?type=stopall&id=${id}`,true);
						xmlhttp.send();
					}
				</script>	