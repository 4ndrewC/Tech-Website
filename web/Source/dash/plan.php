<?php
    $page = "Plans";
	require_once 'header.php';
	?>
	<?php
$SQLGetPlans = $odb -> query("SELECT * FROM `plans` WHERE `private` = 0 ORDER BY `price` ASC");
while ($getInfo = $SQLGetPlans -> fetch(PDO::FETCH_ASSOC))
{
$name = $getInfo['name'];
$price = $getInfo['price'];
$length = $getInfo['length'];
$unit = $getInfo['unit'];
$concurrents = $getInfo['concurrents'];
$mbt = $getInfo['mbt'];
$ID = $getInfo['ID'];
$max = $getInfo['max'];
echo '
<html>

		<div class="page-wrapper" style="display: block;">
			<div class="page-breadcrumb">
				<div class="d-flex align-items-center">
					<h4 class="page-title text-truncate text-white font-weight-medium mb-0">Purchase</h4>
					<div class="ml-auto">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb m-0 p-0">
								<li class="breadcrumb-item text-sql" aria-current="page">'.$sitename.'</li>
								<li class="breadcrumb-item text-muted" aria-current="page">Purchase</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
      </ul>
	  <div class="container-fluid">
	  		  <div class="row">
		  <div class="col-md-4 grid-margin stretch-card">
									<div class="card">
									  <div class="card-body">
										<h5 class="text-center text-uppercase mt-3 mb-4">'.$name.' </h5>
										<h3 class="text-center font-weight-light">'.$price.'¥</h3>
										<p class="text-muted text-center mb-4 font-weight-light">使用天数: '.$length.'天</p>
										<div class="d-flex align-items-center mb-2">
										  <p><i class="fa fa-minus" aria-hidden="true"></i> 最大攻击时间: <b>'.$mbt.'秒</b></p>
										</div>
										<div class="d-flex align-items-center mb-2">
										  <p><i class="fa fa-minus" aria-hidden="true"></i> 并发: <b>'.$concurrents.'</b></p>
										</div>
										<div class="d-flex align-items-center mb-2">
										  <p><i class="fa fa-minus" aria-hidden="true"></i> 冷却时间: <b>'.$max.'秒</b></p>
										</div>
										<div class="d-flex align-items-center mb-2">
										<p><i class="fa fa-minus" aria-hidden="true"></i> <b>无限次数攻击</b> </p>
									    </div>
										<div class="d-flex align-items-center mb-2">
										<p><i class="fa fa-minus" aria-hidden="true"></i> <b>基本</b> 支持 <span style="color:#8cc152;font-weight: bold;" class="fa fa-question-circle" title="Any questions regarding the site and the methods available for your plan. The operator responds within ~1 hour"></span></p>
									    </div>
										<div class="d-flex align-items-center mb-2">
										<p><i class="fa fa-minus" aria-hidden="true"></i> 访问工具: <span style="color:#8cc152;font-weight: bold;" class="fa fa-check"></span></p>
									    </div>
										<div class="d-flex align-items-center mb-2">
										  <p><i class="fa fa-star-o" aria-hidden="true"></i> API对接权限: <span style="color:#da4453;font-weight: bold;" class="fa fa-times"></span></p>
										</div>
										<div class="d-flex align-items-center mb-2">
										  <p><i class="fa fa-star-o" aria-hidden="true"></i> VIP: <span style="color:#da4453;font-weight: bold;" class="fa fa-times"></span></p>
										</div>
										
										<a class="link-effect" href="https://t.me/UsdtNL_bot" target="_blank"><button class="btn btn-success btn-border btn-lg w-100 fw-bold mb-3" type="button"> 立即购买</button></a>
									  </div>
									</div>
										</div>
								  		
					</div>
          </div>
        </div>
				
									

								
															
		
        ';
}
?>
	