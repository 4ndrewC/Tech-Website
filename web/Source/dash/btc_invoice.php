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



<html>
	<title><?php echo $sitename; ?> | Invoice</title>
		<div class="page-wrapper" style="display: block;">
			<div class="page-breadcrumb">
				<div class="d-flex align-items-center">
					<h4 class="page-title text-truncate text-white font-weight-medium mb-0">Invoice for <?php echo $_SESSION['username']; ?></h4>
					<div class="ml-auto">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb m-0 p-0">
								<li class="breadcrumb-item text-sql" aria-current="page"><?php echo $sitename; ?></li>
								<li class="breadcrumb-item text-muted" aria-current="page">Invoice</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
      </ul>	
	  											<script>
											function updateAttackTime(val)
											{
												updatePrice();
												document.getElementById('current_attacktime').textContent=val; 
											}
											function updateConcurrents(val)
											{
												updatePrice();
												document.getElementById('current_concurrents').textContent=val; 
											}
											function updatePrice()
											{
												var attacktime=$('#attacktime').val();
												var concurrents=$('#concurrents').val();
												const finish = (attacktime / 600 * 5) + (concurrents * 10)
												document.getElementById('current_price').textContent=finish;
											}
											function redirect(type)
											{
												var attacktime=$('#attacktime').val();
												var concurrents=$('#concurrents').val();
												if(type == "btc") window.location.href = `btc_invoice.php?time=${attacktime}&concurrents=${concurrents}`;
												if(type == "qiwi") window.location.href = `qiwi_invoice.php?time=${attacktime}&concurrents=${concurrents}`;
											}
											</script>
			<div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><div class="spinner-border text-primary" role="status"><span class="sr-only"></span></div> Awaiting payment...</h4>
                                <div class="mt-4 activity">
                                    <p><span class="text-danger"><i class="fas fa-exclamation-triangle"></i></span> Your payment will be accepted after 1 confirmation.</p>
									<p><span class="text-primary"><i class="fas fa-credit-card"></i></span> Address: <b>19wfVkToj4WpRF3RVZJJLpZ1VQmBvcr3n2</b></p>
									<p><span class="text-primary"><i class="fab fa-bitcoin"></i></span> Amount (BTC): <b>0.00023452</b></p><br>
									<p>You purchase:</p>
									<p><span class="text-primary"><i class="fas fa-clock"></i></span> Attack Time: <b id="current_attacktime">600</b></p>
									<p><span class="text-primary"><i class="fas fa-rocket"></i></span> Concurrent Attacks: <b>1</b></p><br>
									<p>Pay strictly according to the specified details! Otherwise you will not receive your package.</p>
									<form method="post">
										<button id="doClose" name="doClose" type="submit" class="btn waves-effect waves-light btn-primary">Close Invoice</button>
									</form>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-md-6 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">QR code:</h4>
								<center><b class="text-primary"><img src="https://chart.googleapis.com/chart?chs=250x250&amp;cht=qr&amp;chl=bitcoin:19wfVkToj4WpRF3RVZJJLpZ1VQmBvcr3n2?amount=0.00023452" height="200" width="200"></b></center>
                            </div>
                        </div>
                    </div>
                </div>			
            </div>
		        </div>
    </div>