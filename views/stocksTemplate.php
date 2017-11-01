
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


	<br> <h1> <?php echo isset($siteTabWarehouse) ? $siteTabWarehouse : 'Stocks'; ?></h1>
	<br>
<?php
	$userParams = array();
	$userParams = getUserParams();
	
	var_dump ($userParams);
	$errMsg = isset($profileConnErr) ? $profileConnErr : 'Error';
	if (checkUserSession('start')) {
		$errMsg = '';
?>		
		
		<div class="card">
           <div class="card-block"><br>
              <h6 class="card-subtitle mb-2 text-muted"><?php echo isset($pr) ? $pr : 'СКлад'; ?></h6>
                                        <br>
			<div class="form-group row">
               <label for="user-stock-name" class="col-2 col-form-label"><?php echo isset($stockName) ? $stockName : 'Name'; ?></label>
               <div class="col-10">
                  <input class="form-control" type="text" value="<?php echo $user['UserName']; ?>" id="user-stock-name">
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
    <?php $content = ob_get_clean();} ?>

<?php require 'baseTemplate.php'; ?>


