<?php

    $page = "Activate Code";
	/// Require the header that already contains the sidebar and top of the website and head body tags
	require_once 'header.php'; 
	
?>

<html>
		<div class="page-wrapper" style="display: block;">
			<div class="page-breadcrumb">
				<div class="d-flex align-items-center">
					<h4 class="page-title text-truncate text-dark font-weight-medium mb-0">Activate GiftCode</h4>
					<div class="ml-auto">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb m-0 p-0">
								<li class="breadcrumb-item text-primary active" aria-current="page"><?= $sitename; ?> </li>
								<li class="breadcrumb-item text-muted" aria-current="page">Activate</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
      </ul>
<div class="container-fluid">
 <div class="row">
    <div class="col-md-6 col-lg-6">
     <div class="card">
      <div class="card-body">
          <h4 class="card-title">卡密激活 <i style="display: none;" id="icon"></i></h4>
          <form class="form-horizontal" method="post" onsubmit="return false;">
		  <div id="div"></div>
            <div class="form-group">
              <div class="col-sm-12">
                <input type="text" class="form-control" name="code" id="code" placeholder="卡密">
              </div>
              <br>
              <div class="form-group m-b-0">
                <div class="col-sm-offset-3 col-sm-3">
                  <button id="launch" onclick="redeemCode()" class="btn btn-primary form-control">激活</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
	<div class="col-md-6 col-lg-6">
      <div class="card">
         <div class="card-body">
            <p class="alert alert-fill-primary text-center" >卡密激活</p>
          </div>
          <div id="collapse-6" class="collapse show" data-parent="#accordion2" style="">
            <div class="card-body">
              将你购买的卡密在上方激活您的账号自动变成对应的套餐
            </div>
          </div>
        </div>
      </div>
	  	     <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="white-box">
            <h3 class="box-title"></h3>
				<table class="table">
						<tr>
							<th style="font-size: 12px;" class="text-center">Code</th>
							<th class="text-center" style="font-size: 12px;">Plan</th>
							<th class="text-center" style="font-size: 12px;">Date Claimed</th>
							<th class="text-center" style="font-size: 12px;">Date Created</th>
						</tr>
						<tr>
						<?php $userid=$_SESSION["ID"];
							$SQLSelect = $odb -> query("SELECT * FROM `giftcards` where user='$userid' ORDER BY `ID` DESC ");
							while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
							{
								$ID = $show['unit'];
								$code = $show['code'];
								$planID = $show['planID'];
								$claimedby = $show['claimedby'];
								$status = $show['status'];
								$dateClaimed = $show['dateClaimed'];
								$date = $show['date'];
								if(!($dateClaimed == "0"))
								{
									$dateClaimed = date("m-d-Y, h:i:s a" , $dateClaimed);
								}
								if($claimedby == "0") { $claimedby = "Unclaimed"; }
								if($dateClaimed == "0") { $dateClaimed = "Unclaimed"; }
								$date = date("m-d-Y, h:i:s a" , $date);
								$plan = $odb->query("SELECT `name` FROM `plans` WHERE `ID` = '$planID'")->fetchColumn(0);
								echo '<tr">
										<td class="text-center" style="font-size: 12px;">'.$code.'</td>
										<td class="text-center" style="font-size: 12px;">'.htmlentities($plan).'</td>
										<td class="text-center" style="font-size: 12px;">'.htmlentities($dateClaimed).'</td>
										<td class="text-center" style="font-size: 12px;">'.htmlentities($date).'</td>
									</tr>';
							
							} 
							?>
									</tr>                                       
					</table>
          </div>
        </div>
	  
    </div>
  </div>
			<script>
			function redeemCode() {
				var code = $('#code').val();
				document.getElementById("icon").style.display="inline"; 
				var xmlhttp;
				if (window.XMLHttpRequest) {
					xmlhttp=new XMLHttpRequest();
				}
				else {
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
						document.getElementById("icon").style.display="none";
						document.getElementById("div").innerHTML=xmlhttp.responseText;
						if (xmlhttp.responseText.search("SUCCESS") != -1) {
							inbox();
						}
					}
				}
				xmlhttp.open("GET","includes/ajax/user/giftcodes/redeem.php?user=<?php echo $_SESSION['ID']; ?>" + "&code=" + code,true);
				xmlhttp.send();
			}
			</script>

</div>
</html>