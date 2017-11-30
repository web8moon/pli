<?php if (!isset($content)) {
    ob_start();

    
	$userID = checkUserSession('start');
    $userParams = getUserParams();
    $queqryUrl = parseQueryUrl(str_replace("q=", "", trim($_SERVER['QUERY_STRING'])));

    if (isset($queqryUrl[2]) && $queqryUrl[2] > 0) {
		if ($queqryUrl[2] == 1) $queqryUrl[2] = 0;
    } else {
		$queqryUrl[2] = 0;
    }
	$defItemsPerPage = 20;
	if ($queqryUrl[2] == 0 || $queqryUrl[2] == 1) 
		$startPos = 0;
	else 
		$startPos = ($queqryUrl[2] - 1) * $defItemsPerPage;

	$parts = getStockParts($userParams['Stock'][0]['ID'], $startPos, $defItemsPerPage);
// @TODO Check for $parts['NumbersOfRowsInSelect']

	$maxPage = ceil($parts['NumbersOfRowsInSelect']/$defItemsPerPage);
	
	switch ($queqryUrl[2]) {
		case 0:
		case 1:
			$disabled0 = 'disabled';
			$disabled1 = 'disabled';
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
			$disabled3 = 'disabled';
			$disabled4 = 'disabled';
			$page1 = $maxPage - 2;
			$page2 = $maxPage - 1;
			$page3 = $maxPage;
			break;
		case ($maxPage  <= 1):
			$disabled0 = 'disabled';
			$disabled1 = 'disabled';
			$disabled2 = 'disabled';
			$disabled3 = 'disabled';
			$disabled4 = 'disabled';
			$page1 = 1;
			$page2 = 2;
			$page3 = 3;
			break;
		default:
			$disabled0 = '';
			$disabled1 = '';
			$disabled2 = 'disabled';
			$disabled3 = '';
			$disabled4 = '';
			$page1 = $queqryUrl[2] - 1;
			$page2 = $queqryUrl[2];
			$page3 = $queqryUrl[2] + 1;
			break;		
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
                            <button type="button" class="btn btn-outline-primary" id="add-phone-number"><?php echo isset($qq) ? $stockPhoneAdd : 'Update'; ?>
                                <span style="display:none;" class="badge badge-warning" id="add-phone-number-error"><?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
                                </span>
                            </button>
                            <?php
                        }
                        ?>

                        <button type="button" class="btn btn-outline-primary"
                                id="add-phone-number"><?php echo isset($qq) ? $stockPhoneAdd : 'Add'; ?>
                            <span style="display:none;" class="badge badge-warning"
                                  id="add-phone-number-error"><?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
            </span>
                        </button>
                        <button type="button" class="btn btn-outline-primary"
                                id="add-phone-number"><?php echo isset($qq) ? $stockPhoneAdd : 'Import'; ?>
                            <span style="display:none;" class="badge badge-warning"
                                  id="add-phone-number-error"><?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
            </span>
                        </button>
                        <?php
                        if ($parts['NumbersOfRowsInSelect'] > 0) {
                            ?>
                            <button type="button" class="btn btn-outline-primary"
                                    id="add-phone-number"><?php echo isset($qq) ? $stockPhoneAdd : 'Export'; ?>
                                <span style="display:none;" class="badge badge-warning"
                                      id="add-phone-number-error"><?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
            </span>
                            </button>
                            <button type="button" class="btn btn-outline-primary"
                                    id="add-phone-number"><?php echo isset($qq) ? $stockPhoneAdd : 'Erase'; ?>
                                <span style="display:none;" class="badge badge-warning"
                                      id="add-phone-number-error"><?php echo isset($siteErrorLbl) ? $siteErrorLbl : 'Error'; ?>
            </span>
                            </button>
                            <?php
                        }
                        ?>

                    </div>
                    <?php
                    if ($parts['NumbersOfRowsInSelect'] > 0) {
                        ?>
                        <div class="input-group">
                            <input type="text" class="form-control" id="qsearch"
                                   placeholder="<?php echo isset($stockPartsQsearch) ? $stockPartsQsearch : 'Quick Search'; ?>">
                            <span class="input-group-btn">
        <button class="btn btn-outline-primary" id="go" type="submit">Go</button>
      </span>
                        </div>
                        <?php
                    }
                    ?>
                </div>
<br>

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
										echo '<tr>';
										echo '<td>' . $parts[$i]['Active'] . '</td>';
										echo '<td>' . $parts[$i]['IsUsed'] . '</td>';
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
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?php echo $disabled0; ?>">
                                <a class="page-link" title=" 1 " href="/<?php echo $currentAction . '/' . $currentLang; ?>">&laquo;</a>
                            </li>
                            <li class="page-item <?php echo $disabled1; ?>">
									<a class="page-link" href="/<?php echo $currentAction . '/' . $currentLang . '/' . $page1; ?>"><?php echo $page1; ?></a>
								</li>
                            <li class="page-item <?php echo $disabled2; ?>">
									<a class="page-link" href="/<?php echo $currentAction . '/' . $currentLang . '/' . $page2; ?>"><?php echo $page2; ?></a>
								</li>
                            <li class="page-item <?php echo $disabled3; ?>">
									<a class="page-link" href="/<?php echo $currentAction . '/' . $currentLang . '/' . $page3; ?>"><?php echo $page3; ?></a>
								</li>
                            <li class="page-item <?php echo $disabled4; ?>">
                                <a class="page-link" title=" <?php echo $maxPage; ?> " href="/<?php echo $currentAction . '/' . $currentLang . '/' . $maxPage; ?>">&raquo;</a>
                            </li>
                        </ul>
                    </nav>
                    <?php
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


    <?php $content = ob_get_clean();
} ?>

<?php require 'baseTemplate.php'; ?>
