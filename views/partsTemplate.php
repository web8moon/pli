<?php if (!isset($content)) {
    ob_start();

    
	$userID = checkUserSession('start');
    $userParams = getUserParams();
    $queqryUrl = $GLOBALS['QueqryUrl'];
	$defItemsPerPage = 20;

    if (isset($queqryUrl[2]) && $queqryUrl[2] > 0) {
		if ($queqryUrl[2] == 1) $queqryUrl[2] = 0;
    } else {
		$queqryUrl[2] = 0;
    }
	if ($queqryUrl[2] == 0 || $queqryUrl[2] == 1) 
		$startPos = 0;
	else 
		$startPos = ($queqryUrl[2] - 1) * $defItemsPerPage;
	if (isset($_POST['dismiss'])) {
	    unset($_POST['qsearch'], $_SESSION['qsearch']);
    }
    if (isset($_POST['qsearch']) && strlen(trim($_POST['qsearch'])) > 0 && isset($_POST['go'])) {
        $_SESSION['qsearch'] = $_POST['qsearch'];
        $startPos = 0;
    } else {
        $clause = '';
    }
    if (isset($_SESSION['qsearch']))
        $clause = $_SESSION['qsearch'];
	
    $parts = getStockParts($userParams['Stock'][0]['ID'], $startPos, $defItemsPerPage, $clause);
	$maxPage = ceil($parts['NumbersOfRowsInSelect'] / $defItemsPerPage);

	switch ($queqryUrl[2]) {
		case 0:
		case 1:
			$disabled0 = ' disabled';
			$disabled1 = ' disabled';
			$disabled2 = '';
			$disabled3 = '';
			$disabled4 = '';
			$page1 = 1;
			$page2 = 2;
			$page3 = 3;
			break;
		case ($queqryUrl[2] >= $maxPage):
			$disabled0 = '';
			$disabled1 = '';
			$disabled2 = '';
			$disabled3 = ' disabled';
			$disabled4 = ' disabled';
			$page1 = $maxPage - 2;
			$page2 = $maxPage - 1;
			$page3 = $maxPage;
			break;
		case ($maxPage <= 1):
			$disabled0 = ' disabled';
			$disabled1 = ' disabled';
			$disabled2 = ' disabled';
			$disabled3 = ' disabled';
			$disabled4 = ' disabled';
			$page1 = 1;
			$page2 = 2;
			$page3 = 3;
			break;
		default:
			$disabled0 = '';
			$disabled1 = '';
			$disabled2 = ' disabled';
			$disabled3 = '';
			$disabled4 = '';
			$page1 = $queqryUrl[2] - 1;
			$page2 = $queqryUrl[2];
			$page3 = $queqryUrl[2] + 1;
			break;		
	}
    if ($parts['NumbersOfRowsInSelect'] <= $defItemsPerPage) {
        $disabled0 = ' disabled';
        $disabled1 = ' disabled';
        $disabled2 = ' disabled';
        $disabled3 = ' disabled';
        $disabled4 = ' disabled';
        $page1 = 1;
        $page2 = 2;
        $page3 = 3;
    }

    ?>

    <br>
    <div class="card text-center">

        <!-- UPPER TABS -->
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link"
                       href="/<?php echo isset($pageLinks['profile']) ? $pageLinks['profile'] : 'welcome'; ?>/<?php echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($profileAccountMenu) ? $profileAccountMenu : 'Account'; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"
                       href="/<?php echo isset($pageLinks['stocks']) ? $pageLinks['stocks'] : 'welcome'; ?>/<?php echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($profileStocksMenu) ? $profileStocksMenu : 'Stocks'; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active"
                       href="/<?php echo isset($pageLinks['parts']) ? $pageLinks['parts'] : 'welcome'; ?>/<?php echo isset($currentLang) ? $currentLang : '/'; ?>"><?php echo isset($profilePartsMenu) ? $profilePartsMenu : 'Parts'; ?></a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <?php
            if (isset($parts['NumbersOfRowsInSelect'])) {
                ?>


                <div class="container">
                    <div class="form-group row justify-content-center">
                        <?php
                        if ($parts['NumbersOfRowsInSelect'] > 0) {
                            ?>
                            <button type="button" class="btn btn-outline-primary" id="update-stock-date">
									<?php echo isset($stockUpdateData) ? $stockUpdateData : 'Update'; ?>
                                <span style="display:none;" class="badge badge-warning" id="add-phone-number-error">
										<?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
                                </span>
                            </button>
								&nbsp;
                            <?php
                        }
                        ?>

                        <button type="button" class="btn btn-outline-primary" id="add-phone-number">
								<?php echo isset($qq) ? $stockPhoneAdd : 'Add'; ?>
                            <span style="display:none;" class="badge badge-warning">
									<?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
								</span>
                        </button>
						&nbsp;
                        <button type="button" class="btn btn-outline-primary" id="import">
                                <?php echo isset($qq) ? $stockPhoneAdd : 'Import'; ?>
                            <span style="display:none;" class="badge badge-warning">
									<?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
								</span>
                        </button>
                        <?php
                        if ($parts['NumbersOfRowsInSelect'] > 0) {
                            ?>
								&nbsp;
                            <button type="button" class="btn btn-outline-primary" id="add-phone-number">
                                    <?php echo isset($qq) ? $stockPhoneAdd : 'Export'; ?>
									<span style="display:none;" class="badge badge-warning">
										<?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
									</span>
                            </button>
								&nbsp;
                            <button type="button" class="btn btn-outline-primary" id="eraseparts">
                                <?php echo isset($Erase) ? $Erase : 'Erase'; ?>
                                <span class="badge badge-warning">
                                      <?php echo $parts['NumbersOfRowsInSelect']; ?>
                                </span>
                            </button>
							<input type="hidden" id="qsearchclause" value="<?php echo $clause; ?>">
							<input type="hidden" id="stn" value="<?php echo $userParams['Stock'][0]['ID']; ?>">
							<input type="hidden" id="stockPartsConfirmErase" value="<?php echo $stockPartsConfirmErase; ?>">
                         <?php
                        }
                        ?>

                    </div>
                    <?php
                    if ($parts['NumbersOfRowsInSelect'] > 0 || isset($_SESSION['qsearch'])) {
                        ?>
                    <form method="POST" action="<?php echo '/' . $pageLinks['parts'] . '/' . $currentLang; ?>">
                        <div class="input-group">
                            <?php
                            if (isset($_SESSION['qsearch'])) {
                            ?>
                            <button type="submit" class="close" name="dismiss">
                                <span aria-hidden="true">&times;</span>
                            </button>
                         <?php } ?>
                            <input type="text" class="form-control" name="qsearch" maxlength="17"
                                   placeholder="<?php
                                   if (isset($_SESSION['qsearch']))
                                       echo $_SESSION['qsearch'];
                                   else
                                       echo isset($stockPartsQsearch) ? $stockPartsQsearch : 'Quick Search';
                                   ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-outline-primary" name="go" type="submit">Go
                                <?php if (isset($_POST['qsearch']) || isset($_SESSION['qsearch'])) { ?>
                                    <span class="badge badge-info">
                                      <?php echo $parts['NumbersOfRowsInSelect']; ?></span>
                                    <?php } ?>
                                </button>
                            </span>
                        </div>
                    </form>
                        <?php
                    }
                    ?>
                </div>
<p class="card-text"><small class="text-muted" id="updateDat">
	<?php echo isset($lastUpdatedLbl) ? $lastUpdatedLbl : ''; 
		echo ' ' . date($DataFormat, strtotime($userParams['Stock'][0]['DateModify']));
	?>
</small></p>
                <?php
                if ($parts['NumbersOfRowsInSelect'] > 0) {
	                 ?>
                    <table class="table table-responsive table-hover">
                        <thead>
                        <tr>
                            <th>Active</th>
                            <th>Used</th>
                            <th>Brand</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Quan</th>
                            <th>Price</th>
                            <th>Photo</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
								for ($i = 0; $i < $defItemsPerPage; $i++) {
									if (isset($parts[$i]['PartID'])) {
										$active = $used = '';
										if ($parts[$i]['Active'] == 1)
											$active = 'checked';
										if ($parts[$i]['IsUsed'] == 1)
											$used = 'checked';
										echo '<tr>';
										echo '<td><input type="checkbox" class="form-check-input" descr="active" nr="' . $parts[$i]['Code'] . '" ' . $active . ' id="active' . $parts[$i]['PartID'] . '"></td>';
										echo '<td><input type="checkbox" class="form-check-input" descr="used" nr="' . $parts[$i]['Code'] . '" ' . $used .  ' id="used' . $parts[$i]['PartID'] . '"></td>';
										echo '<td>' . $parts[$i]['BRA_BRAND'] . '</td>';
										echo '<td>' . $parts[$i]['Code'] . '</td>';
										echo '<td>' . $parts[$i]['Name'] . '</td>';
										echo '<td>' . $parts[$i]['Quantity'] . '</td>';
										echo '<td>' . $parts[$i]['Price'] . '</td>';
										echo '<td>' . $parts[$i]['Photo'] . '</td>';
										echo '</tr>';
									} else {
										break;
									}
								}
                        ?>
                        </tbody>
                    </table>
                    <?php
                    if ($parts['NumbersOfRowsInSelect'] >= $defItemsPerPage) {
                        ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                <li class="page-item <?php echo $disabled0; ?>">
                                    <a class="page-link" title=" 1 "
											href="/<?php echo $currentAction . '/' . $currentLang; ?>">&laquo;</a>
                                </li>
                                <li class="page-item <?php echo $disabled1; ?>">
                                    <a class="page-link"
                                       href="/<?php echo $currentAction . '/' . $currentLang . '/' . $page1; ?>"><?php echo $page1; ?></a>
                                </li>
                                <li class="page-item <?php echo $disabled2; ?>">
                                    <a class="page-link"
                                       href="/<?php echo $currentAction . '/' . $currentLang . '/' . $page2; ?>"><?php echo $page2; ?></a>
                                </li>
                                <li class="page-item <?php echo $disabled3; ?>">
                                    <a class="page-link"
                                       href="/<?php echo $currentAction . '/' . $currentLang . '/' . $page3; ?>"><?php echo $page3; ?></a>
                                </li>
                                <li class="page-item <?php echo $disabled4; ?>">
                                    <a class="page-link" title=" <?php echo $maxPage; ?> "
                                       href="/<?php echo $currentAction . '/' . $currentLang . '/' . $maxPage; ?>">&raquo;</a>
                                </li>
                            </ul>
                        </nav>
                     <?php
                    }
                } else {
                    ?>
                    <br>
                    <div class="container">
                        <div class="alert alert-warning" role="alert">
                            <?php echo isset($stockPartsEmptyStock) ? $stockPartsEmptyStock : 'Empty'; ?>
                        </div>
                    </div>
                    <br>
                    <?php
                }

            } else {
				$_SESSION = array();
				session_destroy();
                ?>
                <br>
                <div class="container">
                    <div class="alert alert-danger" role="alert">
                        <?php echo isset($siteRegisterWrongErr) ? $siteRegisterWrongErr : 'Error'; ?>
                    </div>
                </div>
                <br>
                <?php
            }
            ?>
        </div>
    </div>

	<!-- PASWWORD CONFIRM -->
    <?php if (isset($_SESSION['start'])) {
        ?>
        <div id="PconfirmModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                        </button>
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
                            <button type="submit" id="conf-form-submit" class="btn btn-success btn-lg pull-right ">
                                <?php echo isset($profileConfirmBtn) ? $profileConfirmBtn : 'Confirm'; ?>
                            </button>
                            </form>

                            <!-- <div id="msgSubmit" class="h3 text-center hidden"></div> -->
                            <div class="clearfix"></div>
                        

                    </div>
                    <!-- Футер модального окна -->
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">
								<?php echo isset($siteLoginCloseBtn) ? $siteLoginCloseBtn : 'Close'; ?>
							</button>
                    </div>
                </div>
            </div>
        </div>

		
		
		
		<!-- EXCEL Load Modal -->
        <div id="LoadModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                        </button>
                        <h4 class="modal-title"><?php echo isset($siteLoginTitle) ? $siteLoginTitle : ''; ?></h4>

                    </div>
					<div class="modal-header">
						<button type="button" class="btn btn-info btn-sm">1. <small>Select file</small></button>
						<button type="button" class="btn btn-outline-secondary btn-sm">2. <small>Point the cells</small></button>
						<button type="button" class="btn btn-outline-secondary btn-sm">Upload price</button>
					</div>					
                    <!-- Основное содержимое модального окна -->
                    <div class="modal-body">

					
					
					
<form id="LoadForm" enctype="multipart/form-data" method="POST">
  <div class="form-group">
    <label for="fileUpload">Example file input</label>
    <input type="file" class="form-control-file" id="fileUpload">
	<button type="submit" id="LoadConfirm" class="btn btn-primary btn-lg pull-right ">
       <?php echo isset($profileConfirmBtn) ? $profileConfirmBtn : 'Confirm'; ?>
    </button>
  <div class="help-block with-errors"></div>
  </div>
<input type="hidden" id="uri1" value="<?php echo $currentAction; ?>">
<input type="hidden" id="uri2" value="<?php echo $currentLang; ?>">
  <div id="msgSubmit" class="h3 text-center hidden"></div>
  <div class="clearfix"></div>
</form>
					
					
					
					

                    </div>
                    <!-- Футер модального окна -->
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">
								<?php echo isset($siteLoginCloseBtn) ? $siteLoginCloseBtn : 'Close'; ?>
							</button>
                    </div>
                </div>
            </div>
        </div>
        <?php

		
		
		
    }
	

    $content = ob_get_clean();
} 

require 'baseTemplate.php';
?>
