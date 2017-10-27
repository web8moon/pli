<?php if (!isset($content)) {
    ob_start(); ?>
    <h1><?php echo isset($siteSearchingLbl) ? $siteSearchingLbl : 'Searching'; ?></h1>

    <div class="input-group">
        <input type="text" class="form-control form-control-lg" id="search" autofocus placeholder="Search for...">
        <span class="input-group-btn">
        <button class="btn btn-primary btn-lg" id="go" type="submit">Go!</button>
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
<br>
    <?php
    if (!in_array($currentAction, $serviceLinks) && !in_array($currentAction, $pageLinks) && $currentAction != $defaultAction) {
        ?>
        <div class="card">
            <div class="card-block">
                <h4 class="card-title">Поиск номера <?php echo $currentAction; ?></h4>
                <h6 class="card-subtitle mb-2 text-muted">Прямой поиск</h6>

                <p class="card-text">SearchResults</p>
                <br>
<?php
				$a= crossSearchList($currentAction, compact('dbhost', 'dbname', 'dbuser', 'dbpass', 'dbhostport'));
				var_dump $a;
?>

            </div>
        </div>

        <?php
    }

    ?>

    <?php $content = ob_get_clean();
} ?>

<?php require 'baseTemplate.php'; ?>


