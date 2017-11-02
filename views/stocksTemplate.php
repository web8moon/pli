
<?php if(!isset($content)){ ob_start(); ?>

<div class="card text-center">


    <!-- UPPER TABS -->
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link" href="/<?php echo isset($pageLinks['profile']) ? $pageLinks['profile'] : 'profile';?>/<?php echo isset($currentLang) ? $currentLang: '/';?>"><?php echo isset($profileAccountMenu) ? $profileAccountMenu : 'Account'; ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/<?php echo isset($pageLinks['stocks']) ? $pageLinks['stocks'] : 'stocks';?>/<?php echo isset($currentLang) ? $currentLang: '/';?>"><?php echo isset($profileStocksMenu) ? $profileStocksMenu : 'Stocks'; ?></a>
            </li>
        </ul>
    </div>

<div class="card-body">
	<h1> <?php echo isset($siteTabWarehouse) ? $siteTabWarehouse : 'Stocks'; ?></h1>
	<br>
<?php
	$userParams = array();
	$userParams = getUserParams();
	
	// var_dump ($userParams);
	if ($userParams['stokNumbers'] > 1 AND $userParams['User']['UserPlan'] == 1) {
		$userParams['stokNumbers'] = 1;
	?>
	<br>
    <div class="container">
        <div class="alert alert-warning" role="alert">
            <?php echo isset($stockMultiError) ? $stockMultiError : 'Error'; ?>
        </div>
    </div>
    <br>
	<?php
	}
	if ($userParams['User']['Active'] != 1) {
	?>
	<br>
    <div class="container">
        <div class="alert alert-warning" role="alert">
            <?php echo isset($profileActiveWarning) ? $profileActiveWarning : 'Warning'; ?>
        </div>
    </div>
    <br>
	<?php
	}
	$errMsg = isset($profileConnErr) ? $profileConnErr : 'Error';
	if (checkUserSession('start')) {
		$errMsg = '';
?>		
		
		<div class="card">
           <div class="card-body">
              <h6 class="card-subtitle mb-2 text-muted"><?php echo isset($pr) ? $pr : 'СКлад'; ?></h6>
			<div class="form-group row">
               <label for="user-stock-name" ><?php echo isset($stockName) ? $stockName : 'Name'; ?></label>
              <div class="col-4">
                  <input class="form-control" type="text" value="<?php echo $userParams[$userParams['stokNumbers']]['StockName']; ?>" id="user-stock-name">
              </div>
           </div>
			
			
		</div>
		</div>
		
<?php
	}
	
	if ($errMsg != '') {
    ?>
    <br>
    <div class="container">
        <div class="alert alert-danger" role="alert">
            <?php echo $errMsg; ?>
        </div>
    </div>
    <br>
    <?php
}

	
?>	
</div>
</div>
    <?php $content = ob_get_clean();} ?>

<?php require 'baseTemplate.php'; ?>


