<?php
$errMsg = isset($profileConnErr) ? $profileConnErr : 'Error';

if (isset($_SESSION['start'])) {
    if (!isset($content)) {
        ob_start(); ?>
        <br> <h1> <?php echo isset($siteTabProfile) ? $siteTabProfile : 'Profile'; ?></h1>
<br>
		<?php
		$startUserIDstr = strpos($_SESSION['start'], md5($_SERVER['HTTP_USER_AGENT']+date("z")));
		if ($startUserIDstr > 0) {

			$UserID = substr($_SESSION['start'], 0, $startUserIDstr);
			$UserPassw = substr($_SESSION['start'], (strlen($UserID) + strlen(md5($_SERVER['HTTP_USER_AGENT']+date("z")))));
			unset($startUserIDstr);
			$link = dbConnector(compact('dbhost', 'dbname', 'dbuser', 'dbpass'));
			if ($link) {
				$select = 'SELECT `UserName`, `UserEmail`, `Active`, `UserPlan` FROM `users` WHERE `UserID`=' . $UserID . ' AND `UserPsw` LIKE \'' . $UserPassw . '\' LIMIT 1';
				if($result = mysqli_query($link, $select)) {
					if (mysqli_num_rows($result) == 1) {
						$user = mysqli_fetch_assoc($result);
						mysqli_free_result($result);
						$errMsg = '';
					
			?>


			<div class="card text-center">
  
				<!-- UPPER TABS -->
				<div class="card-header">
					<ul class="nav nav-tabs card-header-tabs">
						<li class="nav-item">
							<a class="nav-link active" href="#">Профиль</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Склады</a>
						</li>
					</ul>
				</div>
  
  
				<div class="card-block">
					<br><h4 class="card-title">Детали учетной записи</h4><br>
    
	
					<!-- PARAMETERS -->
					
					<div class="card">
						<div class="card-block"><br>
							<h6 class="card-subtitle mb-2 text-muted">Параметры учетной записи</h6>
							<br>
							<div class="form-group row">
								<div class="col col-4">
							
									<div class="input-group mb-2 mr-sm-2 mb-sm-0">
										<div class="input-group-addon">User Card ID:</div>
										<input type="text" class="form-control" id="user-account-id" readonly value="<?php echo $UserID; ?>">
									</div>
								</div>
							
								<div class="col">

									<div class="input-group">
										<span class="input-group-addon">
											<input <?php echo ($user['Active']>=1) ? 'checked' : ''; ?> type="checkbox" aria-label="Checkbox for following text input" id="accountactivechk">
										</span>
										<input disabled value="<?php echo isset($siteSelectorAccountActive) ? $siteSelectorAccountActive : 'Active'; ?>" type="text" id="accountactivelbl"  aria-label="Text input with checkbox" class="form-control <?php echo ($user['Active']<1) ? 'btn-danger' : ''; ?> ">
									</div>

								</div>
					
							</div>
							
							<div class="form-group row">
							<div class="col">
								<label for="exampleSelect1">Условия пользования</label>
								<select class="form-control" id="planSelect" disabled>
									<option>Безплатный</option>
									<option>Платный</option>
								</select>
							</div>
							</div>
							
						</div>
					</div>	


<br>
					<!-- USERs DATA -->
					<div class="card">
						<div class="card-block"><br>
							<h6 class="card-subtitle mb-2 text-muted">Имя и данные данные</h6>
							<br>

							<div class="form-group row">
								<label for="user-text-input" class="col-2 col-form-label">Имя</label>
								<div class="col-10">
									<input class="form-control" type="text" value="<?php echo $user['UserName']; ?>" id="user-text-input">
								</div>
							</div>
	
							<div class="form-group row">
								<label for="user-email-input" class="col-2 col-form-label"><?php echo isset($siteLoginNameLbl) ? $siteLoginNameLbl : 'E-mail'; ?></label>
								<div class="col-10">
									<input class="form-control" type="email" value="<?php echo $user['UserEmail']; ?>" id="user-email-input">
								</div>
							</div>

							<div class="form-group row">
								<label for="user-password-input" class="col-2 col-form-label"><?php echo isset($siteLoginPasswLbl) ? $siteLoginPasswLbl : 'Password'; ?></label>
								<div class="col-10">
									<input class="form-control" type="password" value="<?php echo $UserPassw; ?>" id="user-password-input">
								</div>
							</div>	
						</div>
					</div>

	
					<br><a href="" data-toggle="modal" class="btn btn-primary" id="save-profile">Сохранить</a>
				</div>
			</div>

		





	
		
		
			<?php
					}
				}
				mysqli_close($link);
			}
		}
		$content = ob_get_clean();
    }

	require 'baseTemplate.php';
?>
	
	
		<!-- PASWWORD CONFIRM -->
        <div id="PconfirmModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title"><?php echo isset($siteLoginTitle) ? $siteLoginTitle : ''; ?></h4>
                    </div>
                    <!-- Основное содержимое модального окна -->
                    <div class="modal-body">


                        <form role="form" id="PconfirmForm" data-toggle="validator" class="shake">
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="password" class="h4"><?php echo $siteLoginPasswLbl; ?></label>
                                    <input type="password" class="form-control" id="conf-password"
                                           placeholder="<?php echo isset($siteRegisterPasswPlace) ? $siteRegisterPasswPlace : ''; ?>" required data-error="<?php echo isset($siteRegisterPasswErr) ? $siteRegisterPasswErr : ''; ?>">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <input type="hidden" id="uri1" value="<?php echo $currentAction; ?>">
                            <input type="hidden" id="uri2" value="<?php echo $currentLang; ?>">
                            <button type="submit" id="conf-form-submit"
                                    class="btn btn-success btn-lg pull-right "><?php echo isset($siteLoginLoginBtn) ? $siteLoginLoginBtn : 'Login'; ?></button>
                            <div id="msgSubmit" class="h3 text-center hidden"></div>
                            <div class="clearfix"></div>
                        </form>

                    </div>
                    <!-- Футер модального окна -->
                    <div class="modal-footer">
                        <button type="button" class="btn"
                                data-dismiss="modal"><?php echo isset($siteLoginCloseBtn) ? $siteLoginCloseBtn : 'Close'; ?></button>
                    </div>
                </div>
            </div>
        </div>
	
	
	
<?php	
}

if($errMsg != '') {
	?>
	<br>
	<div class="container">
	<div class="alert alert-danger" role="alert">
		<?php echo isset($profileConnErr) ? $profileConnErr : 'Error'; ?>
	</div></div>
	<br>
	<?php
}
 ?>
