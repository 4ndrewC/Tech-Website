<?php

	/// Require the header that already contains the sidebar and top of the website and head body tags
	require_once 'header.php'; 
	
	if(isset($_POST['createnewCard']))
	{
		$plan = $_POST['plan'];
		$sans = $_POST['sans'];

		if(empty($plan) || empty($sans))
		{
			$notify = error('Failed to update due to missing values');
		}

		if(empty($notify))
		{
			 /// Generate Gift Code
			
			 /// Input to database
			$SQLinsert = $odb -> prepare("INSERT INTO `cark` VALUES(NULL, :planID, :sans)");
			$SQLinsert -> execute(array(':planID' => $plan, ':sans' => $sans));	

			$notify = success('Çark ürünü başarıyla eklendi.');
		}	
	}
	
		if(isset($_POST['delete'])){
		$deleteSQL = $odb->prepare("DELETE FROM `cark` WHERE `id` = :id");
		$deleteSQL->execute(array(':id' => $_POST['delete']));
		$notify = success('Çark silindi');
	}
	
	if (isset($_POST['update'])){
		$plan = $_POST['plan'.$_POST['update']];
		$sans = $_POST['sans'.$_POST['update']];
		
		if (empty($plan) || empty($sans)){
			$notify = error('Failed to update due to missing values');
		}
		else {
			$SQLinsert = $odb -> prepare("UPDATE `cark` SET `plan` = :plan, `sans` = :sans WHERE `ID` = :id");
			$SQLinsert -> execute(array(':plan' => $plan, ':sans' => $sans, ':id' => $_POST['update']));
			$notify = success('Çark güncellendi');
		}
	}
	
?>


<html>
	<title><?php echo $sitename; ?> | Çark</title>
		<div class="page-wrapper" style="display: block;">
			<div class="page-breadcrumb">
				<div class="d-flex align-items-center">
					<h4 class="page-title text-truncate text-white font-weight-medium mb-0">Çark</h4>
					<div class="ml-auto">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb m-0 p-0">
								<li class="breadcrumb-item text-sql" aria-current="page"><?php echo $sitename; ?></li>
								<li class="breadcrumb-item text-muted" aria-current="page">Çark</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
      </ul>
  <div class="container-fluid">  
     <div class="col-lg-12">
      <div id="accordion2">
        <div class="card">
          <div class="card-header">
      <div class="row">
	  	  <?php
		if(isset($notify)){
			echo ($notify);
		}
		?>
	
	     <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="white-box">
            <h3 class="box-title"></h3>
				<table class="table">
						<tr>
							<th style="font-size: 12px;">Ürün</th>
							<th class="text-center" style="font-size: 12px;">Şans</th>
						</tr>
						<tr>
						<?php
							$SQLSelect = $odb -> query("SELECT * FROM `cark` ORDER BY `ID` DESC");
							while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
							{
								$id=$show["id"];
								$planID=$show["plan"];
								$plan = $odb->query("SELECT `name` FROM `plans` WHERE `ID` = '$planID'")->fetchColumn(0);
								echo '<tr">
										<td class="text-center" style="font-size: 12px;"><a class="link-effect" href="#" data-toggle="modal" data-target="#modal-fadein'. $id .'" >'.htmlentities($plan).'</a></td>
										<td class="text-center" style="font-size: 12px;">'.htmlentities($show['sans']).'</td>
									</tr>';
								?>
									<div class="modal fade" id="modal-fadein<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
									  <div class="modal-dialog" role="document">
										<div class="modal-content text-dark">
										  <div class="modal-header">
											<h4 class="modal-title" id="exampleModalLabel1">Edit Plan</h4>
										  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										  </div>
										  <div class="modal-body">
										  
											<form class="form-horizontal" method="post">
																<div class="form-group">
																	<div class="col-sm-12">
																		<div class="form-material">
																		<label for="plan2">Plan</label>
										<select class="form-control" id="plan2" name="plan<?php echo $id; ?>">
											<?php
											$SQLGetMethods = $odb -> query("SELECT * FROM `plans`");
											while($getInfo = $SQLGetMethods -> fetch(PDO::FETCH_ASSOC)){
												$IDa = $getInfo['ID'];
												$name = $getInfo['name'];
												if($IDa==$show["plan"]){
												echo '<option value="'.$IDa.'" selected>'.$name.'</option>';
												}
												else{
												echo '<option value="'.$IDa.'">'.$name.'</option>';
												}
											}
											?>
										</select>
																			
																		</div>
																	</div>
																</div> 
																<div class="form-group">
																	<div class="col-sm-12">
																		<div class="form-material">
																		<label for="sans2">Şans Oranı</label>
																			<input class="form-control" type="text" pattern="[0-9.]*" id="sans2" name="sans<?php echo $id; ?>" value="<?php echo htmlspecialchars($show["sans"]); ?>">
																			
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<div class="col-sm-9">
																		<button name="update" value="<?php echo $id; ?>" class="btn btn-sm btn-primary" type="submit">Update</button>
																		<button name="delete" value="<?php echo $id; ?>" class="btn btn-sm btn-danger" type="submit">Delete</button>
																	</div>
																</div>
															</form>
											</div>
										  
										  <div class="modal-footer">
											
										  </div>
										  </div>
										</div>
									  </div>
									</div>
							<?php
							} 
							?>
									</tr>                                       
					</table>
          </div>
        </div>

		<div class="col-md-6 col-sm-12 col-xs-12">
          <div class="white-box">
            <h3 class="box-title">Add new giftcard</h3>
				<form class="form-horizontal push-10-t" method="post">
							<div class="form-group">
								<div class="col-sm-12">
									<div class="form-material">
									<label for="plan">Plan</label>
										<select class="form-control" id="plan" name="plan">
											<?php
											$SQLGetMethods = $odb -> query("SELECT * FROM `plans`");
											while($getInfo = $SQLGetMethods -> fetch(PDO::FETCH_ASSOC)){
												$ID = $getInfo['ID'];
												$name = $getInfo['name'];
												echo '<option value="'.$ID.'">'.$name.'</option>';
											}
											?>
										</select>
										
									</div>
								</div><br>
								<div class="col-sm-12">
									<div class="form-material">
									<label for="plan">Şans Oranı</label>
									<input class="form-control" type="text" id="sans" pattern="[0-9.]*" name="sans" value="">
										
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-9">
									<button name="createnewCard" value="do" class="btn btn-sm btn-primary" type="submit">Submit</button>
								</div>
							</div>
						</form>
			
          </div>
        </div>
		
      </div>
	  
<?php

	require_once 'footer.php';
	
?>