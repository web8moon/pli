<?php if (!isset($content)) {
    ob_start(); ?>
    <br><h1><?php echo isset($siteSearchingLbl) ? $siteSearchingLbl : 'Searching'; ?></h1>

    <div class="input-group">
        <input type="text" class="form-control form-control-lg" id="search" autofocus placeholder="<?php echo isset($searchFor) ? $searchFor : 'Search for...'; ?>">
        <span class="input-group-btn">
        <button class="btn btn-primary btn-lg" id="go" type="submit" >Go!</button>
      </span>
    </div>
    <input type="hidden" id="uri1" value="<?php echo $currentAction; ?>">
    <input type="hidden" id="uri2" value="<?php echo $currentLang; ?>">
    <br>
    <div class="container" id="errorMsg" style="display: none;">
        <div class="alert alert-danger" role="alert">
            <div class="h4 text-center hidden"><?php echo isset($searchLengthErr) ? $searchLengthErr : 'Short'; ?></div>
        </div>
    </div>
    <div class="progress" >
        <div id="progress" class="progress-bar progress-bar-striped" role="progressbar" style="width: 2%; display: none;" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
<br>
    <?php
    if (!in_array($currentAction, $serviceLinks) && !in_array($currentAction, $pageLinks) && $currentAction != $defaultAction) {
		$SearchNumber = strtoupper(CheckUs($currentAction));
        ?>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Поиск номера <?php echo $SearchNumber; ?></h4>
                <h6 class="card-subtitle mb-2 text-muted">Прямой поиск</h6>

                <p class="card-text">SearchResults</p>
                <br>
<?php
				$t = TDcrossSearchList($SearchNumber, compact('dbhost', 'dbname', 'dbuser', 'dbpass', 'dbhostport'));
				
				
				if($t) {
					$p = priceSearchList($t['cause'], compact('dbhost', 'dbname', 'dbuser', 'dbpass', 'dbhostport'));
					if($p) {
						var_dump ($p);
					} else {
					    unset ($t['cause']);
                        echo $siteSearchEmpty;
					    ?>

                        <p>
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#crossCollapseShow" aria-expanded="false" aria-controls="crossCollapseShow">
                            <?php echo isset($siteSearchCrossesShow) ? $siteSearchCrossesShow : 'Show'; ?>
                        </button>
                        </p>
                        <div class="collapse" id="crossCollapseShow">
                        <table class="table table-responsive">
<!--
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
-->
                            <tbody>
                                <?php
                                foreach ($t as $v) {
                                    echo '<tr><td>' . $v['BRAND'] . '</td><td>' . $v['NUMBER'] . '</td></tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                        </div>

                <?php
						//var_dump ($t);
					}
				} else {

				}
				
?>

            </div>
        </div>

        <?php
    }

    ?>

    <?php $content = ob_get_clean();
} ?>

<?php require 'baseTemplate.php'; ?>


