<?php
$errMsg = isset($profileConnErr) ? $profileConnErr : 'Error';
if (!isset($content)) {
	ob_start(); 

	?>

<div class="card text-center">

    <!-- UPPER TABS -->
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="/<?php echo isset($pageLinks['profile']) ? $pageLinks['profile'] : 'profile';?>/<?php echo isset($currentLang) ? $currentLang: '/';?>"><?php echo isset($profileAccountMenu) ? $profileAccountMenu : 'Account'; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/<?php echo isset($pageLinks['stocks']) ? $pageLinks['stocks'] : 'stocks';?>/<?php echo isset($currentLang) ? $currentLang: '/';?>"><?php echo isset($profileStocksMenu) ? $profileStocksMenu : 'Stocks'; ?></a>
            </li>
        </ul>
    </div>


	
	
							
<?php							
							
							
if (checkUserSession('start')) {

        ?>
        <br> <h1> <?php echo isset($siteTabProfile) ? $siteTabProfile : 'Profile'; ?></h1>
        <br>
        <?php
        $startUserIDstr = strpos($_SESSION['start'], md5($_SERVER['HTTP_USER_AGENT'] + date("z")));
        if ($startUserIDstr > 0) {

            $UserID = substr($_SESSION['start'], 0, $startUserIDstr);
            $UserPassw = substr($_SESSION['start'], (strlen($UserID) + strlen(md5($_SERVER['HTTP_USER_AGENT'] + date("z")))));
            unset($startUserIDstr);
            $link = dbConnector(compact('dbhost', 'dbname', 'dbuser', 'dbpass', 'dbhostport'));
            if ($link) {
                $select = 'SELECT `UserName`, `UserEmail`, `Active`, `UserPlan` FROM `pli_users` WHERE `UserID`=' . $UserID . ' AND `UserPsw` LIKE \'' . $UserPassw . '\' LIMIT 2';
                if ($result = mysqli_query($link, $select)) {
                    if (mysqli_num_rows($result) == 1) {
                        $user = mysqli_fetch_assoc($result);
                        mysqli_free_result($result);
                        $errMsg = '';

                        ?>					
							
	
							
                            <div class="card-body">
                                <br><h5 class="card-title"><?php echo isset($profileAccountDetail) ? $profileAccountDetail : ''; ?></h5><br>


                                <!-- PARAMETERS -->

                                <div class="card">
                                    <div class="card-body"><br>
                                        <h6 class="card-subtitle mb-2 text-muted"><?php echo isset($profileAccountParams) ? $profileAccountParams : ''; ?></h6>
                                        <br>
                                        <div class="form-group row">
                                            <div class="col col-4">

                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <div class="input-group-addon"><?php echo isset($profileAccountId) ? $profileAccountId : 'Card ID:'; ?></div>
                                                    <input type="text" class="form-control" id="user-account-id"
                                                           readonly value="<?php echo $UserID; ?>">
                                                </div>
                                            </div>

                                            <div class="col">

                                                <div class="input-group">
										<span class="input-group-addon">
											<input <?php echo ($user['Active'] >= 1) ? 'checked' : ''; ?>
                                                    type="checkbox" aria-label="Check to activate your account"
                                                    id="accountactivechk">
										</span>
                                                    <input disabled
                                                           value="<?php echo isset($siteSelectorAccountActive) ? $siteSelectorAccountActive : 'Active'; ?>"
                                                           type="text" id="accountactivelbl"
                                                           aria-label="Check to activate your account"
                                                           class="form-control <?php echo ($user['Active'] < 1) ? 'btn-danger' : ''; ?> ">
                                                </div>

                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col">
                                                <h6 class="card-subtitle mb-2 text-muted"><?php echo isset($profileAccountPlan) ? $profileAccountPlan : ''; ?></h6>
                                                <select class="form-control" id="planSelect" disabled>
                                                    <option><?php echo isset($profileAccountFree) ? $profileAccountFree : 'Free'; ?></option>
                                                    <option>Платный</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <br>
                                <!-- USERs DATA -->
                                <div class="card">
                                    <div class="card-body"><br>
                                        <h6 class="card-subtitle mb-2 text-muted"><?php echo isset($profileAccountLogins) ? $profileAccountLogins : ''; ?></h6>
                                        <br>

                                        <div class="form-group row">
                                            <label for="user-text-input" class="col-2 col-form-label"><?php echo isset($profileAccountName) ? $profileAccountName : 'Name'; ?></label>
                                            <div class="col-10">
                                                <input class="form-control" type="text"
                                                       value="<?php echo $user['UserName']; ?>" id="user-text-input">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="user-email-input"
                                                   class="col-2 col-form-label"><?php echo isset($siteLoginNameLbl) ? $siteLoginNameLbl : 'E-mail'; ?></label>
                                            <div class="col-10">
                                                <input required class="form-control" type="email"
                                                       value="<?php echo $user['UserEmail']; ?>" id="user-email-input">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="user-password-input"
                                                   class="col-2 col-form-label"><?php echo isset($siteLoginPasswLbl) ? $siteLoginPasswLbl : 'Password'; ?></label>
                                            <div class="col-10">
                                                <input required class="form-control" type="password"
                                                       value="<?php echo $UserPassw; ?>" id="user-password-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <br><a href="" data-toggle="modal" class="btn btn-primary"
                                       id="save-profile"><?php echo isset($siteSave) ? $siteSave : 'Save'; ?></a>
                            </div> 

                       <?php
                    }
                }
                mysqli_close($link);
            }
        }
        
    }

    
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
                            <div class="form-group">
                                <label for="password"
                                       class="h4"><?php echo isset($profileConfirmLbl) ? $profileConfirmLbl : ''; ?></label>
                                <input type="password" class="form-control" id="conf-password"
                                       placeholder="<?php echo isset($siteRegisterPasswPlace) ? $siteRegisterPasswPlace : ''; ?>"
                                       required
                                       data-error="<?php echo isset($siteRegisterPasswErr) ? $siteRegisterPasswErr : ''; ?>">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                        <input type="hidden" id="uri1" value="<?php echo $currentAction; ?>">
                        <input type="hidden" id="uri2" value="<?php echo $currentLang; ?>">
                        <button type="submit" id="conf-form-submit"
                                class="btn btn-success btn-lg pull-right "><?php echo isset($profileConfirmBtn) ? $profileConfirmBtn : 'Confirm'; ?></button>
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

</div>
    <?php
	$content = ob_get_clean();
}

?>






<?php 


if ($errMsg != '') {
    ?>
    <br>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <?php echo isset($profileConnErr) ? $profileConnErr : 'Error'; ?>
        </div>
    </div>
    <br>
    <?php
}
require 'baseTemplate.php';
?>

